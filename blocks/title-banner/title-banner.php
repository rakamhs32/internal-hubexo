<?php

    $title = get_field('title');

?>
<div class="title-banner header-pad">
    <div class="container snug-child fade-up">
        <h1 class="h2">
            <?php if(!empty($title)):?>
                <?= $title;?>
            <?php else:?>
                <?= the_title();?>
            <?php endif;?>
            
        </h1>
    </div>
</div>