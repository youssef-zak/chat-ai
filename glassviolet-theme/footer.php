<?php
$footer_title        = get_theme_mod( 'glassviolet_footer_title', __( 'انضم للنشرة البنفسجية', 'glassviolet' ) );
$footer_description  = get_theme_mod( 'glassviolet_footer_description', __( 'أرسل بريدك لتحصل على أدلة التصميم والواجهات المتقدمة وأحدث تحديثات القالب.', 'glassviolet' ) );
$footer_note         = get_theme_mod( 'glassviolet_footer_note', __( 'موارد أسبوعية، بدون إزعاج.', 'glassviolet' ) );
$footer_text         = get_theme_mod( 'glassviolet_footer_text', sprintf( __( '© %1$s %2$s. جميع الحقوق محفوظة.', 'glassviolet' ), date_i18n( 'Y' ), get_bloginfo( 'name' ) ) );
$footer_cta_label    = get_theme_mod( 'glassviolet_footer_cta_label', __( 'اشترك الآن', 'glassviolet' ) );
$footer_placeholder  = get_theme_mod( 'glassviolet_footer_cta_placeholder', 'you@example.com' );
?>
<footer class="site-footer">
    <div class="footer-gradient" aria-hidden="true"></div>
    <div class="footer-grid">
        <section class="footer-brand gv-glass">
            <h3><?php bloginfo( 'name' ); ?></h3>
            <p><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
            <ul class="footer-note-list">
                <li><?php echo esc_html( $footer_note ); ?></li>
                <li><?php esc_html_e( 'دعم كامل للمنتور ووردبريس', 'glassviolet' ); ?></li>
            </ul>
        </section>
        <section class="footer-links gv-glass">
            <h3><?php esc_html_e( 'روابط سريعة', 'glassviolet' ); ?></h3>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'container'      => false,
                'menu_class'     => 'footer-menu',
                'fallback_cb'    => '__return_false',
            ) );
            ?>
        </section>
        <section class="footer-newsletter gv-glass">
            <h3><?php echo esc_html( $footer_title ); ?></h3>
            <p><?php echo esc_html( $footer_description ); ?></p>
            <form class="newsletter" action="#" method="post">
                <label class="screen-reader-text" for="newsletter-email"><?php esc_html_e( 'البريد الإلكتروني', 'glassviolet' ); ?></label>
                <input type="email" id="newsletter-email" name="newsletter-email" placeholder="<?php echo esc_attr( $footer_placeholder ); ?>" required>
                <button class="gv-button" type="submit"><?php echo esc_html( $footer_cta_label ); ?></button>
            </form>
        </section>
    </div>
    <div class="footer-bottom">
        <p><?php echo esc_html( $footer_text ); ?></p>
        <div class="footer-badges">
            <span><?php esc_html_e( 'آمن وسريع', 'glassviolet' ); ?></span>
            <span><?php esc_html_e( 'تصميم عصري', 'glassviolet' ); ?></span>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
