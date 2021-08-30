<?php get_header( 'page' ) ?>

<?php if ( ! in_array( 'has-header-image', get_body_class(), true ) ) : ?>
	<h1><?= $title ?></h1>
<?php endif  ?>

<?= $content ?>

<?php get_footer( 'page' ) ?>
