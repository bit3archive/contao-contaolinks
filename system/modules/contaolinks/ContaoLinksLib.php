<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/* include COPYRIGHT */


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


	/**
	 * Get the url of a theme icon.
	 * 
	 * @param string $strIcon
	 * return string
	 */
	public function getIconSrc($strIcon)
	{
		return sprintf('system/themes/%s/images/%s.gif', $this->getTheme(), $strIcon);
	}
	
	
	public function extendIconSrc($strIcon)
	{
		return sprintf('system/themes/%s/images/%s', $this->getTheme(), $strIcon);
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