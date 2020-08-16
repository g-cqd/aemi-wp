

<article id="entry-<?php the_ID(); ?>" <?php

$classes = ['entry'];
if (is_sticky())
{
	$classes[] = 'sticky';
}

post_class($classes);

?> ><?php

do_action('aemi_loop_post');

?></article>