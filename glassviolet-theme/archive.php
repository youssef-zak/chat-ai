<?php get_header(); ?>
<main class="section">
<header class="archive-header gv-glass">
<h1 class="section-title"><?php the_archive_title(); ?></h1>
<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
</header>
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
<?php endwhile; ?>
<?php the_posts_pagination(); ?>
<?php else : ?>
<p><?php esc_html_e( 'لا يوجد محتوى لهذه الأرشيف.', 'glassviolet' ); ?></p>
<?php endif; ?>
</main>
<?php get_footer(); ?>
