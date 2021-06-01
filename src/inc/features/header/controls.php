<?php

if ( ! function_exists( 'aemi_features_controls__header' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_controls__header( $wp_customize ) {
		$wp_customize->add_control(
			'aemi_header_stickyness',
			array(
				'label'       => __( 'Header Stickyness', 'aemi' ),
				'description' => __( 'Choose to keep the header in the view (top or adaptative) while scrolling or not. Adaptative option keeps the header at the bottom of the view on mobile devices.', 'aemi' ),
				'section'     => 'aemi_header',
				'settings'    => 'aemi_header_stickyness',
				'type'        => 'radio',
				'choices'     => array(
					'no'         => __( 'Do not keep in view', 'aemi' ),
					'top'        => __( 'Keep the header to the top of the view', 'aemi' ),
					'adaptative' => __( 'Keep the header more accessible on mobile devices', 'aemi' ),
				),
			)
		);

		$wp_customize->add_control(
			'aemi_header_layout',
			array(
				'label'       => __( 'Header Layout', 'aemi' ),
				'description' => __( 'Decide how the header will be displayed and spread through screen width.', 'aemi' ),
				'section'     => 'aemi_header',
				'settings'    => 'aemi_header_layout',
				'type'        => 'radio',
				'choices'     => array(
					'centered' => __( 'Set the header width to the same width as content', 'aemi' ),
					'wide'     => __( 'Set the header width to a wider width', 'aemi' ),
					'full'     => __( 'Make the header goes full width', 'aemi' ),
				),
			)
		);

		$wp_customize->add_control(
			'aemi_header_autohiding',
			array(
				'label'       => __( 'Header Auto Hiding', 'aemi' ),
				'description' => __( 'Allow header bar to disappear while scrolling down and come back when scroll up occurs. Only works if "Header Stickyness" set to "Top" or "Adaptative".', 'aemi' ),
				'section'     => 'aemi_header',
				'settings'    => 'aemi_header_autohiding',
				'type'        => 'checkbox',
			)
		);
	}
}
