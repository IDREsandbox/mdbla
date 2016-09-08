<?php
/**
 * The template for adding additional theme options in Customizer
 *
 * @package Catch Themes
 * @subpackage Full Frame
 * @since Full Frame 1.0
 */

// Additional Color Scheme (added to Color Scheme section in Theme Customizer)
if ( ! defined( 'FULLFRAME_THEME_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


	//Theme Options
	$wp_customize->add_panel( 'fullframe_theme_options', array(
	    'description'    => esc_html__( 'Basic theme Options', 'full-frame' ),
	    'capability'     => 'edit_theme_options',
	    'priority'       => 200,
	    'title'    		 => esc_html__( 'Theme Options', 'full-frame' ),
	) );

	// Breadcrumb Option
	$wp_customize->add_section( 'fullframe_breadcumb_options', array(
		'description'	=> esc_html__( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance. You can enable/disable them on homepage and entire site.', 'full-frame' ),
		'panel'			=> 'fullframe_theme_options',
		'title'    		=> esc_html__( 'Breadcrumb Options', 'full-frame' ),
		'priority' 		=> 201,
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[breadcumb_option]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['breadcumb_option'],
		'sanitize_callback' => 'fullframe_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'fullframe_theme_options[breadcumb_option]', array(
		'label'    => esc_html__( 'Check to enable Breadcrumb', 'full-frame' ),
		'section'  => 'fullframe_breadcumb_options',
		'settings' => 'fullframe_theme_options[breadcumb_option]',
		'type'     => 'checkbox',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[breadcumb_onhomepage]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['breadcumb_onhomepage'],
		'sanitize_callback' => 'fullframe_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'fullframe_theme_options[breadcumb_onhomepage]', array(
		'label'    => esc_html__( 'Check to enable Breadcrumb on Homepage', 'full-frame' ),
		'section'  => 'fullframe_breadcumb_options',
		'settings' => 'fullframe_theme_options[breadcumb_onhomepage]',
		'type'     => 'checkbox',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[breadcumb_seperator]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['breadcumb_seperator'],
		'sanitize_callback'	=> 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[breadcumb_seperator]', array(
			'input_attrs' => array(
	            'style' => 'width: 40px;'
            	),
            'label'    	=> esc_html__( 'Separator between Breadcrumbs', 'full-frame' ),
			'section' 	=> 'fullframe_breadcumb_options',
			'settings' 	=> 'fullframe_theme_options[breadcumb_seperator]',
			'type'     	=> 'text'
		)
	);
   	// Breadcrumb Option End

   	// Custom CSS Option
	$wp_customize->add_section( 'fullframe_custom_css', array(
		'description'	=> esc_html__( 'Custom/Inline CSS', 'full-frame'),
		'panel'  		=> 'fullframe_theme_options',
		'priority' 		=> 203,
		'title'    		=> esc_html__( 'Custom CSS Options', 'full-frame' ),
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[custom_css]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['custom_css'],
		'sanitize_callback' => 'fullframe_sanitize_custom_css',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[custom_css]', array(
			'label'		=> esc_html__( 'Enter Custom CSS', 'full-frame' ),
	        'priority'	=> 1,
			'section'   => 'fullframe_custom_css',
	        'settings'  => 'fullframe_theme_options[custom_css]',
			'type'		=> 'textarea',
	) );
   	// Custom CSS End

   	// Excerpt Options
	$wp_customize->add_section( 'fullframe_excerpt_options', array(
		'panel'  	=> 'fullframe_theme_options',
		'priority' 	=> 204,
		'title'    	=> esc_html__( 'Excerpt Options', 'full-frame' ),
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[excerpt_length]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['excerpt_length'],
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[excerpt_length]', array(
		'description' => __('Excerpt length. Default is 40 words', 'full-frame'),
		'input_attrs' => array(
            'min'   => 10,
            'max'   => 200,
            'step'  => 5,
            'style' => 'width: 60px;'
            ),
        'label'    => esc_html__( 'Excerpt Length (words)', 'full-frame' ),
		'section'  => 'fullframe_excerpt_options',
		'settings' => 'fullframe_theme_options[excerpt_length]',
		'type'	   => 'number',
	)	);


	$wp_customize->add_setting( 'fullframe_theme_options[excerpt_more_text]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['excerpt_more_text'],
		'sanitize_callback'	=> 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[excerpt_more_text]', array(
		'label'    => esc_html__( 'Read More Text', 'full-frame' ),
		'section'  => 'fullframe_excerpt_options',
		'settings' => 'fullframe_theme_options[excerpt_more_text]',
		'type'	   => 'text',
	) );
	// Excerpt Options End

	//Homepage / Frontpage Options
	$wp_customize->add_section( 'fullframe_homepage_options', array(
		'description'	=> esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'full-frame' ),
		'panel'			=> 'fullframe_theme_options',
		'priority' 		=> 209,
		'title'   	 	=> esc_html__( 'Homepage / Frontpage Options', 'full-frame' ),
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[front_page_category]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['front_page_category'],
		'sanitize_callback'	=> 'fullframe_sanitize_category_list',
	) );

	$wp_customize->add_control( new Fullframe_Customize_Dropdown_Categories_Control( $wp_customize, 'fullframe_theme_options[front_page_category]', array(
        'label'   	=> esc_html__( 'Select Categories', 'full-frame' ),
        'name'	 	=> 'fullframe_theme_options[front_page_category]',
		'priority'	=> '6',
        'section'  	=> 'fullframe_homepage_options',
        'settings' 	=> 'fullframe_theme_options[front_page_category]',
        'type'     	=> 'dropdown-categories',
    ) ) );
	//Homepage / Frontpage Settings End

	// Icon Options
	$wp_customize->add_section( 'fullframe_icons', array(
		'description'	=> esc_html__( 'Remove Icon images to disable.', 'full-frame'),
		'panel'  => 'fullframe_theme_options',
		'priority' 		=> 210,
		'title'    		=> esc_html__( 'Icon Options', 'full-frame' ),
	) );

	//@remove Remove this block when WordPress 4.8 is released
	if ( ! function_exists( 'has_site_icon' ) ) {
		$wp_customize->add_setting( 'fullframe_theme_options[favicon]', array(
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'fullframe_sanitize_image',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fullframe_theme_options[favicon]', array(
			'label'		=> esc_html__( 'Select/Add Favicon', 'full-frame' ),
			'section'    => 'fullframe_icons',
	        'settings'   => 'fullframe_theme_options[favicon]',
		) ) );

		$wp_customize->add_setting( 'fullframe_theme_options[web_clip]', array(
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'fullframe_sanitize_image',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fullframe_theme_options[web_clip]', array(
			'description'	=> esc_html__( 'Web Clip Icon for Apple devices. Recommended Size - Width 144px and Height 144px height, which will support High Resolution Devices like iPad Retina.', 'full-frame'),
			'label'		 	=> esc_html__( 'Select/Add Web Clip Icon', 'full-frame' ),
			'section'    	=> 'fullframe_icons',
	        'settings'   	=> 'fullframe_theme_options[web_clip]',
		) ) );
	}

	$wp_customize->add_setting( 'fullframe_theme_options[logo_icon]', array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback'	=> 'fullframe_sanitize_image',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fullframe_theme_options[logo_icon]', array(
		'description'	=> esc_html__( 'Logo Icon is displayed in Primary Menu', 'full-frame'),
		'label'		 	=> esc_html__( 'Select/Add Logo Icon', 'full-frame' ),
		'section'    	=> 'fullframe_icons',
        'settings'   	=> 'fullframe_theme_options[logo_icon]',
	) ) );
	// Icon Options End

	// Layout Options
	$wp_customize->add_section( 'fullframe_layout', array(
		'capability'=> 'edit_theme_options',
		'panel'		=> 'fullframe_theme_options',
		'priority'	=> 211,
		'title'		=> esc_html__( 'Layout Options', 'full-frame' ),
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[theme_layout]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['theme_layout'],
		'sanitize_callback' => 'fullframe_sanitize_select',
	) );

	$layouts = fullframe_layouts();
	$choices = array();
	foreach ( $layouts as $layout ) {
		$choices[ $layout['value'] ] = $layout['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[theme_layout]', array(
		'choices'	=> $choices,
		'label'		=> esc_html__( 'Default Layout', 'full-frame' ),
		'section'	=> 'fullframe_layout',
		'settings'   => 'fullframe_theme_options[theme_layout]',
		'type'		=> 'select',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[content_layout]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['content_layout'],
		'sanitize_callback' => 'fullframe_sanitize_select',
	) );

	$layouts = fullframe_get_archive_content_layout();
	$choices = array();
	foreach ( $layouts as $layout ) {
		$choices[ $layout['value'] ] = $layout['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[content_layout]', array(
		'choices'   => $choices,
		'label'		=> esc_html__( 'Archive Content Layout', 'full-frame' ),
		'section'   => 'fullframe_layout',
		'settings'  => 'fullframe_theme_options[content_layout]',
		'type'      => 'select',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[single_post_image_layout]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['single_post_image_layout'],
		'sanitize_callback' => 'fullframe_sanitize_select',
	) );


	$single_post_image_layouts = fullframe_single_post_image_layout_options();
	$choices = array();
	foreach ( $single_post_image_layouts as $single_post_image_layout ) {
		$choices[$single_post_image_layout['value']] = $single_post_image_layout['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[single_post_image_layout]', array(
			'label'		=> esc_html__( 'Single Page/Post Image Layout ', 'full-frame' ),
			'section'   => 'fullframe_layout',
	        'settings'  => 'fullframe_theme_options[single_post_image_layout]',
	        'type'	  	=> 'select',
			'choices'  	=> $choices,
	) );
   	// Layout Options End

	// Pagination Options
	$pagination_type	= $options['pagination_type'];

	$fullframe_navigation_description = sprintf( __( 'Numeric Option requires <a target="_blank" href="%s">WP-PageNavi Plugin</a>.<br/>Infinite Scroll Options requires <a target="_blank" href="%s">JetPack Plugin</a> with Infinite Scroll module Enabled.', 'full-frame' ), esc_url( 'https://wordpress.org/plugins/wp-pagenavi' ), esc_url( 'https://wordpress.org/plugins/jetpack/' ) );

	/**
	 * Check if navigation type is Jetpack Infinite Scroll and if it is enabled
	 */
	if ( ( 'infinite-scroll-click' == $pagination_type || 'infinite-scroll-scroll' == $pagination_type ) ) {
		if ( ! (class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) ) {
			$fullframe_navigation_description = sprintf( __( 'Infinite Scroll Options requires <a target="_blank" href="%s">JetPack Plugin</a> with Infinite Scroll module Enabled.', 'full-frame' ), esc_url( 'https://wordpress.org/plugins/jetpack/' ) );
		}
		else {
			$fullframe_navigation_description = '';
		}
	}
	/**
	* Check if navigation type is numeric and if Wp-PageNavi Plugin is enabled
	*/
	else if ( 'numeric' == $pagination_type ) {
		if ( !function_exists( 'wp_pagenavi' ) ) {
			$fullframe_navigation_description = sprintf( __( 'Numeric Option requires <a target="_blank" href="%s">WP-PageNavi Plugin</a>.', 'full-frame' ), esc_url( 'https://wordpress.org/plugins/wp-pagenavi' ) );
		}
		else {
			$fullframe_navigation_description = '';
		}
    }

	$wp_customize->add_section( 'fullframe_pagination_options', array(
		'description'	=> $fullframe_navigation_description,
		'panel'  		=> 'fullframe_theme_options',
		'priority'		=> 212,
		'title'    		=> esc_html__( 'Pagination Options', 'full-frame' ),
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[pagination_type]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['pagination_type'],
		'sanitize_callback' => 'fullframe_sanitize_select',
	) );

	$pagination_types = fullframe_get_pagination_types();
	$choices = array();
	foreach ( $pagination_types as $pagination_type ) {
		$choices[$pagination_type['value']] = $pagination_type['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[pagination_type]', array(
		'choices'  => $choices,
		'label'    => esc_html__( 'Pagination type', 'full-frame' ),
		'section'  => 'fullframe_pagination_options',
		'settings' => 'fullframe_theme_options[pagination_type]',
		'type'	   => 'select',
	) );
	// Pagination Options End

	//Promotion Headline Options
    $wp_customize->add_section( 'fullframe_promotion_headline_options', array(
		'description'	=> esc_html__( 'To disable the fields, simply leave them empty.', 'full-frame' ),
		'panel'			=> 'fullframe_theme_options',
		'priority' 		=> 213,
		'title'   	 	=> esc_html__( 'Promotion Headline Options', 'full-frame' ),
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[promotion_headline_option]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['promotion_headline_option'],
		'sanitize_callback' => 'fullframe_sanitize_select',
	) );

	$fullframe_featured_slider_content_options = fullframe_featured_slider_content_options();
	$choices = array();
	foreach ( $fullframe_featured_slider_content_options as $fullframe_featured_slider_content_option ) {
		$choices[$fullframe_featured_slider_content_option['value']] = $fullframe_featured_slider_content_option['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[promotion_headline_option]', array(
		'choices'  	=> $choices,
		'label'    	=> esc_html__( 'Enable Promotion Headline on', 'full-frame' ),
		'priority'	=> '0.5',
		'section'  	=> 'fullframe_promotion_headline_options',
		'settings' 	=> 'fullframe_theme_options[promotion_headline_option]',
		'type'	  	=> 'select',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[promotion_headline]', array(
		'capability'		=> 'edit_theme_options',
		'default' 			=> $defaults['promotion_headline'],
		'sanitize_callback'	=> 'wp_kses_post'
	) );

	$wp_customize->add_control( 'fullframe_theme_options[promotion_headline]', array(
		'description'	=> esc_html__( 'Appropriate Words: 10', 'full-frame' ),
		'label'    	=> esc_html__( 'Promotion Headline Text', 'full-frame' ),
		'priority'	=> '1',
		'section' 	=> 'fullframe_promotion_headline_options',
		'settings'	=> 'fullframe_theme_options[promotion_headline]',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[promotion_subheadline]', array(
		'capability'		=> 'edit_theme_options',
		'default' 			=> $defaults['promotion_subheadline'],
		'sanitize_callback'	=> 'wp_kses_post'
	) );

	$wp_customize->add_control( 'fullframe_theme_options[promotion_subheadline]', array(
		'description'	=> esc_html__( 'Appropriate Words: 15', 'full-frame' ),
		'label'    	=> esc_html__( 'Promotion Subheadline Text', 'full-frame' ),
		'priority'	=> '2',
		'section' 	=> 'fullframe_promotion_headline_options',
		'settings'	=> 'fullframe_theme_options[promotion_subheadline]',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[promotion_headline_button]', array(
		'capability'		=> 'edit_theme_options',
		'default' 			=> $defaults['promotion_headline_button'],
		'sanitize_callback'	=> 'sanitize_text_field'
	) );

	$wp_customize->add_control( 'fullframe_theme_options[promotion_headline_button]', array(
		'description'	=> esc_html__( 'Appropriate Words: 3', 'full-frame' ),
		'label'    	=> esc_html__( 'Promotion Headline Button Text ', 'full-frame' ),
		'priority'	=> '3',
		'section' 	=> 'fullframe_promotion_headline_options',
		'settings'	=> 'fullframe_theme_options[promotion_headline_button]',
		'type'		=> 'text',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[promotion_headline_url]', array(
		'capability'		=> 'edit_theme_options',
		'default' 			=> $defaults['promotion_headline_url'],
		'sanitize_callback'	=> 'esc_url_raw'
	) );

	$wp_customize->add_control( 'fullframe_theme_options[promotion_headline_url]', array(
		'label'    	=> esc_html__( 'Promotion Headline Link', 'full-frame' ),
		'priority'	=> '4',
		'section' 	=> 'fullframe_promotion_headline_options',
		'settings'	=> 'fullframe_theme_options[promotion_headline_url]',
		'type'		=> 'text',
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[promotion_headline_target]', array(
		'capability'		=> 'edit_theme_options',
		'default' 			=> $defaults['promotion_headline_target'],
		'sanitize_callback' => 'fullframe_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[promotion_headline_target]', array(
		'label'    	=> esc_html__( 'Check to Open Link in New Window/Tab', 'full-frame' ),
		'priority'	=> '5',
		'section'  	=> 'fullframe_promotion_headline_options',
		'settings' 	=> 'fullframe_theme_options[promotion_headline_target]',
		'type'     	=> 'checkbox',
	) );
	// Promotion Headline Options End

	// Scrollup
	$wp_customize->add_section( 'fullframe_scrollup', array(
		'panel'    => 'fullframe_theme_options',
		'priority' => 215,
		'title'    => esc_html__( 'Scrollup Options', 'full-frame' ),
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[disable_scrollup]', array(
		'capability'		=> 'edit_theme_options',
        'default'			=> $defaults['disable_scrollup'],
		'sanitize_callback' => 'fullframe_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[disable_scrollup]', array(
		'label'		=> esc_html__( 'Check to disable Scroll Up', 'full-frame' ),
		'section'   => 'fullframe_scrollup',
        'settings'  => 'fullframe_theme_options[disable_scrollup]',
		'type'		=> 'checkbox',
	) );
	// Scrollup End

	// Search Options
	$wp_customize->add_section( 'fullframe_search_options', array(
		'description'=> esc_html__( 'Change default placeholder text in Search.', 'full-frame'),
		'panel'  => 'fullframe_theme_options',
		'priority' => 216,
		'title'    => esc_html__( 'Search Options', 'full-frame' ),
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[search_text]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['search_text'],
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[search_text]', array(
		'label'		=> esc_html__( 'Default Display Text in Search', 'full-frame' ),
		'section'   => 'fullframe_search_options',
        'settings'  => 'fullframe_theme_options[search_text]',
		'type'		=> 'text',
	) );
	// Search Options End
//Theme Option End