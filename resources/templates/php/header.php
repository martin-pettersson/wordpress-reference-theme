<!DOCTYPE html>
<html <?= language_attributes() ?>>
<head>
	<meta charset="<?= $charset ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<?php wp_head() ?>
</head>
<body <?= body_class() ?>>
	<header id="site-header" class="<?= implode( ' ', $header_classes ) ?>">
		<div class="site-header__wrapper">
			<a href="<?= $site_url ?>" class="site-header__brand">
				<?php if ( ! is_null( $logo ) ) : ?>
					<img src="<?= $logo ?>" class="site-logo">
				<?php else : ?>
					<span class="site-title"><?= $site_title ?></span>
				<?php endif ?>
			</a>
			<?php if ( ! is_null( $nav_menu ) ) : ?>
				<?= $nav_menu ?>
                <button class="site-header__menu-button menu-button" aria-label="<?= __( 'Toggle Menu', 'reference' ) ?>">
                    <div class="menu-button-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
			<?php endif ?>
		</div>
	</header>

	<?php if ( ! is_null( $hero ) ) : ?>
		<div id="hero" class="hero">
			<h1 class="hero__title"><?= $hero['title'] ?></h1>
			<div class="hero__image" style="background-image: url(<?= $hero['image'] ?>)"></div>
		</div>
	<?php endif ?>

	<div class="site-content">
