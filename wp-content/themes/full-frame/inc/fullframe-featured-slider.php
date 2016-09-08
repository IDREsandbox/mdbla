<?php
/**
 * The template for displaying the Slider
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


if( !function_exists( 'fullframe_featured_slider' ) ) :
/**
 * Add slider.
 *
 * @uses action hook fullframe_before_content.
 *
 * @since Fullframe 1.0
 */
function fullframe_featured_slider() {
	global $post, $wp_query;
	//fullframe_flush_transients();
	// get data value from options
	$options 		= fullframe_get_theme_options();
	$enableslider 	= $options['featured_slider_option'];
	$sliderselect 	= $options['featured_slider_type'];
	$imageloader	= isset ( $options['featured_slider_image_loader'] ) ? $options['featured_slider_image_loader'] : 'true';

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');

	if ( $enableslider == 'entire-site' || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && $enableslider == 'homepage' ) ) {
		if( ( !$fullframe_featured_slider = get_transient( 'fullframe_featured_slider' ) ) ) {
			echo '<!-- refreshing cache -->';

			$fullframe_featured_slider = '
				<section id="feature-slider">
					<div class="wrapper">
						<div class="cycle-slideshow"
						    data-cycle-log="false"
						    data-cycle-pause-on-hover="true"
						    data-cycle-swipe="true"
						    data-cycle-auto-height=container
						     data-cycle-fx="'. esc_attr( $options['featured_slide_transition_effect'] ) .'"
							data-cycle-speed="'. esc_attr( $options['featured_slide_transition_length'] ) * 1000 .'"
							data-cycle-timeout="'. esc_attr( $options['featured_slide_transition_delay'] ) * 1000 .'"
							data-cycle-loader="'. esc_attr( $imageloader ) .'"
							data-cycle-slides="> article"
							>

						    <!-- prev/next links -->
						    <div class="cycle-prev"></div>
						    <div class="cycle-next"></div>

						    <!-- empty element for pager links -->
	    					<div class="cycle-pager"></div>';

							// Select Slider
							if ( $sliderselect == 'demo-featured-slider' && function_exists( 'fullframe_demo_slider' ) ) {
								$fullframe_featured_slider .=  fullframe_demo_slider( $options );
							}
							elseif ( $sliderselect == 'featured-page-slider' && function_exists( 'fullframe_page_slider' ) ) {
								$fullframe_featured_slider .=  fullframe_page_slider( $options );
							}

			$fullframe_featured_slider .= '
						</div><!-- .cycle-slideshow -->
					</div><!-- .wrapper -->
				</section><!-- #feature-slider -->';

			set_transient( 'fullframe_featured_slider', $fullframe_featured_slider, 86940 );
		}
		echo $fullframe_featured_slider;
	}
}
endif;
add_action( 'fullframe_before_content', 'fullframe_featured_slider', 10 );


if ( ! function_exists( 'fullframe_demo_slider' ) ) :
/**
 * This function to display featured posts slider
 *
 * @get the data value from customizer options
 *
 * @since Fullframe 1.0
 *
 */
function fullframe_demo_slider( $options ) {
	$fullframe_demo_slider ='
								<article class="post hentry slides demo-image displayblock">
									<figure class="slider-image">
										<a title="Slider Image 1" href="'. esc_url( home_url( '/' ) ) .'">
											<img src="'.get_template_directory_uri().'/images/gallery/slider1-1680x720.jpg" class="wp-post-image" alt="Slider Image 1" title="Slider Image 1">
										</a>
									</figure>
									<div class="entry-container">
										<header class="entry-header">
											<h1 class="entry-title">
												<a title="Slider Image 1" href="#"><span>Slider Image 1</span></a>
											</h1>
											</header>
										<div class="entry-content">
											<p>Slider Image 1 Content</p>
										</div>
									</div>
								</article><!-- .slides -->

								<article class="post hentry slides demo-image displaynone">
									<figure class="Slider Image 2">
										<a title="Slider Image 2" href="'. esc_url( home_url( '/' ) ) .'">
											<img src="'. get_template_directory_uri() . '/images/gallery/slider2-1680x720.jpg" class="wp-post-image" alt="Slider Image 2" title="Slider Image 2">
										</a>
									</figure>
									<div class="entry-container">
										<header class="entry-header">
											<h1 class="entry-title">
												<a title="Slider Image 2" href="#"><span>Slider Image 2</span></a>
											</h1>
											</header>
										<div class="entry-content">
											<p>Slider Image 2 Content</p>
										</div>
									</div>
								</article><!-- .slides --> ';
	return $fullframe_demo_slider;
}
endif; // fullframe_demo_slider


