<?php
/**
 * Aemi WordPress Theme
 * Page Template
 *
 * @package  aemi.page
 * @author   Guillaume COQUARD <contact@aemi.dev>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GNU Public License 3
 * @link     https://github.com/aemi-dev/aemi-wp/tree/main/src/page.php
 */

get_header();

while ( have_posts() ) {
	the_post();
	do_action( 'aemi_page_before' );
	get_template_part( 'inc/parts/content', 'page' );
	do_action( 'aemi_page_after' );
}

get_footer();
