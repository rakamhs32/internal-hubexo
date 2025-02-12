<?php

$testimonials = get_field('testimonials');

?>

<div class="content-panel testimonials white-text plum-bg">
    <div class="container text-center fade-in">
        <?php get_template_part('parts/svg/mic'); ?>
        <?php if (!empty($testimonials)): ?>
            <div class="splide testimonials-slider">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php foreach ($testimonials as $testimonial): ?>
                            <li class="splide__slide">
                                <blockquote>
                                    <p class="h5 snug"><?= $testimonial['testimonial']; ?></p>
                                    <cite><?= $testimonial['name']; ?></cite>
                                </blockquote>
                                <?php if ($testimonial['image'] ?? false): ?>
                                    <div class="testimonial-image">
                                        <img src="<?= $testimonial['image']['sizes']['mobile']; ?>" alt="<?= $testimonial['image']['alt']; ?>">
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>