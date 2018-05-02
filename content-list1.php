<?php
	// TOPページ等のリスト表示部分テンプレート
	global $aryTmp;
?>
<div class="col-sm-4 col-xs-6 text-center col-list mb20">
	<p><a href="<?= $aryTmp['link'] ?>"><img src="<?= $aryTmp['image'] ?>" alt="<?= $aryTmp['name'] ?>" class="img-responsive center-block" /></a></p>
	<p><a href="<?= $aryTmp['link'] ?>" class="text"><strong><?= $aryTmp['is_name'] ?></strong></a></p>
	<p><a href="<?= $aryTmp['link'] ?>" class="text"><?= $aryTmp['name'] ?></a></p>
</div>