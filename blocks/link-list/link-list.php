<?php

$listItems = get_field('links');
$title = get_field('title');

?>

<div class="content-panel link-list white-text plum-bg fade-in-stagger">
    <?php if (!empty($title)): ?>
        <div class="container fade-in">
            <h2 class="h5 snug"><?= $title ?></h2>
        </div>
    <?php endif; ?>
    <div class="container">
        <ul>
            <?php $i = 1;
            foreach ($listItems as $n => $listItem):
                $link = $listItem['link'];
                if (!empty($link)) {
                    $link_target = $link['target'] ? $link['target'] : '_self';
                }
                $title = $listItem['title'];
            ?>
                <li style="--n: <?= $n ?>">
                    <div class="container">
                        <?php if (!empty($link)): ?>
                            <a href="<?= $link['url']; ?>" target="<?= esc_attr($link_target); ?>">
                                <span class="h2 snug link-list--title"><?= $link['title']; ?></span>
                            <?php else: ?>
                                <div class="no-link">
                                    <span class="h2 snug link-list--title"><?= $title; ?></span>
                                <?php endif; ?>
                                <?php if (! empty($link)): ?>
                                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" class="link-list--arrow">
                                        <rect width="60" height="60" rx="30" fill="#DCFF3C" />
                                        <path d="M40.5579 26.481L26.4824 40.5564" stroke="#321432" stroke-width="9.95285" stroke-miterlimit="10" />
                                        <path d="M26.4761 19.4435L40.5516 33.519" stroke="#321432" stroke-width="9.95285" stroke-miterlimit="10" />
                                    </svg>
                                <?php endif; ?>
                                <div class="link-list--overlay">
                                    <svg class="pattern-a is-on-grey flipped">
                                        <g></g>
                                    </svg>
                                    <div class="container">
                                        <h3 class="h6 snug"><?= $listItem['overlay_title']; ?></h3>
                                        <p><?= $listItem['overlay_text']; ?></p>
                                    </div>
                                </div>
                                <div class="link-list--trigger"></div>



                                <?php if (!empty($link)): ?>
                            </a>
                        <?php else: ?>
                    </div>
                <?php endif; ?>
    </div>
    <hr>
    </li>
<?php $i++;
            endforeach; ?>
</ul>
</div>
</div>