<?php
namespace Weltall\classes;
use Michelf\MarkdownExtra;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Database.
 * Handles all database operations for the Weltall plugin.
 */
class Database {

    /**
     * Instance of this class.
     *
     * @var Database
     */
    private static ?Database $instance = null;

    /**
     * Table name for planets.
     *
     * @var string
     */
    private string $table_name;

    /**
     * Get the singleton instance of this class.
     *
     * @return Database Instance of this class.
     */
    public static function get_instance(): Database
    {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Constructor.
     */
    protected function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'weltall';
    }

    /**
     * Create the database table for planets.
     */
    public function create_table(): void
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$this->table_name} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            umfang_km bigint(20) NOT NULL,
            entfernung_sonne varchar(255) NOT NULL,
            zusatz text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY name (name)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta( $sql );

        if ($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $this->table_name)) != $this->table_name) {
            wp_die(__('Fehler beim Erstellen der Datenbanktabelle für Weltall Plugin.', 'weltall'));
        }
    }

    /**
     * Drop the database table for planets.
     */
    public function drop_table(): void
    {
        global $wpdb;
        $table_name = esc_sql($this->table_name);
        $wpdb->query("DROP TABLE IF EXISTS `$table_name`");
    }


    /**
     * @return void
     *
     */
    public function truncate_table(): void
    {
        global $wpdb;
        $table_name = esc_sql($this->table_name);
        $wpdb->query("TRUNCATE TABLE `$table_name`");
    }

    /**
     * Get the latest planets from the database.
     *
     * @param int $limit Number of planets to retrieve.
     * @return array|object|null Array of planet objects.
     */
    public function get_latest_weltall_row(int $limit = 3): array|object|null
    {
        global $wpdb;
        $table_name = esc_sql($this->table_name);

        return $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM `$table_name` ORDER BY id DESC LIMIT %d",
                $limit
            )
        );
    }

    /**
     * Get the latest planets from the database with Markdown converted to HTML.
     *
     * @param int $limit Number of planets to retrieve.
     * @return array|object|null Array of planet objects with zusatz_html property.
     */
    public function get_latest_weltall(int $limit = 3): array|object|null
    {
        $planets = $this->get_latest_weltall_row($limit);

        if (empty($planets)) {
            return $planets;
        }

        foreach ($planets as &$planet) {
            $planet->zusatz_html = wp_kses_post($this->convert_markdown_to_html($planet->zusatz));

        }

        return $planets;
    }

    /**
     * Convert Markdown text to HTML.
     *
     * @param string $text Markdown text to convert.
     * @return string Converted HTML text.
     */
    private function convert_markdown_to_html(string $text): string
    {
        if (class_exists('\Michelf\MarkdownExtra')) {
            $parser = new MarkdownExtra();
            return $parser->transform($text);
        }

        return $text;
    }

    /**
     * Insert initial planet data into the database.
     * This method is called when the plugin is activated.
     * It checks if data already exists to avoid duplicate insertions.
     *
     * @return void
     */
    public function insert_weltall_data(): void
    {
        global $wpdb;

        $table_name = esc_sql($this->table_name);
        $count = $wpdb->get_var("SELECT COUNT(*) FROM `$table_name`");
        if ($count > 0) {
            return;
        }

        $weltalls = $this->getWeltalls();

        foreach ($weltalls as $weltall) {
            $wpdb->insert(
                $table_name,
                $weltall,
                array('%s', '%d', '%s', '%s')
            );
        }
    }

    /**
     * @return array[]
     */
    protected function getWeltalls(): array
    {
        return array(
            array(
                'name' => 'Mars',
                'umfang_km' => 21344,
                'entfernung_sonne' => '227,9 Millionen Kilometer',
                'zusatz' => "## Beschreibung \nÜber den Planeten gibt es **sehr** viel zu erzählen.<br />\n Aber wo fangen wir da an"
            ),
            array(
                'name' => 'Pluto',
                'umfang_km' => 7232,
                'entfernung_sonne' => '5,9 Milliarden Kilometer',
                'zusatz' => "## Beschreibung \nÜber den Planeten gibt es **sehr** viel zu erzählen.<br />\n Aber wo fangen wir da an"
            ),
            array(
                'name' => 'Saturn',
                'umfang_km' => 378675,
                'entfernung_sonne' => '1,43 Milliarden Kilometer',
                'zusatz' => "## Beschreibung \nÜber den Planeten gibt es **sehr** viel zu erzählen.<br />\n Aber wo fangen wir da an"
            ),
            array(
                'name' => 'Erde',
                'umfang_km' => 40075,
                'entfernung_sonne' => '149,6 Millionen Kilometer',
                'zusatz' => "## Beschreibung \nÜber den Planeten gibt es **sehr** viel zu erzählen.<br />\n Aber wo fangen wir da an"
            ),
            array(
                'name' => 'Dagobah',
                'umfang_km' => 8900,
                'entfernung_sonne' => '50,250 Lichtjahre',
                'zusatz' => "## Beschreibung \nÜber den Planeten gibt es **sehr** viel zu erzählen.<br />\n Aber wo fangen wir da an"
            )
        );
    }

}
