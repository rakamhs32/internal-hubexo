<?php
    get_template_part('parts/shared/html-header');
    get_template_part('parts/shared/header');
?>

<main>

    <?php 
        get_template_part('parts/error-404/content');
        get_template_part('parts/shared/footer'); 
    ?>

</main>

<?php get_template_part('parts/shared/html-footer'); ?>