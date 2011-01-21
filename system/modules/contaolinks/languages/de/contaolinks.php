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
 * General
 */
$GLOBALS['TL_LANG']['contaolinks']['title']         = 'Link Editor';
$GLOBALS['TL_LANG']['contaolinks']['link']          = 'Link-Typ';
$GLOBALS['TL_LANG']['contaolinks']['internal']      = 'Interner Link';
$GLOBALS['TL_LANG']['contaolinks']['communication'] = 'Kommunikation';
$GLOBALS['TL_LANG']['contaolinks']['external']      = 'Extern';
$GLOBALS['TL_LANG']['contaolinks']['attributes']    = 'Eigenschaften der Verlinkung';


/**
 * Tabs
 */
$GLOBALS['TL_LANG']['contaolinks']['page_legend']  = array('Seite', 'Verlinkung zu einer Contao Seite bearbeiten');
$GLOBALS['TL_LANG']['contaolinks']['file_legend']  = array('Datei', 'Verlinkung zu einer Datei bearbeiten');
$GLOBALS['TL_LANG']['contaolinks']['email_legend'] = array('E-Mail', 'E-Mail Adresse bearbeiten');
$GLOBALS['TL_LANG']['contaolinks']['phone_legend'] = array('Telefon', 'Telefon oder Faxnummer bearbeiten');
$GLOBALS['TL_LANG']['contaolinks']['url_legend']   = array('URL', 'Verlinkung zu einer externen Adresse bearbeiten');


/**
 * Fields
 */
$GLOBALS['TL_LANG']['contaolinks']['email']  = array('E-Mail Adresse', 'Geben Sie hier eine E-Mail Adresse nach dem Muster <em>martin@muster.de</em> ein.');
$GLOBALS['TL_LANG']['contaolinks']['phone']  = array('Telefon- / Faxnummer', 'Geben Sie hier eine Telefonnummer nach dem Muster <em>+49.1234-567890</em> ein.<br/>Bitte beachten Sie, das verlinken einer Telefonnummer funktioniert in der Regel nur auf Mobilen Geräten (Smartphones) korrekt. Auf PCs funktioniert die Telefonnummer nur in Verbindung mit einer installierten Telefonsoftware (VOIP / Skype).');
$GLOBALS['TL_LANG']['contaolinks']['url']    = array('Internet Adresse', 'Geben Sie hier eine beliebige Internet Adresse nach dem Muster <em>http://www.google.de</em> ein.');
$GLOBALS['TL_LANG']['contaolinks']['title']  = 'Titel';
$GLOBALS['TL_LANG']['contaolinks']['rel']    = 'Lightbox';
$GLOBALS['TL_LANG']['contaolinks']['target'] = 'Fenster';
$GLOBALS['TL_LANG']['contaolinks']['class']  = 'CSS-Klasse';


/**
 * Reference
 */
$GLOBALS['TL_LANG']['contaolinks']['not_set']  = '- unbestimmt -';
$GLOBALS['TL_LANG']['contaolinks']['lightbox'] = 'Einzelnes Element';
$GLOBALS['TL_LANG']['contaolinks']['gallery']  = 'Galerie';
$GLOBALS['TL_LANG']['contaolinks']['_blank']   = 'Neues Fenster öffnen';


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['contaolinks']['save']   = 'Speichern';
$GLOBALS['TL_LANG']['contaolinks']['cancel'] = 'Abbrechen';

?>