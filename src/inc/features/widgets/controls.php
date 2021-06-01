<?php

if ( ! function_exists( 'aemi_features_controls__widgets' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_controls__widgets( $wp_customize ) {
		$wp_customize->add_control(
			new Aemi_Dropdown_Options(
				$wp_customize,
				'aemi_widget_footer_width',
				array(
					'label'       => __( 'Footer Widget Area Width', 'aemi' ),
					'description' => __( 'Change footer widget area width.', 'aemi' ),
					'section'     => 'aemi_widgets',
					'settings'    => 'aemi_widget_footer_width',
					'choices'     => array(
						'default_width' => __( 'Default Width', 'aemi' ),
						'wider_width'   => __( 'Wider Width', 'aemi' ),
						'near_width'    => __( 'Near Full Width', 'aemi' ),
						'full_width'    => __( 'Full Width', 'aemi' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new Aemi_Dropdown_Options(
				$wp_customize,
				'aemi_widget_footer_column_layout',
				array(
					'label'       => __( 'Footer Widget Area Column Layout', 'aemi' ),
					'description' => __( 'Choose maximum number of column for footer widget area.', 'aemi' ),
					'section'     => 'aemi_widgets',
					'settings'    => 'aemi_widget_footer_column_layout',
					'choices'     => array(
						'one_column'    => __( 'Single Column', 'aemi' ),
						'two_columns'   => __( 'Two Columns', 'aemi' ),
						'three_columns' => __( 'Three Columns', 'aemi' ),
						'four_columns'  => __( 'Four Columns', 'aemi' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new Aemi_Dropdown_Options(
				$wp_customize,
				'aemi_widget_overlay_width',
				array(
					'label'       => __( 'Overlay Widget Area Width', 'aemi' ),
					'description' => __( 'Change Overlay Widget Area Width.', 'aemi' ),
					'section'     => 'aemi_widgets',
					'settings'    => 'aemi_widget_overlay_width',
					'choices'     => array(
						'default_width' => __( 'Default Width', 'aemi' ),
						'wider_width'   => __( 'Wider Width', 'aemi' ),
						'near_width'    => __( 'Near Full Width', 'aemi' ),
						'full_width'    => __( 'Full Width', 'aemi' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new Aemi_Dropdown_Options(
				$wp_customize,
				'aemi_widget_overlay_column_layout',
				array(
					'label'       => __( 'Overlay Widget Area Column Layout', 'aemi' ),
					'description' => __( 'Choose maximum number of column for overlay widget area.', 'aemi' ),
					'section'     => 'aemi_widgets',
					'settings'    => 'aemi_widget_overlay_column_layout',
					'choices'     => array(
						'one_column'    => __( 'Single Column', 'aemi' ),
						'two_columns'   => __( 'Two Columns', 'aemi' ),
						'three_columns' => __( 'Three Columns', 'aemi' ),
						'four_columns'  => __( 'Four Columns', 'aemi' ),
					),
				)
			)
		);
	}
}
