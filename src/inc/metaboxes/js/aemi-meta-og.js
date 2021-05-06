jQuery( document ).ready( function() {
	var CustomPluginMediaUploader = {
		construct:function(){
			jQuery('.aemi_meta_og_media_button' ).each(function( index ) {
				CustomPluginMediaUploader.initButton(jQuery(this));
			});
		},
		initButton:function(_that){
			_that.click(function(e){
				var metaImageFrame;
				var btn = e.target;

				if ( !btn || !jQuery( btn ).attr( 'data-custom-plugin-media-uploader-target' ) ) {
					return;
				}


				var field = jQuery( btn ).data( 'custom-plugin-media-uploader-target' );

				e.preventDefault();

				metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
					button: { text:  'Use this file' },
				});


				metaImageFrame.on('select', function() {

					var media_attachment = metaImageFrame.state().get('selection').first().toJSON();

					jQuery( field ).val(media_attachment.url);

				});

				metaImageFrame.open();
			});
		}
	};
	CustomPluginMediaUploader.construct();
});