<?php
/**
 * Text widget class
 *
 * @since 2.8.0
 */
class PHC_Marianiac_Widget_Social_Media extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'phc_marianiac_widget_social_media', 'description' => __('Display Social Media'));
		$control_ops = array('width' => 400, 'height' => 350);
		$this->WP_Widget('PHC_Marianiac_Widget_Social_Media', __('PHC Marianiac Widget Social Media'), $widget_ops, 
		$control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } 
			$phantasmacode_theme_marianiac_settings_vars= get_option('phantasmacode_theme_marianiac_settings_vars');
			$social_media= isset($phantasmacode_theme_marianiac_settings_vars['social_media']) ? 
			$phantasmacode_theme_marianiac_settings_vars['social_media'] : array();
		?>
			<div class="phc_social_media_widget">
		<?php
			foreach( $social_media as $key=>$item ){
				if( $key == "rss" ){
					$link= get_bloginfo('rss2_url');
				}else{
					$link= $item['url'];
				}
				$image_url= PHANTASMACODE_MARIANIAC_THEME_IMAGES_FLAT_SOCIAL_MEDIA_ICONS . $key . ".png";
				
				if( isset($item['display']) ){
		?>
				<a class="" href="<?php echo $link; ?>" title="<?php echo strtoupper($key); ?>">
				<img src="<?php echo $image_url; ?>" alt="<?php echo strtoupper($key); ?>" height="" />
				</a>
		<?php
				}
		?>
		<?php
			}
		?>
			</div>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = esc_textarea($instance['text']);
	}
}

add_action('widgets_init', 'phc_widget_social_media_register_widgets');

// Register Our Widget
function phc_widget_social_media_register_widgets() {
	register_widget('PHC_Marianiac_Widget_Social_Media');
}
?>