<?php
/**
 * Register Menus
 *
 * @package MAMADI_THEME
 */

namespace MAMADI_THEME\Inc;


class Menus {

    /**
     * Instance of this class.
     *
     * @var Menus
     */
    private static $instance = null;

    /**
     * Get the singleton instance of this class.
     *
     * @return Menus|null Instance of this class.
     */
    public static function get_instance(): ?Menus
    {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    protected function __construct() {

        $this->setup_hooks();
    }

    /**
     * Setup hooks for the theme.
     *
     * This method registers the necessary actions and filters for the theme.
     *
     * @return void
     */
    protected function setup_hooks(): void
    {
        add_action( 'init', [ $this, 'register_menus' ] );
    }

    public function register_menus(): void
    {
        register_nav_menus([
            'mamadi-header-menu' => esc_html__( 'Header Menu', 'mamadi' ),
            'mamadi-footer-menu' => esc_html__( 'Footer Menu', 'mamadi' ),
        ]);
    }

    /**
     * Get the menu id by menu location.
     *
     * @param string $location
     *
     * @return int|string
     */
    public function get_menu_id(string $location ): int|string
    {

        $locations = get_nav_menu_locations();
        $menu_id = ! empty($locations[$location]) ? $locations[$location] : '';
        return ! empty( $menu_id ) ? $menu_id : '';

    }

    /**
     * Get all child menus that has given parent menu id.
     *
     * @param array $menu_array Menu array.
     * @param integer $parent_id Parent menu id.
     *
     * @return array Child menu array.
     */
    public function get_child_menu_items(array $menu_array, int $parent_id ): array
    {

        $child_menus = [];

        if (! empty( $menu_array )) {

            foreach ( $menu_array as $menu ) {
                if ( intval( $menu->menu_item_parent ) === $parent_id ) {
                    $child_menus[] = $menu;
                }
            }
        }

        return $child_menus;
    }

}
