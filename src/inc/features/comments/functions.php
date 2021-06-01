<?php

if ( ! function_exists( 'aemi_custom_comment_fields_order' ) ) {
	/**
	 * @param $fields
	 * @return mixed
	 */
	function aemi_custom_comment_fields_order( $fields ) {

		$new_fields = array();

		$types = array( 'author', 'email', 'url', 'comment' );

		foreach ( $types as $type ) {
			$new_fields[ $type ] = $fields[ $type ];
			unset( $fields[ $type ] );
		}

		foreach ( $types as $type ) {
			$fields[ $type ] = $new_fields[ $type ];
		}

		return $fields;
	}
}

if ( ! function_exists( 'aemi_disable_comment_post_types_support' ) ) {
	function aemi_disable_comment_post_types_support() {
		$post_types = get_post_types();
		foreach ( $post_types as $post_type ) {
			if ( post_type_supports( $post_type, 'comments' ) ) {
				remove_post_type_support( $post_type, 'comments' );
				remove_post_type_support( $post_type, 'trackbacks' );
			}
		}
	}
}

if ( ! function_exists( 'aemi_remove_recent_comments_style' ) ) {
	function aemi_remove_recent_comments_style() {
		global $wp_widget_factory;
		remove_action(
			'wp_head',
			array(
				$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
				'recent_comments_style',
			)
		);
	}
}

if ( ! function_exists( 'aemi_remove_comments' ) ) {
	function aemi_remove_comments() {
		global $pagenow;

		if ( 'edit-comments.php' === $pagenow ) {
			wp_safe_redirect( admin_url() );
			exit;
		}
		
		add_action(
			'init',
			function () {
				if ( is_admin_bar_showing() ) {
					remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
				}
			}
		);
		add_action( 'admin_init', 'aemi_disable_comment_post_types_support' );
		add_filter( 'comments_open', '__return_false', 20, 2 );
		add_filter( 'pings_open', '__return_false', 20, 2 );
		add_filter( 'comments_array', '__return_empty_array', 10, 2 );
		add_action(
			'admin_menu',
			function () {
				remove_menu_page( 'edit-comments.php' );
			}
		);
		add_action(
			'wp_before_admin_bar_render',
			function () {
				global $wp_admin_bar;
				$wp_admin_bar->remove_menu( 'comments' );
			}
		);
		add_action( 'widgets_init', 'aemi_remove_recent_comments_style' );
	}
}

if ( ! function_exists( 'aemi_separate_comments' ) ) {
	function aemi_separate_comments() {

		$comment_args = array(
			'order'   => 'ASC',
			'orderby' => 'comment_date_gmt',
			'status'  => 'approve',
			'post_id' => get_the_ID(),
		);

		$comments = get_comments( $comment_args );

		return separate_comments( $comments );
	}
}

if ( ! function_exists( 'aemi_display_comments' ) ) {
	function aemi_display_comments() {
		if (
			isset( $_SERVER['SCRIPT_FILENAME'] ) &&
			'comments.' === basename( wp_unslash( $_SERVER['SCRIPT_FILENAME'] ) )
		) {
			return;
		}
		if ( comments_open() || '0' !== get_comments_number() ) {
			comments_template( '/comments.php' );
		}
	}
}

if ( ! function_exists( 'aemi_filter_comment_text' ) ) {
	/**
	 * @param $comment
	 */
	function aemi_filter_comment_text( $comment ) {
		$allowed_html = array(
			'a'       => array(
				'href'  => array(),
				'title' => array(),
			),
			'br'      => array(),
			'em'      => array(),
			'i'       => array(),
			'strong'  => array(),
			'b'       => array(),
			'del'     => array(),
			's'       => array(),
			'u'       => array(),
			'pre'     => array(),
			'code'    => array(),
			'kbd'     => array(),
			'big'     => array(),
			'small'   => array(),
			'acronym' => array(),
			'abbr'    => array(),
			'ins'     => array(),
			'sup'     => array(),
			'sub'     => array(),
			'ol'      => array(),
			'ul'      => array(),
			'li'      => array(),
		);
		return wp_kses( $comment, $allowed_html );
	}
}
