<?php
	global $post;

	$args = array(
		'numberposts' => -1,
		'post_type' => 'town'
	);
	$posts = get_posts($args);

	// 変数初期化
	$aryTown = array();
	$aryTownMAP = array();
	$strHtml = '';

	$link      = esc_url(get_permalink());
	$title     = get_field('seo_title').'｜'.SITE_NAME;

	if (have_posts()) {
		foreach($posts as $post){

			$arytemp = array();
			// データ変換
			$arytemp = convDataMap($post->ID);
			array_push($aryTownMAP, $arytemp);

			$terms = '';
			$terms = get_the_terms($post -> ID, 'area');
			foreach ( $terms as $term ) {
				$tx_slug = $term->slug;
				$tx_name = $term->name;
			}

			if (isset($aryTown[$tx_slug.'_'.$tx_name])) {
				array_push($aryTown[$tx_slug.'_'.$tx_name], $arytemp);
			} else {
				$aryTown[$tx_slug.'_'.$tx_name][0] = $arytemp;
			}

		}
	}
	wp_reset_query();	//Query Reset

	// HEADER
	get_header();
?>
<div class="main_search_block divider_town">
	<div class="subtitlebox">
		<p class="en_highlight">TOWN LIST</p>
		<p class="mb20 ft_color1 ft_size12">アイスランドの街・村情報</p>
	</div>
</div>
<div class="container">
	<div class="row">
		<?= breadcrumb(); ?>
		<div class="clearfix">
			<div class="col-md-9">
				<!-- MAP -->
				<h2>アイスランドの街・村情報</h2>
<?php
				// SNS
				SNS_btn_horizontal_head($link, $title);
?>
				<p class="subtitle">アイスランドの街、村情報の一覧です。実際に訪れた際の写真も掲載しています。</p>
				<div id="map"></div>
				<p class="text-right mt10 mb30 ft_size8">アイコンをクリックすると詳細を表示します。</p>
				<hr />
				<!-- TOWN -->
				<section>
<?php
				foreach ($aryTown as $key => $value) {
					$aryKey = explode('_', $key);
?>
					<h3><?= $aryKey[1] ?>の街・村情報</h3>
					<div class="clearfix mb40">
<?php
					foreach ($value as $key_s => $value_s) {
						$aryTmp = array();
						$aryTmp = $value_s;
						get_template_part('content', 'list1');
					}
?>
					</div>
					<div class="mb40 text-center">
						<a href="<?= home_url('area/'.$aryKey[0]) ?>" class="btn btn-success"><?= $aryKey[1] ?>の街をもっと見る</a>
					</div>
					<hr />
<?php
				}
?>
				</section><!-- section -->
				<script>
				<!--
					var dat = JSON.parse('<?= json_encode($aryTownMAP); ?>');
					var file = 'town';
				-->
				</script>
				<script src="<?= WP_URL ?>/js/map.js"></script>
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