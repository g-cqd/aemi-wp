<?php

if ( ! function_exists( 'aemi_content_width' ) ) {
	function aemi_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'aemi_content_width', 1024 );
	}
}

if ( ! function_exists( 'aemi_setup' ) ) {
	/**
	 * Classic setup for a theme
	 */
	function aemi_setup() {
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'aemi-large', 1920, 1200, false );
		add_image_size( 'aemi-fhd', 1920, 1080, false );
		add_image_size( 'aemi-hd', 1280, 720, false );
		add_image_size( 'aemi-mid', 720, 480, false );
		add_image_size( 'aemi-small', 640, 360, false );
		add_image_size( 'aemi-tiny', 320, 240, false );
		add_image_size( 'aemi-thumb', 300, 300, false );
		add_image_size( 'aemi-logo', 92, 276, false );

		register_nav_menus(
			array(
				'header-menu'  => __( 'Header Menu', 'aemi' ),
				'overlay-menu' => __( 'Overlay Menu', 'aemi' ),
				'social-menu'  => __( 'Social Menu', 'aemi' ),
				'footer-menu'  => __( 'Footer Menu', 'aemi' ),
			)
		);

		add_theme_support( 'html5' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'site-logo' );
		add_theme_support( 'custom-line-height' );
		add_theme_support( 'custom-units' );

		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'experimental-link-color' );
		add_theme_support( 'experimental-custom-spacing' );

		add_theme_support( 'editor-styles' );

		add_theme_support(
			'custom-background',
			array(
				'default-color' => '',
			)
		);

		add_theme_support(
			'custom-header',
			array(
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
			)
		);

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 92,
				'width'       => 276,
				'flex-height' => true,
				'flex-width'  => true,
				'header-text' => array(),
			)
		);

		$starter_content = apply_filters(
			'aemi_starter_content',
			array(
				'widgets' => array(
					'header-widget-area' => array( 'search' ),
					'footer-widget-area' => array( '' ),
				),
			)
		);
		add_theme_support( 'starter-content', $starter_content );
	}
}

if ( ! function_exists( 'aemi_header_menu_filter' ) ) {
	/**
	 * @param $items
	 * @param $args
	 * @return mixed
	 */
	function aemi_header_menu_filter( $items, $args ) {
		if ( 'header-menu' === $args->theme_location ) {
			$top_level_links = 0;
			foreach ( $items as $key => $item ) {
				if ( 0 === $item->menu_item_parent ) {
					++$top_level_links;
				}
				if ( $top_level_links > 3 ) {
					unset( $items[ $key ] );
				}
			}
		}
		return $items;
	}
}

if ( ! function_exists( 'aemi_tagcount_filter' ) ) {
	/**
	 * @param $variable
	 * @return mixed
	 */
	function aemi_tagcount_filter( $variable ) {
		$variable = str_replace( '<span class="tag-link-count"> (', '<span class="tag-link-count">&bull;', $variable );
		$variable = str_replace( ')</span>', '</span>', $variable );
		return $variable;
	}
}

if ( ! function_exists( 'aemi_pingback_header' ) ) {
	function aemi_pingback_header() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
		}
	}
}

if ( ! function_exists( 'aemi_widgets_init' ) ) {
	function aemi_widgets_init() {
		register_sidebar(
			array(
				'name'          => __( 'Overlay Widget Area', 'aemi' ),
				'id'            => 'overlay-widget-area',
				'description'   => __( 'Add widgets in this area to display them on overlay area.', 'aemi' ),
				'before_widget' => '<div class="header-block"><div id="widget-%1$s" class="widget-container %2$s">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<strong class="widget-title h4">',
				'after_title'   => '</strong>',
			)
		);
		register_sidebar(
			array(
				'name'          => __( 'Footer Widget Area', 'aemi' ),
				'id'            => 'footer-widget-area',
				'description'   => __( 'Add widgets in this area to display them on footer area.', 'aemi' ),
				'before_widget' => '<div id="widget-%1$s" class="widget-container %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<strong class="widget-title h4">',
				'after_title'   => '</strong>',
			)
		);
	}
}

if ( ! function_exists( 'is_enabled' ) ) {
	/**
	 * @param $mod
	 * @param $default
	 */
	function is_enabled( $mod, $default ) {
		return get_theme_mod( $mod, $default ) === 1;
	}
}
if ( ! function_exists( 'is_disabled' ) ) {
	/**
	 * @param $mod
	 * @param $default
	 */
	function is_disabled( $mod, $default ) {
		return get_theme_mod( $mod, $default ) === 0;
	}
}

function is_menu_active( $location ): bool {
	$has_nav_menu         = false;
	$registered_nav_menus = get_registered_nav_menus();
	if ( isset( $registered_nav_menus[ $location ] ) ) {
		$locations    = get_nav_menu_locations();
		$has_nav_menu = ! empty( $locations[ $location ] );
	}
	return $has_nav_menu;
}

function is_menu_filled( $location ): bool {
	$has_nav_menu         = false;
	$registered_nav_menus = get_registered_nav_menus();
	if ( isset( $registered_nav_menus[ $location ] ) ) {
		$locations    = get_nav_menu_locations();
		$has_nav_menu = ! empty( $locations[ $location ] );
	}

	if ( ! $has_nav_menu ) {
		return false;
	}

	$menu = wp_get_nav_menu_object( $locations[ $location ] );

	if ( isset( $menu->count ) && $menu->count > 0 ) {
		return true;
	}

	return false;
}
