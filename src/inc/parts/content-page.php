<?php
/**
 * Aemi WordPress Theme
 * Page Content Template
 *
 * @package  aemi.parts.page
 * @author   Guillaume COQUARD <contact@aemi.dev>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GNU Public License 3
 * @link     https://github.com/aemi-dev/aemi-wp/tree/main/src/inc/parts/content-page.php
 */

?>
<?php do_action( 'aemi_entry_before' ); ?>
<?php do_action( 'aemi_page_beforebegin' ); ?>
<article id="entry-<?php the_ID(); ?>" <?php post_class( array( 'entry' ) ); ?> >
	<?php do_action( 'aemi_page_afterbegin' ); ?>
	<?php do_action( 'aemi_page' ); ?>
	<?php do_action( 'aemi_page_beforeend' ); ?>
</article>
<?php do_action( 'aemi_page_afterend' ); ?>
<?php do_action( 'aemi_entry_after' ); ?>
