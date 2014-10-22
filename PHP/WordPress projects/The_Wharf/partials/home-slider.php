<?php

/**
 * This file contains the definition for the homepage slider powered by
 * Owl Carousel
 * http://owlgraphic.com/owlcarousel/ 
 */

$mobile_detect = new Mobile_Detect();

if( $mobile_detect->isMobile() && !$mobile_detect->isTablet() ){

	$slider_category = 'homepage-slider-mobile';
	$image_size = 'homepage-slider-image-small';

}  else {

	$slider_category = 'homepage-slider';
	$image_size = 'homepage-slider-image';

}

$slider_args = array( 
	'post_type' 	=> 'attachment',
	'post_status' 	=> 'any',
	'category_name' => $slider_category,
	'orderby' 		=> 'title',
	'order'			=> 'ASC'
 );

$slider_query = new WP_Query( $slider_args );

if( $slider_query->have_posts() ){ ?>

<div id="home-slider" class="js-carousel owl-carousel owl-theme">

	<?php while( $slider_query->have_posts() ){ 
		
		$slider_query->the_post(); 

		$image = wp_get_attachment_image_src( get_the_ID(), $image_size );

		?>

		<div class="slider-homepage--slide">
			<img class="slider-homepage--slideImage item" src="<?php echo $image[0] ?>" />
		</div>
	
	<?php } ?>
	
</div>

<?php } ?>