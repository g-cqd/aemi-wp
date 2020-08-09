<?php


if (!function_exists('aemi_post_thumbnail'))
{
	function aemi_post_thumbnail($size)
	{
		the_post_thumbnail($size, [ 'itemprop' => 'image' ]);
	}
}


if (!function_exists('aemi_featured_image'))
{
	function aemi_featured_image()
	{
		if (has_post_thumbnail())
		{
			?><div class="post-attachment"><?php
			if (!is_singular())
			{
				if (is_sticky())
				{
					aemi_post_thumbnail('aemi-mid');
				}
				else
				{
					aemi_post_thumbnail('aemi-small');
				}
			}
			else
			{
				aemi_post_thumbnail('aemi-large');
			}
			?></div><?php
		}
	}
}


if (!function_exists('aemi_meta_header'))
{
	function aemi_meta_header()
	{
		$singular = is_singular();
		$categories = 'post' === get_post_type() && $singular && get_the_category_list() && get_theme_mod('aemi_type_post_category', 1) == 1;
		if (is_sticky() || $categories)
		{
			?><div class="post-meta"><?php
			if (is_sticky())
			{
				?><div class="meta-sticky"><?= esc_html__( 'Featured', 'aemi' ); ?></div><?php
			}
			if (!$singular)
			{
				?><p class="meta-excerpt"><?= get_the_excerpt(); ?></p><?php
			}
			if ($categories)
			{
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
			edit_post_link(esc_html__('Edit', 'aemi'), '<div class="post-edit">', '</div>');
			?></div><?php
		}		
	}
}


if (!function_exists('aemi_exists_post_meta'))
{
	function aemi_get_post_meta()
	{
		$metas = [];
		foreach (get_post_taxonomies() as $tax)
		{
			if (get_theme_mod('aemi_type_' . get_post_type() . '_' . $tax, 1) == 1)
			{
				if (($tax === 'post_tag') || ($tax !== 'category' && $tax !== 'post_format'))
				{
					$metas[] = $tax;
				}
			}
		}
		return $metas;
	}
}


if (!function_exists('aemi_post_meta_footer'))
{
	function aemi_post_meta_footer()
	{
		global $post;
		$metas = aemi_get_post_meta();
		if (is_singular() && count($metas) > 0)
		{
			?><div class="post-meta"><?php
			foreach ($metas as $meta)
			{
				if ($meta === 'post_tag')
				{
					the_tags('<div class="post-tags">', '', '</div>');
				}
				else if ($meta !== 'category' && $meta !== 'post_format')
				{
					the_terms(
						$post->ID,
						$meta,
						'<div class="post-custom-post-type-taxonomy-' . $meta . '"><h3>' . $meta . '</h3><div>',
						'',
						'</div></div>'
					);
				}
			}
			?></div><?php
		}
	}
}
