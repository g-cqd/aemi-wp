<?php
/**
 * Aemi WordPress Theme
 * Loop Content Template
 *
 * @package  aemi.parts.loop
 * @author   Guillaume COQUARD <contact@aemi.dev>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GNU Public License 3
 * @link     https://github.com/aemi-dev/aemi-wp/tree/main/src/inc/parts/loop.php
 */

$layout      = get_theme_mod( 'aemi_post_layout', 'cover' );
$sticky_span = preg_replace( '/_/', '-', get_theme_mod( 'aemi_post_sticky_width', 'span_full' ) );
$width       = preg_replace( '/_/', '-', get_theme_mod( 'aemi_post_width', 'default_width' ) );
$columns     = preg_replace( '/_/', '-', get_theme_mod( 'aemi_post_column_layout', 'two_columns' ) );

$no_img_class = preg_match( '/no_img/', $layout ) ? 'no-img' : '';
$img_behav    = preg_match( '/cover/', $layout ) ? 'cover' : '';

?>
<?php do_action( 'aemi_loop_beforebegin' ); ?>
<div id="site-loop" class="site-loop <?php echo esc_attr( "$sticky_span $no_img_class $img_behav $width $columns" ); ?>">
<?php do_action( 'aemi_loop_afterbegin' ); ?>
<?php

while ( have_posts() ) {
	the_post();
	get_template_part( 'inc/parts/content', get_post_format() );
}

?>
<?php do_action( 'aemi_loop_beforeend' ); ?>
</div>
<?php do_action( 'aemi_loop_afterend' ); ?>
