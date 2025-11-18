<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
$tagline     = get_theme_mod( 'glassviolet_tagline', get_bloginfo( 'description' ) );
$badge       = get_theme_mod( 'glassviolet_header_badge', __( 'إطلاق جديد', 'glassviolet' ) );
$cta_label   = get_theme_mod( 'glassviolet_header_cta_label', __( 'ابدأ رحلتك', 'glassviolet' ) );
$cta_link    = get_theme_mod( 'glassviolet_header_cta_link', home_url( '/contact' ) );
$menu_label  = get_theme_mod( 'glassviolet_menu_label', __( 'القائمة', 'glassviolet' ) );
$is_sticky   = get_theme_mod( 'glassviolet_enable_sticky_header', true );
?>
<header class="site-header <?php echo $is_sticky ? 'is-sticky' : 'is-static'; ?>">
    <div class="header-inner">
        <div class="site-branding">
            <div class="brand-logo">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <span class="fallback-logo" aria-hidden="true">GV</span>
                <?php endif; ?>
            </div>
            <div class="brand-copy">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title"><?php bloginfo( 'name' ); ?></a>
                <?php if ( $tagline ) : ?>
                    <p class="site-description"><?php echo esc_html( $tagline ); ?></p>
                <?php endif; ?>
                <?php if ( $badge ) : ?>
                    <span class="header-badge"><?php echo esc_html( $badge ); ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="header-actions">
            <?php if ( $cta_label && $cta_link ) : ?>
                <a class="gv-button header-cta" href="<?php echo esc_url( $cta_link ); ?>">
                    <span><?php echo esc_html( $cta_label ); ?></span>
                </a>
            <?php endif; ?>
            <button class="menu-toggle" id="gv-toggle-menu" aria-expanded="false" aria-controls="gv-primary-menu">
                <span class="menu-toggle-box" aria-hidden="true">
                    <span class="menu-line"></span>
                    <span class="menu-line"></span>
                    <span class="menu-line"></span>
                </span>
                <span class="menu-toggle-label"><?php echo esc_html( $menu_label ); ?></span>
            </button>
        </div>
    </div>
    <nav class="site-navigation" id="gv-primary-menu" aria-label="<?php esc_attr_e( 'القائمة الرئيسية', 'glassviolet' ); ?>">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'menu primary-menu',
            'menu_id'        => 'gv-primary-menu-list',
            'fallback_cb'    => '__return_false',
        ) );
        ?>
        <?php if ( $cta_label && $cta_link ) : ?>
            <div class="nav-cta-mobile">
                <a class="gv-button is-full" href="<?php echo esc_url( $cta_link ); ?>"><?php echo esc_html( $cta_label ); ?></a>
            </div>
        <?php endif; ?>
    </nav>
    <div class="menu-overlay" id="gv-menu-overlay" aria-hidden="true"></div>
</header>
