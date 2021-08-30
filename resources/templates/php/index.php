<?php get_header() ?>

<div class="post-list">
	<ul class="post-list__posts">
		<?php foreach ( $posts as $post ) : ?>
			<li class="post-list__post">
				<div <?php post_class() ?>>
					<?= $post->ID ?>:
					<a href="<?= esc_attr( get_the_permalink() ) ?>"><?php the_title() ?></a>
				</div>
			</li>
		<?php endforeach ?>
	</ul>
</div>

<?php get_footer() ?>
