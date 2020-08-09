<?php

add_action('wp_default_scripts', 'aemi_remove_jquery_migrate');
add_action('edit_category', 'aemi_category_transient_flusher');
add_action('save_post', 'aemi_category_transient_flusher');
add_filter('script_loader_src', 'aemi_remove_script_version', 15, 1);
add_filter('style_loader_src', 'aemi_remove_script_version', 15, 1);
add_filter('script_loader_tag', 'aemi_async_scripts_filter', 10, 2);
add_filter('script_loader_tag', 'aemi_defer_scripts_filter', 10, 2);
add_filter('get_the_archive_title', 'aemi_custom_archive_title');
add_filter('comment_text', 'aemi_filter_comment_text');