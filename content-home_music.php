<?php
	$post_type = $post->post_type;

	$arytemp = array();
	$arytemp = convData($post->ID, 'music');
?>
	<div class="col-sm-4 col-xs-6 text-center col-list mb20">
		<p><a href="<?= $arytemp['link'] ?>"><img class="img-responsive center-block" src="<?= $arytemp['image'] ?>" alt="<?= $arytemp['name'] ?>"></a></p>
		<p><a href="<?= $arytemp['link'] ?>" class="text"><strong><?= $arytemp['is_name'] ?></strong></a></p>
		<p><a href="<?= $arytemp['link'] ?>" class="text"><?= $arytemp['name'] ?></a></p>
	</div>
