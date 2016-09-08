<?php
/**
 * Implement Default Theme/Customizer Options
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
 * Returns the default options for fullframe.
 *
 * @since Fullframe 1.0
 */
function fullframe_get_default_theme_options() {

	$default_theme_options = array(
		//Site Title an Tagline
		'logo'												=> get_template_directory_uri() . '/images/headers/logo.png',
		'logo_alt_text' 									=> '',
		'logo_disable'										=> 1,
		'move_title_tagline'								=> 0,

		//Layout
		'theme_layout' 										=> 'right-sidebar',
		'content_layout'									=> 'excerpt-featured-image',
		'single_post_image_layout'							=> 'disabled',

		//Header Image
		'enable_featured_header_image'						=> 'exclude-home-page-post',
		'featured_image_size'								=> 'slider',
		'featured_header_image_url'							=> '',
		'featured_header_image_alt'							=> '',
		'featured_header_image_base'						=> 0,

		//Breadcrumb Options
		'breadcumb_option'									=> 0,
		'breadcumb_onhomepage'								=> 0,
		'breadcumb_seperator'								=> '&raquo;',

		//Custom CSS
		'custom_css'										=> '',

		//Scrollup Options
		'disable_scrollup'									=> 0,

		//Excerpt Options
		'excerpt_length'									=> '40',
		'excerpt_more_text'									=> esc_html__( 'Read More ...', 'full-frame' ),

		//Homepage / Frontpage Settings
		'front_page_category'								=> array(),

		//Pagination Options
		'pagination_type'									=> 'default',

		//Promotion Headline Options
		'promotion_headline_option'							=> 'homepage',
		'promotion_headline'								=> esc_html__( 'Full Frame is a Premium Responsive WordPress Theme', 'full-frame' ),
		'promotion_subheadline'								=> esc_html__( 'This is promotion headline. You can edit this from Appearance -> Customize -> Theme Options -> Promotion Headline Options', 'full-frame' ),
		'promotion_headline_button'							=> esc_html__( 'Reviews', 'full-frame' ),
		'promotion_headline_url'							=> esc_url( 'http://wordpress.org/support/view/theme-reviews/full-frame' ),
		'promotion_headline_target'							=> 1,

		//Search Options
		'search_text'										=> esc_html__( 'Search...', 'full-frame' ),

		//Basic Color Options
		'color_scheme' 										=> 'light',

		//Featured Content Options
		'featured_content_option'							=> 'homepage',
		'featured_content_layout'							=> 'layout-three',
		'featured_content_slider'							=> 0,
		'featured_content_position'							=> 0,
		'featured_content_headline'							=> '',
		'featured_content_subheadline'						=> '',
		'featured_content_type'								=> 'demo-featured-content',
		'featured_content_enable_title'						=> 1,
		'featured_content_enable_excerpt_content'			=> 0,
		'featured_content_number'							=> '4',

		'featured_content_background_image'					=> get_template_directory_uri() . '/images/default-featured-bg.jpg',

		//Featured Slider Options
		'featured_slider_option'							=> 'homepage',
		'featured_slider_image_loader'						=> 'true',
		'featured_slide_transition_effect'					=> 'fadeout',
		'featured_slide_transition_delay'					=> '4',
		'featured_slide_transition_length'					=> '1',
		'featured_slider_type'								=> 'demo-featured-slider',
		'featured_slide_number'								=> '4',

		//Reset all settings
		'reset_all_settings'								=> 0,
	);

	return apply_filters( 'fullframe_default_theme_options', $default_theme_options );
}


/**
 * Returns an array of color schemes registered for fullframe.
 *
 * @since Fullframe 1.0
 */
function fullframe_color_schemes() {
	$color_scheme_options = array(
		'light' => array(
			'value' 				=> 'light',
			'label' 				=> esc_html__( 'Light', 'full-frame' ),
		),
		'dark' => array(
			'value' 				=> 'dark',
			'label' 				=> esc_html__( 'Dark', 'full-frame' ),
		),
	);

	return apply_filters( 'fullframe_color_schemes', $color_scheme_options );
}


