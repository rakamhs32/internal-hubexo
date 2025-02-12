<div class="content-panel yellow-bg <?php the_field('color_plum'); ?>">
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
                        $link = !empty($link_card['target']) ? $link_card['target'] : '_self';
                    ?>
                        <div class="card-content--item">
                            <h5 class="title-item <?php the_field('color_plum'); ?>"><?= esc_html($title_card); ?></h5>
                            <div class="homepage-banner--text conten-with--cards snug-child">
                                <p class="small-title"><?= ($content_card); ?></p>
                                <?php if (!empty($link)): ?>
                                    <a href="<?= esc_html($link); ?>" class="blueprint--button"> <?= esc_html($button_card); ?> <?php get_template_part('parts/svg/right-arrow'); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>