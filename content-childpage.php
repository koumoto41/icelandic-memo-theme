<?php
	// ▼子ページ一覧表示用テンプレート

	$tmp      = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail');
	$eyechach = esc_url(imgNotFound($tmp[0]));
	$id       = get_the_ID();
	$title    = get_the_title();
	$link     = get_permalink();
	$text     = getTheExcerpt($id, 40);
?>
	<div class="col-sm-6 childpage col-list">
		<div class="clearfix">
			<div class="col-xs-3">
				<div class="row">
					<a href="<?= $link ?>"><img src="<?= $eyechach ?>" alt="<?= $title ?>" class="img-responsive center-block" /></a>
				</div>
			</div>
			<div class="col-xs-9">
				<h4><a href="<?= $link ?>"><?= $title ?></a></h4>
				<p class="text"><?= $text ?></p>
			</div>
		</div>
	</div>