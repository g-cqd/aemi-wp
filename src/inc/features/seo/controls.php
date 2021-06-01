<?php

if ( ! function_exists( 'aemi_features_controls__seo' ) ) {
	/**
	 * @param $wp_customize
	 */
	function aemi_features_controls__seo( $wp_customize ) {
		$wp_customize->add_control(
			'aemi_add_meta_tags',
			array(
				'label'       => __( 'Enable Meta Tags', 'aemi' ),
				'description' => __( 'Be able to fill author, description and keywords informations to define your content to search engines.', 'aemi' ),
				'section'     => 'aemi_seo',
				'settings'    => 'aemi_add_meta_tags',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_control(
			'aemi_add_meta_og',
			array(
				'label'       => __( 'Enable Open Graph', 'aemi' ),
				'description' => __( 'Open Graph is an internet protocol that was originally created by Facebook to standardize the use of metadata within a webpage to represent the content of a page. – from freeCodeCamp', 'aemi' ),
				'section'     => 'aemi_seo',
				'settings'    => 'aemi_add_meta_og',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_control(
			'aemi_add_meta_twitter',
			array(
				'label'       => __( 'Enable Twitter Cards', 'aemi' ),
				'description' => __( 'Add Twitter-specific informations to your content.', 'aemi' ),
				'section'     => 'aemi_seo',
				'settings'    => 'aemi_add_meta_twitter',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_control(
			new Aemi_Dropdown_Options(
				$wp_customize,
				'aemi_meta_twitter_card',
				array(
					'label'       => __( 'Twitter Card Type', 'aemi' ),
					'description' => __( 'How would you like your content to be displayed in tweets.', 'aemi' ),
					'section'     => 'aemi_seo',
					'settings'    => 'aemi_meta_twitter_card',
					'choices'     => array(
						'summary'             => __( 'Summary Card', 'aemi' ),
						'summary_large_image' => __( 'Summary Card with Large Image', 'aemi' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			'aemi_meta_twitter_site',
			array(
				'label'       => __( 'Twitter: Site Information', 'aemi' ),
				'description' => __( 'Enter your @username for the website used in the card footer.', 'aemi' ),
				'section'     => 'aemi_seo',
				'settings'    => 'aemi_meta_twitter_site',
				'type'        => 'input',
			)
		);

		$wp_customize->add_control(
			'aemi_meta_twitter_creator',
			array(
				'label'       => __( 'Twitter: Creator Information', 'aemi' ),
				'description' => __( 'Enter your @username for the content creator / author.', 'aemi' ),
				'section'     => 'aemi_seo',
				'settings'    => 'aemi_meta_twitter_creator',
				'type'        => 'input',
			)
		);
	}
}
