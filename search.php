<?php get_header();

if ( have_posts() ) { ?>

<article id="post-lead" class="post">

	<div class="post-header">

		<div class="post-info">

			<h1 class="post-title">

				<?php printf( _x( 'Search Results for : %s', 'search results for', 'aemi' ), get_search_query() ); ?>

			</h1>

		</div>

	</div>

</article>

	<?php

	get_template_part( 'loop' );

	} else {

		get_template_part( 'inc/parts/content', 'none' );

	}

get_footer(); ?>
