<?php



/*
 * Hooks from ./setup.php
 */
add_action('after_setup_theme', 'aemi_setup');
add_filter('wp_nav_menu_objects', 'aemi_header_menu_filter', 10, 2);
/* Avoid WordPress to insert inline styling with galleries */
add_filter('use_default_gallery_style', '__return_false');
add_filter('wp_tag_cloud', 'aemi_tagcount_filter');
// add_action( 'wp_head', 'aemi_pingback_header' );
add_action('enqueue_block_editor_assets', 'aemi_gutenberg_editor_style');

add_filter('comment_form_fields', 'aemi_custom_comment_fields_order');
add_filter('comment_text', 'aemi_filter_comment_text');

add_action('customize_register', 'aemi_load_customize_controls', 0);

if (get_theme_mod('aemi_display_comments',1)==0)
{
	aemi_remove_comments();
}

/*
 * Hooks from ./extra.php
 */
$jquery = get_theme_mod('aemi_remove_jquery_migrate','all');
if ($jquery != 'keep')
{
	if ($jquery == 'all')
	{
		add_action('wp_enqueue_scripts', 'aemi_remove_jquery');
	}
	else {
		add_action('wp_default_scripts', 'aemi_remove_jquery_migrate');
	}
}

add_action('edit_category', 'aemi_category_transient_flusher');
add_action('save_post', 'aemi_category_transient_flusher');

if (get_theme_mod('aemi_remove_script_version',0) == 1)
{
	add_filter('script_loader_src', 'aemi_remove_script_version', 15, 1);
	add_filter('style_loader_src', 'aemi_remove_script_version', 15, 1);
}

add_filter('script_loader_tag', 'aemi_async_scripts_filter', 10, 2);
add_filter('script_loader_tag', 'aemi_defer_scripts_filter', 10, 2);

add_filter('get_the_archive_title', 'aemi_custom_archive_title');

if (get_theme_mod('aemi_enable_svg_support',0) == 1)
{
	add_filter('upload_mimes', 'aemi_add_svg_support', 99);
	add_filter('wp_check_filetype_and_ext', 'aemi_svg_upload_check', 10, 4);
	add_filter('wp_check_filetype_and_ext', 'aemi_svg_allow_svg_upload', 10, 4);
}
if (get_theme_mod('aemi_remove_emojis',0) == 1)
{
	add_action('init', 'aemi_remove_emojis');
}
if (get_theme_mod('aemi_remove_wpembeds',0) == 1)
{
	add_action('init', 'aemi_remove_wpembeds', 9999);
	add_action('wp_footer', 'aemi_deregister_wpembed');
}
if (get_theme_mod('aemi_remove_generator',0) == 1)
{
	remove_action('wp_head', 'wp_generator');
}
if (get_theme_mod('aemi_remove_rsd_link',1) == 1)
{
	remove_action ('wp_head', 'rsd_link');
}
if (get_theme_mod('aemi_remove_wlwmanifest_link',1) == 1)
{
	remove_action ('wp_head', 'wlwmanifest_link');
}
if (get_theme_mod('aemi_remove_shortlink',1) == 1)
{
	remove_action('wp_head', 'wp_shortlink_wp_head');
	remove_action('template_redirect', 'wp_shortlink_header', 11);
}

$apiworg = get_theme_mod('aemi_remove_apiworg','non-admins');
if (
	$apiworg == 'all' ||
	($apiworg == 'non-admins' && !current_user_can('administrator')) ||
	($apiworg == 'public' && !is_user_logged_in())
)
{
	remove_action('wp_head', 'rest_output_link_wp_head', 10);
	remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
	remove_action('template_redirect', 'rest_output_link_header', 11, 0);
}

if (get_theme_mod('aemi_add_expire_headers',0) == 1)
{
	add_action('admin_init', 'aemi_add_expire_headers_true');
}
else
{
	add_action('admin_init', 'aemi_add_expire_headers_false');
}