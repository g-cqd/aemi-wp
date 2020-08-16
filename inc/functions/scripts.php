<?php


if (!function_exists('aemi_scripts'))
{
	function aemi_scripts()
	{
		// -- Register Styles -- //
		wp_register_style( 'aemi-fonts', get_template_directory_uri() . '/assets/styles/public/fonts.css' );
		wp_register_style( 'aemi-standard', get_template_directory_uri() . '/assets/styles/public/standard.css' );
		wp_register_style( 'aemi-styles', get_stylesheet_uri() );
		wp_register_style( 'aemi-gutenberg', get_template_directory_uri() . '/assets/styles/public/gutenberg.css' );
		// -- Register Scripts -- //
		wp_register_script( 'aemi-index', get_template_directory_uri() . '/assets/scripts/index.js', false, false, false );
		wp_register_script( 'aemi-script', get_template_directory_uri() . '/assets/scripts/aemi.js', false, false, false );
		// -- Enqueue Styles -- //
		wp_enqueue_style( 'aemi-fonts' );
		wp_enqueue_style( 'aemi-standard' );
		wp_enqueue_style( 'aemi-styles' );
		wp_enqueue_style( 'aemi-gutenberg' );
		// -- Enqueue Scripts -- //
		wp_enqueue_script( 'aemi-index' );
		wp_enqueue_script( 'aemi-script' );
		// -- Dequeue Default Styles -- //
		wp_dequeue_style( 'wp-block-library' );
		// -- Defer Scripts -- //
		aemi_defer_scripts([ 'aemi-index', 'aemi-script' ]);
		
		if (
			is_enabled('aemi_display_comments',1) &&
			is_singular() && comments_open() &&
			get_option('thread_comments')
		)
		{
			wp_enqueue_script('comment-reply');
		}

		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && (
				( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false ) ||
				( strpos( $_SERVER['HTTP_USER_AGENT'], 'Trident/7.0' ) !== false )
		) )
		{
			wp_enqueue_style( 'aemi-ie-styles', get_template_directory_uri() . '/assets/styles/public/ie_style.css' );
		}
	}
}

if (!function_exists('aemi_gutenberg_editor_style'))
{
	function aemi_gutenberg_editor_style()
	{
		wp_enqueue_style( 'aemi-gutenberg-style', get_template_directory_uri() . '/assets/styles/admin/guten-style.css' );
	}
}

if (!function_exists('aemi_remove_script_version'))
{
	function aemi_remove_script_version($src)
	{
		$parts = explode('?', $src);
		return $parts[0];
	}
}