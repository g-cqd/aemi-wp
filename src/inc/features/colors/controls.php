<?php

if ( ! function_exists( 'aemi_features_controls__colors' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_controls__colors( $wp_customize ) {
		$wp_customize->add_control(
			new Aemi_Dropdown_Options(
				$wp_customize,
				'aemi_color_scheme',
				array(
					'label'       => __( 'Color Scheme', 'aemi' ),
					'description' => __( 'Choose to display dark or light color scheme or make it switch automatically.', 'aemi' ),
					'section'     => 'aemi_colors',
					'settings'    => 'aemi_color_scheme',
					'choices'     => array(
						'light' => __( 'Light', 'aemi' ),
						'dark'  => __( 'Dark', 'aemi' ),
						'auto'  => __( 'Auto', 'aemi' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			'aemi_color_scheme_user',
			array(
				'label'       => __( 'Color Scheme User Preference', 'aemi' ),
				'description' => __( 'Choose to let user adapt color scheme to its preference.', 'aemi' ),
				'section'     => 'aemi_colors',
				'settings'    => 'aemi_color_scheme_user',
				'type'        => 'checkbox',
			)
		);
	}
}
