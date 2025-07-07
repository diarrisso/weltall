
<?php
/**
 * Footer template
 *
 * @package Mamadi
 */
?>
</div>
<footer class="footer">
    <div class="container">
        <div class="footer__menu">
            <?php
            if (has_nav_menu('mamadi-footer-menu')) {
                wp_nav_menu(array(
                    'theme_location' => 'mamadi-footer-menu',
                    'menu_class'     => 'footer-nav',
                    'container'      => 'nav',
                    'container_class' => 'footer-navigation',
                    'fallback_cb'    => false,
                ));
            }
            ?>
        </div>
        <div class="footer__bottom">
            <p>&copy; 2025 Masinga Tech</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
