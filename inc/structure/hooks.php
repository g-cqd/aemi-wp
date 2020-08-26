<?php


// -- Register Aemi Customizer -- Controls -- //
add_action( 'customize_register', 			'aemi_load_customize_controls', 0 );
// -- Register Aemi Customizer -- Panel -- //
add_action( 'customize_register', 			'aemi_customizer_panels' );
// -- Register Aemi Customizer -- Settings -- //
add_action( 'customize_register',			'aemi_customizer_settings__analytics' );
add_action( 'customize_register',			'aemi_customizer_settings__colors' );
add_action( 'customize_register',			'aemi_customizer_settings__content_loop' );
add_action( 'customize_register',			'aemi_customizer_settings__custom_scripts' );
add_action( 'customize_register',			'aemi_customizer_settings__header' );
add_action( 'customize_register',			'aemi_customizer_settings__homepage' );
add_action( 'customize_register',			'aemi_customizer_settings__identity' );
add_action( 'customize_register',			'aemi_customizer_settings__post_types' );
add_action( 'customize_register',			'aemi_customizer_settings__search' );
add_action( 'customize_register',			'aemi_customizer_settings__seo' );
add_action( 'customize_register',			'aemi_customizer_settings__widgets' );
// -- Register Aemi Customizer -- Controls -- //
add_action( 'customize_register', 			'aemi_customizer_controls__analytics' );
add_action( 'customize_register', 			'aemi_customizer_controls__colors' );
add_action( 'customize_register', 			'aemi_customizer_controls__content_loop' );
add_action( 'customize_register', 			'aemi_customizer_controls__custom_scripts' );
add_action( 'customize_register', 			'aemi_customizer_controls__header' );
add_action( 'customize_register', 			'aemi_customizer_controls__homepage' );
add_action( 'customize_register', 			'aemi_customizer_controls__identity' );
add_action( 'customize_register', 			'aemi_customizer_controls__post_types' );
add_action( 'customize_register', 			'aemi_customizer_controls__search' );
add_action( 'customize_register', 			'aemi_customizer_controls__seo' );
add_action( 'customize_register', 			'aemi_customizer_controls__widgets' );

// -- General -- //
add_action( 'after_setup_theme',			'aemi_content_width', 0 );
add_action( 'after_setup_theme',			'aemi_setup' );
add_action( 'widgets_init',					'aemi_widgets_init' );
add_action( 'wp_enqueue_scripts',			'aemi_scripts', 10 );
add_filter( 'script_loader_tag',			'aemi_async_scripts_filter', 10, 2);
add_filter( 'script_loader_tag',			'aemi_defer_scripts_filter', 10, 2);
add_filter( 'body_class',					'aemi_body_classes' );
add_filter( 'use_default_gallery_style',	'__return_false' );
add_filter( 'wp_tag_cloud',					'aemi_tagcount_filter' );
add_action( 'edit_category',				'aemi_category_transient_flusher' );
add_action( 'save_post',					'aemi_category_transient_flusher' );
add_action( 'enqueue_block_editor_assets',	'aemi_gutenberg_editor_style' );
add_filter( 'document_title_parts',			'aemi_title_parts' );
add_filter( 'document_title_separator',		'aemi_title_separator' );
add_action( 'widget_init',					'aemi_custom_rss_init' );

// -- Head -- //
add_action( 'aemi_head', 					'aemi_ga_script', 10 );
add_action( 'aemi_head', 					'aemi_bing_meta_tag', 20 );
add_action( 'aemi_head',					'aemi_pingback_header' );

// -- Header -- //
add_filter( 'wp_nav_menu_objects',			'aemi_header_menu_filter', 10, 2 );
add_action( 'aemi_header', 					'aemi_header_branding', 10 );
add_action( 'aemi_header', 					'aemi_header_menu', 20 );
add_action( 'aemi_header', 					'aemi_overlay_menu', 30 );
add_action( 'aemi_header', 					'aemi_header_search', 40 );

add_action( 'aemi_content_before',			'aemi_homepage_header', 0 );
add_action( 'aemi_content_before',			'aemi_before_main_content', 20 );
add_action( 'aemi_content_after',			'aemi_after_main_content' );

// -- Aside -- //
add_action( 'aemi_aside', 					'aemi_aside_wrapper_menu', 30 );
add_action( 'aemi_aside', 					'aemi_aside_search', 30 );
add_action( 'aemi_aside', 					'aemi_aside_progress_bar', 40 );

// -- Footer -- //
add_action( 'aemi_footer', 					'aemi_footer_widgets', 10 );
add_action( 'aemi_footer', 					'aemi_footer_site_description', 20 );
add_action( 'aemi_footer', 					'aemi_footer_menu', 30 );
add_action( 'aemi_footer', 					'aemi_footer_credit', 40 );
add_action( 'aemi_footer_after',			'aemi_footer_wp_footer', 10 );

// -- Posts -- //
add_action( 'aemi_loop_post',				'aemi_post_header', 10 );
add_action( 'aemi_loop_after',				'aemi_posts_pagination', 10 );
add_action( 'aemi_single_post', 			'aemi_post_header', 10 );
add_action( 'aemi_single_post', 			'aemi_post_content', 20 );
add_action( 'aemi_single_post_after', 		'aemi_post_meta_footer', 10 );
add_action( 'aemi_single_post_after', 		'aemi_post_navigation', 30 );

// -- Pages -- //
add_action( 'aemi_page', 					'aemi_page_header', 10 );
add_action( 'aemi_page', 					'aemi_page_content',	20 );
add_action( 'aemi_page_after',				'aemi_post_meta_footer', 10 );

// -- Archive -- //
add_filter( 'get_the_archive_title',		'aemi_get_the_archive_title' );


if ( is_enabled('aemi_loop_cat_filtering', 0) || is_enabled('aemi_loop_add_types', 0) )
{
	add_action( 'pre_get_posts',				'aemi_loop_filtering' );
}