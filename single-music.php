<?php
	// 変数初期化
	$aryMusic   = array();
	$aryTownMap = array();
	$aryYoutube = array();
	$aryAmazon  = array();
	$aryGenre   = array();

	$link  = esc_url(get_permalink());
	$title = get_field('name').'のアーティスト情報｜'.SITE_NAME;

	$strHtml = '';

	if (have_posts()) {

		$arytemp = array();
		$arytemp['name']     = esc_html(get_field('name'));
		$arytemp['is_name']  = esc_html(get_field('is_name'));
		$arytemp['link']     = esc_url(get_permalink());
		$arytemp['youtube']  = get_field('youtube');
		if ($arytemp['youtube'] != '') {
			$arytemp['youtube'] = embedyoutube($arytemp['youtube']);
		}

		$arytemp['text']        = get_field('text');
		$arytemp['member']      = get_field('member');
		$arytemp['discography'] = get_field('discography');
		$arytemp['weblink']     = esc_url(get_field('weblink'));
		$arytemp['wiki_text']   = get_field('wiki_text');
		$arytemp['wiki_url']    = esc_url(get_field('wiki_url'));

		array_push($aryMusic, $arytemp);

		// youtube一覧取得
		$ary = SCF::get('youtube');

		foreach ($ary as $key => $value) {
			$aryTemp = array();
			$aryTemp['youtube_url'] = $value['youtube_url'];

			if ($aryTemp['youtube_url'] != '') {
				$aryTemp['youtube_url'] = embedyoutube($aryTemp['youtube_url']);
			}
			array_push($aryYoutube, $aryTemp);
		}

		// amazon一覧取得
		$ary = SCF::get('amazon');
		foreach ($ary as $key => $value) {
			if ($value['amazon_url'] != '') {
				$aryTemp = array();
				$aryTemp['amazon_url'] = $value['amazon_url'];
				array_push($aryAmazon, $aryTemp);
			}
		}

		// ▼カテゴリ、タグのターム取得
		$aryCatTag = getCategoryTag($post, 'music');
	}
	wp_reset_query();	//Query Reset

	$ary = $aryMusic[0];

	// HEADER
	get_header();
?>
<div class="container">
	<div class="row">
		<?= breadcrumb(); ?>
		<div class="clearfix editor-area">
			<div class="col-md-9">
				<h2><?= $ary['is_name'] ?><br /><span class="ft_size5"><?= $ary['name'] ?></span></h2>
<?php
				// SNS
				SNS_btn_horizontal_head($link, $title);
				// CATEGORY
				get_template_part('content', 'cattag');
?>
				<div class="movie_block">
					<div class="ar_youtubeblock">
						<iframe width="560" height="315" src="<?= $ary['youtube'] ?>" frameborder="0" allowfullscreen></iframe>
					</div>
				</div>
<?php
				if ($ary['text'] != '') {
					echo '<p class="pb20">'.$ary['text'].'</p>'."\n";
					echo '<hr />'."\n";
				}
?>
				<div class="clearfix mb30">
					<div class="col-lg-6 col-md-6 col-sm-6 pb20">
						<h4 class="ft_size15 mb30 ft_color3">Member</h4>
						<p><?= $ary['member'] ?></p>
					</div><!-- col-lg-6 -->
					<div class="col-lg-6 col-md-6 col-sm-6 pb20">
						<h4 class="ft_size15 mb30 ft_color3">Discography</h4>
						<p><?= $ary['discography'] ?></p>
					</div><!-- col-lg-6 -->
				</div>
				<hr />
<?php
				// AMAZON
				if (count($aryAmazon) > 0) {
?>
					<h4 class="ft_size15 mb30 ft_color3">Music Album & DVD</h4>
					<div class="clearfix mb40">
<?php
					foreach ($aryAmazon as $key => $value) {
						if ($value['amazon_url'] != '') {
?>
						<div class="col-md-3 col-sm-4 col-xs-6 amazon_img col-list mb10">
							<?= $value['amazon_url'] ?>
						</div><!-- /col -->
<?php
						}
					}
?>
					</div>
					<hr />
<?php
				}

				// WIKI
				if ($ary['wiki_text'] != '') {
					echo '<blockquote>'."\n";
					echo '<p>'.$ary['wiki_text'].'</p>'."\n";

					if ($ary['wiki_url'] != '') {
						echo '<p class="text-right"><cite><a href="'.$ary['wiki_url'].'" target="_blank">引用：wikipedia</a></cite></p>'."\n";
					}
					echo '</blockquote>'."\n";
					echo '<hr />'."\n";
				}
?>
<?php
				// MOVIE
				if (count($aryYoutube) > 0) {
?>
				<h3><?= $ary['is_name'] ?> Movie</span></h3>
				<div class="clearfix">
<?php
				foreach ($aryYoutube as $key => $value) {
					if ($value['youtube_url'] != '') {
?>
					<div class="col-sm-4 col-xs-6 mb10">
						<div class="ar_youtubeblock">
							<iframe width="560" height="315" src="<?= $value['youtube_url'] ?>" frameborder="0" allowfullscreen></iframe>
						</div>
					</div><!-- /col -->
<?php
					}
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
<?php
	get_footer();
?>