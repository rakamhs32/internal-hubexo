<?php

$selectCountry = get_field('select_country'); // Get the selected countries as an array
if ($selectCountry && is_array($selectCountry)) {
    $countries = implode(',', $selectCountry);
} else {
    $countries = '';
}

?>

<div class="content-panel yellow-bg <?php the_field('color_plum'); ?>" data-country="<?= esc_attr($countries) ?>">
    <div class="container">
        <div class="content-block--cards">
            <h3 class="title-content <?php the_field('color_plum'); ?>"><?= get_field('title'); ?></h3>
            <div class="text-area--content <?php the_field('color_plum'); ?>">
                <?= get_field('text'); ?>
            </div>
            <div class="card-button--with-column">
                <?php if (have_rows('content_cards')): ?>
                    <?php while (have_rows('content_cards')): the_row();
                        $title_card = get_sub_field('title_card');
                        $content_card = get_sub_field('content_card');
                        $button_card = get_sub_field('button_card');
                        $link_card = get_sub_field('link_card');
                        ?>
                        <div class="card-content--item">
                            <h5 class="title-item <?php the_field('color_plum'); ?>"><?= esc_html($title_card); ?></h5>
                            <div class="homepage-banner--text conten-with--cards snug-child">
                                <p class="small-title"><?= ($content_card); ?></p>
                                <?php if (!empty($link_card)): ?>
                                    <a href="<?php echo esc_url($link_card); ?>" class="blueprint--button">
                                        <?php echo esc_html($button_card); ?>
                                        <?php get_template_part('parts/svg/right-arrow'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>