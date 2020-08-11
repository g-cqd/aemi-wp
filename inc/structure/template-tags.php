<?php


if (!function_exists('aemi_type'))
{
	function aemi_type($string)
	{
		return 'aemi_type_'.get_post_type().'_'.$string;
	}
}


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


if (!function_exists('aemi_info_dates'))
{
	function aemi_info_dates()
	{
		$singular = is_singular();
		$in_loop = !$singular;
		$published_date = get_theme_mod(aemi_type('published_date'), 0) == 1;
		$updated_date = get_theme_mod(aemi_type('updated_date'), 0) == 1;
		$published_date_in_loop = get_theme_mod(aemi_type('published_date_in_loop'), 0) == 1;
		$updated_date_in_loop = get_theme_mod(aemi_type('updated_date_in_loop'), 0) == 1;
		if ($singular && $published_date || $in_loop && $published_date_in_loop)
		{
			if ($singular && $updated_date || $in_loop && $updated_date_in_loop)
			{
				printf(
					'<div class="post-date">%1$s%3$s • %2$s</div>',
					sprintf(
						'<span class="screen-reader-text">%s</span> ',
						esc_html__('Published on', 'aemi')
					),
					sprintf(
						'%1$s %2$s',
						esc_attr__('Updated on', 'aemi'),
						esc_attr(get_the_modified_time('j F Y - g:i a'))
					),
					esc_html(get_the_date('j F Y'))
				);
			}
			else
			{
				printf(
					'<div class="post-date" title="%2$s">%1$s%3$s</div>',
					sprintf(
						'<span class="screen-reader-text">%s</span> ',
						esc_html__('Published on', 'aemi')
					),
					sprintf(
						'%1$s %2$s',
						esc_attr__('Updated on', 'aemi'),
						esc_attr(get_the_modified_time('j F Y - g:i a'))
					),
					esc_html(get_the_date('j F Y'))
				);
			}
		}
		else if ($singular && $updated_date || $in_loop && $updated_date_in_loop)
		{
			printf(
				'<div class="post-date">%1$s%2$s</div>',
				sprintf(
					'<span class="screen-reader-text">%1$s %2$s • </span> ',
					esc_html__('Published on', 'aemi'),
					esc_html(get_the_date('j F Y'))
				),
				sprintf(
					'%1$s %2$s',
					esc_attr__('Updated on', 'aemi'),
					esc_attr(get_the_modified_time('j F Y - g:i a'))
				),
			);
		}
	}
}

if (!function_exists('aemi_info_author'))
{
	function aemi_info_author()
	{
		$singular = is_singular();
		$in_loop = !$singular;
		$author = get_theme_mod(aemi_type('author'), 1) == 1;
		$author_in_loop = get_theme_mod(aemi_type('author_in_loop'), 1) == 1;
		if ($singular && $author || $in_loop && $author_in_loop)
		{
			$tag = 'div';
			$screader = ' screen-reader-text';
			$href_attr = '';
			if ($singular)
			{
				$tag = 'a';
				$screader = '';
				$href_attr = ' href="'. esc_url(get_author_posts_url(get_the_author_meta('ID'))) .'"';
			}
			printf( 
				'<%1$s class="post-author"%2$s>%3$s%4$s</%1$s>',
				$tag,
				$href_attr,
				sprintf(
					'<span class="author-pre-text%1$s">%2$s</span>',
					$screader,
					esc_html__('Written by ','aemi')
				),
				sprintf(
					'<span class="author-name">%s</span>',
					esc_html(get_the_author_meta('display_name'))
				)
			);
		}
	}
}

if (!function_exists('aemi_meta_header'))
{
	function aemi_meta_header()
	{
		$singular = is_singular();
		$in_loop = !$singular;
		$categories = 'post' === get_post_type() && $singular && get_the_category_list() && get_theme_mod(aemi_type('category'), 1) == 1;
		$sticky = 'post' === get_post_type() && get_theme_mod(aemi_type('sticky'), 1) == 1;
		$sticky_in_loop = 'post' === get_post_type() && get_theme_mod(aemi_type('sticky_in_loop'), 1) == 1;
		$show_excerpt = !is_sticky() && ('post' === get_post_type() || 'page' === get_post_type()) && get_theme_mod(aemi_type('show_excerpt'), 0) == 1;
		$show_excerpt_sticky = is_sticky() && 'post' === get_post_type() && get_theme_mod(aemi_type('show_excerpt_when_sticky'), 1) == 1;
		$excerpt = $in_loop && ($show_excerpt || $show_excerpt_sticky);
		$is_sticky = is_sticky() && ($singular && $sticky || $in_loop && $sticky_in_loop);
		if ($excerpt || $is_sticky || $categories)
		{
			?><div class="post-meta"><?php
			if ($is_sticky)
			{
				?><div class="meta-sticky"><?= esc_html__( 'Featured', 'aemi' ); ?></div><?php
			}
			if ($excerpt)
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
			if (get_theme_mod(aemi_type($tax), 1) == 1)
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
