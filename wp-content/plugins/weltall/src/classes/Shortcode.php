<?php

namespace Weltall\classes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Shortcode Class for Weltall Plugin.
 *
 * @package Weltall
 */


class Shortcode
{

    public function __construct( private Database $db )
    {
        add_shortcode('weltall', [$this, 'shortcode_weltall']);
        add_action('wp_enqueue_scripts', [$this, 'weltall_enqueue_styles']);
    }
    /**
     * Enqueue styles
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
     * Shortcode für Planeten-Anzeige
     *
     * @param array $atts Shortcode Attribute
     * @return string HTML Output der Planeten
     */
    public function shortcode_weltall(array $atts): string
    {

        $options = get_option('weltall_options');
        $default_limit = isset($options['default_limit']) ? absint($options['default_limit']) : 3;

        $atts = shortcode_atts(array(
            'limit' => $default_limit,
            'style' => 'list'
        ), $atts, 'weltall');

        $planets = $this->db->get_latest_weltall(intval($atts['limit']));

        if (empty($planets)) {
            return '<p>' . __('Keine Planeten gefunden.', 'weltall') . '</p>';
        }


        ob_start();
        ?>

        <div class="container">
            <h3>Weltall list</h3>

            <div class="weltall_grid">
            <?php foreach ($planets as $planet): ?>
                <div class="weltall_flex">
                    <h4><?php echo esc_html($planet->name); ?></h4>
                    <div>
                        <div><strong>Umfang:</strong> <?php echo esc_html(number_format($planet->umfang_km)); ?> km</div>
                        <div><strong>Entfernung zur Sonne:</strong> <?php echo esc_html($planet->entfernung_sonne); ?></div>
                        <div><strong>Zutsatz:</strong> <?php echo wp_kses_post($planet->zusatz_html); ?> </div>
                    </div>
                </div>
            <?php endforeach; ?>

            </div>

        </div>

        <?php
        return ob_get_clean();
    }

}
