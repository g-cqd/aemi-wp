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
			$p_name = $post_type->name;

			$post_type_object = (object) ['post_type' => $p_name];

			$default_metas = [
				'author'			=> [ 'name' => 'author' ],
				'published_date'	=> [ 'name' => 'published_date' ],
				'updated_date'		=> [ 'name' => 'updated_date' ]
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
				$m_name = $meta->name;

				$setting = aemi_setting($p_name,$m_name);

				if (in_array($m_name, ['author','published_date']))
				{
					aemi_add_setting_radio($wp_customize,$setting,'both');
				}
				else if ($m_name == 'updated_date')
				{
					aemi_add_setting_radio($wp_customize,$setting,'none');	
				}
				else
				{
					aemi_add_setting_checkbox($wp_customize,$setting,1);
				}
			}

			if ($p_name == "post")
			{
				aemi_add_setting_radio(
					$wp_customize,
					aemi_setting($p_name,'show_excerpt'),
					'sticky_only'
				);
				aemi_add_setting_radio(
					$wp_customize,
					aemi_setting($p_name,'show_sticky_badge'),
					'both'
				);
			}
			else
			{
				aemi_add_setting_checkbox(
					$wp_customize,
					aemi_setting($p_name,'show_excerpt'),
					0
				);
			}

			aemi_add_setting_checkbox(
				$wp_customize,
				aemi_setting($p_name,'progress_bar'),
				1
			);

		}

		$settings = [
			[
				'name' => 'aemi_color_scheme',
				'type' => 'radio',
				'default' => 'auto'
			],
			[
				'name' => 'aemi_color_scheme_user',
				'type' => 'checkbox',
				'default' => 0
			],
			[
				'name' => 'aemi_search_button_display',
				'type' => 'checkbox',
				'default' => 0
			],
			[
				'name' => 'aemi_header_autohiding',
				'type' => 'checkbox',
				'default' => 0
			],
			[
				'name' => 'aemi_remove_jquery_migrate',
				'type' => 'checkbox',
				'default' => 0
			],
			[
				'name' => 'aemi_remove_script_version',
				'type' => 'checkbox',
				'default' => 0
			],
			[
				'name' => 'aemi_remove_emojis',
				'type' => 'checkbox',
				'default' => 0
			],
			[
				'name' => 'aemi_remove_wpembeds',
				'type' => 'checkbox',
				'default' => 0
			],
			[
				'name' => 'aemi_enable_svg_support',
				'type' => 'checkbox',
				'default' => 0,
				'critical' => true
			],
			[
				'name' => 'aemi_add_expire_headers',
				'type' => 'checkbox',
				'default' => 0,
				'critical' => true
			],
			[
				'name' => 'aemi_loop_cat_filtering',
				'type' => 'checkbox',
				'default' => 0,
				'critical' => true
			],
			[
				'name' => 'aemi_loop_add_types',
				'type' => 'checkbox',
				'default' => 0,
				'critical' => true
			]
		];

		foreach ($settings as $setting) {
			switch ($setting['type']) {
				case 'radio':
					aemi_add_setting_radio(
						$wp_customize,
						$setting['name'],
						$setting['default']
					);
					break;
				case 'checkbox':
					aemi_add_setting_checkbox(
						$wp_customize,
						$setting['name'],
						$setting['default'],
						isset($setting['critical']) ? $setting['critical'] : false
					);
					break;
				default:
					break;
			}
		}

		$categories = get_categories();

		$cat_ids = [];

		foreach ($categories as $cat) {
			$cat_IDs[] = $cat->cat_ID;
		}

		$wp_customize->add_setting('aemi_loop_cat_filters', [
			'default' => $cat_IDs,
			'sanitize_callback' => 'aemi_sanitize_checkbox_multiple'
		]);

		$wp_customize->add_setting('aemi_loop_added_types', [
			'default' => ['post'],
			'sanitize_callback' => 'aemi_sanitize_checkbox_multiple'
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

