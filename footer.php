	<div class="container">
		<div class="row">
			<div class="mt20 mb20 text-center">
				<?php set_adsense('footer'); ?>
			</div>
		</div>
	</div>
	<div id="anchor">
		<a href="#top"><img src="<?= WP_URL ?>/img/anchor.png" alt="TOPへ戻る" /></a>
	</div><!-- #anchor -->
	<div class="footerlink">
		<div class="container">
			<div class="ml05 mr05 mb20">
				<p class="ft_color3"><i class="glyphicon glyphicon-warning-sign ft_color2"></i> 注意点</p>
				<p class="ft_size8">
					このサイトに記載されている画像は当サイト管理人が2014年4月、2015年4月の2回現地を訪れ撮影した画像です。<br />
					掲載している情報もその際に収集した情報をもとにしていますので、最新の情報ではない場合があります。
				</p>
				<p class="ft_size8">実際に現地へ行かれる際は各種機関へお問い合わせの上、最新の情報を調査された上で渡航してください。<p>
				<p class="ft_size8">また、当サイトで使用している画像の無断転載を禁止します。</p>
			</div>
			<div class="visible-lg visible-md">
<?php
				$cat = get_categories('title_li=&taxonomy=area&echo=0&hide_empty=0');
				if ($cat) {
					echo '<h5 class="ft_color3 pb05"><i class="glyphicon glyphicon-search"></i> エリアから探す</h5>'."\n";
					echo '<ul class="list-inline">'."\n";
					foreach ($cat as $key => $value) {
						echo '<li><a href="'.home_url('area/'.$value->slug).'">'.$value->cat_name.'</a></li>'."\n";
					}
					echo '</ul>'."\n";
					echo '<hr />'."\n";
				}

				$cat = get_categories('title_li=&taxonomy=spot-tag&echo=0&hide_empty=0');
				if ($cat) {
					echo '<h5 class="ft_color3 pb05"><i class="glyphicon glyphicon-map-marker"></i> スポットジャンルから探す</h5>'."\n";
					echo '<ul class="list-inline">'."\n";
					foreach ($cat as $key => $value) {
						echo '<li><a href="'.home_url('spot-tag/'.$value->slug).'">'.$value->cat_name.'</a></li>'."\n";
					}
					echo '</ul>'."\n";
					echo '<hr />'."\n";
				}

				$cat = get_categories('title_li=&taxonomy=music-tag&echo=0&hide_empty=0');
				if ($cat) {
					echo '<h5 class="ft_color3 pb05"><i class="glyphicon glyphicon-music"></i> 音楽ジャンルから探す</h5>'."\n";
					echo '<ul class="list-inline">'."\n";
					foreach ($cat as $key => $value) {
						echo '<li><a href="'.home_url('music-tag/'.$value->slug).'">'.$value->cat_name.'</a></li>'."\n";
					}
					echo '</ul>'."\n";
					echo '<hr />'."\n";
				}
?>
			</div>
			<div class="clearfix divider mb30">
				<div class="col-md-4">
					<ul>
						<li><a href="<?= home_url() ?>">HOME</a></li>
						<li><a href="<?= home_url('town-list') ?>">アイスランド街情報</a></li>
						<li><a href="<?= home_url('spot-list') ?>">アイスランド観光地・名所情報</a></li>
						<li><a href="<?= home_url('music-list') ?>">アイスランド音楽情報</a></li>
						<li><a href="<?= home_url('photo-list') ?>">アイスランド写真館</a></li>
					</ul>
				</div>
				<div class="col-md-4">
					<ul>
						<li><a href="<?= home_url('about') ?>">アイスランド基本情報</a></li>
						<li><a href="<?= home_url('about/outline') ?>">アイスランドってこんなとこ</a></li>
						<li><a href="<?= home_url('about/drive') ?>">アイスランドを車で旅してみよう！</a></li>
						<li><a href="<?= home_url('about/golden-circle') ?>">ゴールデンサークルへ行ってみよう！</a></li>
						<li><a href="<?= home_url('about/rentalcar') ?>">レンタカーについて</a></li>
					</ul>
				</div>
				<div class="col-md-4">
					<ul>
						<li><a href="<?= home_url('travel') ?>">アイスランド旅行記</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<footer>
		Copyright(c) Icelandic Memo All Rights Reserved.
	</footer>
	<script src="<?= WP_URL ?>/js/jquery.mobile-menu.js"></script>
	<script src="<?= WP_URL ?>/js/imagelightbox.min.js"></script>
	<script src="<?= WP_URL ?>/js/script.js"></script>
	<?php wp_footer(); ?>
</body>
</html>