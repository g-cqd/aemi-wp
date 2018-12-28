<?php

function aemi_jetpack_setup()
{
	add_theme_support( 'infinite-scroll', array(
		'type'      => 'click',
		'container' => 'content',
		'render'    => 'aemi_infinite_scroll_render',
		'footer'    => 'page',
		'footer_widgets' => 'footer-1'
	) );
}
add_action( 'after_setup_theme', 'aemi_jetpack_setup' );


function aemi_infinite_scroll_render()
{
	get_template_part( 'loop' );
}
