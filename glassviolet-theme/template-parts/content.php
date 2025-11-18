<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card gv-glass' ); ?>>
<header class="entry-header">
<?php if ( is_singular() ) : ?>
<h1 class="entry-title"><?php the_title(); ?></h1>
<?php else : ?>
<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php endif; ?>
<p class="entry-meta">
<?php esc_html_e( 'بواسطة', 'glassviolet' ); ?> <?php the_author_posts_link(); ?>
<span>•</span>
<?php echo esc_html( get_the_date() ); ?>
</p>
</header>
<div class="entry-content">
<?php if ( is_singular() ) : ?>
<?php the_content(); ?>
<?php else : ?>
<?php the_excerpt(); ?>
<?php endif; ?>
</div>
<footer class="entry-footer">
<?php the_tags( '<span class="tags">', ' ', '</span>' ); ?>
</footer>
</article>
