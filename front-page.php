<?php
	// HEADER
	get_header();
?>
<div class="container">
	<div class="row">
		<div class="clearfix">
			<div class="col-md-9">
				<section>
					<div class="clearfix">
						<div class="col-md-6">
							<p><a href="<?= home_url('about') ?>"><img src="<?= WP_URL ?>/img/top1.png" alt="アイスランド情報" class="img-responsive center-block"></a></p>
							<p class="text-center ft_size12"><strong><a href="<?= home_url('about') ?>">アイスランド旅行情報</a></strong></p>
							<p class="subtitle">実際アイスランドに行った際に調べた情報、現地での情報、豆知識等紹介しています。</p>
						</div>
						<div class="col-md-6">
							<p><a href="<?= home_url('travel') ?>"><img src="<?= WP_URL ?>/img/top2.jpg" alt="アイスランド旅行記" class="img-responsive center-block"></a></p>
							<p class="text-center ft_size12"><strong><a href="<?= home_url('travel') ?>">アイスランド旅行記</a></strong></p>
							<p class="subtitle">2014、2015の2回アイスランドを訪れた際の旅行記です。※任意執筆中</p>
						</div>
					</div>
				</section>
				<hr />
				<!-- TOWN -->
				<section>
					<h2>アイスランドの街、村情報</h2>
					<p class="subtitle">アイスランドの街、村情報の一覧です。実際に訪れた際の写真も掲載しています。</p>
					<div class="clearfix mb10">
<?php
					$args = array(
						'numberposts' => 8,
						'post_type'   => 'town'
					);
					$home_posts = get_posts($args);

					if ($home_posts) {
						foreach($home_posts as $post){
							get_template_part('content', 'home');
						}
					} else {
						echo '<p>Not Available</p>'."\n";
					}
					wp_reset_query();	//Query Reset
?>
					</div>
					<p class="mb20 text-center"><a href="<?= home_url('town-list') ?>" class="btn btn-primary btn-danger">アイスランドの街、村情報</a></p>
				</section><!-- section -->
				<hr />
				<!-- SPOT -->
				<section>
					<h2>アイスランド観光地、名所、スポット情報</h2>
					<p class="subtitle">メジャーな所からマイナーな所まで、アイスランドの観光地、名所、スポット情報一覧です。</p>
					<div class="clearfix mb10">
<?php
					$args = array(
						'numberposts' => 8,
						'post_type'   => 'spot',
						'orderby'     => 'rand'
					);
					$spot_posts = get_posts($args);

					if ($spot_posts) {
						foreach($spot_posts as $post){
							get_template_part('content', 'home');
						}
					} else {
						echo '<p>Not Available</p>'."\n";
					}
					wp_reset_query();	//Query Reset
?>
					</div>
					<p class="mb20 text-center"><a href="<?= home_url('spot-list') ?>" class="btn btn-primary btn-danger">アイスランドの観光地・名所情報</a></p>
				</section><!-- section -->
				<hr />
				<!-- MUSIC -->
				<section>
					<h2>アイスランド音楽情報</h2>
					<p class="subtitle">メジャーなビョーク、シガーロスから日本では馴染みの薄いアーティストまで、個性豊かなアイスランドアーティスト達を紹介</p>
					<div class="clearfix mb10">
<?php
					$args = array(
						'numberposts' => 9,
						'post_type'   => 'music',
						'orderby'     => 'rand'
					);
					$spot_posts = get_posts($args);

					if ($spot_posts) {
						foreach($spot_posts as $post){
							get_template_part('content', 'home_music');
						}
					} else {
						echo '<p>Not Available</p>'."\n";
					}
					wp_reset_query();	//Query Reset
?>
					</div>
					<p class="mb20 text-center"><a href="<?= home_url('music-list') ?>" class="btn btn-primary btn-danger">アイスランドのアーティスト情報</a></p>
				</section><!-- section -->
				<hr />
				<!--  PHOTO -->
				<section>
					<h2>ICELAND PHOTOBOOTH</h2>
					<p class="subtitle">アイスランドで撮影した風景、景色等をまとめています。</p>
					<div class="clearfix">
<?php
					$args = array(
						'numberposts' => 9,
						'post_type'   => 'photo'
					);
					$spot_posts = get_posts($args);

					if ($spot_posts) {
						foreach($spot_posts as $post){
							get_template_part('content', 'home_photo');
						}
					} else {
						echo '<p>Not Available</p>'."\n";
					}
					wp_reset_query();	//Query Reset
?>
					</div>
					<p class="mb20 text-center"><a href="<?= home_url('photo-list') ?>" class="btn btn-primary btn-danger">アイスランドの写真館</a></p>
				</section>
				<hr />
<?php
				// ブログ記事表示
				$paged = get_query_var('paged');
				$blog_posts = get_posts('posts_per_page=8&paged=$paged');

				if ($blog_posts) {
?>
				<section class="post_list">
					<h2>アイスランド関連ブログ</h2>
					<p class="subtitle">アイスランド関連情報やニュースなどをお届けします。</p>
<?php
					foreach( $blog_posts as $post ) {
							get_template_part('content', 'blog1');
						}
?>
					<p class="mt20 mb20 text-center"><a href="<?= home_url('blog') ?>" class="btn btn-primary btn-danger">アイスランド関連ブログ</a></p>
				</section>
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
	// FOOTER
	get_footer();
?>