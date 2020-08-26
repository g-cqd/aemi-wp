<?php

if (!function_exists('aemi_customizer_settings__analytics'))
{
	function aemi_customizer_settings__analytics($wp_customize)
	{
		$wp_customize->add_setting('aemi_ga_type', [
			'default' => 'none',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback' => 'aemi_sanitize_dropdown_options',
		]);

		aemi_add_settings([
			[
				'name' => 'aemi_bing_meta_tag',
				'type' => 'checkbox',
				'default' => 0,
				'critical' => true
			]
		], $wp_customize);

		$wp_customize->add_setting('aemi_ga_id', [
			'capability'		=> 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		]);

		$wp_customize->add_setting('aemi_bing_meta_tag_content', [
			'capability'		=> 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		]);
	}
}

if (!function_exists('aemi_customizer_settings__colors'))
{
	function aemi_customizer_settings__colors($wp_customize)
	{
		$wp_customize->add_setting( 'aemi_color_scheme',[
			'default' => 'auto',
			'sanitize_callback' => 'aemi_sanitize_dropdown_options'
		]);

		aemi_add_settings([
			[
				'name' => 'aemi_color_scheme_user',
				'type' => 'checkbox',
				'default' => 0
			]
		], $wp_customize);
	}
}

if (!function_exists('aemi_customizer_settings__comments'))
{
	function aemi_customizer_settings__comments($wp_customize)
	{
		aemi_add_settings([
			[
				'name' => 'aemi_display_comments',
				'type' => 'checkbox',
				'default' => 1
			],
			[
				'name' => 'aemi_remove_recent_comments_style',
				'type' => 'checkbox',
				'default' => 0
			]
		], $wp_customize);
	}
}

