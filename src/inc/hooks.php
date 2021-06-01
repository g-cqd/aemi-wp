<?php
/**
 * Aemi WordPress Theme
 * Hooks
 *
 * @package  aemi.hooks
 * @author   Guillaume COQUARD <contact@aemi.dev>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GNU Public License 3
 * @link     https://github.com/aemi-dev/aemi-wp/tree/main/src/inc/structure/hooks.php
 */

/**
 * Aemi Customizer -- Custom Controls
 */
add_action( 'customize_register', 'aemi_load_customize_controls', 0 );

/**
 * Aemi Customizer -- Add Panels
 */
add_action( 'customize_register', 'aemi_customizer_panels' );

/**
 * Aemi Customizer -- Add Settings
 */
add_action( 'customize_register', 'aemi_features_settings__analytics' );
add_action( 'customize_register', 'aemi_features_settings__colors' );
add_action( 'customize_register', 'aemi_features_settings__content_loop' );
add_action( 'customize_register', 'aemi_features_settings__generic_types' );
add_action( 'customize_register', 'aemi_features_settings__header' );
add_action( 'customize_register', 'aemi_features_settings__homepage' );
add_action( 'customize_register', 'aemi_features_settings__identity' );
add_action( 'customize_register', 'aemi_features_settings__layout' );
add_action( 'customize_register', 'aemi_features_settings__scripts' );
add_action( 'customize_register', 'aemi_features_settings__search' );
add_action( 'customize_register', 'aemi_features_settings__seo' );
add_action( 'customize_register', 'aemi_features_settings__widgets' );

/**
 * Aemi Customizer -- Add Controls
 */
add_action( 'customize_register', 'aemi_features_controls__analytics' );
add_action( 'customize_register', 'aemi_features_controls__colors' );
add_action( 'customize_register', 'aemi_features_controls__content_loop' );
add_action( 'customize_register', 'aemi_features_controls__generic_types' );
add_action( 'customize_register', 'aemi_features_controls__header' );
add_action( 'customize_register', 'aemi_features_controls__homepage' );
add_action( 'customize_register', 'aemi_features_controls__identity' );
add_action( 'customize_register', 'aemi_features_controls__layout' );
add_action( 'customize_register', 'aemi_features_controls__scripts' );
add_action( 'customize_register', 'aemi_features_controls__search' );
add_action( 'customize_register', 'aemi_features_controls__seo' );
add_action( 'customize_register', 'aemi_features_controls__widgets' );

/**
 * General
 */
add_action( 'after_setup_theme', 'aemi_setup', 0 );
add_action( 'after_setup_theme', 'aemi_content_width', 10 );

add_action( 'widgets_init', 'aemi_widgets_init' );
add_action( 'widget_init', 'aemi_custom_rss_init' );

add_filter( 'aemi_preload_script', 'aemi_default_preload_script', 0 );
add_filter( 'aemi_preload_style', 'aemi_default_preload_style', 0 );
add_filter( 'aemi_preload_domain', 'aemi_default_preload_domain', 0 );
add_filter( 'aemi_preload_font', 'aemi_default_preload_font', 0 );

/**
 * Site Head
 */
add_action( 'aemi_head', 'aemi_bing_meta_tag', 10 );
add_action( 'aemi_head', 'aemi_pingback_header', 20 );
add_action( 'wp_head', 'aemi_preprocess_resources', 1 );

/**
 * Scripts
 */
add_action( 'wp_enqueue_scripts', 'aemi_scripts', 10 );
add_action( 'wp_enqueue_scripts', 'aemi_ga_script', 20 );
add_action( 'wp_enqueue_scripts', 'aemi_header_script', 30 );
add_action( 'wp_enqueue_scripts', 'aemi_footer_script', 40 );

add_filter( 'script_loader_tag', 'aemi_async_scripts_filter', 10, 2 );
add_filter( 'script_loader_tag', 'aemi_defer_scripts_filter', 10, 2 );
add_filter( 'script_loader_tag', 'aemi_module_scripts_filter', 10, 2 );

/**
 * Style
 */
add_filter( 'body_class', 'aemi_body_classes' );
add_filter( 'use_default_gallery_style', '__return_false' );
add_filter( 'wp_tag_cloud', 'aemi_tagcount_filter' );
add_action( 'edit_category', 'aemi_category_transient_flusher' );
add_action( 'save_post', 'aemi_category_transient_flusher' );
add_action( 'enqueue_block_editor_assets', 'aemi_gutenberg_editor_style' );
add_filter( 'document_title_parts', 'aemi_title_parts' );
add_filter( 'document_title_separator', 'aemi_title_separator' );

/**
 * Site Header
 */
