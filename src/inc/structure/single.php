<?php

if ( ! function_exists( 'aemi_single_header_info' ) ) {
	function aemi_single_header_info() {
		?>
		<?php do_action( 'aemi_single_header_info_beforebegin' ); ?>
		<?php

		$is_singular = is_singular();

		if ( $is_singular ) {
			?>
	<div class="post-info">
			<?php
		} else {
			?>
	<a class="post-info" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
			<?php
		}
		?>
		<?php do_action( 'aemi_single_header_info_afterbegin' ); ?>
		<?php

		/** Title */
		if ( $is_singular ) {
			the_title( '<h1 class="post-title">', '</h1>' );
		} else {
			the_title( '<h2 class="post-title">', '</h2>' );
		}

		?>
		<?php do_action( 'aemi_single_header_info_beforeend' ); ?>
		<?php
		if ( $is_singular ) {
			?>
	</div>
			<?php
		} else {
			?>
	</a>
			<?php
		}
		?>
		<?php do_action( 'aemi_single_header_info_afterend' ); ?>
		<?php
	}
}

if ( ! function_exists( 'aemi_single_header' ) ) {
	function aemi_single_header() {
		?>
		<?php do_action( 'aemi_single_header_beforebegin' ); ?>
	<header <?php aemi_get_entry_header_classes(); ?>>
		<?php do_action( 'aemi_single_header_afterbegin' ); ?>
		<?php do_action( 'aemi_single_header_inner' ); ?>
		<?php do_action( 'aemi_single_header_beforeend' ); ?>
	</header>
		<?php do_action( 'aemi_single_header_afterend' ); ?>
		<?php
	}
}

if ( ! function_exists( 'aemi_single_content' ) ) {
	function aemi_single_content() {
		?>
		<?php do_action( 'aemi_single_content_beforebegin' ); ?>
	<main class="post-content">
		<?php do_action( 'aemi_single_content_afterbegin' ); ?>
		<?php do_action( 'aemi_single_content_inner' ); ?>
		<?php do_action( 'aemi_single_content_beforeend' ); ?>
	</main>
		<?php do_action( 'aemi_single_content_afterend' ); ?>
		<?php
	}
}

if ( ! function_exists( 'aemi_single_footer' ) ) {
	function aemi_single_footer() {
		?>
		<?php do_action( 'aemi_single_footer_beforebegin' ); ?>
	<footer class="post-footer">
		<?php do_action( 'aemi_single_footer_afterbegin' ); ?>
		<?php do_action( 'aemi_single_footer_inner' ); ?>
		<?php do_action( 'aemi_single_footer_beforeend' ); ?>
	</footer>
		<?php do_action( 'aemi_single_footer_afterend' ); ?>
		<?php
	}
}
