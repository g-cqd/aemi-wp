<?php

if ( ! function_exists( 'aemi_features_settings__seo' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_settings__seo( $wp_customize ) {

		aemi_add_settings(
			array(
				array(
					'name'    => 'aemi_add_meta_tags',
					'type'    => 'checkbox',
					'default' => 0,
				),
				array(
					'name'    => 'aemi_add_meta_og',
					'type'    => 'checkbox',
					'default' => 0,
				),
				array(
					'name'    => 'aemi_add_meta_twitter',
					'type'    => 'checkbox',
					'default' => 0,
				),
			),
			$wp_customize
		);

		$wp_customize->add_setting(
			'aemi_meta_twitter_card',
			array(
				'default'           => 'summary',
				'sanitize_callback' => 'aemi_sanitize_dropdown_options',
			)
		);

		$wp_customize->add_setting(
			'aemi_meta_twitter_site',
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_setting(
			'aemi_meta_twitter_creator',
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
	}
}