/**
 * Returns an array of layout options registered for fullframe.
 *
 * @since Fullframe 1.0
 */
function fullframe_layouts() {
	$layout_options = array(
		'left-sidebar' 	=> array(
			'value' => 'left-sidebar',
			'label' => esc_html__( 'Primary Sidebar, Content', 'full-frame' ),
		),
		'right-sidebar' => array(
			'value' => 'right-sidebar',
			'label' => esc_html__( 'Content, Primary Sidebar', 'full-frame' ),
		),
		'no-sidebar'	=> array(
			'value' => 'no-sidebar',
			'label' => esc_html__( 'No Sidebar ( Content Width )', 'full-frame' ),
		),
	);
	return apply_filters( 'fullframe_layouts', $layout_options );
}


/**
 * Returns an array of content layout options registered for fullframe.
 *
 * @since Fullframe 1.0
 */
function fullframe_get_archive_content_layout() {
	$layout_options = array(
		'excerpt-featured-image' => array(
			'value' => 'excerpt-featured-image',
			'label' => esc_html__( 'Show Excerpt', 'full-frame' ),
		),
		'full-content' => array(
			'value' => 'full-content',
			'label' => esc_html__( 'Show Full Content (No Featured Image)', 'full-frame' ),
		),
	);

	return apply_filters( 'fullframe_get_archive_content_layout', $layout_options );
}


/**
 * Returns an array of feature header enable options
 *
 * @since Fullframe 1.0
 */
function fullframe_enable_featured_header_image_options() {
	$enable_featured_header_image_options = array(
		'homepage' 		=> array(
			'value'	=> 'homepage',
			'label' => esc_html__( 'Homepage / Frontpage', 'full-frame' ),
		),
		'exclude-home' 		=> array(
			'value'	=> 'exclude-home',
			'label' => esc_html__( 'Excluding Homepage', 'full-frame' ),
		),
		'exclude-home-page-post' 	=> array(
			'value' => 'exclude-home-page-post',
			'label' => esc_html__( 'Excluding Homepage, Page/Post Featured Image', 'full-frame' ),
		),
		'entire-site' 	=> array(
			'value' => 'entire-site',
			'label' => esc_html__( 'Entire Site', 'full-frame' ),
		),
		'entire-site-page-post' 	=> array(
			'value' => 'entire-site-page-post',
			'label' => esc_html__( 'Entire Site, Page/Post Featured Image', 'full-frame' ),
		),
		'pages-posts' 	=> array(
			'value' => 'pages-posts',
			'label' => esc_html__( 'Pages and Posts', 'full-frame' ),
		),
		'disabled'		=> array(
			'value' => 'disabled',
			'label' => esc_html__( 'Disabled', 'full-frame' ),
		),
	);

	return apply_filters( 'fullframe_enable_featured_header_image_options', $enable_featured_header_image_options );
}


/**
 * Returns an array of feature image size
 *
 * @since Fullframe 1.0
 */
function fullframe_featured_image_size_options() {
	$featured_image_size_options = array(
		'full' 		=> array(
			'value'	=> 'full',
			'label' => esc_html__( 'Full Image', 'full-frame' ),
		),
		'large' 	=> array(
			'value' => 'large',
			'label' => esc_html__( 'Large Image', 'full-frame' ),
		),
		'slider'		=> array(
			'value' => 'slider',
			'label' => esc_html__( 'Slider Image', 'full-frame' ),
		),
	);

	return apply_filters( 'fullframe_featured_image_size_options', $featured_image_size_options );
}


/**
 * Returns an array of content and slider layout options registered for fullframe.
 *
 * @since Fullframe 1.0
 */
function fullframe_featured_slider_content_options() {
	$featured_slider_content_options = array(
		'homepage' 		=> array(
			'value'	=> 'homepage',
			'label' => esc_html__( 'Homepage / Frontpage', 'full-frame' ),
		),
		'entire-site' 	=> array(
			'value' => 'entire-site',
			'label' => esc_html__( 'Entire Site', 'full-frame' ),
		),
		'disabled'		=> array(
			'value' => 'disabled',
			'label' => esc_html__( 'Disabled', 'full-frame' ),
		),
	);

	return apply_filters( 'fullframe_featured_slider_content_options', $featured_slider_content_options );
}


