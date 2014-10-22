<?php

/**
 * Definition of featured image area for header on pages where it is derived from
 * the page category (Archive and Post pages)
 */

$post_display_category_slugs = tw_get_post_display_categories( tw_get_display_categories(), get_the_category() );

//Post belongs to a display category
if( $post_display_category_slugs ){

	//Pick a display category at random and get its featured image
	shuffle( $post_display_category_slugs );
	$category_header_image = tw_get_category_header_image( $post_display_category_slugs[0] );

	//Category has no image set, get default featured image
	if ( !$category_header_image ){
		$category_header_image = tw_get_default_header_image();
	}

//Post does not belong to a display category, get default featured image
} else {

	$category_header_image = tw_get_default_header_image();

}

?>
<div class="page-header js-hero-image has-thumbnail hidden-xs hidden-ms animated inplace" data-src="<?php echo $category_header_image['large']; ?>" data-src-small="<?php echo $category_header_image['small']; ?>">
</div>