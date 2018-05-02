<?php
	// ■変数初期化
	$str_title       = '';
	$str_keywords    = '';
	$str_description = '';
	$str_h1          = '';
	$str_url         = 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

	// ▼タイトル、キーワード設定
	if (is_single()) {

		$post_type = get_post_type();

		switch ($post_type) {
			case 'post':
				$str_description = strip_tags($post->post_content);
				$str_description = str_replace('n', '', $str_description);
				$str_description = mb_substr($str_description, 0, 80).'…';
				$str_keywords = DEF_KEYWORDS;
				$str_h1 = get_the_title();
				$str_title = get_the_title().'｜'.SITE_NAME;
				break;
			case 'photo':
				$tmp = get_the_title();
				$str_h1 = 'アイスランドで撮影した【'.$tmp.'】の写真、画像';
				$str_title = $tmp.'｜アイスランド写真館｜'.SITE_NAME;
				$str_keywords = $tmp.',画像,写真,アイスランド,iceland';
				$str_description = 'アイスランドで撮影した【'.$tmp.'】の写真、画像を掲載しています。2014年、2015年に撮影した写真です。';
				break;
			case 'town':
				$str_h1 = 'アイスランドの街 【'.get_field('name').'】の街、観光情報';
				$str_title = get_field('name').'｜アイスランドの街、観光情報｜'.SITE_NAME;
				$str_keywords = get_field('name').','.get_field('is_name').',街,情報,アイスランド,iceland';
				$str_description = 'アイスランドの街「'.get_field('name').'(アイスランド表記：'.get_field('is_name').')」の街情報、観光情報、見どころ、実際に撮影した写真を掲載しています。';
				break;
			case 'spot':
				$str_h1 = 'アイスランドの【'.get_field('name').'】の観光地・名所・スポット情報';
				$str_title = get_field('name').'｜アイスランドの観光地・名所・スポット情報｜'.SITE_NAME;
				$str_keywords = get_field('name').','.get_field('is_name').',観光地,名所,スポット,アイスランド,iceland';
				$str_description = 'アイスランドの観光地・名所・スポット「'.get_field('name').'(アイスランド表記：'.get_field('is_name').')」の観光情報、見どころ、実際に撮影した写真を掲載しています。';
				break;
			case 'music':
				$tmp = get_the_title();
				$str_h1 = $tmp.'【'.get_field('name').'】のアイスランド音楽(アーティスト)情報';
				$str_title = $tmp.'('.get_field('name').')｜アイスランド音楽(アーティスト)情報｜'.SITE_NAME;
				$str_keywords = $tmp.','.get_field('name').','.get_field('is_name').',音楽,アーティスト,アイスランド,iceland';
				$str_description = 'アイスランドのアーティスト '.$tmp.'('.get_field('name').','.get_field('is_name').')」の音楽情報、動画、リリースした作品等を紹介しています。';
				break;
			default:
				$str_h1 = get_field('name');
				$str_title = get_field('name').'('.get_field('is_name').')｜'.SITE_NAME;
				$str_keywords = get_field('name').','.get_field('is_name').',アイスランド,iceland,情報';
				$str_description = get_field('name').'('.get_field('is_name').')の詳細ページです。'.DEF_DESCRIPTION;
				break;
		}
	} elseif (is_category()) {

		$cat_info = get_category( $cat );
		$name = esc_html($cat_info->cat_name);
		$description = esc_html($cat_info->category_description);

		$tmp = $name.'一覧';
		$str_h1 = $tmp;
		$str_title = $tmp.'｜'.SITE_NAME;
		$str_keywords = DEF_KEYWORDS;
		$str_description = $description;

	} elseif (is_tax()) {
		$name = single_cat_title('', false);
		$type = get_post_type();

		switch($type) {
			case 'music':
				$str_h1 = 'ジャンル【'.$name.'】のアイスランドアーティスト情報';
				$str_title = $name.'｜アイスランドアーティスト情報｜'.SITE_NAME;
				$str_keywords = $name.',音楽,アーティスト,アイスランド,iceland';
				$str_description = 'ジャンル【'.$name.'】のアイスランドのアーティストの情報を一覧で表示しています。';
				break;
			case 'photo':
				// $type_name = 'Iceland Photobooth-アイスランド写真館';
				break;
			case 'town':
				$str_h1 = $name.'の街、観光地情報';
				$str_title = $name.'｜街、観光地情報｜'.SITE_NAME;
				$str_keywords = $name.',街,観光地,名所,スポット,アイスランド,iceland';
				$str_description = $name.'の街、観光地、名所、スポットの情報を一覧で表示しています。';
				break;
			case 'spot':
				$str_h1 = 'アイスランドの'.$name.'情報';
				$str_title = 'アイスランドの'.$name.'情報｜観光地、名所、スポット情報｜'.SITE_NAME;
				$str_keywords = $name.',観光地,名所,スポット,アイスランド,iceland';
				$str_description = 'アイスランドの【'.$name.'】カテゴリの観光地、名所、スポットの情報を一覧で表示しています。';
				break;
			default:
				// $type_name = 'アイスランド街、観光地、名所、スポット情報';
				// $str_title = $name.'｜'.$type_name.'｜'.SITE_NAME;
				// $str_keywords = $name.',街,観光地,名所,スポット,アイスランド,iceland';
				// $str_description = $name.'の街、観光地、名所、スポットの情報を一覧で表示しています。';
				break;
		}
	} elseif (is_tag()) {

	} elseif (is_search()) {
		global $s;
		$str_h1 = '【'.$s.'】でのアイスランド情報検索結果';
		$str_title = '【'.$s.'】でのアイスランド情報検索結果｜'.SITE_NAME;
		$str_keywords = $s.',街,観光地,名所,スポット,アイスランド,iceland';
		$str_description = '【'.$s.'】でのアイスランド情報の検索結果を一覧で表示しています。';
	} elseif ( is_404() ) {
		// 404
		$str_h1 = 'ページが見つかりませんでした。';
		$str_title = 'ページが見つかりませんでした。｜'.SITE_NAME;
		$str_keywords = DEF_KEYWORDS;
		$str_description = 'ごめんなさい、ページが見つかりませんでした。別のキーワード、カテゴリからアイスランドの情報を見つける事が出来るかもしれませんよ！！';
	} else {
		// PAGE
		$str_h1 = get_field('seo_title');
		$str_title = get_field('seo_title').'｜'.SITE_NAME;
		$str_keywords = get_field('seo_keywords');
		$str_description = get_field('seo_description');
	}
	wp_reset_query();
