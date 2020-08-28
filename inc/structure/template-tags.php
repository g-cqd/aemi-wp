<?php


/*'function aemi_html_tag_schema()
{
	$schema 	= 'http://schema.org/';
	$type 		= 'WebPage';
	if ( is_singular( 'post' ) )
	{
		$type 	= 'Article';
	}
	else if ( is_author() )
	{
		$type 	= 'ProfilePage';
	}
	else if ( is_search() )
	{
		$type 	= 'SearchResultsPage';
	}
	echo 'itemscope="itemscope" itemtype="' . esc_attr( $schema ) . esc_attr( $type ) . '"';
}*/


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
		$single_attachment = is_enabled('aemi_post_single_attachment',1);
		$no_img = get_theme_mod('aemi_post_layout','cover') == 'no_img';
		if (has_post_thumbnail() && (is_singular() && $single_attachment || !$no_img))
		{
			?><div class="post-attachment"><?php
			if (!is_singular())
			{
				if (!$no_img)
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
			}
			else
			{
				if ($single_attachment)
				{
					aemi_post_thumbnail('aemi-large');
				}
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

		$pub_mod = get_theme_mod(aemi_type('published_date'), 'both');
		$pub_both = $pub_mod == 'both';
		$pub_none = $pub_mod == 'none';
		$pub_single = $pub_mod == 'single';
		$pub_loop = $pub_mod == 'loop';

		$upt_mod = get_theme_mod(aemi_type('updated_date'), 'none');
		$upt_both = $upt_mod == 'both';
		$upt_none = $upt_mod == 'none';
		$upt_single = $upt_mod == 'single';
		$upt_loop = $upt_mod == 'loop';

		$pub = !$pub_none && ($pub_both || ($singular && $pub_single || !$singular && $pub_loop));

		$upt = !$upt_none && ($upt_both || ($singular && $upt_single || !$singular && $upt_loop));

		if ($pub)
		{
			if ($upt)
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
		else if ($upt)
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
				)
			);
		}
	}
}

if (!function_exists('aemi_info_author'))
{
	function aemi_info_author()
	{
		$author_mod = get_theme_mod(aemi_type('author'), 'both');
		$author_both = $author_mod == 'both';
		$author_none = $author_mod == 'none';
		$author_single = $author_mod == 'single';
		$author_loop = $author_mod == 'loop';
		$singular = is_singular();
		if (!$author_none && ($author_both || ($singular && $author_single || !$singular && $author_loop)))
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

if (!function_exists('aemi_sticky_badge'))
{
	function aemi_sticky_badge($post_type)
	{
		if ($post_type == 'post')
		{
			$singular = is_singular();
			$in_loop = !$singular;
			$is_sticky = is_sticky();
			$sticky_mod = get_theme_mod(aemi_type('show_sticky_badge'), 'both');
			$sticky_both = $sticky_mod == 'both';
			$sticky_single = $sticky_mod == 'single';
			$sticky_loop = $sticky_mod == 'loop';
			$sticky_none = $sticky_mod == 'none';
			if ($is_sticky && !$sticky_none && ($sticky_both || ($singular && $sticky_single || !$singular && $sticky_loop)))
			{
				return true;
			}
		}
		return false;
	}
}

if (!function_exists('aemi_show_excerpt'))
{
	function aemi_show_excerpt($post_type)
	{
		if (!is_singular())
		{
			if ($post_type == 'post')
			{
				$is_sticky = is_sticky();
				$excerpt_mod = get_theme_mod(aemi_type('show_excerpt'), 'sticky_only');
				$excerpt_both = $excerpt_mod == 'both';
				$excerpt_sticky = $excerpt_mod == 'sticky_only';
				$excerpt_non_sticky = $excerpt_mod == 'non_sticky_only';
				$excerpt_none = $excerpt_mod == 'none';
				if (!$excerpt_none && ($excerpt_both || ($is_sticky && $excerpt_sticky || !$is_sticky && $excerpt_non_sticky)))
				{
					return true;
				}
			}
			else if (get_theme_mod(aemi_type('show_excerpt'), 0))
			{
				return true;
			}
		}
		return false;
	}
}

if (!function_exists('aemi_meta_header'))
{
	function aemi_meta_header()
	{
		$p_type = get_post_type();
		$singular = is_singular();
		$categories = 'post' === $p_type && $singular && get_the_category_list() && get_theme_mod(aemi_type('category'), 1) == 1;
		$excerpt = aemi_show_excerpt($p_type);
		$sticky = aemi_sticky_badge($p_type);
		$edit_link = get_edit_post_link();
		
		if ($categories || $excerpt || $sticky || $edit_link)
		{
			?><div class="post-meta"><?php
			if ($sticky)
			{
				?><div class="meta-sticky"><?php echo esc_html__('Featured', 'aemi') ?></div><?php
			}
			if ($excerpt)
			{
				?><p class="meta-excerpt"><?php echo get_the_excerpt() ?></p><?php
			}
			if ($categories)
			{
				?><div class="meta-categories meta-item">
					<div class="meta-item-title">
						<?php echo esc_html__( 'Categories', 'aemi' ) ?>
					</div>
					<div class="meta-item-list">
						<span class="meta-item-list-item button">
							<?php the_category( '</span><span class="meta-item-list-item button"> ' ); ?>
						</span>
					</div>
					</div><?php
				}
				if ($edit_link)
				{
					edit_post_link(esc_html__('Edit', 'aemi'), '<div class="post-edit">', '</div>');
				}
				?></div><?php
			}		
		}
	}


	if (!function_exists('aemi_get_post_meta'))
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
				$meta_occ = [];
				$one_meta = false;
				foreach ($metas as $meta) {
					if (get_the_term_list($post->ID,$meta) != '' ) {
						$one_meta = true;
						$meta_occ[$meta] = true;
					}
				}
				if ($one_meta) {
					?><div class="post-meta"><?php
					foreach ($metas as $meta)
					{
						if ($meta_occ[$meta]) {
							if ($meta === 'post_tag')
							{
								?><div class="meta-tags meta-item">
									<div class="meta-item-title h2">
										<?php echo esc_html__( 'Tags', 'aemi' ) ?>
									</div>
									<div class="meta-item-list">
										<span class="meta-item-list-item button">
											<?php the_tags( '', '</span><span class="meta-item-list-item button">', '' ); ?>
										</span>
									</div>
									</div><?php
								}
								else if ($meta !== 'category' && $meta !== 'post_format')
								{
									?><div class="custom-post-type-taxonomy=<?php echo esc_attr( $meta ) ?> meta-item">
										<div class="meta-item-title h2">
											<?php echo esc_html( $meta ) ?>
										</div>
										<div class="meta-item-list">
											<span class="meta-item-list-item button">
												<?php the_terms( $post->ID, $meta, '', '</span><span class="meta-item-list-item button">', '' ); ?>
											</span>
										</div>
										</div><?php
										
									}
								}
							}
							?></div><?php
						}
					}
				}
			}
