<?php
//-----------------------------------------------------
// ■カスタム投稿登録時使用関数
//-----------------------------------------------------

// ▼カスタム投稿設定
//-----------------------------------------------------
add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'spot',
		array(
			'labels' => array(
			'name' => __( 'SPOTLIST' ),
			'singular_name' => __( 'SPOTLIST' )
		),
		'public' => true,
		'menu_position' =>5,
		'menu_icon' => 'dashicons-location',
		'rewrite' => array('with_front' => false),
		'has_archive' => false,
		)
	);

	register_post_type( 'town',
		array(
			'labels' => array(
			'name' => __( 'TOWNLIST' ),
			'singular_name' => __( 'TOWNLIST' )
		),
		'public' => true,
		'menu_position' =>6,
		'menu_icon' => 'dashicons-admin-home',
		'rewrite' => array('with_front' => false),
		'has_archive' => fasle,
		)
	);

	register_post_type( 'music',
		array(
			'labels' => array(
			'name' => __( 'MUSICLIST' ),
			'singular_name' => __( 'MUSICLIST' )
		),
		'public' => true,
		'menu_position' =>7,
		'menu_icon' => 'dashicons-format-audio',
		'rewrite' => array('with_front' => false),
		'has_archive' => fasle,
		)
	);

	register_post_type( 'photo',
		array(
			'labels' => array(
			'name' => __( 'PHOTOLIST' ),
			'singular_name' => __( 'PHOTLIST' )
			),
		'supports' => array('title', 'editor', 'thumbnail'),
		'public' => true,
		'menu_position' =>8,
		'menu_icon' => 'dashicons-camera',
		'rewrite' => array('with_front' => false),
		'has_archive' => fasle,
		)
	);
}

// ▼カスタムタクソノミー　カテゴリ追加
//-----------------------------------------------------
/*
register_taxonomy(
	'genre', // 分類名
	'photo',  // 投稿タイプ名
	array(
		'label' => '種別', 		// フロントで表示する分類名
		'hierarchical' => true,		// 階層構造か否か（trueの場合はカテゴリー、falseの場合はタグ）
		'query_var' => true,
		'rewrite' => true
	)
);
*/
register_taxonomy(
	'area',
	'town',
	array(
		'label' => 'エリア',
		'hierarchical' => true,
		'query_var' => true,
		'rewrite' => true
	)
);

register_taxonomy(
	'spot-area',
	'spot',
	array(
		'label' => 'エリア',
		'hierarchical' => true,
		'query_var' => true,
		'rewrite' => true
	)
);

// ▼カスタムタクソノミー　タグ追加
//-----------------------------------------------------
/*register_taxonomy(
	'town-tag',
	'town',
	array(
		'label' => 'タグ',
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true
	)
);*/

register_taxonomy(
	'spot-tag',
	'spot',
	array(
		'label' => 'タグ',
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_tagcloud' => true
	)
);

register_taxonomy(
	'music-tag',
	'music',
	array(
		'label' => 'タグ',
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true
	)
);

// ▼パーマリンクを数字設定へ
//-----------------------------------------------------
add_filter( 'post_type_link', 'my_post_type_link', 1, 2 );
function my_post_type_link( $link, $post ){
	if ( 'photo' === $post->post_type ) {
		return home_url( '/photo/' . $post->ID );
	} else {
		return $link;
	}
}
add_filter( 'rewrite_rules_array', 'my_rewrite_rules_array' );
function my_rewrite_rules_array( $rules ) {
	$new_rules = array(
		'photo/([0-9]+)/?$' => 'index.php?post_type=photo&p=$matches[1]',
	);
	return $new_rules + $rules;
}

// ▼ページングの際のエラー対策
//-----------------------------------------------------
function category_display_five_articles( $wp_query ) {
	if (!is_admin() && $wp_query->is_main_query()) {
		$wp_query->set('posts_per_page', get_option('posts_per_page'));
	}
}
add_action( 'pre_get_posts', 'category_display_five_articles' );


//-----------------------------------------------------
// ■管理画面カスタム使用関数
//-----------------------------------------------------

