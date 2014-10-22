<?php 

/**
 * Definition for homepage featured articles section.
 */

$featured_items_query = array(
	'post_type' 	 => 'post',
	'post_status' 	 => 'published',
	'category_name'  => 'homepage-featured',
	'posts_per_page' => 4
);

$featured_items = new WP_Query( $featured_items_query );

?>

<div id="homepage-featured-articles" class="u-padded-section container">

	<div class="row u-center headline-centered animated right">
		
		<div class="headline-centered--subhead">
			What's going on this week at The Wharf?
		</div>

		<h1 class="headline-centered--heading">
			A Waterfront Life
		</h1>

		<div class="headline-centered--underline">
		</div>

	</div>

	<!-- Featured articles will be a carousel on mobile -->
	<div class="row featured-items hidden-sm hidden-ms hidden-xs animated left">
		
		<?php if( $featured_items->have_posts() ){
				while( $featured_items->have_posts() ){
					$featured_items->the_post(); 

					$category_ids = wp_get_post_categories( get_the_ID() );

					foreach( $category_ids as $cat_id ){
						$category = get_category( $cat_id );
						$parents = get_category_parents( $cat_id );

						//Not the "featured" category and not a non-visible category, and with the "display" parent
						if( $category->slug !== 'homepage-featured' && !strstr( $category->slug, '-noshow' ) && strstr( $parents, 'Display' ) ){
							$category_name = $category->name;
						}
					}

					?>

					<div class="featured-item col-sm-3 col-xs-6 js-matchheight">
						
						<div class="featured-item--inner u-shadow-light">
							
							<div class="featured-item--imageWrapper">
								<a href="<?php echo get_the_permalink(); ?>" class="thumbnail-link">
								<?php 
								
								if( has_post_thumbnail() ){

									$thumbnail_attributes = array( 'class' => 'featured-item--image' );
									echo get_the_post_thumbnail( get_the_ID(), 'homepage-featured-thumbnail', $thumbnail_attributes ); 

								} else { ?>
									
									<img class="featured-item--image" src="http://placehold.it/265x180">

								<?php } ?>
								</a>
							</div>

							<div class="featured-item--description">
								<div class="featured-item--category">
									<?php echo $category_name ?>
								</div>

								<h3 class="featured-item--title">
									<a href="<?php echo get_the_permalink(); ?>">
										<?php echo get_the_title(); ?>
									</a>
								</h3>

								<div class="featured-item--excerpt">
									<?php echo get_the_excerpt(); ?>
								</div>

								<?php if( str_word_count( get_the_content() ) > 55 ){ ?>
								<div class="featured-item--readmore">
									<a class="button button-yellow" href="<?php echo get_the_permalink(); ?>">Read More</a>
								</div>
								<?php } ?>
							</div>
							
						</div>

					</div>
			<?php }
			rewind_posts();
			} ?>

	</div>

	<div class="mobile-featured-items visible-sm visible-xs visible-ms owl-carousel owl-theme js-carousel-mobile">

		<?php if( $featured_items->have_posts() ){
			while( $featured_items->have_posts() ){
				$featured_items->the_post(); 

				$category_ids = wp_get_post_categories( get_the_ID() );

				foreach( $category_ids as $cat_id ){
					$category = get_category( $cat_id );
					$parents = get_category_parents( $cat_id );

					//Not the "featured" category and not a non-visible category, and with the "display" parent
					if( $category->slug !== 'homepage-featured' && !strstr( $category->slug, '-noshow' ) && strstr( $parents, 'Display' ) ){
						$category_name = $category->name;
					}
				}

				?>

				<div class="featured-item item">
					
					<div class="featured-item--inner">
						
						<div class="featured-item--imageWrapper">
							<?php 
							
							if( has_post_thumbnail() ){

								$thumbnail_attributes = array( 'class' => 'featured-item--image' );
								echo get_the_post_thumbnail( get_the_ID(), 'homepage-featured-thumbnail', $thumbnail_attributes ); 

							} else { ?>
								
								<img class="featured-item--image" src="http://placehold.it/265x180">

							<?php } ?>
						</div>

						<div class="featured-item--description">
							<div class="featured-item--category">
								<?php echo $category_name ?>
							</div>

							<h3 class="featured-item--title">
								<a href="<?php echo get_the_permalink(); ?>">
									<?php echo get_the_title(); ?>
								</a>
							</h3>

							<div class="featured-item--excerpt">
								<?php echo get_the_excerpt(); ?>
							</div>

							<?php if( str_word_count( get_the_content() ) > 55 ){ ?>
							<div class="featured-item--readmore">
								<a class="button button-yellow" href="<?php echo get_the_permalink(); ?>">Read More</a>
							</div>
							<?php } ?>
						</div>
						
					</div>

				</div>
		<?php }
		} ?>

	</div>

</div>