<?php
/**
 * Enqueue theme assets
 *
 * @package MAMADI
 */

namespace MAMADI_THEME\Inc;


class Assets {

    /**
     * Instance of this class.
     *
     * @var Assets
     */
    private static ?Assets $instance = null;

    /**
     * Get the singleton instance of this class.
     *
     * @return Assets|null Instance of this class.
     */
    public static function get_instance(): ?Assets
    {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    protected function __construct() {

        // load class.
        $this->setup_hooks();
    }

    protected function setup_hooks(): void
    {

        /**
         * Actions.
         */
        add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );

    }

    /**
     * @return void
     * Register styles for the theme.
     */
    public function register_styles(): void
    {

        wp_register_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', [], '5.3.2', 'all' );
        wp_register_style( 'style-css', MAMADI_BUILD_CSS_URI . '/style.css', [], filemtime( MAMADI_BUILD_CSS_DIR_PATH . '/style.css' ), 'all' );
        wp_register_style( 'fonts-css', MAMADI_BUILD_CSS_URI . '/fonts.css', [], filemtime( MAMADI_BUILD_CSS_DIR_PATH . '/fonts.css' ), 'all' );


        wp_enqueue_style( 'style-css' );
        wp_enqueue_style( 'bootstrap-css' );
        wp_enqueue_style( 'fonts-css' );

    }

    /**
     * Register scripts for the theme.
     *
     * @return void
     * This method registers the scripts used in the theme.
     */

    public function register_scripts(): void
    {
        wp_register_script( 'popper-js', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js', [], '2.11.8', true );
        wp_register_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js', ['popper-js'], '5.3.2', true );
        wp_register_script( 'main-js', MAMADI_BUILD_JS_URI . '/main.js', ['jquery'], filemtime( MAMADI_BUILD_JS_DIR_PATH . '/main.js' ), true );


        wp_enqueue_script( 'popper-js' );
        wp_enqueue_script( 'bootstrap-js' );
        wp_enqueue_script( 'main-js' );



    }


}
