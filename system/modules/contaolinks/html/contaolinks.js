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
	else if ($('anchor_tab').hasClass('current'))
	{
		atts.href = '{{env::request}}#' + f.anchor.value;
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
		else if (match = atts.href.match(/^(\{\{env::request\}\})?#/))
		{
			f.anchor.value = atts.href.substring(match[0].length);
			displayTab('anchor_tab','anchor_panel');
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
	f.pageTree.addEvent('toggle', function(node, state) {
		new Request({
			url: 'system/modules/contaolinks/pages.php'
		}).get({ pid: node.property.pageId, state: state ? 'opened' : 'closed' });
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