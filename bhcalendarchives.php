<?php
/*
Plugin Name: bhCalendarchives
Plugin URI: http://blog.burninghat.net/2008/08/15/plugin-wordpress-bhcalendarchives/
Description: Replace the archives widget by a wonderful monthly table
Version: 0.2
Author: Emmanuel Ostertag alias burningHat and with the contribution of Jérémy Verda (http://blog.v-jeremy.net/)
Author URI: http://blog.burninghat.net
License: GPL

Copyright 2008  Emmanuel Ostertag alias burningHat (email : webmaster _at_ burninghat.net)

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

/* main function */
function bhCalendarchives($display = 'num'){
	global $wpdb;
	
	// array of months
	$full_months = array(
					1 => __('January', 'bhCalendarchives'),
					2 => __('February', 'bhCalendarchives'),
					3 => __('March', 'bhCalendarchives'),
					4 => __('April', 'bhCalendarchives'),
					5 => __('May', 'bhCalendarchives'),
					6 => __('June', 'bhCalendarchives'),
					7 => __('July', 'bhCalendarchives'),
					8 => __('August', 'bhCalendarchives'),
					9 => __('October', 'bhCalendarchives'),
					10 => __('September', 'bhCalendarchives'),
					11 => __('November', 'bhCalendarchives'),
					12 => __('December', 'bhCalendarchives')
				  );
	
	// initialize the array to display month
	if ( 'num' == $display ){
		$display_months = array(1=>'01', 2=>'02', 3=>'03', 4=>'04', 5=>'05', 6=>'06', 7=>'07', 8=>'08', 9=>'09', 10=>'10', 11=>'11', 12=>'12');
	} else if ( 'first' == $display ){
		$display_months = array(
					1 => __('J', 'bhCalendarchives'), 
					2 => __('F', 'bhCalendarchives'),
					3 => __('M', 'bhCalendarchives'),
					4 => __('A', 'bhCalendarchives'),
					5 => __('M', 'bhCalendarchives'),
					6 => __('J', 'bhCalendarchives'),
					7 => __('J', 'bhCalendarchives'),
					8 => __('A', 'bhCalendarchives'),
					9 => __('S', 'bhCalendarchives'),
					10 => __('O', 'bhCalendarchives'),
					11 => __('N', 'bhCalendarchives'),
					12 => __('D', 'bhCalendarchives')
				  );
	} else if ( 'short' == $display ){
		$display_months = array(
					1 => __('Jan', 'bhCalendarchives'),
					2 => __('Feb', 'bhCalendarchives'),
					3 => __('Mar', 'bhCalendarchives'),
					4 => __('Apr', 'bhCalendarchives'),
					5 => __('May', 'bhCalendarchives'),
					6 => __('Jun', 'bhCalendarchives'),
					7 => __('Jul', 'bhCalendarchives'),
					8 => __('Aug', 'bhCalendarchives'),
					9 => __('Sep', 'bhCalendarchives'),
					10 => __('Oct', 'bhCalendarchives'),
					11 => __('Nov', 'bhCalendarchives'),
					12 => __('Dec', 'bhCalendarchives')
				  );
	}
?>
<table id="bhCalendarchives" summary="<?php _e('links to the blog archives', 'bhCalendarchives'); ?>">
	<tbody>
<?php
	
	$years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC");
	
	foreach ( $years as $year ){
?>
		<tr>
			<th scope="row"><?php echo $year; ?></th>
<?php
	 $months = $wpdb->get_col("SELECT DISTINCT MONTH(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND YEAR(post_date) = '".$year."' ORDER BY post_date ASC");
	 
	 $monthwithposts = array_flip($months);
	 
	 for ( $x = 1 ; $x <= 12 ; $x++ ){
	 	if ( array_key_exists($x, $monthwithposts) ){
?>
			<td><a href="<?php echo get_month_link($year, $x); ?>" title="<?php printf(__('%1$s %2$s archives'), $full_months[$x], $year); ?>"><?php echo $display_months[$x]; ?></a></td>
<?php
	 	} else {
?>
			<td><?php echo $display_months[$x]; ?></td>
<?php
	 	}
	 }
?>
		</tr>
<?php
	}
?>
	</tbody>
</table>
<p id="bhCalendarchives-sig">Calendarchives powered by <a href="http://blog.burninghat.net/" title="burningHat">burningHat</a></p>
<?php
}


