<?php
    $image = get_field('image');
    $title = get_field('title');
    $content = get_field('content');
    $link = get_field('link');
    if(!empty($link)){
        $link_target = $link['target'] ? $link['target'] : '_self';
    }

?>

<div class="content-panel yellow-bg image-cta">
    <?php get_template_part('parts/svg/cta-mask-desktop');?>
    <div class="image-cta--image-wrap">
        <?php if(!empty($image)):?>
            <picture>
                <source
                    srcset="<?= $image['sizes']['mobile'];?>"
                    media="(max-width: 500px)" >
                <source
                    srcset="<?= $image['sizes']['large'];?>" >
                <img
                    src="<?= $image['sizes']['large'];?>"
                    loading="lazy"
                    alt="<?= $image['alt'];?>"
                    >
            </picture>
        <?php endif;?>
        <?php get_template_part('parts/svg/cta-mask-mobile');?>
    </div>
    <div class="container snug-child">
        <div class="image-cta--text snug-child fade-in">
            <h3><?= get_field('title');?></h3>
            <div><?= get_field('content');?></div>
            <?php if(!empty($link)):?>
                <p>
                    <a href="<?= $link['url'];?>" target="<?= esc_attr( $link_target ); ?>" class="blueprint--button is-plum">
                        <?= $link['title'];?> <?php get_template_part('parts/svg/right-arrow');?>
                    </a>
                </p>
            <?php endif;?>
        </div>
    </div>
</div>