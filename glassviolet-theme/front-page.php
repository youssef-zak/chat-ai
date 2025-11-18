<?php get_header(); ?>
<section class="hero">
<div class="hero-card gv-glass animation-fade">
<h1><?php echo esc_html( get_theme_mod( 'glassviolet_hero_title', __( 'تصميم زجاجي مذهل لموقعك', 'glassviolet' ) ) ); ?></h1>
<p><?php echo wp_kses_post( get_theme_mod( 'glassviolet_hero_text', __( 'قالب ووردبريس متكامل يدعم المنتور وجميع خصائص النظام مع واجهة عصرية.', 'glassviolet' ) ) ); ?></p>
<a class="gv-button" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'استكشف المدونة', 'glassviolet' ); ?></a>
</div>
<div class="hero-visual gv-glass animation-fade" data-delay="150">
<?php if ( has_post_thumbnail() ) : ?>
<?php the_post_thumbnail( 'large' ); ?>
<?php else : ?>
<div class="placeholder">
<svg viewBox="0 0 200 200" width="100%" height="100%">
<defs>
<linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
<stop offset="0%" stop-color="var(--gv-primary)" />
<stop offset="100%" stop-color="var(--gv-secondary)" />
</linearGradient>
</defs>
<circle cx="100" cy="100" r="80" fill="url(#grad)" opacity="0.6"></circle>
</svg>
</div>
<?php endif; ?>
</div>
</section>
<section class="section animation-fade" id="services">
<h2 class="section-title"><?php esc_html_e( 'الخدمات والمميزات', 'glassviolet' ); ?></h2>
<div class="cards-grid">
<?php
$features = array(
array( 'title' => __( 'تكامل مع المنتور', 'glassviolet' ), 'text' => __( 'تحكم كامل بتخطيط الصفحات من خلال Elementor ومكتبة عناصر جاهزة.', 'glassviolet' ) ),
array( 'title' => __( 'أداء وسرعة', 'glassviolet' ), 'text' => __( 'الاعتماد على كود نظيف وخفيف يضمن سرعة تحميل عالية وتحسين SEO.', 'glassviolet' ) ),
array( 'title' => __( 'مرونة التخصيص', 'glassviolet' ), 'text' => __( 'خيارات ألوان وخطوط وحركات تفاعلية قابلة للضبط من أداة التخصيص.', 'glassviolet' ) ),
array( 'title' => __( 'تكامل مع واجهات برمجية', 'glassviolet' ), 'text' => __( 'نقطة نهاية REST مدمجة لعرض بيانات الواجهة في تطبيقات خارجية.', 'glassviolet' ) ),
);
foreach ( $features as $feature ) :
?>
<article class="card gv-glass">
<h3><?php echo esc_html( $feature['title'] ); ?></h3>
<p><?php echo esc_html( $feature['text'] ); ?></p>
</article>
<?php endforeach; ?>
</div>
</section>
<section class="section animation-fade" id="latest-posts">
<h2 class="section-title"><?php esc_html_e( 'أحدث المقالات', 'glassviolet' ); ?></h2>
<div class="cards-grid">
<?php
$latest = new WP_Query( array( 'posts_per_page' => 3 ) );
if ( $latest->have_posts() ) :
while ( $latest->have_posts() ) :
$latest->the_post();
get_template_part( 'template-parts/content', get_post_type() );
endwhile;
wp_reset_postdata();
else :
printf( '<p>%s</p>', esc_html__( 'لا توجد مقالات بعد، ابدأ بكتابة قصتك.', 'glassviolet' ) );
endif;
?>
</div>
</section>
<?php get_footer(); ?>
