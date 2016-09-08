<?php
/**
 * The template for adding Custom Sidebars and Widgets
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
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Fullframe 1.0
 */
function fullframe_widgets_init() {
	//Primary Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'full-frame' ),
		'id'            => 'primary-sidebar',
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
		'after_widget'  => '</div><!-- .widget-wrap --></section><!-- #widget-default-search -->',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
		'description'	=> esc_html__( 'This is the primary sidebar if you are using two column site layout option.', 'full-frame' ),
	) );

	$footer_sidebar_number = 3; //Number of footer sidebars

	for( $i=1; $i <= $footer_sidebar_number; $i++ ) {
		register_sidebar( array(
			'name'          => sprintf( esc_html__( 'Footer Area %d', 'full-frame' ), $i ),
			'id'            => sprintf( 'footer-%d', $i ),
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'after_widget'  => '</div><!-- .widget-wrap --></section><!-- #widget-default-search -->',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
			'description'	=> sprintf( esc_html__( 'Footer %d widget area.', 'full-frame' ), $i ),
		) );
	}
}
add_action( 'widgets_init', 'fullframe_widgets_init' );


/**
 * Adds fullframeSocialIcons widget.
 *
 * @since Fullframe 1.0
 */
class Fullframe_social_icons_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'fullframe_social_icons', // Base ID
			'CT: Social Icons', // Name
			array( 'description' => esc_html__( 'Use this widget to add Social Icons as a widget. ', 'full-frame' ) ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';

		echo $args['before_widget'];

		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		echo fullframe_get_social_icons();

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		else {
			$title = '';
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php esc_html_e( 'Title (optional):', 'full-frame' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
        <?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}


}

/**
 * Register Widgets
 *
 * @since Fullframe 1.0
 */
function fullframe_register_widgets() {
    register_widget( 'Fullframe_social_icons_widget' );
}
add_action( 'widgets_init', 'fullframe_register_widgets' );