<?php
/*
 * Plugin Name: Wordpress Widget Social
 * Description:
 * Version: 1.0
 * Author URI: clooder.com
 * License: MYT
 */



function wpb_load_widget() {
    if(!class_exists("piiWidget"))
	include("piiWidget.php");
    register_widget( 'piiWidget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );


?>
