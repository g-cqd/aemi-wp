<?php

/**
 * General
 * @see aemi_content_width()
 * @see aemi_setup()
 * @see aemi_widgets_init()
 * @see aemi_scripts()
 */
add_action( 'after_setup_theme', 'aemi_content_width', 0 );
add_action( 'after_setup_theme', 'aemi_setup' );
add_action( 'widgets_init', 'aemi_widgets_init' );
add_action( 'wp_enqueue_scripts', 'aemi_scripts', 10 );

/**
 * Head
 * @see aemi_ga_script()
 */
add_action( 'aemi_head', 'aemi_ga_script', 10 );
add_action( 'aemi_head', 'aemi_bing_meta_tag', 20 );


/**
 * Header
 * @see aemi_header_menu()
 * @see aemi_header_branding()
 * @see aemi_header_search()
 */
add_action( 'aemi_header', 'aemi_header_branding', 10 );
add_action( 'aemi_header', 'aemi_header_menu', 20 );
add_action( 'aemi_header', 'aemi_overlay_menu', 30 );
add_action( 'aemi_header', 'aemi_header_search', 40 );

/**
 * Aside
 * @see aemi_aside_wrapper_menu()
 * @see aemi_aside_search()
 * @see aemi_aside_progress_bar()
 */
add_action( 'aemi_aside', 'aemi_aside_wrapper_menu', 30 );
add_action( 'aemi_aside', 'aemi_aside_search', 30 );
add_action( 'aemi_aside', 'aemi_aside_progress_bar', 40 );

/**
 * Footer
 * @see aemi_sidebar_widgets()
 * @see aemi_footer_widgets()
 * @see aemi_footer_site_description()
 * @see aemi_footer_menu()
 * @see aemi_footer_credit()
 * @see aemi_footer_wp_footer()
 */
add_action( 'aemi_footer_before', 'aemi_sidebar_widgets', 10 );
add_action( 'aemi_footer', 'aemi_footer_widgets', 10 );
add_action( 'aemi_footer', 'aemi_footer_site_description', 20 );
add_action( 'aemi_footer', 'aemi_footer_menu', 30 );
add_action( 'aemi_footer', 'aemi_footer_credit', 40 );
add_action( 'aemi_footer_after', 'aemi_footer_wp_footer', 10 );

/**
 * Posts
 * @see aemi_post_header()
 * @see aemi_post_content()
 * @see aemi_post_excerpt()
 * @see aemi_posts_pagination()
 * @see aemi_post_navigation()
 */
add_action( 'aemi_loop_post', 'aemi_post_header', 10 );
add_action( 'aemi_loop_after','aemi_posts_pagination', 10 );
add_action( 'aemi_single_post', 'aemi_post_header', 10 );
add_action( 'aemi_single_post', 'aemi_post_content', 20 );
add_action( 'aemi_single_post_after', 'aemi_post_meta_footer', 10 );
add_action( 'aemi_single_post_after', 'aemi_post_navigation', 30 );

/**
 * Pages
 * @see aemi_page_header()
 * @see aemi_page_content()
 */
add_action( 'aemi_page', 'aemi_page_header', 10 );
add_action( 'aemi_page', 'aemi_page_content',	20 );
add_action( 'aemi_page_after', 'aemi_post_meta_footer', 10 );


// Display comments
if (get_theme_mod('aemi_display_comments',1)==1)
{
	add_action( 'aemi_single_post_after', 'aemi_display_comments', 20 );
	add_action( 'aemi_page_after', 'aemi_display_comments', 20 );
}

/**
 * Extras
 * @see aemi_body_classes()
 */
add_filter( 'body_class', 'aemi_body_classes' );
