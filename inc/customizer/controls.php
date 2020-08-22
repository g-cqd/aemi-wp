<?php

if (!function_exists('aemi_customizer_controls__analytics'))
{
    function aemi_customizer_controls__analytics($wp_customize)
    {
        $wp_customize->add_control('aemi_ga_id', [
            'label'     =>      esc_html__('Google Analytics ID', 'aemi'),
            'description'   =>  esc_html__('Enter your Google Analytics ID to set up Google Analytics on this website.', 'aemi'),
            'section'   =>      'aemi_analytics',
            'settings'  =>      'aemi_ga_id',
            'type'      =>      'input'
        ]);


        $wp_customize->add_control( new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_ga_type', [
                'label'     =>      esc_html__('Google Analytics Method', 'aemi'),
                'description'   =>  esc_html__('Choose the method to set up Google Analytics. If "gtag.js" or "analytics.js" is selected, please fill your Google Analytics ID.', 'aemi'),
                'section'   =>      'aemi_analytics',
                'settings'  =>      'aemi_ga_type',
                'choices'   =>      [
                    'none'  => esc_html__('None','aemi'),
                    'gtag'  => esc_html__('gtag.js','aemi'),
               'analytics'  => esc_html__('analytics.js','aemi')
                ]
            ])
        );

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
    }
}

if (!function_exists('aemi_customizer_controls__colors'))
{
    function aemi_customizer_controls__colors($wp_customize)
    {
        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_color_scheme', [
            'label'     =>      esc_html__('Color Scheme', 'aemi'),
            'description'   =>  esc_html__('Choose to display dark or light color scheme or make it switch automatically.', 'aemi'),
            'section'   =>      'aemi_colors',
            'settings'  =>      'aemi_color_scheme',
            'choices'   => [
                'light' =>  esc_html__('Light', 'aemi'),
                'dark'  =>  esc_html__('Dark', 'aemi'),
                'auto'  =>  esc_html__('Auto', 'aemi')
            ]
        ]));

        $wp_customize->add_control('aemi_color_scheme_user', [
            'label'     =>      esc_html__('Color Scheme User Preference', 'aemi'),
            'description'   =>  esc_html__('Choose to let user adapt color scheme to its preference.', 'aemi'),
            'section'   =>      'aemi_colors',
            'settings'  =>      'aemi_color_scheme_user',
            'type'      =>      'checkbox'
        ]);
    }
}

