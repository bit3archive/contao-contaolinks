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
 * @copyright  InfinitySoft 2011
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    ContaoLinks
 * @license    LGPL
 * @filesource
 */

function displayTab(tab, panel) {
	$$('.current').removeClass('current');
	$(tab).addClass('current');
	$(panel).addClass('current');
}

function getLinkAttributes() {
	var f = document.forms[0];
	
	var atts = {
		title: f.linktitle.value,
		'rel' : f.rel_list ? getSelectValue(f, "rel_list") : null,
		'class' : f.class_list ? getSelectValue(f, "class_list") : null
	};
	
	if ($('page_tab').hasClass('current'))
	{
		var n = f.pageTree.getSelected();
		if (!n) return false;
		atts.href = '{{link_url::' + n.pageId + '}}';
	}
	else if ($('file_tab').hasClass('current'))
	{
		var n = f.fileTree.getSelected();
		if (!n) return false;
		atts.href = n.path;
	}
	else if ($('email_tab').hasClass('current'))
	{
		atts.href = 'mailto:' + f.email.value;
	}
	else if ($('phone_tab').hasClass('current'))
	{
		atts.href = 'tel:' + f.phone.value;
	}
	else if ($('url_tab').hasClass('current'))
	{
		var url = f.url.value;
		if (!url.match(/^\w+:\/\//))
		{
			url = 'http://' + url;
		}
		atts.href = url;
	}
	else
	{
		return false;
	}

	return atts;
};

function init(atts, okCallback, cancelCallback) {
	var f = document.forms[0];
	
	var selectedPage = 0;
	var selectedPath = '';
	if (atts)
	{
		if (match = atts.href.match(/^\{\{link_url::(\d+)\}\}$/))
		{
			selectedPage = match[1];
			displayTab('page_tab','page_panel');
		}
		else if (atts.href.match(/^tl_files\//))
		{
			selectedPath = atts.href;
			displayTab('file_tab','file_panel');
		}
		else if (atts.href.match(/^mailto:/))
		{
			f.email.value = atts.href.substr(7);
			displayTab('email_tab','email_panel');
		}
		else if (atts.href.match(/^tel:/))
		{
			f.phone.value = atts.href.substr(4);
			displayTab('phone_tab','phone_panel');
		}
		else
		{
			f.url.value = atts.href;
			displayTab('url_tab','url_panel');
		}
	}
	
	f.pageTree = new Mif.Tree({
		container: $('pageTree'),
		forest: true,
		initialize: function(){
			new Mif.Tree.KeyNav(this);
		},
		types: {
			page:   { openIcon: 'mif-tree-page-page',   closeIcon: 'mif-tree-page-page' },
			loader: { openIcon: 'mif-tree-loader-icon', closeIcon: 'mif-tree-loader-icon' }
		},
		dfltType: 'page',
		height: 18
	});

	f.pageTree.loadOptions = function(node){
		return {
			url: 'system/modules/contaolinks/pages.php?pid=' + (node ? node.pageId : 0)
		};
	};

	new Request.JSON({
		url: 'system/modules/contaolinks/pages.php',
		onSuccess: function(tree) {
			f.pageTree.load({
				json:tree
			});
		}
	}).get({ pid: 0, selectedPage: selectedPage });

	f.fileTree = new Mif.Tree({
		container: $('fileTree'),
		forest: true,
		initialize: function(){
			new Mif.Tree.KeyNav(this);
		},
		types: {
			folder: { openIcon: 'mif-tree-folder-icon', closeIcon: 'mif-tree-folder-icon' },
			file:   { openIcon: 'mif-tree-file-icon',   closeIcon: 'mif-tree-file-icon' },
			loader: { openIcon: 'mif-tree-loader-icon', closeIcon: 'mif-tree-loader-icon' }
		},
		dfltType: 'folder',
		height: 18
	});

	f.fileTree.addEvent('select', function(node) {
		if (node.preview) {
			window.Preview.show(node.path);
		} else {
			window.Preview.hide();
		}
	});
	
	f.fileTree.loadOptions = function(node){
		return {
			url: 'system/modules/contaolinks/files.php?path=' + (node ? node.path : '')
		};
	};

	new Request.JSON({
		url: 'system/modules/contaolinks/files.php',
		onSuccess: function(tree) {
			f.fileTree.load({
				json:tree
			});
		}
	}).get({ path: '', selectedPath: selectedPath });

	window.update = function() {
		okCallback(getLinkAttributes());
	};
	window.cancel = function() {
		cancelCallback();
	};
};

window.addEvent('domready', function() {
	var filePreview = $('filePreview');
	filePreview.set('morph', { link: 'cancel', duration: 'short' });
	var filePreviewImage = $('filePreviewImage');
	filePreviewImage.set('morph', { link: 'cancel' });
	window.Preview = {
		show: function(path) {
			filePreviewImage.setStyle('opacity', 0);
			filePreview.get('morph')
				.start({ width: '22px', height: '22px', opacity: 1.0 })
				.chain(function() {
					new Request.JSON({
						url: 'system/modules/contaolinks/files.php',
						onSuccess: function(json) {
							if (json && json.thumb.src) {
								filePreview.setStyles('backgroundImage', '');
								filePreview.get('morph')
									.start({ width: json.thumb.width+'px', height: json.thumb.height+'px', opacity: 1.0 })
									.chain(function() {
										filePreviewImage.setStyle('backgroundImage', 'url(' + json.thumb.src + ')');
										filePreviewImage.morph({ opacity: 1.0 });
									});
							}
						}
					}).get({ preview: path });
				});
		},
		hide: function() {
			filePreview.get('morph')
				.start({ opacity: 0.0 })
				.chain(function() { filePreview.setStyles({ width: '22px', height: '22px' }); });
		}
	};
	filePreview.setStyles({ display: 'block', opacity: 0.0 });
	
	var wrapper = $('attributes_wrapper');
	var edit = wrapper.getElement('div.tl_formbody_edit');
	var fx = new Fx.Slide(edit);
	fx.hide();
	wrapper.getElement('h1.main_headline').addEvent('click', function() {
		fx.toggle();
	});
});