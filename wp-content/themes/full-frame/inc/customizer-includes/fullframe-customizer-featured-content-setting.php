<?php
/**
 * The template for adding Featured Content Settings in Customizer
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
	// Featured Content Options
	$wp_customize->add_panel( 'fullframe_featured_content_options', array(
	    'capability'     => 'edit_theme_options',
		'description'    => esc_html__( 'Options for Featured Content', 'full-frame' ),
	    'priority'       => 400,
	    'title'    		 => esc_html__( 'Featured Content', 'full-frame' ),
	) );

	$wp_customize->add_section( 'fullframe_featured_content_settings', array(
		'panel'			=> 'fullframe_featured_content_options',
		'priority'		=> 1,
		'title'			=> esc_html__( 'Featured Content Options', 'full-frame' ),
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[featured_content_option]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_option'],
		'sanitize_callback' => 'fullframe_sanitize_select',
	) );

	$fullframe_featured_slider_content_options = fullframe_featured_slider_content_options();
	$choices = array();
	foreach ( $fullframe_featured_slider_content_options as $fullframe_featured_slider_content_option ) {
		$choices[$fullframe_featured_slider_content_option['value']] = $fullframe_featured_slider_content_option['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[featured_content_option]', array(
		'choices'  	=> $choices,
		'label'    	=> esc_html__( 'Enable Featured Content on', 'full-frame' ),
		'priority'	=> '1',
		'section'  	=> 'fullframe_featured_content_settings',
		'settings' 	=> 'fullframe_theme_options[featured_content_option]',
		'type'	  	=> 'select',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[featured_content_layout]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_layout'],
		'sanitize_callback' => 'fullframe_sanitize_select',
	) );

	$fullframe_featured_content_layout_options = fullframe_featured_content_layout_options();
	$choices = array();
	foreach ( $fullframe_featured_content_layout_options as $fullframe_featured_content_layout_option ) {
		$choices[$fullframe_featured_content_layout_option['value']] = $fullframe_featured_content_layout_option['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[featured_content_layout]', array(
		'active_callback'	=> 'fullframe_is_featured_content_active',
		'choices'  	=> $choices,
		'label'    	=> esc_html__( 'Select Featured Content Layout', 'full-frame' ),
		'priority'	=> '2',
		'section'  	=> 'fullframe_featured_content_settings',
		'settings' 	=> 'fullframe_theme_options[featured_content_layout]',
		'type'	  	=> 'select',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[featured_content_position]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_position'],
		'sanitize_callback' => 'fullframe_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'fullframe_theme_options[featured_content_position]', array(
		'active_callback'	=> 'fullframe_is_featured_content_active',
		'label'		=> esc_html__( 'Check to Move above Footer', 'full-frame' ),
		'priority'	=> '3',
		'section'  	=> 'fullframe_featured_content_settings',
		'settings'	=> 'fullframe_theme_options[featured_content_position]',
		'type'		=> 'checkbox',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[featured_content_slider]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_slider'],
		'sanitize_callback' => 'fullframe_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'fullframe_theme_options[featured_content_slider]', array(
		'active_callback'	=> 'fullframe_is_featured_content_active',
		'label'		=> esc_html__( 'Check to Enable Sliding Effect', 'full-frame' ),
		'priority'	=> '4',
		'section'  	=> 'fullframe_featured_content_settings',
		'settings'	=> 'fullframe_theme_options[featured_content_slider]',
		'type'		=> 'checkbox',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[featured_content_type]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_type'],
		'sanitize_callback'	=> 'fullframe_sanitize_select',
	) );

	$fullframe_featured_content_types = fullframe_featured_content_types();
	$choices = array();
	foreach ( $fullframe_featured_content_types as $fullframe_featured_content_type ) {
		$choices[$fullframe_featured_content_type['value']] = $fullframe_featured_content_type['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[featured_content_type]', array(
		'active_callback'	=> 'fullframe_is_featured_content_active',
		'choices'  	=> $choices,
		'label'    	=> esc_html__( 'Select Content Type', 'full-frame' ),
		'priority'	=> '3',
		'section'  	=> 'fullframe_featured_content_settings',
		'settings' 	=> 'fullframe_theme_options[featured_content_type]',
		'type'	  	=> 'select',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[featured_content_headline]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_headline'],
		'sanitize_callback'	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[featured_content_headline]' , array(
		'active_callback'	=> 'fullframe_is_featured_content_active',
		'description'	=> esc_html__( 'Leave field empty if you want to remove Headline', 'full-frame' ),
		'label'    		=> esc_html__( 'Headline for Featured Content', 'full-frame' ),
		'priority'		=> '4',
		'section'  		=> 'fullframe_featured_content_settings',
		'settings' 		=> 'fullframe_theme_options[featured_content_headline]',
		'type'	   		=> 'text',
		)
	);

	$wp_customize->add_setting( 'fullframe_theme_options[featured_content_subheadline]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_subheadline'],
		'sanitize_callback'	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[featured_content_subheadline]' , array(
		'active_callback'	=> 'fullframe_is_featured_content_active',
		'description'	=> esc_html__( 'Leave field empty if you want to remove Sub-headline', 'full-frame' ),
		'label'    		=> esc_html__( 'Sub-headline for Featured Content', 'full-frame' ),
		'priority'		=> '5',
		'section'  		=> 'fullframe_featured_content_settings',
		'settings' 		=> 'fullframe_theme_options[featured_content_subheadline]',
		'type'	   		=> 'text',
		)
	);

	$wp_customize->add_setting( 'fullframe_theme_options[featured_content_number]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_number'],
		'sanitize_callback'	=> 'fullframe_sanitize_number_range',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[featured_content_number]' , array(
		'active_callback'	=> 'fullframe_is_demo_featured_content_inactive',
		'description'	=> esc_html__( 'Save and refresh the page if No. of Featured Content is changed (Max no of Featured Content is 20)', 'full-frame' ),
		'input_attrs' 	=> array(
            'style' => 'width: 45px;',
            'min'   => 0,
            'max'   => 20,
            'step'  => 1,
        	),
		'label'    		=> esc_html__( 'No of Featured Content', 'full-frame' ),
		'priority'		=> '6',
		'section'  		=> 'fullframe_featured_content_settings',
		'settings' 		=> 'fullframe_theme_options[featured_content_number]',
		'type'	   		=> 'number',
		)
	);

	$wp_customize->add_setting( 'fullframe_theme_options[featured_content_enable_title]', array(
	        'default'			=> $defaults['featured_content_enable_title'],
			'sanitize_callback'	=> 'fullframe_sanitize_checkbox',
		) );

	$wp_customize->add_control(  'fullframe_theme_options[featured_content_enable_title]', array(
		'active_callback'	=> 'fullframe_is_demo_featured_content_inactive',
		'label'		=> esc_html__( 'Check to Enable Title', 'full-frame' ),
        'priority'	=> '7',
		'section'   => 'fullframe_featured_content_settings',
        'settings'  => 'fullframe_theme_options[featured_content_enable_title]',
		'type'		=> 'checkbox',
    ) );

	$wp_customize->add_setting( 'fullframe_theme_options[featured_content_enable_excerpt_content]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_enable_excerpt_content'],
		'sanitize_callback'	=> 'fullframe_sanitize_select',
	) );

	$fullframe_featured_content_show = fullframe_featured_content_show();
	$choices = array();
	foreach ( $fullframe_featured_content_show as $fullframe_featured_content_shows ) {
		$choices[$fullframe_featured_content_shows['value']] = $fullframe_featured_content_shows['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[featured_content_enable_excerpt_content]', array(
		'active_callback'	=> 'fullframe_is_demo_featured_content_inactive',
		'choices'  	=> $choices,
		'label'    	=> esc_html__( 'Display Content', 'full-frame' ),
		'priority'	=> '8',
		'section'  	=> 'fullframe_featured_content_settings',
		'settings' 	=> 'fullframe_theme_options[featured_content_enable_excerpt_content]',
		'type'	  	=> 'select',
	) );

	//loop for featured page content
	for ( $i=1; $i <= $options['featured_content_number'] ; $i++ ) {
		$wp_customize->add_setting( 'fullframe_theme_options[featured_content_page_'. $i .']', array(
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'fullframe_sanitize_page',
		) );

		$wp_customize->add_control( 'fullframe_featured_content_page_'. $i .'', array(
			'active_callback'	=> 'fullframe_is_demo_featured_content_inactive',
			'label'    	=> esc_html__( 'Featured Page', 'full-frame' ) . ' ' . $i ,
			'priority'	=> '7' . $i,
			'section'  	=> 'fullframe_featured_content_settings',
			'settings' 	=> 'fullframe_theme_options[featured_content_page_'. $i .']',
			'type'	   	=> 'dropdown-pages',
		) );
	}

	$wp_customize->add_section( 'fullframe_featured_content_background_settings', array(
		'panel'			=> 'fullframe_featured_content_options',
		'priority'		=> 3,
		'title'			=> esc_html__( 'Featured Content Background Settings', 'full-frame' ),
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[featured_content_background_image]', array(
			'capability'		=> 'edit_theme_options',
			'default'			=> $defaults['featured_content_background_image'],
			'sanitize_callback'	=> 'esc_url_raw',
		) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fullframe_theme_options[featured_content_background_image]', array(
		'active_callback'	=> 'fullframe_is_featured_content_active',
		'label'		=> esc_html__( 'Select/Add Background Image', 'full-frame' ),
		'priority'	=> '1',
		'section'   => 'fullframe_featured_content_background_settings',
        'settings'  => 'fullframe_theme_options[featured_content_background_image]',
	) ) );
// Featured Content Setting End