// ▼ログイン画面の画像変更
function custom_login_logo() {
	echo '<style type="text/css">h1 a { width: 300px !important; background: url('.WP_URL.'/img/logo.png) no-repeat !important; }</style>';
}
add_action('login_head', 'custom_login_logo');

// ▼フッター「WordPressリンク」を変更
function custom_admin_footer() {
	echo '';
}
add_filter('admin_footer_text', 'custom_admin_footer');


// ▼管理上部メニューバーの項目の非表示
function mytheme_remove_item( $wp_admin_bar ) {
	$wp_admin_bar->remove_node('updates');		// アップデート通知
	$wp_admin_bar->remove_node('wp-logo');		// Wpロゴ
	$wp_admin_bar->remove_node('comments');		// コメント
	$wp_admin_bar->remove_node('new-content');	// 新規投稿ボタン
	/* 管理バー右の部分 */
	$wp_admin_bar->remove_node('edit-profile');	// プロフィール編集
	$wp_admin_bar->remove_node('user-info');	// ユーザー
}
add_action( 'admin_bar_menu', 'mytheme_remove_item', 1000 );


// ▼ダッシュボードウィジェットの項目非表示
function example_remove_dashboard_widgets() {
	if (!current_user_can('level_10')) { //level10以下のユーザーの場合ウィジェットをunsetする
		global $wp_meta_boxes;
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);		// 現在の状況
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);	// 最近のコメント
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);	// 被リンク
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);			// プラグイン
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);		// 最近の下書き
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);			// WordPressブログ
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);			// WordPressフォーラム
	}
 }
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets');


// ▼左サイドメニュー項目削除・変更
function remove_menus () {
	if (!current_user_can('level_10')) { //level10以下のユーザーの場合
		remove_menu_page('wpcf7'); //Contact Form 7
		global $menu;
		//unset($menu[2]); // ダッシュボード
		//unset($menu[4]); // メニューの線1
		//unset($menu[5]); // 投稿
		//unset($menu[10]); // メディア
		unset($menu[15]); // リンク
		// unset($menu[20]); // ページ
		unset($menu[25]); // コメント
		//unset($menu[59]); // メニューの線2
 		unset($menu[60]); // テーマ
		unset($menu[65]); // プラグイン
		unset($menu[70]); // プロフィール
		unset($menu[75]); // ツール
		unset($menu[80]); // 設定
		unset($menu[90]); // メニューの線3
	}
}
add_action('admin_menu', 'remove_menus');

// ▼左サイドメニュー項目名称変更
function edit_admin_menus() {
	// if (!current_user_can('level_10')) { //level10以下のユーザーの場合
	global $menu;
	global $submenu;

	$menu[5][0] = 'POST';
	$menu[10][0] = 'MEDIA';
	$menu[20][0] = 'PAGE';
		//$submenu['edit.php'][5][0] = 投稿一覧をその他一覧へ変更;
	// }
}
add_action( 'admin_menu', 'edit_admin_menus' );


//-----------------------------------------------------
// ■投稿登録時使用関数
//-----------------------------------------------------

// ▼アイキャッチ表示設定
add_theme_support('post-thumbnails');

// ▼カテゴリ選択をラジオボタンに
if(strstr($_SERVER['REQUEST_URI'], 'wp-admin/post.php')) {
	ob_start('one_category_only');
}
if(strstr($_SERVER['REQUEST_URI'], 'wp-admin/post-new.php')) {
	ob_start('one_category_only');
}
function one_category_only($content) {
	$content = str_replace('type="checkbox" name="post_category', 'type="radio" name="post_category', $content);
	return $content;
}

// ▼カテゴリ新規追加消去
function hide_category_tabs_adder() {
	global $pagenow;
	global $post_type;
	if (is_admin() && ($pagenow=='post-new.php' || $pagenow=='post.php' || $post_type=='article') ){
		echo '<style type="text/css">
		#category-tabs, #category-adder, #genre-tabs {display:none;}
		#xxx-tabs, #xxx-adder {display:none;}

		.categorydiv .tabs-panel {padding: 0 !important; background: none; border: none !important;}
		</style>';
	}
}
add_action( 'admin_head', 'hide_category_tabs_adder' );