?><!DOCTYPE html>
<html>
	<head lang="ja">
	<meta charset="utf-8">
	<meta http-equiv="Content-Language" content="ja">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title><?= $str_title ?></title>
	<meta name="title" content="<?= $str_title ?>" >
	<meta name="keywords" content="<?= $str_keywords ?>">
	<meta name="description" content="<?= $str_description ?>">
	<meta name="google-site-verification" content="ok3H4nugHQgKPIvDOxsrdAKv4VVzPqjzq-tWWgi6KL4">
	<!-- OG -->
	<?php if (is_front_page()) { ?>
	<meta property="og:type" content="website">
	<?php } else { ?>
	<meta property="og:type" content="article">
	<?php } ?>
	<meta property="og:image" content="<?= WP_URL ?>/img/iceland.png" />
	<meta property="og:url" content="<?= $str_url ?>">
	<meta property="og:locale" content="ja_JP">
	<meta property="og:description" content="<?= $str_description ?>">
	<meta property="og:title" content="<?= $str_title ?>">
	<!-- ICON -->
	<!--
	<link rel="apple-touch-icon" sizes="57x57" href="<?= SITE_URL ?>/favicons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?= SITE_URL ?>/favicons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= SITE_URL ?>/favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?= SITE_URL ?>/favicons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= SITE_URL ?>/favicons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?= SITE_URL ?>/favicons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?= SITE_URL ?>/favicons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?= SITE_URL ?>/favicons/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= SITE_URL ?>/favicons/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="<?= SITE_URL ?>/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="<?= SITE_URL ?>/favicons/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="<?= SITE_URL ?>/favicons/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="<?= SITE_URL ?>/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="<?= SITE_URL ?>/favicons/manifest.json">
	<meta name="msapplication-TileColor" content="#00a300">
	<meta name="msapplication-TileImage" content="<?= SITE_URL ?>/favicons/mstile-144x144.png">
	<meta name="theme-color" content="#ffffff">
	-->
	<!-- CSS -->
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="<?= WP_URL ?>/css/bootstrap.css">
	<!-- Custom styles for this template -->
	<link rel="stylesheet" href="<?= WP_URL ?>/css/main.css">
	<link rel="stylesheet" href="<?= WP_URL ?>/css/imagelightbox.css">
	<link rel="stylesheet" href="<?= WP_URL ?>/css/jquery.mobile-menu.css">
	<!-- Web fonts -->
	<link rel="stylesheet" href='//fonts.googleapis.com/css?family=Raleway:400,300,700'>
	<!-- <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Just+Me+Again+Down+Here"> -->
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:900,400" type="text/css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
	<!-- JS -->
	<script src="<?= WP_URL ?>/js/jquery.min.js"></script>
	<script src="<?= WP_URL ?>/js/bootstrap.min.js"></script>
	<script src="http://maps.google.com/maps/api/js"></script>
	<!--[if lt IE 9]>
	<script src="<?= WP_URL ?>/js/html5shiv.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body id="top">
	<header>
		<div class="container">
			<h1><?= $str_h1 ?></h1>
			<div class="row">
				<div class="clearfix">
					<div class="col-md-4 logo">
						<a href="<?= home_url() ?>"><img src="<?= WP_URL ?>/img/logo.png" class="img-responsive center-block" alt="<?= SITE_NAME ?>" /></a>
					</div>
					<div class="col-md-8 hidden-xs">
						<ul class="menu list-inline center-block">
							<li><a href="<?= home_url('town-list') ?>"><img src="<?= WP_URL ?>/img/menu/town.png" alt="街情報" /><br />TOWN</a></li>
							<li><a href="<?= home_url('spot-list') ?>"><img src="<?= WP_URL ?>/img/menu/spot.png" alt="観光地・名所・スポット情報" /><br />SPOT</a></li>
							<li><a href="<?= home_url('music-list') ?>"><img src="<?= WP_URL ?>/img/menu/music.png" alt="音楽(アーティスト)情報" /><br />MUSIC</a></li>
							<li><a href="<?= home_url('photo-list') ?>"><img src="<?= WP_URL ?>/img/menu/photo.png" alt="写真館" /><br />PHOTO</a></li>
							<li><a href="<?= home_url('about') ?>"><img src="<?= WP_URL ?>/img/menu/about.png" alt="アイスランド情報" /><br />ABOUT</a></li>
							<li><a href="<?= home_url('travel') ?>"><img src="<?= WP_URL ?>/img/menu/blog.png" alt="アイスランド旅行記" /><br />TRAVEL</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>
	<div class="visible-xs">
		<div class="mobile-menu">
			<div id="mainWrap">
				<nav id="mobile-bar"></nav>
			</div> <!-- #mainWrap -->
			<nav id="nav1">
				<ul>
					<li><a href="<?= home_url() ?>">HOME</a></li>
					<li><a href="<?= home_url('town-list') ?>">街情報</a></li>
					<li><a href="<?= home_url('spot-list') ?>">観光地・名所・スポット情報</a></li>
					<li><a href="<?= home_url('music-list') ?>">音楽(アーティスト)情報</a></li>
					<li><a href="<?= home_url('photo-list') ?>">写真館</a></li>
					<li><a href="<?= home_url('about') ?>">アイスランド情報</a></li>
					<li><a href="<?= home_url('travel') ?>">アイスランド旅行記</a></li>
				</ul>
			</nav><!-- #nav1 -->
		</div><!-- .mobile-menu -->
	</div><!-- .visible-xs visible-sm -->
	<?php if (is_front_page()) { ?>
	<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "WebSite",
		"url": "<?= home_url() ?>",
		"potentialAction": {
			"@type": "SearchAction",
			"target": "<?= home_url() ?>?s={search_term}",
			"query-input": "required name=search_term"
		}
	}
	</script>
	<div class="main_search_block">
		<div class="searchbox">
			<p class="en_highlight">Search Iceland</p>
			<p class="mb20 ft_color1">アイスランドの街、スポット等の名称を入力して下さい。</p>
			<?= get_search_form(false); ?>
		</div>
	</div>
	<?php } ?>