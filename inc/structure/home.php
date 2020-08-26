<?php

if (!function_exists('aemi_homepage_header'))
{
	function aemi_homepage_header()
	{
		$mod = is_enabled('aemi_homepage_header',0);
		if ( $mod && (is_home() || is_front_page()) )
		{
			$title = get_theme_mod('aemi_homepage_header_custom_title','');
			if ($title == '')
			{
				if (is_home())
				{
					$title = __( 'Latest Posts', 'aemi' );
				}
				else {
					$title = get_the_title( get_option( 'page_for_front' ) );
				}
			}
	?><article id="entry-head" class="entry">
    	<header class="post-header">
        	<div class="post-info">
        		<h1 class="post-title"><?php echo $title ?></h1>
        		<?php
        		$subtitle = get_theme_mod('aemi_homepage_header_custom_subtitle','');
        		if ($subtitle != '')
        		{
        			?><h2 class="post-subtitle h2"><?php echo $subtitle ?></h2><?php
        		}
        		?>
			</div>
    	</header>
	</article><?php
		}
	}
}

if (!function_exists('aemi_before_main_content'))
{
	function aemi_before_main_content()
	{
		if (is_home() || is_front_page())
		{
			$page_id = get_theme_mod('aemi_homepage_before','');
			if ($page_id != '')
			{
				$page_id = absint($page_id);
				$post = get_post( $page_id );
				$the_content = apply_filters('the_content', $post->post_content);
				if ( !empty($the_content) ) {
	  				?><div id="pre-content">
						<?php echo $the_content ?>
					</div><?php
				}
			}
		}
	}
}

if (!function_exists('aemi_after_main_content'))
{
	function aemi_after_main_content()
	{
		if (is_home() || is_front_page())
		{
			$page_id = get_theme_mod('aemi_homepage_after','');
			if ($page_id != '')
			{
				$page_id = absint($page_id);
				$post = get_post($page_id);
				$the_content = apply_filters('the_content', $post->post_content);
				if ( !empty($the_content) ) {
					?><div id="post-content">
						<?php echo $the_content ?>
					</div><?php
				}
			}
		}
	}
}