// ▼投稿画面用CSS読み込み
add_editor_style();

// ▼投稿画面カスタマイズ
function custom_editor_settings( $initArray ){
	$initArray['block_formats'] = '見出し3=h3; 見出し4=h4; 見出し5=h5; 段落=p; グループ=div;';

	return $initArray;
}
add_filter( 'tiny_mce_before_init', 'custom_editor_settings' );




//-----------------------------------------------------
// ■投稿一覧表示時使用関数
//-----------------------------------------------------

// ▼記事表示数の変更
function my_edit_posts_per_page($posts_per_page) {
	return 60;
}
add_filter('edit_posts_per_page', 'my_edit_posts_per_page');


// ▼投稿一覧から項目を除外
function custom_columns($columns) {
		unset($columns['tags']);
		unset($columns['comments']);
		return $columns;
}
add_filter( 'manage_posts_columns', 'custom_columns' );


// ▼投稿一覧へ項目追加
function add_thumb_columns( $columns ) {
	// サムネイル用のスタイル
	echo '<style>.column-thumb{width:80px;} #title{width:300px;}</style>';
	// カラム追加
	$columns = array_reverse( $columns, true );
	$columns['thumb'] = '<div class="dashicons dashicons-format-image"></div>';
	$columns = array_reverse( $columns, true );
	$columns['modified'] = '最終更新日';
	return $columns;
}
add_filter( 'manage_edit-town_columns', 'add_thumb_columns' );
add_filter( 'manage_edit-spot_columns', 'add_thumb_columns' );
add_filter( 'manage_edit-music_columns', 'add_thumb_columns' );


// ▼投稿一覧へ項目データ追加処理
function add_thumb_column( $column, $post_id ) {
	$strImage  = '';
	$post_type = get_post_type( $post_id );

	switch ( $column ) {
		// 画像表示部分枠
		case 'thumb':
			if ($post_type == 'music') {
				$thumb = imageyoutube(get_field('youtube'));
				$thumb = imgNotFound($thumb);
			} else {
				$thumb = wp_get_attachment_image_src(get_field('image'), 'thumbnail');
				$thumb = imgNotFound($thumb[0]);
			}

			// 編集権限、ゴミ箱内かどうかの判別用変数
			$user_can_edit = current_user_can( 'edit_post', $post_id );
			$is_trash = isset( $_REQUEST['status'] ) && 'trash' == $_REQUEST['status'];

			// 編集権限があり、ゴミ箱でないなら画像をリンクつきに
			if ( ! $is_trash || $user_can_edit ) {
				$strImage .= '<a href="'.get_edit_post_link( $post_id, true ).'">';
				$strImage .= '<img src="'.$thumb.'" class="column-thumb" />';
				$strImage .= '</a>';
			}

			// 出力
			echo $strImage;

			break;
		// 最終更新日
		case 'modified':
			echo get_the_modified_date();
			break;
		default:
			break;
	}
}
add_action( 'manage_posts_custom_column', 'add_thumb_column', 10, 2 );


//-----------------------------------------------------
// ■ページ表示時使用関数
//-----------------------------------------------------

// ▼wp_headの不要タグ除去
//-----------------------------------------------------
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_print_styles', 8 );
remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_head', 'rel_shortlink' );
remove_action('wp_head', 'wp_shortlink_wp_head');



// ▼ユーザーエージェント確認、振り分け
//-----------------------------------------------------
function check_useragent(){
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$temp_flg = false;

	if ( strpos( $user_agent, 'iPhone' ) !== false
		|| strpos( $user_agent, 'Android' ) !== false
		|| strpos( $user_agent, 'iPod' ) !== false ){
		$temp_flg = true;
	}
	return $temp_flg;
}


