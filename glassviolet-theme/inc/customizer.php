<?php
/**
 * Customizer additions
 */

function glassviolet_customize_register( $wp_customize ) {
$wp_customize->add_section( 'glassviolet_colors', array(
'title'       => __( 'ألوان القالب', 'glassviolet' ),
'priority'    => 30,
'description' => __( 'تحكم في الألوان البنفسجية والزجاجية للقالب.', 'glassviolet' ),
) );

$wp_customize->add_setting( 'glassviolet_primary_color', array(
'default'           => '#8f70ff',
'sanitize_callback' => 'sanitize_hex_color',
'transport'         => 'postMessage',
) );

$wp_customize->add_setting( 'glassviolet_secondary_color', array(
'default'           => '#c8bfff',
'sanitize_callback' => 'sanitize_hex_color',
'transport'         => 'postMessage',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'glassviolet_primary_color', array(
'label'    => __( 'اللون الأساسي', 'glassviolet' ),
'section'  => 'glassviolet_colors',
'settings' => 'glassviolet_primary_color',
) ) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'glassviolet_secondary_color', array(
'label'    => __( 'اللون الثانوي', 'glassviolet' ),
'section'  => 'glassviolet_colors',
'settings' => 'glassviolet_secondary_color',
) ) );

$wp_customize->add_section( 'glassviolet_cta', array(
'title'       => __( 'الواجهة الرئيسية', 'glassviolet' ),
'priority'    => 31,
'description' => __( 'تخصيص النصوص الرئيسية للواجهة.', 'glassviolet' ),
) );

$wp_customize->add_setting( 'glassviolet_hero_title', array(
'default'           => __( 'تصميم زجاجي مذهل لموقعك', 'glassviolet' ),
'sanitize_callback' => 'sanitize_text_field',
'transport'         => 'postMessage',
) );

$wp_customize->add_control( 'glassviolet_hero_title', array(
'label'   => __( 'عنوان الواجهة', 'glassviolet' ),
'section' => 'glassviolet_cta',
'type'    => 'text',
) );

$wp_customize->add_setting( 'glassviolet_hero_text', array(
'default'           => __( 'قالب ووردبريس متكامل يدعم المنتور وجميع خصائص النظام مع واجهة عصرية.', 'glassviolet' ),
'sanitize_callback' => 'wp_kses_post',
'transport'         => 'postMessage',
) );

$wp_customize->add_control( 'glassviolet_hero_text', array(
'label'   => __( 'وصف الواجهة', 'glassviolet' ),
'section' => 'glassviolet_cta',
'type'    => 'textarea',
) );
}
add_action( 'customize_register', 'glassviolet_customize_register' );

function glassviolet_customizer_css() {
$primary   = get_theme_mod( 'glassviolet_primary_color', '#8f70ff' );
$secondary = get_theme_mod( 'glassviolet_secondary_color', '#c8bfff' );
echo '<style type="text/css">:root{--gv-primary:' . esc_html( $primary ) . ';--gv-secondary:' . esc_html( $secondary ) . ';}</style>';
}
add_action( 'wp_head', 'glassviolet_customizer_css' );
