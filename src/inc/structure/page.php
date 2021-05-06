<?php

if (!function_exists('aemi_page_header'))
{
	function aemi_page_header()
	{
		if (!is_front_page())
		{
			?><header class="post-header<?php echo has_post_thumbnail() ? ' color-scheme-dark' : '' ?>"><?php

				aemi_featured_image();

				?><div class="post-info"><?php
					aemi_info_dates();

					the_title('<h1 class="post-title">', '</h1>');

					aemi_info_author();
				?></div><?php

			aemi_meta_header();
			
		?></header><?php
		}
	}
}


if (!function_exists('aemi_page_content'))
{
	function aemi_page_content()
	{
		?><main class="post-content"><?php
			the_content();
			aemi_page_navigation();
		?></main><?php
	}
}
