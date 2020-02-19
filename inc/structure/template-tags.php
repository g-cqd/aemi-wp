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
			?><div class="post-attachment"><?php
			if ( is_sticky() )
			{
				?><div class="meta-sticky"><?= esc_html__( 'Featured', 'aemi' ); ?></div><?php
			}
			if ( !is_singular() )
			{
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
			}
			else
			{
				aemi_post_thumbnail( 'aemi-large' );
			}
			?></div><?php
		}
	}
}


if ( ! function_exists( 'aemi_meta_header' ) )
{
	function aemi_meta_header()
	{
		$singular = is_singular();
		$aemi_author = get_theme_mod( 'aemi_type_'.get_post_type().'_author', 1 ) == 1 ? true : false;
		$aemi_date = get_theme_mod( 'aemi_type_'.get_post_type().'_published_date', 1 ) == 1 ? true : false;
		$aemi_categories = false;
		if ( 'post' === get_post_type() && $singular && get_the_category_list() && get_theme_mod( 'aemi_type_post_category', 1 ) == 1 ) {
			$aemi_categories = true;
		}
		if ( $aemi_author || $aemi_date || $aemi_categories ) {
			?><div class="post-meta"><?php
			if ( $aemi_author ) {
				?><a class="post-author" href="<?= esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>">
					<div class="author-avatar">
						<?= get_avatar( get_the_author_meta('ID'), 50 ); ?>
					</div>
					<div class="author-name">
						<?= esc_html( get_the_author_meta( 'display_name' ) ) ?>
					</div>
				</a><?php
			}
			if ( $aemi_date )
			{ ?>
				<?php
				$screader = $singular === false ? ' screen-reader-text' : '';
				printf(
					'<a class="post-date" href="%3$s" title="%4$s"><span class="meta-detail%1$s">%2$s </span>%5$s</a>',
					$screader,
					esc_html__( 'Published on', 'aemi' ),
					esc_url( get_day_link(
						get_the_time( 'Y' ),
						get_the_time( 'm' ),
						get_the_time( 'd' )
					) ),
					sprintf(
						'%1$s %2$s',
						esc_attr__( 'Updated on', 'aemi' ),
						esc_attr( get_the_modified_time('j F Y - g:i a') )
					),
					esc_html( get_the_date( 'j F Y' ) )
				);
			}
			if ( $aemi_categories ) {
				?><div class="post-categories">
					<?php
					printf(
						'<span class="meta-detail">%s </span>',
						esc_html__( 'Categorized in', 'aemi' )
					);
					the_category( '<span class="category-separator">,</span> ' );
				?></div><?php
			}
			?></div><?php
		}		
		edit_post_link( esc_html__( 'Edit', 'aemi' ), '<div class="post-edit">', '</div>' );
	}
}

if ( !function_exists( 'aemi_exists_post_meta' ) ) {
	function aemi_exists_post_meta () {
		foreach ( get_post_taxonomies( $post, 'name' ) as $tax ) {
			if ( get_theme_mod( 'aemi_type_' . get_post_type() . $tax, 1 ) == 1 ) {
				if ( ($tax === 'post_tag') || ($tax !== 'category' && $tax !== 'post_format') ) {
					return true;
				}
			}
		}
		return false;
	}
}



if ( ! function_exists( 'aemi_post_meta_footer' ) )
{
	function aemi_post_meta_footer()
	{
		global $post;
		if ( is_singular() && aemi_exists_post_meta() ) {
			?><div class="post-meta"><?php
			foreach ( get_post_taxonomies( $post, 'name' ) as $tax ) {
				if ( get_theme_mod( 'aemi_type_' . get_post_type() . $tax, 1 ) == 1 ) {
					if ( $tax === 'post_tag' ) {
						the_tags('<div class="post-tags">','','</div>');
					}
					else if ( $tax !== 'category' && $tax !== 'post_format' ) {
						the_terms( $post->ID, $tax, '<div class="post-custom-post-type-taxonomy-' . $tax . '"><h3>' . $tax . '</h3><div>', '', '</div></div>' );
					}
				}
			}
			?></div><?php
		}
	}
}
