<?php

if (!function_exists('aemi_post_header'))  {
	function aemi_post_header() {

		$singular = is_singular();

		?><header class="post-header<?= has_post_thumbnail() ? ' color-scheme-dark' : '' ?>"><?php
		
		aemi_featured_image();

		if ( $singular ) {
			?><div class="post-info"><?php
		}
		else {
			?><a class="post-info" href="<?=esc_url ( get_permalink() ) ?>" rel="bookmark"><?php
		}

		// Date
		if ( get_theme_mod( 'aemi_type_'.get_post_type().'_published_date', 1 ) == 1 ) {
			printf(
				'<div class="post-date" title="%3$s">%1$s%3$s</div>',
				sprintf(
					'<span class="screen-reader-text">%s</span> ',
					esc_html__( 'Published on', 'aemi' )
				),
				sprintf(
					'%1$s %2$s',
					esc_attr__( 'Updated on', 'aemi' ),
					esc_attr( get_the_modified_time('j F Y - g:i a') )
				),
				esc_html( get_the_date( 'j F Y' ) )
			);
		}

		// Title
		if ( $singular ) {
			the_title( '<h1 class="post-title">', '</h1>' );
		}
		else {
			the_title( '<h2 class="post-title">', '</h2>' );
		}

		// Author
		if ( get_theme_mod( 'aemi_type_'.get_post_type().'_author', 1 ) == 1 ) {
			$tag = 'div';
			$screader = ' screen-reader-text';
			$href_attr = '';
			if ( $singular ) {
				$tag = 'a';
				$screader = '';
				$href_attr = ' href="'. esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) .'"';
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
					esc_html(get_the_author_meta( 'display_name' ))
				)
			);
		}
		if ($singular) {
			?></div><?php
		}
		else {
			?></a><?php
		}
		aemi_meta_header(); ?>
		</header><?php
	}
}

if (!function_exists('aemi_post_content')) {
	function aemi_post_content() {
		?><main class="post-content"><?php
		the_content();
		aemi_page_navigation();
		?></main><?php
	}
}
