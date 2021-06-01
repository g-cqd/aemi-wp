<?php

if ( ! function_exists( 'aemi_features_settings__header' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_settings__header( $wp_customize ) {
		aemi_add_settings(
			array(
				array(
					'name'    => 'aemi_header_autohiding',
					'type'    => 'checkbox',
					'default' => 0,
				),
				array(
					'name'    => 'aemi_header_layout',
					'type'    => 'radio',
					'default' => 'centered',
				),
				array(
					'name'    => 'aemi_header_stickyness',
					'type'    => 'radio',
					'default' => 'adaptative',
				),
			),
			$wp_customize
		);
	}
}
