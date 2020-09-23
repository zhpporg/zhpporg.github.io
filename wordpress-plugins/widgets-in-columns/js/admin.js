jQuery(function($){
	var file_frame = '';

	$( 'body' ).on( 'click', '.wic-media-upload', function(){
		var thiz = $( this );
		file_frame = wp.media.frames.file_frame = wp.media({
			title: thiz.data( 'uploader-title' ),
			library: {
				type: 'image'
			},
			button: {
				text: thiz.data( 'uploader-button-text' )
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			var attachment = file_frame.state().get('selection').first().toJSON();
			$( thiz.data( 'target' ) ).val( attachment.url );
		});

		// Finally, open the modal
		file_frame.open();
		event.preventDefault();
	} );
});