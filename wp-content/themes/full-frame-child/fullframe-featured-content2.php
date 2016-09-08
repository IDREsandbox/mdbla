<?php
/**
 * The template for displaying the Featured Content
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


if( !function_exists( 'fullframe_featured_content_display' ) ) :
/**
* Add Featured content.
*
* @uses action hook fullframe_before_content.
*
* @since Fullframe 1.0
*/
function fullframe_featured_content_display() {
	//fullframe_flush_transients();

	global $post, $wp_query;

	// get data value from options
	$options 		= fullframe_get_theme_options();
	$enablecontent 	= $options['featured_content_option'];
	$contentselect 	= $options['featured_content_type'];
	$sliderselect	= $options['featured_content_slider'];

	// Front page displays in Reading Settings
	$page_on_front 	= get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');


	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	if ( $enablecontent == 'entire-site' || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && $enablecontent == 'homepage' ) ) {
		if( ( !$fullframe_featured_content = get_transient( 'fullframe_featured_content_display' ) ) ) {
			$layouts 	 = $options ['featured_content_layout'];
			$headline 	 = $options ['featured_content_headline'];
			$subheadline = $options ['featured_content_subheadline'];

			echo '<!-- refreshing cache -->';

			if ( !empty( $layouts ) ) {
				$classes = $layouts ;
			}

			if( $contentselect == 'demo-featured-content' ) {
				$classes 		.= ' demo-featured-content' ;
				$headline 		= esc_html__( 'Featured Content', 'full-frame' );
				$subheadline 	= esc_html__( 'Here you can showcase the x number of Featured Content. You can edit this Headline, Subheadline and Feaured Content from "Appearance -> Customize -> Featured Content Options".', 'full-frame' );
			}
			elseif ( $contentselect == 'featured-page-content' ) {
				$classes .= ' featured-page-content' ;
			}

			//Check Featured Content Position
			if ( isset( $options [ 'featured_content_position' ] ) ) {
				$featured_content_position = $options [ 'featured_content_position' ];
			}
			// Providing Backward Compatible with Version 1.0
			else {
				$featured_content_position =  $options [ 'move_posts_home' ];
			}

			if ( '1' == $featured_content_position ) {
				$classes .= ' border-top' ;
			}

			$fullframe_featured_content ='
				<section id="featured-content" class="' . $classes . '">
					<div class="intro-wrapper">';
						if ( !empty( $headline ) || !empty( $subheadline ) ) {
							$fullframe_featured_content .='<div class="featured-heading-wrap">';
								if ( !empty( $headline ) ) {
									$fullframe_featured_content .='<h1 id="featured-heading" class="entry-title">'. $headline .'</h1>';
								}
								if ( !empty( $subheadline ) ) {
									$fullframe_featured_content .='<p>'. $subheadline .'</p>';
								}
							$fullframe_featured_content .='</div><!-- .featured-heading-wrap -->';
						}
						$fullframe_featured_content .='
						<div class="featured-content-wrap">';
							if ( $sliderselect ) {
								$fullframe_featured_content .='
								<!-- prev/next links -->
								<div id="content-controls">
									<div id="content-prev"></div>
									<div id="content-next"></div>
								</div>
								<div class="cycle-slideshow"
								    data-cycle-log="false"
								    data-cycle-pause-on-hover="true"
								    data-cycle-swipe="true"
								    data-cycle-auto-height=container
									data-cycle-slides=".featured_content_slider_wrap"
									data-cycle-fx="scrollHorz"
									data-cycle-prev="#content-prev"
        							data-cycle-next="#content-next"
									>';
							 }

								// Select content
								if ( $contentselect == 'demo-featured-content'  && function_exists( 'fullframe_demo_content' ) ) {
									$fullframe_featured_content .= fullframe_demo_content( $options );
								}
								elseif ( $contentselect == 'featured-page-content' && function_exists( 'fullframe_page_content' ) ) {
									$fullframe_featured_content .= fullframe_page_content( $options );
								}

							if ( $sliderselect ) {
								$fullframe_featured_content .='
								</div><!-- .cycle-slideshow -->';
							}

				$fullframe_featured_content .='
						</div><!-- .featured-content-wrap -->
					</div><!-- .wrapper -->
				</section><!-- #featured-content -->';

		set_transient( 'fullframe_featured_content', $fullframe_featured_content, 86940 );
		}
	echo $fullframe_featured_content;
	}
}
endif;


