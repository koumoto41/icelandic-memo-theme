<?php
	// HEADER
	get_header();
?>
<div class="container">
	<div class="row">
		<?= breadcrumb(); ?>
		<div class="clearfix">
			<div class="col-md-9 editor-area">
				<h2>404 NOT FOUND</h2>
				<img src="<?= WP_URL ?>/img/notfound1.png" class="img-resposive center-block">
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


