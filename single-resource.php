<?php
    get_template_part('parts/shared/html-header');
    get_template_part('parts/shared/header');
    $background = get_field('background_colours');
?>

<main class="<?= $background;?>-bg">
    <div class="flexible-content">
        <?php
            get_template_part('parts/news/single/banner');
            get_template_part('parts/news/single/content');
            get_template_part('parts/news/single/pagination');
        ?>
    </div>
	<?php get_template_part('parts/shared/footer');?>

</main>

<?php get_template_part('parts/shared/html-footer'); ?>