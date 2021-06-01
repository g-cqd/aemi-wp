<?php

if ( ! function_exists( 'aemi_features_controls__content_loop' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_controls__content_loop( $wp_customize ) {
		$wp_customize->add_control(
			new Aemi_Dropdown_Options(
				$wp_customize,
				'aemi_post_layout',
				array(
					'label'       => __( 'Post Listing Layout', 'aemi' ),
					'description' => __( 'How would you like your post listings to be displayed.', 'aemi' ),
					'section'     => 'aemi_loop',
					'settings'    => 'aemi_post_layout',
					'choices'     => array(
						'no_img' => __( 'Cards without Image', 'aemi' ),
						'stack'  => __( 'Cards with Image', 'aemi' ),
						'cover'  => __( 'Cards with Background Image', 'aemi' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new Aemi_Dropdown_Options(
				$wp_customize,
				'aemi_post_width',
				array(
					'label'       => __( 'Post Listing Width', 'aemi' ),
					'description' => __( 'Change post listing (content loop layout) width.', 'aemi' ),
					'section'     => 'aemi_loop',
					'settings'    => 'aemi_post_width',
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
				'aemi_post_column_layout',
				array(
					'label'       => __( 'Post Listing Column Layout', 'aemi' ),
					'description' => __( 'Choose maximum number of column to display post in near-full-width and full width.', 'aemi' 	),
					'section'     => 'aemi_loop',
					'settings'    => 'aemi_post_column_layout',
					'choices'     => array(
						'one_column'    => __( 'Single Column', 'aemi' ),
						'two_columns'   => __( 'Two Columns', 'aemi' ),
						'three_columns' => __( 'Three Columns', 'aemi' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new Aemi_Dropdown_Options(
				$wp_customize,
				'aemi_post_sticky_width',
				array(
					'label'       => __( 'Sticky Post Layout in Listing ', 'aemi' ),
					'description' => __( 'Choose maximum number of column to display post in near-full-width and full width.', 'aemi' ),
					'section'     => 'aemi_loop',
					'settings'    => 'aemi_post_sticky_width',
					'choices'     => array(
						'span_1'    => __( 'One Column', 'aemi' ),
						'span_2'    => __( 'Two Columns', 'aemi' ),
						'span_full' => __( 'Full Width', 'aemi' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			'aemi_post_single_attachment',
			array(
				'label'       => __( 'Display Attachment on Single Content Page', 'aemi' ),
				'description' => __( 'Choose to display a featured image for your single-page content.', 'aemi' ),
				'section'     => 'aemi_loop',
				'settings'    => 'aemi_post_single_attachment',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_control(
			'aemi_loop_cat_filtering',
			array(
				'label'       => __( 'Enable Loop Filtering by Post Categories', 'aemi' ),
				'description' => __( 'Enable this feature to select which categories you want to be shown in content loop and those you do not want to see.', 'aemi' ),
				'section'     => 'aemi_loop',
				'settings'    => 'aemi_loop_cat_filtering',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_control(
			'aemi_loop_add_types',
			array(
				'label'       => __( 'Add Custom Post Types to Content Loop', 'aemi' ),
				'description' => __( 'Enable this feature to select which custom post types to add to WordPress content loop.', 'aemi' ),
				'section'     => 'aemi_loop',
				'settings'    => 'aemi_loop_add_types',
				'type'        => 'checkbox',
			)
		);

		$categories = get_categories();

		$cat_labels = array();

		foreach ( $categories as $cat ) {
			$cat_labels[ $cat->cat_ID ] = $cat->name;
		}

		$wp_customize->add_control(
			new Aemi_Checkbox_Multiple(
				$wp_customize,
				'aemi_loop_cat_filters',
				array(
					'label'       => __( 'Content Loop Post Category Filter', 'aemi' ),
					'description' => __( 'Choose post categories that will be shown in content loop.', 'aemi' ),
					'section'     => 'aemi_loop',
					'settings'    => 'aemi_loop_cat_filters',
					'choices'     => $cat_labels,
				)
			)
		);

		$custom_types = array();

		foreach ( get_post_types( array( 'public' => true ), 'objects' ) as $post_type ) {
			$custom_types[ $post_type->name ] = $post_type->label;
		}

		$wp_customize->add_control(
			new Aemi_Checkbox_Multiple(
				$wp_customize,
				'aemi_loop_added_types',
				array(
					'label'       => __( 'Custom Post Types to add', 'aemi' ),
					'description' => __( 'Choose custom post types that will be added to the content loop.', 'aemi' ),
					'section'     => 'aemi_loop',
					'settings'    => 'aemi_loop_added_types',
					'choices'     => $custom_types,
				)
			)
		);
	}
}
