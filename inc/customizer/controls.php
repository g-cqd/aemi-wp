<?php

if (!function_exists('aemi_customizer_controls__analytics'))
{
    function aemi_customizer_controls__analytics($wp_customize)
    {
        $wp_customize->add_control('aemi_ga_id', [
            'label'     =>      __('Google Analytics ID', 'aemi'),
            'description'   =>  __('Enter your Google Analytics ID to set up Google Analytics on this website.', 'aemi'),
            'section'   =>      'aemi_analytics',
            'settings'  =>      'aemi_ga_id',
            'type'      =>      'input'
        ]);


        $wp_customize->add_control( new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_ga_type', [
                'label'     =>      __('Google Analytics Method', 'aemi'),
                'description'   =>  __('Choose the method to set up Google Analytics. If "gtag.js" or "analytics.js" is selected, please fill your Google Analytics ID.', 'aemi'),
                'section'   =>      'aemi_analytics',
                'settings'  =>      'aemi_ga_type',
                'choices'   =>      [
                    'none'  => __('None','aemi'),
                    'gtag'  => __('gtag.js','aemi'),
               'analytics'  => __('analytics.js','aemi')
                ]
            ])
        );

        $wp_customize->add_control('aemi_bing_meta_tag', [
            'label'     =>      __('Enable Bing Meta Tag', 'aemi'),
            'description'   =>  __('Enable this feature to be able to set up Bing Webmaster Tools on this website.', 'aemi'),
            'section'   =>      'aemi_analytics',
            'settings'  =>      'aemi_bing_meta_tag',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control('aemi_bing_meta_tag_content', [
            'label'     =>      __('Bing Meta Tag', 'aemi'),
            'description'   =>  __('Enter your Bing Meta Tag to set up Bing Webmaster Tools on this website.', 'aemi'),
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
            'label'     =>      __('Color Scheme', 'aemi'),
            'description'   =>  __('Choose to display dark or light color scheme or make it switch automatically.', 'aemi'),
            'section'   =>      'aemi_colors',
            'settings'  =>      'aemi_color_scheme',
            'choices'   => [
                'light' =>  __('Light', 'aemi'),
                'dark'  =>  __('Dark', 'aemi'),
                'auto'  =>  __('Auto', 'aemi')
            ]
        ]));

        $wp_customize->add_control('aemi_color_scheme_user', [
            'label'     =>      __('Color Scheme User Preference', 'aemi'),
            'description'   =>  __('Choose to let user adapt color scheme to its preference.', 'aemi'),
            'section'   =>      'aemi_colors',
            'settings'  =>      'aemi_color_scheme_user',
            'type'      =>      'checkbox'
        ]);
    }
}

