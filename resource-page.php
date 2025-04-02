<?php /* Template Name: Resource */ ?>

<?php
get_template_part('parts/shared/html-header');
get_template_part('parts/shared/header');
?>

<main class="aluminium-bg">
    <div class="flexible-content-panels">
        <div class="header-pad-two">
            <div class="container fade-up">
                <div class="title-page--custom">
                    <h1 class="h2 snug "><?= get_the_title(); ?></h1>
                </div>
            </div>
            <div class="fade-up">
                <?= the_content();?>
            </div>
        </div>
    </div>
    <?php get_template_part('parts/shared/float-btn'); ?>
    <?php get_template_part('parts/shared/footer'); ?>
</main>

<?php get_template_part('parts/shared/html-footer'); ?>