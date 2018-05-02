<?php
	$cat_info = get_category( $cat );
	$name = esc_html($cat_info->cat_name);
	$slug = esc_html($cat_info->slug);
	$description = esc_html($cat_info->category_description);

	$title = $name.'一覧';
	$link  = home_url('category/'.$slug);

	// HEADER
	get_header();
?>
<div class="container">
	<div class="row">
		<?= breadcrumb(); ?>
		<div class="clearfix editor-area">
			<div class="col-md-9 post_list">
				<h2><?= $title ?></h2>
				<p class="subtitle"><?= $description ?></p>
<?php
				// SNS
				SNS_btn_horizontal_head($link, $title);

				// CONTENTS
				if (have_posts()) {
					foreach($posts as $post){
						get_template_part('content', 'blog1');
					}
				} else {
					get_template_part('content', 'list_none');
				}

				if (function_exists("pagination")) {
					echo pagination($glb_count);
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