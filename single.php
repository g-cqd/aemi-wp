<?php get_header(); ?>
<?php
while (have_posts()) {
    the_post();
    do_action('aemi_single_post_before');
    get_template_part('inc/parts/content', 'single');
} ?>
<?php get_footer();
