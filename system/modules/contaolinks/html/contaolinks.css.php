<?php

#copyright


/**
 * Initialize system
 */
define('TL_MODE', 'FE');
require('../../../initialize.php');

class ContaoLinksCss extends ContaoLinksLib
{
	public function __construct()
	{
		parent::__construct();
	}


	public function run()
	{
		header('Content-Type: text/css');
		
		?>
body#contaolinks {
	padding: 6px;
	overflow: hidden;
}
#tl_navigation ul,
#tl_navigation li {
	margin: 0;
	padding: 0;
	list-style: none;
}
#tl_navigation li span {
	padding-left: 18px;
}
#tl_navigation li.current a {
	font-weight: bold;
}

a.navigation.phone {
	background-image: url(phone.png);
}
a.navigation.email {
	background-image: url(email.png);
}
a.navigation.url {
	background-image: url(url.png);
}

#tl_formbody {
	position: relative;
	padding-bottom: 20px;
}
#attributes_wrapper {
	position: absolute;
	bottom: 0;
	left: 0;
	width: 100%;
	background: rgba(255,255,255,.8);
}
#attributes_wrapper h1.main_headline {
	cursor: pointer;
}

#panel_wrapper .tl_formbody_edit {
	height: 250px;
	position: relative;
	overflow: auto;
}
#panel_wrapper .panel {
	display: none;
}
#panel_wrapper .panel.current {
	display: block;
}

#filePreview {
	position: absolute;
	top: 24px;
	right: 21px;
	padding: 3px;
	border: 1px solid #BBBBBB;
	background-position: center center;
	background-repeat: no-repeat;
	background-color: #fff;
	background-image: url(loader.gif);
}
#filePreviewImage {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-position: center center;
	background-repeat: no-repeat;
	background-color: #fff;
}

.mif-tree-wrapper {
	padding: 18px 0;
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
.mif-tree-node-wrapper {
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
	background-image: url('../../../../<?php echo $this->getIconSrc('folMinus'); ?>');
}
.mif-tree-gadjet-plus {
	background-image: url('../../../../<?php echo $this->getIconSrc('folPlus'); ?>');
}


/* @icons */
.mif-tree-icon {
	padding-right:18px;
	background-position:0 50%;
	background-repeat:no-repeat;
	cursor:inherit;
}
.mif-tree-loader-icon {
	background-image: url('loader.gif') !important;
}

/*@selection*/
.mif-tree-node-selected .mif-tree-name {
	background-color: #010161;
	color:#fff;
	text-transform:italic;
}
.mif-tree-highlighter {
	height:18px;
	overflow:hidden;
	width:100%;
	background:#b64553;
	position:absolute;
}

/*@d'n'd*/
.mif-tree-pointer {
	height:1px;
	overflow: hidden;
	position: absolute;
	background-repeat:repeat-x;
	background-color:#292fef;
}
.mif-tree-ghost {
	background-color:#fff;
	border:solid 2px #e8e8f7;
	padding-left:2px;
}
.mif-tree-ghost span {
	padding-top:2px;
	padding-bottom:2px;
}
.mif-tree-ghost .mif-tree-node-wrapper {
	background:none;
}
.mif-tree-ghost span.mif-tree-text {
	padding-top:1px;
	padding-bottom:1px;
}
.mif-tree-ghost-icon {
	padding-left:16px;
	background-color:#fff;
	background-repeat:no-repeat;
}
.mif-tree-ghost-after {
	background-position:-64px 2px;
}
.mif-tree-ghost-before {
	background-position:-48px 2px;
}
.mif-tree-ghost-between {
	background-position:-16px 2px;
}
.mif-tree-ghost-inside {
	background-position:-0px 2px;
}
.mif-tree-ghost-notAllowed {
	background-position:-32px 2px;
}
.mif-tree-drag-current {
	background-color:#cfcfd8;
}
.mif-tree-replace {
	background-color:#99c8fb;
}

/*@rename*/
.mif-tree-rename {
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

$objContaoLinksCss = new ContaoLinksCss();
$objContaoLinksCss->run();

?>