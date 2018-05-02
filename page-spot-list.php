<?php
	global $post;

	// ▼変数初期化
	$category  = array();
	$arySearch = array();
	$aryMap    = array();

	$link      = esc_url(get_permalink());
	$title     = get_field('seo_title').'｜'.SITE_NAME;

	// ▼公開されている投稿のカテゴリ一覧を取得
	$category = get_categories('type=post&taxonomy=spot-area');

	foreach ($category as $key => $value) {
		$args = array(
			'post_type' => 'spot',
			'tax_query' => array(
				array(
					'taxonomy' => 'spot-area',
					'field'    => 'slug',
					'terms'    => $value->slug,
				),
			),
			'orderby'        => 'rand',
			'posts_per_page' => '12',
		);
		$the_query = new WP_Query($args);

		// ▼表示用データ変換
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$arytemp = array();
				$arytemp = convDataSearch();

				// 投稿のタクソノミー、名前を取得
				$terms = '';
				$terms = get_the_terms($post -> ID, 'spot-area');
				foreach ( $terms as $term ) {
					$tx_slug = $term->slug;
					$tx_name = $term->name;
				}

				// 'slug_name'をキーとした配列に格納
				if (isset($arySearch[$tx_slug.'_'.$tx_name])) {
					array_push($arySearch[$tx_slug.'_'.$tx_name], $arytemp);
				} else {
					$arySearch[$tx_slug.'_'.$tx_name][0] = $arytemp;
				}

			endwhile;
		endif;
	}
	wp_reset_query();	//Query Reset

	// ▼地図表示用データ設定
	$args = 'numberposts=-1&post_type=spot';
	$posts = get_posts($args);

	if (have_posts()) {
		foreach($posts as $post){
			$arytemp = array();
			$arytemp = convDataMap($post->ID);
			array_push($aryMap, $arytemp);
		}
	}
	wp_reset_query();	//Query Reset


	// HEADER
	get_header();
?>
<div class="main_search_block divider_spot">
	<div class="subtitlebox">
		<p class="en_highlight">SPOT LIST</p>
		<p class="mb20 ft_color1 ft_size12">アイスランド観光地・名所・スポット情報</p>
	</div>
</div>
<div class="container">
	<div class="row">
		<?= breadcrumb(); ?>
		<div class="clearfix">
			<div class="col-md-9">
				<!-- MAP -->
				<h2>アイスランド観光地・名所・スポット情報</h2>
<?php
				// SNS
				SNS_btn_horizontal_head($link, $title);
?>
				<p class="subtitle">メジャーな所からマイナーな所まで、アイスランドの観光地、名所、スポット情報一覧です。</p>
				<div id="map"></div>
				<p class="text-right mt10 mb30 ft_size8">アイコンをクリックすると詳細を表示します。</p>
				<hr />
				<!-- SPOT -->
				<section>
<?php
				foreach ($arySearch as $key => $value) {
					$aryKey = explode('_', $key);
?>
					<h3><?= $aryKey[1] ?>の観光地・名所・スポット情報</h3>
					<div class="clearfix mb40">
<?php
						foreach ($value as $key_s => $value_s) {
							$aryTmp = array();
							$aryTmp = $value_s;
							// LIST
							get_template_part('content', 'list1');
						}
?>
					</div>
					<div class="mb40 text-center">
						<a href="<?= home_url('area/'.$aryKey[0]) ?>" class="btn btn-success"><?= $aryKey[1] ?>のスポットをもっと見る</a>
					</div>
					<hr />
<?php
				}
?>
				</section>
			</div>
			<div class="col-md-3">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>
<script>
<!--
	var dat = JSON.parse('<?= json_encode($aryMap); ?>');
	var file = 'town';
-->
</script>
<script src="<?= WP_URL ?>/js/map.js"></script>
<?php
	// FOOTER
	get_footer();
?>