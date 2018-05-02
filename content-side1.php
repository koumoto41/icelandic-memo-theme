<?php
	// アイキャッチ画像取得
	$tmp      = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail');
	$eyechach = esc_url(imgNotFound($tmp[0]));
	$id       = get_the_ID();
	$title    = get_the_title();
	$link     = get_permalink();
	$text     = getTheExcerpt($id, 80);
?>
	<div class="clearfix post_list">
		<div class="col-xs-3">
			<div class="row">
				<img src="<?= $eyechach ?>" alt="<?= $title ?>" class="img-responsive center-block">
			</div>
		</div>
		<div class="col-xs-9">
			<p><a href="<?= $link ?>"><?= $title ?></a></p>
			<!-- <p class="text"><?= $text ?></p> -->
		</div>
	</div>