if (!function_exists('aemi_customizer_controls__content_loop'))
{
    function aemi_customizer_controls__content_loop($wp_customize)
    {

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_post_layout', [
             'label'     =>      __('Post Listing Layout', 'aemi'),
             'description'   =>  __('How would you like your post listings to be displayed.', 'aemi'),
             'section'   =>      'aemi_loop',
             'settings'  =>      'aemi_post_layout',
             'choices'  => [
                'no_img'                 => __('Cards without Image', 'aemi'),
                'stack'                  => __('Cards with Image', 'aemi'),
                'cover'                  => __('Cards with Background Image', 'aemi'),
             ]
        ]));

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_post_width', [
             'label'     =>      __('Post Listing Width', 'aemi'),
             'description'   =>  __('Change post listing (content loop layout) width.', 'aemi'),
             'section'   =>      'aemi_loop',
             'settings'  =>      'aemi_post_width',
             'choices'  => [
                'default_width'                => __('Default Width', 'aemi'),
                'wider_width'                   => __('Wider Width', 'aemi'),
                'near_width'                   => __('Near Full Width', 'aemi'),
                'full_width'                  => __('Full Width', 'aemi')
             ]
        ]));

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_post_column_layout', [
             'label'     =>      __('Post Listing Column Layout', 'aemi'),
             'description'   =>  __('Choose maximum number of column to display post in near-full-width and full width.', 'aemi'),
             'section'   =>      'aemi_loop',
             'settings'  =>      'aemi_post_column_layout',
             'choices'  => [
                'one_column'       => __('Single Column', 'aemi'),
                'two_columns'       => __('Two Columns', 'aemi'),
                'three_columns'     => __('Three Columns', 'aemi')
             ]
        ]));

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_post_sticky_width', [
             'label'     =>      __('Sticky Post Layout in Listing ', 'aemi'),
             'description'   =>  __('Choose maximum number of column to display post in near-full-width and full width.', 'aemi'),
             'section'   =>      'aemi_loop',
             'settings'  =>      'aemi_post_sticky_width',
             'choices'  => [
                'span_1'       => __('One Column', 'aemi'),
                'span_2'       => __('Two Columns', 'aemi'),
                'span_full'     => __('Full Width', 'aemi')
             ]
        ]));

        $wp_customize->add_control( 'aemi_post_single_attachment', [
            'label'     =>      __('Display Attachment on Single Content Page', 'aemi'),
            'description'   =>  __('Choose to display a featured image for your single-page content.', 'aemi'),
            'section'   =>      'aemi_loop',
            'settings'  =>      'aemi_post_single_attachment',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control('aemi_loop_cat_filtering', [
            'label'     =>      __('Enable Loop Filtering by Post Categories', 'aemi'),
            'description'   =>  __('Enable this feature to select which categories you want to be shown in content loop and those you do not want to see.', 'aemi'),
            'section'   =>      'aemi_loop',
            'settings'  =>      'aemi_loop_cat_filtering',
            'type'      =>      'checkbox',
        ]);

        $wp_customize->add_control('aemi_loop_add_types', [
            'label'     =>      __('Add Custom Post Types to Content Loop', 'aemi'),
            'description'   =>  __('Enable this feature to select which custom post types to add to WordPress content loop.', 'aemi'),
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
                'label'     =>      __('Content Loop Post Category Filter', 'aemi'),
                'description'   =>  __('Choose post categories that will be shown in content loop.', 'aemi'),
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
                'label'     =>      __('Custom Post Types to add', 'aemi'),
                'description'   =>  __('Choose custom post types that will be added to the content loop.', 'aemi'),
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
            'label'     =>      __('Header JS Script', 'aemi'),
            'description'   =>  __('Add JS scripts to wp-head. No need to add script tag.', 'aemi'),
            'section'   =>      'aemi_scripts',
            'type'      =>      'textarea'
        ]);

        $wp_customize->add_control('aemi_footer_js_code', [
            'label'     =>      __('Footer JS Script', 'aemi'),
            'description'   =>  __('Add JS scripts to wp-footer. No need to add script tag.', 'aemi'),
            'section'   =>      'aemi_scripts',
            'type'      =>      'textarea'
        ]);
    }
}

if (!function_exists('aemi_customizer_controls__footer'))
{
    function aemi_customizer_controls__footer($wp_customize)
    {

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_footer_width', [
             'label'     =>      __('Footer Width', 'aemi'),
             'description'   =>  __('Change footer width.', 'aemi'),
             'section'   =>      'aemi_footer',
             'settings'  =>      'aemi_footer_width',
             'choices'  => [
                'default_width'                => __('Default Width', 'aemi'),
                'wider_width'                   => __('Wider Width', 'aemi'),
                'near_width'                   => __('Near Full Width', 'aemi'),
                'full_width'                  => __('Full Width', 'aemi')
             ]
        ]));

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_footer_column_layout', [
             'label'     =>      __('Footer Column Layout', 'aemi'),
             'description'   =>  __('Choose maximum number of column to display widgets in Footer.', 'aemi'),
             'section'   =>      'aemi_footer',
             'settings'  =>      'aemi_footer_column_layout',
             'choices'  => [
                'one_column'       => __('Single Column', 'aemi'),
                'two_columns'       => __('Two Columns', 'aemi'),
                'three_columns'     => __('Three Columns', 'aemi'),
                'four_columns'     => __('Four Columns', 'aemi')
             ]
        ]));
    }
}

