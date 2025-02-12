<?php

$socialLinks = get_field('links', 'options');

?>

<footer class="site-footer">
    <div class="container">
        <div class="site-footer--logos">
            <div class="site-footer--logo">
                <?php get_template_part('parts/svg/footer-logo'); ?>
            </div>
            <nav class="site-footer--social">
                <?php if (!empty($socialLinks)): ?>
                    <ul>
                        <?php foreach ($socialLinks as $socialLink):
                            $link = $socialLink['link'];
                            $link_target = $link['target'] ? $link['target'] : '_self';
                            $icon = $socialLink['icon'];
                        ?>
                            <li>
                                <a href="<?= $link['url']; ?>" target="_blank">
                                    <span class="sr-only"><?= $link['title']; ?></span>
                                    <?= $icon; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </nav>
        </div>
        <div class="site-footer--grid">
            <nav class="footer-nav">
                <?php wp_nav_menu(["theme_location" => "footer"]) ?>
            </nav>
            <span>&copy; Hubexo, <?= date("Y"); ?></span>
        </div>
    </div>
    <svg class="pattern-a is-yellow">
        <g></g>
    </svg>
</footer>