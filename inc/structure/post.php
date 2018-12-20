<?php

if ( ! function_exists( 'aemi_post_header' ) )
{
	function aemi_post_header()
	{

		?><div class="post-header"><?php

		aemi_featured_image();

			?><div class="post-info"><?php

				if ( is_single() ) {

					the_title( '<h1 class="post-title" itemprop="name">', '</h1>' );

				} else {

					the_title( sprintf( '<h1 class="post-title" itemprop="name headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );

				}

				aemi_post_meta_header(); 

				?></div>
		</div><?php
	}
}

if ( ! function_exists( 'aemi_post_content' ) )
{
	function aemi_post_content()
	{
		?><div class="post-content" itemprop="articleBody"><?php

			the_content();

			wp_link_pages( array(
				'before'    => '<div id="post-pagination" class="pagination"><div class="nav-previous">',
				'after'     => '</div></div>',
				'next_or_number' => 'next',
				'nextpagelink' => esc_html( sprintf( '%s &rarr;', __( 'next page', 'aemi' ) ) ),
				'previouspagelink' => esc_html( sprintf( '&larr; %s', __( 'previous page', 'aemi' ) ) ),
				'separator' => '</div><div class="nav-next">'
			) );

		?></div><?php
	}
}
