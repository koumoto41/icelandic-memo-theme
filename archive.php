<?php
	$category  = array();
	$arySearch = array();
	$aryMap    = array();

	$category['name'] = single_cat_title( '', false );

	// ▼データ作成
	if (have_posts()) {
		foreach($posts as $post){
			// 表示用データ変換
			$arytemp = array();
			$arytemp = convDataSearch();
			array_push($arySearch, $arytemp);
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
				<h2>”<?= $category['name'] ?>” 関連情報</h2>

				<h3><?= $category['name'] ?> Information</h3>
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
<?php
	// FOOTER
	get_footer();
?>