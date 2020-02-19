<?php get_header(); ?>
<?php
if ( have_posts() ) {
	get_template_part( 'loop' );
}
else {
	get_template_part( 'inc/parts/content', 'none' );
}
?>
<?php get_footer(); ?>