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
(function() {
	tinymce.create('tinymce.plugins.ContaolinksPlugin', {
		init : function(ed, url) {
			// Register contaolinks command
			ed.addCommand('mceContaolinks', function() {
				ed.windowManager.open({
					file : 'system/modules/contaolinks/links.php?tinymce',
					width : 952,
					height : 355,
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register button
			ed.addButton('contaolinks', {
				title : 'contaolinks.link_desc',
				cmd : 'mceContaolinks',
				image : url + '/img/link.gif'
			});

			// Add shortcut
			ed.addShortcut('ctrl+k', 'contaolinks.desc', 'mceContaolinks');

			// Add a node change handler
			ed.onNodeChange.add(function(ed, cm, n, co) {
				cm.setDisabled('contaolinks', co && n.nodeName != 'A');
				cm.setActive('contaolinks', n.nodeName == 'A');
			});

			// Register lightbox image command
			ed.addCommand('mceContaobox', function() {
				ed.windowManager.open({
					file : url + 'system/modules/contaolinks/image.php?tinymce',
					width : 686,
					height : 400,
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register button
			ed.addButton('contaobox', {
				title : 'contaolinks.image_desc',
				cmd : 'mceContaobox',
				image : url + '/img/image.gif'
			});
		},

		getInfo : function() {
			return {
				longname : 'Contao plugin',
				author : 'Tristan Lins',
				authorurl : 'http://www.infinitysoft.de',
				infourl : 'http://www.contao.org',
				version : '3.2.7'
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('contaolinks', tinymce.plugins.ContaolinksPlugin);
})();