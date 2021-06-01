<?php

if ( ! function_exists( 'aemi_features_settings__comments' ) ) {
	/**
	 * Add Comments Panel Settings.
	 *
	 * @param wp_customize $wp_customize Customizer object.
	 */
	function aemi_features_settings__comments( $wp_customize ) {
		aemi_add_settings(
			array(
				array(
					'name'    => 'aemi_display_comments',
					'type'    => 'checkbox',
					'default' => 1,
				),
				array(
					'name'    => 'aemi_remove_recent_comments_style',
					'type'    => 'checkbox',
					'default' => 0,
				),
			),
			$wp_customize
		);
	}
}
