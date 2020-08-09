<?php

if (!function_exists('aemi_customizer_panels'))
{
    function aemi_customizer_panels($wp_customize)
    {

        $wp_customize->add_panel('aemi_panel', [
            'priority'       => 0,
            'capability'     => 'edit_theme_options',
            'title'          => esc_html__('Aemi', 'aemi'),
            'description'    => esc_html__('Customize Aemi Settings and Features', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_scripts', [
            'priority'   => 0,
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Custom Scripts', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_features', [
            'priority'   => 10,
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Features', 'aemi'),
        ]);

        $id = 20;

        foreach (get_post_types(['public' => true], 'objects') as $post_type)
        {
            $post_name = $post_type->name;

            $wp_customize->add_section(('aemi_type_' . $post_name), [
                'panel'     =>  'aemi_panel',
                'title'     =>  esc_html__($post_type->label, 'aemi'),
                'priority'  =>  $id,
            ]);
            
            $id += 10;
        }
    }
}
add_action('customize_register', 'aemi_customizer_panels');