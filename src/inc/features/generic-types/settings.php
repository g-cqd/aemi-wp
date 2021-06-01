<?php

if ( ! function_exists( 'aemi_features_settings__generic_types' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_settings__generic_types( $wp_customize ) {
		foreach ( get_post_types( array( 'public' => true ), 'objects' ) as $post_type ) {
			$p_name = $post_type->name;

			$post_type_object = (object) array( 'post_type' => $p_name );

			$default_metas = array(
				'author'         => array( 'name' => 'author' ),
				'published_date' => array( 'name' => 'published_date' ),
				'updated_date'   => array( 'name' => 'updated_date' ),
			);

			$array_of_metas = array();

			foreach ( @get_object_taxonomies( $post_type_object, 'objects' ) as $taxonomy ) {
				$array_of_metas[] = $taxonomy;
			}

			foreach ( $default_metas as $meta ) {
				$array_of_metas[] = (object) $meta;
			}

			foreach ( $array_of_metas as $meta ) {
				$m_name = $meta->name;

				$setting = aemi_setting( $p_name, $m_name );

				if ( in_array( $m_name, array( 'author', 'published_date' ), true ) ) {
					$wp_customize->add_setting(
						$setting,
						array(
							'default'           => 'both',
							'sanitize_callback' => 'aemi_sanitize_dropdown_options',
						)
					);
				} elseif ( 'updated_date' === $m_name ) {
					$wp_customize->add_setting(
						$setting,
						array(
							'default'           => 'none',
							'sanitize_callback' => 'aemi_sanitize_dropdown_options',
						)
					);
				} else {
					aemi_add_setting_checkbox( $wp_customize, $setting, 1 );
				}
			}

			if ( 'post' === $p_name ) {
				$wp_customize->add_setting(
					aemi_setting( $p_name, 'show_excerpt' ),
					array(
						'default'           => 'sticky_only',
						'sanitize_callback' => 'aemi_sanitize_dropdown_options',
					)
				);
				$wp_customize->add_setting(
					aemi_setting( $p_name, 'show_sticky_badge' ),
					array(
						'default'           => 'both',
						'sanitize_callback' => 'aemi_sanitize_dropdown_options',
					)
				);
			} else {
				aemi_add_setting_checkbox(
					$wp_customize,
					aemi_setting( $p_name, 'show_excerpt' ),
					0
				);
			}

			aemi_add_setting_checkbox(
				$wp_customize,
				aemi_setting( $p_name, 'progress_bar' ),
				1
			);
		}
	}
}
