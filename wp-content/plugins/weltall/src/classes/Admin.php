<?php

namespace Weltall\classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Weltall Plugin
 * @package Weltall
 * @since 1.0.0
 */


use JetBrains\PhpStorm\NoReturn;
use mysqli_result;
use wpdb;

/**
 * Admin Class for Weltall Plugin.
 *
 * @package Weltall
 */
class Admin

{
    /**
     * The plugin name.
     *
     * @var string
     */

    public string $plugin_name = 'weltall';

    public array $error = [];
    public array $error_fields = [];

    /**
     * Database instance.
     *
     * @return void
     */

    public function __construct(public Database $db)
    {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_weltall_settings']);
        add_action('admin_post_add_weltall_planet', [$this, 'weltall_form_response']);
        add_filter('wp_redirect', [$this, 'modify_settings_redirect'], 10, 2);
    }

    /**
     * Add an admin menu for the Weltall plugin.
     *
     * @return void
     */

    public function add_admin_menu(): void{
        add_menu_page(
            __('Weltall Planètes', 'weltall'),
            __('Weltall', 'weltall'),
            'manage_options',
            'weltall-settings',
            [$this, 'weltall_settings_page'],
            'dashicons-admin-site',
            30
        );
    }


    /**
     * Sanitize options for the Weltall plugin.
     *
     * @param array $options The options to sanitize.
     * @return array Sanitized options.
     */

    public function sanitize_weltall_options(array $options): array
    {

        $options['default_limit'] = isset($options['default_limit']) ? absint($options['default_limit']) : 3;

        return $options;
    }

    /**
     * Register settings for the Weltall plugin.
     *
     * @return void
     */
    public function register_weltall_settings(): void
    {

        register_setting(
            'weltall_options_group',
            'weltall_options',
            [$this, 'sanitize_weltall_options']
        );

        add_settings_section(
            'weltall_general_section',
            'Weltall Einstellungen',
            [$this, 'weltall_general_section_callback'],
            'weltall_settings_page',

        );

        add_settings_field(
            'weltall_default_limit',
            'Anzahl Planeten zum Anzeigen',
            [$this, 'weltall_default_limit_callback'],
            'weltall_settings_page',
            'weltall_general_section'
        );


    }


    /**
     * Callback function for the general section of the Weltall settings.
     *
     * @return void
     */

    public function weltall_general_section_callback(): void
    {
        echo '<p>' . esc_html__('Hier können Sie die Anzahl der Weltall zur Anzeige geben.', 'weltall') . '</p>';
    }

    /**
     * Callback function for the default limit field in the Weltall settings.
     *
     * @return void
     */
    public function weltall_default_limit_callback(): void
    {
        $options = get_option('weltall_options');
        $default_limit = isset($options['default_limit']) ? absint($options['default_limit']) : 3;
        echo '<input type="number" class="form-control" name="weltall_options[default_limit]" value="' . esc_attr($default_limit) . '" />';
        echo '<p class="description">' . esc_html__('Geben Sie die Anzahl der Standardplaneten ein.', 'weltall') . '</p>';
    }

    /**
     * Handle the form submission for adding a new planet.
     * This function processes the form data, validates it, and inserts a new planet into the database.
     * It also handles errors and redirects the user accordingly.
     *
     * @return void
     */

