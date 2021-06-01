<?php

if ( ! function_exists( 'aemi_features_settings__colors' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_settings__colors( $wp_customize ) {
		$wp_customize->add_setting(
			'aemi_color_scheme',
			array(
				'default'           => 'auto',
				'sanitize_callback' => 'aemi_sanitize_dropdown_options',
			)
		);

		aemi_add_settings(
			array(
				array(
					'name'    => 'aemi_color_scheme_user',
					'type'    => 'checkbox',
					'default' => 0,
				),
			),
			$wp_customize
		);
	}
}
