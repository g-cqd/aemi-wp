<?php
/**
 * Aemi WordPress Theme
 * Single Page Template
 *
 * @package  aemi.single
 * @author   Guillaume COQUARD <contact@aemi.dev>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GNU Public License 3
 * @link     https://github.com/aemi-dev/aemi-wp/tree/main/src/single.php
 */

get_header();

while ( have_posts() ) {
	the_post();
	do_action( 'aemi_single_before' );
	get_template_part( 'inc/parts/content', 'single' );
	do_action( 'aemi_single_after' );
}

get_footer();
