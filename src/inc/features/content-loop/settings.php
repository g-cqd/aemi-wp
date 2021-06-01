<?php

if ( ! function_exists( 'aemi_features_settings__content_loop' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_settings__content_loop( $wp_customize ) {

		$wp_customize->add_setting(
			'aemi_post_layout',
			array(
				'default'           => 'cover',
				'sanitize_callback' => 'aemi_sanitize_dropdown_options',
			)
		);

		$wp_customize->add_setting(
			'aemi_post_column_layout',
			array(
				'default'           => 'one_column',
				'sanitize_callback' => 'aemi_sanitize_dropdown_options',
			)
		);

		$wp_customize->add_setting(
			'aemi_post_width',
			array(
				'default'           => 'default_width',
				'sanitize_callback' => 'aemi_sanitize_dropdown_options',
			)
		);

		$wp_customize->add_setting(
			'aemi_post_sticky_width',
			array(
				'default'           => 'span_full',
				'sanitize_callback' => 'aemi_sanitize_dropdown_options',
			)
		);

		/*
			 * For a future Update
			 *

			$wp_customize->add_setting('aemi_post_font_heading', [
				'default' => 'unset',
				'sanitize_callback' => 'aemi_sanitize_dropdown_options',
			]);

			$wp_customize->add_setting('aemi_post_font_heading', [
				'default' => 'unset',
				'sanitize_callback' => 'aemi_sanitize_dropdown_options',
			]);

			 *
			 *
		*/

		aemi_add_settings(
			array(
				array(
					'name'    => 'aemi_post_single_attachment',
					'type'    => 'checkbox',
					'default' => 1,
				),
			),
			$wp_customize
		);

		aemi_add_settings(
			array(
				array(
					'name'     => 'aemi_loop_cat_filtering',
					'type'     => 'checkbox',
					'default'  => 0,
					'critical' => true,
				),
				array(
					'name'     => 'aemi_loop_add_types',
					'type'     => 'checkbox',
					'default'  => 0,
					'critical' => true,
				),
			),
			$wp_customize
		);

		$categories = get_categories();

		$cat_IDs = array();

		foreach ( $categories as $cat ) {
			$cat_IDs[] = $cat->cat_ID;
		}

		$wp_customize->add_setting(
			'aemi_loop_cat_filters',
			array(
				'default'           => $cat_IDs,
				'sanitize_callback' => 'aemi_sanitize_checkbox_multiple',
			)
		);

		$wp_customize->add_setting(
			'aemi_loop_added_types',
			array(
				'default'           => array( 'post' ),
				'sanitize_callback' => 'aemi_sanitize_checkbox_multiple',
			)
		);
	}
}