if (!function_exists('aemi_customizer_controls__header'))
{
    function aemi_customizer_controls__header($wp_customize)
    {
        $wp_customize->add_control('aemi_header_stickyness', [
            'label'     =>      __('Header Stickyness', 'aemi'),
            'description'   =>  __('Choose to keep the header in the view (top or adaptative) while scrolling or not. Adaptative option keeps the header at the bottom of the view on mobile devices.', 'aemi'),
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
            'label'     =>      __('Header Auto Hiding', 'aemi'),
            'description'   =>  __('Allow header bar to disappear while scrolling down and come back when scroll up occurs. Only works if "Header Stickyness" set to "Top" or "Adaptative".', 'aemi'),
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
            'label'     =>      __('Add a Page-Like Header to Homepage', 'aemi'),
            'description'   =>  __('Add a custom page-like header to your homepage to make it more user-friendly and search-engine-friendly.', 'aemi'),
            'section'   =>      'aemi_homepage',
            'settings'  =>      'aemi_homepage_header',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control('aemi_homepage_header_custom_title', [
            'label'     =>      __('Customize Homepage Displayed Title', 'aemi'),
            'description'   =>  __('Set a custom title for your homepage.', 'aemi'),
            'section'   =>      'aemi_homepage',
            'settings'  =>      'aemi_homepage_header_custom_title',
            'type'      =>      'textarea'
        ]);
        $wp_customize->add_control('aemi_homepage_header_custom_subtitle', [
            'label'     =>      __('Customize Homepage Subtitle', 'aemi'),
            'description'   =>  __('Set a custom subtitle for your homepage', 'aemi'),
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
            'label'     => __('Add Light for Light Scheme', 'aemi'),
            'description'   => __('It is recommanded to set up this setting. If used, it replaces native logo setting.', 'aemi'),
            'settings'  => 'aemi_light_scheme_logo',
            'section'   => 'aemi_identity'
        ]));

        $wp_customize->add_control(
            new WP_Customize_Image_Control($wp_customize, 'aemi_dark_scheme_logo', [
            'label'     => __('Add Logo for Dark Scheme', 'aemi'),
            'description'   => __('It is recommanded to set up this setting.', 'aemi'),
            'settings'  => 'aemi_dark_scheme_logo',
            'section'   => 'aemi_identity'
        ]));

        $wp_customize->add_control( 'aemi_site_description', [
            'label'     => __('Site Description', 'aemi'),
            'description'   => __('Site Description differs from Tagline. Site description can be used in meta tags and by search engines.', 'aemi'),
            'settings'  => 'aemi_site_description',
            'section'   => 'aemi_identity',
            'type'      => 'textarea',
            'input_attrs' => [
                'placeholder' => esc_attr__( 'Description should not exceed 180 characters.', 'aemi' ),
            ]
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
                    $wp_customize->add_control(new Aemi_Dropdown_Options(
                        $wp_customize,
                        $setting, [
                        'label' =>  $m_label,
                        'description'   =>  sprintf(
                            '%1$s %2$s %3$s.',
                            __('Choose to display', 'aemi'),
                            $meta->label,
                            __('information in single page, content loop, both or none', 'aemi')
                        ),
                        'section'   =>  'aemi_type_' . $p_name,
                        'settings'  =>  $setting,
                        'choices'   =>  [
                            'both'  => __('Both','aemi'),
                            'single'  => __('Single Page Only','aemi'),
                            'loop'  => __('Content Loop Only','aemi'),
                            'none'  => __('None','aemi')
                        ]
                    ]));
                }
                else
                {
                    $wp_customize->add_control($setting, [
                        'label'     =>      $m_label,
                        'description'   =>  sprintf(
                                '%1$s %2$s %3$s %4$s.',
                            __('Display', 'aemi'),
                            $m_label,
                            __('in', 'aemi'),
                            $p_name
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
                    'label'     =>      __('Show Excerpt', 'aemi'),
                    'description'   =>  __('Choose to display a short excerpt of featured, non-featured, both or none of the posts.', 'aemi'),
                    'section'   =>      'aemi_type_post',
                    'settings'  =>      $setting,
                    'choices'   =>      [
                        'both'  => __('Both','aemi'),
                        'sticky_only'  => __('Featured Only','aemi'),
                        'non_sticky_only'  => __('Not Featured Only','aemi'),
                        'none'  => __('None','aemi')
                    ]
                ]));
                $setting = aemi_setting($p_name,'show_sticky_badge');
                $wp_customize->add_control(new Aemi_Dropdown_Options(
                    $wp_customize,
                    $setting, [
                    'label'     =>      __('Show Featured Badge', 'aemi'),
                    'description'   =>  __('Choose to display a "Featured" badge on single page, content loop, both or none of the featured posts.', 'aemi'),
                    'section'   =>      'aemi_type_post',
                    'settings'  =>      $setting,
                    'choices'   =>      [
                        'both'  => __('Both','aemi'),
                        'single'  => __('Single Page Only','aemi'),
                        'loop'  => __('Content Loop Only','aemi'),
                        'none'  => __('None','aemi')
                    ]
                ]));
            }
            else {

                $setting = aemi_setting($p_name,'show_excerpt');

                $wp_customize->add_control($setting, [
                    'label'     =>      __('Show Excerpt', 'aemi'),
                    'description'   =>  sprintf(
                        '%1$s %2$s%3$s %2$s %4$s.',
                        __('Show a short excerpt of','aemi'),
                        $p_name,
                        __('s in lists of','aemi'),
                        $p_name,
                        __('s','aemi'),
                    ),
                    'section'   =>      'aemi_type_' . $p_name,
                    'settings'  =>      $setting,
                    'type'      =>      'checkbox'
                ]);
            }

            $setting = aemi_setting($p_name,'progress_bar');

            $wp_customize->add_control($setting, [
                'label'     =>      __('Progress Bar', 'aemi'),
                'description'   =>  __('Display a progress bar that indicate what quantity of the page you read.', 'aemi'),
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
            'label'     =>      __('Search Button', 'aemi'),
            'description'   =>  __('Display a search button on right side of header bar.', 'aemi'),
            'section'   =>      'aemi_search',
            'settings'  =>      'aemi_search_button_display',
            'type'      =>      'checkbox'
        ]);
    }
}


if (!function_exists('aemi_customizer_controls__seo'))
{
    function aemi_customizer_controls__seo($wp_customize)
    {
        $wp_customize->add_control( 'aemi_add_meta_tags', [
            'label'     =>      __('Enable Meta Tags', 'aemi'),
            'description'   =>  __('Be able to fill author, description and keywords informations to define your content to search engines.', 'aemi'),
            'section'   =>      'aemi_seo',
            'settings'  =>      'aemi_add_meta_tags',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control( 'aemi_add_meta_og', [
            'label'     =>      __('Enable Open Graph', 'aemi'),
            'description'   =>  __('Open Graph is an internet protocol that was originally created by Facebook to standardize the use of metadata within a webpage to represent the content of a page. – from freeCodeCamp', 'aemi'),
            'section'   =>      'aemi_seo',
            'settings'  =>      'aemi_add_meta_og',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control( 'aemi_add_meta_twitter', [
            'label'     =>      __('Enable Twitter Cards', 'aemi'),
            'description'   =>  __('Add Twitter-specific informations to your content.', 'aemi'),
            'section'   =>      'aemi_seo',
            'settings'  =>      'aemi_add_meta_twitter',
            'type'      =>      'checkbox'
        ]);

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_meta_twitter_card', [
             'label'     =>      __('Twitter Card Type', 'aemi'),
             'description'   =>  __('How would you like your content to be displayed in tweets.', 'aemi'),
             'section'   =>      'aemi_seo',
             'settings'  =>      'aemi_meta_twitter_card',
             'choices'  => [
                'summary'   => __('Summary Card', 'aemi'),
                'summary_large_image'   => __('Summary Card with Large Image', 'aemi'),  
             ]
        ]));

        $wp_customize->add_control('aemi_meta_twitter_site', [
            'label'     =>      __('Twitter: Site Information', 'aemi'),
            'description'   =>  __('Enter your @username for the website used in the card footer.', 'aemi'),
            'section'   =>      'aemi_seo',
            'settings'  =>      'aemi_meta_twitter_site',
            'type'      =>      'input'
        ]);

        $wp_customize->add_control('aemi_meta_twitter_creator', [
            'label'     =>      __('Twitter: Creator Information', 'aemi'),
            'description'   =>  __('Enter your @username for the content creator / author.', 'aemi'),
            'section'   =>      'aemi_seo',
            'settings'  =>      'aemi_meta_twitter_creator',
            'type'      =>      'input'
        ]);
    }
}

if (!function_exists('aemi_customizer_controls__widgets'))
{
    function aemi_customizer_controls__widgets($wp_customize)
    {

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_widget_footer_width', [
             'label'     =>      __('Footer Widget Area Width', 'aemi'),
             'description'   =>  __('Change footer widget area width.', 'aemi'),
             'section'   =>      'aemi_widgets',
             'settings'  =>      'aemi_widget_footer_width',
             'choices'  => [
                'default_width' => __('Default Width', 'aemi'),
                'wider_width'   => __('Wider Width', 'aemi'),
                'near_width'    => __('Near Full Width', 'aemi'),
                'full_width'    => __('Full Width', 'aemi')
             ]
        ]));

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_widget_footer_column_layout', [
             'label'     =>      __('Footer Widget Area Column Layout', 'aemi'),
             'description'   =>  __('Choose maximum number of column for footer widget area.', 'aemi'),
             'section'   =>      'aemi_widgets',
             'settings'  =>      'aemi_widget_footer_column_layout',
             'choices'  => [
                'one_column'       => __('Single Column', 'aemi'),
                'two_columns'       => __('Two Columns', 'aemi'),
                'three_columns'     => __('Three Columns', 'aemi'),
                'four_columns'     => __('Four Columns', 'aemi')
             ]
        ]));

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_widget_overlay_width', [
             'label'     =>      __('Overlay Widget Area Width', 'aemi'),
             'description'   =>  __('Change Overlay Widget Area Width.', 'aemi'),
             'section'   =>      'aemi_widgets',
             'settings'  =>      'aemi_widget_overlay_width',
             'choices'  => [
                'default_width'                => __('Default Width', 'aemi'),
                'wider_width'                   => __('Wider Width', 'aemi'),
                'near_width'                   => __('Near Full Width', 'aemi'),
                'full_width'                  => __('Full Width', 'aemi')
             ]
        ]));

        $wp_customize->add_control(new Aemi_Dropdown_Options(
            $wp_customize,
            'aemi_widget_overlay_column_layout', [
             'label'     =>      __('Overlay Widget Area Column Layout', 'aemi'),
             'description'   =>  __('Choose maximum number of column for overlay widget area.', 'aemi'),
             'section'   =>      'aemi_widgets',
             'settings'  =>      'aemi_widget_overlay_column_layout',
             'choices'  => [
                'one_column'       => __('Single Column', 'aemi'),
                'two_columns'       => __('Two Columns', 'aemi'),
                'three_columns'     => __('Three Columns', 'aemi'),
                'four_columns'     => __('Four Columns', 'aemi')
             ]
        ]));
    }
}