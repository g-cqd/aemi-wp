<?php

if (!function_exists('aemi_customizer_controls')) {
    function aemi_customizer_controls($wp_customize)
    {

        foreach (get_post_types(['public' => true], 'objects') as $post_type)
        {
            $post_name = $post_type->name;

            $post_type_object = (object) ['post_type' => $post_name];

            $default_metas = [
                'author'    =>          [
                    'name'  =>  'author',
                    'label' =>  __('Author', 'aemi'),
                ],
                'published_date'    =>  [
                    'name'  =>  'published_date',
                    'label' =>  __('Published Date', 'aemi'),
                ],
                'updated_date'  =>      [
                    'name'  =>  'updated_date',
                    'label' =>  __('Updated Date', 'aemi'),
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

            $progress_bar = 'aemi_type_' . $post_name . '_progress_bar';

            $wp_customize->add_control($progress_bar, [
                'label'     =>      esc_html__('Progress Bar', 'aemi'),
                'description'   =>  esc_html__('Display a progress bar that indicate what quantity of the page you read.', 'aemi'),
                'section'   =>      'aemi_type_' . $post_name,
                'settings'  =>      $progress_bar,
                'type'      =>      'checkbox'
            ]);
        }

        $wp_customize->add_control('aemi_darkmode_display', [
            'label'     =>      esc_html__('Dark Mode', 'aemi'),
            'description'   =>  esc_html__('Allow theme to switch automatically between light and dark mode.', 'aemi'),
            'section'   =>      'aemi_features',
            'settings'  =>      'aemi_darkmode_display',
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
