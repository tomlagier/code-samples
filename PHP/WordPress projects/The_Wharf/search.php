<?php 

/**
 * This file contains the definition for the default search page. It has a default header image and no sidebar.
 */

get_header(); ?>

<div id="page" class="search">

	<?php get_template_part( 'partials/category' , 'image' ); ?>

	<div class="page-wrapper container u-padded-section">

		<div class="row">
			<div class="col-md-12 page-body">
				
				<h1 class="archive-title content-title animated right">Search results for: <?php echo get_search_query(); ?></h1>
				
				<?php if( have_posts() ){ 
					while( have_posts() ){
						the_post(); ?>

						<div class="archive-post row animated left">

							<?php if( has_post_thumbnail() ){ ?>
							<div class="archive-featured-image featured-image col-md-2 col-sm-3 col-ms-4">
								<a href="<?php echo get_the_permalink(); ?>" class="thumbnail-link" />
								<?php echo get_the_post_thumbnail( get_the_ID(), 'archive-featured-thumbnail' ); ?>
								</a>
							</div>
							<?php } ?>

							<div class="archive-post-inner <?php echo ( has_post_thumbnail() ? 'col-md-10 col-sm-9 col-ms-8' : 'col-sm-12' ); ?>">
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
					<h2 class="no-results">
						No search results found
					</h2>
				<?php } ?>

				<!-- Pagination -->
				<?php 

				$pagination = tw_get_pagination();

				if( $pagination ){ ?>
					
					<div class="pagination">
						<?php echo $pagination; ?>
					</div>

				<?php } ?>

			</div>
		</div>
	</div>

</div>

<?php get_footer(); ?>