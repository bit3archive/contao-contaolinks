var LinkDialog = {
	preInit : function() {
		var url;

		if (url = tinyMCEPopup.getParam("external_link_list_url"))
			document.write('<script language="javascript" type="text/javascript" src="' + tinyMCEPopup.editor.documentBaseURI.toAbsolute(url) + '"></script>');
	},

	init : function() {
		var f = document.forms[0], ed = tinyMCEPopup.editor;

		var selectedPage = 0;
		var selectedFile = '';
		
		if (e = ed.dom.getParent(ed.selection.getNode(), 'A')) {
			var match = false;
			var atts = {
					'href': ed.dom.getAttrib(e, 'href'),
					'title': ed.dom.getAttrib(e, 'title'),
					'target': (/window.open\(this.href\);/.test(ed.dom.getAttrib(e, 'onclick')) ? '_blank' : ''),
					'rel': ed.dom.getAttrib(e, 'rel'),
					'class': ed.dom.getAttrib(e, 'class')
			};
		} else {
			atts = null;
		}
		
		init(atts, function(atts) {
			var f = document.forms[0], ed = tinyMCEPopup.editor, e, b;
			
			tinyMCEPopup.restoreSelection();
			e = ed.dom.getParent(ed.selection.getNode(), 'A');

			// Remove element if there is no href
			if (!atts) {
				if (e) {
					tinyMCEPopup.execCommand("mceBeginUndoLevel");
					b = ed.selection.getBookmark();
					ed.dom.remove(e, 1);
					ed.selection.moveToBookmark(b);
					tinyMCEPopup.execCommand("mceEndUndoLevel");
					tinyMCEPopup.close();
				}
				return;
			}
			
			tinyMCEPopup.execCommand("mceBeginUndoLevel");
			
			// Create new anchor elements
			if (e == null) {
				ed.getDoc().execCommand("unlink", false, null);
				tinyMCEPopup.execCommand("CreateLink", false, "#mce_temp_url#", {skip_undo : 1});
	
				tinymce.each(ed.dom.select("a"), function(n) {
					if (ed.dom.getAttrib(n, 'href') == '#mce_temp_url#') {
						e = n;
	
						ed.dom.setAttribs(e, atts);
	
						// PATCH: handle target="_blank"
						LinkDialog.fixIssues(ed, e, f, atts);
					}
				});
			} else {
				ed.dom.setAttribs(e, atts);
	
				// PATCH: handle target="_blank"
				LinkDialog.fixIssues(ed, e, f, atts);
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
		}, function() {
			tinyMCEPopup.close();
		});

		TinyMCE_EditableSelects.init(); // PATCH: initialize editable select
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
};

LinkDialog.preInit();
tinyMCEPopup.onInit.add(LinkDialog.init, LinkDialog);
