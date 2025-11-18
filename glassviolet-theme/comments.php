<?php
if ( post_password_required() ) {
return;
}
?>
<div id="comments" class="comments-area gv-glass">
<?php if ( have_comments() ) : ?>
<h2 class="comments-title"><?php esc_html_e( 'التعليقات', 'glassviolet' ); ?></h2>
<ol class="comment-list">
<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true ) ); ?>
</ol>
<?php the_comments_navigation(); ?>
<?php endif; ?>

<?php if ( comments_open() ) : ?>
<?php comment_form(); ?>
<?php endif; ?>
</div>
