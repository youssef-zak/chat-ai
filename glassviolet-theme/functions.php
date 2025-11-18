<?php
/**
 * GlassViolet Theme functions and definitions
 */

define( 'GLASSVIOLET_VERSION', '1.0.0' );

if ( ! function_exists( 'glassviolet_setup' ) ) {
function glassviolet_setup() {
load_theme_textdomain( 'glassviolet', get_template_directory() . '/languages' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
register_nav_menus( array(
'primary' => __( 'Primary Menu', 'glassviolet' ),
'footer'  => __( 'Footer Menu', 'glassviolet' ),
) );
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
add_theme_support( 'custom-logo', array( 'height' => 60, 'flex-height' => true ) );
add_theme_support( 'custom-background', array( 'default-color' => 'f4f2ff' ) );
add_theme_support( 'editor-styles' );
add_editor_style( 'style.css' );
add_theme_support( 'responsive-embeds' );
}
}
add_action( 'after_setup_theme', 'glassviolet_setup' );

function glassviolet_content_width() {
$GLOBALS['content_width'] = 800;
}
add_action( 'after_setup_theme', 'glassviolet_content_width', 0 );

function glassviolet_scripts() {
wp_enqueue_style( 'glassviolet-fonts', 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap', array(), null );
wp_enqueue_style( 'glassviolet-style', get_stylesheet_uri(), array( 'glassviolet-fonts' ), GLASSVIOLET_VERSION );
wp_enqueue_script( 'glassviolet-theme', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery' ), GLASSVIOLET_VERSION, true );
$customizer_data = array(
'primaryColor'   => get_theme_mod( 'glassviolet_primary_color', '#8f70ff' ),
'secondaryColor' => get_theme_mod( 'glassviolet_secondary_color', '#c8bfff' ),
);
wp_localize_script( 'glassviolet-theme', 'glassvioletOptions', $customizer_data );
}
add_action( 'wp_enqueue_scripts', 'glassviolet_scripts' );

function glassviolet_widgets_init() {
register_sidebar( array(
'name'          => __( 'Sidebar', 'glassviolet' ),
'id'            => 'sidebar-1',
'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'glassviolet' ),
'before_widget' => '<section id="%1$s" class="widget %2$s gv-glass">',
'after_widget'  => '</section>',
'before_title'  => '<h2 class="widget-title">',
'after_title'   => '</h2>',
) );
}
add_action( 'widgets_init', 'glassviolet_widgets_init' );

require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/api.php';

function glassviolet_body_classes( $classes ) {
if ( is_customize_preview() ) {
$classes[] = 'customizer-preview';
}
return $classes;
}
add_filter( 'body_class', 'glassviolet_body_classes' );

function glassviolet_register_elementor_locations( $elementor_theme_manager ) {
if ( class_exists( '\\Elementor\\Theme\\Locations_Manager' ) ) {
$elementor_theme_manager->register_all_core_location();
}
}
add_action( 'elementor/theme/register_locations', 'glassviolet_register_elementor_locations' );

function glassviolet_register_block_styles() {
if ( function_exists( 'register_block_style' ) ) {
register_block_style( 'core/cover', array(
'name'  => 'glass-layer',
'label' => __( 'Glass Layer', 'glassviolet' ),
'inline_style' => '.wp-block-cover.is-style-glass-layer{background:rgba(255,255,255,0.25);backdrop-filter:blur(12px);border-radius:24px;}',
) );
}
}
add_action( 'init', 'glassviolet_register_block_styles' );
