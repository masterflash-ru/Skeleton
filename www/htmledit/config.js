/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.skin = 'office2013';
	
	config.extraPlugins = 'html5video,lineutils,widget,uploadimage,uploadwidget,filetools,notificationaggregator,notification,toolbar,floatpanel,panel,panelbutton,button,quicktable,youtube,mytable';

	/*config.toolbar = [
        { name: 'others', items: [ 'Youtube' ] },
    ]*/ 
config.height =600;
config.allowedContent = true;
config.removeButtons = 'Save,Print,Iframe,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Font,FontSize';

config.qtWidth="100%";
config.qtBorder="0";

 config.filebrowserBrowseUrl = '/htmledit/plugins/ckfinder/ckfinder.html';
   config.filebrowserImageBrowseUrl = '/htmledit/plugins/ckfinder/ckfinder.html?type=Images';
   config.filebrowserFlashBrowseUrl = '/htmledit/plugins/ckfinder/ckfinder.html?type=Flash';
   config.filebrowserUploadUrl = '/htmledit/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
   config.filebrowserImageUploadUrl = '/htmledit/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
   config.filebrowserFlashUploadUrl = '/htmledit/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

};
