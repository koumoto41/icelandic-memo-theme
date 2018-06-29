<?php
	$popular     = array();
	$popular_tx  = array();
	$popular_cat = array();

	// $popular['post'] = do_shortcode('[wpp header="Popular Page" header_start="<h4><strong>" header_end="</strong></h4><p>人気のブログ記事</p>" range="monthly" order_by="avg" post_type="post" limit=5 title_length=35 stats_views=0 wpp_start="<ul class="mb30">" wpp_end="</ul>" thumbnail_width=60 thumbnail_height=60]');
	$popular['post'] = '';

	$popular['page'] = do_shortcode('[wpp header="Popular Page" header_start="<h4><strong>" header_end="</strong></h4><p>よく読まれているページ</p>" range="monthly" order_by="avg" post_type="page" limit=5 title_length=35 stats_views=0 wpp_start="<ul class="mb30">" wpp_end="</ul>" thumbnail_width=60 thumbnail_height=60]');

	$popular_tx['town'] = do_shortcode('[wpp header="Popular Town" header_start="<h4><strong>" header_end="</strong></h4>" range="monthly" order_by="avg" post_type="town" limit=5 title_length=35 stats_views=0 wpp_start="<ul class="mb30">" wpp_end="</ul>"]');

	$popular_tx['spot'] = do_shortcode('[wpp header="Popular Spot" header_start="<h4><strong>" header_end="</strong></h4>" range="monthly" order_by="avg" post_type="spot" limit=5 title_length=35 stats_views=0 wpp_start="<ul class="mb30">" wpp_end="</ul>"]');

	$popular_tx['music'] = do_shortcode('[wpp header="Popular Music" header_start="<h4><strong>" header_end="</strong></h4>" range="monthly" order_by="avg" post_type="music" limit=5 title_length=35 stats_views=0 wpp_start="<ul class="mb30">" wpp_end="</ul>"]');

	$popular_cat['エリア'] = wp_list_categories('title_li=&taxonomy=area&echo=0&hide_empty=0');
	$popular_cat['スポット'] = wp_list_categories('title_li=&taxonomy=spot-tag&number=5&echo=0');
	$popular_cat['ミュージックジャンル'] = wp_list_categories('title_li=&taxonomy=music-tag&number=5&echo=0');

?>
<div class="sidebar">
<!--	<div class="banner">-->
<!--		<iframe frameborder="0" allowtransparency="true" height="200" width="200" marginheight="0" scrolling="no" src="http://ad.jp.ap.valuecommerce.com/servlet/htmlbanner?sid=3285436&pid=883983187" marginwidth="0"><script language="javascript" src="http://ad.jp.ap.valuecommerce.com/servlet/jsbanner?sid=3285436&pid=883983187"></script><noscript><a href="http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=3285436&pid=883983187" target="_blank" ><img src="http://ad.jp.ap.valuecommerce.com/servlet/gifbanner?sid=3285436&pid=883983187" height="200" width="200" border="0"></a></noscript></iframe>-->
<!--	</div>-->
<div class="banner text-center">
	<?php set_adsense('side-top'); ?>
</div>
<?php if (is_front_page()): // 検索結果表示 ?>
	<div class="thum_list">
		<?= $popular['page'] ?>
	</div>
	<div class="link_list">
		<?= $popular_tx['town'] ?>
		<?= $popular_tx['spot'] ?>
		<?= $popular_tx['music'] ?>
	</div>
	<div class="thum_list">
		<?= $popular['post'] ?>
	</div>
<?php
	echoTagList($popular_cat);

