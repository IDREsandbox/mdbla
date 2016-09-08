<?php
/**
 * The template for Managing Theme Structure
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


if ( ! function_exists( 'fullframe_doctype' ) ) :
	/**
	 * Doctype Declaration
	 *
	 * @since Fullframe 1.0
	 *
	 */
	function fullframe_doctype() {
		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>
		<?php
	}
endif;
add_action( 'fullframe_doctype', 'fullframe_doctype', 10 );


if ( ! function_exists( 'fullframe_head' ) ) :
	/**
	 * Header Codes
	 *
	 * @since Fullframe 1.0
	 *
	 */
	function fullframe_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<!--[if lt IE 9]>
			<script src="<?php echo get_template_directory_uri(); ?>/js/html5.min.js"></script>
		<![endif]-->
		<?php
	}
endif;
add_action( 'fullframe_before_wp_head', 'fullframe_head', 10 );


if ( ! function_exists( 'fullframe_doctype_start' ) ) :
	/**
	 * Start div id #page
	 *
	 * @since Fullframe 1.0
	 *
	 */
	function fullframe_page_start() {
		?>
		<div id="page" class="hfeed site">
		<?php
	}
endif;
add_action( 'fullframe_header', 'fullframe_page_start', 10 );

if ( ! function_exists( 'fullframe_page_end' ) ) :
	/**
	 * End div id #page
	 *
	 * @since Fullframe 1.0
	 *
	 */
	function fullframe_page_end() {
		?>
		</div><!-- #page -->
		<?php
	}
endif;
add_action( 'fullframe_footer', 'fullframe_page_end', 200 );


if ( ! function_exists( 'fullframe_fixed_header_start' ) ) :
	/**
	 * Start div id #fixed-header
	 *
	 * @since Fullframe 1.0
	 *
	 */
	function fullframe_fixed_header_start() {
		?>
		<div id="fixed-header">
		<?php
	}
endif;
add_action( 'fullframe_header', 'fullframe_fixed_header_start', 20 );


if ( ! function_exists( 'fullframe_fixed_header_end' ) ) :
	/**
	 * End div id #fixed-header
	 *
	 * @since Fullframe 1.0
	 *
	 */
	function fullframe_fixed_header_end() {
		?>
		</div><!-- #fixed-header -->
		<?php
	}
endif;
add_action( 'fullframe_header', 'fullframe_fixed_header_end', 80 );


if ( ! function_exists( 'fullframe_header_start' ) ) :
	/**
	 * Start Header id #masthead and class .wrapper
	 *
	 * @since Fullframe 1.0
	 *
	 */
	function fullframe_header_start() {
		?>
		<header id="masthead" class="displaynone" role="banner">
    		<div class="wrapper">
		<?php
	}
endif;
add_action( 'fullframe_header', 'fullframe_header_start', 40 );


if ( ! function_exists( 'fullframe_header_end' ) ) :
	/**
	 * End Header id #masthead and class .wrapper
	 *
	 * @since Fullframe 1.0
	 *
	 */
	function fullframe_header_end() {
		?>
			</div><!-- .wrapper -->
		</header><!-- #masthead -->
		<?php
	}
endif;
add_action( 'fullframe_header', 'fullframe_header_end', 70 );


if ( ! function_exists( 'fullframe_content_start' ) ) :
	/**
	 * Start div id #content and class .wrapper
	 *
	 * @since Fullframe 1.0
	 *
	 */
	function fullframe_content_start() {
		?>
		<div id="content" class="site-content">
			<div class="wrapper">
	<?php
	}
endif;
add_action('fullframe_content', 'fullframe_content_start', 10 );

if ( ! function_exists( 'fullframe_content_end' ) ) :
	/**
	 * End div id #content and class .wrapper
	 *
	 * @since Fullframe 1.0
	 */
	function fullframe_content_end() {
		?>
			</div><!-- .wrapper -->
	    </div><!-- #content -->
		<?php
	}

endif;
add_action( 'fullframe_after_content', 'fullframe_content_end', 30 );


if ( ! function_exists( 'fullframe_footer_content_start' ) ) :
/**
 * Start footer id #colophon
 *
 * @since Fullframe 1.0
 */
function fullframe_footer_content_start() {
	?>
	<footer id="colophon" class="site-footer" role="contentinfo">
    <?php
}
endif;
add_action( 'fullframe_footer', 'fullframe_footer_content_start', 30 );


if ( ! function_exists( 'fullframe_footer_sidebar' ) ) :
/**
 * Footer Sidebar
 *
 * @since Fullframe 1.0
 */
function fullframe_footer_sidebar() {
	get_sidebar( 'footer' );
}
endif;
add_action( 'fullframe_footer', 'fullframe_footer_sidebar', 40 );


if ( ! function_exists( 'fullframe_footer_content_end' ) ) :
/**
 * End footer id #colophon
 *
 * @since Fullframe 1.0
 */
function fullframe_footer_content_end() {
	?>
	</footer><!-- #colophon -->
	<?php
}
endif;
add_action( 'fullframe_footer', 'fullframe_footer_content_end', 110 );


if ( ! function_exists( 'fullframe_header_right' ) ) :
/**
 * Shows Header Right
 *
 * @since Fullframe 1.0
 */
function fullframe_header_right() { ?>
	<aside class="sidebar sidebar-header-right widget-area">
		<?php if ( '' != ( $fullframe_social_icons = fullframe_get_social_icons() ) ) { ?>
			<section class="widget widget_fullframe_social_icons" id="header-right-social-icons">
				<div class="widget-wrap">
					<?php echo $fullframe_social_icons; ?>
				</div>
			</section>
		<?php } ?>
		<section class="widget widget_search" id="header-right-search">
			<div class="widget-wrap">
				<?php echo get_search_form(); ?>
			</div>
		</section>
	</aside><!-- .sidebar .header-sidebar .widget-area -->
<?php	
}
endif;
add_action( 'fullframe_header', 'fullframe_header_right', 60 );