<?php

if ( ! function_exists( 'aemi_page_header_info' ) ) {
	function aemi_page_header_info() {
		?>
		<?php do_action( 'aemi_page_header_info_beforebegin' ); ?>
		<div class="post-info">
			<?php do_action( 'aemi_page_header_info_afterbegin' ); ?>
			<?php the_title( '<h1 class="post-title">', '</h1>' ); ?>
			<?php do_action( 'aemi_page_header_info_beforebegin' ); ?>
		</div>
		<?php do_action( 'aemi_page_header_info_afterend' ); ?>
		<?php
	}
}


if ( ! function_exists( 'aemi_page_header' ) ) {
	function aemi_page_header() {
		if ( ! is_front_page() ) {
			?>
			<?php do_action( 'aemi_page_header_beforebegin' ); ?>
		<header <?php aemi_get_entry_header_classes(); ?>>
			<?php do_action( 'aemi_page_header_afterbegin' ); ?>
			<?php do_action( 'aemi_page_header_inner' ); ?>
			<?php do_action( 'aemi_page_header_beforeend' ); ?>
		</header>
			<?php do_action( 'aemi_page_header_afterend' ); ?>
			<?php
		}
	}
}


if ( ! function_exists( 'aemi_page_content' ) ) {
	function aemi_page_content() {
		?>
		<?php do_action( 'aemi_page_content_beforebegin' ); ?>
		<main class="post-content">
			<?php do_action( 'aemi_page_content_afterbegin' ); ?>
			<?php do_action( 'aemi_page_content_inner' ); ?>
			<?php do_action( 'aemi_page_content_beforeend' ); ?>
		</main>
		<?php do_action( 'aemi_page_content_afterend' ); ?>
		<?php
	}
}

if ( ! function_exists( 'aemi_page_footer' ) ) {
	function aemi_page_footer() {
		?>
		<?php do_action( 'aemi_page_footer_beforebegin' ); ?>
	<footer class="post-footer">
		<?php do_action( 'aemi_page_footer_afterbegin' ); ?>
		<?php do_action( 'aemi_page_footer_inner' ); ?>
		<?php do_action( 'aemi_page_footer_beforeend' ); ?>
	</footer>
		<?php do_action( 'aemi_page_footer_afterend' ); ?>
		<?php
	}
}