    public function weltall_settings_page(): void
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('Sie haben keine ausreichenden Berechtigungen, um auf diese Seite zuzugreifen.'));
        }

        list($success_message, $error_messages, $error_fields) = $this->getAdminMessages();

        $active_tab = $_GET['tab'] ?? 'settings-show-weltall-limit';

        ?>
        <div class="wrap">
        <h2 class="nav-tab-wrapper">
            <a href="?page=weltall-settings&tab=settings-show-weltall-limit"
               class="nav-tab <?php echo $active_tab === 'settings-show-weltall-limit' ? 'nav-tab-active' : ''; ?>">
                <?php _e('Einstellungen', 'weltall'); ?>
            </a>
            <a href="?page=weltall-settings&tab=add-weltall-planet"
               class="nav-tab <?php echo $active_tab === 'add-weltall-planet' ? 'nav-tab-active' : ''; ?>">
                <?php _e('Fügen Sie einen Planeten hinzu', 'weltall'); ?>
            </a>
            <a href="?page=weltall-settings&tab=list-weltall-planets"
               class="nav-tab <?php echo $active_tab === 'list-weltall-planets' ? 'nav-tab-active' : ''; ?>">
                <?php _e('Liste der Planeten', 'weltall'); ?>
            </a>
        </h2>

        <div id="settings-show-weltall-limit" class="tab-content"
             style="display: <?php echo $active_tab === 'settings-show-weltall-limit' ? 'block' : 'none'; ?>;">
            <form method="post" action="options.php">
                <?php
                settings_fields('weltall_options_group');
                do_settings_sections('weltall_settings_page');
                echo '<input type="hidden" name="tab" value="settings-show-weltall-limit" />';
                submit_button();
                ?>
            </form>
        </div>

        <div id="add-weltall-planet" class="tab-content" style="display: <?php echo $active_tab === 'add-weltall-planet' ? 'block' : 'none'; ?>;">
            <h2>
                <?php _e('Fügen Sie einen neuen Planeten hinzu', 'weltall'); ?>
            </h2>

            <?php

            if (!empty($success_message)) {
                echo '<div class="notice notice-success is-dismissible"><p>' . esc_html($success_message) . '</p></div>';
            }

            if (!empty($error_messages)) {
                echo '<div class="notice notice-error is-dismissible"><p>Ein Fehler ist aufgetreten. Bitte überprüfen Sie Ihre Eingaben.</p></div>';
            }
            ?>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="add_weltall_planet">
                <?php wp_nonce_field('add_weltall_planet_nonce', 'weltall_nonce'); ?>

                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="name"><?php _e('Name', 'weltall'); ?></label></th>
                        <td>
                            <input name="name" id="name" type="text" class="regular-text"
                                   value="<?php echo isset($_GET['name']) ? esc_attr($_GET['name']) : ''; ?>">
                            <?php if (in_array('name', $error_fields)): ?>
                                <p class="text-danger"><?php _e('Der Name ist erforderlich.', 'weltall'); ?></p>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="umfang_km"><?php _e('Umfang (km)', 'weltall'); ?></label></th>
                        <td>
                            <input name="umfang_km" id="umfang_km" type="number" class="regular-text"
                                   value="<?php echo isset($_GET['umfang_km']) ? esc_attr($_GET['umfang_km']) : ''; ?>">
                            <?php if (in_array('umfang_km', $error_fields)): ?>
                                <p class="text-danger"><?php _e('Der Umfang muss eine Zahl sein.', 'weltall'); ?></p>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label
                                    for="entfernung_sonne"><?php _e('Entfernung zur Sonne', 'weltall'); ?></label></th>
                        <td>
                            <input name="entfernung_sonne" id="entfernung_sonne" type="text" class="regular-text"
                                   value="<?php echo isset($_GET['entfernung_sonne']) ? esc_attr($_GET['entfernung_sonne']) : ''; ?>">
                            <?php if (in_array('entfernung_sonne', $error_fields)): ?>
                                <p class="text-danger"><?php _e('Die Entfernung zur Sonne ist erforderlich.', 'weltall'); ?></p>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label
                                    for="zusatz"><?php _e('zusätzliche (supporte Markdown)', 'weltall'); ?></label></th>
                        <td>
                            <textarea name="zusatz" id="zusatz" rows="5" class="large-text"><?php echo isset($_GET['zusatz']) ? esc_textarea($_GET['zusatz']) : ''; ?></textarea>
                            <?php if (in_array('zusatz', $error_fields)): ?>
                                <p class="text-danger"><?php _e('Zusätzliche Informationen müssen gültig sein.', 'weltall'); ?></p>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
                <?php submit_button(__('Speichern', 'weltall')); ?>
            </form>
        </div>

        <div id="list-weltall-planets" class="tab-content"
             style="display: <?php echo $active_tab === 'list-weltall-planets' ? 'block' : 'none'; ?>;">
            <h2><?php _e('Liste der Planeten', 'weltall'); ?></h2>

            <?php

            $planets = $this->db->get_latest_weltall();

            if (!empty($planets)) {
                echo '<table class="widefat fixed striped">';
                echo '<thead><tr><th>' . __('Name', 'weltall') . '</th><th>' . __('Umfang (km)', 'weltall') . '</th><th>' . __('Entfernung zur Sonne', 'weltall') . '</th><th>' . __('Zusatz', 'weltall') . '</th></tr></thead>';
                echo '<tbody>';
                foreach ($planets as $planet) {
                    echo '<tr>';
                    echo '<td>' . esc_html($planet->name) . '</td>';
                    echo '<td>' . esc_html($planet->umfang_km) . '</td>';
                    echo '<td>' . esc_html($planet->entfernung_sonne) . '</td>';
                    echo '<td>' . esc_html($planet->zusatz) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>' . __('Keine Planeten gefunden.', 'weltall') . '</p>';
            }
            ?>
        </div>
        <?php
    }

    /**
     * @return array
     */
    protected function getAdminMessages(): array
    {
        $success_message = '';
        $error_messages = [];
        $error_fields = [];


        if (isset($_GET['weltall-error']) && $_GET['weltall-error'] == '1') {
            if (isset($_GET['error-messages'])) {
                $decoded_messages = json_decode(base64_decode($_GET['error-messages']), true);
                if (is_array($decoded_messages)) {
                    $error_messages = $decoded_messages;
                }
            }

            if (isset($_GET['error-fields'])) {
                $decoded_fields = json_decode(base64_decode($_GET['error-fields']), true);
                if (is_array($decoded_fields)) {
                    $error_fields = $decoded_fields;
                }
            }
        }
        if (isset($_GET['weltall-added']) && $_GET['weltall-added'] == '1') {
            $success_message = __('Der Planet wurde erfolgreich hinzugefügt.', 'weltall');
        }
        return array($success_message, $error_messages, $error_fields);
    }

    /**
     * Handle the form submission for adding a new planet.
     * This function processes the form data, validates it, and inserts a new planet into the database.
     * It also handles errors and redirects the user accordingly.
     *
     * @return void
     */
    #[NoReturn] public function weltall_form_response(): void
    {
        global $wpdb;

        if (!current_user_can('manage_options')) {
            wp_die(__('Sie haben keine ausreichenden Berechtigungen, um diese Aktion auszuführen.', $this->plugin_name));
        }

        if (isset($_POST['weltall_nonce']) && wp_verify_nonce($_POST['weltall_nonce'], 'add_weltall_planet_nonce')) {

            $this->isValidateInput();

            if (!empty($this->error)) {
                $redirect_url = add_query_arg(
                    [
                        'page' => 'weltall-settings',
                        'weltall-error' => '1',
                        'error-messages' => base64_encode(json_encode($this->error)),
                        'error-fields' => base64_encode(json_encode($this->error_fields)),
                        'tab' => 'add-weltall-planet'
                    ],
                    admin_url('admin.php')
                );
                wp_redirect($redirect_url);
                exit;
            }

            list($name, $umfang_km, $entfernung_sonne, $zusatz) = $this->sanitizeInputFields();

            $result = $this->insertPlanetData($name, $umfang_km, $entfernung_sonne, $zusatz, $wpdb);

            if ($result) {
                wp_redirect(add_query_arg([
                    'page' => 'weltall-settings',
                    'weltall-added' => '1',
                    'tab' => 'add-weltall-planet'
                ], admin_url('admin.php')));
                exit;
            } else {
                wp_die(__('Fehler beim Hinzufügen des Planeten.', $this->plugin_name), __('Error', $this->plugin_name), [
                    'response' => 500,
                    'back_link' => 'admin.php?page=weltall-settings',
                ]);
            }

        } else {
            wp_die(__('Invalid nonce specified', $this->plugin_name), __('Error', $this->plugin_name), [
                'response' => 403,
                'back_link' => 'admin.php?page=weltall-settings',
            ]);
        }
    }

    /**
     * @return void
     */
    protected function isValidateInput(): void
    {
        $this->error = [];
        $this->error_fields = [];

        if (empty($_POST['name'])) {
            $this->error[] = __('Der Name ist erforderlich.', $this->plugin_name);
            $this->error_fields[] = 'name';
        }

        if (empty($_POST['umfang_km'])) {
            $this->error[] = __('Der Umfang ist erforderlich.', $this->plugin_name);
            $this->error_fields[] = 'umfang_km';
        } elseif (!is_numeric($_POST['umfang_km'])) {
            $this->error[] = __('Der Umfang muss eine Zahl sein.', $this->plugin_name);
            $this->error_fields[] = 'umfang_km';
        }

        if (empty($_POST['entfernung_sonne'])) {
            $this->error[] = __('Die Entfernung zur Sonne ist erforderlich.', $this->plugin_name);
            $this->error_fields[] = 'entfernung_sonne';
        }
    }

    /**
     * @return array
     */
    protected function sanitizeInputFields(): array
    {
        $name = sanitize_text_field($_POST['name'] ?? '');
        $umfang_km = sanitize_text_field($_POST['umfang_km'] ?? '0');
        $entfernung_sonne = sanitize_text_field($_POST['entfernung_sonne'] ?? '');
        $zusatz = sanitize_textarea_field($_POST['zusatz'] ?? '');

        return array($name, $umfang_km, $entfernung_sonne, $zusatz);
    }

    /**
     * @param mixed $name
     * @param mixed $umfang_km
     * @param mixed $entfernung_sonne
     * @param mixed $zusatz
     * @param wpdb $wpdb
     * @return bool|int|mysqli_result|null
     */
    protected function insertPlanetData(mixed $name, mixed $umfang_km, mixed $entfernung_sonne, mixed $zusatz, wpdb $wpdb): int|bool|null|mysqli_result
    {
        $weltall_planet = [
            'name' => $name,
            'umfang_km' => intval($umfang_km),
            'entfernung_sonne' => $entfernung_sonne,
            'zusatz' => $zusatz,
        ];

        $table_name = $wpdb->prefix . esc_sql('weltall');

        return $wpdb->insert(
            $table_name,
            $weltall_planet,
            ['%s', '%d', '%s', '%s']
        );
    }

    /**
     * Modify the redirect URL after settings are saved to preserve the active tab.
     *
     * @param string $location The redirect URL.
     * @param int $status The redirect status code.
     * @return string The modified redirect URL.
     */
    public function modify_settings_redirect(string $location, int $status): string
    {
        if (isset($_POST['option_page']) && $_POST['option_page'] === 'weltall_options_group') {

            $location = add_query_arg('tab', 'settings-show-weltall-limit', admin_url('admin.php?page=weltall-settings'));
        }

        return $location;
    }

}
