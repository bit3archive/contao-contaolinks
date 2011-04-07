<?php

#copyright


/**
 * Initialize system
 */
define('TL_MODE', 'FE');
require('../../initialize.php');


/**
 * Class contaolinks
 */
class ContaoPages extends ContaoLinksLib
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Input');
		$this->import('Database');
	}
	
	
	public function run()
	{
		header('Content-Type: application/json');
		
		$intPid = $this->Input->get('pid');
		if (!$intPid)
		{
			$intPid = '0';
		}
		
		// Set opened/closed state
		if ($this->Input->get('state'))
		{
			$session = $this->Session->getData();
			$session['tl_article_tl_page_tree'][$intPid] = $this->Input->get('state') == 'opened' ? 1 : 0;
			$this->Session->setData($session);
			exit;
		}
		
		$arrOpen = array();
		$intSelected = $this->Input->get('selectedPage');
		if ($intSelected > 0)
		{
			$arrOpen = $this->calculateSelectedTrail($intSelected);
		}

		echo json_encode($this->getPageList($intPid, $intSelected, $arrOpen));
	}
	
	
	/**
	 * Get a list of page children.
	 * 
	 * @param int $intPid
	 * @param int $intSelected
	 * @param array $arrOpen
	 * @return
	 */
	public function getPageList($intPid, $intSelected, $arrOpen)
	{
		$session = $this->Session->getData();
		
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
			$strIcon = $this->getPageType($objPage);
			$arrPage = array
			(
				'property' => array
				(
					'pageId' => $objPage->id,
					'name' => $objPage->title,
					'loadable' => $this->hasPageChilds($objPage->id),
					'openIconUrl' => $strIcon,
					'closeIconUrl' => $strIcon
				),
				'type' => 'page'
			);
			if ($objPage->id == $intSelected)
			{
				$arrPage['state']['selected'] = true;
			}
			if (in_array($objPage->id, $arrOpen) || $session['tl_article_tl_page_tree'][$objPage->id])
			{
				$arrPage['children'] = $this->getPageList($objPage->id, $intSelected, $arrOpen);
				$arrPage['state']['open'] = true;
			}
			$arrPages[] = $arrPage;
		}
		return $arrPages;
	}
	
	
	/**
	 * Calculate the page trail of a selected page.
	 * 
	 * @param int $intSelected
	 * @return array
	 */
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


	/**
	 * Check if a page have children.
	 * 
	 * @param int $intId
	 * @return bool
	 */
	protected function hasPageChilds($intId)
	{
		$objPage = $this->Database->prepare("SELECT COUNT(*) as c FROM tl_page WHERE pid=? AND type IN ('regular','forward','redirect','root')")->execute($intId);
		return $objPage->c > 0;
	}


	/**
	 * Get the page type identifier.
	 * 
	 * @param $objPage
	 * @return string
	 */
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
		return $this->getIconSrc($sub>0 ? $objPage->type.'_'.$sub : $objPage->type);
	}
}

$objContaoPages = new ContaoPages();
$objContaoPages->run();

?>