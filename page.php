<?php
	$id        = $post->ID;
	$parent_id = $post->post_parent;
	$link      = esc_url(get_permalink());
	$title     = get_field('seo_title').'｜'.SITE_NAME;

	// ▼アイキャッチ画像を取得
	$tmp = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
	$eyechach = esc_url(imgNotFound($tmp[0]));

	// HEADER
	get_header();
?>
<div class="container">
	<div class="row">
		<?= breadcrumb(); ?>
		<div class="clearfix">
			<div class="col-md-9 editor-area">
<?php
			if(have_posts()) {
				while(have_posts()) :
					the_post();
?>
					<h2><?= esc_html(get_the_title()) ?></h2>
<?php
					// SNS
					SNS_btn_horizontal_head($link, $title);

					if ($eyechach != '') {
						echo '<p class="mb30"><img src="'.$eyechach.'" alt="'.get_the_title().'" class="img-responsibe center-block" /></p>';
					}
					echo '<div class="ma10 mb40" id="lightbox">';
					the_content();
					echo '</div>';
				endwhile;

				// 子ページの有無判断
				$flg = has_childpage($id);

				if ($flg) {
					// 子ページがあった場合は一覧を表示
					// global $post;
					$args = array(
						'post_type'   => 'page',
						'sort_order'  => 'asc',
						'sort_column' => 'menu_order',
						'child_of'    => $id,
					);
					$child_posts = get_pages($args);

					if ($child_posts) {
						$i = 1;
						echo '<div class="clearfix mb40">'."\n";
						foreach($child_posts as $post) {
							setup_postdata($post);
							get_template_part('content', 'childpage');

							if ($i % 2 == 0) {
								echo '<hr class="hidden-xs" />'."\n";
							}
							$i++;
						}
						echo '</div>'."\n";
					}
				} else {
					// 親ページがあった場合は自身以外の子ページの一覧を取得
					if ($parent_id != 0) {
						$args = array(
							'posts_per_page' => 10,
							'post_type'      => 'page',
							'post_parent'    => $parent_id,
							'exclude'        => $id,
							'order'          => 'rand'
						);
						$child_posts = get_posts( $args );

						if ($child_posts) {
							echo '<hr />'."\n";
							echo '<div class="ma10 mb40">';
							echo '<h3>同じカテゴリの記事</h3>'."\n";
							$i = 1;
							foreach( $child_posts as $post ) {
								get_template_part('content', 'childpage');

								if ($i % 2 == 0) {
									echo '<hr class="hidden-xs" />'."\n";
								}
								$i++;
							}
							echo '</div>';
						}
						wp_reset_query();	//Query Reset
					}
				}
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
	get_footer();

	// ▼子ページがあるかどうかの判断
	function has_childpage($id) {
		global $post;

		if ( is_page() ) { // test to see if the page has a parent
			$h = get_children('post_type=page&post_parent=' .$id );
			if ( empty($h) ) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
?>
