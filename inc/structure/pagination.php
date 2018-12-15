<?php

if ( ! function_exists( 'aemi_posts_pagination' ) )
{
	function aemi_posts_pagination()
	{
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) {

			?><nav id="pagination" class="pagination global" role="navigation"><?php

			if ( get_next_posts_link() ) {

				?><div class="nav-previous"><?php

				next_posts_link( '<span class="nav-title">&larr; ' . _x( 'old', 'old posts link', 'aemi' ) . '</span>' );

				?></div><?php

			}

				if ( get_previous_posts_link() ) {

					?><div class="nav-next"><?php

					previous_posts_link( '<span class="nav-title">' . _x( 'new', 'new posts link', 'aemi' ) . ' &rarr;</span>' );

					?></div><?php

				}

			?></nav><?php

		}
	}
}



if ( ! function_exists( 'aemi_post_navigation' ) )
{
	function aemi_post_navigation()
	{
		
		?><nav id="pagination" class="pagination" role="navigation"><?php

			previous_post_link('<div class="nav-previous">%link</div>', '<span class="nav-arrow">&larr; ' . _x( 'older', 'older post link', 'aemi' ) . '</span><span class="nav-title">%title</span>');

			next_post_link('<div class="nav-next">%link</div>', '<span class="nav-arrow">' . _x( 'newer', 'newer posts link', 'aemi' ) . ' &rarr;</span><span class="nav-title">%title</span>');

		?></nav><?php
	
	}

}
