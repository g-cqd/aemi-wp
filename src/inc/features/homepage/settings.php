<?php

if ( ! function_exists( 'aemi_features_settings__homepage' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_settings__homepage( $wp_customize ) {

		aemi_add_settings(
			array(
				array(
					'name'    => 'aemi_homepage_header',
					'type'    => 'checkbox',
					'default' => 0,
				),
			),
			$wp_customize
		);

		$wp_customize->add_setting(
			'aemi_homepage_before',
			array(
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'aemi_sanitize_dropdown_pages',
			)
		);

		$wp_customize->add_setting(
			'aemi_homepage_after',
			array(
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'aemi_sanitize_dropdown_pages',
			)
		);

		$wp_customize->add_setting(
			'aemi_homepage_header_custom_title',
			array(
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_textarea_field',
			)
		);
		$wp_customize->add_setting(
			'aemi_homepage_header_custom_subtitle',
			array(
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_textarea_field',
			)
		);

	}
}
