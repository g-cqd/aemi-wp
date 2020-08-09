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
			if ( !is_singular() ) {
				if ( is_sticky() ) {
					aemi_post_thumbnail( 'aemi-mid' );
				}
				else {
					aemi_post_thumbnail( 'aemi-small' );
				}
			}
			else {
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
		$categories = 'post' === get_post_type() && $singular && get_the_category_list() && get_theme_mod( 'aemi_type_post_category', 1 ) == 1;
		if ( is_sticky() || $categories ) {
			?><div class="post-meta"><?php
			if (is_sticky()) {
				?><div class="meta-sticky"><?= esc_html__( 'Featured', 'aemi' ); ?></div><?php
			}
			if (!$singular) {
				?><p class="meta-excerpt"><?= get_the_excerpt(); ?></p><?php
			}
			if ( $categories ) {
				?><div class="meta-categories meta-item">
					<div class="meta-item-title">
						<?= esc_html__( 'Categories', 'aemi' ) ?>
					</div>
					<div class="meta-item-list">
						<span class="meta-item-list-item">
							<?php the_category( '</span><span class="meta-item-list-item"> ' ); ?>
						</span>
					</div>
				</div><?php
			}
			edit_post_link( esc_html__( 'Edit', 'aemi' ), '<div class="post-edit">', '</div>' );
			?></div><?php
		}		
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
						the_tags(
							'<div class="post-tags">',
							'',
							'</div>'
						);
					}
					else if ( $tax !== 'category' && $tax !== 'post_format' ) {
						the_terms(
							$post->ID,
							$tax,
							'<div class="post-custom-post-type-taxonomy-' . $tax . '"><h3>' . $tax . '</h3><div>',
							'',
							'</div></div>'
						);
					}
				}
			}
			?></div><?php
		}
	}
}
