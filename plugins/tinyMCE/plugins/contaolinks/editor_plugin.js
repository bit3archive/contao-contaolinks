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