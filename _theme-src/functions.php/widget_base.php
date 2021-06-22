<?php 
// Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

$widget_domain = 'new_widget';
$widget_name;
$widget_id = 'wpb_widget';
$widget_title = 'WPBeginner Widget';
$widget_description = 'Sample widget based on WPBeginner Tutorial';


 
// Creating the widget 
class wpb_widget extends WP_Widget {
    
    function __construct() {
        parent::__construct(
        
            // Base ID of your widget
            $widget_id, 
            
            // Widget name will appear in UI
            __($widget_title, $widget_domain), 
            
            // Widget description
            array( 'description' => __( $widget_description, $widget_domain ) ) 
        );
        } // End constructor
        
        // Creating widget front-end
        public function widget( $args, $instance ) {
            
            $title = apply_filters( 'widget_title', $instance['title'] );
            
            // before and after widget arguments are defined by themes
            echo $args['before_widget'];
            if ( ! empty( $title ) ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            
            // This is where you run the code and display the output
            echo __( 'Hello, World!', $widget_domain );
            echo $args['after_widget'];
        }
                
        // Widget Backend 
        public function form( $instance ) {
            if ( isset( $instance[ 'title' ] ) ) {
                $title = $instance[ 'title' ];
            }
            else {
                $title = __( $widget_title, $widget_domain );
            }
            // Widget admin form
            ?>
            <!-- Widget HTML -->
                <p>
                    This is a test widget. I hate poorly constructed tutorials.
                </p>
            <?php 
        }
            
        // Updating widget replacing old instances with new
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} // Class wpb_widget ends here