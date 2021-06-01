<?php

if ( ! function_exists( 'aemi_none_header_info' ) ) {
	function aemi_none_header_info() {
		?>
		<?php do_action( 'aemi_none_header_info_beforebegin' ); ?>
<div class="post-info">
		<?php do_action( 'aemi_none_header_info_afterbegin' ); ?>
	<h1 class="post-title">
		<?php esc_html_e( 'Nothing Found', 'aemi' ); ?>
	</h1>
	<div class="archive-details not-found">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) {
			printf(
				wp_kses(
					__( 'Ready to publish your first post?', 'aemi' ) .
					'<a href="%1$s">' . __( 'Get started here', 'aemi' ) . '</a>.',
					array(
						'a' => array(
							'href' => array(),
						),
					)
				),
				esc_url( admin_url( 'post-new.php' ) )
			);
		} elseif ( is_search() ) {
			esc_html_e( 'Sorry, nothing matched your search. Please try again.', 'aemi' );
		} else {
			esc_html_e( 'Nothing found for the requested page. Try a search instead?', 'aemi' );
		}
		?>
	</div>
		<?php do_action( 'aemi_none_header_info_beforeend' ); ?>
</div>
		<?php do_action( 'aemi_none_header_info_afterend' ); ?>
		<?php
	}
}

if ( ! function_exists( 'aemi_none_header' ) ) {
	function aemi_none_header() {
		?>
		<?php do_action( 'aemi_none_header_beforebegin' ); ?>
	<header class="post-header">
		<?php do_action( 'aemi_none_header_afterbegin' ); ?>
		<?php do_action( 'aemi_none_header_inner' ); ?>
		<?php do_action( 'aemi_none_header_beforeend' ); ?>
	</header>
		<?php do_action( 'aemi_none_header_afterend' ); ?>
		<?php
	}
}

?>
