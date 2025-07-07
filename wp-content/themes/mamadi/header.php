<?php
/**
 * Header template.
 *
 * @package Advanced WooCommerce Theme
 */
?>
    <!doctype html>
<html <?php language_attributes(); ?> lang="">
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?php the_title() ?></title>
        <?php wp_head(); ?>
    </head>
<body <?php body_class(); ?>>

<?php
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
}
?>
    <div id="page">
        <header class="header mb-5 ">
            <div class="container d-flex justify-content-between align-items-center">
                <a href="<?php echo home_url(); ?>" class="navbar-brand">
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="<?php bloginfo('name'); ?>
                    ">
                </a>

                <nav class="navbar navbar-expand-lg" id="nav">
                    <?php
                    if (has_nav_menu('mamadi-header-menu')) {
                        wp_nav_menu(array(
                            'theme_location' => 'mamadi-header-menu',
                            'menu_class'     => 'navbar-nav',
                            'container'      => false,
                            'fallback_cb'    => false,

                        ));
                    } else {
                        echo '<ul class="navbar-nav"><li class="nav-item">' . esc_html__('Please assign a menu to the header menu location.', 'mamadi') . '</li></ul>';
                    }
                    ?>
                </nav>
            </div>
        </header>
    </div>


<div class="container">





