<div class="content-panel fpn-blocks yellow-bg" <?= getBlockId($block) ?>>
    <div class="container fpn-blocks">
        <h2><?= get_field('title'); ?></h2>
        <?php if (have_rows('fpn_blocks')): ?>
            <div class="fpn-blocks--grid">
                <?php while (have_rows('fpn_blocks')): the_row();
                    $icon_column = get_sub_field('icon_column');
                    $text_column = get_sub_field('text_column');
                    $url_column = get_sub_field('url_column');
                    $sub_text = get_sub_field('sub_text');
                    $description = get_sub_field('description');
                    $link_target = !empty($url_column['target']) ? $url_column['target'] : '_self';
                ?>
                    <div class="item-column">
                        <?php if (!empty($icon_column)): ?>
                            <div class="icon-item">
                                <img src="<?= esc_url($icon_column['url']); ?>"
                                     alt="<?= esc_attr($icon_column['alt']); ?>"
                                     title="<?= esc_attr($icon_column['title']); ?>">
                            </div>
                        <?php endif; ?>
                        <div class="item-content">
                            <?php if (!empty($url_column)): ?>
                                <a href="<?= esc_html($url_column); ?>"
                                   target="_blank">
                                    <?= esc_html($text_column); ?>
                                </a>
                            <?php else: ?>
                                <?= esc_html($text_column); ?>
                            <?php endif; ?>
                                 <a href="<?= esc_html($url_column); ?>"
                                   target="_blank">
                            <div class="hover-description">

                                <h6><?= esc_html($sub_text); ?></h6>

                                <p><?= esc_html($description); ?></p>
                            </div>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>