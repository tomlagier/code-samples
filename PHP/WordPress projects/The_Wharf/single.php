<?php 

/**
 * Definition for single post template. Functionally similar to page.php, 
 * but pulls the header image from the category rather than the featured image.
 */

get_header(); 
while ( have_posts() ) {
the_post(); ?>

<!-- Begin #page-->
<div id="page" class="post">

	<!-- Banner image -->
	<?php get_template_part( 'partials/category' , 'image' ); ?>
	
	<!-- Begin .page-content -->
	<div class="page-wrapper container u-padded-section has-breadcrumbs">
		<div class="row breadcrumb-row">
			<div class="col-sm-12 animated right">
				<?php
				 if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb('<div id="breadcrumbs" class="breadcrumbs">', '</div>');
				} ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9 page-body js-matchheight">

				<h1 class="post-title content-title animated right">
					<?php the_title(); ?>
				</h1>

				<?php if( has_post_thumbnail() ){ ?>
				<div class="post-featured-image featured-image animated left">
					<?php echo get_the_post_thumbnail( get_the_ID(), 'post-featured-image' ); ?>
				</div>
				<?php } ?>

				<div class="page-content animated left">
					<?php the_content(); ?>
					<?php get_template_part( 'partials/social', 'shares' ); ?>
				</div>
			
			</div>
			
			<div class="col-md-3 page-sidebar hidden-sm hidden-ms hidden-xs js-matchheight animated left">
				<?php get_sidebar(); ?>
			</div>

		</div>
	<!-- End .page-content -->
	</div>

<?php } //End of the loop ?>

<!-- End #page -->
</div>

<?php get_footer(); ?>