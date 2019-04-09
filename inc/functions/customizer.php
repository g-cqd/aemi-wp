<?php


function aemi_custom_settings( $wp_customize )
{

	/* ** Sanitizing Functions ** */
	function aemi_sanitize_checkbox( $input )
	{
		if ( true === $input ) { return 1; }
		else { return 0; }
	}


	function aemi_raw_js_code( $input ) { return $input; }

	/* ** Panel & Sections ** */
	$wp_customize->add_panel( 'aemi_panel', array(
		'priority'       => 0,
		'capability'     => 'edit_theme_options',
		'title'          => esc_html__( 'AeMi', 'aemi' ),
		'description'    => esc_html__( 'Customize AeMi Settings and Features', 'aemi' ),
	) );
	$wp_customize->add_section( 'aemi_scripts' , array(
		'priority'   => 0,
		'panel'      => 'aemi_panel',
		'title'      => esc_html__( 'Custom Scripts', 'aemi' ),
	) );
	$wp_customize->add_section( 'aemi_features' , array(
		'priority'   => 10,
		'panel'      => 'aemi_panel',
		'title'      => esc_html__( 'Special Features', 'aemi' ),
	) );
	$id = 20;
	foreach ( get_post_types( array( 'public' => true, ), 'objects' ) as $post_type ) {

		$post_name = $post_type->name;

		$wp_customize->add_section( ( 'aemi_type_' . $post_name ), array(
			'panel'    => 'aemi_panel',
			'title'      => esc_html__( $post_type->label, 'aemi' ),
			'priority'	 => $id,
		) );

		$id += 10;

		$post_type_object = (object) array( 'post_type' => $post_name );

		$default_metas = array(
			'author' => array(
				'name' => 'author',
				'label' => __( 'Author', 'aemi' ),
			),
			'published_date' => array(
				'name' => 'published_date',
				'label' => __( 'Published Date', 'aemi' ),
			),
			'updated_date' => array(
				'name' => 'updated_date',
				'label' => __( 'Updated Date', 'aemi' ),
			),
		);

		$array_of_metas = array();

		foreach( @get_object_taxonomies( $post_type_object, 'objects' ) as $taxonomy) {
			array_push( $array_of_metas, $taxonomy );
		}
		foreach( $default_metas as $meta ) {
			array_push( $array_of_metas, (object) $meta );
		}

		foreach ( $array_of_metas as $meta ) {
			$type_setting = 'aemi_type_' . $post_name . '_' . $meta->name;
			if ( ( $post_name == "post" && $meta->name == "updated_date" ) || ( $post_name == "page" && ( $meta->name == "author" || $meta->name == "published_date" ) ) ) {
				$wp_customize->add_setting( $type_setting , array(
					'default'			=> 0,
					'sanitize_callback'	=> 'aemi_sanitize_checkbox',
					'transport'			=> 'refresh',
				) );
			} else {
				$wp_customize->add_setting( $type_setting , array(
					'default'			=> 1,
					'sanitize_callback'	=> 'aemi_sanitize_checkbox',
					'transport'			=> 'refresh',
				) );
			}
			$wp_customize->add_control( $type_setting, array(
				'label' => esc_html__( $meta->label, 'aemi' ),
				'description' => esc_html( sprintf( '%1$s %2$s %3$s %4$s.', __( 'Display', 'aemi' ), $meta->label, __( 'in', 'aemi' ), $post_name ) ),
				'section' => 'aemi_type_' . $post_name,
				'settings' => $type_setting,
				'type' => 'checkbox',
			) );
		}
		$progress_bar = 'aemi_type_' . $post_name . '_progress_bar';
		$wp_customize->add_setting( $progress_bar , array(
			'default'			=> 0,
			'sanitize_callback'	=> 'aemi_sanitize_checkbox',
			'transport'			=> 'refresh',
		) );
		$wp_customize->add_control( $progress_bar, array(
			'label' => esc_html__( 'Progress Bar', 'aemi' ),
			'description' => esc_html__( 'Display a progress bar that indicate what quantity of the page you read.', 'aemi' ),
			'section' => 'aemi_type_' . $post_name,
			'settings' => $progress_bar,
			'type' => 'checkbox',
		) );

	}

	/* ** Settings & Controls ** */
	$wp_customize->add_setting( 'aemi_darkmode_display' , array(
		'default'			=> 1,
		'sanitize_callback'	=> 'aemi_sanitize_checkbox',
		'transport'			=> 'refresh',
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
		'description' => esc_html__( 'Display a search button on right side of header bar.', 'aemi' ),
		'section' => 'aemi_features',
		'settings' => 'aemi_search_button_display',
		'type' => 'checkbox',
	) );


	$wp_customize->add_setting( 'aemi_header_autohiding' , array(
		'default'			=> 0,
		'sanitize_callback'	=> 'aemi_sanitize_checkbox',
		'transport'			=> 'refresh',
	) );
	$wp_customize->add_control( 'aemi_header_autohiding', array(
		'label' => esc_html__( 'Header Auto Hiding', 'aemi' ),
		'description' => esc_html__( 'Allow header bar to disappear while scrolling down and come back when scroll up occurs.', 'aemi' ),
		'section' => 'aemi_features',
		'settings' => 'aemi_header_autohiding',
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
