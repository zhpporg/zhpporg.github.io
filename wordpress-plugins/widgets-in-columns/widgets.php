<?php

/**
 * Divider Widget
 * Used to add a new row of widgets. It has several display options.
 *
 * @since 0.1
 */
class WIC_Widget_Divider extends WP_Widget {

	function WIC_Widget_Divider() {
		$widget_ops = array('description' => __( 'New row of widgets', 'widget-in-columns' ) );
		$this->WP_Widget( "wic-divider", __( 'Divider', 'widget-in-columns' ), $widget_ops, null );
	}

	function widget( $args, $instance ) {
		echo "<div class='{$instance[type]}'></div>";
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['type'] = stripslashes($new_instance['type']);

		return $instance;
	}

	function form( $instance ) { ?>
		<p>
			<label><?php _e('Type') ?>:</label>
			<select name="<?php echo $this->get_field_name('type') ?>" id="<?php echo $this->get_field_id('type') ?>" class="widefat">
				<option value="divider" <?php selected( $instance['type'], 'divider' ) ?>>.divider</option>
				<option value="break" <?php selected( $instance['type'], 'break' ) ?>>.break</option>
				<option value="clear" <?php selected( $instance['type'], 'clear' ) ?>>.clear</option>
			</select>
		</p>
	<?php }
}

/**
 * Spacer Widget
 * Used to add a blank column.
 *
 * @since 0.2
 */
class WIC_Widget_Spacer extends WP_Widget {

	function WIC_Widget_Spacer() {
		$widget_ops = array('description' => __( 'Adds a blank column', 'widget-in-columns' ) );
		$this->WP_Widget( "wic-spacer", __( 'Spacer', 'widget-in-columns' ), $widget_ops, null );
	}

	function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		return $instance;
	}

	function form( $instance ) {
		// no options, really.
	}
}