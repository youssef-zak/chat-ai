<footer class="site-footer">
<div class="footer-grid">
<section>
<h3><?php esc_html_e( 'حول القالب', 'glassviolet' ); ?></h3>
<p><?php esc_html_e( 'قالب زجاجي متكامل يدعم أحدث تقنيات ووردبريس والمنتور مع واجهات قابلة للتخصيص.', 'glassviolet' ); ?></p>
</section>
<section>
<h3><?php esc_html_e( 'روابط سريعة', 'glassviolet' ); ?></h3>
<?php
wp_nav_menu( array(
'theme_location' => 'footer',
'container'      => false,
'menu_class'     => 'footer-menu',
) );
?>
</section>
<section>
<h3><?php esc_html_e( 'اشترك في النشرة', 'glassviolet' ); ?></h3>
<form class="newsletter" action="#" method="post">
<label class="screen-reader-text" for="newsletter-email"><?php esc_html_e( 'البريد الإلكتروني', 'glassviolet' ); ?></label>
<input type="email" id="newsletter-email" placeholder="you@example.com" required>
<button class="gv-button" type="submit"><?php esc_html_e( 'اشترك الآن', 'glassviolet' ); ?></button>
</form>
</section>
</div>
<p class="copyright">&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.</p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
