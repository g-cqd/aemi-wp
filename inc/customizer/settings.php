<?php


if (!function_exists('aemi_customizer_settings'))
{
	function aemi_customizer_settings($wp_customize)
	{

		$wp_customize->add_setting('aemi_light_scheme_logo', [

		]);

		$wp_customize->add_setting('aemi_dark_scheme_logo', [
			
		]);

		foreach (get_post_types(['public' => true], 'objects') as $post_type)
		{
			$post_name = $post_type->name;

			$post_type_object = (object) ['post_type' => $post_name];

			$default_metas = [
				'author'	=>	[
					'name'	=> 'author',
					'label'	=> __('Author', 'aemi')
				],
				'author_in_loop'	=>	[
					'name'	=> 'author_in_loop',
					'label'	=> __('Author in Loop', 'aemi')
				],
				'published_date'	=>	[
					'name'	=> 'published_date',
					'label'	=> __('Published Date', 'aemi')
				],
				'published_date_in_loop'	=>	[
					'name'	=> 'published_date_in_loop',
					'label'	=> __('Published Date in Loop', 'aemi')
				],
				'updated_date'	=>	[
					'name'	=> 'updated_date',
					'label'	=> __('Updated Date', 'aemi')
				],
				'updated_date_in_loop'	=>	[
					'name'	=> 'updated_date_in_loop',
					'label'	=> __('Updated Date in Loop', 'aemi')
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
			}

			if ($post_name == "post" || $post_name == "page")
			{
				$show_excerpt = 'aemi_type_'.$post_name.'_show_excerpt';

				$wp_customize->add_setting($show_excerpt, [
					'default'			=> 0,
					'sanitize_callback'	=> 'aemi_sanitize_checkbox',
					'transport'			=> 'refresh',
				]);
			}

			if ($post_name == "post")
			{
				$wp_customize->add_setting('aemi_type_post_sticky', [
					'default'			=> 1,
					'sanitize_callback'	=> 'aemi_sanitize_checkbox',
					'transport'			=> 'refresh',
				]);
				$wp_customize->add_setting('aemi_type_post_sticky_in_loop', [
					'default'			=> 1,
					'sanitize_callback'	=> 'aemi_sanitize_checkbox',
					'transport'			=> 'refresh',
				]);

				$wp_customize->add_setting('aemi_type_post_show_excerpt_when_sticky', [
					'default'			=> 1,
					'sanitize_callback'	=> 'aemi_sanitize_checkbox',
					'transport'			=> 'refresh',
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

		$wp_customize->add_setting('aemi_remove_jquery_migrate', [
			'default'			=> 0,
			'sanitize_callback'	=> 'aemi_sanitize_checkbox',
			'transport'			=> 'refresh',
		]);

		$wp_customize->add_setting('aemi_remove_script_version', [
			'default'			=> 0,
			'sanitize_callback'	=> 'aemi_sanitize_checkbox',
			'transport'			=> 'refresh',
		]);

		$wp_customize->add_setting('aemi_enable_svg_support', [
			'default'			=> 0,
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'aemi_sanitize_checkbox',
			'transport'			=> 'refresh',
		]);

		$wp_customize->add_setting('aemi_remove_emojis', [
			'default'			=> 0,
			'sanitize_callback'	=> 'aemi_sanitize_checkbox',
			'transport'			=> 'refresh',
		]);

		$wp_customize->add_setting('aemi_remove_wpembeds', [
			'default'			=> 0,
			'sanitize_callback'	=> 'aemi_sanitize_checkbox',
			'transport'			=> 'refresh',
		]);

		$wp_customize->add_setting('aemi_add_expire_headers', [
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

