<?php

if (!function_exists('aemi_separate_comments'))
{
	function aemi_separate_comments()
	{
		$comment_args = [
			'order'		=>	'ASC',
			'orderby'	=>	'comment_date_gmt',
			'status'	=>	'approve',
			'post_id'	=>	get_the_ID(),
		];
		$comments = get_comments($comment_args);
		$comments_by_type = separate_comments($comments);

		return $comments_by_type;
	}
}

if (!function_exists('aemi_display_comments'))
{
	function aemi_display_comments()
	{
		if ('comments.' == basename($_SERVER['SCRIPT_FILENAME']))
		{
			return;
		}
		if (comments_open() || '0' != get_comments_number())
		{
			comments_template('/comments.php');
		}
	}
}