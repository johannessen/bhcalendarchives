<?php
/*
Plugin Name: bhCalendarchives
Plugin URI: http://blog.burninghat.net.
Description: Replace the archives widget by a wonderful monthly table
Version: 0.1
Author: Emmanuel Ostertag alias burningHat
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
function bhCalendarchives(){
	global $wpdb;
?>
<table id="bhCalendarchives" summary="liens vers les archives du blog">
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
			<td><a href="<?php echo get_month_link($year, $x); ?>"><?php if ( $x < 10 ) : echo '0'.$x; else : echo $x; endif; ?></td>
<?php
	 	} else {
?>
			<td><?php if ( $x < 10 ) : echo '0'.$x; else : echo $x; endif; ?></td>
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
		//$title = __('Archives');
		echo $before_widget . $before_title . __('Archives') . $after_title;
		bhCalendarchives();
		echo $after_widget;
	}
		
	function bhCalendarchives_widget_register(){
		$widget_ops = array('classname' => 'widget_bhcalendarchives', 'description' => __( "A nicely table to display your monthly archive of your blog's posts") );
		wp_register_sidebar_widget('archives', __('Archives'), 'bhCalendarchives_widget', $widget_ops);
		//wp_register_widget_control('archives', __('Archives'), 'wp_widget_archives_control' );
		unregister_widget_control('archives');
	}
	// Launch widget
	bhCalendarchives_widget_register();
}

add_action('widgets_init', 'bhCalendarchives_widget_init');
?>