<?php

#copyright


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

var tinyMCEImageList = new Array(
<?php echo substr($objLib->createImageList(), 0, -2); ?> 
);