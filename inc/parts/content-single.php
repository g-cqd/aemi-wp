<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="" itemtype="http://schema.org/BlogPosting"><?php

	do_action( 'aemi_single_post' );

	?><div class="post-footer"><?php

		do_action( 'aemi_single_post_after' );

	?></div>

</article>
