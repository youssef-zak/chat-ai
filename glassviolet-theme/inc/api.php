<?php
/**
 * Simple REST endpoints to expose theme data
 */

function glassviolet_register_api_routes() {
register_rest_route( 'glassviolet/v1', '/hero', array(
'methods'             => 'GET',
'permission_callback' => '__return_true',
'callback'            => 'glassviolet_get_hero_data',
) );
}
add_action( 'rest_api_init', 'glassviolet_register_api_routes' );

function glassviolet_get_hero_data() {
return array(
'title'       => get_theme_mod( 'glassviolet_hero_title', __( 'تصميم زجاجي مذهل لموقعك', 'glassviolet' ) ),
'description' => wpautop( get_theme_mod( 'glassviolet_hero_text', __( 'قالب ووردبريس متكامل يدعم المنتور وجميع خصائص النظام مع واجهة عصرية.', 'glassviolet' ) ) ),
'primary'     => get_theme_mod( 'glassviolet_primary_color', '#8f70ff' ),
'secondary'   => get_theme_mod( 'glassviolet_secondary_color', '#c8bfff' ),
);
}
