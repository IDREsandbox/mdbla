<?php
/**
 * The template for displaying custom menus
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


if ( ! function_exists( 'fullframe_primary_menu' ) ) :
/**
 * Shows the Primary Menu
 */
function fullframe_primary_menu() {
    $options    = fullframe_get_theme_options();
    ?>
	<nav class="nav-primary search-enabled" role="navigation">
        <div class="wrapper">
            <h1 class="assistive-text"><?php esc_html_e( 'Primary Menu', 'full-frame' ); ?></h1>
            <div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'full-frame' ); ?>"><?php esc_html_e( 'Skip to content', 'full-frame' ); ?></a></div>

            <?php // Header Left Mobile Menu Anchor
            if ( has_nav_menu( 'primary' ) ) {
                $classes = "mobile-menu-anchor primary-menu";
            }
            else {
                $classes = "mobile-menu-anchor page-menu";
            }
            ?>
            <div id="mobile-header-left-menu" class="<?php echo $classes; ?>">
                <a href="#mobile-header-left-nav" id="header-left-menu" class="genericon genericon-menu">
                    <span class="mobile-menu-text"><?php esc_html_e( 'Menu', 'full-frame' );?></span>
                </a>
            </div><!-- #mobile-header-menu -->

            <?php

                $logo_alt = ( '' != $options['logo_alt_text'] ) ? $options['logo_alt_text'] : get_bloginfo( 'name', 'display' );

                if ( isset( $options[ 'logo_icon' ] ) &&  $options[ 'logo_icon' ] != '' &&  !empty( $options[ 'logo_icon' ] ) ){
                     echo '<div id="logo-icon"><a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">
                        <img src="' . esc_url( $options['logo_icon'] ) . '" alt="' . esc_attr(  $logo_alt ) . '">
                    </a></div>';
                }

                if ( has_nav_menu( 'primary' ) ) {
                    $fullframe_primary_menu_args = array(
                        'theme_location'    => 'primary',
                        'menu_class'        => 'menu fullframe-nav-menu',
                        'container'         => false
                    );
                    wp_nav_menu( $fullframe_primary_menu_args );
                }
                else {
                    wp_page_menu( array( 'menu_class'  => 'menu fullframe-nav-menu' ) );
                }

                ?>
                <div id="header-toggle" class="genericon">
                    <a class="screen-reader-text" href="#header-container"><?php esc_html_e( 'Header Toggle', 'full-frame' ); ?></a>
                </div>
    	</div><!-- .wrapper -->
    </nav><!-- .nav-primary -->
    <?php
}
endif; //fullframe_primary_menu
add_action( 'fullframe_header', 'fullframe_primary_menu', 30 );


if ( ! function_exists( 'fullframe_mobile_menus' ) ) :
/**
 * This function loads Mobile Menus
 *
 * @uses fullframe_after action to add the code in the footer
 */
function fullframe_mobile_menus() {
    //For primary menu, check if primary menu exists, if not, page menu
    echo '<nav id="mobile-header-left-nav" class="mobile-menu" role="navigation">';
        if ( has_nav_menu( 'primary' ) ) {
            $args = array(
                'theme_location'    => 'primary',
                'container'         => false,
                'items_wrap'        => '<ul id="header-left-nav" class="menu">%3$s</ul>'
            );
            wp_nav_menu( $args );
        }
        else {
            wp_page_menu( array( 'menu_class'  => 'menu' ) );
        }
    echo '</nav><!-- #mobile-header-left-nav -->';
}
endif; //fullframe_mobile_menus

add_action( 'fullframe_after', 'fullframe_mobile_menus', 20 );