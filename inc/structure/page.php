<?php

if ( ! function_exists( 'aemi_page_header' ) )
{
	function aemi_page_header()
	{

		if ( ! is_front_page() ) { ?>

			<div class="post-header"><?php

			aemi_featured_image();

				?><div class="post-info"><?php

					the_title( '<h1 class="post-title" itemprop="name">', '</h1>' );

					aemi_post_meta_header();

				?></div>

			</div><?php

		}

	}
}

if ( ! function_exists( 'aemi_page_content' ) )
{
	function aemi_page_content()
	{
		?><div class="post-content" itemprop="mainContentOfPage"><?php

			the_content();

			aemi_page_navigation();

		?></div><?php

	}
}