add_filter( 'wp_nav_menu_objects', 'aemi_header_menu_filter', 10, 2 );
add_filter( 'aemi_site_header_classes_filter', 'aemi_site_header_colorscheme', 0 );

add_action( 'aemi_header', 'aemi_skip_content', 10 );
add_action( 'aemi_header', 'aemi_header_branding', 20 );
add_action( 'aemi_header', 'aemi_header_menu', 30 );
add_action( 'aemi_header', 'aemi_overlay_menu', 40 );
add_action( 'aemi_header', 'aemi_header_search', 50 );

/**
 * Site Content
 */
add_action( 'aemi_content_beforebegin', 'aemi_homepage_header', 0 );
add_action( 'aemi_content_beforebegin', 'aemi_before_main_content', 20 );
add_action( 'aemi_content_afterend', 'aemi_after_main_content' );

/**
 * Site Aside Menu
 */
add_action( 'aemi_aside', 'aemi_aside_wrapper_menu', 30 );
add_action( 'aemi_aside', 'aemi_aside_search', 30 );
add_action( 'aemi_aside', 'aemi_aside_progress_bar', 40 );

/**
 * Site Footer
 */
add_action( 'aemi_footer', 'aemi_footer_widgets', 10 );
add_action( 'aemi_footer', 'aemi_footer_site_description', 20 );
add_action( 'aemi_footer', 'aemi_footer_menu', 30 );
add_action( 'aemi_footer', 'aemi_footer_credit', 40 );
add_action( 'aemi_footer_afterend', 'aemi_footer_wp_footer', 10 );


/**
 * Entries
 */
add_filter( 'aemi_entry_header_classes_filter', 'aemi_thumbnails_display', 0 );
add_filter( 'aemi_entry_header_classes_filter', 'aemi_entry_header_colorscheme', 10 );


/**
 * No Entry
 */

add_action( 'aemi_none_header_inner', 'aemi_none_header_info', 0 );

add_action( 'aemi_none', 'aemi_none_header', 10 );
add_action( 'aemi_none', 'aemi_only_search_content', 20 );



/**
 * Page
 */
add_action( 'aemi_page_header_info_afterbegin', 'aemi_info_dates', 0 );
add_action( 'aemi_page_header_info_beforeend', 'aemi_info_author', 10 );

add_action( 'aemi_page_header_inner', 'aemi_featured_image', 0 );
add_action( 'aemi_page_header_inner', 'aemi_page_header_info', 10 );
add_action( 'aemi_page_header_inner', 'aemi_meta_header', 20 );

add_action( 'aemi_page_content_inner', 'the_content', 0 );
add_action( 'aemi_page_content_inner', 'aemi_page_navigation', 10 );

add_action( 'aemi_page', 'aemi_page_header', 10 );
add_action( 'aemi_page', 'aemi_page_content', 20 );
add_action( 'aemi_page', 'aemi_page_footer', 30 );

/**
 * Single Post
 */
add_action( 'aemi_single_header_info_afterbegin', 'aemi_info_dates', 0 );
add_action( 'aemi_single_header_info_beforeend', 'aemi_info_author', 10 );

add_action( 'aemi_single_header_inner', 'aemi_featured_image', 0 );
add_action( 'aemi_single_header_inner', 'aemi_single_header_info', 10 );
add_action( 'aemi_single_header_inner', 'aemi_meta_header', 20 );

add_action( 'aemi_single_content_inner', 'the_content', 0 );
add_action( 'aemi_single_content_inner', 'aemi_page_navigation', 10 );

add_action( 'aemi_single_footer_inner', 'aemi_post_meta_footer', 0 );
add_action( 'aemi_single_footer_inner', 'aemi_post_navigation', 10 );

add_action( 'aemi_single', 'aemi_single_header', 10 );
add_action( 'aemi_single', 'aemi_single_content', 20 );
add_action( 'aemi_single', 'aemi_single_footer', 30 );

/**
 * Loop
 */
add_action( 'aemi_loop_afterend', 'aemi_posts_pagination', 10 );
add_action( 'pre_get_posts', 'aemi_loop_filtering' );

/**
 * Loop Entries
 */
add_action( 'aemi_loop_entry', 'aemi_single_header', 10 );

/**
 * Comments
 */
add_action( 'aemi_single_after', 'aemi_display_comments', 20 );
add_action( 'aemi_page_after', 'aemi_display_comments', 20 );
add_filter( 'comment_form_fields', 'aemi_custom_comment_fields_order' );
add_filter( 'comment_text', 'aemi_filter_comment_text' );

/**
 * Archive
 */
add_filter( 'get_the_archive_title', 'aemi_get_the_archive_title' );
