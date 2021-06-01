<?php

if ( ! function_exists( 'aemi_features_controls__scripts' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_controls__scripts( $wp_customize ) {
		$wp_customize->add_control(
			'aemi_header_js_code',
			array(
				'label'       => __( 'Header JS Script', 'aemi' ),
				'description' => __( 'Add JS scripts to wp-head. No need to add script tag.', 'aemi' ),
				'section'     => 'aemi_scripts',
				'type'        => 'textarea',
			)
		);

		$wp_customize->add_control(
			'aemi_footer_js_code',
			array(
				'label'       => __( 'Footer JS Script', 'aemi' ),
				'description' => __( 'Add JS scripts to wp-footer. No need to add script tag.', 'aemi' ),
				'section'     => 'aemi_scripts',
				'type'        => 'textarea',
			)
		);
	}
}
