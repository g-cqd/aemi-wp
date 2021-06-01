<?php

$classes = array( 'entry' );

if ( is_sticky() ) {
	$classes[] = 'sticky';
}

?>
<?php do_action( 'aemi_entry_before' ); ?>
<?php do_action( 'aemi_loop_entry_beforebegin' ); ?>
<article id="entry-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<?php do_action( 'aemi_loop_entry_afterbegin' ); ?>
	<?php do_action( 'aemi_loop_entry' ); ?>
	<?php do_action( 'aemi_loop_entry_beforeend' ); ?>
</article>
<?php do_action( 'aemi_loop_entry_afterend' ); ?>
<?php do_action( 'aemi_entry_before' ); ?>
