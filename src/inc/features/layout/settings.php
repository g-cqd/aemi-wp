<?php

if ( ! function_exists( 'aemi_features_settings__layout' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_settings__layout( $wp_customize ) {
		aemi_add_settings(
			array(
				array(
					'name'    => 'aemi_thumbnails_display',
					'type'    => 'radio',
					'default' => 'covered',
				),
			),
			$wp_customize
		);
	}
}
