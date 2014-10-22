<?php
/**
 * Template Name: Full-Width Page
 * 
 * The full-width secondary page template file
 *
 * This file contains the single-page definition for the The Wharf template, 
 * without sidebar.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage The Wharf
 * @since The Wharf 0.1
 */

get_header(); ?>

<?php while ( have_posts() ) {
the_post(); ?>

<!-- Begin #page-->
<div id="page" class="page">
	
	<!-- Banner image -->	
	<?php 
	//Set up page hero if page has thumbnail, else just pad out header with empty .page-header
	if( has_post_thumbnail() ){ 

		$attachment_id = get_post_thumbnail_id();
		$small_url = wp_get_attachment_image_src( $attachment_id, 'post-hero-small' );
		$large_url = wp_get_attachment_image_src( $attachment_id, 'post-hero' );

		$header_image['large'] = $large_url[0];
		$header_image['small'] = $small_url[0]; ?>

		<div class="page-header js-hero-image has-thumbnail hidden-xs hidden-ms animated inplace" data-src="<?php echo $header_image['large']; ?>" data-src-small="<?php echo $header_image['small']; ?>">
		</div>

	<?php } else { 

		get_template_part( 'partials/category' , 'image' );

	} ?>

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
			<div class="col-sm-12 page-body">
			
				<h1 class="page-title content-title animated right">
					<?php the_title(); ?>
				</h1>

				<div class="page-content animated left">
					<?php the_content(); ?>
				</div>
			
			</div>
		</div>
	<!-- End .page-content -->
	</div>


<?php } // end of the loop. ?>

<!-- End #page -->	
</div>

<?php get_footer(); ?>