if ( ! function_exists( 'fullframe_featured_content_display_position' ) ) :
/**
 * Homepage Featured Content Position
 *
 * @action fullframe_content, fullframe_after_secondary
 *
 * @since Fullframe 1.0
 */
function fullframe_featured_content_display_position() {
	// Getting data from Theme Options
	$options 		= fullframe_get_theme_options();

	//Check Featured Content Position
	if ( isset( $options [ 'featured_content_position' ] ) ) {
		$featured_content_position = $options [ 'featured_content_position' ];
	}
	// Providing Backward Compatible with Version 1.0
	else {
		$featured_content_position =  $options [ 'move_posts_home' ];
	}

	if ( '1' != $featured_content_position ) {
		add_action( 'fullframe_before_content', 'fullframe_featured_content_display', 50 );
	} else {
		add_action( 'fullframe_after_content', 'fullframe_featured_content_display', 40 );
	}

}
endif; // fullframe_featured_content_display_position
add_action( 'fullframe_before', 'fullframe_featured_content_display_position' );


if ( ! function_exists( 'fullframe_demo_content' ) ) :
/**
 * This function to display featured posts content
 *
 * @get the data value from customizer options
 *
 * @since Fullframe 1.0
 *
 */
function fullframe_demo_content( $options ) {
	$fullframe_demo_content = '
	<div class="featured_content_slider_wrap">
		<article id="featured-post-1" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Central Park" class="wp-post-image" src="'.get_template_directory_uri() . '/images/gallery/featured1-400x225.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h1 class="entry-title">
						<a href="#" rel="bookmark">Central Park</a>
					</h1>
				</header>
				<div class="entry-content">
					Central Park is is the most visited urban park in the United States as well as one of the most filmed locations in the world. It was opened in 1857 and is expanded in 843 acres of city-owned land.
				</div>
			</div><!-- .entry-container -->
		</article>

		<article id="featured-post-2" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Antique Clock" class="wp-post-image" src="'.get_template_directory_uri() . '/images/gallery/featured2-400x225.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h1 class="entry-title">
						<a href="#" rel="bookmark">Antique Clock</a>
					</h1>
				</header>
				<div class="entry-content">
					Antique clocks increase in value with the rarity of the design, their condition, and appeal in the market place. Many different materials were used in antique clocks.
				</div>
			</div><!-- .entry-container -->
		</article>

		<article id="featured-post-3" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Vespa Scooter" class="wp-post-image" src="'.get_template_directory_uri() . '/images/gallery/featured3-400x225.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h1 class="entry-title">
						<a href="#" rel="bookmark">Vespa Scooter</a>
					</h1>
				</header>
				<div class="entry-content">
					The Vespa has evolved from a single model motor scooter manufactured in 1946 by Piaggio & Co. S.p.A. of Pontedera, Italy-to a full line of scooters, today owned by Piaggio.
				</div>
			</div><!-- .entry-container -->
		</article>';

	if( 'layout-four' == $options ['featured_content_layout']) {
		$fullframe_demo_content .= '
		<article id="featured-post-4" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Dhulikhel" class="wp-post-image" src="'.get_template_directory_uri() . '/images/gallery/featured4-400x225.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h1 class="entry-title">
						<a href="#" rel="bookmark">Dhulikhel</a>
					</h1>
				</header>
			</div><!-- .entry-container -->
		</article>';
	}
	$fullframe_demo_content .= '</div><!-- .featured_content_slider_wrap -->';

	return $fullframe_demo_content;
}
endif; // fullframe_demo_content


if ( ! function_exists( 'fullframe_page_content' ) ) :
/**
 * This function to display featured page content
 *
 * @param $options: fullframe_theme_options from customizer
 *
 * @since Full Frame 1.0
 */
