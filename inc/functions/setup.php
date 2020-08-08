<?php

if ( ! function_exists( 'aemi_content_width' ) ) {
	function aemi_content_width()
	{
		$GLOBALS['content_width'] = apply_filters( 'aemi_content_width', 1024 );
	}
}

$theme = wp_get_theme( 'aemi' );
$aemi_version = $theme['Version'];

if ( ! function_exists( 'aemi_setup' ) ) {
	function aemi_setup()
	{
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'aemi-large', 1920, 1200, false );
		add_image_size( 'aemi-mid', 800, 500, false );
		add_image_size( 'aemi-small', 400, 250, false );
		add_image_size( 'aemi-logo', 92, 276, false );
		register_nav_menus(
			array(
				'header-menu' => __( 'Header Menu', 'aemi' ),
				'overlay-menu' => __( 'Overlay Menu', 'aemi' ),
				'social-menu' => __( 'Social Menu', 'aemi' ),
				'footer-menu' => __( 'Footer Menu', 'aemi' ),
			)
		);

		add_theme_support( 'html5' );

		add_theme_support(
			'custom-background',
			apply_filters(
				'aemi_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => ''
				)
			)
		);

		add_theme_support( 'custom-header', array(
			'default-image'          => '',
			'width'                  => 2880,
			'height'                 => 172,
			'flex-height'            => true,
			'flex-width'             => true,
			'uploads'                => true,
			'random-default'         => false,
			'header-text'            => false,
			'default-text-color'     => '',
			'wp-head-callback'       => '',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		) );

		add_theme_support( 'site-logo' );

		add_theme_support( 'custom-logo', array(
			'height'      => 92,
			'width'		  => 276,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array(),
		) );

		add_editor_style( array( 'assets/editor-style.css' ) );

		$starter_content = apply_filters( 'aemi_starter_content', array(
			'widgets' => array(
				'header-widget-area' => array(
					'search',
				),
				'footer-widget-area' => array(
					'',
				)
			)
		) );
		add_theme_support( 'starter-content', $starter_content );
	}
}
add_action( 'after_setup_theme', 'aemi_setup' );

/* Avoid WordPress to insert inline styling with galleries */
add_filter( 'use_default_gallery_style', '__return_false' );

function aemi_tagcount_filter ( $variable )
{
	$variable = str_replace( '<span class="tag-link-count"> (', '<span class="tag-link-count">&bull;', $variable );
	$variable = str_replace( ')</span>', '</span>', $variable );
	return $variable;
}
add_filter( 'wp_tag_cloud', 'aemi_tagcount_filter' );


if ( ! function_exists( 'aemi_pingback_header' ) )
{
	function aemi_pingback_header()
	{
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
		}
	}
}
add_action( 'wp_head', 'aemi_pingback_header' );




if ( ! function_exists( 'aemi_widgets_init' ) )
{
	function aemi_widgets_init()
	{
		register_sidebar( array (
			'name' => __( 'Header Widget Area', 'aemi' ),
			'id' => 'header-widget-area',
			'description' => __( 'Add widgets in this area to display them on header area.', 'aemi' ),
			'before_widget' => '<div id="w-%1$s" class="w-cont header-section %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		) );
		register_sidebar( array (
			'name' => __( 'Sidebar Widget Area', 'aemi' ),
			'id' => 'sidebar-widget-area',
			'description' => __( 'Add widgets in this area to display them on sidebar area.', 'aemi' ),
			'before_widget' => '<div id="w-%1$s" class="w-cont %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		) );
		register_sidebar( array (
			'name' => __( 'Footer Widget Area', 'aemi' ),
			'id' => 'footer-widget-area',
			'description' => __( 'Add widgets in this area to display them on footer area.', 'aemi' ),
			'before_widget' => '<div id="w-%1$s" class="w-cont %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		) );
	}
}


if ( ! function_exists( 'aemi_scripts' ) ) {
	function aemi_scripts()
	{
		wp_register_style( 'aemi-fonts', get_template_directory_uri() . '/assets/styles/public/fonts.css' );
		wp_register_style( 'aemi-standard', get_template_directory_uri() . '/assets/styles/public/standard.css' );
		wp_register_style( 'aemi-styles', get_stylesheet_uri() );
		wp_register_style( 'aemi-gutenberg', get_template_directory_uri() . '/assets/styles/public/gutenberg.css' );
		wp_register_script( 'aemi-index', get_template_directory_uri() . '/assets/scripts/index.js', false, false, false );
		wp_register_script( 'aemi-script', get_template_directory_uri() . '/assets/scripts/aemi.js', false, false, false );

		wp_enqueue_style ( 'aemi-fonts' );
		wp_enqueue_style ( 'aemi-standard' );
		wp_enqueue_style ( 'aemi-styles' );
		wp_enqueue_style ( 'aemi-gutenberg' );

		wp_enqueue_script ( 'aemi-index' );
		wp_enqueue_script ( 'aemi-script' );

		aemi_defer_scripts( array(
				'aemi-index',
				'aemi-script',
			)
		);
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}

if ( ! function_exists( 'aemi_ie_scripts') ) {
	function aemi_ie_scripts()
	{
		wp_enqueue_style( 'aemi-ie-style', get_template_directory_uri() . '/assets/styles/admin/ie_style.css' );
	}
}

if ( ! function_exists( 'aemi_gutenberg_editor_style' ) )
{
	function aemi_gutenberg_editor_style()
	{
		wp_enqueue_style( 'aemi-gutenberg-style', get_template_directory_uri() . "/assets/styles/admin/guten-style.css" );
	}
}
add_action('enqueue_block_editor_assets', 'aemi_gutenberg_editor_style');

if ( !function_exists( 'aemi_custom_comment_fields_order' ) ) {
	function aemi_custom_comment_fields_order( $fields ) {
		
		$comment_field = $fields['comment'];
		$author_field = $fields['author'];
		$email_field = $fields['email'];
		$url_field = $fields['url'];

		unset( $fields['comment'] );
		unset( $fields['author'] );
		unset( $fields['email'] );
		unset( $fields['url'] );
		
		$fields['author'] = $author_field;
		$fields['email'] = $email_field;
		$fields['url'] = $url_field;
		$fields['comment'] = $comment_field;
		
		return $fields;
	}
}
add_filter( 'comment_form_fields', 'aemi_custom_comment_fields_order' );

// function aemi_change_comment_date_format(){
// 	return sprintf( _x( '%s ago', '%s = human-readable time difference', 'your-text-domain' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) );
// }

// if ( !function_exists( 'aemi_change_comment_date_format' ) ) {
// 	function aemi_change_comment_date_format( $date, $date_format, $comment ) {
// 		if ('Y/m/d' == $date_format ) {
// 			return date( 'm.d.y', strtotime( $comment->comment_date ) );
// 		  } else {
// 			return date( 'm.d.y', strtotime( $comment->comment_date ) );
// 		  }
// 	}
// }
// add_filter( 'get_comment_date', 'aemi_change_comment_date_format' );
// add_filter( 'get_comment_time', 'aemi_change_comment_date_format' );