<?php

if ( ! function_exists( 'aemi_features_settings__identity' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_settings__identity( $wp_customize ) {
		$wp_customize->add_setting(
			'aemi_light_scheme_logo',
			array(
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_setting(
			'aemi_dark_scheme_logo',
			array(
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_setting(
			'aemi_site_description',
			array(
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_textarea_field',
			)
		);
	}
}
