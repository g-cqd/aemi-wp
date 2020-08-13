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

        $wp_customize->add_section('aemi_site_identity', [
            'priority'   => 0,
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Site Identity', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_scripts', [
            'priority'   => 10,
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Custom Scripts', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_features', [
            'priority'   => 20,
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Features', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_advanced_features', [
            'priority'   => 30,
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Features: Advanced', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_critical_features', [
            'priority'   => 40,
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Features: Critical', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_loop', [
            'priority'   => 50,
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Content Loop', 'aemi'),
        ]);

        $id = 60;

        foreach (get_post_types(['public' => true], 'objects') as $post_type)
        {
            $post_name = $post_type->name;

            $wp_customize->add_section(('aemi_type_' . $post_name), [
                'panel'     =>  'aemi_panel',
                'title'     =>  esc_html__( 'Type', 'aemi') . ': ' . $post_type->label,
                'priority'  =>  $id,
            ]);
            
            $id += 10;
        }


    }
}
add_action('customize_register', 'aemi_customizer_panels');