<?php
	// アイキャッチ画像取得
	$tmp = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
	$eyechach = esc_url(imgNotFound($tmp[0]));

	$link  = get_permalink();
	$title = get_the_title();

	// HEADER
	get_header();
?>
<div class="container">
	<div class="row">
		<?= breadcrumb(); ?>
		<div class="clearfix">
			<div class="col-md-9 editor-area">
<?php
			if (have_posts()) {
				while(have_posts()) :
					the_post();
?>
					<h2><?= get_the_title(); ?></h2>
					<?php SNS_btn_horizontal_head($link, $title); ?>

					<div class="cate-list">
						<p><i class="glyphicon glyphicon-book"></i> <?php the_category('|'); ?> <?php the_tags('<i class="glyphicon glyphicon-tag"></i> ',' '); ?>
						<p><?= get_the_date('Y-m-d'); ?>
					</div>
<?php
					if ($eyechach != '') {
						echo '<p class="mt20 mb30"><img src="'.$eyechach.'" alt="'.get_the_title().'" class="img-responsive center-block" /></p>';
					}
					echo '<div style="margin: 0 10px;">';
						the_content();
					echo '</div>';
				endwhile;
			} else {
				get_template_part('content', 'page_none');
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

