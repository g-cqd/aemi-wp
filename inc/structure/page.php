<?php

if ( ! function_exists( 'aemi_page_header' ) )
{
	function aemi_page_header()
	{

		?><div class="post-header"><?php

			aemi_featured_image();

			if ( ! is_front_page() ) {

				?><div class="post-info"><?php

					the_title( '<h1 class="post-title" itemprop="name">', '</h1>' );

					aemi_post_meta_header();

				?></div><?php

			}

		?></div><?php

	}
}

if ( ! function_exists( 'aemi_page_content' ) )
{
	function aemi_page_content()
	{
		?><div class="post-content" itemprop="mainContentOfPage"><?php

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
