<?php
$storyImage = acf_get_attachment(get_post_thumbnail_id($post->ID));

$location = wp_get_post_terms($post->ID, 'location');
$locations = false;
if (!empty($location) && !is_wp_error($location)) {
    $locations = implode(", ", array_map(function ($loc) {
        return $loc->name;
    }, $location));
}


?>
<div class="blog-post-block fade-in">
    <a href="<?= the_permalink(); ?>" class="block-link">
        <div class="image-wrap">
            <?php get_template_part("parts/image/medium", null, ['image' => $storyImage]) ?>
        </div>
        <div class="blog-post-block--text">
            <span class="blog-post-block--meta"><span><?php the_time('j M Y'); ?></span><?php if ($locations): ?><span class="blog-post-block--meta-locations"><?= $locations ?></span><?php endif ?></span>
            <h3 class="small-title--bold blog-post-block--title"><?= the_title(); ?></h3>
        </div>
        <button class="blueprint--button hover">
            Read more
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.62281 12L19.8828 12" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
                <path d="M16.4711 19.3846C16.4711 15.3231 19.4249 12 23.0352 12" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
                <path d="M16.4711 4.61719C16.4711 8.67873 19.4249 12.0018 23.0352 12.0018" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
            </svg>
        </button>
    </a>
    <?php // the_category(); 
    ?>
</div>