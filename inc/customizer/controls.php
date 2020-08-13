<?php

if (!function_exists('aemi_customizer_controls')) {
    function aemi_customizer_controls($wp_customize)
    {

        $wp_customize->add_control(
            new WP_Customize_Image_Control($wp_customize, 'aemi_light_scheme_logo', [
            'label'     => __('Add Light for Light Scheme', 'aemi'),
            'description'   => __('It is recommanded to set up this setting. If used, it replaces native logo setting.', 'aemi'),
            'settings'  => 'aemi_light_scheme_logo',
            'section'   => 'aemi_site_identity'
        ]));

        $wp_customize->add_control(
            new WP_Customize_Image_Control($wp_customize, 'aemi_dark_scheme_logo', [
            'label'     => __('Add Logo for Dark Scheme', 'aemi'),
            'description'   => __('It is recommanded to set up this setting.', 'aemi'),
            'settings'  => 'aemi_dark_scheme_logo',
            'section'   => 'aemi_site_identity'
        ]));

        foreach (get_post_types(['public' => true], 'objects') as $post_type)
        {
            $p_name = $post_type->name;

            $post_type_object = (object) ['post_type' => $p_name];

            $default_metas = [
                'author'            => [
                    'name' => 'author',
                    'label' => __('Author', 'aemi')
                ],
                'published_date'    => [
                    'name' => 'published_date',
                    'label' => __('Published Date', 'aemi')
                ],
                'updated_date'      => [
                    'name' => 'updated_date',
                    'label' => __('Updated Date', 'aemi')
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
                $m_name = $meta->name;
                $m_label = $meta->label;

                $setting = aemi_setting($p_name,$m_name);

                if (in_array($m_name, ['author','published_date','updated_date']))
                {
                    $wp_customize->add_control($setting, [
                        'label'         =>  esc_html__($m_label, 'aemi'),
                        'description'   =>  esc_html(
                            sprintf(
                                '%1$s %2$s %3$s.',
                                __('Choose to display', 'aemi'),
                                $meta->label,
                                __('information in single page, content loop, both or none', 'aemi')
                            )
                        ),
                        'section'   =>      'aemi_type_' . $p_name,
                        'settings'  =>      $setting,
                        'type'      =>      'radio',
                        'choices'   =>      [
                            'both'  => __('Both','aemi'),
                            'single'  => __('Single Page Only','aemi'),
                            'loop'  => __('Content Loop Only','aemi'),
                            'none'  => __('None','aemi')
                        ]
                    ]);
                }
                else
                {
                    $wp_customize->add_control($setting, [
                        'label'     =>      esc_html__($m_label, 'aemi'),
                        'description'   =>  esc_html(
                            sprintf(
                                '%1$s %2$s %3$s %4$s.',
                                __('Display', 'aemi'),
                                $m_label,
                                __('in', 'aemi'),
                                $p_name
                            )
                        ),
                        'section'   =>      'aemi_type_' . $p_name,
                        'settings'  =>      $setting,
                        'type'      =>      'checkbox'
                    ]);
                }
            }

            if ($p_name == "post")
            {
                $setting = aemi_setting($p_name,'show_excerpt');
                $wp_customize->add_control($setting, [
                    'label'     =>      esc_html__('Show Excerpt', 'aemi'),
                    'description'   =>  esc_html__('Choose to display a short excerpt of featured, non-featured, both or none of the posts.', 'aemi'),
                    'section'   =>      'aemi_type_post',
                    'settings'  =>      $setting,
                    'type'      =>      'radio',
                    'choices'   =>      [
                        'both'  => __('Both','aemi'),
                        'sticky_only'  => __('Featured Only','aemi'),
                        'non_sticky_only'  => __('Not Featured Only','aemi'),
                        'none'  => __('None','aemi')
                    ]
                ]);
                $setting = aemi_setting($p_name,'show_sticky_badge');
                $wp_customize->add_control($setting, [
                    'label'     =>      esc_html__('Show Featured Badge', 'aemi'),
                    'description'   =>  esc_html__('Choose to display a "Featured" badge on single page, content loop, both or none of the featured posts.', 'aemi'),
                    'section'   =>      'aemi_type_post',
                    'settings'  =>      $setting,
                    'type'      =>      'radio',
                    'choices'   =>      [
                        'both'  => __('Both','aemi'),
                        'single'  => __('Single Page Only','aemi'),
                        'loop'  => __('Content Loop Only','aemi'),
                        'none'  => __('None','aemi')
                    ]
                ]);
            }
            else {

                $setting = aemi_setting($p_name,'show_excerpt');

                $wp_customize->add_control($setting, [
                    'label'     =>      esc_html__('Show Excerpt', 'aemi'),
                    'description'   =>  esc_html__('Show a short excerpt of '.$p_name.'s in lists of ' .$p_name.'s.', 'aemi'),
                    'section'   =>      'aemi_type_' . $p_name,
                    'settings'  =>      $setting,
                    'type'      =>      'checkbox'
                ]);
            }

            $setting = aemi_setting($p_name,'progress_bar');

            $wp_customize->add_control($setting, [
                'label'     =>      esc_html__('Progress Bar', 'aemi'),
                'description'   =>  esc_html__('Display a progress bar that indicate what quantity of the page you read.', 'aemi'),
                'section'   =>      'aemi_type_' . $p_name,
                'settings'  =>      $setting,
                'type'      =>      'checkbox'
            ]);
        }

        $wp_customize->add_control('aemi_color_scheme', [
            'label'     =>      esc_html__('Color Scheme', 'aemi'),
            'description'   =>  esc_html__('Choose to display dark or light color scheme or make it switch automatically.', 'aemi'),
            'section'   =>      'aemi_features',
            'settings'  =>      'aemi_color_scheme',
            'type'      =>      'radio',
            'choices'   => [
                'light' =>  __('Light', 'aemi'),
                'dark'  =>  __('Dark', 'aemi'),
                'auto'  =>  __('Auto', 'aemi')
            ]
        ]);

        $wp_customize->add_control('aemi_color_scheme_user', [
            'label'     =>      esc_html__('Color Scheme User Preference', 'aemi'),
            'description'   =>  esc_html__('Choose to let user adapt color scheme to its preference.', 'aemi'),
            'section'   =>      'aemi_features',
            'settings'  =>      'aemi_color_scheme_user',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control('aemi_search_button_display', [
            'label'     =>      esc_html__('Search Button', 'aemi'),
            'description'   =>  esc_html__('Display a search button on right side of header bar.', 'aemi'),
            'section'   =>      'aemi_features',
            'settings'  =>      'aemi_search_button_display',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control('aemi_header_autohiding', [
            'label'     =>      esc_html__('Header Auto Hiding', 'aemi'),
            'description'   =>  esc_html__('Allow header bar to disappear while scrolling down and come back when scroll up occurs.', 'aemi'),
            'section'   =>      'aemi_features',
            'settings'  =>      'aemi_header_autohiding',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_remove_jquery_migrate', [
            'label'     =>      esc_html__('Remove jQuery Migrate', 'aemi'),
            'description'   =>  esc_html__('As far as Aemi needs not jQuery, Aemi needs not jQuery Migrate.', 'aemi'),
            'section'   =>      'aemi_advanced_features',
            'settings'  =>      'aemi_remove_jquery_migrate',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_remove_script_version', [
            'label'     =>      esc_html__('Remove Script Version', 'aemi'),
            'description'   =>  esc_html__('Remove script version in scripts and styles ressource URLs.', 'aemi'),
            'section'   =>      'aemi_advanced_features',
            'settings'  =>      'aemi_remove_script_version',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_remove_emojis', [
            'label'     =>      esc_html__('Remove emojis', 'aemi'),
            'description'   =>  esc_html__('Reduce requests by removing emojis scripts.', 'aemi'),
            'section'   =>      'aemi_advanced_features',
            'settings'  =>      'aemi_remove_emojis',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_remove_wpembeds', [
            'label'     =>      esc_html__('Remove WP Embeds', 'aemi'),
            'description'   =>  esc_html__('Reduce requests by removing wpembeds scripts.', 'aemi'),
            'section'   =>      'aemi_advanced_features',
            'settings'  =>      'aemi_remove_wpembeds',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_enable_svg_support', [
            'label'     =>      esc_html__('Enable SVG Upload Support', 'aemi'),
            'description'   =>  esc_html__('Administrator only.', 'aemi'),
            'section'   =>      'aemi_critical_features',
            'settings'  =>      'aemi_enable_svg_support',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_add_expire_headers', [
            'label'     =>      esc_html__('Add Expire Headers', 'aemi'),
            'description'   =>  esc_html__('Edit .htaccess file and add expire headers to improve browser caching.', 'aemi'),
            'section'   =>      'aemi_critical_features',
            'settings'  =>      'aemi_add_expire_headers',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_loop_cat_filtering', [
            'label'     =>      esc_html__('Enable Loop Filtering by Post Categories', 'aemi'),
            'description'   =>  esc_html__('Enable this feature to select which categories you want to be shown in content loop and those you do not want to see.', 'aemi'),
            'section'   =>      'aemi_loop',
            'settings'  =>      'aemi_loop_cat_filtering',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_loop_add_types', [
            'label'     =>      esc_html__('Add Custom Post Types to Content Loop', 'aemi'),
            'description'   =>  esc_html__('Enable this feature to select which custom post types to add to WordPress content loop.', 'aemi'),
            'section'   =>      'aemi_loop',
            'settings'  =>      'aemi_loop_add_types',
            'type'      =>      'checkbox',
        ]);

        $categories = get_categories();

        $cat_labels = [];

        foreach ($categories as $cat) {
            $cat_labels[$cat->cat_ID] = $cat->name;
        }

        $wp_customize->add_control( new Aemi_Customize_Control_Checkbox_Multiple(
            $wp_customize,
            'aemi_loop_cat_filters', [
                'label'     =>      esc_html__('Content Loop Post Category Filter', 'aemi'),
                'description'   =>  esc_html__('Choose post categories that will be shown in content loop.', 'aemi'),
                'section'   =>      'aemi_loop',
                'settings'  =>      'aemi_loop_cat_filters',
                'choices'   =>      $cat_labels
            ]
        ));

        $custom_types = [];

        foreach( get_post_types(['public' => true], 'objects') as $post_type )
        {
            $custom_types[$post_type->name] = $post_type->label;
        } 

        $wp_customize->add_control( new Aemi_Customize_Control_Checkbox_Multiple(
            $wp_customize,
            'aemi_loop_added_types', [
                'label'     =>      esc_html__('Custom Post Types to add', 'aemi'),
                'description'   =>  esc_html__('Choose custom post types that will be added to the content loop.', 'aemi'),
                'section'   =>      'aemi_loop',
                'settings'  =>      'aemi_loop_added_types',
                'choices'   =>      $custom_types
            ]
        ));

        $wp_customize->add_control('aemi_header_js_code', [
            'label'     =>      esc_html__('Header JS Script', 'aemi'),
            'description'   =>  esc_html__('Add JS scripts to wp-head. No need to add script tag.', 'aemi'),
            'section'   =>      'aemi_scripts',
            'type'      =>      'textarea'
        ]);

        $wp_customize->add_control('aemi_footer_js_code', [
            'label'     =>      esc_html__('Footer JS Script', 'aemi'),
            'description'   =>  esc_html__('Add JS scripts to wp-footer. No need to add script tag.', 'aemi'),
            'section'   =>      'aemi_scripts',
            'type'      =>      'textarea'
        ]);
    }
}
add_action('customize_register', 'aemi_customizer_controls');
