<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php
	do_action( 'aemi_page' );
	?><div class="post-footer"><?php
		do_action( 'aemi_page_after' );
	?></div>
</article>
