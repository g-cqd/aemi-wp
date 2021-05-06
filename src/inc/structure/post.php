<?php

if (!function_exists('aemi_post_header'))
{
	function aemi_post_header()
	{

		$singular = is_singular();
		$has_thumbnail = has_post_thumbnail();

        $to_dark = $singular == false && get_theme_mod('aemi_post_layout','cover') == 'cover' && $has_thumbnail || $singular && $has_thumbnail ;

		?><header class="post-header<?php echo $to_dark ? ' color-scheme-dark' : '' ?>"><?php
		
			aemi_featured_image();

			if ($singular)
			{
				?><div class="post-info"><?php
			}
			else
			{
				?><a class="post-info" href="<?php echo esc_url(get_permalink()) ?>" rel="bookmark"><?php
			}

				// Date
				aemi_info_dates();

				// Title
				if ($singular)
				{
					the_title('<h1 class="post-title">', '</h1>');
				}
				else
				{
					the_title('<h2 class="post-title">', '</h2>');
				}

				// Author
				aemi_info_author();

			if ($singular)
			{
				?></div><?php
			}
			else
			{
				?></a><?php
			}
		
			aemi_meta_header();

		?></header><?php
	}
}

if (!function_exists('aemi_post_content'))
{
	function aemi_post_content()
	{
		?><main class="post-content"><?php
			the_content();
			aemi_page_navigation();
		?></main><?php
	}
}
