<?php

if ( ! function_exists( 'aemi_features_controls__search' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_controls__search( $wp_customize ) {
		$wp_customize->add_control(
			'aemi_search_button_display',
			array(
				'label'       => __( 'Search Button', 'aemi' ),
				'description' => __( 'Display a search button on right side of header bar.', 'aemi' ),
				'section'     => 'aemi_search',
				'settings'    => 'aemi_search_button_display',
				'type'        => 'checkbox',
			)
		);
	}
}
