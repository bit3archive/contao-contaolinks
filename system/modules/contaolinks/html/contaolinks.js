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
		atts.href = n.filePath;
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
	if (atts)
	{
		if (match = atts.href.match(/^\{\{link_url::(\d+)\}\}$/))
		{
			selectedPage = match[1];
			displayTab('page_tab','page_panel');
		}
		else if (atts.href.match(/^tl_files\//))
		{
			selectedFile = href;
			// TODO f.pageTree.setSelected(href);
			displayTab('file_tab','file_panel');
		}
		else if (atts.href.match(/^mailto:/))
		{
			f.email.value = href.substr(7);
			displayTab('email_tab','email_panel');
		}
		else if (atts.href.match(/^tel:/))
		{
			f.phone.value = href.substr(4);
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
			folder:     { openIcon: 'mif-tree-page-icon',                                  closeIcon: 'mif-tree-page-icon' },
			regular_0:  { openIcon: 'mif-tree-regular-icon',                               closeIcon: 'mif-tree-regular-icon',                               loadable: true },
			regular_1:  { openIcon: 'mif-tree-regular-unpublished-icon',                   closeIcon: 'mif-tree-regular-unpublished-icon',                   loadable: true },
			regular_2:  { openIcon: 'mif-tree-regular-hidden-icon',                        closeIcon: 'mif-tree-regular-hidden-icon',                        loadable: true },
			regular_3:  { openIcon: 'mif-tree-regular-unpublished-hidden-icon',            closeIcon: 'mif-tree-regular-unpublished-hidden-icon',            loadable: true },
			regular_4:  { openIcon: 'mif-tree-regular-protected-icon',                     closeIcon: 'mif-tree-regular-protected-icon',                     loadable: true },
			regular_5:  { openIcon: 'mif-tree-regular-unpublished-protected-icon',         closeIcon: 'mif-tree-regular-unpublished-protected-icon',         loadable: true },
			regular_6:  { openIcon: 'mif-tree-regular-unpublished-hidden-protected-icon',  closeIcon: 'mif-tree-regular-unpublished-hidden-protected-icon',  loadable: true },
			forward_0:  { openIcon: 'mif-tree-forward-icon',                               closeIcon: 'mif-tree-forward-icon',                               loadable: true },
			forward_1:  { openIcon: 'mif-tree-forward-unpublished-icon',                   closeIcon: 'mif-tree-forward-unpublished-icon',                   loadable: true },
			forward_2:  { openIcon: 'mif-tree-forward-hidden-icon',                        closeIcon: 'mif-tree-forward-hidden-icon',                        loadable: true },
			forward_3:  { openIcon: 'mif-tree-forward-unpublished-hidden-icon',            closeIcon: 'mif-tree-forward-unpublished-hidden-icon',            loadable: true },
			forward_4:  { openIcon: 'mif-tree-forward-protected-icon',                     closeIcon: 'mif-tree-forward-protected-icon',                     loadable: true },
			forward_5:  { openIcon: 'mif-tree-forward-unpublished-protected-icon',         closeIcon: 'mif-tree-forward-unpublished-protected-icon',         loadable: true },
			forward_6:  { openIcon: 'mif-tree-forward-unpublished-hidden-protected-icon',  closeIcon: 'mif-tree-forward-unpublished-hidden-protected-icon',  loadable: true },
			redirect_0: { openIcon: 'mif-tree-redirect-icon',                              closeIcon: 'mif-tree-redirect-icon',                              loadable: true },
			redirect_1: { openIcon: 'mif-tree-redirect-unpublished-icon',                  closeIcon: 'mif-tree-redirect-unpublished-icon',                  loadable: true },
			redirect_2: { openIcon: 'mif-tree-redirect-hidden-icon',                       closeIcon: 'mif-tree-redirect-hidden-icon',                       loadable: true },
			redirect_3: { openIcon: 'mif-tree-redirect-unpublished-hidden-icon',           closeIcon: 'mif-tree-redirect-unpublished-hidden-icon',           loadable: true },
			redirect_4: { openIcon: 'mif-tree-redirect-protected-icon',                    closeIcon: 'mif-tree-redirect-protected-icon',                    loadable: true },
			redirect_5: { openIcon: 'mif-tree-redirect-unpublished-protected-icon',        closeIcon: 'mif-tree-redirect-unpublished-protected-icon',        loadable: true },
			redirect_6: { openIcon: 'mif-tree-redirect-unpublished-hidden-protected-icon', closeIcon: 'mif-tree-redirect-unpublished-hidden-protected-icon', loadable: true },
			root_0:     { openIcon: 'mif-tree-root-icon',                                  closeIcon: 'mif-tree-root-icon',                                  loadable: true },
			root_1:     { openIcon: 'mif-tree-root-unpublished-icon',                      closeIcon: 'mif-tree-root-unpublished-icon',                      loadable: true },
			root_2:     { openIcon: 'mif-tree-root-hidden-icon',                           closeIcon: 'mif-tree-root-hidden-icon',                           loadable: true },
			root_3:     { openIcon: 'mif-tree-root-unpublished-hidden-icon',               closeIcon: 'mif-tree-root-unpublished-hidden-icon',               loadable: true },
			root_4:     { openIcon: 'mif-tree-root-protected-icon',                        closeIcon: 'mif-tree-root-protected-icon',                        loadable: true },
			root_5:     { openIcon: 'mif-tree-root-unpublished-protected-icon',            closeIcon: 'mif-tree-root-unpublished-protected-icon',            loadable: true },
			root_6:     { openIcon: 'mif-tree-root-unpublished-hidden-protected-icon',     closeIcon: 'mif-tree-root-unpublished-hidden-protected-icon',     loadable: true },
			loader:     { openIcon: 'mif-tree-loader-icon',                                closeIcon: 'mif-tree-loader-icon' }
		},
		dfltType: 'regular',
		height: 18
	});

	f.pageTree.loadOptions = function(node){
		return {
			url: 'system/modules/contaolinks/contaopages.php?pid=' + (node ? node.pageId : 0)
		};
	};

	new Request.JSON({
		url: 'system/modules/contaolinks/contaopages.php',
		onSuccess: function(tree) {
			f.pageTree.load({
				json:tree
			});
		}
	}).get({ pid: 0, selectedPage: selectedPage });
	
	f.onsubmit = '';
	
	window.update = function() {
		okCallback(getLinkAttributes());
	};
	window.cancel = function() {
		cancelCallback();
	};
};

window.addEvent('domready', function() {
	var wrapper = $('attributes_wrapper');
	var edit = wrapper.getElement('div.tl_formbody_edit');
	var fx = new Fx.Slide(edit);
	fx.hide();
	wrapper.getElement('h1.main_headline').addEvent('click', function() {
		fx.toggle();
	});
});