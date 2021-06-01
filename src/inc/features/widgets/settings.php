<?php

if ( ! function_exists( 'aemi_features_settings__widgets' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_settings__widgets( $wp_customize ) {
		$wp_customize->add_setting(
			'aemi_widget_overlay_column_layout',
			array(
				'default'           => 'one_column',
				'sanitize_callback' => 'aemi_sanitize_dropdown_options',
			)
		);

		$wp_customize->add_setting(
			'aemi_widget_overlay_width',
			array(
				'default'           => 'default_width',
				'sanitize_callback' => 'aemi_sanitize_dropdown_options',
			)
		);

		$wp_customize->add_setting(
			'aemi_widget_footer_column_layout',
			array(
				'default'           => 'one_column',
				'sanitize_callback' => 'aemi_sanitize_dropdown_options',
			)
		);

		$wp_customize->add_setting(
			'aemi_widget_footer_width',
			array(
				'default'           => 'default_width',
				'sanitize_callback' => 'aemi_sanitize_dropdown_options',
			)
		);
	}
}
