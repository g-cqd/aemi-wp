<?php
/**
 * Aemi WordPress Theme
 * Single Content Template
 *
 * @package  aemi.parts.single
 * @author   Guillaume COQUARD <contact@aemi.dev>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GNU Public License 3
 * @link     https://github.com/aemi-dev/aemi-wp/tree/main/src/inc/parts/content-single.php
 */

?>
<?php do_action( 'aemi_entry_before' ); ?>
<?php do_action( 'aemi_single_beforebegin' ); ?>
<article id="entry-<?php the_ID(); ?>" <?php post_class( array( 'entry' ) ); ?> >
	<?php do_action( 'aemi_single_afterbegin' ); ?>
	<?php do_action( 'aemi_single' ); ?>
	<?php do_action( 'aemi_single_beforeend' ); ?>
</article>
<?php do_action( 'aemi_single_afterend' ); ?>
<?php do_action( 'aemi_entry_after' ); ?>
