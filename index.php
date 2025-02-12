<?php
get_template_part('parts/shared/html-header');
get_template_part('parts/shared/header');
$postID = get_option('page_for_posts');
$content = apply_filters('the_content', get_post_field('post_content', $postID));

?>

<main class="aluminium-bg">
    <div class="flexible-content-panels">
        <div class="title-banner header-pad">
            <div class="container fade-up">
                <h1 class="h2 snug "><?= get_the_title($postID); ?></h1>
            </div>
        </div>
        <?= $content; ?>
        <?php // get_template_part('parts/news/post-list'); 
        ?>
    </div>
    <?php get_template_part('parts/shared/footer'); ?>
</main>

<?php get_template_part('parts/shared/html-footer'); ?>