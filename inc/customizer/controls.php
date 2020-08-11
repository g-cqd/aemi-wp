<?php

if (!function_exists('aemi_customizer_controls')) {
    function aemi_customizer_controls($wp_customize)
    {

        $wp_customize->add_control(
            new WP_Customize_Image_Control($wp_customize, 'aemi_light_scheme_logo', [
            'label'     => 'Add Light for Light Scheme',
            'description'   => 'It is recommanded to set up this setting. If used, it replaces native logo setting.',
            'settings'  => 'aemi_light_scheme_logo',
            'section'   => 'aemi_site_identity'
        ]));

        $wp_customize->add_control(
            new WP_Customize_Image_Control($wp_customize, 'aemi_dark_scheme_logo', [
            'label'     => 'Add Logo for Dark Scheme',
            'description'   => 'It is recommanded to set up this setting.',
            'settings'  => 'aemi_dark_scheme_logo',
            'section'   => 'aemi_site_identity'
        ]));

        foreach (get_post_types(['public' => true], 'objects') as $post_type)
        {
            $post_name = $post_type->name;

            $post_type_object = (object) ['post_type' => $post_name];

            $default_metas = [
                'author'    =>  [
                    'name'  => 'author',
                    'label' => __('Author', 'aemi')
                ],
                'author_in_loop'    =>  [
                    'name'  => 'author_in_loop',
                    'label' => __('Author in Loop', 'aemi')
                ],
                'published_date'    =>  [
                    'name'  => 'published_date',
                    'label' => __('Published Date', 'aemi')
                ],
                'published_date_in_loop'    =>  [
                    'name'  => 'published_date_in_loop',
                    'label' => __('Published Date in Loop', 'aemi')
                ],
                'updated_date'  =>  [
                    'name'  => 'updated_date',
                    'label' => __('Updated Date', 'aemi')
                ],
                'updated_date_in_loop'  =>  [
                    'name'  => 'updated_date_in_loop',
                    'label' => __('Updated Date in Loop', 'aemi')
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

                $wp_customize->add_control($type_setting, [
                    'label'     =>      esc_html__($meta->label, 'aemi'),
                    'description'   =>  esc_html(
                        sprintf(
                            '%1$s %2$s %3$s %4$s.',
                            __('Display', 'aemi'),
                            $meta->label,
                            __('in', 'aemi'),
                            $post_name
                        )
                    ),
                    'section'   =>      'aemi_type_' . $post_name,
                    'settings'  =>      $type_setting,
                    'type'      =>      'checkbox'
                ]);
            }

            if ($post_name == "post")
            {
                $wp_customize->add_control('aemi_type_post_sticky', [
                    'label'     =>      esc_html__('Featured Badge', 'aemi'),
                    'description'   =>  esc_html__('Display a "Featured" badge for each featured post.', 'aemi'),
                    'section'   =>      'aemi_type_' . $post_name,
                    'settings'  =>      'aemi_type_post_sticky',
                    'type'      =>      'checkbox'
                ]);
                $wp_customize->add_control('aemi_type_post_sticky_in_loop', [
                    'label'     =>      esc_html__('Featured Badge in Loop', 'aemi'),
                    'description'   =>  esc_html__('Display a "Featured" badge for each featured post in lists of posts.', 'aemi'),
                    'section'   =>      'aemi_type_' . $post_name,
                    'settings'  =>      'aemi_type_post_sticky_in_loop',
                    'type'      =>      'checkbox'
                ]);
            }

            if ($post_name == "post" || $post_name == "page")
            {
                $show_excerpt = 'aemi_type_'.$post_name.'_show_excerpt';

                $wp_customize->add_control($show_excerpt, [
                    'label'     =>      esc_html__('Show Excerpt', 'aemi'),
                    'description'   =>  esc_html__('Show a short excerpt of '.$post_name.'s in lists of ' .$post_name.'s.', 'aemi'),
                    'section'   =>      'aemi_type_' . $post_name,
                    'settings'  =>      $show_excerpt,
                    'type'      =>      'checkbox'
                ]);

                if ($post_name == "post")
                {
                    $wp_customize->add_control('aemi_type_post_show_excerpt_when_sticky', [
                        'label'     =>      esc_html__('Show Excerpt when Featured', 'aemi'),
                        'description'   =>  esc_html__('Show a short excerpt of featured posts in lists of posts.', 'aemi'),
                        'section'   =>      'aemi_type_post',
                        'settings'  =>      'aemi_type_post_show_excerpt_when_sticky',
                        'type'      =>      'checkbox'
                    ]);   
                }
            }

            $progress_bar = 'aemi_type_' . $post_name . '_progress_bar';

            $wp_customize->add_control($progress_bar, [
                'label'     =>      esc_html__('Progress Bar', 'aemi'),
                'description'   =>  esc_html__('Display a progress bar that indicate what quantity of the page you read.', 'aemi'),
                'section'   =>      'aemi_type_' . $post_name,
                'settings'  =>      $progress_bar,
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
        
        $wp_customize->add_control('aemi_enable_svg_support', [
            'label'     =>      esc_html__('Enable SVG Upload Support', 'aemi'),
            'description'   =>  esc_html__('Administrator only.', 'aemi'),
            'section'   =>      'aemi_advanced_features',
            'settings'  =>      'aemi_enable_svg_support',
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

        $wp_customize->add_control('aemi_add_expire_headers', [
            'label'     =>      esc_html__('Add Expire Headers', 'aemi'),
            'description'   =>  esc_html__('Edit .htaccess file and add expire headers to improve browser caching.', 'aemi'),
            'section'   =>      'aemi_critical_features',
            'settings'  =>      'aemi_add_expire_headers',
            'type'      =>      'checkbox',
        ]);

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
