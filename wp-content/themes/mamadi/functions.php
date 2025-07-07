<?php

if ( ! defined( 'MAMADI_DIR_PATH' ) ) {
    define( 'MAMADI_DIR_PATH', untrailingslashit( get_template_directory() ) );
}

if ( ! defined( 'MAMADI_DIR_URI' ) ) {
    define( 'MAMADI_DIR_URI', untrailingslashit( get_template_directory_uri() ) );
}

if ( ! defined( 'MAMADI_BUILD_URI' ) ) {
    define( 'MAMADI_BUILD_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/scss' );
}

if ( ! defined( 'MAMADI_BUILD_PATH' ) ) {
    define( 'MAMADI_BUILD_PATH', untrailingslashit( get_template_directory() ) . '/assets/scss' );
}

if ( ! defined( 'MAMADI_BUILD_JS_URI' ) ) {
    define( 'MAMADI_BUILD_JS_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/js' );
}

if ( ! defined( 'MAMADI_BUILD_JS_DIR_PATH' ) ) {
    define( 'MAMADI_BUILD_JS_DIR_PATH', untrailingslashit( get_template_directory() ) . '/assets/js' );
}

if ( ! defined( 'MAMADI_BUILD_IMG_URI' ) ) {
    define( 'MAMADI_BUILD_IMG_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/images' );
}

if ( ! defined( 'MAMADI_BUILD_CSS_URI' ) ) {
    define( 'MAMADI_BUILD_CSS_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/css' );
}

if ( ! defined( 'MAMADI_BUILD_CSS_DIR_PATH' ) ) {
    define( 'MAMADI_BUILD_CSS_DIR_PATH', untrailingslashit( get_template_directory() ) . '/assets/css' );
}



require_once MAMADI_DIR_PATH . '/inc/helpers/autoloader.php';

function mamadi_get_theme_instance() {
    \MAMADI_THEME\Inc\MAMADI_THEME::get_instance();
}

mamadi_get_theme_instance();