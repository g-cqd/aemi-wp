<?php
/**
 * Aemi WordPress Theme
 * Search Page Template
 *
 * @package  aemi.search
 * @author   Guillaume COQUARD <contact@aemi.dev>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GNU Public License 3
 * @link     https://github.com/aemi-dev/aemi-wp/tree/main/src/search.php
 */

get_header();

$query    = get_search_query();
$is_empty = empty( $query );

if ( have_posts() ) {
	?>
<article id="entry-head" class="entry">
	<header class="post-header">
		<div class="post-info">
			<h1 class="post-title">
				<?php
				if ( $is_empty ) {
					echo esc_html__( 'What are you looking for?', 'aemi' );
				} else {
					echo esc_html( $query );
				}
				?>
			</h1>
			<div class="archive-details search">
			<?php
			if ( $is_empty ) {
				esc_html_e( 'Is looking for "anything" useful?', 'aemi' );
			} else {
				esc_html_e( 'Search Results', 'aemi' );
			}
			?>
			</div>
		</div>
	</header>
	<?php
	if ( $is_empty ) {
		aemi_only_search_content();
		?>
</article>
		<?php
	} else {
		?>
</article>
		<?php
		get_template_part( 'inc/parts/loop' );
	}
} else {
		get_template_part( 'inc/parts/content', 'none' );
}

get_footer();
