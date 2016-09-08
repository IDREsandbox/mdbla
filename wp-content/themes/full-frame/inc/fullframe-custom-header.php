<?php
/**
 * Implement Custom Header functionality
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


if ( ! function_exists( 'fullframe_custom_header' ) ) :
/**
 * Implementation of the Custom Header feature
 * Setup the WordPress core custom header feature and default custom headers packaged with the theme.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
	function fullframe_custom_header() {

		$args = array(
		// Text color and image (empty to use none).
		'default-text-color'     => '404040',

		// Header image default
		'default-image'			=> get_template_directory_uri() . '/images/gallery/slider1-1680x720.jpg',

		// Set height and width, with a maximum value for the width.
		'height'                 => 720,
		'width'                  => 1680,

		// Support flexible height and width.
		'flex-height'            => true,
		'flex-width'             => true,

		// Random image rotation off by default.
		'random-default'         => false,

		// Callbacks for styling the header and the admin preview.
		'wp-head-callback'       => 'fullframe_header_style',
		'admin-head-callback'    => 'fullframe_admin_header_style',
		'admin-preview-callback' => 'fullframe_admin_header_image',
	);

	$args = apply_filters( 'custom-header', $args );

	// Add support for custom header
	add_theme_support( 'custom-header', $args );

	}
endif; // fullframe_custom_header
add_action( 'after_setup_theme', 'fullframe_custom_header' );


if ( ! function_exists( 'fullframe_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see fullframe_custom_header()
 *
 * @since Full Frame 0.3
 */
function fullframe_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' != get_header_textcolor() ) { ?>
			.site-title a,
			.site-description {
				color: #<?php echo get_header_textcolor(); ?> !important;
			}
	<?php
	} ?>
	</style>
	<?php
}
endif; // fullframe_header_style


if ( ! function_exists( 'fullframe_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @since Full Frame 1.0
 */
function fullframe_admin_header_style() {
	$options 	= fullframe_get_theme_options();

	$defaults 	= fullframe_get_default_theme_options();
?>
	<style type="text/css">
	body {
		color: #404040;
		font-family: sans-serif;
		font-size: 15px;
		line-height: 1.5;
	}
	#site-logo,
	#site-header {
	    display: inline-block;
	    float: left;
	}
	#site-branding .site-title {
		font-size: 40px;
    	font-weight: bold;
    	line-height: 1.2;
    	margin: 0;
	}
	#site-branding .site-title a {
		color: #404040;
		text-decoration: none;
	}
	#site-branding .site-description {
		color: #404040;
		font-size: 13px;
		line-height: 1.2;
		font-style: italic;
		padding: 0;
	}
	.logo-left #site-header {
		padding-left: 10px;
	}
	.logo-right #site-header {
		padding-right: 10px;
	}
	#header-featured-image {
		clear: both;
		padding-top: 20px;
		max-width: 90%;
	}
	#header-featured-image img {
		height: auto;
		max-width: 100%;
	}
	<?php
	// If the user has set a custom color for the text use that
	if ( get_header_textcolor() != HEADER_TEXTCOLOR ) {
		echo '
		#site-branding .site-title a,
		#site-branding .site-description {
			color: #' . get_header_textcolor() . ';
		}';
	}
	 ?>
	</style>
<?php
}
endif; // fullframe_admin_header_style


