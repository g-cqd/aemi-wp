<?php


if (!function_exists('aemi_infinite_scroll_render'))
{
	function aemi_infinite_scroll_render()
	{
		while (have_posts())
		{
			the_post();
			get_template_part('inc/parts/content', get_post_format());
		}
	}
}


if (!function_exists('aemi_jetpack_setup'))
{
	function aemi_jetpack_setup()
	{
		add_theme_support('infinite-scroll', [
			'type'      => 'scroll',
			'container' => 'content',
			'render'    => 'aemi_infinite_scroll_render',
			'posts_per_page' => get_option('posts_per_page'),
			'wrapper'	=> false,
			'footer'    => false,
			'footer_widgets' => ['footer-widgets']
		]);
	}
}
add_action('after_setup_theme', 'aemi_jetpack_setup');