// ▼パンくず作成
//-----------------------------------------------------
function breadcrumb() {
	global $post;

	$html = '';
	$mark_li = ' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"';
	$home_icon = '<i class="glyphicon glyphicon-home"></i> ';

	$array_bc = array();
	$array_bc[0]['icon']  = ;
	$array_bc[0]['url']   = home_url();
	$array_bc[0]['title'] = 'Icelandic-Memo';


	// 検索結果表示
	if (is_search())
	{
		$temp = wp_specialchars(get_search_query(), 1);
		$array_bc[1]['url']   = '';
		$array_bc[1]['title'] = $keyword.'の検索結果';
	}
	// タクソノミータグアーカイブ
	elseif (is_tag() || is_tax())
	{
		$temp = single_cat_title('', false);
		$array_bc[1]['url']   = '';
		$array_bc[1]['title'] = $temp;
	}
	// 404 Not Found
	elseif (is_404())
	{
		$array_bc[1]['url']   = '';
		$array_bc[1]['title'] = '404 Not Found';
	}
	// カテゴリーアーカイブ
	elseif (is_category())
	{
		$array_bc[1]['url']   = home_url('blog');
		$array_bc[1]['title'] = 'ブログ';

		$cat = get_category(get_cat_ID( single_cat_title('', false)));

		// if ($cat->parent)
		// {
		// 	// 親カテゴリがある場合
		// 	$cate_pare = get_category_parents( get_cat_ID( single_cat_title('', false) ), true, SEPA );

		// 	// get_category_parentsが自カテゴリも生成しちゃうので除去
		// 	for ( $i=0; $i<2; $i++; )
		// 	{
		// 		$cate_pare = substr($cate_pare, 0, strrpos($cate_pare, SEPA));
		// 	}

		// 	// 親カテゴリ
		// 	$array_bc[2]['url']   = '';
		// 	$array_bc[2]['title'] = $cate_pare;
		// }

		$array_bc[3]['url']   = '';
		$array_bc[3]['title'] = single_cat_title('', false);
	}
	// 固定ページ
	elseif (is_page())
	{
		$id = $post->ID;

		// 親ページがある場合はリンク追加
		$parent_id = $post->post_parent;
		if ($parent_id != '')
		{
			$array_bc[1]['url']   = get_the_permalink($parent_id);
			$array_bc[1]['title'] = get_the_title($parent_id);
		}

		$array_bc[2]['url']   = '';
		$array_bc[2]['title'] = get_the_title($id);
	}
	// 記事ページ
	elseif (is_single())
	{
		$id = $post->ID;
		$post_type = $post->post_type;

		// 投稿記事
		if ($post_type == 'post')
		{
			$category       = get_the_category();
			$category_id    = $category[0]->term_id; // カテゴリID
			$cate_parent_id = $category[0]->parent; // 親カテゴリID

			// 親カテゴリがある場合は表示
			if ($cate_parent_id != 0)
			{
				$p_category = get_the_category($cate_parent_id);
				$p_category_name = $p_category[0]->name;
				$p_category_slug = $p_category[0]->slug;

				$array_bc[1]['url']   = home_url($p_category_slug);
				$array_bc[1]['title'] = $p_category_name;
			}

			// 自身のカテゴリを設定
			$category_name = $category[0]->name;
			$category_slug = $category[0]->slug;

			$array_bc[2]['url']   = home_url($category_slug);
			$array_bc[2]['title'] = $category_name;
		}
		else
		{
			// カスタム投稿の場合は各一覧ページを表示
			$aryTemp = retParentPage($post_type);

			$array_bc[1]['url']   = home_url($aryTemp[1]);
			$array_bc[1]['title'] = $aryTemp[0];

			if ($post_type == 'town' || $post_type == 'spot')
			{
				// 街情報、スポット情報の場合はカテゴリを表示
				$taxo_name = '';
				if ($post_type == 'town')
				{
					$taxo_name = 'area';
				}
				else
				{
					$taxo_name = 'spot-area';
				}

				// タクソノミー情報を取得し、リンク追加
				$terms = get_the_terms($id, $taxo_name);
				foreach ($terms as $term)
				{
					$tx_slug = $term->slug;
					$tx_name = $term->name;
				}

				if ($tx_slug != '' && $tx_name != '')
				{
					$array_bc[2]['url']   = home_url('area/'.$tx_slug);
					$array_bc[2]['title'] = $tx_name;
				}
			}
		}

		$array_bc[3]['url']   = '';
		$array_bc[3]['title'] = get_the_title($id);
	}
	// 上記以外
	else
	{

	}


	// パンくずタグ整形
	$breadcrumb = '';
	$i = 1;

	foreach ($array_bc as $key => $value)
	{
		if ($key == 0)
		{
			$breadcrumb .= $home_icon;
		}
		if ($value['url'] != '')
		{
			$breadcrumb .= '<a href="'.$value['url'].'" itemprop="item"><span itemprop="name">'.$value['title'].'</span></a>';
		}
		else
		{
			$breadcrumb .= '<span itemprop="name">'.$value['title'].'</span>';
		}

		$breadcrumb .= '<meta itemprop="position" content="'.$i.'" />';
		$breadcrumb .= '<li'.$mark_li.'>'.$breadcrumb.'</li>'."\n";
		$i++;
	}

	if ($breadcrumb)
	{
		$html .= '<ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">'."\n";
		$html .= $breadcrumb;
		$html .= '</ul>'."\n";
	}

	return $html;
}