if ( ! function_exists( 'fullframe_admin_header_image' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @since Full Frame 1.0
 */
function fullframe_admin_header_image() {

	fullframe_site_branding();
	fullframe_featured_image();
?>

<?php
}
endif; // fullframe_admin_header_image


if ( ! function_exists( 'fullframe_site_branding' ) ) :
	/**
	 * Get the logo and display
	 *
	 * @uses get_transient, fullframe_get_theme_options, get_header_textcolor, get_bloginfo, set_transient, display_header_text
	 * @get logo from options
	 *
	 * @display logo
	 *
	 * @action
	 *
	 * @since Fullframe 1.0
	 */
	function fullframe_site_branding() {
		$options 			= fullframe_get_theme_options();

		$logo_alt = ( '' != $options['logo_alt_text'] ) ? $options['logo_alt_text'] : get_bloginfo( 'name', 'display' );

		$fullframe_site_logo = '';
		//Checking Logo
		if ( function_exists( 'has_custom_logo' ) ) {
			if ( has_custom_logo() ) {
				$fullframe_site_logo = '
				<div id="site-logo">'. get_custom_logo() . '</div><!-- #site-logo -->';
			}
		}
		else if ( '' != $options['logo'] && !$options['logo_disable'] ) {
			$fullframe_site_logo = '
			<div id="site-logo">
				<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">
					<img src="' . esc_url( $options['logo'] ) . '" alt="' . esc_attr(  $logo_alt ) . '">
				</a>
			</div><!-- #site-logo -->';
		}

		$fullframe_header_text = '
		<div id="site-header">
			<h1 class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a></h1>
			<h2 class="site-description">' . get_bloginfo( 'description' ) . '</h2>
		</div><!-- #site-header -->';


		$text_color = get_header_textcolor();

		$fullframe_site_branding	= '<div id="site-branding">';
		$fullframe_site_branding	.= $fullframe_header_text;

		if ( function_exists( 'has_custom_logo' ) ) {
			if ( has_custom_logo() ) {
				if ( ! $options['move_title_tagline'] && 'blank' != $text_color ) {
					$fullframe_site_branding  = '<div id="site-branding" class="logo-left">';
					$fullframe_site_branding .= $fullframe_site_logo;
					$fullframe_site_branding .= $fullframe_header_text;
				}
				else {
					$fullframe_site_branding  = '<div id="site-branding" class="logo-right">';
					$fullframe_site_branding .= $fullframe_header_text;
					$fullframe_site_branding .= $fullframe_site_logo;
				}
			}
		}
		else if ( '' != $options['logo'] && !$options['logo_disable'] ) {
			if ( ! $options['move_title_tagline'] && 'blank' != $text_color ) {
				$fullframe_site_branding  = '<div id="site-branding" class="logo-left">';
				$fullframe_site_branding .= $fullframe_site_logo;
				$fullframe_site_branding .= $fullframe_header_text;
			}
			else {
				$fullframe_site_branding  = '<div id="site-branding" class="logo-right">';
				$fullframe_site_branding .= $fullframe_header_text;
				$fullframe_site_branding .= $fullframe_site_logo;
			}

		}

		$fullframe_site_branding 	.= '</div><!-- #site-branding-->';

		echo $fullframe_site_branding ;
	}
endif; // fullframe_site_branding
add_action( 'fullframe_header', 'fullframe_site_branding', 50 );


if ( ! function_exists( 'fullframe_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own fullframe_featured_image(), and that function will be used instead.
	 *
	 * @since Fullframe 1.0
	 */
	function fullframe_featured_image() {
		$options				= fullframe_get_theme_options();

		$header_image 			= get_header_image();

		//Support Random Header Image
		if ( is_random_header_image() ) {
			delete_transient( 'fullframe_featured_image' );
		}

		if ( !$fullframe_featured_image = get_transient( 'fullframe_featured_image' ) ) {

			echo '<!-- refreshing cache -->';

			if ( $header_image != '' ) {

				// Header Image Link and Target
				if ( !empty( $options[ 'featured_header_image_url' ] ) ) {
					//support for qtranslate custom link
					if ( function_exists( 'qtrans_convertURL' ) ) {
						$link = qtrans_convertURL($options[ 'featured_header_image_url' ]);
					}
					else {
						$link = esc_url( $options[ 'featured_header_image_url' ] );
					}
					//Checking Link Target
					if ( !empty( $options[ 'featured_header_image_base' ] ) )  {
						$target = '_blank';
					}
					else {
						$target = '_self';
					}
				}
				else {
					$link = '';
					$target = '';
				}

				// Header Image Title/Alt
				if ( !empty( $options[ 'featured_header_image_alt' ] ) ) {
					$title = esc_attr( $options[ 'featured_header_image_alt' ] );
				}
				else {
					$title = '';
				}

				// Header Image
				$feat_image = '<img class="wp-post-image" alt="'.$title.'" src="'.esc_url(  $header_image ).'" />';

				$fullframe_featured_image = '<div id="header-featured-image">
					<div class="wrapper">';
					// Header Image Link
					if ( !empty( $options[ 'featured_header_image_url' ] ) ) :
						$fullframe_featured_image .= '<a title="'. esc_attr( $title ).'" href="'. esc_url( $link ) .'" target="'.$target.'">' . $feat_image . '</a>';
					else:
						// if empty featured_header_image on theme options, display default
						$fullframe_featured_image .= $feat_image;
					endif;
				$fullframe_featured_image .= '</div><!-- .wrapper -->
				</div><!-- #header-featured-image -->';
			}

			set_transient( 'fullframe_featured_image', $fullframe_featured_image, 86940 );
		}

		echo $fullframe_featured_image;

	} // fullframe_featured_image
endif;


if ( ! function_exists( 'fullframe_featured_page_post_image' ) ) :
	/**
	 * Template for Featured Header Image from Post and Page
	 *
	 * To override this in a child theme
	 * simply create your own fullframe_featured_imaage_pagepost(), and that function will be used instead.
	 *
	 * @since Fullframe 1.0
	 */
	function fullframe_featured_page_post_image() {
		global $post, $wp_query;

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();
		$page_for_posts = get_option('page_for_posts');

		if ( is_home() && $page_for_posts == $page_id ) {
			$header_page_id = $page_id;
		}
		else {
			$header_page_id = $post->ID;
		}

		if( has_post_thumbnail( $header_page_id ) ) {
		   	$options					= fullframe_get_theme_options();
			$featured_header_image_url	= $options['featured_header_image_url'];
			$featured_header_image_base	= $options['featured_header_image_base'];

			if ( '' != $featured_header_image_url ) {
				//support for qtranslate custom link
				if ( function_exists( 'qtrans_convertURL' ) ) {
					$link = qtrans_convertURL( $featured_header_image_url );
				}
				else {
					$link = esc_url( $featured_header_image_url );
				}
				//Checking Link Target
				if ( '1' == $featured_header_image_base ) {
					$target = '_blank';
				}
				else {
					$target = '_self';
				}
			}
			else {
				$link = '';
				$target = '';
			}

			$featured_header_image_alt	= $options['featured_header_image_alt'];
			// Header Image Title/Alt
			if ( '' != $featured_header_image_alt ) {
				$title = esc_attr( $featured_header_image_alt );
			}
			else {
				$title = '';
			}

			$featured_image_size	= $options['featured_image_size'];

			if ( 'slider' ==  $featured_image_size ) {
				$feat_image = get_the_post_thumbnail( $post->ID, 'fullframe-slider', array('id' => 'main-feat-img'));
			}
			else if ( 'full' ==  $featured_image_size ) {
				$feat_image = get_the_post_thumbnail( $post->ID, 'full', array('id' => 'main-feat-img'));
			}
			else {
				$feat_image = get_the_post_thumbnail( $post->ID, 'fullframe-large', array('id' => 'main-feat-img'));
			}

			$fullframe_featured_image = '<div id="header-featured-image" class =' . $featured_image_size . '>';
				// Header Image Link
				if ( '' != $featured_header_image_url ) :
					$fullframe_featured_image .= '<a title="'. esc_attr( $title ).'" href="'. esc_url( $link ) .'" target="'.$target.'">' . $feat_image . '</a>';
				else:
					// if empty featured_header_image on theme options, display default
					$fullframe_featured_image .= $feat_image;
				endif;
			$fullframe_featured_image .= '</div><!-- #header-featured-image -->';

			echo $fullframe_featured_image;
		}
		else {
			fullframe_featured_image();
		}
	} // fullframe_featured_page_post_image
endif;


if ( ! function_exists( 'fullframe_featured_overall_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own fullframe_featured_pagepost_image(), and that function will be used instead.
	 *
	 * @since Fullframe 1.0
	 */
	function fullframe_featured_overall_image() {
		global $post, $wp_query;
		$options				= fullframe_get_theme_options();
		$defaults 				= fullframe_get_default_theme_options();
		$enableheaderimage 		= $options['enable_featured_header_image'];

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		$page_for_posts = get_option('page_for_posts');

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_page() || is_single() ) {
			//Individual Page/Post Image Setting
			$individual_featured_image = get_post_meta( $post->ID, 'fullframe-header-image', true );

			if ( $individual_featured_image == 'disable' || ( $individual_featured_image == 'default' && $enableheaderimage == 'disable' ) ) {
				echo '<!-- Page/Post Disable Header Image -->';
				return;
			}
			elseif ( $individual_featured_image == 'enable' && $enableheaderimage == 'disabled' ) {
				fullframe_featured_page_post_image();
			}
		}

		// Check Homepage
		if ( $enableheaderimage == 'homepage' ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				fullframe_featured_image();
			}
		}
		// Check Excluding Homepage
		if ( $enableheaderimage == 'exclude-home' ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				return false;
			}
			else {
				fullframe_featured_image();
			}
		}
		elseif ( $enableheaderimage == 'exclude-home-page-post' ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				return false;
			}
			elseif ( is_page() || is_single() ) {
				fullframe_featured_page_post_image();
			}
			else {
				fullframe_featured_image();
			}
		}
		// Check Entire Site
		elseif ( $enableheaderimage == 'entire-site' ) {
			fullframe_featured_image();
		}
		// Check Entire Site (Post/Page)
		elseif ( $enableheaderimage == 'entire-site-page-post' ) {
			if ( is_page() || is_single() ) {
				fullframe_featured_page_post_image();
			}
			else {
				fullframe_featured_image();
			}
		}
		// Check Page/Post
		elseif ( $enableheaderimage == 'pages-posts' ) {
			if ( is_page() || is_single() ) {
				fullframe_featured_page_post_image();
			}
		}
		else {
			echo '<!-- Disable Header Image -->';
		}
	} // fullframe_featured_overall_image
endif;

add_action( 'fullframe_before_content', 'fullframe_featured_overall_image', 20 );