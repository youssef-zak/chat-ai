<?php get_header(); ?>
<main class="section">
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
<?php endwhile; ?>
<?php the_posts_pagination(); ?>
<?php else : ?>
<p><?php esc_html_e( 'لم يتم العثور على محتوى.', 'glassviolet' ); ?></p>
<?php endif; ?>
</main>
<?php get_footer(); ?>
