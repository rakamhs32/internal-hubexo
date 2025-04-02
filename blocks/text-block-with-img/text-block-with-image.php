<?php
$image             = get_field( 'image' );
$url_video         = get_field( 'url_video' );
$url_video_youtube = get_field( 'url_video_youtube' );
$link              = get_field( 'link' );
if ( ! empty( $link ) ) {
	$link_target = $link['target'] ? $link['target'] : '_self';
}

$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
?>

<div class="content-panel text-block white-text plum-bg <?= $BlockCss; ?>"
     data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
    <div class="container fade-in">
        <div class="text-block--text snug-child text-block-with--image">
            <div class="text-content">
				<?= get_field( 'text' ); ?>
				<?php if ( ! empty( $link ) ): ?>
                    <div><a href="<?= $link['url']; ?>" target="<?= esc_attr( $link_target ); ?>"
                            class="blueprint--button"><?= $link['title']; ?><?php get_template_part( 'parts/svg/right-arrow' ); ?></a>
                    </div>
				<?php endif; ?>
            </div>
            <div class="image-content">
				<?php if ( ! empty( $image ) ): ?>
                    <img src="<?= $image['url']; ?>" alt="<?= esc_attr( $image['alt'] ); ?>">
				<?php else: ?>
                    <img style="display: none;">
				<?php endif; ?>

				<?php if ( ! empty( $url_video ) ): ?>
                    <video controls>
                        <source src="<?= $url_video ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
				<?php else: ?>
                    <video style="display: none;"></video>
				<?php endif; ?>

				<?php
				if ( ! empty( $url_video_youtube ) ):
					// Convert regular YouTube URL to embed URL
					$video_id = '';

					// Match YouTube URL patterns
					if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url_video_youtube, $match ) ) {
						$video_id = $match[1];
					}

					// Create proper embed URL
					$embed_url = 'https://www.youtube.com/embed/' . $video_id;
					?>
                    <iframe
                            width="620"
                            height="465"
                            src="<?= esc_url( $embed_url ) ?>"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allowfullscreen>
                    </iframe>
				<?php else: ?>
                    <iframe style="display: none;"></iframe>
				<?php endif; ?>
            </div>
        </div>
    </div>
</div>