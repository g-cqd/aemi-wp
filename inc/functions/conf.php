<?php

/* Change Font of Gutenberg editor - using same font-stack as aemi */
if ( ! function_exists( 'aemi_gutenberg_editor_style' ) )
{
	function aemi_gutenberg_editor_style() {
		wp_enqueue_style( 'aemi-gutenberg-style', get_template_directory_uri() . "/assets/guten-style.css" );
	}
}
add_action('enqueue_block_editor_assets', 'aemi_gutenberg_editor_style');
