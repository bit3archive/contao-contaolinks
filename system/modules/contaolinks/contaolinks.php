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
require('../../../../system/initialize.php');


/**
 * Include library class
 */
require('contaolib.php');


/**
 * Generate page
 */
header('Content-Type: text/html; charset=' . $GLOBALS['TL_CONFIG']['characterSet']);
$objLib = new contaolib();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{#contaolinks_dlg.link_title}</title>
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script type="text/javascript" src="../../utils/mctabs.js"></script>
	<script type="text/javascript" src="../../utils/editable_selects.js"></script>
	<script type="text/javascript" src="../../utils/form_utils.js"></script>
	<script type="text/javascript" src="../../utils/validate.js"></script>
	<script type="text/javascript" src="../../../mootools/mootools-core.js"></script>
	<script type="text/javascript" src="../../../mootools/mootools-more.js"></script>
	<script type="text/javascript" src="../../../Mif.Tree/mif.tree.js"></script>
	<script type="text/javascript" src="js/contaolinks.js"></script>
	<link type="text/css" rel="stylesheet" href="css/mif.tree.php" />
</head>
<body id="link" style="display: none">
<form onsubmit="LinkDialog.update();return false;" action="#">
	<div class="tabs">
		<ul>
			<li id="page_tab" class="current"><span><a href="javascript:mcTabs.displayTab('page_tab','page_panel');" onmousedown="return false;">{#contaolinks_dlg.page_title}</a></span></li>
			<li id="file_tab"><span><a href="javascript:mcTabs.displayTab('file_tab','file_panel');" onmousedown="return false;">{#contaolinks_dlg.file_title}</a></span></li>
			<li id="email_tab"><span><a href="javascript:mcTabs.displayTab('email_tab','email_panel');" onmousedown="return false;">{#contaolinks_dlg.email_title}</a></span></li>
			<li id="phone_tab"><span><a href="javascript:mcTabs.displayTab('phone_tab','phone_panel');" onmousedown="return false;">{#contaolinks_dlg.phone_title}</a></span></li>
			<li id="url_tab"><span><a href="javascript:mcTabs.displayTab('url_tab','url_panel');" onmousedown="return false;">{#contaolinks_dlg.url_title}</a></span></li>
		</ul>
	</div>

	<div class="panel_wrapper" style="height:252px;">
		<div id="page_panel" class="panel current" style="height: 252px; position: relative;">
			<div id="pageTree"></div>
		</div>
		<div id="file_panel" class="panel">
			<div id="fileTree"></div>
		</div>
		<div id="email_panel" class="panel">
			<table border="0" cellpadding="4" cellspacing="0" width="100%">
				<tr>
					<td class="nowrap"><label for="email">{#contaolinks_dlg.email}</label></td>
				</tr>
				<tr>
					<td><input id="email" name="email" type="text" value="" style="width: 99%" /></td>
				</tr>
				<tr>
					<td>{#contaolinks_dlg.email_desc}</td>
				</tr>
			</table>
		</div>
		<div id="phone_panel" class="panel">
			<table border="0" cellpadding="4" cellspacing="0" width="100%">
				<tr>
					<td class="nowrap"><label for="phone">{#contaolinks_dlg.phone}</label></td>
				</tr>
				<tr>
					<td><input id="phone" name="phone" type="text" value="" style="width: 99%" onkeyup="clearTimeout(this.timeout); var self = this; this.timeout = setTimeout(function(){ self.value = self.value.replace(/[^+\-\d]/g, ''); }, 250);" /></td>
				</tr>
				<tr>
					<td>{#contaolinks_dlg.phone_desc}</td>
				</tr>
			</table>
		</div>
		<div id="url_panel" class="panel">
			<table border="0" cellpadding="4" cellspacing="0" width="100%">
				<tr>
					<td class="nowrap"><label for="url">{#contaolinks_dlg.url}</label></td>
				</tr>
				<tr>
					<td><input id="url" name="url" type="text" value="" style="width: 99%" /></td>
				</tr>
				<tr>
					<td>{#contaolinks_dlg.url_desc}</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="panel_wrapper" style="height:50px; margin-top: 2px;">
		<table border="0" cellpadding="4" cellspacing="0">
			<tr>
				<td class="nowrap"><label for="linktitle">{#contaolinks_dlg.link_titlefield}</label></td>
				<td><input id="linktitle" name="linktitle" type="text" value="" style="width: 200px" /></td>
				<td><label id="targetlistlabel" for="target_list">{#contaolinks_dlg.link_target}</label></td>
				<td><select id="target_list" name="target_list" style="width: 200px"></select></td>
			</tr>
			<tr>
				<td><label id="rellistlabel" for="rel_list">{#contaolinks_dlg.image_rel}</label></td>
				<td><select id="rel_list" name="rel_list" class="mceEditableSelect" style="width: 200px"></select></td>
				<td><label for="class_list">{#class_name}</label></td>
				<td><select id="class_list" name="class_list" class="mceEditableSelect" style="width: 200px"></select></td>
			</tr>
		</table>
	</div>

	<div class="mceActionPanel">
		<input type="submit" id="insert" name="insert" value="{#insert}" />
		<input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
	</div>
</form>
</body>
</html>