/**
 * Returns an array of feature content types registered for fullframe.
 *
 * @since Fullframe 1.0
 */
function fullframe_featured_content_types() {
	$featured_content_types = array(
		'demo-featured-content' => array(
			'value' => 'demo-featured-content',
			'label' => esc_html__( 'Demo Featured Content', 'full-frame' ),
		),
		'featured-page-content' => array(
			'value' => 'featured-page-content',
			'label' => esc_html__( 'Featured Page Content', 'full-frame' ),
		)
	);

	return apply_filters( 'fullframe_featured_content_types', $featured_content_types );
}


/**
 * Returns an array of featured content options registered for fullframe.
 *
 * @since Fullframe 1.0
 */
function fullframe_featured_content_layout_options() {
	$featured_content_layout_option = array(
		'layout-three' 		=> array(
			'value'	=> 'layout-three',
			'label' => esc_html__( '3 columns', 'full-frame' ),
		),
		'layout-four' 	=> array(
			'value' => 'layout-four',
			'label' => esc_html__( '4 columns', 'full-frame' ),
		),
	);

	return apply_filters( 'fullframe_featured_content_layout_options', $featured_content_layout_option );
}

/**
 * Returns an array of featured content show registered for fullframe.
 *
 * @since Fullframe 1.6
 */
function fullframe_featured_content_show() {
	$featured_content_show_option = array(
		'excerpt' 		=> array(
			'value'	=> '1',
			'label' => esc_html__( 'Show Excerpt', 'full-frame' ),
		),
		'full-content' 	=> array(
			'value' => '2',
			'label' => esc_html__( 'Show Full Content', 'full-frame' ),
		),
		'hide-content' 	=> array(
			'value' => '0',
			'label' => esc_html__( 'Hide Content', 'full-frame' ),
		),
	);

	return apply_filters( 'fullframe_featured_content_show', $featured_content_show_option );
}


/**
 * Returns an array of feature slider types registered for fullframe.
 *
 * @since Fullframe 1.0
 */
function fullframe_featured_slider_types() {
	$featured_slider_types = array(
		'demo-featured-slider' => array(
			'value' => 'demo-featured-slider',
			'label' => esc_html__( 'Demo Featured Slider', 'full-frame' ),
		),
		'featured-page-slider' => array(
			'value' => 'featured-page-slider',
			'label' => esc_html__( 'Featured Page Slider', 'full-frame' ),
		),
	);

	return apply_filters( 'fullframe_featured_slider_types', $featured_slider_types );
}


/**
 * Returns an array of feature slider transition effects
 *
 * @since Fullframe 1.0
 */
function fullframe_featured_slide_transition_effects() {
	$featured_slide_transition_effects = array(
		'fade' 		=> array(
			'value'	=> 'fade',
			'label' => esc_html__( 'Fade', 'full-frame' ),
		),
		'fadeout' 	=> array(
			'value'	=> 'fadeout',
			'label' => esc_html__( 'Fade Out', 'full-frame' ),
		),
		'none' 		=> array(
			'value' => 'none',
			'label' => esc_html__( 'None', 'full-frame' ),
		),
		'scrollHorz'=> array(
			'value' => 'scrollHorz',
			'label' => esc_html__( 'Scroll Horizontal', 'full-frame' ),
		),
		'scrollVert'=> array(
			'value' => 'scrollVert',
			'label' => esc_html__( 'Scroll Vertical', 'full-frame' ),
		),
		'flipHorz'	=> array(
			'value' => 'flipHorz',
			'label' => esc_html__( 'Flip Horizontal', 'full-frame' ),
		),
		'flipVert'	=> array(
			'value' => 'flipVert',
			'label' => esc_html__( 'Flip Vertical', 'full-frame' ),
		),
		'tileSlide'	=> array(
			'value' => 'tileSlide',
			'label' => esc_html__( 'Tile Slide', 'full-frame' ),
		),
		'tileBlind'	=> array(
			'value' => 'tileBlind',
			'label' => esc_html__( 'Tile Blind', 'full-frame' ),
		),
		'shuffle'	=> array(
			'value' => 'shuffle',
			'label' => esc_html__( 'Shuffle', 'full-frame' ),
		)
	);

	return apply_filters( 'fullframe_featured_slide_transition_effects', $featured_slide_transition_effects );
}


