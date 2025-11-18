<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header gv-glass">
<div class="site-branding">
<?php if ( has_custom_logo() ) : ?>
<?php the_custom_logo(); ?>
<?php endif; ?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title"><?php bloginfo( 'name' ); ?></a>
<p class="site-description"><?php bloginfo( 'description' ); ?></p>
</div>
<nav class="site-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'glassviolet' ); ?>">
<?php
wp_nav_menu( array(
'theme_location' => 'primary',
'container'      => false,
'menu_class'     => 'menu',
'fallback_cb'    => '__return_false',
) );
?>
</nav>
<button class="gv-button" id="gv-toggle-menu" aria-label="<?php esc_attr_e( 'Toggle menu', 'glassviolet' ); ?>">
<span>&#9776;</span>
</button>
</header>
