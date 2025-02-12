<?php

$contactBlocks = get_field('contact_blocks');

?>

<div class="content-panel">
    <div class="container">
        <div class="contacts fade-in">
            <h2 class="h5 snug"><?= get_field('title'); ?></h2>
            <div class="locations-grid is-yellow">
                <?php if (!empty($contactBlocks)): ?>
                    <?php foreach ($contactBlocks as $i => $contactBlock):
                        $email = $contactBlock['email_address'];
                        $email = antispambot($email);
                    ?>
                        <div class="location-card" style="--n: <?= $i ?>">
                            <h3 class="snug">
                                <span><?= $contactBlock['title']; ?></span>
                                <?php if ($contactBlock['icon'] ?? false): ?>
                                    <img src="<?= $contactBlock['icon']['url'] ?>" alt="<?= $contactBlock['icon']['alt'] ?>" class="icon-size-medium" />
                                <?php endif; ?>
                            </h3>
                            <p class="snug"><a href="mailto:<?= $email; ?>" target="_blank" class="small-title--bold"><?= $email; ?></a></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>