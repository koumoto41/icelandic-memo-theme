<?php
	// 変数初期化
	$aryTown    = array();
	$aryTownMap = array();
	$aryPhoto   = array();
	$strHtml    = '';

	$link  = esc_url(get_permalink());
	$title = get_field('name').'の観光地・名所・スポット情報｜'.SITE_NAME;

	if (have_posts()) {

		$arytemp = array();
		// データ変換
		$arytemp = convDataMap($post->ID);
		array_push($aryTownMap, $arytemp);

		// テキストが長すぎるとエラーになる為、JSに投げるデータと分ける
		$tmp = get_field('background_image');
		$tmp = wp_get_attachment_image_src($tmp,'full');
		$arytemp['bgimage']   = esc_url($tmp[0]);

		$tmp = get_field('image');
		$tmp = wp_get_attachment_image_src($tmp,'large');
		$arytemp['mainimage']   = esc_url(imgNotFound($tmp[0]));

		$arytemp['name']      = esc_html(get_field('name'));
		$arytemp['text']      = get_field('text');
		$arytemp['wiki_text'] = get_field('wiki_text');
		$arytemp['wiki_url']  = esc_url(get_field('wiki_url'));
		$arytemp['wiki_name'] = esc_html(get_field('wiki_name'));
		array_push($aryTown, $arytemp);

		// ▼写真一覧取得
		$ary = SCF::get('photolist');

		foreach ($ary as $key => $value) {
			$aryTemp = array();
			$tmp1 = wp_get_attachment_image_src($value['photo'],'large');
			$tmp2 = wp_get_attachment_image_src($value['photo'],'thumbnail');
			$aryTemp['image_lg']    = esc_url($tmp1[0]);
			$aryTemp['image_thumb'] = esc_url($tmp2[0]);
			$aryTemp['title']       = esc_html($value['title']);
			array_push($aryPhoto, $aryTemp);
		}

		// ▼スポット一覧取得
		$arySpot = array();
		$ary = SCF::get('near_spot');

		foreach ($ary as $key => $value) {
			if (count($value['near_name']) != 0) {

				foreach ($value['near_name'] as $key_s => $value_s) {
					$arytemp1 = array();
					$id = $value_s;

					$tmp = get_field('image', $id);
					$tmp = wp_get_attachment_image_src($tmp, 'thumbnail');
					$tmp = imgNotFound($tmp[0]);

					$arytemp1['image']   = esc_url($tmp);
					$arytemp1['name']    = esc_html(get_field('name', $id));
					$arytemp1['is_name'] = esc_html(get_field('is_name', $id));
					$arytemp1['link']    = esc_url(get_permalink($id));

					array_push($arySpot, $arytemp1);
				}
			}
		}
		// ▼カテゴリ、タグのターム取得
		$aryCatTag = getCategoryTag($post, 'spot');
	}
	wp_reset_query();	//Query Reset

	$ary = $aryTown[0];

	// HEADER
	get_header();
?>
<div class="container">
	<div class="row">
		<?= breadcrumb(); ?>
		<div class="clearfix editor-area">
			<div class="col-md-9">
				<h2><?= $ary['name'] ?>情報</h2>
<?php
				// SNS
				SNS_btn_horizontal_head($link, $title);
				// CATEGORY
				get_template_part('content', 'cattag');
?>
				<div class="mb20">
					<img class="img-responsive center-block" src="<?= $ary['mainimage'] ?>" alt="<?= $ary['name'] ?>" />
				</div>
<?php
				// CONTENTS
				if ($ary['text'] != '') {
					echo '<div class="mt20 mb30">'."\n";
					echo $ary['text']."\n";
					echo '</div>'."\n";
					echo '<hr />'."\n";
				}

				// WIKI
				if ($ary['wiki_text'] != '') {
					echo '<blockquote>'."\n";
					echo '<p>'.$ary['wiki_text'].'</p>'."\n";

					if ($ary['wiki_url'] != '') {
						echo '<p class="text-right"><cite><a href="'.$ary['wiki_url'].'" target="_blank">引用：'.$ary['wiki_name'].'</a></cite></p>'."\n";
					}
					echo '</blockquote>'."\n";
					echo '<hr />'."\n";
				}

				// PHOTO
				if (count($aryPhoto) > 0) {
?>
				<h3><?= $ary['name'] ?>の写真</h3>
				<div class="clearfix" id="lightbox">
<?php
				foreach ($aryPhoto as $key => $value) {
					if ($value['image_lg'] != '') {
?>
					<div class="col-md-3 col-sm-4 col-xs-6 text-center col-list mb20">
						<a href="<?= $value['image_lg'] ?>"><img class="img-responsive center-block" src="<?= $value['image_thumb'] ?>" alt="<?= $value['title'] ?>"></a>
					</div>
<?php
					}
				}
?>
				</div>
				<hr />
<?php
				}
?>
				<h3><?= $ary['name'] ?>の場所</h3>
				<div id="map" class="mb30"></div>
				<hr />
<?php
				if (count($arySpot) > 0) {
?>
				<h3><?= $ary['name'] ?>の近隣スポット</h3>
				<div class="clearfix">
<?php
					foreach ($arySpot as $key => $value) {
						$aryTmp = array();
						$aryTmp = $value;
						get_template_part('content', 'list1');
					}
?>
				</div>
<?php
				}
?>
			</div>
			<div class="col-md-3">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>
<script>
<!--
	var dat = JSON.parse('<?= json_encode($aryTownMap); ?>');
	var file = 'detail';
-->
</script>
<script src="<?= WP_URL ?>/js/map.js"></script>
<?php
	get_footer();
?>