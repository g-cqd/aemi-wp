<?php
/**
 * Aemi WordPress Theme
 * Index Page
 *
 * @package  aemi
 * @author   Guillaume COQUARD <contact@aemi.dev>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GNU Public License 3
 * @link     https://github.com/aemi-dev/aemi-wp/tree/main/src/index.php
 */

get_header();

if ( have_posts() ) {
	get_template_part( 'inc/parts/loop' );
} else {
	get_template_part( 'inc/parts/content', 'none' );
}

get_footer();
