<?php
/**
 * The template for Social Links in Customizer
 *
 * @package Catch Themes
 * @subpackage Full Frame
 * @since Full Frame 1.0
 */

if ( ! defined( 'FULLFRAME_THEME_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

	// Social Icons
	$wp_customize->add_panel( 'fullframe_social_links', array(
	    'capability'     => 'edit_theme_options',
	    'description'	=> esc_html__( 'Note: Enter the url for correponding social networking website', 'full-frame' ),
	    'priority'       => 600,
		'title'    		 => esc_html__( 'Social Links', 'full-frame' ),
	) );

	$wp_customize->add_section( 'fullframe_social_links', array(
		'panel'			=> 'fullframe_social_links',
		'priority' 		=> 1,
		'title'   	 	=> esc_html__( 'Social Links', 'full-frame' ),
	) );

	$fullframe_social_icons 	=	fullframe_get_social_icons_list();

	foreach ( $fullframe_social_icons as $key => $value ){
		if( 'skype_link' == $key ){
			$wp_customize->add_setting( 'fullframe_theme_options['. $key .']', array(
					'capability'		=> 'edit_theme_options',
					'sanitize_callback' => 'esc_attr',
				) );

			$wp_customize->add_control( 'fullframe_theme_options['. $key .']', array(
				'description'	=> esc_html__( 'Skype link can be of formats:<br>callto://+{number}<br> skype:{username}?{action}. More Information in readme file', 'full-frame' ),
				'label'    		=> $value['label'],
				'section'  		=> 'fullframe_social_links',
				'settings' 		=> 'fullframe_theme_options['. $key .']',
				'type'	   		=> 'url',
			) );
		}
		else {
			if( 'email_link' == $key ){
				$wp_customize->add_setting( 'fullframe_theme_options['. $key .']', array(
						'capability'		=> 'edit_theme_options',
						'sanitize_callback' => 'sanitize_email',
					) );
			}
			else if( 'handset_link' == $key || 'phone_link' == $key ){
				$wp_customize->add_setting( 'fullframe_theme_options['. $key .']', array(
						'capability'		=> 'edit_theme_options',
						'sanitize_callback' => 'sanitize_text_field',
					) );
			}
			else {
				$wp_customize->add_setting( 'fullframe_theme_options['. $key .']', array(
						'capability'		=> 'edit_theme_options',
						'sanitize_callback' => 'esc_url_raw',
					) );
			}

			$wp_customize->add_control( 'fullframe_theme_options['. $key .']', array(
				'label'    => $value['label'],
				'section'  => 'fullframe_social_links',
				'settings' => 'fullframe_theme_options['. $key .']',
				'type'	   => 'url',
			) );
		}
	}
	// Social Icons End