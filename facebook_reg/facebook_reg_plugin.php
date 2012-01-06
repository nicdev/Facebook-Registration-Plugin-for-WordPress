<?php
/*
Plugin Name: Facebook Registration Plugin
Plugin URI: http://epiclabs.com
Description: Facebook Registration form married to WP auth.
Author: Epic Labs
Author URI: http://epiclabs.com
Version: 0.2
*/

/*  Copyright 2012 Epic Labs

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

require_once('Facebook_reg.php');

register_activation_hook( __FILE__, array( 'Fb_reg', 'install_init' ) );

add_action( 'wp_head', array( 'Fb_reg', 'register_user' ) );
add_action( 'admin_menu', array( 'Fb_reg', 'register_menu' ) );
add_action( 'wp_enqueue_scripts', array( 'Fb_reg', 'script_queuer' ) );
add_action( 'wp_print_footer_scripts', array( 'Fb_reg', 'so_say_we_all' ) );

add_filter( 'register' , array( 'Fb_reg', 'change_reg_link' ) );

/*********************************************************************************************************************/

?>