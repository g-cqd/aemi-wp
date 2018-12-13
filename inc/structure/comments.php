<?php

if ( ! function_exists( 'aemi_display_comments' ) )
{
	function aemi_display_comments()
	{
		if ( 'comments.' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
		{
			return;
		}

		if ( comments_open() || comments_open() || '0' != get_comments_number() )
		{
			comments_template();
		}
	}
}
