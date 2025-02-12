<?php
$related = get_posts(array(
    //'category__in' => wp_get_post_categories($post->ID), 
    'numberposts' => 3, 
    'post__not_in' => array($post->ID)));
?>

<div class="content-panel no-bg related-posts">
    <div class="container">
    <h3 class="snug fade-in">You may also be interested in...</h3>
    <div class="blog-post-grid">
        <?php foreach ($related as $post) {
            setup_postdata($post); ?>
            <?php get_template_part('parts/news/news-post-block'); ?>
        <?php }
        wp_reset_postdata(); ?>

        </div>
    </div>
</div>