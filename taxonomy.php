<?php
	$taxonomy  = array();
	$arySearch = array();
	$aryMap    = array();

	// ▼タクソノミー取得
	$taxo = $wp_query->get_queried_object();
	$taxonomy['name'] = esc_html($taxo->name);
	$taxonomy['type'] = esc_html($taxo->taxonomy);
	$taxonomy['slug'] = esc_html($taxo->slug);
	$taxonomy['description'] = $taxo->description;

	// ▼データ作成
	if (have_posts()) {
		foreach($posts as $post){
			// 表示用データ変換
			$arytemp = array();
			$arytemp = convDataSearch();
			array_push($arySearch, $arytemp);

			// !!!スポットタグの場合は地図用データ変換
			if ($taxonomy['type'] == 'spot-tag') {
				// 地図用データ変換
				$arytemp = array();
				$arytemp = convDataMap($post->ID);
				array_push($aryMap, $arytemp);
			}
		}
	}
	wp_reset_query();	//Query Reset

	// HEADER
	get_header();
?>
<div class="container">
	<div class="row">
		<?= breadcrumb(); ?>
		<div class="clearfix editor-area">
			<div class="col-md-9">
				<h2>”<?= $taxonomy['name'] ?>” 関連情報</h2>
<?php
				if ($taxonomy['description'] == '') {
					if ($taxonomy['type'] == 'music-tag') {
						echo '<p class="ft_size8 mb20">ジャンル【'.$taxonomy['name'].'】のアイスランドアーティスト一覧です。</p>'."\n";
					} else {
						echo '<p class="ft_size8 mb20">アイスランドの'.$taxonomy['name'].'関連情報を掲載しています。</p>'."\n";
					}
				} else {
					echo '<p class="ft_size8 mb20">'.$taxonomy['description'].'</p>'."\n";
				}

				$cat = get_categories('title_li=&taxonomy='.$taxonomy['type'].'&echo=0&hide_empty=0');
				if ($cat) {
					echo '<ul class="list-inline mb30">'."\n";
					foreach ($cat as $key => $value) {
						echo '<li class="mb10"><a href="'.home_url($taxonomy['type'].'/'.$value->slug).'" class="btn btn-primary">'.$value->cat_name.'</a></li>'."\n";
					}
					echo '</ul>'."\n";
				}
?>
				<?php if ($taxonomy['type'] == 'spot-tag') { ?>
				<h3><?= $taxonomy['name'] ?>を地図から探す</h3>
				<div id="map"></div>
				<p class="text-right mt10 mb30 ft_size8">アイコンをクリックすると詳細を表示します。</p>
				<hr />
				<?php } ?>
				<h3><?= $taxonomy['name'] ?> 情報</h3>
				<?php
					if(count($arySearch) != 0){
						get_template_part('content', 'list2');
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
<?php if ($taxonomy['type'] == 'spot-tag') { ?>
<script>
<!--
	var dat = JSON.parse('<?= json_encode($aryMap); ?>');
	var file = 'town';
-->
</script>
<script src="<?= WP_URL ?>/js/map.js"></script>
<?php } ?>
<?php
	// FOOTER
	get_footer();
?>