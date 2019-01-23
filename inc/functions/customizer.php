<?php

function aemi_custom_settings( $wp_customize )
{
	function aemi_sanitize_checkbox( $checked )
	{
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
	
	$wp_customize->add_section( 'aemi_features' , array(
		'title'      => esc_html_x( 'AeMi - Features', 'aemi features section', 'aemi' ),
		'priority'   => 0,
	) );

	$wp_customize->add_setting( 'aemi_darkmode_display' , array(
		'default'	=> true,
		'transport'	=> 'refresh',
		'sanitize_callback'	=> 'aemi_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'aemi_darkmode_display', array(
		'label' => esc_html_x( 'Dark Theme', 'darkmode activation' , 'aemi' ),
		'section' => 'aemi_features',
		'settings' => 'aemi_darkmode_display',
		'type' => 'checkbox',
	) );

	$wp_customize->add_setting( 'aemi_search_button_display' , array(
		'default'	=> true,
		'transport'	=> 'refresh',
		'sanitize_callback'	=> 'aemi_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'aemi_search_button_display', array(
		'label' => esc_html_x( 'Display Search Button in Top bar', 'search button display' , 'aemi' ),
		'section' => 'aemi_features',
		'settings' => 'aemi_search_button_display',
		'type' => 'checkbox',
	) );

}
add_action( 'customize_register', 'aemi_custom_settings' );
