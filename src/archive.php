<?php

get_header();

?><article id="entry-head" class="entry">
    <header class="post-header">
        <div class="post-info"><?php echo get_the_archive_title() ?><?php
			the_archive_description('<div class="archive-details">', '</div>');
		?></div>
    </header>
</article><?php

if (have_posts())
{
    get_template_part('loop');
}
else
{
    get_template_part('inc/parts/content', 'none');
}

get_footer();

?>
