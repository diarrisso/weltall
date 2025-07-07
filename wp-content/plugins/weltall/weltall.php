<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * Plugin Name: Weltall
 * Plugin URI: http://localhost:8000/plugins/weltall/
 * Description: Das Weltall ist ein maßgeschneidertes plugin zur Verwaltung und Anzeige von Planetendaten. Es bietet ein vollständiges System zur Speicherung, Abfrage und Darstellung von Planeteninformationen mit Unterstützung des Markdown-Formats.
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 8.0
 * Author: Mamadi Diarrisso Full-stack Developer
 * Author URI: http://localhost:8000
 * License URI:http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: weltall
 * Domain Path: /languages
 */

/**
 * Bootstrap the plugin.
 */
require_once 'vendor/autoload.php';
require_once untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/src/classes/Database.php';

use Weltall\classes\Plugin;

/**
 * Instantiate the plugin class.
 *
 */


if ( class_exists('Weltall\classes\Plugin') ) {
    $the_plugin = new Plugin( __FILE__ );

    register_activation_hook( __FILE__, [ $the_plugin, 'activate' ] );
    register_deactivation_hook( __FILE__, [ $the_plugin, 'deactivate' ] );
}


