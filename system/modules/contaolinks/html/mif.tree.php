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
 * @copyright  Leo Feyer 2005-2010
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Plugins
 * @license    LGPL
 * @filesource
 */


/**
 * Initialize system
 */
define('TL_MODE', 'FE');
require('../../../../../system/initialize.php');

class MifTreeCss extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}


	public function icon($strIcon)
	{
		return sprintf('../../../../../system/themes/%s/images/%s.gif', $this->getTheme(), $strIcon);
	}


	public function output()
	{
		header('Content-Type: text/css');
		?>
.mif-tree-wrapper {
	position: absolute;
	width: 100%;
	height:100%;
	margin:0;
	padding:0;
	overflow:auto;
	font-family:sans-serif;
	font-size:11px;
	line-height:18px;/******Tree node height******/
	white-space:nowrap;
	cursor:default;
}
.mif-tree-bg {
	width:100%;
	height:100%;
	position:absolute;
	overflow:hidden;
}
.mif-tree-bg-container {
	width:100%;
	display:none;
}
.mif-tree-bg-node {
	width:100%;
	height:18px;
}
.mif-tree-bg-selected {
	background-color:#dcd7ab;
}
.mif-tree-wrapper:focus {
	outline:0;
}
.mif-tree-wrapper span {
	padding-bottom:2px;
	padding-top:2px;
	cursor:inherit;
}
.mif-tree-children {
	padding-left:18px;
	width:18px;
}
.mif-tree-node {
	width:18px;
}
.mif-tree-node-last {
}
.mif-tree-name {
	cursor: default;
	overflow:hidden;
	margin-left:4px;
}
.mif-tree-name a {
	color:red;
}
.mif-tree-name a:hover {
	color:blue;
}
.mif-tree-node-wrapper{
}

/*@gadjets*/
.mif-tree-gadjet {
	background-position: left center;
	background-repeat:no-repeat;
	padding-right: 16px;
	z-index:1;
	overflow:hidden;
	cursor:default;
}
.mif-tree-gadjet-none {
	background: none;
}
.mif-tree-gadjet-minus {
	background-image: url('<?php echo $this->icon('folMinus'); ?>');
}
.mif-tree-gadjet-plus {
	background-image: url('<?php echo $this->icon('folPlus'); ?>');
}


/* @icons */
.mif-tree-icon{
	padding-right:18px;
	background-position:0 50%;
	background-repeat:no-repeat;
	cursor:inherit;
}

.mif-tree-folder-open-icon{
	background-image:url('<?php echo $this->icon('folderO'); ?>')
}
.mif-tree-folder-close-icon{
	background-image:url('<?php echo $this->icon('folderC'); ?>')
}

.mif-tree-regular-icon {
	background-image:url('<?php echo $this->icon('regular'); ?>')
}
.mif-tree-regular-unpublished-icon {
	background-image:url('<?php echo $this->icon('regular_1'); ?>')
}
.mif-tree-regular-hidden-icon {
	background-image:url('<?php echo $this->icon('regular_2'); ?>')
}
.mif-tree-regular-unpublished-hidden-icon {
	background-image:url('<?php echo $this->icon('regular_3'); ?>')
}
.mif-tree-regular-protected-icon {
	background-image:url('<?php echo $this->icon('regular_4'); ?>')
}
.mif-tree-regular-unpublished-protected-icon {
	background-image:url('<?php echo $this->icon('regular_5'); ?>')
}
.mif-tree-regular-unpublished-hidden-protected {
	background-image:url('<?php echo $this->icon('regular_6'); ?>')
}

.mif-tree-forward-icon {
	background-image:url('<?php echo $this->icon('forward'); ?>')
}
.mif-tree-forward-unpublished-icon {
	background-image:url('<?php echo $this->icon('forward_1'); ?>')
}
.mif-tree-forward-hidden-icon {
	background-image:url('<?php echo $this->icon('forward_2'); ?>')
}
.mif-tree-forward-unpublished-hidden-icon {
	background-image:url('<?php echo $this->icon('forward_3'); ?>')
}
.mif-tree-forward-protected-icon {
	background-image:url('<?php echo $this->icon('forward_4'); ?>')
}
.mif-tree-forward-unpublished-protected-icon {
	background-image:url('<?php echo $this->icon('forward_5'); ?>')
}
.mif-tree-forward-unpublished-hidden-protected {
	background-image:url('<?php echo $this->icon('forward_6'); ?>')
}

.mif-tree-redirect-icon {
	background-image:url('<?php echo $this->icon('redirect'); ?>')
}
.mif-tree-redirect-unpublished-icon {
	background-image:url('<?php echo $this->icon('redirect_1'); ?>')
}
.mif-tree-redirect-hidden-icon {
	background-image:url('<?php echo $this->icon('redirect_2'); ?>')
}
.mif-tree-redirect-unpublished-hidden-icon {
	background-image:url('<?php echo $this->icon('redirect_3'); ?>')
}
.mif-tree-redirect-protected-icon {
	background-image:url('<?php echo $this->icon('redirect_4'); ?>')
}
.mif-tree-redirect-unpublished-protected-icon {
	background-image:url('<?php echo $this->icon('redirect_5'); ?>')
}
.mif-tree-redirect-unpublished-hidden-protected {
	background-image:url('<?php echo $this->icon('redirect_6'); ?>')
}

.mif-tree-root-icon {
	background-image:url('<?php echo $this->icon('root'); ?>')
}
.mif-tree-root-unpublished-icon {
	background-image:url('<?php echo $this->icon('root_1'); ?>')
}
.mif-tree-root-hidden-icon {
	background-image:url('<?php echo $this->icon('root_2'); ?>')
}
.mif-tree-root-unpublished-hidden-icon {
	background-image:url('<?php echo $this->icon('root_3'); ?>')
}
.mif-tree-root-protected-icon {
	background-image:url('<?php echo $this->icon('root_4'); ?>')
}
.mif-tree-root-unpublished-protected-icon {
	background-image:url('<?php echo $this->icon('root_5'); ?>')
}
.mif-tree-root-unpublished-hidden-protected {
	background-image:url('<?php echo $this->icon('root_6'); ?>')
}

.mif-tree-loader-icon {
	background-image:url('../img/loader.gif');
}



/*@selection*/

.mif-tree-node-selected .mif-tree-name{
	background-color: #010161;
	color:#fff;
	text-transform:italic;
}

.mif-tree-highlighter{
	height:18px;
	overflow:hidden;
	width:100%;
	background:#b64553;
	position:absolute;
}



/*@d'n'd*/
.mif-tree-pointer{
	height:1px;
	overflow: hidden;
	position: absolute;
	background-repeat:repeat-x;
	background-color:#292fef;
}


.mif-tree-ghost{
	background-color:#fff;
	border:solid 2px #e8e8f7;
	padding-left:2px;
}

.mif-tree-ghost span{
	padding-top:2px;
	padding-bottom:2px;
}

.mif-tree-ghost .mif-tree-node-wrapper{
	background:none;
}

.mif-tree-ghost span.mif-tree-text{
	padding-top:1px;
	padding-bottom:1px;
}

.mif-tree-ghost-icon{
	padding-left:16px;
	background-color:#fff;
	background-repeat:no-repeat;
}

.mif-tree-ghost-after{
	background-position:-64px 2px;
}

.mif-tree-ghost-before{
	background-position:-48px 2px;
}

.mif-tree-ghost-between{
	background-position:-16px 2px;
}

.mif-tree-ghost-inside{
	background-position:-0px 2px;
}

.mif-tree-ghost-notAllowed{
	background-position:-32px 2px;
}

.mif-tree-drag-current{
	background-color:#cfcfd8;
}

.mif-tree-replace{
	background-color:#99c8fb;
}


/*@checkbox*/
.mif-tree-checkbox{
	padding-left:18px;
}

.mif-tree-node-checked, .mif-tree-node-checked .mif-tree-checkbox{
	background:url('../img/checked.gif') center 2px no-repeat;
}

.mif-tree-node-unchecked, .mif-tree-node-unchecked .mif-tree-checkbox{
	background:url('../img/unchecked.gif') center 2px no-repeat;
}

.mif-tree-node-checked-selected{
	background:url('../img/checked_selected.gif') center 2px no-repeat;
}

.mif-tree-node-unchecked-selected{
	background:url('../img/unchecked_selected.gif') center 2px no-repeat;
}

/*@rename*/
.mif-tree-rename{
	display: inline;
	line-height: 14px;
	height:14px;
	cursor: default;
	overflow:hidden;
	font-family:sans-serif;
	font-size:11px;
	padding:1px 0;
	border:solid 1px black;
}
<?php
	}
}

$objMifTreeCss = new MifTreeCss();
$objMifTreeCss->output();

?>