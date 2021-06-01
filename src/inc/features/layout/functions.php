<?php

if ( ! function_exists( 'aemi_thumbnails_display' ) ) {
	function aemi_thumbnails_display( $classes = array() ) {
		$classes[] = get_theme_mod( 'aemi_thumbnails_display', 'covered' ) . '-layout';
		return $classes;
	}
}