if ( ! function_exists( 'fullframe_page_slider' ) ) :
/**
 * This function to display featured page slider
 *
 * @param $options: fullframe_theme_options from customizer
 *
 * @since Fullframe 1.0
 */
function fullframe_page_slider( $options ) {
	$quantity		= $options['featured_slide_number'];
	$more_link_text	=	$options['excerpt_more_text'];

    global $post;

    $fullframe_page_slider = '';
    $number_of_page 		= 0; 		// for number of pages
	$page_list				= array();	// list of valid page ids

	//Get number of valid pages
	for( $i = 1; $i <= $quantity; $i++ ){
		if( isset ( $options['featured_slider_page_' . $i] ) && $options['featured_slider_page_' . $i] > 0 ){
			$number_of_page++;

			$page_list	=	array_merge( $page_list, array( $options['featured_slider_page_' . $i] ) );
		}

	}

	if ( !empty( $page_list ) && $number_of_page > 0 ) {
		$get_featured_posts = new WP_Query( array(
			'posts_per_page'	=> $quantity,
			'post_type'			=> 'page',
			'post__in'			=> $page_list,
			'orderby' 			=> 'post__in'
		));
		$i=0;

		while ( $get_featured_posts->have_posts()) : $get_featured_posts->the_post(); $i++;
			$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
			$excerpt = get_the_excerpt();
			if ( $i == 1 ) { $classes = 'page pageid-'.$post->ID.' hentry slides displayblock'; } else { $classes = 'page pageid-'.$post->ID.' hentry slides displaynone'; }
			$fullframe_page_slider .= '
			<article class="'.$classes.'">
				<figure class="slider-image">';
				if ( has_post_thumbnail() ) {
					$fullframe_page_slider .= '<a title="' . the_title_attribute( array( 'before' => esc_html__( 'Permalink to:', 'full-frame' ), 'echo' => false ) ) . '" href="' . get_permalink() . '">
						'. get_the_post_thumbnail( $post->ID, 'fullframe_slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class'	=> 'pngfix' ) ).'
					</a>';
				}
				else {
					//Default value if there is no first image
					$fullframe_image = '<img class="pngfix wp-post-image" src="'.get_template_directory_uri().'/images/gallery/no-featured-image-1680x720.jpg" >';

					//Get the first image in page, returns false if there is no image
					$fullframe_first_image = fullframe_get_first_image( $post->ID, 'fullframe-slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class' => 'pngfix' ) );

					//Set value of image as first image if there is an image present in the page
					if ( '' != $fullframe_first_image ) {
						$fullframe_image =	$fullframe_first_image;
					}

					$fullframe_page_slider .= '<a title="' . the_title_attribute( array( 'before' => esc_html__( 'Permalink to:', 'full-frame' ), 'echo' => false ) ) . '" href="' . get_permalink() . '">
						'. $fullframe_image .'
					</a>';
				}

				$fullframe_page_slider .= '
				</figure><!-- .slider-image -->
				<div class="entry-container">
					<header class="entry-header">
						<h1 class="entry-title">
							<a title="' . the_title_attribute( array( 'before' => esc_html__( 'Permalink to:', 'full-frame' ), 'echo' => false ) ) . '" href="' . get_permalink() . '">'.the_title( '<span>','</span>', false ).'</a>
						</h1>
						<div class="assistive-text">'.fullframe_page_post_meta().'</div>
					</header>';
					if( $excerpt !='') {
						$fullframe_page_slider .= '<div class="entry-content">'. $excerpt.'</div>';
					}
					$fullframe_page_slider .= '
				</div><!-- .entry-container -->
			</article><!-- .slides -->';
		endwhile;

		wp_reset_query();
  	}
	return $fullframe_page_slider;
}
endif; // fullframe_page_slider