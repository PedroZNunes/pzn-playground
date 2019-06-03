<?php

/*
Plugin Name: Pedro Nunes Playground Plugin
Plugin URI: https://wordpress.org/plugins/pzn-playground/
Description: Just my play thing
Version: 0.1.0
Author: Pedro Zgierski Nunes
Author URI: http://pedro-nunes.com/pzn-playground
Text Domain: pzn-playground
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/


// Check if this plugin is being called from within a wordpress installation.
// You can also check for 'function_exists('add_action')'
// Isso previne que o plugin seja acessado por fontes externas.

defined ( 'ABSPATH' ) or die ( 'Hey, you can not access this file' );

if ( file_exists ( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once ( dirname( __FILE__ ) . '/vendor/autoload.php' );
}

if ( class_exists( 'PZN\\Playground\\Init' ) ) {
    PZN\Playground\Init::register_services();
}