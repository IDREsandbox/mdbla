<?php
/**
 * The Template for displaying all single posts
 *
 * @package Catch Themes
 * @subpackage Full Frame
 * @since Full Frame 1.0 

   Template Name: MDBLA Full Width Intro
*/

get_header(); ?>

	<main id="intro" class="site-intro" role="intro">
	<script>

		jQuery( document ).ready(function() {
		    jQuery('.entry-header').hide();
			jQuery('#iframe').height(jQuery(window).height()-123);
		});

		jQuery( window ).resize(function() {
			jQuery('#iframe').height(jQuery(window).height()-123);			
		});

	</script>
	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'single' ); ?>

	<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>