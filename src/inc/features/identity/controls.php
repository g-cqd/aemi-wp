<?php


if ( ! function_exists( 'aemi_features_controls__identity' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_controls__identity( $wp_customize ) {
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'aemi_light_scheme_logo',
				array(
					'label'       => __( 'Add Light for Light Scheme', 'aemi' ),
					'description' => __( 'It is recommanded to set up this setting. If used, it replaces native logo setting.', 'aemi' ),
					'settings'    => 'aemi_light_scheme_logo',
					'section'     => 'aemi_identity',
					'mime_type'   => 'image',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'aemi_dark_scheme_logo',
				array(
					'label'       => __( 'Add Logo for Dark Scheme', 'aemi' ),
					'description' => __( 'It is recommanded to set up this setting.', 'aemi' ),
					'settings'    => 'aemi_dark_scheme_logo',
					'section'     => 'aemi_identity',
					'mime_type'   => 'image',
				)
			)
		);

		$wp_customize->add_control(
			'aemi_site_description',
			array(
				'label'       => __( 'Site Description', 'aemi' ),
				'description' => __( 'Site Description differs from Tagline. Site description can be used in meta tags and by search engines.', 'aemi' ),
				'settings'    => 'aemi_site_description',
				'section'     => 'aemi_identity',
				'type'        => 'textarea',
				'input_attrs' => array(
					'placeholder' => esc_attr__( 'Description should not exceed 180 characters.', 'aemi' ),
				),
			)
		);
	}
}
