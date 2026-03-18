<?php
/**
 * Footer template
 */
?>

<!-- footer -->
<footer id="colophon" class="site-footer">
    <div id="footer">
        <div class="container">

            <div class="row text-center">

                <div class="col-12 footer-uno">
                    <a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo get_bloginfo('name'); ?>">
                        <img 
                            src="<?php echo wp_get_attachment_url(get_option('options_logotipo_blanco')); ?>" 
                            width="300" 
                            height="150" 
                            alt="<?php echo get_bloginfo('name'); ?>" 
                            class="logo-img normal"
                        >
                    </a>
                </div>

                <div class="col-12 footer-dos">
                    <?php wp_nav_menu( array(
                        'theme_location' => 'footer-menu',
                        'menu_class'     => 'menu-footer',
                        'container'      => false,
                        'fallback_cb'    => false
                    ) ); ?>
                </div>

            </div>

            <hr>

            <div id="copyright" class="row justify-content-between align-items-center">
                <div class="col-auto footer-logo">
                    <span class="copyright">
                        © <?php echo date('Y'); ?> – <?php bloginfo( 'name' ); ?>
                    </span>
                </div>

                <div class="col-auto wrapper-idento text-right">
                    <a class="firma-idento" href="https://www.idento.es" target="_blank" title="Idento"></a>
                </div>
            </div>

        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>