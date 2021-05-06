<?php

if (!function_exists('aemi_customizer_panels'))
{
    function aemi_customizer_panels($wp_customize)
    {

        $wp_customize->add_panel('aemi_panel', [
            'priority'       => 0,
            'capability'     => 'edit_theme_options',
            'title'          => __('Aemi', 'aemi'),
            'description'    => __('Customize Aemi Settings and Features', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_analytics', [
            'panel'      => 'aemi_panel',
            'title'      => __('Analytics', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_colors', [
            'panel'      => 'aemi_panel',
            'title'      => __('Colors', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_loop', [
            'panel'      => 'aemi_panel',
            'title'      => __('Content Loop', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_scripts', [
            'panel'      => 'aemi_panel',
            'title'      => __('Custom Scripts', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_header', [
            'panel'      => 'aemi_panel',
            'title'      => __('Header', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_homepage', [
            'panel'      => 'aemi_panel',
            'title'      => __('Homepage', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_identity', [
            'panel'      => 'aemi_panel',
            'title'      => __('Identity', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_search', [
            'panel'      => 'aemi_panel',
            'title'      => __('Search', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_seo', [
            'panel'      => 'aemi_panel',
            'title'      => __('SEO', 'aemi'),
        ]);

        $wp_customize->add_section('aemi_widgets', [
            'panel'      => 'aemi_panel',
            'title'      => __('Widgets', 'aemi'),
        ]);

        foreach (get_post_types(['public' => true], 'objects') as $post_type)
        {
            $post_name = $post_type->name;

            $wp_customize->add_section(('aemi_type_' . $post_name), [
                'panel'     =>  'aemi_panel',
                'title'     =>  __( 'Type', 'aemi') . ': ' . $post_type->label,
            ]);   
        }
    }
}