<?php
/**
 * The template for displaying the footer
 *
 * @package Catch Themes
 * @subpackage Full Frame
 * @since Full Frame 1.0 
 */
?>

<?php 
    /** 
     * fullframe_after_content hook
     *
     * @hooked fullframe_content_end - 30
     * @hooked fullframe_featured_content_display (move featured content below homepage posts) - 40 
     *
     */
    do_action( 'fullframe_after_content' ); 
?>
            
<?php                
    /** 
     * fullframe_footer hook
     *
     * @hooked fullframe_footer_content_start - 30
     * @hooked fullframe_footer_sidebar - 40
     * @hooked fullframe_get_footer_content - 100
     * @hooked fullframe_footer_content_end - 110
     * @hooked fullframe_page_end - 200
     *
     */
    do_action( 'fullframe_footer' );
?>

<?php               
/** 
 * fullframe_after hook
 *
 * @hooked fullframe_scrollup - 10
 * @hooked fullframe_mobile_menus- 20
 *
 */
do_action( 'fullframe_after' );?>

<?php wp_footer(); ?>

</body>
</html>