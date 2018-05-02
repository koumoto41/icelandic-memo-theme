<?php
	// ■ 検索結果一覧表示用テンプレート
	// ■ USE:search.pnp、taxonomy-area.php、taxonomy.php

	global $arySearch;

?>
	<div class="clearfix">
<?php
	foreach ($arySearch as $key => $value) {
?>
		<div class="col-sm-6 col-xs-12 col-list blog_list">
			<div class="thumbnail">
				<div class="type type_<?= $value['type'] ?>"></div>
				<img src="<?= $value['image'] ?>" alt="<?= $value['name'] ?>" class="img-responsive center-block" />
				<div class="caption">
					<h3><a href="<?= $value['link'] ?>"><?= $value['name'] ?></a></h3>
					<p class="text"><?= $value['text'] ?></p>
					<p><a href="<?= $value['link'] ?>" class="btn btn-primary btn-block"><?= $value['name'] ?></a></p>
<?php
					if (count($value['cat']['cat']) > 0 || count($value['cat']['tag']) > 0) {
						echo '<hr />'."\n";
					}

					// CATEGORY
					if (count($value['cat']['cat']) > 0) {
						echo '<ul class="list-inline">'."\n";
						echo '<li><i class="glyphicon glyphicon-book"></i></li>'."\n";
						foreach ($value['cat']['cat'] as $key_c => $value_c) {
							if (count($value_c) > 0) {
								$link = str_replace ('/spot-area/', '/area/', $value_c[0]);
								echo '<li><a href="'.$link.'">'.$value_c[1].'</a></li>'."\n";
							}
						}
						echo '</ul>'."\n";
					}

					// TAG
					if (count($value['cat']['tag']) > 0) {
						echo '<ul class="list-inline">'."\n";
						echo '<li><i class="glyphicon glyphicon-tag"></i></li>'."\n";
						foreach ($value['cat']['tag'] as $key_t => $value_t) {
							if (count($value_t) > 0) {
								echo '<li><a href="'.$value_t[0].'">'.$value_t[1].'</a></li>'."\n";
							}
						}
						echo '</ul>'."\n";
					}
?>
				</div>
			</div>
		</div>
<?php
	}
?>
	</div>