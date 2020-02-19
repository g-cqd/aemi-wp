<?php

if ( ! function_exists( 'aemi_post_header' ) )
{
	function aemi_post_header()
	{
		?><header class="post-header"><?php
			aemi_featured_image();
			?><div class="post-info"><?php
				if ( is_single() ) {
					the_title( '<h1 class="post-title">', '</h1>' );
				}
				else {
					the_title(
						sprintf(
							'<h2 class="post-title"><a href="%s">',
							esc_url( get_permalink() )
						),
						'</a></h2>'
					);
				}
				aemi_meta_header();
			?></div>
		</header><?php
	}
}

if ( ! function_exists( 'aemi_post_content' ) )
{
	function aemi_post_content()
	{
		?><main class="post-content"><?php
			the_content();
			aemi_page_navigation();
		?></main><?php
	}
}
