<?php get_header(); ?>
<main class="section">
<?php while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
<?php comments_template(); ?>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
