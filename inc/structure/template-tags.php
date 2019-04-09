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
				{
					?><div class="meta-sticky"><?php
						echo esc_html__( 'Featured', 'aemi' );
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
			/* else
			{
				aemi_post_thumbnail( 'aemi-large' );
			} */
		}
	}
}


if ( ! function_exists( 'aemi_meta_header' ) )
{
	function aemi_meta_header()
	{
		$aemi_author = get_theme_mod( 'aemi_type_'.get_post_type().'_author', 1 ) == 1 ? true : false;
		$aemi_date = get_theme_mod( 'aemi_type_'.get_post_type().'_published_date', 1 ) == 1 ? true : false;
		$aemi_update = get_theme_mod( 'aemi_type_'.get_post_type().'_updated_date' ) == 1 ? true : false;
		$aemi_cat = false;
		if ( 'post' === get_post_type() && is_singular() && get_the_category_list() && get_theme_mod( 'aemi_type_post_category', 1 ) == 1 ) { $aemi_cat = true; }
		if ( $aemi_author || $aemi_date || $aemi_update || $aemi_cat ) {
			?>
			<div class="post-meta"><?php
			if ( $aemi_author || $aemi_date || $aemi_update ) {
				?><div class="post-details"><?php
				if ( $aemi_author ) {
					?><div class="post-author"><?php the_author_posts_link(); ?></div><?php
				}
				if ( $aemi_date ) {
					?><div class="post-date"><span class="meta-detail"><?php
					if ( is_singular() ) {
						echo esc_html__( 'Published: ', 'aemi' ); ?></span><?php echo get_the_date(); ?></div><?php
					}
					else {
						?></span><?php echo get_the_date(); ?></div><?php
					}
				}
				if ( $aemi_update && is_singular() ) {
					?><div class="post-mod">
						<span class="meta-detail"><?php
						echo esc_html__( 'Updated: ', 'aemi' );
						?></span><?php
						the_modified_date(); the_modified_time(' - g:i a');
					?></div><?php
				}
				?></div><?php
			}
			if ( $aemi_cat ) {
				?><div class="post-cats">
					<span class="meta-detail"><?php
					echo esc_html__( 'Categories: ', 'aemi' );
					?></span><?php
					the_category( ' + ' );
				?></div><?php
			}
			?></div><?php
		}
		edit_post_link( esc_html__( 'Edit', 'aemi' ), '<div class="post-edit">', '</div>' );
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
				if ( get_theme_mod( 'aemi_type_'.get_post_type().$tax, 1 ) == 1 )
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
		}
		?></div><?php
	}
}
