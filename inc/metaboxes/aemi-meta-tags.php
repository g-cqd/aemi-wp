<?php

if (!function_exists('aemi_add_meta_tags'))
{
	function aemi_add_meta_tags()
	{
		foreach (get_post_types(['public'=>true]) as $type)
		{
			add_meta_box(
				'aemi_meta_tags',
				__( 'Meta Tags', 'aemi' ),
				'aemi_meta_tags_callback',
				$type
			);
		}
	}
}

if (!function_exists('aemi_meta_tags_data'))
{
	function aemi_meta_tags_data($post)
	{
		$data = [];

		if (isset($post))
		{
			$data['author']			= [ 'value' => get_post_meta( $post->ID, 'aemi_meta_author', true ) ];
			$data['description']	= [ 'value' => get_post_meta( $post->ID, 'aemi_meta_description', true ) ];
			$data['keywords']		= [ 'value' => get_post_meta( $post->ID, 'aemi_meta_keywords', true ) ];
		}
		else
		{
			$data['author']			= [ 'value' => '' ];
			$data['description']	= [ 'value' => '' ];
			$data['keywords']		= [ 'value' => '' ];
		}

		if ($data['author']['value'] == '')
		{
			$data['author']['value'] = get_the_author();
		}

		if ($data['description']['value'] == '')
		{
			$data['description']['value'] = aemi_get_meta_desc($post);
		}

		return $data;
	}
}


if (!function_exists('aemi_meta_tags_callback'))
{
	function aemi_meta_tags_callback($post)
	{
		wp_nonce_field( 'aemi_meta_tags_nonce', 'aemi_meta_tags_nonce' );

		$opt = aemi_meta_tags_data($post);

		?><fieldset>
			<label for="aemi_meta_author">
				<?php echo esc_html__('Meta Tag: Author','aemi') ?>
				<input type="text" id="aemi_meta_author" name="aemi_meta_author" value="<?php echo esc_attr( $opt['author']['value'] ) ?>">
			</label>
		</fieldset>
		<fieldset>
			<label for="aemi_meta_description">
				<?php echo esc_html__('Meta Tag: Description','aemi') ?>
				<textarea id="aemi_meta_description" name="aemi_meta_description"><?php echo esc_textarea( $opt['description']['value'] ) ?></textarea>
			</label>	
		</fieldset>
		<fieldset>
			<label for="aemi_meta_keywords">
				<?php echo esc_html__('Meta Tag: Keywords','aemi') ?>
				<textarea id="aemi_meta_keywords" name="aemi_meta_keywords"><?php echo esc_textarea( $opt['keywords']['value'] ) ?></textarea>
			</label>
		</fieldset><?php
	}
}

if (!function_exists('aemi_save_meta_tags_data'))
{
	function aemi_save_meta_tags_data( $post_id )
	{

		if (!isset($_POST['aemi_meta_tags_nonce']))
			{ return; }

		if (!wp_verify_nonce($_POST['aemi_meta_tags_nonce'], 'aemi_meta_tags_nonce'))
			{ return; }

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			{ return; }

		if (isset($_POST['post_type']) && 'page' == $_POST['post_type'])
		{
			if (!current_user_can('edit_page', $post_id))
				{ return; }
		}
		else
		{
			if (!current_user_can('edit_post', $post_id))
				{ return; }
		}
		if (is_multisite() && ms_is_switched())
		{
      		return $post_id;
   		}

   		update_post_meta( $post_id, 'aemi_meta_author', sanitize_text_field( $_POST['aemi_meta_author'] ) );
   		update_post_meta( $post_id, 'aemi_meta_description', sanitize_text_field( $_POST['aemi_meta_description'] ) );
   		update_post_meta( $post_id, 'aemi_meta_keywords', sanitize_text_field( $_POST['aemi_meta_keywords'] ) );
	}
}

if (!function_exists('aemi_meta_tags__action'))
{
	function aemi_meta_tags__action()
	{

		global $post;

		foreach (aemi_meta_tags_data($post) as $k => $v) {
			if (isset($v['value']) && $v['value']!='') {
				?><meta name="<?php echo esc_attr( $k ) ?>" content="<?php echo esc_attr( $v['value'] ) ?>"><?php
			}
		}

	}
}

if (is_enabled('aemi_add_meta_tags',0))
{
	add_action( 'add_meta_boxes',	'aemi_add_meta_tags' );
	add_action( 'save_post',		'aemi_save_meta_tags_data' );
	add_action( 'aemi_head',		'aemi_meta_tags__action' );
}