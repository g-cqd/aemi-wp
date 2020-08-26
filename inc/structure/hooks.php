<?php


// -- Register Aemi Customizer -- Controls -- //
add_action( 'customize_register', 			'aemi_load_customize_controls', 0 );
// -- Register Aemi Customizer -- Panel -- //
add_action( 'customize_register', 			'aemi_customizer_panels' );
// -- Register Aemi Customizer -- Settings -- //
add_action( 'customize_register',			'aemi_customizer_settings__analytics' );
add_action( 'customize_register',			'aemi_customizer_settings__colors' );
add_action( 'customize_register',			'aemi_customizer_settings__comments' );
add_action( 'customize_register',			'aemi_customizer_settings__content_loop' );
add_action( 'customize_register',			'aemi_customizer_settings__custom_scripts' );
add_action( 'customize_register',			'aemi_customizer_settings__header' );
add_action( 'customize_register',			'aemi_customizer_settings__homepage' );
add_action( 'customize_register',			'aemi_customizer_settings__identity' );
add_action( 'customize_register',			'aemi_customizer_settings__performance' );
add_action( 'customize_register',			'aemi_customizer_settings__post' );
add_action( 'customize_register',			'aemi_customizer_settings__post_types' );
add_action( 'customize_register',			'aemi_customizer_settings__search' );
add_action( 'customize_register',			'aemi_customizer_settings__security' );
add_action( 'customize_register',			'aemi_customizer_settings__seo' );
add_action( 'customize_register',			'aemi_customizer_settings__widgets' );
// -- Register Aemi Customizer -- Controls -- //
add_action( 'customize_register', 			'aemi_customizer_controls__analytics' );
add_action( 'customize_register', 			'aemi_customizer_controls__colors' );
add_action( 'customize_register', 			'aemi_customizer_controls__comments' );
add_action( 'customize_register', 			'aemi_customizer_controls__content_loop' );
add_action( 'customize_register', 			'aemi_customizer_controls__custom_scripts' );
add_action( 'customize_register', 			'aemi_customizer_controls__header' );
add_action( 'customize_register', 			'aemi_customizer_controls__homepage' );
add_action( 'customize_register', 			'aemi_customizer_controls__identity' );
add_action( 'customize_register', 			'aemi_customizer_controls__performance' );
add_action( 'customize_register', 			'aemi_customizer_controls__post' );
add_action( 'customize_register', 			'aemi_customizer_controls__post_types' );
add_action( 'customize_register', 			'aemi_customizer_controls__search' );
add_action( 'customize_register', 			'aemi_customizer_controls__security' );
add_action( 'customize_register', 			'aemi_customizer_controls__seo' );
add_action( 'customize_register', 			'aemi_customizer_controls__widgets' );

// -- General -- //
add_action( 'admin_init',					'aemi_update_htaccess_rules' );
add_action( 'init',							'aemi_remove_emojis' );
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


// -- Comments -- //
if (is_enabled('aemi_display_comments', 1))
{
	add_action( 'aemi_single_post_after',	'aemi_display_comments', 20 );
	add_action( 'aemi_page_after',			'aemi_display_comments', 20 );
	add_filter( 'comment_form_fields',		'aemi_custom_comment_fields_order' );
	add_filter( 'comment_text',				'aemi_filter_comment_text' );
}
else
{
	aemi_remove_comments();
}
if (is_enabled('aemi_remove_recent_comments_style',0))
{
	add_action('widgets_init',				'aemi_remove_recent_comments_style');
}

// -- External Resource Load -- //
$jquery = get_theme_mod('aemi_remove_jquery_migrate', 'all');
if ($jquery != 'keep')
{
	if ($jquery == 'all')
	{
		add_action('wp_enqueue_scripts',	'aemi_remove_jquery');
	}
	else {
		add_action('wp_default_scripts',	'aemi_remove_jquery_migrate');
	}
}

if (is_enabled('aemi_remove_script_version', 0))
{
	add_filter('script_loader_src',			'aemi_remove_script_version', 15, 1);
	add_filter('style_loader_src',			'aemi_remove_script_version', 15, 1);
}

if (is_enabled('aemi_enable_svg_support', 0))
{
	add_filter( 'upload_mimes',					'aemi_add_svg_support', 99 );
	add_filter( 'wp_check_filetype_and_ext',	'aemi_svg_upload_check', 10, 4 );
	add_filter( 'wp_check_filetype_and_ext',	'aemi_svg_allow_svg_upload', 10, 4 );
}

if (is_enabled('aemi_remove_wpembeds',0))
{
	add_action('init',							'aemi_remove_wpembeds', 9999 );
	add_action('wp_footer',						'aemi_deregister_wpembed' );
}
if (is_enabled('aemi_remove_generator',0))
{
	remove_action('wp_head',					'wp_generator');
}
if (is_enabled('aemi_remove_rsd_link',1))
{
	remove_action('wp_head',					'rsd_link');
}
if (is_enabled('aemi_remove_wlwmanifest_link',1))
{
	remove_action('wp_head',					'wlwmanifest_link');
}
if (is_enabled('aemi_remove_shortlink',1))
{
	remove_action('wp_head',					'wp_shortlink_wp_head');
	remove_action('template_redirect',			'wp_shortlink_header', 11);
}

$apiworg = get_theme_mod('aemi_remove_apiworg','non-admins');
if (
	$apiworg == 'all' ||
	($apiworg == 'non-admins' && !current_user_can('administrator')) ||
	($apiworg == 'public' && !is_user_logged_in())
)
{
	remove_action('wp_head',					'rest_output_link_wp_head', 10);
	remove_action('wp_head',					'wp_oembed_add_discovery_links', 10);
	remove_action('template_redirect',			'rest_output_link_header', 11, 0);
}

if ( is_enabled('aemi_loop_cat_filtering', 0) || is_enabled('aemi_loop_add_types', 0) )
{
	add_action( 'pre_get_posts',				'aemi_loop_filtering' );
}