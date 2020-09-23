<?php
/*
Plugin Name: Widgets in Columns
Description: Display your widgets in desired columns and rows. This is a weapon too powerful to be used in the hand of mortals!
Version: 0.2.4
Author: Hassan Derakhshandeh
Author URI:		http://shazdeh.me/

		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation; either version 2 of the License, or
		(at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Widgets_in_Columns {

	private static $instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @return	A single instance of this class.
	 */
	public static function get_instance() {
		return null == self::$instance ? self::$instance = new self : self::$instance;
	}

	private function __construct() {
		add_action( 'widgets_init', array( &$this, 'widgets_init' ) );
		if( is_admin() ) {
			add_action( 'in_widget_form', array( &$this, 'options' ), 10, 3 );
			add_filter( 'widget_update_callback', array( &$this, 'update' ), 10, 3 );
			add_action( 'admin_print_styles-widgets.php', array( &$this, 'admin_queue' ) );
		} else {
			add_filter( 'dynamic_sidebar_params', array( &$this, 'dynamic_sidebar_params' ), 99999 ); /* very high priority to make sure the wrapper divs will wrap everything else */
			add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue' ) );
		}
	}

	function options( $widget, $return, $instance ) {
		if( in_array( $widget->id_base, array( 'wic-divider', 'scroller-divider' ) ) )
			return;
		$instance = wp_parse_args( $instance, $this->get_defaults() );
		?>
		<p>
			<label for="<?php echo $widget->get_field_id( 'wic_width' ); ?>"><?php _e( 'Width', 'widget-in-columns' ) ?>: </label>
			<select name="<?php echo $widget->get_field_name( 'wic_width' ); ?>" id="<?php echo $widget->get_field_id( 'wic_width' ); ?>" class="smallfat">
				<option value="" <?php selected( $instance['wic_width'], '' ) ?>>&nbsp;</option>
				<option value="one-half" <?php selected( $instance['wic_width'], 'one-half' ) ?>>1/2</option>
				<option value="one-third" <?php selected( $instance['wic_width'], 'one-third' ) ?>>1/3</option>
				<option value="two-third" <?php selected( $instance['wic_width'], 'two-third' ) ?>>2/3</option>
				<option value="one-fourth" <?php selected( $instance['wic_width'], 'one-fourth' ) ?>>1/4</option>
				<option value="three-fourth" <?php selected( $instance['wic_width'], 'two-third' ) ?>>3/4</option>
				<option value="one-fifth" <?php selected( $instance['wic_width'], 'one-fifth' ) ?>>1/5</option>
				<option value="two-fifth" <?php selected( $instance['wic_width'], 'two-fifth' ) ?>>2/5</option>
				<option value="three-fifth" <?php selected( $instance['wic_width'], 'three-fifth' ) ?>>3/5</option>
				<option value="four-fifth" <?php selected( $instance['wic_width'], 'four-fifth' ) ?>>4/5</option>
				<option value="one-sixth" <?php selected( $instance['wic_width'], 'one-sixth' ) ?>>1/6</option>
				<option value="five-sixth" <?php selected( $instance['wic_width'], 'five-sixth' ) ?>>5/6</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $widget->get_field_id( 'wic_icon' ); ?>"><?php _e( 'Icon', 'widget-in-columns' ) ?>: </label>
			<input type="text" name="<?php echo $widget->get_field_name( 'wic_icon' ); ?>" id="<?php echo $widget->get_field_id( 'wic_icon' ); ?>" value="<?php echo $instance['wic_icon'] ?>" />
			<input type="button" class="button-secondary wic-media-upload" value="<?php _e( 'Upload' ) ?>" data-uploader-button-text="<?php _e( 'Insert icon', 'widget-in-columns' ); ?>" data-uploader-title="<?php _e( 'Insert icon', 'widget-in-columns' ); ?>" data-target="#<?php echo $widget->get_field_id( 'wic_icon' ); ?>" />
		</p>
	<?php }

	/**
	 * Save the wic_width option for current widget in admin area
	 */
	function update( $instance, $new_instance, $old_instance ) {
		$instance['wic_width'] = $new_instance['wic_width'];
		$instance['wic_icon'] = $new_instance['wic_icon'];
		return $instance;
	}

	function dynamic_sidebar_params( $params ) {
		global $wp_registered_widgets;
		$sidebars_widgets = wp_get_sidebars_widgets();

		// get wic_width option
		$options = get_option( $wp_registered_widgets[$params[0]['widget_id']]['callback'][0]->option_name );
		$widget_id = $this->_get_widget_id( $params[0]['widget_id'] );
		$options[$widget_id] = wp_parse_args( $options[$widget_id], $this->get_defaults() );
		$width = $options[$widget_id]['wic_width'];
		$position_id = array_search( $params[0]['widget_id'], $sidebars_widgets[$params[0]['id']] );

		// last widget in a row?
		$last = $clear = '';
		if( end( $sidebars_widgets[$params[0]['id']] ) == $params[0]['widget_id'] ) {
			$last = 'last';
			$clear = '<div class="clear"></div>';
		}
		if( isset( $sidebars_widgets[$params[0]['id']][$position_id+1] ) && in_array( _get_widget_id_base( $sidebars_widgets[$params[0]['id']][$position_id+1] ), array( 'wic-divider', 'scroller-divider' ) ) )
			$last = 'last';

		// icon
		if( ! empty( $options[$widget_id]['wic_icon'] ) ) {
			$params[0]['before_widget'] = "<div class='icon-box'><div class='icon-image'><img src='{$options[$widget_id]['wic_icon']}' alt='' /></div><div class='icon-content'>" . $params[0]['before_widget'];
			$params[0]['after_widget'] .= '</div></div>';
		}

		// trying to be smart here: do not output the wrapper div's unless we need them
		if( ! empty( $width ) && $width !== 'full-width' ) {
			$params[0]['before_widget'] = "<div class='{$width} {$last}'>" . $params[0]['before_widget'];
			$params[0]['after_widget'] .= "</div>{$clear}";
		}

		return $params;
	}

	function _get_widget_id( $widget ) {
		preg_match( '/-([0-9]+)$/', $widget, $matches );
		return $matches[1];
	}

	function enqueue() {
		if( is_rtl() ) $library = 'library-rtl.css'; else $library = 'library.css';
		wp_enqueue_style( 'layouts-grid', plugins_url( 'css/' . $library, __FILE__ ) );
	}

	function widgets_init() {
		require_once( dirname( __FILE__ ) . '/widgets.php' );
		register_widget( 'WIC_Widget_Divider' );
		register_widget( 'WIC_Widget_Spacer' );
	}

	/**
	 * Scripts for the admin
	 *
	 * @since 0.2
	 * @return void
	 */
	function admin_queue() {
		wp_enqueue_media();
		wp_enqueue_script( 'wic-library', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery', 'plupload-all' ), '0.2.4', true );
	}

	/**
	 * Default widget options
	 *
	 * @return array
	 */
	function get_defaults() {
		return array(
			'wic_width' => '',
			'wic_icon' => '',
		);
	}
}

Widgets_in_Columns::get_instance();