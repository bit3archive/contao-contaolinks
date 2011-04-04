<?php

/* include COPYRIGHT */


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
 * Create image list
 */
$objLib = new contaolib();
header('Content-Type: text/javascript'); ?>

var tinyMCETemplateList = new Array(
<?php echo substr($objLib->createTemplateList(), 0, -2); ?> 
);