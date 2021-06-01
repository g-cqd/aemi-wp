<?php
/**
 * Aemi WordPress Theme
 * Archive Page Template
 *
 * @package  aemi.archive
 * @author   Guillaume COQUARD <contact@aemi.dev>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GNU Public License 3
 * @link     https://github.com/aemi-dev/aemi-wp/tree/main/src/archive.php
 */

get_header();

?>
<article id="entry-head" class="entry">
	<header class="post-header">
		<div class="post-info">
			<?php echo get_the_archive_title(); ?>
			<?php the_archive_description( '<div class="archive-details">', '</div>' ); ?>
		</div>
	</header>
</article>
<?php

if ( have_posts() ) {
	get_template_part( 'inc/parts/loop' );
} else {
	get_template_part( 'inc/parts/content', 'none' );
}

get_footer();

?>
