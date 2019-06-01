<?php

/*
Plugin Name: Pedro Nunes NYT Articles
Plugin URI: https://wordpress.org/plugins/pzn-nyt-articles/
Description: Show up-to-date NYT Articles in your pages
Version: 0.1.0
Author: Pedro Zgierski Nunes
Author URI: http://pedro-nunes.com/pzn-nyt-articles
Text Domain: pzn-nyt-articles
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

//require_once( 'inc/options-page-wrapper.php' );
// Check if this plugin is being called from within a wordpress installation.
// You can also check for 'function_exists('add_action')'
// Isso previne que o plugin seja acessado por fontes externas.
//namespace PZN_NYT_Articles;


defined ( 'ABSPATH' ) or die ( 'Hey, you can not access this file' );

if ( file_exists ( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once ( dirname( __FILE__ ) . '/vendor/autoload.php' );
}

if ( class_exists( 'PZN\\NYT\\Init' ) ) {
    PZN\NYT\Init::register_services();
}