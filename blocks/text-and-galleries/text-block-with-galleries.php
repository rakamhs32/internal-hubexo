<?php
$content          = get_field( 'content' );
$galleries        = get_field( 'galleries' );
$background_color = get_field( 'background_color' );

$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
?>

<div class="content-panel white-text text-block <?= $background_color ?> <?= $BlockCss; ?>"
     data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
    <div class="container fade-in">
        <div class="text-block-with--galleries">
            <div class="text-content">
				<?= $content ?>
            </div>
            <div class="block-galleries">
				<?php if ( have_rows( 'galleries' ) ): ?>
					<?php while ( have_rows( 'galleries' ) ): the_row();
						$number_column  = get_sub_field( 'number_column' );
						$gallery_images = get_sub_field( 'galleries_item' );
						?>
                        <div class="content-galleries">
                            <div class="galleries-items <?= esc_attr( $number_column ) ?>">
								<?php
								if ( $gallery_images && is_array( $gallery_images ) ):
									foreach ( $gallery_images as $image ):
										// Get image details
										$img_url = $image['url'];
										$img_alt = $image['alt'] ? $image['alt'] : '';
										$img_title = $image['title'] ? $image['title'] : '';
										$img_caption = $image['caption'] ? $image['caption'] : '';
										?>
                                        <div class="gallery-item">
                                            <img src="<?= esc_url( $img_url ); ?>"
                                                 alt="<?= esc_attr( $img_alt ); ?>"
                                                 title="<?= esc_attr( $img_title ); ?>"
                                                 loading="lazy">
											<?php if ( $img_caption ): ?>
                                                <div class="gallery-caption"><?= $img_caption; ?></div>
											<?php endif; ?>
                                        </div>
									<?php endforeach; ?>
								<?php endif; ?>
                            </div>
                        </div>
					<?php endwhile; ?>
				<?php endif; ?>
            </div>
        </div>
    </div>
</div>