/**
 * Returns an array of featured slider image loader options
 *
 * @since Full Frame 2.3
 */
function fullframe_featured_slider_image_loader() {
	$color_scheme_options = array(
		'true' => array(
			'value' 				=> 'true',
			'label' 				=> esc_html__( 'True', 'full-frame' ),
		),
		'wait' => array(
			'value' 				=> 'wait',
			'label' 				=> esc_html__( 'Wait', 'full-frame' ),
		),
		'false' => array(
			'value' 				=> 'false',
			'label' 				=> esc_html__( 'False', 'full-frame' ),
		),
	);

	return apply_filters( 'fullframe_color_schemes', $color_scheme_options );
}


/**
 * Returns an array of color schemes registered for fullframe.
 *
 * @since Fullframe 1.0
 */
function fullframe_get_pagination_types() {
	$pagination_types = array(
		'default' => array(
			'value' => 'default',
			'label' => esc_html__( 'Default(Older Posts/Newer Posts)', 'full-frame' ),
		),
		'numeric' => array(
			'value' => 'numeric',
			'label' => esc_html__( 'Numeric', 'full-frame' ),
		),
		'infinite-scroll-click' => array(
			'value' => 'infinite-scroll-click',
			'label' => esc_html__( 'Infinite Scroll (Click)', 'full-frame' ),
		),
		'infinite-scroll-scroll' => array(
			'value' => 'infinite-scroll-scroll',
			'label' => esc_html__( 'Infinite Scroll (Scroll)', 'full-frame' ),
		),
	);

	return apply_filters( 'fullframe_get_pagination_types', $pagination_types );
}


/**
 * Returns an array of content featured image size.
 *
 * @since Full Frame 1.0
 */
function fullframe_single_post_image_layout_options() {
	$single_post_image_layout_options = array(
		'featured' => array(
			'value' => 'featured',
			'label' => esc_html__( 'Featured', 'full-frame' ),
		),
		'full-size' => array(
			'value' => 'full-size',
			'label' => esc_html__( 'Full Size', 'full-frame' ),
		),
		'disabled' => array(
			'value' => 'disabled',
			'label' => esc_html__( 'Disabled', 'full-frame' ),
		),
	);
	return apply_filters( 'fullframe_single_post_image_layout_options', $single_post_image_layout_options );
}


