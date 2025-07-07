<?php

namespace Weltall\classes;


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Plugin Class for Weltall Plugin.
 *
 * @package Weltall
 */


class Plugin {

    /**
     * Database instance.
     *
     * @var Database
     */
    private Database $db;
    /**
     * Shortcode instance.
     *
     * @var Shortcode
     */
    private  Shortcode $shortcode;

    /**
     * The path to the plugin file.
     *
     * @var string
     */
    private string $plugin_file;


    /**
     * Constructor.
     * 
     * @param string $plugin_file The path to the plugin file.
     */
    public function __construct(string $plugin_file) {
        $this->plugin_file = $plugin_file;
        $this->init();
    }
    /**
     * Activate plugin
     * install database table
     * insert data
     */
    public function activate(): void
    {
        $this->db->create_table();
        $this->db->insert_weltall_data();
    }

    /**
     * Deactivate plugin
     * delete database table
     * delete data
     * flush rewrite rules
     */

    public function deactivate(): void
    {
        $this->db->drop_table();
       $this->db->truncate_table();
        flush_rewrite_rules();
    }

    /**
     * Initialize plugin
     *
     * This method sets up the plugin constants, initializes the database, assets, shortcode, and admin functionalities.
     * It defines constants for the plugin path, URL, build path, and version.
     * It also creates an instance of the Database class, initializes assets, sets up the shortcode functionality, and initializes the admin interface.
     */
    private function init(): void
    {
        define( 'WELTALL_PLUGIN_PATH', untrailingslashit( plugin_dir_path( $this->plugin_file ) ) );
        define( 'WELTALL_PLUGIN_URL', untrailingslashit( plugin_dir_url( $this->plugin_file ) ) );
        define( 'WELTALL_PLUGIN_BUILD_PATH', WELTALL_PLUGIN_PATH . '/assets/build' );
        define( 'WELTALL_PLUGIN_BUILD_URL', WELTALL_PLUGIN_URL . '/assets/build' );
        define( 'WELTALL_PLUGIN_VERSION', '1.0.0' );

        $this->db = Database::get_instance();
        new Assets();

        $this->shortcode = new Shortcode($this->db);

        new Admin($this->db);
    }

}
