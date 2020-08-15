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

        $wp_customize->add_control('aemi_display_comments', [
            'label'     =>      esc_html__('Display Comments', 'aemi'),
            'description'   =>  esc_html__('Disable this to hide comments and comment forms.', 'aemi'),
            'section'   =>      'aemi_comments',
            'settings'  =>      'aemi_display_comments',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control('aemi_search_button_display', [
            'label'     =>      esc_html__('Search Button', 'aemi'),
            'description'   =>  esc_html__('Display a search button on right side of header bar.', 'aemi'),
            'section'   =>      'aemi_search',
            'settings'  =>      'aemi_search_button_display',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control('aemi_header_stickyness', [
            'label'     =>      esc_html__('Header Stickyness', 'aemi'),
            'description'   =>  esc_html__('Choose to keep the header in the view (top or adaptative) while scrolling or not. Adaptative option keeps the header at the bottom of the view on mobile devices.', 'aemi'),
            'section'   =>      'aemi_header',
            'settings'  =>      'aemi_header_stickyness',
            'type'      =>      'radio',
            'choices'   =>      [
                'no'    =>      __('Do not keep in view','aemi'),
                'top'   =>      __('Keep the header to the top of the view','aemi'),
                'adaptative'   =>   __('Keep the header more accessible on mobile devices','aemi'),
            ]
        ]);

        $wp_customize->add_control('aemi_header_autohiding', [
            'label'     =>      esc_html__('Header Auto Hiding', 'aemi'),
            'description'   =>  esc_html__('Allow header bar to disappear while scrolling down and come back when scroll up occurs. Only works if "Header Stickyness" set to "Top" or "Adaptative".', 'aemi'),
            'section'   =>      'aemi_header',
            'settings'  =>      'aemi_header_autohiding',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_remove_jquery', [
            'label'     =>      esc_html__('Remove jQuery Migrate', 'aemi'),
            'description'   =>  esc_html__('As far as Aemi needs not jQuery, Aemi needs not jQuery Migrate. Maybe do you.', 'aemi'),
            'section'   =>      'aemi_advanced_features',
            'settings'  =>      'aemi_remove_jquery',
            'type'      =>      'radio',
            'choices'   =>      [
                'all'   =>      __('Remove every jQuery-related resources.','aemi'),
                'migrate'   =>  __('Remove only jQuery Migrate','aemi'),
                'keep'  =>      __('Do not remove and keep them all')
            ]
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

        $wp_customize->add_control('aemi_remove_generator', [
            'label'     =>      esc_html__('Remove Generator Meta Tag', 'aemi'),
            'description'   =>  esc_html__('This removes display of WordPress Version.', 'aemi'),
            'section'   =>      'aemi_advanced_features',
            'settings'  =>      'aemi_remove_generator',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_remove_rsd_link', [
            'label'     =>      esc_html__('Remove XML-RPC RSD Link', 'aemi'),
            'description'   =>  esc_html__('If you do not know what it is, you need not it, otherwise reactivate it.', 'aemi'),
            'section'   =>      'aemi_advanced_features',
            'settings'  =>      'aemi_remove_rsd_link',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_remove_wlwmanifest_link', [
            'label'     =>      esc_html__('Remove Windows Live Writer', 'aemi'),
            'description'   =>  esc_html__('Windows Live Writer is a native Microsoft blogging software. It is not much used anymore. So Aemi Theme disables it by default.', 'aemi'),
            'section'   =>      'aemi_advanced_features',
            'settings'  =>      'aemi_remove_wlwmanifest_link',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_remove_shortlink', [
            'label'     =>      esc_html__('Remove WordPress Shortlink', 'aemi'),
            'description'   =>  esc_html__('Shortlinks are placed in head tag. Rarely used, if you use pretty permalinks such as domain-name/post-name, you can remove them.', 'aemi'),
            'section'   =>      'aemi_advanced_features',
            'settings'  =>      'aemi_remove_shortlink',
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

        $wp_customize->add_control('aemi_remove_apiworg', [
            'label'     =>      esc_html__('Remove WordPress REST API', 'aemi'),
            'description'   =>  esc_html__('Remove REST API in Wordpress. Mostly used admin-side, perhaps by some of your plugins on public side. Non-admn', 'aemi'),
            'section'   =>      'aemi_critical_features',
            'settings'  =>      'aemi_remove_apiworg',
            'type'      =>      'radio',
            'choices'   =>      [
                'all'   => __('Remove for All Users','aemi'),
                'non-admins'     => __('Remove for Non-Admins Users'),
                'public'     => __('Remove for Public Users'),
                'keep'     => __('Keep it enabled')
            ]
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

        $wp_customize->add_control('aemi_ga_id', [
            'label'     =>      esc_html__('Google Analytics ID', 'aemi'),
            'description'   =>  esc_html__('Enter your Google Analytics ID to set up Google Analytics on this website.', 'aemi'),
            'section'   =>      'aemi_analytics',
            'settings'  =>      'aemi_ga_id',
            'type'      =>      'input'
        ]);


        $wp_customize->add_control('aemi_ga_type', [
            'label'     =>      esc_html__('Google Analytics Method', 'aemi'),
            'description'   =>  esc_html__('Choose the method to set up Google Analytics. If "gtag.js" or "analytics.js" is selected, please fill your Google Analytics ID.', 'aemi'),
            'section'   =>      'aemi_analytics',
            'settings'  =>      'aemi_ga_type',
            'type'      =>      'radio',
            'choices'   =>      [
                'none'  => __('None','aemi'),
                'gtag'  => __('gtag.js','aemi'),
                'analytics'  => __('analytics.js','aemi')
            ]
        ]);

        $wp_customize->add_control('aemi_bing_meta_tag', [
            'label'     =>      esc_html__('Enable Bing Meta Tag', 'aemi'),
            'description'   =>  esc_html__('Enable this feature to be able to set up Bing Webmaster Tools on this website.', 'aemi'),
            'section'   =>      'aemi_analytics',
            'settings'  =>      'aemi_bing_meta_tag',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control('aemi_bing_meta_tag_content', [
            'label'     =>      esc_html__('Bing Meta Tag', 'aemi'),
            'description'   =>  esc_html__('Enter your Bing Meta Tag to set up Bing Webmaster Tools on this website.', 'aemi'),
            'section'   =>      'aemi_analytics',
            'settings'  =>      'aemi_bing_meta_tag_content',
            'type'      =>      'input'
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
