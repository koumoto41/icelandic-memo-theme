<?php
	$aryInfo = array();
	$strHtml = '';

	if (have_posts()) {

		// get_the_contentで取得出来ない為
		$my_postid = $post->ID ;
		$content_post = get_post($my_postid);
		$content = $content_post->post_content;
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]>', $content);

		$aryInfo['title']    = esc_html(get_the_title());
		$aryInfo['contents'] = $content;
		$aryInfo['link']     = esc_url(get_permalink());
	}
	wp_reset_query();	//Query Reset

	// HEADER
	get_header();
?>
<div class="container">
	<div class="row">
		<?= breadcrumb(); ?>
		<div class="clearfix">
			<div class="col-md-9" id="lightbox">
				<h3><?= $aryInfo['title'] ?></h3>
				<p><?= $aryInfo['contents'] ?></p>
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