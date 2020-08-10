<?php


if (!function_exists('aemi_customizer_settings'))
{
	function aemi_customizer_settings($wp_customize)
	{
		foreach (get_post_types(['public' => true], 'objects') as $post_type)
		{
			$post_name = $post_type->name;

			$post_type_object = (object) ['post_type' => $post_name];

			$default_metas = [
				'author'	=>	[
					'name'	=> 'author',
					'label'	=> __('Author', 'aemi')
				],
				'published_date'	=>	[
					'name'	=> 'published_date',
					'label'	=> __('Published Date', 'aemi')
				],
				'updated_date'	=>	[
					'name'	=> 'updated_date',
					'label'	=> __('Updated Date', 'aemi')
				]
			];

			$array_of_metas = [];

			foreach (@get_object_taxonomies($post_type_object, 'objects') as $taxonomy)
			{
				$array_of_metas[] = $taxonomy;
			}

			foreach ($default_metas as $meta)
			{
				$array_of_metas[] = (object) $meta;
			}

			foreach ($array_of_metas as $meta)
			{
				$type_setting = 'aemi_type_' . $post_name . '_' . $meta->name;

				if (
					($post_name == "post" && $meta->name == "updated_date") ||
					($post_name == "page" && ($meta->name == "author" || $meta->name == "published_date"))
				)
				{
					$wp_customize->add_setting($type_setting, [
						'default'			=> 0,
						'sanitize_callback'	=> 'aemi_sanitize_checkbox',
						'transport'			=> 'refresh',
					]);
				}
				else
				{
					$wp_customize->add_setting($type_setting, [
						'default'			=> 1,
						'sanitize_callback'	=> 'aemi_sanitize_checkbox',
						'transport'			=> 'refresh',
					]);
				}

				$wp_customize->add_control($type_setting, [
					'label'		=>		esc_html__($meta->label, 'aemi'),
					'description'	=>	esc_html(
						sprintf(
							'%1$s %2$s %3$s %4$s.',
							__('Display', 'aemi'),
							$meta->label,
							__('in', 'aemi'),
							$post_name
						)
					),
					'section'	=>	'aemi_type_' . $post_name,
					'settings'	=>	$type_setting,
					'type'		=>	'checkbox',
				]);

			}

			$progress_bar = 'aemi_type_' . $post_name . '_progress_bar';

			$wp_customize->add_setting($progress_bar, [
				'default'			=> 0,
				'sanitize_callback'	=> 'aemi_sanitize_checkbox',
				'transport'			=> 'refresh',
			]);

		}

		$wp_customize->add_setting('aemi_color_scheme', [
			'default'			=> 'auto',
			'sanitize_callback'	=> 'aemi_sanitize_radio',
			'transport'			=> 'refresh',
		]);

		$wp_customize->add_setting('aemi_color_scheme_user', [
			'default'			=> 0,
			'sanitize_callback'	=> 'aemi_sanitize_checkbox',
			'transport'			=> 'refresh',
		]);

		$wp_customize->add_setting('aemi_search_button_display', [
			'default'	        => 0,
			'sanitize_callback'	=> 'aemi_sanitize_checkbox',
			'transport'	        => 'refresh',
		]);

		$wp_customize->add_setting('aemi_header_autohiding', [
			'default'			=> 0,
			'sanitize_callback'	=> 'aemi_sanitize_checkbox',
			'transport'			=> 'refresh',
		]);

		$wp_customize->add_setting('aemi_header_js_code', [
			'capability'		=> 'edit_theme_options',
			'sanitize_callback' => 'aemi_raw_js_code',
		]);


		$wp_customize->add_setting('aemi_footer_js_code', [
			'capability'		=> 'edit_theme_options',
			'sanitize_callback' => 'aemi_raw_js_code',
		]);
	}
}
add_action('customize_register', 'aemi_customizer_settings');

