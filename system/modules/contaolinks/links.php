<?php

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
 * @copyright  Tristan Lins 2010
 * @author     Tristan Lins <http://www.infinitysoft.de>
 * @package    Plugins
 * @license    LGPL
 * @filesource
 */


/**
 * Initialize system
 */
define('TL_MODE', 'FE');
require('../../initialize.php');


/**
 * Class contaolinks
 */
class ContaoLinks extends ContaoLinksLib
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Input');
	}
	
	
	public function run()
	{
		/**
		 * Generate page
		 */
		header('Content-Type: text/html; charset=' . $GLOBALS['TL_CONFIG']['characterSet']);
		$this->import('ContaoLinksLib');
		
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<base href="<?php echo $this->Environment->base; ?>"></base>
	<title><?php echo $GLOBALS['TL_LANG']['contaolinks']['title']; ?></title>
	<script type="text/javascript" src="plugins/mootools/mootools-core.js"></script>
	<script type="text/javascript" src="plugins/mootools/mootools-more.js"></script>
	<script type="text/javascript" src="plugins/Mif.Tree/mif.tree.js"></script>
	<script type="text/javascript" src="system/modules/contaolinks/html/contaolinks.js"></script>
	<?php if (isset($_GET['tinymce'])): ?>
	<script type="text/javascript" src="plugins/tinyMCE/tiny_mce_popup.js"></script>
	<script type="text/javascript" src="plugins/tinyMCE/utils/editable_selects.js"></script>
	<script type="text/javascript" src="plugins/tinyMCE/utils/form_utils.js"></script>
	<script type="text/javascript" src="plugins/tinyMCE/utils/validate.js"></script>
	<script type="text/javascript" src="system/modules/contaolinks/html/tinymce.js"></script>
	<?php endif; ?>
	<link type="text/css" rel="stylesheet" href="system/modules/contaolinks/html/contaolinks.css.php" />
	<link type="text/css" rel="stylesheet" href="system/themes/<?php echo $this->getTheme(); ?>/basic.css?<?php echo VERSION; ?>.<?php echo BUILD; ?>" />
	<link type="text/css" rel="stylesheet" href="system/themes/<?php echo $this->getTheme(); ?>/main.css?<?php echo VERSION; ?>.<?php echo BUILD; ?>" />
	<link type="text/css" rel="stylesheet" href="system/themes/<?php echo $this->getTheme(); ?>/be27.css?<?php echo VERSION; ?>.<?php echo BUILD; ?>" />
</head>
<body id="contaolinks">
	<div id="left">
		<div id="tl_navigation">
			<div id="tab_wrapper">
				<h1><?php echo $GLOBALS['TL_LANG']['contaolinks']['link']; ?></h1>
				<ul class="tl_level_1">
					<li class="tl_level_1_group">
						<span><?php echo $GLOBALS['TL_LANG']['contaolinks']['internal']; ?></span>
						<ul class="tl_level_2">
							<li id="page_tab" class="page current"><a class="navigation page" href="javascript:displayTab('page_tab','page_panel');" onmousedown="return false;"><?php echo $GLOBALS['TL_LANG']['contaolinks']['page_legend'][0]; ?></a></li>
							<li id="file_tab" class="file"><a class="navigation files" href="javascript:displayTab('file_tab','file_panel');" onmousedown="return false;"><?php echo $GLOBALS['TL_LANG']['contaolinks']['file_legend'][0]; ?></a></li>
						</ul>
					</li>
					<li class="tl_level_1_group">
						<span><?php echo $GLOBALS['TL_LANG']['contaolinks']['communication']; ?></span>
						<ul class="tl_level_2">
							<li id="email_tab" class="email"><a class="navigation email" href="javascript:displayTab('email_tab','email_panel');" onmousedown="return false;"><?php echo $GLOBALS['TL_LANG']['contaolinks']['email_legend'][0]; ?></a></li>
							<li id="phone_tab" class="phone"><a class="navigation phone" href="javascript:displayTab('phone_tab','phone_panel');" onmousedown="return false;"><?php echo $GLOBALS['TL_LANG']['contaolinks']['phone_legend'][0]; ?></a></li>
						</ul>
					</li>
					<li class="tl_level_1_group">
						<span><?php echo $GLOBALS['TL_LANG']['contaolinks']['external']; ?></span>
						<ul class="tl_level_2">
							<li id="url_tab" class="url"><a class="navigation url" href="javascript:displayTab('url_tab','url_panel');" onmousedown="return false;"><?php echo $GLOBALS['TL_LANG']['contaolinks']['url_legend'][0]; ?></a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	
	<div id="main">
		<form onsubmit="update.delay(1);return false;" action="#" id="form">
			<div id="tl_formbody">
				<div id="panel_wrapper">
					<div id="page_panel" class="panel current">
						<h1 class="main_headline"><?php echo $GLOBALS['TL_LANG']['contaolinks']['page_legend'][1]; ?></h1>
						<div class="tl_formbody_edit">
							<div id="pageTree"></div>
						</div>
					</div>
					<div id="file_panel" class="panel">
						<h1 class="main_headline"><?php echo $GLOBALS['TL_LANG']['contaolinks']['file_legend'][1]; ?></h1>
						<div id="filePreview" style="display:none;"><div id="filePreviewImage"></div></div>
						<div class="tl_formbody_edit">
							<div id="fileTree"></div>
						</div>
					</div>
					<div id="email_panel" class="panel">
						<h1 class="main_headline"><?php echo $GLOBALS['TL_LANG']['contaolinks']['email_legend'][1]; ?></h1>
						<div class="tl_formbody_edit">
							<fieldset class="tl_tbox">
								<div>
									<h3><label for="email"><?php echo $GLOBALS['TL_LANG']['contaolinks']['email'][0]; ?></label></h3>
									<input id="email" name="email" type="text" value="" style="width: 99%" />
									<p class="tl_help tl_tip"><?php echo $GLOBALS['TL_LANG']['contaolinks']['email'][1]; ?></p>
								</div>
							</fieldset>
						</div>
					</div>
					<div id="phone_panel" class="panel">
						<h1 class="main_headline"><?php echo $GLOBALS['TL_LANG']['contaolinks']['phone_legend'][1]; ?></h1>
						<div class="tl_formbody_edit">
							<fieldset class="tl_tbox">
								<div>
									<h3><label for="phone"><?php echo $GLOBALS['TL_LANG']['contaolinks']['phone'][0]; ?></label></h3>
									<input id="phone" name="phone" type="text" value="" style="width: 99%" onkeyup="clearTimeout(this.timeout); var self = this; this.timeout = setTimeout(function(){ self.value = self.value.replace(/[^+\-\d\.]/g, ''); }, 250);" />
									<p class="tl_help tl_tip"><?php echo $GLOBALS['TL_LANG']['contaolinks']['phone'][1]; ?></p>
								</div>
							</fieldset>
						</div>
					</div>
					<div id="url_panel" class="panel">
						<h1 class="main_headline"><?php echo $GLOBALS['TL_LANG']['contaolinks']['url_legend'][1]; ?></h1>
						<div class="tl_formbody_edit">
							<fieldset class="tl_tbox">
								<div>
									<h3><label for="url"><?php echo $GLOBALS['TL_LANG']['contaolinks']['url'][0]; ?></label></h3>
									<input id="url" name="url" type="text" value="" style="width: 99%" />
									<p class="tl_help tl_tip"><?php echo $GLOBALS['TL_LANG']['contaolinks']['url'][1]; ?></p>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
				
				<div id="attributes_wrapper">
					<h1 class="main_headline"><?php echo $GLOBALS['TL_LANG']['contaolinks']['attributes']; ?></h1>
					<div class="tl_formbody_edit">
						<table border="0" cellpadding="4" cellspacing="0">
							<tr>
								<td class="nowrap"><label for="linktitle"><?php echo $GLOBALS['TL_LANG']['contaolinks']['title']; ?></label></td>
								<td><input id="linktitle" name="linktitle" type="text" value="" style="width: 200px" /></td>
								<td><label id="targetlistlabel" for="target_list"><?php echo $GLOBALS['TL_LANG']['contaolinks']['target']; ?></label></td>
								<td><select id="target_list" name="target_list" style="width: 200px">
									<option value=""><?php echo $GLOBALS['TL_LANG']['contaolinks']['not_set']; ?></option>
									<option value="_blank"><?php echo $GLOBALS['TL_LANG']['contaolinks']['_blank']; ?></option>
								</select></td>
							</tr>
							<tr>
								<td><label id="rellistlabel" for="rel_list"><?php echo $GLOBALS['TL_LANG']['contaolinks']['rel']; ?></label></td>
								<td><select id="rel_list" name="rel_list" class="mceEditableSelect" style="width: 200px">
									<option value=""><?php echo $GLOBALS['TL_LANG']['contaolinks']['not_set']; ?></option>
									<option value="lightbox"><?php echo $GLOBALS['TL_LANG']['contaolinks']['lightbox']; ?></option>
									<option value="lightbox[multi]"><?php echo $GLOBALS['TL_LANG']['contaolinks']['gallery']; ?></option>
								</select></td>
								<td><label for="class_list"><?php echo $GLOBALS['TL_LANG']['contaolinks']['class']; ?></label></td>
								<td><select id="class_list" name="class_list" class="mceEditableSelect" style="width: 200px">
									<option value=""><?php echo $GLOBALS['TL_LANG']['contaolinks']['not_set']; ?></option>
								</select></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			
			<div class="tl_formbody_submit">
				<div class="tl_submit_container">
					<input type="submit" name="save" id="save" class="tl_submit" accesskey="s" value="<?php echo specialchars($GLOBALS['TL_LANG']['contaolinks']['save']); ?>" />
					<input type="button" name="cancel" id="cancel" class="tl_submit" accesskey="c" value="<?php echo specialchars($GLOBALS['TL_LANG']['contaolinks']['cancel']); ?>" onclick="window.cancel();" />
				</div>
			</div>
		</form>
	</div>
</body>
</html>
		<?php	
	}
}

$objContaoLinks = new ContaoLinks();
$objContaoLinks->run();

?>