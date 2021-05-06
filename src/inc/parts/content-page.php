<article id="entry-<?php the_ID(); ?>" <?php post_class(['entry']); ?> >
	<?php do_action( 'aemi_page' ); ?>
	<footer class="post-footer"><?php do_action('aemi_page_after'); ?></footer>
</article>
