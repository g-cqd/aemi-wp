<?php get_header();

while ( have_posts() ) {

	the_post();

	do_action( 'aemi_page_before' );

	get_template_part( 'inc/parts/content', 'page' );

}

get_footer(); ?>
