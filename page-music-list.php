<?php
	global $post;

	$args = array(
		'numberposts' => -1,
		'post_type'   => 'music',
		'orderby'     => 'meta_value',
		'meta_key'    => 'is_name',
		'order'       => 'ASC'
	);
	$posts = get_posts($args);

	// 変数初期化
	$aryMusic = array();
	$strHtml = '';

	$link      = esc_url(get_permalink());
	$title     = get_field('seo_title').'｜'.SITE_NAME;

	if (have_posts()) {
		foreach($posts as $post){
			$arytemp['title']   = esc_html(get_the_title());
			$arytemp['name']    = esc_html(get_field('name'));
			$arytemp['is_name'] = esc_html(get_field('is_name'));
			$arytemp['youtube'] = esc_url(imageyoutube(get_field('youtube')));
			$arytemp['link']    = esc_url(get_permalink());
			array_push($aryMusic, $arytemp);
		}
	}
	wp_reset_query();	//Query Reset

	// HEADER
	get_header();
?>
<!-- HEADER -->
<div class="main_search_block divider_music">
	<div class="subtitlebox">
		<p class="en_highlight">MUSIC</p>
		<p class="mb20 ft_color1 ft_size12">アイスランド音楽情報</p>
	</div>
</div><!-- /headerwrap -->
<div class="container">
	<div class="row">
		<?= breadcrumb(); ?>
		<div class="clearfix">
			<div class="col-md-9">
				<h2>アイスランド音楽(アーティスト)情報</h2>
<?php
				// SNS
				SNS_btn_horizontal_head($link, $title);
?>
				<p class="subtitle mb30">メジャーなビョーク、シガーロスから日本では馴染みの薄いアーティストまで、個性豊かなアイスランドアーティスト達を紹介</p>
<?php
				for ($i=0; $i<26; $i++) {
					$strHtml = '';

					$lg = chr(65+$i);
					$sm = chr(97+$i);

					foreach($aryMusic as $key => $value){
						$front = mb_substr($value['title'], 0, 1);

						if ($lg == $front || $sm == $front) {
							if ($strHtml == '') {
								$strHtml .= '<h3 class="ft_size15">'.$lg.'</h3>'."\n";
								$strHtml .= '<div class="clearfix">'."\n";
							}

							$strHtml .= '<div class="col-sm-4 col-xs-6 text-center col-list mb20">'."\n";
							$strHtml .= '<p><a href="'.$value['link'].'"><img class="img-responsive center-block" src="'.$value['youtube'].'" alt="'.$value['name'].'"></a></p>'."\n";
							$strHtml .= '<p><a href="'.$value['link'].'" class="text"><strong>'.$value['is_name'].'</strong></a></p>'."\n";
							$strHtml .= '<p><a href="'.$value['link'].'" class="text">'.$value['name'].'</a></p>'."\n";
							$strHtml .= '</div>'."\n";

						}
					}

					if ($strHtml != '') {
						$strHtml .= '</div>'."\n";
					}
					echo $strHtml;
				}
?>
			</div>
			<div class="col-md-3">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div><!-- container -->
<?php
	// FOOTER
	get_footer();
?>