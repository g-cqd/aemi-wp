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

        $wp_customize->add_section('aemi_analytics', [
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Analytics', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_comments', [
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Comments', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_loop', [
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Content Loop', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_scripts', [
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Custom Scripts', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_features', [
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Features', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_advanced_features', [
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Features: Advanced', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_critical_features', [
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Features: Critical', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_header', [
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Header', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_search', [
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Search', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_site_identity', [
            'panel'      => 'aemi_panel',
            'title'      => esc_html__('Site Identity', 'aemi'),
        ]);


        foreach (get_post_types(['public' => true], 'objects') as $post_type)
        {
            $post_name = $post_type->name;

            $wp_customize->add_section(('aemi_type_' . $post_name), [
                'panel'     =>  'aemi_panel',
                'title'     =>  esc_html__( 'Type', 'aemi') . ': ' . $post_type->label,
            ]);
            
        }


    }
}
add_action('customize_register', 'aemi_customizer_panels');