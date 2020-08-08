<?php do_action('aemi_loop_before'); ?>
<?php
while (have_posts()) {
    the_post();
    get_template_part('inc/parts/content', get_post_format());
}
?>
<?php do_action('aemi_loop_after');
