<?php get_header();
if ( have_posts() ) { ?>
<article id="post-lead" class="post">
	<div class="post-header">
		<div class="post-info">
			<h1 class="post-title"><?php 
				$search_query_content = get_search_query();
				echo $search_query_content;
			?></h1>
			<div class="archive-type search"><?php
			if ( $search_query_content == "" )
			{
				esc_html_e( "Is 'looking for anything' useful?", 'aemi' );
			}
			else
			{
				esc_html_e( 'Search Results', 'aemi' );
			}
			?></div>
		</div>
	</div>
</article>
<?php
	get_template_part( 'loop' );
}
else
{
	get_template_part( 'inc/parts/content', 'none' );
}
get_footer(); ?>
