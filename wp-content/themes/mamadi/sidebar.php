<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Mamadi
 */
?>
<aside>
    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    <?php else : ?>
        <div>
            <h2><?php esc_html_e( 'Search', 'mamadi' ); ?></h2>
            <?php get_search_form(); ?>
        </div>

        <div>
            <h2><?php esc_html_e( 'Recent Posts', 'mamadi' ); ?></h2>
            <ul>
                <?php
                $recent_posts = wp_get_recent_posts(array(
                    'number posts' => 5,
                    'post_status' => 'publish'
                ));
                foreach ($recent_posts as $post) {
                    echo '<li><a href="' . get_permalink($post['ID']) . '">' . $post['post_title'] . '</a></li>';
                }
                ?>
            </ul>
        </div>
    <?php endif; ?>
</aside>