/**
 * Returns list of social icons currently supported
 *
 * @since Fullframe 1.0
*/
function fullframe_get_social_icons_list() {
	$fullframe_social_icons_list = array(
		'facebook_link'		=> array(
			'genericon_class' 	=> 'facebook-alt',
			'label' 			=> esc_html__( 'Facebook', 'full-frame' )
			),
		'twitter_link'		=> array(
			'genericon_class' 	=> 'twitter',
			'label' 			=> esc_html__( 'Twitter', 'full-frame' )
			),
		'googleplus_link'	=> array(
			'genericon_class' 	=> 'googleplus-alt',
			'label' 			=> esc_html__( 'Googleplus', 'full-frame' )
			),
		'email_link'		=> array(
			'genericon_class' 	=> 'mail',
			'label' 			=> esc_html__( 'Email', 'full-frame' )
			),
		'feed_link'			=> array(
			'genericon_class' 	=> 'feed',
			'label' 			=> esc_html__( 'Feed', 'full-frame' )
			),
		'wordpress_link'	=> array(
			'genericon_class' 	=> 'wordpress',
			'label' 			=> esc_html__( 'WordPress', 'full-frame' )
			),
		'github_link'		=> array(
			'genericon_class' 	=> 'github',
			'label' 			=> esc_html__( 'GitHub', 'full-frame' )
			),
		'linkedin_link'		=> array(
			'genericon_class' 	=> 'linkedin',
			'label' 			=> esc_html__( 'LinkedIn', 'full-frame' )
			),
		'pinterest_link'	=> array(
			'genericon_class' 	=> 'pinterest',
			'label' 			=> esc_html__( 'Pinterest', 'full-frame' )
			),
		'flickr_link'		=> array(
			'genericon_class' 	=> 'flickr',
			'label' 			=> esc_html__( 'Flickr', 'full-frame' )
			),
		'vimeo_link'		=> array(
			'genericon_class' 	=> 'vimeo',
			'label' 			=> esc_html__( 'Vimeo', 'full-frame' )
			),
		'youtube_link'		=> array(
			'genericon_class' 	=> 'youtube',
			'label' 			=> esc_html__( 'YouTube', 'full-frame' )
			),
		'tumblr_link'		=> array(
			'genericon_class' 	=> 'tumblr',
			'label' 			=> esc_html__( 'Tumblr', 'full-frame' )
			),
		'instagram_link'	=> array(
			'genericon_class' 	=> 'instagram',
			'label' 			=> esc_html__( 'Instagram', 'full-frame' )
			),
		'polldaddy_link'	=> array(
			'genericon_class' 	=> 'polldaddy',
			'label' 			=> esc_html__( 'PollDaddy', 'full-frame' )
			),
		'codepen_link'		=> array(
			'genericon_class' 	=> 'codepen',
			'label' 			=> esc_html__( 'CodePen', 'full-frame' )
			),
		'path_link'			=> array(
			'genericon_class' 	=> 'path',
			'label' 			=> esc_html__( 'Path', 'full-frame' )
			),
		'dribbble_link'		=> array(
			'genericon_class' 	=> 'dribbble',
			'label' 			=> esc_html__( 'Dribbble', 'full-frame' )
			),
		'skype_link'		=> array(
			'genericon_class' 	=> 'skype',
			'label' 			=> esc_html__( 'Skype', 'full-frame' )
			),
		'digg_link'			=> array(
			'genericon_class' 	=> 'digg',
			'label' 			=> esc_html__( 'Digg', 'full-frame' )
			),
		'reddit_link'		=> array(
			'genericon_class' 	=> 'reddit',
			'label' 			=> esc_html__( 'Reddit', 'full-frame' )
			),
		'stumbleupon_link'	=> array(
			'genericon_class' 	=> 'stumbleupon',
			'label' 			=> esc_html__( 'Stumbleupon', 'full-frame' )
			),
		'pocket_link'		=> array(
			'genericon_class' 	=> 'pocket',
			'label' 			=> esc_html__( 'Pocket', 'full-frame' ),
			),
		'dropbox_link'		=> array(
			'genericon_class' 	=> 'dropbox',
			'label' 			=> esc_html__( 'DropBox', 'full-frame' ),
			),
		'spotify_link'		=> array(
			'genericon_class' 	=> 'spotify',
			'label' 			=> esc_html__( 'Spotify', 'full-frame' ),
			),
		'foursquare_link'	=> array(
			'genericon_class' 	=> 'foursquare',
			'label' 			=> esc_html__( 'Foursquare', 'full-frame' ),
			),
		'twitch_link'		=> array(
			'genericon_class' 	=> 'twitch',
			'label' 			=> esc_html__( 'Twitch', 'full-frame' ),
			),
		'website_link'		=> array(
			'genericon_class' 	=> 'website',
			'label' 			=> esc_html__( 'Website', 'full-frame' ),
			),
		'phone_link'		=> array(
			'genericon_class' 	=> 'phone',
			'label' 			=> esc_html__( 'Phone', 'full-frame' ),
			),
		'handset_link'		=> array(
			'genericon_class' 	=> 'handset',
			'label' 			=> esc_html__( 'Handset', 'full-frame' ),
			),
		'cart_link'			=> array(
			'genericon_class' 	=> 'cart',
			'label' 			=> esc_html__( 'Cart', 'full-frame' ),
			),
		'cloud_link'		=> array(
			'genericon_class' 	=> 'cloud',
			'label' 			=> esc_html__( 'Cloud', 'full-frame' ),
			),
		'link_link'		=> array(
			'genericon_class' 	=> 'link',
			'label' 			=> esc_html__( 'Link', 'full-frame' ),
			),
	);

	return apply_filters( 'fullframe_social_icons_list', $fullframe_social_icons_list );
}