// ▼post typeから上層ページを取得
//-----------------------------------------------------
function retParentPage($post_type) {
	$ret = array();
	switch($post_type) {
		case 'town':
			$ret[] = '街・村';
			$ret[] = 'town-list';
			break;
		case 'spot':
			$ret[] = '観光地・名所・スポット';
			$ret[] = 'spot-list';
			break;
		case 'music':
			$ret[] = '音楽・アーティスト';
			$ret[] = 'music-list';
			break;
		case 'photo':
			$ret[] = '写真';
			$ret[] = 'photo-list';
			break;
	}
	return $ret;
}


// ▼街情報、スポット情報、音楽情報データ変換
//-----------------------------------------------------
function convData($id, $type=''){

	$arytemp = array();

	switch ($type) {
		case 'music':
			$tmp[0] = imageyoutube(get_field('youtube', $id));
			break;
		case 'photo':
			$tmp = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'thumbnail');
			break;
		default:
			$tmp = get_field('image',$id);
			$tmp = wp_get_attachment_image_src($tmp,'thumbnail');
			break;
	}


	if ($type == 'photo') {
		$arytemp['image']   = esc_url(imgNotFound($tmp[0]));
		$arytemp['name']    = esc_html(get_the_title($id));
		$arytemp['text']    = esc_html(getTheExcerpt($id, 50));
		$arytemp['link']    = esc_url(get_permalink($id));
	} else {
		$arytemp['image']   = esc_url(imgNotFound($tmp[0]));
		$arytemp['name']    = esc_html(get_field('name', $id));
		$arytemp['is_name'] = esc_html(get_field('is_name', $id));
		$arytemp['text']    = esc_html(strip_tags(get_field('text', $id)));
		$arytemp['link']    = esc_url(get_permalink($id));
		$arytemp['date']    = '';

		if (mb_strlen($arytemp['text']) > 49) $arytemp['text'] = mb_substr($arytemp['text'], 0, 49). '…';

		$map_temp = get_field('map', $id);
		$arytemp['lat'] = esc_html($map_temp['lat']);
		$arytemp['lng'] = esc_html($map_temp['lng']);
	}
	return $arytemp;
}

// ▼街情報、スポット情報、音楽情報データ変換(地図表示用)
//-----------------------------------------------------
function convDataMap($id){

	$arytemp = array();

	$tmp = get_field('image',$id);
	$tmp = wp_get_attachment_image_src($tmp,'thumbnail');
	$arytemp['image']   = esc_url(imgNotFound($tmp[0]));
	$arytemp['name']    = esc_html(get_field('name', $id));
	$arytemp['is_name'] = esc_html(get_field('is_name', $id));
	$arytemp['link']    = esc_url(get_permalink($id));

	$map_temp = get_field('map', $id);
	$arytemp['lat'] = esc_html($map_temp['lat']);
	$arytemp['lng'] = esc_html($map_temp['lng']);

	return $arytemp;
}

