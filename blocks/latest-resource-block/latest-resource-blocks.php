<?php
$title = get_field('title_section');

$selectCountry = get_field('select_country'); // Get the selected countries as an array
if ($selectCountry && is_array($selectCountry)) {
    $countries = implode(',', $selectCountry);
} else {
    $countries = '';
}
?>

<div class="content-panel no-bg" data-country="<?= esc_attr($countries) ?>">
    <div class="container">
        <div class="blog-post--grid-title">
            <h2 class="h5 snug"><?= $title ?></h2>
        </div>
        <div class="blog-post-grid sec-post-grid" id="posts-wrap">
            <?php if (have_rows('card_content')): ?>
                <?php while (have_rows('card_content')): the_row();
                    $cover_image = get_sub_field('cover_image');
                    $title = get_sub_field('title');
                    $date = get_sub_field('date');
                    $content = get_sub_field('content');
                    $url_button = get_sub_field('url_button');
                    $text_button = get_sub_field('text_button');
                ?>
                    <div class="blog-post-block fade-in">
                        <a href="<?= $url_button ?>" class="block-link">
                            <div class="image-wrap">
                                <img src="<?= $cover_image['url']; ?>" alt="<?= $cover_image['alt']; ?>">
                            </div>
                            <div class="blog-post-block--text">
                                <span class="blog-post-block--meta"><span><?= $date ?></span>
                                </span>
                                <h3 class="small-title--bold blog-post-block--title"><?= $title; ?></h3>
                                <div class="content-excerpt"><?= $content ?></div>
                            </div>
                            <button class="blueprint--button hover">
                                <?= $text_button; ?>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.62281 12L19.8828 12" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
                                    <path d="M16.4711 19.3846C16.4711 15.3231 19.4249 12 23.0352 12" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
                                    <path d="M16.4711 4.61719C16.4711 8.67873 19.4249 12.0018 23.0352 12.0018" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
                                </svg>
                            </button>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>