/**
 * Returns an array of metabox layout options registered for fullframe.
 *
 * @since Full Frame 1.0
 */
function fullframe_metabox_layouts() {
	$layout_options = array(
		'default' 	=> array(
			'id' 	=> 'fullframe-layout-option',
			'value' => 'default',
			'label' => esc_html__( 'Default', 'full-frame' ),
		),
		'left-sidebar' 	=> array(
			'id' 	=> 'fullframe-layout-option',
			'value' => 'left-sidebar',
			'label' => esc_html__( 'Primary Sidebar, Content', 'full-frame' ),
		),
		'right-sidebar' => array(
			'id' 	=> 'fullframe-layout-option',
			'value' => 'right-sidebar',
			'label' => esc_html__( 'Content, Primary Sidebar', 'full-frame' ),
		),
		'no-sidebar'	=> array(
			'id' 	=> 'fullframe-layout-option',
			'value' => 'no-sidebar',
			'label' => esc_html__( 'No Sidebar ( Content Width )', 'full-frame' ),
		)
	);
	return apply_filters( 'fullframe_layouts', $layout_options );
}

/**
 * Returns an array of metabox header featured image options registered for fullframe.
 *
 * @since Full Frame 1.0
 */
function fullframe_metabox_header_featured_image_options() {
	$header_featured_image_options = array(
		'default' => array(
			'id'		=> 'fullframe-header-image',
			'value' 	=> 'default',
			'label' 	=> esc_html__( 'Default', 'full-frame' ),
		),
		'enable' => array(
			'id'		=> 'fullframe-header-image',
			'value' 	=> 'enable',
			'label' 	=> esc_html__( 'Enable', 'full-frame' ),
		),
		'disable' => array(
			'id'		=> 'fullframe-header-image',
			'value' 	=> 'disable',
			'label' 	=> esc_html__( 'Disable', 'full-frame' )
		)
	);
	return apply_filters( 'header_featured_image_options', $header_featured_image_options );
}


/**
 * Returns an array of metabox featured image options registered for fullframe.
 *
 * @since Full Frame 1.0
 */
function fullframe_metabox_featured_image_options() {
	$featured_image_options = array(
		'default' => array(
			'id'		=> 'fullframe-featured-image',
			'value' 	=> 'default',
			'label' 	=> esc_html__( 'Default', 'full-frame' ),
		),
		'featured' => array(
			'id'		=> 'fullframe-featured-image',
			'value' 	=> 'featured',
			'label' 	=> esc_html__( 'Featured Image', 'full-frame' )
		),
		'full' => array(
			'id' => 'fullframe-featured-image',
			'value' => 'full',
			'label' => esc_html__( 'Full Size', 'full-frame' )
		),
		'disable' => array(
			'id' => 'fullframe-featured-image',
			'value' => 'disable',
			'label' => esc_html__( 'Disable Image', 'full-frame' )
		)
	);
	return apply_filters( 'featured_image_options', $featured_image_options );
}


/**
 * Returns fullframe_contents registered for fullframe.
 *
 * @since Fullframe 1.0
 */
function fullframe_get_content() {
	$theme_data = wp_get_theme();

	$fullframe_content['left'] 	= sprintf( _x( 'Copyright &copy; %1$s %2$s. All Rights Reserved.', '1: Year, 2: Site Title with home URL', 'full-frame' ), date( 'Y' ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' );

	$fullframe_content['right']	= esc_attr( $theme_data->get( 'Name') ) . '&nbsp;' . esc_html__( 'by', 'full-frame' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_attr( $theme_data->get( 'Author' ) ) .'</a>';

	return apply_filters( 'fullframe_get_content', $fullframe_content );
}