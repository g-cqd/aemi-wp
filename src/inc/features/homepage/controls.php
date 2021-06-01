<?php

if ( ! function_exists( 'aemi_features_controls__homepage' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_controls__homepage( $wp_customize ) {
		$wp_customize->add_control(
			'aemi_homepage_before',
			array(
				'type'        => 'dropdown-pages',
				'settings'    => 'aemi_homepage_before',
				'section'     => 'aemi_homepage',
				'label'       => __( 'Homepage - Before Main Content', 'aemi' ),
				'description' => __( 'Use this to add content before the main content of homepage. Another page can be integrated before blog post listing or before front page content for example.', 'aemi' ),
			)
		);

		$wp_customize->add_control(
			'aemi_homepage_after',
			array(
				'type'        => 'dropdown-pages',
				'settings'    => 'aemi_homepage_after',
				'section'     => 'aemi_homepage',
				'label'       => __( 'Homepage - After Main Content', 'aemi' ),
				'description' => __( 'Use this to add content after the main content of homepage. Another page can be integrated after blog post listing or after front page content.', 'aemi' ),
			)
		);

		$wp_customize->add_control(
			'aemi_homepage_header',
			array(
				'label'       => __( 'Add a Page-Like Header to Homepage', 'aemi' ),
				'description' => __( 'Add a custom page-like header to your homepage to make it more user-friendly and search-engine-friendly.', 'aemi' ),
				'section'     => 'aemi_homepage',
				'settings'    => 'aemi_homepage_header',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_control(
			'aemi_homepage_header_custom_title',
			array(
				'label'       => __( 'Customize Homepage Displayed Title', 'aemi' ),
				'description' => __( 'Set a custom title for your homepage.', 'aemi' ),
				'section'     => 'aemi_homepage',
				'settings'    => 'aemi_homepage_header_custom_title',
				'type'        => 'textarea',
			)
		);
		$wp_customize->add_control(
			'aemi_homepage_header_custom_subtitle',
			array(
				'label'       => __( 'Customize Homepage Subtitle', 'aemi' ),
				'description' => __( 'Set a custom subtitle for your homepage', 'aemi' ),
				'section'     => 'aemi_homepage',
				'settings'    => 'aemi_homepage_header_custom_subtitle',
				'type'        => 'textarea',
			)
		);
	}
}
