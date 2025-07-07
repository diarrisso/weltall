<?php

namespace Weltall\classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Assets Class.
 *
 * @package Weltall
 */


/**
 * Class Assets.
 */
class Assets {

    /**
     * Constructor.
     */
    public function __construct() {
        $this->init();
    }

    /**
     * Initialize.
     */
    private function init(): void
    {
        add_action( 'admin_enqueue_scripts', [ $this, 'weltall_enqueue_styles' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'weltall_enqueue_scripts' ] );
    }

    /**
     * Enqueue styles.
     */
    public function weltall_enqueue_styles(): void
    {
        wp_enqueue_style(
            'weltall-style',
            WELTALL_PLUGIN_URL . '/assets/css/style.css',
            [],
            filemtime( WELTALL_PLUGIN_PATH . '/assets/css/style.css' )
        );
    }

    /**
     * Enqueue scripts.
     */
    public function weltall_enqueue_scripts(): void
    {
        wp_enqueue_script(
            'weltall-script',
            WELTALL_PLUGIN_URL . '/assets/js/weltall.js',
            ['jquery'],
            filemtime( WELTALL_PLUGIN_PATH . '/assets/js/weltall.js' ),
            true
        );
    }

}
