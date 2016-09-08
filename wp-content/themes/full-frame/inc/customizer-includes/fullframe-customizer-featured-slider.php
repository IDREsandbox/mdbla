<?php
/**
 * The template for adding Featured Slider Options in Customizer
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
	// Featured Slider
	if ( 4.3 > get_bloginfo( 'version' ) ) {
		$wp_customize->add_panel( 'fullframe_featured_slider', array(
		    'capability'     => 'edit_theme_options',
		    'description'    => esc_html__( 'Featured Slider Options', 'full-frame' ),
		    'priority'       => 500,
			'title'    		 => esc_html__( 'Featured Slider', 'full-frame' ),
		) );

		$wp_customize->add_section( 'fullframe_featured_slider', array(
			'panel'			=> 'fullframe_featured_slider',
			'priority'		=> 1,
			'title'			=> esc_html__( 'Featured Slider Options', 'full-frame' ),
		) );
	}
	else {
		$wp_customize->add_section( 'fullframe_featured_slider', array(
			'priority'		=> 400,
			'title'			=> esc_html__( 'Featured Slider', 'full-frame' ),
		) );
	}

	$wp_customize->add_setting( 'fullframe_theme_options[featured_slider_option]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slider_option'],
		'sanitize_callback' => 'fullframe_sanitize_select',
	) );

	$featured_slider_content_options = fullframe_featured_slider_content_options();
	$choices = array();
	foreach ( $featured_slider_content_options as $featured_slider_content_option ) {
		$choices[$featured_slider_content_option['value']] = $featured_slider_content_option['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[featured_slider_option]', array(
		'choices'   => $choices,
		'label'    	=> esc_html__( 'Enable Slider on', 'full-frame' ),
		'priority'	=> '1.1',
		'section'  	=> 'fullframe_featured_slider',
		'settings' 	=> 'fullframe_theme_options[featured_slider_option]',
		'type'    	=> 'select',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[featured_slide_transition_effect]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_transition_effect'],
		'sanitize_callback'	=> 'fullframe_sanitize_select',
	) );

	$fullframe_featured_slide_transition_effects = fullframe_featured_slide_transition_effects();
	$choices = array();
	foreach ( $fullframe_featured_slide_transition_effects as $fullframe_featured_slide_transition_effect ) {
		$choices[$fullframe_featured_slide_transition_effect['value']] = $fullframe_featured_slide_transition_effect['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[featured_slide_transition_effect]' , array(
		'active_callback'	=> 'fullframe_is_slider_active',
		'choices'  	=> $choices,
		'label'		=> esc_html__( 'Transition Effect', 'full-frame' ),
		'priority'	=> '2',
		'section'  	=> 'fullframe_featured_slider',
		'settings' 	=> 'fullframe_theme_options[featured_slide_transition_effect]',
		'type'	  	=> 'select',
		)
	);

	$wp_customize->add_setting( 'fullframe_theme_options[featured_slide_transition_delay]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_transition_delay'],
		'sanitize_callback'	=> 'fullframe_sanitize_number_range',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[featured_slide_transition_delay]' , array(
		'active_callback'	=> 'fullframe_is_slider_active',
		'description'	=> esc_html__( 'seconds(s)', 'full-frame' ),
		'input_attrs' => array(
            'style' => 'width: 40px;'
        	),
		'label'    		=> esc_html__( 'Transition Delay', 'full-frame' ),
		'priority'		=> '2.1.1',
		'section'  		=> 'fullframe_featured_slider',
		'settings' 		=> 'fullframe_theme_options[featured_slide_transition_delay]',
		)
	);

	$wp_customize->add_setting( 'fullframe_theme_options[featured_slide_transition_length]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_transition_length'],
		'sanitize_callback'	=> 'fullframe_sanitize_number_range',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[featured_slide_transition_length]' , array(
		'active_callback'	=> 'fullframe_is_slider_active',
		'description'	=> esc_html__( 'seconds(s)', 'full-frame' ),
		'input_attrs' => array(
	            'style' => 'width: 40px;'
            	),
		'label'    		=> esc_html__( 'Transition Length', 'full-frame' ),
		'priority'		=> '2.1.2',
		'section'  		=> 'fullframe_featured_slider',
		'settings' 		=> 'fullframe_theme_options[featured_slide_transition_length]',
		)
	);

	$wp_customize->add_setting( 'fullframe_theme_options[featured_slider_image_loader]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slider_image_loader'],
		'sanitize_callback' => 'fullframe_sanitize_select',
	) );

	$featured_slider_image_loader_options = fullframe_featured_slider_image_loader();
	$choices = array();
	foreach ( $featured_slider_image_loader_options as $featured_slider_image_loader_option ) {
		$choices[$featured_slider_image_loader_option['value']] = $featured_slider_image_loader_option['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[featured_slider_image_loader]', array(
		'active_callback'	=> 'fullframe_is_slider_active',
		'description'	=> esc_html__( 'True: Fixes the height overlap issue. Slideshow will start as soon as two slider are available. Slide may display in random, as image is fetch.<br>Wait: Fixes the height overlap issue.<br> Slideshow will start only after all images are available.', 'full-frame' ),
		'choices'   => $choices,
		'label'    	=> esc_html__( 'Image Loader', 'full-frame' ),
		'priority'	=> '2.1.3',
		'section'  	=> 'fullframe_featured_slider',
		'settings' 	=> 'fullframe_theme_options[featured_slider_image_loader]',
		'type'    	=> 'select',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[featured_slider_type]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slider_type'],
		'sanitize_callback'	=> 'fullframe_sanitize_select',
	) );

	$featured_slider_types = fullframe_featured_slider_types();
	$choices = array();
	foreach ( $featured_slider_types as $featured_slider_type ) {
		$choices[$featured_slider_type['value']] = $featured_slider_type['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[featured_slider_type]', array(
		'active_callback'	=> 'fullframe_is_slider_active',
		'choices'  	=> $choices,
		'label'    	=> esc_html__( 'Select Slider Type', 'full-frame' ),
		'priority'	=> '2.1.3',
		'section'  	=> 'fullframe_featured_slider',
		'settings' 	=> 'fullframe_theme_options[featured_slider_type]',
		'type'	  	=> 'select',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[featured_slide_number]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_number'],
		'sanitize_callback'	=> 'fullframe_sanitize_number_range',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[featured_slide_number]' , array(
		'active_callback'	=> 'fullframe_is_demo_slider_inactive',
		'description'	=> esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'full-frame' ),
		'input_attrs' 	=> array(
            'style' => 'width: 45px;',
            'min'   => 0,
            'max'   => 20,
            'step'  => 1,
        	),
		'label'    		=> esc_html__( 'No of Slides', 'full-frame' ),
		'priority'		=> '2.1.4',
		'section'  		=> 'fullframe_featured_slider',
		'settings' 		=> 'fullframe_theme_options[featured_slide_number]',
		'type'	   		=> 'number',
		)
	);

	//loop for featured page sliders
	for ( $i=1; $i <= $options['featured_slide_number'] ; $i++ ) {
		$wp_customize->add_setting( 'fullframe_theme_options[featured_slider_page_'. $i .']', array(
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'fullframe_sanitize_page',
		) );

		$wp_customize->add_control( 'fullframe_featured_slider_page_'. $i .'', array(
			'active_callback'	=> 'fullframe_is_demo_slider_inactive',
			'label'    	=> esc_html__( 'Featured Page', 'full-frame' ) . ' # ' . $i ,
			'priority'	=> '4' . $i,
			'section'  	=> 'fullframe_featured_slider',
			'settings' 	=> 'fullframe_theme_options[featured_slider_page_'. $i .']',
			'type'	   	=> 'dropdown-pages',
		) );
	}
// Featured Slider End