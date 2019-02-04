<?php

function aemi_custom_settings( $wp_customize )
{

	/* ** Sanitizing Functions ** */
	function aemi_sanitize_checkbox( $input )
	{
		if ( true === $input )
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	function aemi_raw_js_code( $input )
	{
		return $input;
	}

	/* ** Panel & Sections ** */
	$wp_customize->add_panel( 'aemi_panel', array(
		'priority'       => 0,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'AeMi', 'aemi' ),
		'description'    => esc_html__( 'Customize AeMi Settings and Features', 'aemi' ),
	) );
	$wp_customize->add_section( 'aemi_scripts' , array(
		'panel'      => 'aemi_panel',
		'title'      => esc_html__( 'Custom Scripts', 'aemi' ),
		'priority'   => 0,
	) );
	$wp_customize->add_section( 'aemi_features' , array(
		'panel'      => 'aemi_panel',
		'title'      => esc_html__( 'Special Features', 'aemi' ),
		'priority'   => 10,
	) );

	/* ** Settings & Controls ** */
	$wp_customize->add_setting( 'aemi_darkmode_display' , array(
		'default'	=> 1,
		'sanitize_callback'	=> 'aemi_sanitize_checkbox',
		'transport'	=> 'refresh',
	) );
	$wp_customize->add_control( 'aemi_darkmode_display', array(
		'label' => esc_html__( 'Dark Mode', 'aemi' ),
		'description' => esc_html__( 'Allow theme to switch automatically between light and dark mode.', 'aemi' ),
		'section' => 'aemi_features',
		'settings' => 'aemi_darkmode_display',
		'type' => 'checkbox',
	) );

	$wp_customize->add_setting( 'aemi_search_button_display' , array(
		'default'	=> 0,
		'sanitize_callback'	=> 'aemi_sanitize_checkbox',
		'transport'	=> 'refresh',
	) );
	$wp_customize->add_control( 'aemi_search_button_display', array(
		'label' => esc_html__( 'Search Button', 'aemi' ),
		'description' => esc_html__( 'Display a search button on right side of top bar.', 'aemi' ),
		'section' => 'aemi_features',
		'settings' => 'aemi_search_button_display',
		'type' => 'checkbox',
	) );

	$wp_customize->add_setting( 'aemi_header_js_code', array(
		'sanitize_callback' => 'aemi_raw_js_code',
	) );
	$wp_customize->add_control( 'aemi_header_js_code', array(
		'label' => esc_html__( 'Header JS Script', 'aemi' ),
		'description' => esc_html__( 'Add JS scripts to wp-head. No need to add script tag.', 'aemi' ),
		'section' => 'aemi_scripts',
		'type' => 'textarea'
	) );
	$wp_customize->add_setting( 'aemi_footer_js_code', array(
		'sanitize_callback' => 'aemi_raw_js_code',
	) );
	$wp_customize->add_control( 'aemi_footer_js_code', array(
		'label' => esc_html__( 'Footer JS Script', 'aemi' ),
		'description' => esc_html__( 'Add JS scripts to wp-footer. No need to add script tag.', 'aemi' ),
		'section' => 'aemi_scripts',
		'type' => 'textarea'
	) );
}
add_action( 'customize_register', 'aemi_custom_settings' );

/* ** Functions ** */
function aemi_header_script()
{
	?><script type="text/javascript">
	<?php echo get_theme_mod( 'aemi_header_js_code' ); ?>
	</script>
	<?php
}
function aemi_footer_script()
{
	?><script type="text/javascript">
	<?php echo get_theme_mod( 'aemi_footer_js_code' ); ?>
	</script>
	<?php
}
add_action( 'wp_head', 'aemi_header_script' );
add_action( 'wp_footer', 'aemi_footer_script' );
