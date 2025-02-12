

<?php
    /* Template Name: Single column */
    get_template_part('parts/shared/html-header');
    get_template_part('parts/shared/header');
    $background = get_field('background_colours');
?>

<main class="<?= $background;?>-bg">
    <div class="flexible-content-panels">
        <div class="header-pad single-post-banner">
            <div class="container">
                <h1 class="h4 snug"><?= the_title();?></h1>
            </div>
        </div>
        <div class="blog-content content-panel">
            <div class="container">
                <article class="single-post--content snug-child wysiwyg">
                    <?= the_content(); ?>
                </article>
            </div>
        </div>
    </div>
    <?php get_template_part('parts/shared/footer');?>

</main>

<?php get_template_part('parts/shared/html-footer'); ?>