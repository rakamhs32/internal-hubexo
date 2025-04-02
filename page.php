<?php
    get_template_part('parts/shared/html-header');
    get_template_part('parts/shared/header');
    $background = get_field('background_colours');
?>

<main class="<?= $background;?>-bg">
    <div class="flexible-content-panels">
        <?= the_content();?>
    </div>
    <?php get_template_part('parts/shared/footer');?>

</main>

<?php get_template_part('parts/shared/html-footer'); ?>