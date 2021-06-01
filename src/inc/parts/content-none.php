<?php
/**
 * Aemi WordPress Theme
 * No Entry Content Template
 *
 * @package  aemi.parts.none
 * @author   Guillaume COQUARD <contact@aemi.dev>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GNU Public License 3
 * @link     https://github.com/aemi-dev/aemi-wp/tree/main/src/inc/parts/content-none.php
 */

?>
<?php do_action( 'aemi_entry_before' ); ?>
<?php do_action( 'aemi_none_beforebegin' ); ?>
<article id="entry-head" class="entry post no-results not-found">
	<?php do_action( 'aemi_none_afterbegin' ); ?>
	<?php do_action( 'aemi_none' ); ?>
	<?php do_action( 'aemi_none_beforeend' ); ?>
</article>
<?php do_action( 'aemi_none_afterend' ); ?>
<?php do_action( 'aemi_entry_after' ); ?>
