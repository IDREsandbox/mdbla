<?php
/**
 * The default template for displaying header
 *
 * @package Catch Themes
 * @subpackage Full Frame Pro
 * @since Full Frame 1.0 
 */

	/** 
	 * fullframe_doctype hook
	 *
	 * @hooked fullframe_doctype -  10
	 *
	 */
	do_action( 'fullframe_doctype' );?>

<head>
<?php	
	/** 
	 * fullframe_before_wp_head hook
	 *
	 * @hooked fullframe_head -  10
	 * 
	 */
	do_action( 'fullframe_before_wp_head' );

	wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php 
	/** 
     * fullframe_before_header hook
     *
     */
    do_action( 'fullframe_before' );
	
	/** 
	 * fullframe_site_branding hook
	 *
	 * @hooked fullframe_page_start -  10
	 * @hooked fullframe_fixed_header_start - 20
     * @hooked fullframe_primary_menu - 30 
     * @hooked fullframe_header_start - 40
     * @hooked fullframe_site_branding - 50 
	 * @hooked fullframe_header_right - 60
	 * @hooked fullframe_header_end - 70
     * @hooked fullframe_fixed_header_end - 80
	 * 
	 */
	do_action( 'fullframe_header' );

	/** 
     * fullframe_after_header hook
     */
	do_action( 'fullframe_after_header' ); 

	/** 
	 * fullframe_before_content hook
	 *
	 * @hooked fullframe_featured_slider - 10
     * @hooked fullframe_featured_overall_image - 20
	 * @hooked fullframe_add_breadcrumb - 30
	 * @hooked fullframe_promotion_headline - 40
	 * @hooked fullframe_featured_content_display (move featured content above homepage posts - default option) - 50	
	 */
	do_action( 'fullframe_before_content' );
	
	/** 
     * fullframe_main hook
     *
     *  @hooked fullframe_content_start - 10
     *
     */
	do_action( 'fullframe_content' );	