<?php

if ( ! function_exists( 'aemi_features_settings__search' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_settings__search( $wp_customize ) {
		aemi_add_settings(
			array(
				array(
					'name'    => 'aemi_search_button_display',
					'type'    => 'checkbox',
					'default' => 0,
				),
			),
			$wp_customize
		);
	}
}