function fullframe_page_content( $options ) {
	global $post;

	$quantity 					= $options [ 'featured_content_number' ];

	$more_link_text				= $options['excerpt_more_text'];

	$fullframe_page_content 	= '';

   	$number_of_page 			= 0; 		// for number of pages

	$page_list					= array();	// list of valid pages ids

	if( 'layout-four' == $options ['featured_content_layout']) {
		$layouts = 4;
	}
	else{
		$layouts = 3;
	}

	//Get valid pages
	for( $i = 1; $i <= $quantity; $i++ ){
		if( isset ( $options['featured_content_page_' . $i] ) && $options['featured_content_page_' . $i] > 0 ){
			$number_of_page++;

			$page_list	=	array_merge( $page_list, array( $options['featured_content_page_' . $i] ) );
		}

	}
	if ( !empty( $page_list ) && $number_of_page > 0 ) {
		$get_featured_posts = new WP_Query( array(
                    'posts_per_page' 		=> $number_of_page,
                    'post__in'       		=> $page_list,
                    'orderby'        		=> 'post__in',
                    'post_type'				=> 'page',
                ));

		$i=0;

		$fullframe_page_content = '
		<div class="featured_content_slider_wrap">';

		while ( $get_featured_posts->have_posts()) :
			$get_featured_posts->the_post();

			$i++;

			$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );

			$excerpt = get_the_excerpt();

			$fullframe_page_content .= '
				<article id="featured-post-' . $i . '" class="post hentry featured-page-content">';
				if ( has_post_thumbnail() ) {
					$fullframe_page_content .= '
					<figure class="featured-homepage-image">
						<a href="' . get_permalink() . '" title="' . the_title_attribute( array( 'before' => esc_html__( 'Permalink to:', 'full-frame' ), 'echo' => false ) ). '">
						'. get_the_post_thumbnail( $post->ID, 'fullframe-featured-content', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class' => 'pngfix' ) ) .'
						</a>
					</figure>';
				}
				else {
					//Default value if there is no first image
					$fullframe_image = '<img class="pngfix wp-post-image" src="'.get_template_directory_uri().'/images/gallery/no-featured-image-1680x720.jpg" >';

					//Get the first image in page, returns false if there is no image
					$fullframe_first_image = fullframe_get_first_image( $post->ID, 'fullframe-featured-content', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class' => 'pngfix' ) );

					//Set value of image as first image if there is an image present in the page
					if ( '' != $fullframe_first_image ) {
						$fullframe_image =	$fullframe_first_image;
					}

					$fullframe_page_content .= '<a title="' . the_title_attribute( array( 'before' => esc_html__( 'Permalink to:', 'full-frame' ), 'echo' => false ) ) . '" href="' . get_permalink() . '">
						'. $fullframe_image .'
					</a>';
				}

				if ( '1' == $options['featured_content_enable_title'] || '0'!= $options['featured_content_enable_excerpt_content'] ) {
				$fullframe_page_content .= '
					<div class="entry-container">';
					if ( '1' == $options['featured_content_enable_title'] ) {
						$fullframe_page_content .= '
							<header class="entry-header">
								<h1 class="entry-title">
									<a href="' . get_permalink() . '" rel="bookmark">' . the_title( '','', false ) . '</a>
								</h1>
							</header>';
					}
					if ( '1' == $options['featured_content_enable_excerpt_content'] ) {
						//Show Excerpt
						$fullframe_page_content .= '<div class="entry-excerpt"><p>' . $excerpt . '</p></div><!-- .entry-excerpt -->';
					}
					elseif ( '2' == $options['featured_content_enable_excerpt_content'] ) {
						//Show Content
						$content = apply_filters( 'the_content', get_the_content() );
						$content = str_replace( ']]>', ']]&gt;', $content );
						$fullframe_page_content .= '<div class="entry-content">' . $content . '</div><!-- .entry-content -->';
					}
				}
				$fullframe_page_content .= '
				</article><!-- .featured-page-'. $i .' -->';

				if ( 0 == ( $i % $layouts ) && $i < $number_of_page ) {
					//end and start featured_content_slider_wrap div based on logic
					$fullframe_page_content .= '
				</div><!-- .featured_content_slider_wrap -->

				<div class="featured_content_slider_wrap">';
				}
		endwhile;

		wp_reset_query();

		$fullframe_page_content .= '</div><!-- .featured_content_slider_wrap -->';
	}

	return $fullframe_page_content;
}
endif; // fullframe_page_content