// ▼検索情報データ変換(search.phpで利用)
//-----------------------------------------------------
function convDataSearch(){

	global $post;

	$arytemp = array();

	$id   = $post->ID;
	$type = $post->post_type;

	if ($type == 'post' || $type == 'page') {
		// ブログ投稿記事
		$tmp = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'thumbnail');

		$arytemp['image']   = esc_url(imgNotFound($tmp[0]));
		$arytemp['name']    = esc_html(get_the_title( $id ));
		$arytemp['is_name'] = '';
		$arytemp['text']    = esc_html(getTheExcerpt($id, 50));
		$arytemp['link']    = esc_url(get_permalink($id));
		$arytemp['date']    = esc_url($post->post_modified);

	} else {
		// カスタムタクソノミー
		$arytemp = convData($id, $type);
	}

	$arytemp['type'] = $type;
	switch ($type) {
		case 'music':
			$arytemp['type_name'] = '音楽情報';
			break;
		case 'town':
			$arytemp['type_name'] = '街情報';
			break;
		case 'spot':
			$arytemp['type_name'] = 'スポット情報';
			break;
		case 'photo':
			$arytemp['type_name'] = '写真集';
			break;
		default:
			$arytemp['type_name'] = 'ブログ';
			break;
	}

	$arytemp['cat'] = getCategoryTag($post, $type);

	return $arytemp;
}


// ▼埋め込みyoutubeURL作成
function embedyoutube($id) {
	return 'https://www.youtube.com/embed/'.$id;
}

// ▼画像youtubeURL作成
function imageyoutube($id) {
	// return 'http://img.youtube.com/vi/'.$id.'/mqdefault.jpg';
	return 'http://img.youtube.com/vi/'.$id.'/0.jpg';
}


// ▼画像が無い場合にNotfound画像表示
function imgNotFound($url) {
	$ret = '';

	// 画像登録無しの場合
	if ($url == '') {
		$ret = WP_URL.'/img/img_not_found.jpg';
	} else {
		$ret = $url;
	}
	return $ret;
}


// ▼投稿別カテゴリ、タグの取得
function getCategoryTag($post, $type) {
	$aryTemp = array();
	$aryTemp['cat'] = array();
	$aryTemp['tag'] = array();

	$terms = '';
	if ($type == 'post') {
		// カテゴリ
		$cat = get_the_category($post -> ID);
		if ($cat){
			foreach ( $cat as $key => $value ) {
				$tmp = array();
				$tmp[] = esc_url(get_category_link($value->cat_ID));
				$tmp[] = esc_html($value->cat_name);
				array_push($aryTemp['cat'], $tmp);
			}
		}

		// タグ
		$tag = get_the_tags($post -> ID);
		if ($tag) {
			foreach ( $tag as $key => $value ) {
				$tmp = array();
				$tmp[] = esc_url(get_tag_link($value->term_id));
				$tmp[] = esc_html($value->name);
				array_push($aryTemp['tag'], $tmp);
			}
		}
	} else {
		switch ($type) {
			case 'town':
				$terms_cat = get_the_terms($post -> ID, 'area');
				$terms_tag = get_the_terms($post -> ID, 'town-tag');
				break;
			case 'music':
				$terms_cat = '';
				$terms_tag = get_the_terms($post -> ID, 'music-tag');
				break;
			case 'spot':
				$terms_cat = get_the_terms($post -> ID, 'spot-area');
				$terms_tag = get_the_terms($post -> ID, 'spot-tag');
				break;
			default:
				$terms_cat = '';
				$terms_tag = '';
				break;
		}

		// ■カテゴリ
		if ($terms_cat != '') {
			foreach ( $terms_cat as $term ) {
				$taxonomy = $term->taxonomy;
				$slug = $term->slug;
				$name = $term->name;

				$tmp = array();
				$tmp[] = esc_url(home_url($taxonomy.'/'.$slug));
				$tmp[] = esc_html($name);

				array_push($aryTemp['cat'], $tmp);
			}
		}

		// ■タグ
		if ($terms_tag != '') {
			foreach ( $terms_tag as $term ) {
				$taxonomy = $term->taxonomy;
				$slug = $term->slug;
				$name = $term->name;

				$tmp = array();
				$tmp[] = esc_url(home_url($taxonomy.'/'.$slug));
				$tmp[] = esc_html($name);

				array_push($aryTemp['tag'], $tmp);
			}
		}
	}

	return $aryTemp;
}

