<?php
	// ▼アイキャッチ画像を取得
	$eye = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail');
	$image = esc_url(imgNotFound($eye[0]));

	$title = esc_html(get_the_title());
	$link  = esc_url(get_permalink());
?>
	<div class="col-sm-4 col-xs-6 text-center col-list mb20">
		<p><a href="<?= $link ?>"><img class="img-responsive center-block" src="<?= $image ?>" alt="<?= $title ?>"></a></p>
		<p><a href="<?= $link ?>" class="text"><strong><?= $title ?></strong></a></p>
	</div>
