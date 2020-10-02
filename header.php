<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); if(get_bloginfo('description')) { echo ' - ' . get_bloginfo('description');  } ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">

        <meta name="msapplication-TileImage" content="<?php echo get_option('morii_msapplication_tileimage'); ?>"/>
        <meta name="msapplication-TileColor" content="<?php echo get_option('morii_theme_color'); ?>"/>
        <meta name="theme-color" content="<?php echo get_option('morii_theme_color'); ?>"/>
        <link rel="shortcut icon" href="<?php echo get_option('morii_favicon'); ?>" />
        <link rel="apple-touch-icon" href="<?php echo get_option('morii_apple_touch_icon'); ?>" />
        <link rel="icon" sizes="192x192" href="<?php echo get_option('morii_highres_favicon'); ?>">

        <link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/styles/daylight-switch.css' type='text/css' media='all' />
        <link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/styles/tooltips.css' type='text/css' media='all' />
        <!-- iconfont-icons -->
        <link rel="stylesheet" href="//at.alicdn.com/t/font_1980391_er18uopnsel.css">

        <!-- custom header -->
        <?php echo stripslashes(get_option('morii_header')); ?>

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- SEO -->
        <?php if (get_option('morii_meta') == true) : ?>
        <?php morii_seo_meta(); ?>
        <?php else : ?>
        <meta name="description" content="<?php bloginfo('description'); ?>">
        <?php endif; ?>

		<?php wp_head(); ?>
		<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
        </script>

	</head>
	<body <?php body_class(); ?>>

		<!-- wrapper -->
		<div class="wrapper">

			<!-- header -->
			<header class="header clear" role="banner">

                <a href="/"><h1 class="header-title"><?php bloginfo('name'); ?></h1></a>

                <!-- nav -->
                <nav class="nav" role="navigation">
                    <?php html5blank_nav(); ?>
                </nav>
                <!-- /nav -->

			</header>
			<!-- /header -->
