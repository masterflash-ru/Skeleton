// Remove default value in table dialog for width (which is 500 by default).

CKEDITOR.plugins.add( 'mytable', {
});

CKEDITOR.on( 'dialogDefinition', function( ev ) {
  // Take the dialog name and its definition from the event data.
  var dialogName = ev.data.name;
  var dialogDefinition = ev.data.definition;

  // Check if the definition is from the dialog we're
  // interested on (the "Table" dialog).
  if ( dialogName == 'table' ) {
    // Get a reference to the "Table Info" tab.
    var infoTab = dialogDefinition.getContents( 'info' );
         txtWidth = infoTab.get( 'txtWidth' );
         txtWidth['default'] = '100%';
		 
	var t=infoTab.get( "txtBorder" );
		 t['default'] = '';
  }
});