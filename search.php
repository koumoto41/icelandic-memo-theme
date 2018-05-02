<?php
	$arySearch = array();
	$strCount  = '';
	$glb_count = 0;
	$keyword   = wp_specialchars($s, 1);

	if ($s != '') {
		$args = array(
			's' => $s,
			'posts_per_page' => -1
		);
		// 全体の件数取得
		$allsearch = new WP_Query($args);
		$glb_count = $allsearch->post_count;

		foreach($posts as $post){
			$arytemp = array();
			// データ変換
			$arytemp = convDataSearch();
			array_push($arySearch, $arytemp);
		}
	}

	if($glb_count != 0){
		// 検索結果を表示:該当記事あり
		$strCount = '<strong class="ft_color2">'.$glb_count.'</strong>件の項目が見つかりました！！';
	} else {
		// 検索結果を表示:該当記事なし
		$strCount = '関連する項目は見つかりませんでした…Fyrirgefðu…';
	}

	// ページ数設定
	$system_count = get_option('posts_per_page');
	$pager_count  = ceil($glb_count / $system_count);


	// HEADER
	get_header();
?>
	<div class="container">
		<div class="row">
			<?= breadcrumb(); ?>
			<div class="clearfix">
				<div class="col-md-9">
					<h2>“<?= $keyword ?>”<span class="ft_size08">の検索結果</span></h2>
					<p class="mb30">“<strong><?= $keyword ?></strong>”で検索した結果、<?= $strCount ?></p>
<?php
					if($glb_count != 0){
						get_template_part('content', 'list2');
						// ページング
						if (function_exists("pagination")) echo pagination($pager_count);
					} else {
						get_template_part('content', 'list_none');
					}
?>
				</div>
				<div class="col-md-3">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>
<?php
	// FOOTER
	get_footer();
?>