if (!function_exists('aemi_customizer_controls__comments'))
{
    function aemi_customizer_controls__comments($wp_customize)
    {
        $wp_customize->add_control('aemi_display_comments', [
            'label'     =>      esc_html__('Display Comments', 'aemi'),
            'description'   =>  esc_html__('Disable this to hide comments and comment forms.', 'aemi'),
            'section'   =>      'aemi_comments',
            'settings'  =>      'aemi_display_comments',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control('aemi_remove_recent_comments_style', [
            'label'     =>      esc_html__('Remove "Recent Comments" Widget Inline CSS', 'aemi'),
            'description'   =>  esc_html__('Remove default inline-css style for "Recent Comments" Widget.', 'aemi'),
            'section'   =>      'aemi_comments',
            'settings'  =>      'aemi_remove_recent_comments_style',
            'type'      =>      'checkbox'
        ]);
    }
}

if (!function_exists('aemi_customizer_controls__content_loop'))
{
    function aemi_customizer_controls__content_loop($wp_customize)
    {
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

        $wp_customize->add_control( new Aemi_Checkbox_Multiple(
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

        $wp_customize->add_control( new Aemi_Checkbox_Multiple(
            $wp_customize,
            'aemi_loop_added_types', [
                'label'     =>      esc_html__('Custom Post Types to add', 'aemi'),
                'description'   =>  esc_html__('Choose custom post types that will be added to the content loop.', 'aemi'),
                'section'   =>      'aemi_loop',
                'settings'  =>      'aemi_loop_added_types',
                'choices'   =>      $custom_types
            ]
        ));
    }
}

if (!function_exists('aemi_customizer_controls__custom_scripts'))
{
    function aemi_customizer_controls__custom_scripts($wp_customize)
    {
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

if (!function_exists('aemi_customizer_controls__header'))
{
    function aemi_customizer_controls__header($wp_customize)
    {
        $wp_customize->add_control('aemi_header_stickyness', [
            'label'     =>      esc_html__('Header Stickyness', 'aemi'),
            'description'   =>  esc_html__('Choose to keep the header in the view (top or adaptative) while scrolling or not. Adaptative option keeps the header at the bottom of the view on mobile devices.', 'aemi'),
            'section'   =>      'aemi_header',
            'settings'  =>      'aemi_header_stickyness',
            'type'      =>      'radio',
            'choices'   =>      [
                'no'    =>      esc_html__('Do not keep in view','aemi'),
                'top'   =>      esc_html__('Keep the header to the top of the view','aemi'),
                'adaptative'   =>   esc_html__('Keep the header more accessible on mobile devices','aemi'),
            ]
        ]);

        $wp_customize->add_control('aemi_header_autohiding', [
            'label'     =>      esc_html__('Header Auto Hiding', 'aemi'),
            'description'   =>  esc_html__('Allow header bar to disappear while scrolling down and come back when scroll up occurs. Only works if "Header Stickyness" set to "Top" or "Adaptative".', 'aemi'),
            'section'   =>      'aemi_header',
            'settings'  =>      'aemi_header_autohiding',
            'type'      =>      'checkbox',
        ]);
    }
}

if (!function_exists('aemi_customizer_controls__homepage'))
{
    function aemi_customizer_controls__homepage($wp_customize)
    {
        $wp_customize->add_control( 'aemi_homepage_before', array(
            'type' => 'dropdown-pages',
            'settings' => 'aemi_homepage_before',
            'section' => 'aemi_homepage',
            'label' => __( 'Homepage - Before Main Content', 'aemi' ),
            'description' => __( 'Use this to add content before the main content of homepage. Another page can be integrated before blog post listing or before front page content for example.', 'aemi' ),
        ) );

        $wp_customize->add_control( 'aemi_homepage_after', array(
            'type' => 'dropdown-pages',
            'settings' => 'aemi_homepage_after',
            'section' => 'aemi_homepage',
            'label' => __( 'Homepage - After Main Content', 'aemi' ),
            'description' => __( 'Use this to add content after the main content of homepage. Another page can be integrated after blog post listing or after front page content.', 'aemi' ),
        ) );

        $wp_customize->add_control('aemi_homepage_header', [
            'label'     =>      esc_html__('Add a Page-Like Header to Homepage', 'aemi'),
            'description'   =>  esc_html__('', 'aemi'),
            'section'   =>      'aemi_homepage',
            'settings'  =>      'aemi_homepage_header',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control('aemi_homepage_header_custom_title', [
            'label'     =>      esc_html__('Customize Homepage Displayed Title', 'aemi'),
            'description'   =>  esc_html__('', 'aemi'),
            'section'   =>      'aemi_homepage',
            'settings'  =>      'aemi_homepage_header_custom_title',
            'type'      =>      'textarea'
        ]);
        $wp_customize->add_control('aemi_homepage_header_custom_subtitle', [
            'label'     =>      esc_html__('Customize Homepage Subtitle', 'aemi'),
            'description'   =>  esc_html__('', 'aemi'),
            'section'   =>      'aemi_homepage',
            'settings'  =>      'aemi_homepage_header_custom_subtitle',
            'type'      =>      'textarea'
        ]);
    }
}

if (!function_exists('aemi_customizer_controls__identity'))
{
    function aemi_customizer_controls__identity($wp_customize)
    {
        $wp_customize->add_control(
            new WP_Customize_Image_Control($wp_customize, 'aemi_light_scheme_logo', [
            'label'     => esc_html__('Add Light for Light Scheme', 'aemi'),
            'description'   => esc_html__('It is recommanded to set up this setting. If used, it replaces native logo setting.', 'aemi'),
            'settings'  => 'aemi_light_scheme_logo',
            'section'   => 'aemi_identity'
        ]));

        $wp_customize->add_control(
            new WP_Customize_Image_Control($wp_customize, 'aemi_dark_scheme_logo', [
            'label'     => esc_html__('Add Logo for Dark Scheme', 'aemi'),
            'description'   => esc_html__('It is recommanded to set up this setting.', 'aemi'),
            'settings'  => 'aemi_dark_scheme_logo',
            'section'   => 'aemi_identity'
        ]));

        $wp_customize->add_control( 'aemi_site_description', [
            'label'     => esc_html__('Site Description', 'aemi'),
            'description'   => esc_html__('Site Description differs from Tagline. Site description can be used in meta tags and by search engines.', 'aemi'),
            'settings'  => 'aemi_site_description',
            'section'   => 'aemi_identity',
            'type'      => 'textarea',
            'input_attrs' => [
                'placeholder' => esc_attr__( 'Description should not exceed 180 characters.', 'aemi' ),
            ]
        ]);
    }
}

if (!function_exists('aemi_customizer_controls__performance'))
{
    function aemi_customizer_controls__performance($wp_customize)
    {
        $wp_customize->add_control('aemi_remove_jquery', [
            'label'     =>      esc_html__('Remove jQuery Migrate', 'aemi'),
            'description'   =>  esc_html__('As far as Aemi needs not jQuery, Aemi needs not jQuery Migrate. Maybe do you.', 'aemi'),
            'section'   =>      'aemi_performance',
            'settings'  =>      'aemi_remove_jquery',
            'type'      =>      'radio',
            'choices'   =>      [
                'all'   =>      esc_html__('Remove every jQuery-related resources.','aemi'),
                'migrate'   =>  esc_html__('Remove only jQuery Migrate','aemi'),
                'keep'  =>      esc_html__('Do not remove and keep them all')
            ]
        ]);

        $wp_customize->add_control('aemi_remove_script_version', [
            'label'     =>      esc_html__('Remove Script Version', 'aemi'),
            'description'   =>  esc_html__('Remove script version in scripts and styles ressource URLs.', 'aemi'),
            'section'   =>      'aemi_performance',
            'settings'  =>      'aemi_remove_script_version',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_remove_emojis', [
            'label'     =>      esc_html__('Remove emojis', 'aemi'),
            'description'   =>  esc_html__('Reduce requests by removing emojis scripts.', 'aemi'),
            'section'   =>      'aemi_performance',
            'settings'  =>      'aemi_remove_emojis',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_remove_wpembeds', [
            'label'     =>      esc_html__('Remove WP Embeds', 'aemi'),
            'description'   =>  esc_html__('Reduce requests by removing wpembeds scripts.', 'aemi'),
            'section'   =>      'aemi_performance',
            'settings'  =>      'aemi_remove_wpembeds',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_remove_generator', [
            'label'     =>      esc_html__('Remove Generator Meta Tag', 'aemi'),
            'description'   =>  esc_html__('This removes display of WordPress Version.', 'aemi'),
            'section'   =>      'aemi_performance',
            'settings'  =>      'aemi_remove_generator',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_remove_rsd_link', [
            'label'     =>      esc_html__('Remove XML-RPC RSD Link', 'aemi'),
            'description'   =>  esc_html__('If you do not know what it is, you need not it, otherwise reactivate it.', 'aemi'),
            'section'   =>      'aemi_performance',
            'settings'  =>      'aemi_remove_rsd_link',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_remove_wlwmanifest_link', [
            'label'     =>      esc_html__('Remove Windows Live Writer', 'aemi'),
            'description'   =>  esc_html__('Windows Live Writer is a native Microsoft blogging software. It is not much used anymore. So Aemi Theme disables it by default.', 'aemi'),
            'section'   =>      'aemi_performance',
            'settings'  =>      'aemi_remove_wlwmanifest_link',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_remove_shortlink', [
            'label'     =>      esc_html__('Remove WordPress Shortlink', 'aemi'),
            'description'   =>  esc_html__('Shortlinks are placed in head tag. Rarely used, if you use pretty permalinks such as domain-name/post-name, you can remove them.', 'aemi'),
            'section'   =>      'aemi_performance',
            'settings'  =>      'aemi_remove_shortlink',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_add_expire_headers', [
            'label'     =>      esc_html__('Add Expire Headers', 'aemi'),
            'description'   =>  esc_html__('Edit .htaccess file and add expire headers to improve browser caching.', 'aemi'),
            'section'   =>      'aemi_performance',
            'settings'  =>      'aemi_add_expire_headers',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_add_compression', [
            'label'     =>      esc_html__('Add Compression', 'aemi'),
            'description'   =>  esc_html__('Reduce global resource transfer size.', 'aemi'),
            'section'   =>      'aemi_performance',
            'settings'  =>      'aemi_add_compression',
            'choices'   =>      [
                'none'  =>  esc_html__('None','aemi'),
                'gzip'  =>  esc_html__('GZip','aemi'),
                'brotli'  =>  esc_html__('Brotli','aemi'),
                'all'  =>  esc_html__('All','aemi'),
            ]
        ]));

        $wp_customize->add_control('aemi_remove_apiworg', [
            'label'     =>      esc_html__('Remove WordPress REST API', 'aemi'),
            'description'   =>  esc_html__('Remove REST API in Wordpress. Mostly used admin-side, perhaps by some of your plugins on public side. Non-admn', 'aemi'),
            'section'   =>      'aemi_performance',
            'settings'  =>      'aemi_remove_apiworg',
            'type'      =>      'radio',
            'choices'   =>      [
                'all'   => esc_html__('Remove for All Users','aemi'),
                'non-admins'     => esc_html__('Remove for Non-Admins Users'),
                'public'     => esc_html__('Remove for Public Users'),
                'keep'     => esc_html__('Keep it enabled')
            ]
        ]);

        $wp_customize->add_control('aemi_add_keep_alive', [
            'label'     =>      esc_html__('Add Keep Alive Headers', 'aemi'),
            'description'   =>  esc_html__('Prevent browser to create a connection to server for each request.', 'aemi'),
            'section'   =>      'aemi_performance',
            'settings'  =>      'aemi_add_keep_alive',
            'type'      =>      'checkbox',
        ]);
    }
}

if (!function_exists('aemi_customizer_controls__post_types'))
{
    function aemi_customizer_controls__post_types($wp_customize)
    {
        foreach (get_post_types(['public' => true], 'objects') as $post_type)
        {
            $p_name = $post_type->name;

            $post_type_object = (object) ['post_type' => $p_name];

            $default_metas = [
                'author'            => [
                    'name' => 'author',
                    'label' => esc_html__('Author', 'aemi')
                ],
                'published_date'    => [
                    'name' => 'published_date',
                    'label' => esc_html__('Published Date', 'aemi')
                ],
                'updated_date'      => [
                    'name' => 'updated_date',
                    'label' => esc_html__('Updated Date', 'aemi')
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
                    $wp_customize->add_control(new Aemi_Dropdown_Options(
                        $wp_customize,
                        $setting, [
                        'label'         =>  esc_html__($m_label, 'aemi'),
                        'description'   =>  esc_html__(
                            sprintf(
                                '%1$s %2$s %3$s.',
                                esc_html__('Choose to display', 'aemi'),
                                $meta->label,
                                esc_html__('information in single page, content loop, both or none', 'aemi')
                            )
                        ),
                        'section'   =>      'aemi_type_' . $p_name,
                        'settings'  =>      $setting,
                        'choices'   =>      [
                            'both'  => esc_html__('Both','aemi'),
                            'single'  => esc_html__('Single Page Only','aemi'),
                            'loop'  => esc_html__('Content Loop Only','aemi'),
                            'none'  => esc_html__('None','aemi')
                        ]
                    ]));
                }
                else
                {
                    $wp_customize->add_control($setting, [
                        'label'     =>      esc_html__($m_label, 'aemi'),
                        'description'   =>  esc_html__(
                            sprintf(
                                '%1$s %2$s %3$s %4$s.',
                                esc_html__('Display', 'aemi'),
                                $m_label,
                                esc_html__('in', 'aemi'),
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
                $wp_customize->add_control(new Aemi_Dropdown_Options(
                    $wp_customize,
                    $setting, [
                    'label'     =>      esc_html__('Show Excerpt', 'aemi'),
                    'description'   =>  esc_html__('Choose to display a short excerpt of featured, non-featured, both or none of the posts.', 'aemi'),
                    'section'   =>      'aemi_type_post',
                    'settings'  =>      $setting,
                    'choices'   =>      [
                        'both'  => esc_html__('Both','aemi'),
                        'sticky_only'  => esc_html__('Featured Only','aemi'),
                        'non_sticky_only'  => esc_html__('Not Featured Only','aemi'),
                        'none'  => esc_html__('None','aemi')
                    ]
                ]));
                $setting = aemi_setting($p_name,'show_sticky_badge');
                $wp_customize->add_control(new Aemi_Dropdown_Options(
                    $wp_customize,
                    $setting, [
                    'label'     =>      esc_html__('Show Featured Badge', 'aemi'),
                    'description'   =>  esc_html__('Choose to display a "Featured" badge on single page, content loop, both or none of the featured posts.', 'aemi'),
                    'section'   =>      'aemi_type_post',
                    'settings'  =>      $setting,
                    'choices'   =>      [
                        'both'  => esc_html__('Both','aemi'),
                        'single'  => esc_html__('Single Page Only','aemi'),
                        'loop'  => esc_html__('Content Loop Only','aemi'),
                        'none'  => esc_html__('None','aemi')
                    ]
                ]));
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
    }
}

if (!function_exists('aemi_customizer_controls__search'))
{
    function aemi_customizer_controls__search($wp_customize)
    {
        $wp_customize->add_control('aemi_search_button_display', [
            'label'     =>      esc_html__('Search Button', 'aemi'),
            'description'   =>  esc_html__('Display a search button on right side of header bar.', 'aemi'),
            'section'   =>      'aemi_search',
            'settings'  =>      'aemi_search_button_display',
            'type'      =>      'checkbox'
        ]);
    }
}

if (!function_exists('aemi_customizer_controls__security'))
{
    function aemi_customizer_controls__security($wp_customize)
    {
        $wp_customize->add_control('aemi_add_content_nosniff', [
            'label'     =>      esc_html__('Prevent MIME Type Autodetection', 'aemi'),
            'description'   =>  esc_html__('Avoid browsers to autodected MIME Type and prevent browser to execute an image as a script for example.', 'aemi'),
            'section'   =>      'aemi_security',
            'settings'  =>      'aemi_add_content_nosniff',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_add_xframe_options', [
            'label'     =>      esc_html__('Add X-Frame-Options Header', 'aemi'),
            'description'   =>  esc_html__('X-Frame Options prevent your website to be embedded in <frame>, <iframe>, <embed> or <object> tags.', 'aemi'),
            'section'   =>      'aemi_security',
            'settings'  =>      'aemi_add_xframe_options',
            'choices'   =>      [
                'not-set'   =>  esc_html__('Not set','aemi'),
                'deny'      =>  esc_html__('Deny','aemi'),
                'sameorigin'   =>  esc_html__('Same Origin','aemi')
            ]
        ]));

        $wp_customize->add_control('aemi_add_hsts', [
            'label'     =>      esc_html__('Add HTTP Strict Transport Security Header', 'aemi'),
            'description'   =>  esc_html__('Force use of HTTPS on every resource loaded by your website.', 'aemi'),
            'section'   =>      'aemi_security',
            'settings'  =>      'aemi_add_hsts',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_add_xss', [
            'label'     =>      esc_html__('Add X-XSS Protection Header', 'aemi'),
            'description'   =>  esc_html__('Prevent Cross-Scripting attacks.', 'aemi'),
            'section'   =>      'aemi_security',
            'settings'  =>      'aemi_add_xss',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_add_expect_ct', [
            'label'     =>      esc_html__('Add Expect-CT Header', 'aemi'),
            'description'   =>  esc_html__('Tell browsers to enforce policy about Certificate Transparency.', 'aemi'),
            'section'   =>      'aemi_security',
            'settings'  =>      'aemi_add_expect_ct',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_add_csph', [
             'label'     =>      esc_html__('Add Content Security Policy Header', 'aemi'),
             'description'   =>  esc_html__('Content Security Policy (CSP) is an added layer of security that helps to detect and mitigate certain types of attacks, including Cross Site Scripting (XSS) and data injection attacks. – from Mozilla Developer Network', 'aemi'),
             'section'   =>      'aemi_security',
             'settings'  =>      'aemi_add_csph',
             'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_add_referer', [
             'label'     =>      esc_html__('Add Referer Policy Header', 'aemi'),
             'description'   =>  esc_html__('Referrer Policy allows control of information about origin website sent to destination website during navigation.', 'aemi'),
             'section'   =>      'aemi_security',
             'settings'  =>      'aemi_add_referer',
             'choices'  => [
                'not-set'                        => esc_html__('Not set','aemi'),
                'no-referrer'                       => esc_html__('No Referrer', 'aemi'),
                'no-referrer-when-downgrade'        => esc_html__('No Referrer when Downgrade', 'aemi'),
                'same-origin'                       => esc_html__('Same Origin', 'aemi'),
                'origin'                            => esc_html__('Origin', 'aemi'),
                'strict-origin'                     => esc_html__('Strict Origin', 'aemi'),
                'origin-when-cross-origin'          => esc_html__('Origin when Cross Origin', 'aemi'),
                'strict-origin-when-cross-origin'   => esc_html__('Strict Origin when Cross-Origin', 'aemi'),
                'unsafe-url'                        => esc_html__('Unsafe URL', 'aemi'),
             ]
        ]));

        $wp_customize->add_control('aemi_enable_svg_support', [
            'label'     =>      esc_html__('Enable SVG Upload Support', 'aemi'),
            'description'   =>  esc_html__('Administrator only.', 'aemi'),
            'section'   =>      'aemi_security',
            'settings'  =>      'aemi_enable_svg_support',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_add_powered_by', [
            'label'     =>      esc_html__('Remove X-Powered-By Header', 'aemi'),
            'description'   =>  esc_html__('Reduce informations disclosed in HTTP Headers.', 'aemi'),
            'section'   =>      'aemi_security',
            'settings'  =>      'aemi_add_powered_by',
            'type'      =>      'checkbox',
        ]);
    }
}

if (!function_exists('aemi_customizer_controls__seo'))
{
    function aemi_customizer_controls__seo($wp_customize)
    {
        $wp_customize->add_control( 'aemi_add_meta_tags', [
            'label'     =>      esc_html__('Enable Meta Tags', 'aemi'),
            'description'   =>  esc_html__('Be able to fill author, description and keywords informations to define your content to search engines.', 'aemi'),
            'section'   =>      'aemi_seo',
            'settings'  =>      'aemi_add_meta_tags',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control( 'aemi_add_meta_og', [
            'label'     =>      esc_html__('Enable Open Graph', 'aemi'),
            'description'   =>  esc_html__('Open Graph is an internet protocol that was originally created by Facebook to standardize the use of metadata within a webpage to represent the content of a page. – from freeCodeCamp', 'aemi'),
            'section'   =>      'aemi_seo',
            'settings'  =>      'aemi_add_meta_og',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control( 'aemi_add_meta_twitter', [
            'label'     =>      esc_html__('Enable Twitter Cards', 'aemi'),
            'description'   =>  esc_html__('Add Twitter-specific informations to your content.', 'aemi'),
            'section'   =>      'aemi_seo',
            'settings'  =>      'aemi_add_meta_twitter',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_meta_twitter_card', [
             'label'     =>      esc_html__('Twitter Card Type', 'aemi'),
             'description'   =>  esc_html__('How would you like your content to be displayed in tweets.', 'aemi'),
             'section'   =>      'aemi_seo',
             'settings'  =>      'aemi_meta_twitter_card',
             'choices'  => [
                'summary'                       => esc_html__('Summary Card', 'aemi'),
                'summary_large_image'           => esc_html__('Summary Card with Large Image', 'aemi'),  
             ]
        ]));

        $wp_customize->add_control('aemi_meta_twitter_site', [
            'label'     =>      esc_html__('Twitter: Site Information', 'aemi'),
            'description'   =>  esc_html__('Enter your @username for the website used in the card footer.', 'aemi'),
            'section'   =>      'aemi_seo',
            'settings'  =>      'aemi_meta_twitter_site',
            'type'      =>      'input'
        ]);

        $wp_customize->add_control('aemi_meta_twitter_creator', [
            'label'     =>      esc_html__('Twitter: Creator Information', 'aemi'),
            'description'   =>  esc_html__('Enter your @username for the content creator / author.', 'aemi'),
            'section'   =>      'aemi_seo',
            'settings'  =>      'aemi_meta_twitter_creator',
            'type'      =>      'input'
        ]);
    }
}