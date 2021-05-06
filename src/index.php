<?php

get_header();

if (have_posts())
{
    get_template_part('loop');
}
else
{
    get_template_part('inc/parts/content', 'none');
}

get_footer();