// ▼ループ外から抜粋文取得
function getTheExcerpt($post_id='', $length=120){
	global $post; $post_bu = '';
	$t = '';

	if(!$post_id){
		$post_id = get_the_ID();
	} else {
		$post_bu = $post;
		$post = get_post($post_id);
	}
	$mojionly = strip_tags($post->post_content);
	if(mb_strlen($mojionly ) > $length) $t = '...';
	$content =  mb_substr($mojionly, 0, $length);
	$content .= $t;
	if($post_bu) $post = $post_bu;
	return $content;
}

// ▼ページネーション
function pagination($pages = '', $range = 4) {

	$pager = '';
	$showitems = ($range * 2)+1;

	global $paged;
	if(empty($paged)) $paged = 1;

	if($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;

		if(!$pages) {
			$pages = 1;
		}
	}

	if (1 != $pages) {
		$pager .= '<nav>'."\n";
		$pager .= '<ul class="pagination">'."\n";

		if ($paged > 2 && $paged > $range+1 && $showitems < $pages) {
			$pager .= "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
		}
		if ($paged > 1 && $showitems < $pages) {
			$pager .= "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";
		}

		for ($i=1; $i <= $pages; $i++) {

			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
				if ($paged == $i) {
					$pager .= '<li class="active"><a href="#">'.$i.'</a></li>'."\n";
				} else {
					$pager .= '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>'."\n";
				}
			}
		}
		if ($paged < $pages && $showitems < $pages) {
			$pager .= "<li><a href=\"".get_pagenum_link($paged + 1)."\">&rsaquo;</a></li>";
		}
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) {
			$pager .= "<li><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
		}

		$pager .= '</ul>'."\n";
		$pager .= '</nav>'."\n";
	}

	return $pager;
}

// ▼検索フォームを吐き出す
function echoFormTag() {
	echo '<h4><b>Contents Search</b></h4>'."\n";
	echo '<form action="'.home_url().'/" method="get" class="form-inline">'."\n";
	echo '<div class="input-group">'."\n";
	echo '<input type="text" class="form-control" name="s" placeholder="キーワードを入力">'."\n";
	echo '<span class="input-group-btn">'."\n";
	echo '<button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search ft_size8"></i></button>'."\n";
	echo '</span>'."\n";
	echo '</div>'."\n";
	echo '</form>'."\n";
}

// ▼タグ一覧を書きだす
function echoTagList($popular_cat) {
	foreach ($popular_cat as $key => $value) {
		echo '<div class="link_list">'."\n";
		echo '<h4><b>'.$key.'</b></h4>'."\n";
		echo '<ul class="mb30">'."\n";
		echo $value;
		echo '</ul>'."\n";
		echo '</div>'."\n";
	}
}




// 自作ソーシャルボタン＋SNS Count Cache連携（記事上部）
function SNS_btn_horizontal_head($url, $title) {

?>
<div class="sns_head sns_button">
	<ul class="list-inline">
		<li class="facebook">
			<a href="http://www.facebook.com/sharer.php?src=bm&u=<?= $url ?>&t=<?= $title ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="blank" title="Facebookでシェア！">
				<span><b class="share-num">&nbsp;<?php if(function_exists('scc_get_share_facebook')) echo (scc_get_share_facebook()==0)?'0':scc_get_share_facebook(); ?></b></span>
			</a>
		</li>
		<li class="twitter">
			<a href="http://twitter.com/intent/tweet?url=<?= $url ?>&text=<?= $title ?>&tw_p=tweetbutton" target="blank" title="ツイートする！">
				<span><b class="share-num">&nbsp;<?php if(function_exists('scc_get_share_twitter')) echo (scc_get_share_twitter()==0)?'0':scc_get_share_twitter(); ?></b></span>
			</a>
		</li>
		<li class="google">
			<a href="https://plus.google.com/share?url=<?= $url ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=500');return false;" target="blank" title="+1する！">
				<span><b class="share-num">&nbsp;<?php if(function_exists('scc_get_share_gplus')) echo (scc_get_share_gplus()==0)?'0':scc_get_share_gplus(); ?></b></span>
			</a>
		</li>
	</ul>
</div>
<?php
}
?>