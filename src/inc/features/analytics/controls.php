<?php

if ( ! function_exists( 'aemi_features_controls__analytics' ) ) {
	/**
	 * Add Analytics Panel Controls
	 *
	 * @param wp_customize $wp_customize Customizer object.
	 */
	function aemi_features_controls__analytics( $wp_customize ) {
		$wp_customize->add_control(
			'aemi_ga_id',
			array(
				'label'       => __( 'Google Analytics ID', 'aemi' ),
				'description' => __( 'Enter your Google Analytics ID to set up Google Analytics on this website.', 'aemi' ),
				'section'     => 'aemi_analytics',
				'settings'    => 'aemi_ga_id',
				'type'        => 'input',
			)
		);

		$wp_customize->add_control(
			new Aemi_Dropdown_Options(
				$wp_customize,
				'aemi_ga_type',
				array(
					'label'       => __( 'Google Analytics Method', 'aemi' ),
					'description' => __( 'Choose the method to set up Google Analytics. If "gtag.js" or "analytics.js" is selected, please fill your Google Analytics ID.', 'aemi' ),
					'section'     => 'aemi_analytics',
					'settings'    => 'aemi_ga_type',
					'choices'     => array(
						'none'      => __( 'None', 'aemi' ),
						'gtag'      => __( 'gtag.js', 'aemi' ),
						'analytics' => __( 'analytics.js', 'aemi' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			'aemi_bing_meta_tag',
			array(
				'label'       => __( 'Enable Bing Meta Tag', 'aemi' ),
				'description' => __( 'Enable this feature to be able to set up Bing Webmaster Tools on this website.', 'aemi' ),
				'section'     => 'aemi_analytics',
				'settings'    => 'aemi_bing_meta_tag',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_control(
			'aemi_bing_meta_tag_content',
			array(
				'label'       => __( 'Bing Meta Tag', 'aemi' ),
				'description' => __( 'Enter your Bing Meta Tag to set up Bing Webmaster Tools on this website.', 'aemi' ),
				'section'     => 'aemi_analytics',
				'settings'    => 'aemi_bing_meta_tag_content',
				'type'        => 'input',
			)
		);
	}
}
