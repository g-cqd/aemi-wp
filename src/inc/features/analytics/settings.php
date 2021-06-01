<?php

if ( ! function_exists( 'aemi_features_settings__analytics' ) ) {
	/**
	 * Add Analytics Panel Settings
	 *
	 * @param wp_customize $wp_customize Customiwer object.
	 */
	function aemi_features_settings__analytics( $wp_customize ) {
		$wp_customize->add_setting(
			'aemi_ga_type',
			array(
				'default'           => 'none',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'aemi_sanitize_dropdown_options',
			)
		);

		aemi_add_settings(
			array(
				array(
					'name'     => 'aemi_bing_meta_tag',
					'type'     => 'checkbox',
					'default'  => 0,
					'critical' => true,
				),
			),
			$wp_customize
		);

		$wp_customize->add_setting(
			'aemi_ga_id',
			array(
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_setting(
			'aemi_bing_meta_tag_content',
			array(
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
	}
}
