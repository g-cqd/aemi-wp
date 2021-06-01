jQuery( document ).ready( function() {
	const CustomPluginMediaUploader = {
		construct: function() {
			jQuery('.aemi_meta_twitter_media_button' ).each( function() {
				CustomPluginMediaUploader.initButton( jQuery( this ) );
			} );
		},
		initButton: function( _that ){
			_that.click( function( e ){
				let metaImageFrame;
				const btn = e.target;

				if ( !btn || !jQuery( btn ).attr( 'data-custom-plugin-media-uploader-target' ) ) {
					return;
				}


				const field = jQuery( btn ).data( 'custom-plugin-media-uploader-target' );

				e.preventDefault();

				metaImageFrame = wp.media.frames.metaImageFrame = wp.media( {
					button: { text:  'Use this file' },
				} );


				metaImageFrame.on( 'select', function() {

					const media_attachment = metaImageFrame.state().get( 'selection' ).first().toJSON();

					jQuery( field ).val( media_attachment.url );

				} );

				metaImageFrame.open();
			} );
		}
	};
	CustomPluginMediaUploader.construct();
} );
