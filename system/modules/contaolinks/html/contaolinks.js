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
tinyMCEPopup.requireLangPack();

var LinkDialog = {
	preInit : function() {
		var url;

		if (url = tinyMCEPopup.getParam("external_link_list_url"))
			document.write('<script language="javascript" type="text/javascript" src="' + tinyMCEPopup.editor.documentBaseURI.toAbsolute(url) + '"></script>');
	},

	init : function() {
		var f = document.forms[0], ed = tinyMCEPopup.editor;

		// Setup browse button
		/*
		document.getElementById('hrefbrowsercontainer').innerHTML = getBrowserHTML('hrefbrowser', 'href', 'file', 'theme_advanced_link');
		if (isVisible('hrefbrowser'))
			document.getElementById('href').style.width = '180px';
		*/

		// this.fillFileList('link_list', 'tinyMCELinkList');
		this.fillRelList('rel_list');
		this.fillTargetList('target_list');
		this.fillClassList('class_list');

		var selectedPage = 0;
		var selectedFile = '';
		
		if (e = ed.dom.getParent(ed.selection.getNode(), 'A')) {
			var match = false;
			var href = ed.dom.getAttrib(e, 'href');
			if (match = href.match(/^\{\{link_url::(\d+)\}\}$/))
			{
				selectedPage = match[1];
				mcTabs.displayTab('page_tab','page_panel');
			}
			else if (href.match(/^tl_files\//))
			{
				selectedFile = href;
				// TODO f.pageTree.setSelected(href);
				mcTabs.displayTab('file_tab','file_panel');
			}
			else if (href.match(/^mailto:/))
			{
				f.email.value = href.substr(7);
				mcTabs.displayTab('email_tab','email_panel');
			}
			else if (href.match(/^tel:/))
			{
				f.phone.value = href.substr(4);
				mcTabs.displayTab('phone_tab','phone_panel');
			}
			else
			{
				f.url.value = href;
				mcTabs.displayTab('url_tab','url_panel');
			}
			f.linktitle.value = ed.dom.getAttrib(e, 'title');
			f.insert.value = ed.getLang('update');
			//selectByValue(f, 'link_list', f.href.value);
			// PATCH: handle target="_blank"
			if (/window.open\(this.href\);/.test(ed.dom.getAttrib(e, 'onclick'))) {
				selectByValue(f, 'target_list', '_blank');
			} else {
				selectByValue(f, 'target_list', ed.dom.getAttrib(e, 'target'));
			}
			// PATCH EOF
			selectByValue(f, 'rel_list', ed.dom.getAttrib(e, 'rel'), true); // PATCH: rel attribute
			selectByValue(f, 'class_list', ed.dom.getAttrib(e, 'class'), true); // PATCH: add true to set custom values
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
				url: 'contaopages.php?pid=' + (node ? node.pageId : 0)
			};
		};

		new Request.JSON({
			url: 'contaopages.php',
			onSuccess: function(tree) {
				f.pageTree.load({
					json:tree
				});
			}
		}).get({ pid: 0, selectedPage: selectedPage });

		TinyMCE_EditableSelects.init(); // PATCH: initialize editable select
	},

	atts : function() {
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
	},

	update : function() {
		var f = document.forms[0], ed = tinyMCEPopup.editor, e, b;

		tinyMCEPopup.restoreSelection();
		e = ed.dom.getParent(ed.selection.getNode(), 'A');

		var atts = this.atts();
		
		// Remove element if there is no href
		if (!atts) {
			if (e) {
				tinyMCEPopup.execCommand("mceBeginUndoLevel");
				b = ed.selection.getBookmark();
				ed.dom.remove(e, 1);
				ed.selection.moveToBookmark(b);
				tinyMCEPopup.execCommand("mceEndUndoLevel");
				tinyMCEPopup.close();
				return;
			}
		}

		tinyMCEPopup.execCommand("mceBeginUndoLevel");

		// Create new anchor elements
		if (e == null) {
			ed.getDoc().execCommand("unlink", false, null);
			tinyMCEPopup.execCommand("CreateLink", false, "#mce_temp_url#", {skip_undo : 1});
			var t = this;

			tinymce.each(ed.dom.select("a"), function(n) {
				if (ed.dom.getAttrib(n, 'href') == '#mce_temp_url#') {
					e = n;

					ed.dom.setAttribs(e, atts);

					// PATCH: handle target="_blank"
					t.fixIssues(ed, e, f, atts);
				}
			});
		} else {
			ed.dom.setAttribs(e, atts);

			// PATCH: handle target="_blank"
			this.fixIssues(ed, e, f, atts);
		}

		// Don't move caret if selection was image
		if (e.childNodes.length != 1 || e.firstChild.nodeName != 'IMG') {
			ed.focus();
			ed.selection.select(e);
			ed.selection.collapse(0);
			tinyMCEPopup.storeSelection();
		}

		tinyMCEPopup.execCommand("mceEndUndoLevel");
		tinyMCEPopup.close();
	},

	// PATCH: add function fixIssues
	fixIssues : function(ed, e, f, atts) {
		var o = ed.dom.getAttrib(e, 'onclick');

		// Handle target="_blank"
		if (getSelectValue(f, "target_list") == '_blank' && !/window.open\(this.href\);/.test(o)) {
			ed.dom.setAttrib(e, 'onclick', tinymce.trim(o + ' window.open(this.href); return false;'));
		} else if (o) {
			ed.dom.setAttrib(e, 'onclick', tinymce.trim(o.replace('window.open(this.href); return false;', '')));
		}

		// Fix relative URLs
		if (atts.href+'/' == ed.settings.document_base_url) {
			atts.href += '/';
		}
		if (atts.href == ed.settings.document_base_url) {
			e.setAttribute('mce_href', atts.href);
		}
	},
	// PATCH EOF

	checkPrefix : function(n) {
		if (n.value && Validator.isEmail(n) && !/^\s*mailto:/i.test(n.value) && confirm(tinyMCEPopup.getLang('contaolinks_dlg.link_is_email')))
			n.value = 'mailto:' + n.value;

		if (/^\s*www\./i.test(n.value) && confirm(tinyMCEPopup.getLang('contaolinks_dlg.link_is_external')))
			n.value = 'http://' + n.value;

		if (n.value && /^#/.test(n.value))
			n.value = '{{env::request}}' + n.value;
	},

	fillFileList : function(id, l) {
		var dom = tinyMCEPopup.dom, lst = dom.get(id), v, cl;

		l = window[l];

		if (l && l.length > 0) {
			lst.options[lst.options.length] = new Option('', '');

			tinymce.each(l, function(o) {
				lst.options[lst.options.length] = new Option(o[0], o[1]);
			});
		} else
			dom.remove(dom.getParent(id, 'tr'));
	},

	fillRelList : function(id) {
		var dom = tinyMCEPopup.dom, lst = dom.get(id), v;

		lst.options[lst.options.length] = new Option(tinyMCEPopup.getLang('not_set'), '');
		lst.options[lst.options.length] = new Option(tinyMCEPopup.getLang('contaolinks_dlg.image_rel_single'), 'lightbox');
		lst.options[lst.options.length] = new Option(tinyMCEPopup.getLang('contaolinks_dlg.image_rel_multi'), 'lightbox[multi]');
	},

	fillTargetList : function(id) {
		var dom = tinyMCEPopup.dom, lst = dom.get(id), v;

		lst.options[lst.options.length] = new Option(tinyMCEPopup.getLang('not_set'), '');
		lst.options[lst.options.length] = new Option(tinyMCEPopup.getLang('contaolinks_dlg.link_target_blank'), '_blank');

		if (v = tinyMCEPopup.getParam('theme_advanced_link_targets')) {
			tinymce.each(v.split(','), function(v) {
				v = v.split('=');
				lst.options[lst.options.length] = new Option(v[0], v[1]);
			});
		}
	},

	fillClassList : function(id) {
		var dom = tinyMCEPopup.dom, lst = dom.get(id), v, cl;

		if (v = tinyMCEPopup.getParam('theme_advanced_styles')) {
			cl = [];

			tinymce.each(v.split(';'), function(v) {
				var p = v.split('=');

				cl.push({'title' : p[0], 'class' : p[1]});
			});
		} else
			cl = tinyMCEPopup.editor.dom.getClasses();

		// PATCH: always show not_set option
		lst.options[lst.options.length] = new Option(tinyMCEPopup.getLang('not_set'), '');

		if (cl.length > 0) {
			tinymce.each(cl, function(o) {
				lst.options[lst.options.length] = new Option(o.title || o['class'], o['class']);
			});
		}/* else
			dom.remove(dom.getParent(id, 'tr')); PATCH: do not remove */
	}
};

LinkDialog.preInit();
tinyMCEPopup.onInit.add(LinkDialog.init, LinkDialog);
