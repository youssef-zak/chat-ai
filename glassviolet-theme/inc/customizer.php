<?php
/**
 * Customizer additions
 */

function glassviolet_sanitize_checkbox( $checked ) {
    return ( isset( $checked ) && true === $checked );
}

function glassviolet_sanitize_float_range( $value ) {
    $value = floatval( $value );
    if ( $value < 0 ) {
        $value = 0;
    }
    if ( $value > 1 ) {
        $value = 1;
    }
    return $value;
}

function glassviolet_sanitize_blur( $value ) {
    $value = absint( $value );
    if ( $value > 60 ) {
        $value = 60;
    }
    return $value;
}

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

    $wp_customize->add_setting( 'glassviolet_accent_color', array(
        'default'           => '#f6edff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    foreach ( array( 'glassviolet_primary_color' => __( 'اللون الأساسي', 'glassviolet' ), 'glassviolet_secondary_color' => __( 'اللون الثانوي', 'glassviolet' ), 'glassviolet_accent_color' => __( 'لون الوهج/التفاصيل', 'glassviolet' ) ) as $setting => $label ) {
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting, array(
            'label'    => $label,
            'section'  => 'glassviolet_colors',
            'settings' => $setting,
        ) ) );
    }

    $wp_customize->add_section( 'glassviolet_surface', array(
        'title'       => __( 'الهوية البصرية', 'glassviolet' ),
        'priority'    => 31,
        'description' => __( 'تحكم بدرجات الخلفية وقوة الزجاج والتمويه.', 'glassviolet' ),
    ) );

    $wp_customize->add_setting( 'glassviolet_background_gradient_start', array(
        'default'           => '#f4f2ff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_setting( 'glassviolet_background_gradient_end', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'glassviolet_background_gradient_start', array(
        'label'   => __( 'لون الخلفية الأول', 'glassviolet' ),
        'section' => 'glassviolet_surface',
    ) ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'glassviolet_background_gradient_end', array(
        'label'   => __( 'لون الخلفية الثاني', 'glassviolet' ),
        'section' => 'glassviolet_surface',
    ) ) );

    $wp_customize->add_setting( 'glassviolet_glass_opacity', array(
        'default'           => 0.82,
        'sanitize_callback' => 'glassviolet_sanitize_float_range',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'glassviolet_glass_opacity', array(
        'label'       => __( 'شفافية الزجاج', 'glassviolet' ),
        'section'     => 'glassviolet_surface',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0.4,
            'max'  => 0.98,
            'step' => 0.02,
        ),
    ) );

    $wp_customize->add_setting( 'glassviolet_glass_blur', array(
        'default'           => 18,
        'sanitize_callback' => 'glassviolet_sanitize_blur',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'glassviolet_glass_blur', array(
        'label'       => __( 'قيمة التمويه (px)', 'glassviolet' ),
        'section'     => 'glassviolet_surface',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 60,
            'step' => 1,
        ),
    ) );

    $wp_customize->add_section( 'glassviolet_header', array(
        'title'       => __( 'خيارات الهيدر', 'glassviolet' ),
        'priority'    => 32,
        'description' => __( 'تحكم في الشعار، الشعار الفرعي، والزر العلوي.', 'glassviolet' ),
    ) );

    $wp_customize->add_setting( 'glassviolet_tagline', array(
        'default'           => __( 'تصميمات رقمية بلمسة زجاجية.', 'glassviolet' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'glassviolet_tagline', array(
        'label'   => __( 'وصف قصير', 'glassviolet' ),
        'section' => 'glassviolet_header',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'glassviolet_header_badge', array(
        'default'           => __( 'إطلاق جديد', 'glassviolet' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'glassviolet_header_badge', array(
        'label'   => __( 'شارة الهيدر', 'glassviolet' ),
        'section' => 'glassviolet_header',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'glassviolet_header_cta_label', array(
        'default'           => __( 'ابدأ رحلتك', 'glassviolet' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_setting( 'glassviolet_header_cta_link', array(
        'default'           => home_url( '/contact' ),
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'glassviolet_header_cta_label', array(
        'label'   => __( 'نص زر الهيدر', 'glassviolet' ),
        'section' => 'glassviolet_header',
        'type'    => 'text',
    ) );

    $wp_customize->add_control( 'glassviolet_header_cta_link', array(
        'label'   => __( 'رابط زر الهيدر', 'glassviolet' ),
        'section' => 'glassviolet_header',
        'type'    => 'url',
    ) );

    $wp_customize->add_setting( 'glassviolet_menu_label', array(
        'default'           => __( 'القائمة', 'glassviolet' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'glassviolet_menu_label', array(
        'label'   => __( 'نص زر القائمة', 'glassviolet' ),
        'section' => 'glassviolet_header',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'glassviolet_enable_sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'glassviolet_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'glassviolet_enable_sticky_header', array(
        'label'   => __( 'تثبيت الهيدر أثناء التمرير', 'glassviolet' ),
        'section' => 'glassviolet_header',
        'type'    => 'checkbox',
    ) );

    $wp_customize->add_section( 'glassviolet_cta', array(
        'title'       => __( 'الواجهة الرئيسية', 'glassviolet' ),
        'priority'    => 33,
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

    $wp_customize->add_setting( 'glassviolet_hero_button_text', array(
        'default'           => __( 'استكشف المدونة', 'glassviolet' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_setting( 'glassviolet_hero_button_link', array(
        'default'           => home_url( '/' ),
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'glassviolet_hero_button_text', array(
        'label'   => __( 'زر الواجهة', 'glassviolet' ),
        'section' => 'glassviolet_cta',
        'type'    => 'text',
    ) );

    $wp_customize->add_control( 'glassviolet_hero_button_link', array(
        'label'   => __( 'رابط زر الواجهة', 'glassviolet' ),
        'section' => 'glassviolet_cta',
        'type'    => 'url',
    ) );

    $wp_customize->add_section( 'glassviolet_footer_section', array(
        'title'       => __( 'تذييل الموقع', 'glassviolet' ),
        'priority'    => 34,
        'description' => __( 'نصوص وعبارات الدعوة في التذييل.', 'glassviolet' ),
    ) );

    $wp_customize->add_setting( 'glassviolet_footer_title', array(
        'default'           => __( 'انضم للنشرة البنفسجية', 'glassviolet' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'glassviolet_footer_title', array(
        'label'   => __( 'عنوان قسم التذييل', 'glassviolet' ),
        'section' => 'glassviolet_footer_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'glassviolet_footer_description', array(
        'default'           => __( 'أرسل بريدك لتحصل على أدلة التصميم والواجهات المتقدمة وأحدث تحديثات القالب.', 'glassviolet' ),
        'sanitize_callback' => 'wp_kses_post',
    ) );

    $wp_customize->add_control( 'glassviolet_footer_description', array(
        'label'   => __( 'وصف قسم التذييل', 'glassviolet' ),
        'section' => 'glassviolet_footer_section',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'glassviolet_footer_note', array(
        'default'           => __( 'موارد أسبوعية، بدون إزعاج.', 'glassviolet' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'glassviolet_footer_note', array(
        'label'   => __( 'ملاحظة سريعة', 'glassviolet' ),
        'section' => 'glassviolet_footer_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'glassviolet_footer_cta_label', array(
        'default'           => __( 'اشترك الآن', 'glassviolet' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_setting( 'glassviolet_footer_cta_placeholder', array(
        'default'           => 'you@example.com',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'glassviolet_footer_cta_label', array(
        'label'   => __( 'نص زر التذييل', 'glassviolet' ),
        'section' => 'glassviolet_footer_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_control( 'glassviolet_footer_cta_placeholder', array(
        'label'   => __( 'نص الحقل', 'glassviolet' ),
        'section' => 'glassviolet_footer_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'glassviolet_footer_text', array(
        'default'           => sprintf( __( '© %s GlassViolet. جميع الحقوق محفوظة.', 'glassviolet' ), date_i18n( 'Y' ) ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'glassviolet_footer_text', array(
        'label'   => __( 'نص الحقوق', 'glassviolet' ),
        'section' => 'glassviolet_footer_section',
        'type'    => 'text',
    ) );
}
add_action( 'customize_register', 'glassviolet_customize_register' );

function glassviolet_customizer_css() {
    $primary      = get_theme_mod( 'glassviolet_primary_color', '#8f70ff' );
    $secondary    = get_theme_mod( 'glassviolet_secondary_color', '#c8bfff' );
    $accent       = get_theme_mod( 'glassviolet_accent_color', '#f6edff' );
    $bg_start     = get_theme_mod( 'glassviolet_background_gradient_start', '#f4f2ff' );
    $bg_end       = get_theme_mod( 'glassviolet_background_gradient_end', '#ffffff' );
    $glass        = get_theme_mod( 'glassviolet_glass_opacity', 0.82 );
    $blur         = get_theme_mod( 'glassviolet_glass_blur', 18 );
    $custom_css   = sprintf(
        ':root{--gv-primary:%1$s;--gv-secondary:%2$s;--gv-accent:%3$s;--gv-bg:%4$s;--gv-bg-alt:%5$s;--gv-glass-opacity:%6$s;--gv-blur:%7$spx;}',
        esc_html( $primary ),
        esc_html( $secondary ),
        esc_html( $accent ),
        esc_html( $bg_start ),
        esc_html( $bg_end ),
        esc_html( $glass ),
        esc_html( $blur )
    );
    echo '<style type="text/css">' . $custom_css . '</style>';
}
add_action( 'wp_head', 'glassviolet_customizer_css' );