elseif (is_page()): // 固定ページ

	$id = $post->ID;
	$slug = $post->post_name;
	$parent_id = $post->post_parent;

	// ▼フォーム書き出し
	echoFormTag();

	if ($slug == 'town-list' || $slug == 'spot-list' || $slug == 'music-list') {
		echo '<div class="link_list">'."\n";
		foreach ($popular_tx as $key => $value) {
			if(strpos($slug, $key) !== false){
				echo $value;
				break;
			}
		}
		echo '</div>'."\n";
		echo '<div class="thum_list">'."\n";
		echo $popular['page'];
		echo '</div>'."\n";
		echo '<div class="link_list">'."\n";
		foreach ($popular_tx as $key => $value) {
			if(strpos($slug, $key) === false){
				echo $value;
			}
		}
		echo '</div>'."\n";
		echoTagList($popular_cat);
	} else {
		// 親ページがあった場合、子ページの一覧を取得
		if ($parent_id != 0) {
			$args = array(
				'posts_per_page'   => -1,
				'post_type'        => 'page',
				'post_parent'      => $parent_id,
				'exclude'          => $id
			);
			$child_posts = get_posts( $args );

			if ($child_posts) {
				echo '<h4><b>同じカテゴリの記事</b></h4>'."\n";
				foreach( $child_posts as $post ) {
					get_template_part('content', 'side1');
				}
			}
			wp_reset_query();	//Query Reset
		}
?>
		<div class="link_list">
			<?= $popular_tx['town'] ?>
			<?= $popular_tx['spot'] ?>
			<?= $popular_tx['music'] ?>
		</div>
		<div class="thum_list">
			<?= $popular['page'] ?>
			<?= $popular['post'] ?>
		</div>
<?php
		echoTagList($popular_cat);
	}

elseif (is_single()): // 記事ページ

	$id = $post->ID;
	$type = $post->post_type;
	$parent_id = $post->post_parent;

	// ▼フォーム書き出し
	echoFormTag();

	if ($type == 'town' || $type == 'spot' || $type == 'music') {
		echo '<div class="link_list">'."\n";
		foreach ($popular_tx as $key => $value) {
			if($type == $key) {
				echo $value;
				break;
			}
		}
		echo '</div>'."\n";
		echo '<div class="thum_list">'."\n";
		echo $popular['page'];
		echo '</div>'."\n";
		echo '<div class="link_list">'."\n";
		foreach ($popular_tx as $key => $value) {
			if($type != $key) {
				echo $value;
			}
		}
		echo '</div>'."\n";
		echoTagList($popular_cat);
	} else {
?>
		<div class="link_list">
			<?= $popular_tx['town'] ?>
			<?= $popular_tx['spot'] ?>
			<?= $popular_tx['music'] ?>
		</div>
		<div class="thum_list">
			<?= $popular['page'] ?>
			<?= $popular['post'] ?>
		</div>
<?php
		echoTagList($popular_cat);
	}
elseif (is_category()): // カテゴリーアーカイブ

	// ▼フォーム書き出し
	echoFormTag();
?>
	<div class="thum_list">
		<?= $popular['page'] ?>
	</div>
	<div class="link_list">
		<?= $popular_tx['town'] ?>
		<?= $popular_tx['spot'] ?>
		<?= $popular_tx['music'] ?>
	</div>
	<div class="thum_list">
		<?= $popular['post'] ?>
	</div>
<?php
	echoTagList($popular_cat);

elseif (is_tag()): // タグアーカイブ

	// ▼フォーム書き出し
	echoFormTag();
?>
	<div class="thum_list">
		<?= $popular['page'] ?>
	</div>
	<div class="link_list">
		<?= $popular_tx['town'] ?>
		<?= $popular_tx['spot'] ?>
		<?= $popular_tx['music'] ?>
	</div>
	<div class="thum_list">
		<?= $popular['post'] ?>
	</div>
<?php
	echoTagList($popular_cat);

elseif (is_tax()): // タグアーカイブ


	$id = $post->ID;
	$type = $post->post_type;
	$parent_id = $post->post_parent;

	// ▼フォーム書き出し
	echoFormTag();

	echo '<div class="link_list">'."\n";
	foreach ($popular_tx as $key => $value) {
		if($type == $key) {
			echo $value;
			break;
		}
	}
	echo '</div>'."\n";
	echo '<div class="link_list">'."\n";
	foreach ($popular_tx as $key => $value) {
		if($type != $key) {
			echo $value;
		}
	}
	echo '</div>'."\n";
	echo '<div class="thum_list">'."\n";
	echo $popular['page'];
	echo '</div>'."\n";
	echoTagList($popular_cat);
else:
?>
	<div class="thum_list">
		<?= $popular['page'] ?>
	</div>
	<div class="link_list">
		<?= $popular_tx['town'] ?>
		<?= $popular_tx['spot'] ?>
		<?= $popular_tx['music'] ?>
	</div>
	<div class="thum_list">
		<?= $popular['post'] ?>
	</div>
<?php
	echoTagList($popular_cat);
endif;
?>
	<div class="mt20 mb20 text-center">
		<?php set_adsense('side-bottom'); ?>
	</div>
</div>