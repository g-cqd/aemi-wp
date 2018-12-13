<?php do_action( 'aemi_loop_before' );

while ( have_posts() ) {

	the_post();

	get_template_part( 'inc/parts/content', get_post_format() );

}

do_action( 'aemi_loop_after' );
