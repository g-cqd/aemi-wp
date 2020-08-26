<!DOCTYPE html>

<html <?php language_attributes(); ?> <?php echo aemi_meta_og_namespace() ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php do_action('aemi_head'); ?>
        <?php wp_head(); ?>
    </head>

<?php

$custom_background_color = get_background_color();

$style = '';

if ($custom_background_color != '')
{
    $style = sprintf('style="background-color:%s;"',$custom_background_color);
}

?>
    <body <?php body_class(); ?> <?php echo $style != '' ? $style : '' ?>>
        <?php wp_body_open(); ?>
        <?php do_action('aemi_header_before'); ?>
        <header id="site-header"<?php echo is_singular() & has_post_thumbnail() ? ' class="color-scheme-dark"' : '' ?>>
            <?php
            printf(
                '<a class="skip-link focusable screen-reader-text button" href="#%1$s" tabindex="0">%2$s</a>',
                is_singular() ? 'post-content' : 'site-loop',
                esc_html__('Skip to content', 'aemi')
            );
            ?>
            <?php do_action('aemi_header'); ?>
        </header>
        <main id="site-content">
            <div id="main-content">
                <?php do_action('aemi_content_before'); ?>
