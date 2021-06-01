<?php

if ( ! function_exists( 'aemi_ga_script' ) ) {
	function aemi_ga_script() {
		$ga_id = get_theme_mod( 'aemi_ga_id', '' );
		$type  = get_theme_mod( 'aemi_ga_type', 'none' );

		if ( '' !== $ga_id && 'none' !== $type ) {
			switch ( $type ) {
				case 'gtag':
					aemi_register_script(
						'aemi-gtm',
						"https://www.googletagmanager.com/gtag/js?id=$ga_id"
					);
					aemi_enqueue_script( 'aemi-gtm', array( 'async' ) );
					wp_add_inline_script(
						'aemi-gtm',
						'window.dataLayer=window.dataLayer||[];' .
						'function gtag(){dataLayer.push(arguments);}' .
						"gtag('js',new Date);" .
						"gtag('config','$ga_id');",
						'after'
					);
					break;
				case 'analytics':
					aemi_register_script(
						'aemi-ga',
						'https://www.google-analytics.com/analytics.js'
					);
					aemi_enqueue_script( 'aemi-ga', array( 'async' ) );
					wp_add_inline_script(
						'aemi-ga',
						'window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;' .
						"ga('create','$ga_id', 'auto' );" .
						"ga('send','pageview');",
						'before'
					);
					break;
				default:
					break;
			}
		}
	}
}

if ( ! function_exists( 'aemi_bing_meta_tag' ) ) {
	function aemi_bing_meta_tag() {
		$bing_content = get_theme_mod( 'aemi_bing_meta_tag_content', '' );
		if ( is_enabled( 'aemi_bing_meta_tag', 0 ) && '' !== $bing_content ) {
?>
			<meta name="msvalidate.01" content="<?php echo esc_attr( $bing_content ); ?>" />
			<?php
		}
	}
}
