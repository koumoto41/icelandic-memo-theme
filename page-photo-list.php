<?php
	$link      = esc_url(get_permalink());
	$title     = get_field('seo_title').'｜'.SITE_NAME;

	// HEADER
	get_header();
?>
<!-- HEADER -->
<div class="main_search_block divider_photo">
	<div class="subtitlebox">
		<p class="en_highlight">ICELAND PHOTOBOOTH</p>
		<p class="mb20 ft_color1 ft_size12">アイスランドの風景、写真</p>
	</div>
</div>
<div class="container">
	<div class="row">
		<?= breadcrumb(); ?>
		<div class="clearfix">
			<div class="col-md-9">
				<h2>アイスランドの風景、写真</h2>
<?php
				// SNS
				SNS_btn_horizontal_head($link, $title);

				$args = array(
					'numberposts' => -1,
					'post_type' => 'photo'
				);
				$posts = get_posts($args);

				if (have_posts()) {
					foreach ($posts as $post) {
						get_template_part('content', 'home_photo');
					}
				} else {
					echo '<p>Not Available</p>'."\n";
				}
				wp_reset_query();	//Query Reset
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