if (!function_exists('aemi_customizer_settings__content_loop'))
{
	function aemi_customizer_settings__content_loop($wp_customize)
	{

		$wp_customize->add_setting('aemi_post_layout', [
			'default' => 'cover',
			'sanitize_callback' => 'aemi_sanitize_dropdown_options',
		]);

		$wp_customize->add_setting('aemi_post_column_layout', [
			'default' => 'one_column',
			'sanitize_callback' => 'aemi_sanitize_dropdown_options',
		]);

		$wp_customize->add_setting('aemi_post_width', [
			'default' => 'default_width',
			'sanitize_callback' => 'aemi_sanitize_dropdown_options',
		]);

		$wp_customize->add_setting('aemi_post_sticky_width', [
			'default' => 'span_full',
			'sanitize_callback' => 'aemi_sanitize_dropdown_options',
		]);

		/*
		 * For a future Update
		 *

		$wp_customize->add_setting('aemi_post_font_heading', [
			'default' => 'unset',
			'sanitize_callback' => 'aemi_sanitize_dropdown_options',
		]);

		$wp_customize->add_setting('aemi_post_font_heading', [
			'default' => 'unset',
			'sanitize_callback' => 'aemi_sanitize_dropdown_options',
		]);

		 *
		 *
		 */

		aemi_add_settings([
			[
				'name' => 'aemi_post_single_attachment',
				'type' => 'checkbox',
				'default' => 1,
			]
		], $wp_customize);

		aemi_add_settings([
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
		], $wp_customize);

		$categories = get_categories();

		$cat_ids = [];

		foreach ($categories as $cat)
		{
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
	}
}

if (!function_exists('aemi_customizer_settings__custom_scripts'))
{
	function aemi_customizer_settings__custom_scripts($wp_customize)
	{
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

if (!function_exists('aemi_customizer_settings__widgets'))
{
	function aemi_customizer_settings__widgets($wp_customize)
	{
		$wp_customize->add_setting('aemi_widget_overlay_column_layout', [
			'default' => 'one_column',
			'sanitize_callback' => 'aemi_sanitize_dropdown_options',
		]);

		$wp_customize->add_setting('aemi_widget_overlay_width', [
			'default' => 'default_width',
			'sanitize_callback' => 'aemi_sanitize_dropdown_options',
		]);

		$wp_customize->add_setting('aemi_widget_footer_column_layout', [
			'default' => 'one_column',
			'sanitize_callback' => 'aemi_sanitize_dropdown_options',
		]);

		$wp_customize->add_setting('aemi_widget_footer_width', [
			'default' => 'default_width',
			'sanitize_callback' => 'aemi_sanitize_dropdown_options',
		]);
	}
}

if (!function_exists('aemi_customizer_settings__header'))
{
	function aemi_customizer_settings__header($wp_customize)
	{
		aemi_add_settings([
			[
				'name' => 'aemi_header_autohiding',
				'type' => 'checkbox',
				'default' => 0
			],
			[
				'name' => 'aemi_header_stickyness',
				'type' => 'radio',
				'default' => 'adaptative'
			]
		], $wp_customize);
	}
}

if (!function_exists('aemi_customizer_settings__homepage'))
{
	function aemi_customizer_settings__homepage($wp_customize)
	{

		aemi_add_settings([
			[
				'name' => 'aemi_homepage_header',
				'type' => 'checkbox',
				'default' => 0
			],
		], $wp_customize);

		$wp_customize->add_setting( 'aemi_homepage_before', array(
  			'capability' => 'edit_theme_options',
  			'sanitize_callback' => 'aemi_sanitize_dropdown_pages',
		) );

		$wp_customize->add_setting( 'aemi_homepage_after', array(
  			'capability' => 'edit_theme_options',
  			'sanitize_callback' => 'aemi_sanitize_dropdown_pages',
		) );

		$wp_customize->add_setting( 'aemi_homepage_header_custom_title', array(
  			'capability' => 'edit_theme_options',
  			'sanitize_callback' => 'sanitize_textarea_field',
		) );
		$wp_customize->add_setting( 'aemi_homepage_header_custom_subtitle', array(
  			'capability' => 'edit_theme_options',
  			'sanitize_callback' => 'sanitize_textarea_field',
		) );

	}
}

if (!function_exists('aemi_customizer_settings__identity'))
{
	function aemi_customizer_settings__identity($wp_customize)
	{
		$wp_customize->add_setting('aemi_light_scheme_logo', [
			'sanitize_callback'	=> 'aemi_sanitize_media'
		]);

		$wp_customize->add_setting('aemi_dark_scheme_logo', [
			'sanitize_callback'	=> 'aemi_sanitize_media'
		]);

		$wp_customize->add_setting('aemi_site_description', [
			'capability'		=> 'edit_theme_options',
			'sanitize_callback' => 'sanitize_textarea_field',
		]);
	}
}

if (!function_exists('aemi_customizer_settings__post_types'))
{
	function aemi_customizer_settings__post_types($wp_customize)
	{
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
					$wp_customize->add_setting( $setting, [
						'default' => 'both',
						'sanitize_callback' => 'aemi_sanitize_dropdown_options'
					]);
				}
				else if ($m_name == 'updated_date')
				{
					$wp_customize->add_setting( $setting, [
						'default' => 'none',
						'sanitize_callback' => 'aemi_sanitize_dropdown_options'
					]);
				}
				else
				{
					aemi_add_setting_checkbox($wp_customize,$setting,1);
				}
			}

			if ($p_name == "post")
			{
				$wp_customize->add_setting( aemi_setting($p_name,'show_excerpt'), [
					'default' => 'sticky_only',
					'sanitize_callback' => 'aemi_sanitize_dropdown_options'
				]);
				$wp_customize->add_setting( aemi_setting($p_name,'show_sticky_badge'), [
					'default' => 'both',
					'sanitize_callback' => 'aemi_sanitize_dropdown_options'
				]);
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
	}
}

if (!function_exists('aemi_customizer_settings__search'))
{
	function aemi_customizer_settings__search($wp_customize)
	{
		aemi_add_settings([
			[
				'name' => 'aemi_search_button_display',
				'type' => 'checkbox',
				'default' => 0
			]
		], $wp_customize);
	}
}

if (!function_exists('aemi_customizer_settings__seo'))
{
	function aemi_customizer_settings__seo($wp_customize)
	{

		aemi_add_settings([
			[
				'name' => 'aemi_add_meta_tags',
				'type' => 'checkbox',
				'default' => 0,
			],
			[
				'name' => 'aemi_add_meta_og',
				'type' => 'checkbox',
				'default' => 0,
			],
			[
				'name' => 'aemi_add_meta_twitter',
				'type' => 'checkbox',
				'default' => 0,
			],
		], $wp_customize);

		$wp_customize->add_setting('aemi_meta_twitter_card', [
			'default' => 'summary',
			'sanitize_callback' => 'aemi_sanitize_dropdown_options',
		]);

		$wp_customize->add_setting('aemi_meta_twitter_site', [
			'sanitize_callback' => 'sanitize_text_field',
		]);

		$wp_customize->add_setting('aemi_meta_twitter_creator', [
			'sanitize_callback' => 'sanitize_text_field',
		]);
	}
}