<?php
/**
 * The Template for displaying all single posts
 *
 * @package Catch Themes
 * @subpackage Full Frame
 * @since Full Frame 1.0 
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'single' ); ?>

		<?php 
			/** 
			 * fullframe_after_post hook
			 *
			 * @hooked fullframe_post_navigation - 10
			 */
			do_action( 'fullframe_after_post' ); 
			
			/** 
			 * fullframe_comment_section hook
			 *
			 * @hooked fullframe_get_comment_section - 10
			 */
			do_action( 'fullframe_comment_section' ); 
		?>
	<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>