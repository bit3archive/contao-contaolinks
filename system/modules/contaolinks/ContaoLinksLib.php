<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Tristan Lins 2011
 * @author     Tristan Lins <http://www.infinitysoft.de>
 * @package    Plugins
 * @license    LGPL
 * @filesource
 */


/**
 * Class ContaoLinksLib
 * 
 * 
 * @copyright  Tristan Lins 2011
 * @author     Tristan Lins <http://www.infinitysoft.de>
 * @package    Controller
 */
class ContaoLinksLib extends Backend
{

	/**
	 * Initialize the controller
	 * 
	 * 1. Import user
	 * 2. Call parent constructor
	 * 3. Authenticate user
	 * DO NOT CHANGE THIS ORDER!
	 */
	public function __construct()
	{
		$this->import('BackendUser', 'User');
		parent::__construct();
		$this->User->authenticate();
		$this->loadLanguageFile('contaolinks');
	}


	public function createPageList()
	{
		$intPid = $this->Input->get('pid');
		if (!$intPid)
		{
			$intPid = '0';
		}
		$arrOpen = array();
		$intSelected = $this->Input->get('selectedPage');
		if ($intSelected > 0)
		{
			$arrOpen = $this->calculateSelectedTrail($intSelected);
		}

		return json_encode($this->getPageList($intPid, $intSelected, $arrOpen));
	}


	public function getPageList($intPid, $intSelected, $arrOpen)
	{
		if ($this->User->isAdmin)
		{
			$objPage = $this->Database->prepare("SELECT * FROM tl_page WHERE pid=? AND type IN ('regular','forward','redirect','root') ORDER BY sorting")->execute($intPid);
		}
		else
		{
			// TODO
		}

		$arrPages = array();
		while ($objPage->next())
		{
			$arrPage = array
			(
				'property' => array
				(
					'pageId' => $objPage->id,
					'name' => $objPage->title,
					'loadable' => $this->hasPageChilds($objPage->id)
				),
				'type' => $this->getPageType($objPage),
				'state' => array()
			);
			if ($objPage->id == $intSelected)
			{
				$arrPage['state']['selected'] = true;
			}
			else if (in_array($objPage->id, $arrOpen))
			{
				$arrPage['children'] = $this->getPageList($objPage->id, $intSelected, $arrOpen);
				$arrPage['state']['open'] = true;
			}
			$arrPages[] = $arrPage;
		}
		return $arrPages;
	}


	public function calculateSelectedTrail($intSelected)
	{
		$arrTrail = array();
		
		$intPid = $intSelected;
		do
		{
			$objPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=?")->execute($intPid);
			if ($objPage->next())
			{
				$arrTrail[] = $objPage->id;
				$intPid = $objPage->pid;
			}
			else
			{
				break;
			}
		}
		while ($intPid > 0);

		return array_reverse($arrTrail);
	}


	protected function hasPageChilds($intId)
	{
		$objPage = $this->Database->prepare("SELECT COUNT(*) as c FROM tl_page WHERE pid=? AND type IN ('regular','forward','redirect','root')")->execute($intId);
		return $objPage->c > 0;
	}


	protected function getPageType($objPage)
	{
		$sub = 0;

		// Page not published or not active
		if ((!$objPage->published || $objPage->start && $objPage->start > time() || $objPage->stop && $objPage->stop < time()))
		{
			$sub += 1;
		}

		// Page hidden from menu
		if ($objPage->hide && !in_array($objPage->type, array('redirect', 'forward', 'root', 'error_403', 'error_404')))
		{
			$sub += 2;
		}

		// Page protected
		if ($objPage->protected && !in_array($objPage->type, array('root', 'error_403', 'error_404')))
		{
			$sub += 4;
		}

		// Get image name
		return $objPage->type.'_'.$sub;
	}


	/**
	 * Get all allowed images and return them as string
	 * @return string
	 */
	public function createImageList()
	{
		if ($this->User->isAdmin)
		{
			return $this->doCreateImageList($GLOBALS['TL_CONFIG']['uploadPath']);
		}

		$return = '';
		$processed = array();

		// Limit nodes to the filemounts of the user
		foreach ($this->eliminateNestedPaths($this->User->filemounts) as $path)
		{
			if (in_array($path, $processed))
			{
				continue;
			}

			$processed[] = $path;
			$return .= $this->doCreateImageList($path);
		}

		return $return;
	}


	/**
	 * Recursively get all allowed images and return them as string
	 * @param integer
	 * @param integer
	 * @return string
	 */
	public function doCreateImageList($strFolder=null, $level=-1)
	{
		$arrPages = scan(TL_ROOT . '/' . $strFolder);

		// Empty folder
		if (count($arrPages) < 1)
		{
			return '';
		}

		// Protected folder
		if (array_search('.htaccess', $arrPages) !== false)
		{
			return '';
		}

		++$level;
		$strFolders = '';
		$strFiles = '';

		// Recursively list all images
		foreach ($arrPages as $strFile)
		{
			if (substr($strFile, 0, 1) == '.')
			{
				continue;
			}

			// Folders
			if (is_dir(TL_ROOT . '/' . $strFolder . '/' . $strFile))
			{
				$strFolders .= $this->doCreateImageList($strFolder . '/' . $strFile, $level);
			}

			// Files
			elseif (preg_match('/\.gif$|\.jpg$|\.jpeg$|\.png$/i', $strFile))
			{
				$strFiles .= sprintf('["%s", "%s"]', specialchars($strFolder . '/' . $strFile), $strFolder . '/' . $strFile) . ",\n";
			}
		}

		return $strFiles . $strFolders;
	}


	/**
	 * Get all tiny_ templates and return them as string
	 * @return string
	 */
	public function createTemplateList()
	{
		$dir = TL_ROOT . '/' . $GLOBALS['TL_CONFIG']['uploadPath'] . '/tiny_templates';

		if (!is_dir($dir))
		{
			return '';
		}

		$strFiles = '';
		$arrTemplates = scan($dir);

		foreach ($arrTemplates as $strFile)
		{
			if (strncmp('.', $strFile, 1) !== 0 && is_file($dir . '/' . $strFile))
			{
				$strFiles .= sprintf('["%s", "' . TL_PATH . '/' . $GLOBALS['TL_CONFIG']['uploadPath'] . '/tiny_templates/%s", "' . $GLOBALS['TL_CONFIG']['uploadPath'] . '/tiny_templates/%s"]', $strFile, $strFile, $strFile) . ",\n";
			}
		}

		return $strFiles;
	}
}

?>