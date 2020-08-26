<?php

do_action('aemi_loop_before');

$layout = get_theme_mod('aemi_post_layout','cover');
$sticky_span = preg_replace( '/_/', '-', get_theme_mod('aemi_post_sticky_width','span_full'));
$width = preg_replace( '/_/', '-', get_theme_mod('aemi_post_width','default_width'));
$columns = preg_replace( '/_/', '-', get_theme_mod('aemi_post_column_layout','two_columns'));

$no_img_class = preg_match('/no_img/', $layout) ? 'no-img' : '';
$img_behav = preg_match('/cover/', $layout) ? 'cover' : '';

?><div id="site-loop" class="site-loop <?php echo esc_attr("$sticky_span $no_img_class $img_behav $width $columns") ?>"><?php

while (have_posts())
{
    the_post();
    get_template_part('inc/parts/content', get_post_format());
}

?></div><?php

do_action('aemi_loop_after');
