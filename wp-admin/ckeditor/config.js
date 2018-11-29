/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'hu';
	config.allowedContent = true;
	config.filebrowserBrowseUrl = '../wp-admin/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '../wp-admin/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = '../wp-admin/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl = '../wp-admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = '../wp-admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = '../wp-admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
	config.extraPlugins = 'youtube';
};