// Widget
function bhCalendarchives_widget_init(){
	// Widget capable ?
	if ( !function_exists('wp_register_sidebar_widget') || !function_exists('wp_register_widget_control') )
		return;
		
	function bhCalendarchives_widget($args){
		extract($args);
		$options = get_option('widget_archives');
		$title = empty($options['title']) ? __('Archives', 'bhCalendarchives') : apply_filters('widget_title', $options['title']);
		$display = $options['display'];
		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		bhCalendarchives($display);
		echo $after_widget;
	}
	
	function bhCalendarchives_widget_control(){
		$options = $newoptions = get_option('widget_archives');
		
		if ( $_POST['archives-submit'] ){
			$newoptions['title'] = strip_tags(stripslashes($_POST["archives-title"]));
			
			$display = stripslashes($_POST['archives-display']);
			if ( in_array( $display, array('num', 'first', 'short')) ){
				$newoptions['display'] = $display;
			} else {
				$newoptions['display'] = 'num';
			}
		}
		if ( $options != $newoptions ){
			$options = $newoptions;
			update_option('widget_archives', $options);
		}
		
		$title = attribute_escape($options['title']);
		$display = attribute_escape($options['display']);
?>
				<p><label for="archives-title"><?php _e('Title:', 'bhCalendarchives'); ?> <input class="widefat" id="archives-title" name="archives-title" type="text" value="<?php echo $title; ?>" /></label></p>
				<p><label for="archives-display"><?php _e('How to display archives', 'bhCalendarchives'); ?>
					<select name="archives-display" id="archives-display" class="widefat">
						<option value="num"<?php  selected( $display, 'num' ); ?>><?php _e('Numeric', 'bhCalendarchives'); ?></option>
						<option value="first"<?php selected( $display, 'first' ); ?>><?php _e('First letter', 'bhCalendarchives'); ?></option>
						<option value="short"<?php selected( $display, 'short' ); ?>><?php _e('First three letters', 'bhCalendarchives'); ?></option>
					</select>
				</label>
				<small><ul>
					<li><?php _e('<strong>Numeric:</strong> numeric representation of a mon with leading zeros like "01" for "January"', 'bhCalendarchives'); ?></li>
					<li><?php _e('<strong>First letter:</strong> display only the first letter of the month name, like "J" for "January"', 'bhCalendarchives'); ?></li>
					<li><?php _e('<strong>First three letters:</strong> display a short textual representation of a month, three letters like "Jan" for "January"', 'bhCalendarchives'); ?></li>
				</ul></small>
				</p>				
				
				<input type="hidden" id="archives-submit" name="archives-submit" value="1" />
<?php
		
	}
		
	function bhCalendarchives_widget_register(){
		
		// need upgrade ?
		$options = get_option('widget_archives');
		if ( is_array($options) && !isset($options['display']) ){
			$options['display'] = 'num';
			update_option('widget_archives', $options);
		}
		
	
		$widget_ops = array('classname' => 'widget_bhcalendarchives', 'description' => __( "A nicely table to display your monthly archive of your blog's posts") );
		wp_register_sidebar_widget('archives', __('Archives', 'bhCalendarchives'), 'bhCalendarchives_widget', $widget_ops);
		//wp_register_widget_control('archives', __('Archives'), 'wp_widget_archives_control' );
		unregister_widget_control('archives');
		wp_register_widget_control('archives', __('Archives', 'bhCalendarchives'), 'bhCalendarchives_widget_control');
	}
	// Launch widget
	bhCalendarchives_widget_register();
}

// localization
function bhCalendarchives_textdomain(){
	$locale = get_locale();
	if ( empty($locale) ){
		$locale = 'en_US';
	} else {
		$path = basename(str_replace('\\', '/', dirname(__FILE__)));
		$path = ABSPATH.PLUGINDIR.'/'.$path;
		$mofile = $path.'/'.$locale.'.mo';
		load_textdomain('bhCalendarchives', $mofile);
	}
}

// Run
add_action('init', 'bhCalendarchives_textdomain');
add_action('widgets_init', 'bhCalendarchives_widget_init');

// reset the widget_archives options to default on plugin deactivation
function bhCalendarchives_deactivate(){
	$options = get_option('widget_archives');
	
	$newoptions['count'] = $options['count'];
	$newoptions['dropdown'] = $options['dropdown'];
	$newoptions['title'] = $options['title'];
	update_option('widget_archives', $newoptions);
}

register_deactivation_hook(__FILE__, 'bhCalendarchives_deactivate');
?>