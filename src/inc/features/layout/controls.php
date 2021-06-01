<?php

if ( ! function_exists( 'aemi_features_controls__layout' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_controls__layout( $wp_customize ) {
		$wp_customize->add_control(
			'aemi_thumbnails_display',
			array(
				'label'       => __( 'Thumbnails Display', 'aemi' ),
				'description' => __( 'Choose to display post and page attachment behind and covered by page title or detached', 'aemi' ),
				'section'     => 'aemi_layout',
				'settings'    => 'aemi_thumbnails_display',
				'type'        => 'radio',
				'choices'     => array(
					'covered'    => __( 'Covered', 'aemi' ),
					'fullscreen' => __( 'Fullscreen', 'aemi' ),
					'detached'   => __( 'Detached', 'aemi' ),
				),
			)
		);
	}
}
