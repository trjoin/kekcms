/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	config.language = 'hu';
	config.allowedContent = true;
	config.extraPlugins = 'imageresize';
	config.extraPlugins = 'syntaxhighlight';
	config.extraPlugins = 'youtube';
	config.youtube_width = '100%';
	config.youtube_responsive = true;
	
	config.filebrowserBrowseUrl = '../wp-admin/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '../wp-admin/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = '../wp-admin/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl = '../wp-admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = '../wp-admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = '../wp-admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};

CKEDITOR.on( 'dialogDefinition', function( ev )
{
  var dialogName = ev.data.name;
  var dialogDefinition = ev.data.definition;
  
  if ( dialogName == 'link' || dialogName == 'image' )
  {
	 // remove Upload tab
	 dialogDefinition.removeContents( 'Upload' );
  }
});
