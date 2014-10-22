<?php

/**
 * This file contains the definition for the default archive page. 
 * It is functionally identical to search.php, except that pulls the header image from the current display category
 */

get_header(); ?>
<!-- Begin #page-->
<div id="page" class="archive">

	<!-- Banner image -->
	<?php get_template_part( 'partials/category' , 'image' ); ?>

	<!-- Begin .page-wrapper -->
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
				<?php if( have_posts() ){ ?>

					<h1 class="archive-title content-title animated right">
						<?php single_cat_title(); ?>
					</h1>

					<?php while( have_posts() ){
						the_post(); ?>
						<div class="archive-post row animated left">

							<?php if( has_post_thumbnail() ){ ?>
							<div class="archive-featured-image featured-image col-sm-3 col-ms-4">
								<a href="<?php echo get_the_permalink(); ?>" class="thumbnail-link" />
								<?php echo get_the_post_thumbnail( get_the_ID(), 'archive-featured-thumbnail' ); ?>
								</a>
							</div>
							<?php } ?>

							<div class="archive-post-inner <?php echo ( has_post_thumbnail() ? 'col-sm-9 col-ms-8' : 'col-sm-12' ); ?>">
								<h2 class="archive-post-title">
									<a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a>
								</h2>

								<div class="archive-content">
									<?php echo get_the_excerpt(); ?>
								</div>

								<div class="archive-readmore button button-yellow">
									<a href="<?php echo get_the_permalink(); ?>">Read More</a>
								</div>
							</div>

							<div class="clear"></div>

						</div>

						<!-- Divider -->
						<div class="row">
							<div class="col-sm-12">
								<div class="dividing-line animated left"></div>
							</div>
						</div>

				<?php }
				} else { ?>
					<h1 class="no-results">
						No posts
					</h1>
				<?php } ?>

				<!-- Pagination -->
				<?php 

				$pagination = tw_get_pagination();

				if( $pagination ){ ?>
					
					<div class="pagination animated">
						<?php echo $pagination; ?>
					</div>

				<?php } ?>

			</div>
			
			<div class="col-md-3 page-sidebar hidden-sm hidden-xs hidden-ms js-matchheight animated left">
				<?php get_sidebar(); ?>
			</div>

		</div>
	<!-- End .page-content -->
	</div>
</div>

<?php get_footer(); ?>