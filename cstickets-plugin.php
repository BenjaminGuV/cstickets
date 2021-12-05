<?php
/**
 * Plugin Name: CS TICKETS
 * Plugin URI: https://github.com/BenjaminGuV/cstickets
 * Description: Generador de tickets de compra
 * Text Domain: cstickets
 * Domain Path: /i18n/languages
 * Version: 1.0.0
 * Requires at least: 5.5.3
 * Requires PHP: 7.2.24
 * Author: Benjamin Guerrero
 * Author URI: https://nanos.pw/
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
*/

//PATH
define( 'CSTS_CSTICKETS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CSTS_CSTICKETS__PLUGIN_URL', plugin_dir_url( __FILE__ ) );

//includes libs functions
require_once plugin_dir_path(__FILE__) . 'includes/cstickets-functions.php';


//menu admin
add_action( 'admin_menu', 'csts_cstickets_add_my_admin_link' );

//load css and js
add_action('wp_enqueue_scripts', 'csts_cstickets_callback_scripts');

//print html
add_action( 'the_content', 'csts_cstickets_print_html' );

//install tables
register_activation_hook(__FILE__, 'csts_cstickets_installer');


// Hook para usuarios logueados
add_action('wp_ajax_save_cstickets_ajax', 'csts_cstickets_save_ajax');
add_action('wp_ajax_get_cstickets_ajax', 'csts_cstickets_get_ajax');