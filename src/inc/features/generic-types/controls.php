<?php

if ( ! function_exists( 'aemi_features_controls__generic_types' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_controls__generic_types( $wp_customize ) {
		foreach ( get_post_types( array( 'public' => true ), 'objects' ) as $post_type ) {
			$p_name = $post_type->name;

			$post_type_object = (object) array( 'post_type' => $p_name );

			$default_metas = array(
				'author'         => array(
					'name'  => 'author',
					'label' => __( 'Author', 'aemi' ),
				),
				'published_date' => array(
					'name'  => 'published_date',
					'label' => __( 'Published Date', 'aemi' ),
				),
				'updated_date'   => array(
					'name'  => 'updated_date',
					'label' => __( 'Updated Date', 'aemi' ),
				),
			);

			$array_of_metas = array();

			foreach ( @get_object_taxonomies( $post_type_object, 'objects' ) as $taxonomy ) {
				$array_of_metas[] = $taxonomy;
			}
			foreach ( $default_metas as $meta ) {
				$array_of_metas[] = (object) $meta;
			}

			foreach ( $array_of_metas as $meta ) {
				$m_name  = $meta->name;
				$m_label = $meta->label;

				$setting = aemi_setting( $p_name, $m_name );

				if ( in_array( $m_name, array( 'author', 'published_date', 'updated_date' ), true ) ) {
					$wp_customize->add_control(
						new Aemi_Dropdown_Options(
							$wp_customize,
							$setting,
							array(
								'label'       => $m_label,
								'description' => sprintf(
									'%1$s %2$s %3$s.',
									__( 'Choose to display', 'aemi' ),
									$meta->label,
									__( 'information in single page, content loop, both or none', 'aemi' )
								),
								'section'     => 'aemi_type_' . $p_name,
								'settings'    => $setting,
								'choices'     => array(
									'both'   => __( 'Both', 'aemi' ),
									'single' => __( 'Single Page Only', 'aemi' ),
									'loop'   => __( 'Content Loop Only', 'aemi' ),
									'none'   => __( 'None', 'aemi' ),
								),
							)
						)
					);
				} else {
					$wp_customize->add_control(
						$setting,
						array(
							'label'       => $m_label,
							'description' => sprintf(
								'%1$s %2$s %3$s %4$s.',
								__( 'Display', 'aemi' ),
								$m_label,
								__( 'in', 'aemi' ),
								$p_name
							),
							'section'     => 'aemi_type_' . $p_name,
							'settings'    => $setting,
							'type'        => 'checkbox',
						)
					);
				}
			}

			if ( 'post' === $p_name ) {
				$setting = aemi_setting( $p_name, 'show_excerpt' );
				$wp_customize->add_control(
					new Aemi_Dropdown_Options(
						$wp_customize,
						$setting,
						array(
							'label'       => __( 'Show Excerpt', 'aemi' ),
							'description' => __( 'Choose to display a short excerpt of featured, non-featured, both or none of the posts.', 'aemi' ),
							'section'     => 'aemi_type_post',
							'settings'    => $setting,
							'choices'     => array(
								'both'            => __( 'Both', 'aemi' ),
								'sticky_only'     => __( 'Featured Only', 'aemi' ),
								'non_sticky_only' => __( 'Not Featured Only', 'aemi' ),
								'none'            => __( 'None', 'aemi' ),
							),
						)
					)
				);
				$setting = aemi_setting( $p_name, 'show_sticky_badge' );
				$wp_customize->add_control(
					new Aemi_Dropdown_Options(
						$wp_customize,
						$setting,
						array(
							'label'       => __( 'Show Featured Badge', 'aemi' ),
							'description' => __( 'Choose to display a "Featured" badge on single page, content loop, both or none of the featured posts.', 'aemi' ),
							'section'     => 'aemi_type_post',
							'settings'    => $setting,
							'choices'     => array(
								'both'   => __( 'Both', 'aemi' ),
								'single' => __( 'Single Page Only', 'aemi' ),
								'loop'   => __( 'Content Loop Only', 'aemi' ),
								'none'   => __( 'None', 'aemi' ),
							),
						)
					)
				);
			} else {
				$setting = aemi_setting( $p_name, 'show_excerpt' );

				$wp_customize->add_control(
					$setting,
					array(
						'label'       => __( 'Show Excerpt', 'aemi' ),
						'description' => sprintf(
							'%1$s %2$s%3$s %2$s %4$s.',
							__( 'Show a short excerpt of', 'aemi' ),
							$p_name,
							__( 's in lists of', 'aemi' ),
							__( 's', 'aemi' )
						),
						'section'     => 'aemi_type_' . $p_name,
						'settings'    => $setting,
						'type'        => 'checkbox',
					)
				);
			}

			$setting = aemi_setting( $p_name, 'progress_bar' );

			$wp_customize->add_control(
				$setting,
				array(
					'label'       => __( 'Progress Bar', 'aemi' ),
					'description' => __( 'Display a progress bar that indicate what quantity of the page you read.', 'aemi' ),
					'section'     => 'aemi_type_' . $p_name,
					'settings'    => $setting,
					'type'        => 'checkbox',
				)
			);
		}
	}
}
