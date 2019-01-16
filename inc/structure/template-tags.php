<?php


if ( ! function_exists( 'aemi_post_thumbnail' ) )
{
	function aemi_post_thumbnail( $size )
	{
		the_post_thumbnail( $size, array( 'itemprop' => 'image' ) );
	}
}


if ( ! function_exists( 'aemi_featured_image' ) )
{
	function aemi_featured_image()
	{
		if ( has_post_thumbnail() )
		{
			if ( ! is_singular() )
			{
				?><div class="post-attachment"><?php

				if ( is_sticky() )
				{ ?><div class="meta-sticky"><?php
					echo esc_html_x( 'Featured', 'featured', 'aemi' );
					?></div><?php
				}

				?><a href="<?php the_permalink(); ?>" rel="bookmark"><?php

				if ( is_sticky() )
				{
					aemi_post_thumbnail( 'aemi-mid' );
				}
				else
				{
					aemi_post_thumbnail( 'aemi-small' );
				}

				?></a><?php

				?></div><?php
			}
			else
			{

				/* aemi_post_thumbnail( 'aemi-large' ); */

			} 
		}
	}
}


if ( ! function_exists( 'aemi_posted_info' ) )
{
	function aemi_posted_info()
	{
		if ( is_page() )
		{
			?><div class="post-details">
				<div class="post-mod"><span class="meta-detail"><?php echo esc_html_x( 'Updated: ', 'updated on', 'aemi' ); ?></span><?php the_modified_time( 'F j, Y - g:i a'); ?></div>
				</div><?php
			}
			else
			{
				?><div class="post-details">
					<div class="post-author"><?php the_author_posts_link(); ?></div>
					<div class="post-date"><span class="meta-detail"><?php
					if ( is_singular() )
					{
						echo esc_html_x( 'Published: ', 'published on', 'aemi' ); ?></span><?php echo get_the_date(); ?></div><?php
					}
					else
					{
						?></span><?php echo get_the_date(); ?></div><?php
					}
					?><div class="post-mod"><span class="meta-detail"><?php echo esc_html_x( 'Updated: ', 'updated on', 'aemi' ); ?></span><?php the_modified_time(); the_modified_time(' - g:i a'); ?></div>
					</div><?php
				}
			}
		}


		if ( ! function_exists( 'aemi_meta_header' ) )
		{
			function aemi_meta_header()
			{ 
				?><div class="post-meta"><?php

				aemi_posted_info();

				if ( 'post' === get_post_type() && is_singular() ) {

					if ( get_the_category_list() ) {

						?><div class="post-cats"><span class="meta-detail"><?php echo esc_html_x( 'Categories: ', 'categories', 'aemi' ); ?></span><?php the_category( ' + ' ); ?></div><?php

					}

				}

				edit_post_link( esc_html_x( 'Edit', 'edit text', 'aemi' ), '<div class="post-edit">', '</div>' );

				?></div><?php
			}
		}

		if ( ! function_exists( 'aemi_post_meta_footer' ) )
		{
			function aemi_post_meta_footer()
			{ 

				global $post;

				?><div class="post-meta"><?php

				if ( is_singular() )
				{
					foreach ( get_post_taxonomies( $post, 'name' ) as $tax )
					{
						if ( $tax === 'post_tag' )
						{
							the_tags('<div class="post-tags">','','</div>');
						}
						else if ( $tax !== 'category' )
						{
							the_terms( $post->ID, $tax, '<div class="post-cptt ' . $tax . '"><h2 class="cptt-title">' . $tax . '</h2><div class="cptt-content">', '', '</div></div>' );
						}
					}
				}

				?></div><?php

			}
		}
