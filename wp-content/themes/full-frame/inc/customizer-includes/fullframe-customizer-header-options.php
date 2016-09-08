<?php
/**
 * The template for adding Additional Header Option in Customizer
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

	// Header Options
	$wp_customize->add_setting( 'fullframe_theme_options[enable_featured_header_image]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['enable_featured_header_image'],
		'sanitize_callback' => 'fullframe_sanitize_select',
	) );

	$fullframe_enable_featured_header_image_options = fullframe_enable_featured_header_image_options();
	$choices = array();
	foreach ( $fullframe_enable_featured_header_image_options as $fullframe_enable_featured_header_image_option ) {
		$choices[$fullframe_enable_featured_header_image_option['value']] = $fullframe_enable_featured_header_image_option['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[enable_featured_header_image]', array(
			'choices'  	=> $choices,
			'label'		=> esc_html__( 'Enable Featured Header Image on ', 'full-frame' ),
			'section'   => 'header_image',
	        'settings'  => 'fullframe_theme_options[enable_featured_header_image]',
	        'type'	  	=> 'select',
	) );


	$wp_customize->add_setting( 'fullframe_theme_options[featured_image_size]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_image_size'],
		'sanitize_callback' => 'fullframe_sanitize_select',
	) );

	$fullframe_featured_image_size_options = fullframe_featured_image_size_options();
	$choices = array();
	foreach ( $fullframe_featured_image_size_options as $fullframe_featured_image_size_option ) {
		$choices[$fullframe_featured_image_size_option['value']] = $fullframe_featured_image_size_option['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[featured_image_size]', array(
			'choices'  	=> $choices,
			'label'		=> esc_html__( 'Page/Post Featured Header Image Size', 'full-frame' ),
			'section'   => 'header_image',
			'settings'  => 'fullframe_theme_options[featured_image_size]',
			'type'	  	=> 'select',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[featured_header_image_alt]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_header_image_alt'],
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[featured_header_image_alt]', array(
			'label'		=> esc_html__( 'Featured Header Image Alt/Title Tag ', 'full-frame' ),
			'section'   => 'header_image',
	        'settings'  => 'fullframe_theme_options[featured_header_image_alt]',
	        'type'	  	=> 'text',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[featured_header_image_url]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_header_image_url'],
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[featured_header_image_url]', array(
			'label'		=> esc_html__( 'Featured Header Image Link URL', 'full-frame' ),
			'section'   => 'header_image',
	        'settings'  => 'fullframe_theme_options[featured_header_image_url]',
	        'type'	  	=> 'text',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[featured_header_image_base]', array(
		'capability'		=> 'edit_theme_options',
		'default'	=> $defaults['featured_header_image_url'],
		'sanitize_callback' => 'fullframe_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[featured_header_image_base]', array(
		'label'    	=> esc_html__( 'Check to Open Link in New Window/Tab', 'full-frame' ),
		'section'  	=> 'header_image',
		'settings' 	=> 'fullframe_theme_options[featured_header_image_base]',
		'type'     	=> 'checkbox',
	) );
// Header Options End