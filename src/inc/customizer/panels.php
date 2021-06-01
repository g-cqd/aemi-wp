<?php

if ( ! function_exists( 'aemi_customizer_panels' ) ) {
	/**
	 * Add Aemi Theme Customizer Panels
	 *
	 * @param wp_customize $wp_customize Customizer object.
	 */
	function aemi_customizer_panels( $wp_customize ) {

		$wp_customize->add_panel(
			'aemi_panel',
			array(
				'priority'    => 0,
				'capability'  => 'edit_theme_options',
				'title'       => __( 'Aemi', 'aemi' ),
				'description' => __( 'Customize Aemi Settings and Features', 'aemi' ),
			)
		);

		$wp_customize->add_section(
			'aemi_analytics',
			array(
				'panel' => 'aemi_panel',
				'title' => __( 'Analytics', 'aemi' ),
			)
		);

		$wp_customize->add_section(
			'aemi_colors',
			array(
				'panel' => 'aemi_panel',
				'title' => __( 'Colors', 'aemi' ),
			)
		);

		$wp_customize->add_section(
			'aemi_loop',
			array(
				'panel' => 'aemi_panel',
				'title' => __( 'Content Loop', 'aemi' ),
			)
		);

		$wp_customize->add_section(
			'aemi_header',
			array(
				'panel' => 'aemi_panel',
				'title' => __( 'Header', 'aemi' ),
			)
		);

		$wp_customize->add_section(
			'aemi_homepage',
			array(
				'panel' => 'aemi_panel',
				'title' => __( 'Homepage', 'aemi' ),
			)
		);

		$wp_customize->add_section(
			'aemi_identity',
			array(
				'panel' => 'aemi_panel',
				'title' => __( 'Identity', 'aemi' ),
			)
		);

		$wp_customize->add_section(
			'aemi_layout',
			array(
				'panel' => 'aemi_panel',
				'title' => __( 'Layout', 'aemi' ),
			)
		);

		$wp_customize->add_section(
			'aemi_scripts',
			array(
				'panel' => 'aemi_panel',
				'title' => __( 'Scripts', 'aemi' ),
			)
		);

		$wp_customize->add_section(
			'aemi_search',
			array(
				'panel' => 'aemi_panel',
				'title' => __( 'Search', 'aemi' ),
			)
		);

		$wp_customize->add_section(
			'aemi_seo',
			array(
				'panel' => 'aemi_panel',
				'title' => __( 'SEO', 'aemi' ),
			)
		);

		$wp_customize->add_section(
			'aemi_widgets',
			array(
				'panel' => 'aemi_panel',
				'title' => __( 'Widgets', 'aemi' ),
			)
		);

		foreach ( get_post_types( array( 'public' => true ), 'objects' ) as $post_type ) {
			$post_name = $post_type->name;

			$wp_customize->add_section(
				( 'aemi_type_' . $post_name ),
				array(
					'panel' => 'aemi_panel',
					'title' => __( 'Type', 'aemi' ) . ': ' . $post_type->label,
				)
			);
		}
	}
}
