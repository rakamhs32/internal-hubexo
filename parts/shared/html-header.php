<!DOCTYPE HTML>
<!--[if IEMobile 7 ]><html class="no-js iem7" manifest="default.appcache?v=1"><![endif]-->
<!--[if lt IE 7 ]><html class="no-js ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="no-js ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
	<title><?php wp_title('|'); ?></title>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
	<meta name="format-detection" content="telephone=no">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/site.webmanifest">
	<link rel="mask-icon" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/safari-pinned-tab.svg" color="#321432">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="theme-color" content="#ffffff">
	<script>
		window.THEME_DIRECORY = "<?= get_stylesheet_directory_uri(); ?>";
		window.GOOGLE_MAPS_API_KEY = "<?= GOOGLE_MAPS_API_KEY ?>";
	</script>
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-V49ZSF18RF"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());
		gtag('config', 'G-V49ZSF18RF');
	</script>
</head>

<body <?php body_class(); ?>>
	<div style="display: none">
		<svg id="master-pattern-a">
			<g id="master-pattern-a-group"></g>
		</svg>
	</div>