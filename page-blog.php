<?php
	$link      = esc_url(get_permalink());
	$title     = get_field('seo_title').'｜'.SITE_NAME;

	// HEADER
	get_header();
?>
<!-- HEADER -->
<div class="main_search_block divider_blog">
	<div class="subtitlebox">
		<p class="en_highlight">ICELAND NEWS</p>
		<p class="mb20 ft_color1 ft_size12">最新のアイスランド情報をお届け！！</p>
	</div>
</div><!-- /headerwrap -->
<div class="container">
	<div class="row">
		<?= breadcrumb(); ?>
		<div class="clearfix">
			<div class="col-md-9">
				<h2>アイスランド関連ブログ</h2>
<?php
				// SNS
				SNS_btn_horizontal_head($link, $title);
?>
				<div class="post_list">

<?php
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$args = array(
					'post_type' => 'post',
					'paged'     => $paged
				);
				$the_query = new WP_Query($args);
				$glb_count = $the_query->max_num_pages;

				if ( $the_query->have_posts() ) :

					// カテゴリ一覧
					$cat = get_categories('type=post');

					if (count($cat) > 0 ) {
						echo '<ul class="list-inline mb20">'."\n";
						foreach ($cat as $key => $value) {
							echo '<li class="pb10"><a href="'.home_url($value->taxonomy.'/'.$value->slug).'" class="btn btn-primary">'.$value->name.'</a></li>'."\n";
						}
						echo '</ul>'."\n";
					}
					wp_reset_query();


					while ( $the_query->have_posts() ) : $the_query->the_post();
						get_template_part('content', 'blog1');
					endwhile;
					if (function_exists('pagination')) {
						echo pagination($glb_count);
					}
				endif;
?>
				</div>
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
