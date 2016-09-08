<?php
/**
 * The main template for implementing Theme/Customzer Options
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


/**
 * Implements Fullframe theme options into Theme Customizer.
 *
 * @param $wp_customize Theme Customizer object
 * @return void
 *
 * @since Fullframe 1.0
 */
function fullframe_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport			= 'postMessage';

	/**
	  * Set priority of blogname (Site Title) to 1.
	  *  Strangly, if more than two options is added, Site title is moved below Tagline. This rectifies this issue.
	  */
	$wp_customize->get_control( 'blogname' )->priority			= 1;

	$wp_customize->get_setting( 'blogdescription' )->transport	= 'postMessage';

	$options  = fullframe_get_theme_options();

	$defaults = fullframe_get_default_theme_options();

	//Custom Controls
	require get_template_directory() . '/inc/customizer-includes/fullframe-customizer-custom-controls.php';

	//@remove Remove this block when WordPress 4.8 is released
	if ( ! function_exists( 'has_custom_logo' ) ) {
		// Custom Logo (added to Site Title and Tagline section in Theme Customizer)
		$wp_customize->add_setting( 'fullframe_theme_options[logo]', array(
			'capability'		=> 'edit_theme_options',
			'default'			=> $defaults['logo'],
			'sanitize_callback'	=> 'fullframe_sanitize_image'
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
			'label'		=> esc_html__( 'Logo', 'full-frame' ),
			'priority'	=> 100,
			'section'   => 'title_tagline',
	        'settings'  => 'fullframe_theme_options[logo]',
	    ) ) );

	    $wp_customize->add_setting( 'fullframe_theme_options[logo_disable]', array(
			'capability'		=> 'edit_theme_options',
			'default'			=> $defaults['logo_disable'],
			'sanitize_callback' => 'fullframe_sanitize_checkbox',
		) );

		$wp_customize->add_control( 'fullframe_theme_options[logo_disable]', array(
			'label'    => esc_html__( 'Check to disable logo', 'full-frame' ),
			'priority' => 101,
			'section'  => 'title_tagline',
			'settings' => 'fullframe_theme_options[logo_disable]',
			'type'     => 'checkbox',
		) );

		$wp_customize->add_setting( 'fullframe_theme_options[logo_alt_text]', array(
			'capability'		=> 'edit_theme_options',
			'default'			=> $defaults['logo_alt_text'],
			'sanitize_callback'	=> 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'fullframe_logo_alt_text', array(
			'label'    	=> esc_html__( 'Logo Alt Text', 'full-frame' ),
			'priority'	=> 102,
			'section' 	=> 'title_tagline',
			'settings' 	=> 'fullframe_theme_options[logo_alt_text]',
			'type'     	=> 'text',
		) );
	}

	$wp_customize->add_setting( 'fullframe_theme_options[move_title_tagline]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['move_title_tagline'],
		'sanitize_callback' => 'fullframe_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[move_title_tagline]', array(
		'label'    => esc_html__( 'Check to move Site Title and Tagline before logo', 'full-frame' ),
		'priority' => function_exists( 'has_custom_logo' ) ? 10 : 103,
		'section'  => 'title_tagline',
		'settings' => 'fullframe_theme_options[move_title_tagline]',
		'type'     => 'checkbox',
	) );
	// Custom Logo End

	// Color Scheme
	$wp_customize->add_setting( 'fullframe_theme_options[color_scheme]', array(
		'capability' 		=> 'edit_theme_options',
		'default'    		=> $defaults['color_scheme'],
		'sanitize_callback'	=> 'fullframe_sanitize_select',
		'transport'         => 'refresh',
	) );

	$schemes = fullframe_color_schemes();

	$choices = array();

	foreach ( $schemes as $scheme ) {
		$choices[ $scheme['value'] ] = $scheme['label'];
	}

	$wp_customize->add_control( 'fullframe_theme_options[color_scheme]', array(
		'choices'  => $choices,
		'label'    => esc_html__( 'Color Scheme', 'full-frame' ),
		'priority' => 5,
		'section'  => 'colors',
		'settings' => 'fullframe_theme_options[color_scheme]',
		'type'     => 'radio',
	) );
	//End Color Scheme

	// Header Options (added to Header section in Theme Customizer)
	require get_template_directory() . '/inc/customizer-includes/fullframe-customizer-header-options.php';

	//Theme Options
	require get_template_directory() . '/inc/customizer-includes/fullframe-customizer-theme-options.php';

	//Featured Content Setting
	require get_template_directory() . '/inc/customizer-includes/fullframe-customizer-featured-content-setting.php';

	//Featured Slider
	require get_template_directory() . '/inc/customizer-includes/fullframe-customizer-featured-slider.php';

	//Social Links
	require get_template_directory() . '/inc/customizer-includes/fullframe-customizer-social-icons.php';

	// Reset all settings to default
	$wp_customize->add_section( 'fullframe_reset_all_settings', array(
		'description'	=> esc_html__( 'Caution: Reset all settings to default. Refresh the page after save to view full effects.', 'full-frame' ),
		'priority' 		=> 700,
		'title'    		=> esc_html__( 'Reset all settings', 'full-frame' ),
	) );

	$wp_customize->add_setting( 'fullframe_theme_options[reset_all_settings]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['reset_all_settings'],
		'sanitize_callback' => 'fullframe_reset_all_settings',
		'transport'			=> 'postMessage',
	) );

	$wp_customize->add_control( 'fullframe_theme_options[reset_all_settings]', array(
		'label'    => esc_html__( 'Check to reset all settings to default', 'full-frame' ),
		'section'  => 'fullframe_reset_all_settings',
		'settings' => 'fullframe_theme_options[reset_all_settings]',
		'type'     => 'checkbox',
	) );
	// Reset all settings to default end

	//Important Links
	$wp_customize->add_section( 'important_links', array(
		'priority' 		=> 999,
		'title'   	 	=> esc_html__( 'Important Links', 'full-frame' ),
	) );

	/**
	 * Has dummy Sanitizaition function as it contains no value to be sanitized
	 */
	$wp_customize->add_setting( 'important_links', array(
		'sanitize_callback'	=> 'fullframe_sanitize_important_link',
	) );

	$wp_customize->add_control( new Fullframe_Important_Links( $wp_customize, 'important_links', array(
        'label'   	=> esc_html__( 'Important Links', 'full-frame' ),
         'section'  	=> 'important_links',
        'settings' 	=> 'important_links',
        'type'     	=> 'important_links',
    ) ) );
    //Important Links End
}
add_action( 'customize_register', 'fullframe_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously for fullframe.
 * And flushes out all transient data on preview
 *
 * @since Fullframe 1.0
 */
function fullframe_customize_preview() {
	wp_enqueue_script( 'fullframe_customizer', get_template_directory_uri() . '/js/fullframe-customizer.min.js', array( 'customize-preview' ), '20120827', true );

	//Flush transients on preview
	fullframe_flush_transients();
}
add_action( 'customize_preview_init', 'fullframe_customize_preview' );


/**
 * Custom scripts and styles on customize.php for fullframe.
 *
 * @since Fullframe 1.0
 */
function fullframe_customize_scripts() {
	wp_enqueue_script( 'fullframe_customizer_custom', get_template_directory_uri() . '/js/fullframe-customizer-custom-scripts.min.js', array( 'jquery' ), '20131028', true );

	$fullframe_misc_links = array(
							'upgrade_link' 				=> esc_url( 'https://catchthemes.com/themes/full-frame-pro/' ),
							'upgrade_text'	 			=> esc_html__( 'Upgrade To Pro &raquo;', 'full-frame' ),
		);

	//Add Upgrade Button and old WordPress message via localized script
	wp_localize_script( 'fullframe_customizer_custom', 'fullframe_misc_links', $fullframe_misc_links );

	wp_enqueue_style( 'fullframe_customizer_custom', get_template_directory_uri() . '/css/fullframe-customizer.css');
}
add_action( 'customize_controls_enqueue_scripts', 'fullframe_customize_scripts');


//Active callbacks for customizer
require get_template_directory() . '/inc/customizer-includes/fullframe-customizer-active-callbacks.php';

//Sanitize functions for customizer
require get_template_directory() . '/inc/customizer-includes/fullframe-customizer-sanitize-functions.php';