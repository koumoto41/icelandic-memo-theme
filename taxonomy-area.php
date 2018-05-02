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

	// ▼現在のページ番号取得
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	// ▼クエリ作成（エリア、スポット両方のタクソノミーで絞り込み）
	$args = array(
		'tax_query' => array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'area',
				'field' => 'slug',
				'terms' => array($taxonomy['slug']),
				'include_children' => true,
				'operator' => 'IN'
			),
			array(
				'taxonomy' => 'spot-area',
				'field' => 'slug',
				'terms' => array($taxonomy['slug']),
				'include_children' => true,
				'operator' => 'IN'
			)
		),
		'paged'=>$paged
	);
	$the_query = new WP_Query($args);

	// ▼表示用データ変換
	if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$arytemp = array();
			$arytemp = convDataSearch();
			array_push($arySearch, $arytemp);
		endwhile;
	endif;

	// 全体の件数取得
	$glb_count = $the_query->max_num_pages;

	// ▼地図表示用データ作成
	$args['posts_per_page'] = -1;
	$the_query = new WP_Query($args);

	if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$arytemp = array();
			$arytemp = convDataMap($post->ID);
			array_push($aryMap, $arytemp);
		endwhile;
	endif;

	wp_reset_query();	//Query Reset

	// HEADER
	get_header();
?>
<div class="container">
	<div class="row">
		<?= breadcrumb(); ?>
		<div class="clearfix editor-area">
			<div class="col-md-9">
				<h2>”<?= $taxonomy['name'] ?>” 情報</h2>
				<p class="ft_size8 mb20"><?= nl2br($taxonomy['description']) ?></p>
<?php
				$cat = get_categories('title_li=&taxonomy=area&echo=0&hide_empty=0');
				if ($cat) {
					echo '<ul class="list-inline mb30">'."\n";
					foreach ($cat as $key => $value) {
						echo '<li class="mb10"><a href="'.home_url('area/'.$value->slug).'" class="btn btn-primary">'.$value->cat_name.'</a></li>'."\n";
					}
					echo '</ul>'."\n";
				}
?>
				<h3><?= $taxonomy['name'] ?>のスポットを地図で確認</h3>
				<div id="map"></div>
				<p class="text-right mt10 mb30 ft_size8">地図上のアイコンをクリックすると詳細を表示します。</p>
				<hr />
				<h3><?= $taxonomy['name'] ?>のスポット一覧</h3>
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