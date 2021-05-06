<article id="entry-<?php the_ID(); ?>" <?php post_class(['entry']); ?> >
	<?php do_action('aemi_single_post'); ?>
	<footer class="post-footer"><?php do_action('aemi_single_post_after'); ?></footer>
</article>
