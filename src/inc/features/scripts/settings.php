<?php

if ( ! function_exists( 'aemi_features_settings__scripts' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_settings__scripts( $wp_customize ) {
		$wp_customize->add_setting(
			'aemi_header_js_code',
			array(
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'aemi_raw_js_code',
			)
		);

		$wp_customize->add_setting(
			'aemi_footer_js_code',
			array(
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'aemi_raw_js_code',
			)
		);
	}
}
