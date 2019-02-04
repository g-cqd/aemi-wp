<?php get_header(); ?>

<article id="post-lead" class="post">
	<div class="post-header">
		<div class="post-info">
			<?php
			echo get_the_archive_title();
			the_archive_description( '<div class="archive-details">', '</div>' );
			?>
		</div>
	</div>
</article>

<?php
if ( have_posts() )
{
	get_template_part( 'loop' );
}
else
{
	get_template_part( 'inc/parts/content', 'none' );
}
get_footer();
?>
