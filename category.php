<?php
    get_template_part('parts/shared/html-header');
    get_template_part('parts/shared/header');
?>

<main>
    <?php get_template_part('parts/news/banner'); ?>
    <?php get_template_part('parts/news/post-list'); ?>
    <?php get_template_part('parts/shared/cta-blocks'); ?>
    <?php get_template_part('parts/shared/footer');?>
</main>

<?php get_template_part('parts/shared/html-footer'); ?>