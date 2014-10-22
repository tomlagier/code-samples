<?php

/**
 * Definition for sidebar.
 * Automatically displays the appropriate category sidebar, or the generic uncategorized sidebar.
 */

//Get category slugs
$post_display_category_slugs = tw_get_post_display_categories( tw_get_display_categories(), get_the_category() );

//Grab the sidebar by name
if( $post_display_category_slugs ){
	
	//Pick a random one if there are multiple
	shuffle( $post_display_category_slugs );

	$sidebar = 'sidebar-widgets-' . $post_display_category_slugs[0];

//Fallback to uncategorized if it can't find one
} else {
	$sidebar = 'sidebar-widgets-uncategorized';
} ?>

<div class="sidebar-widgets">
	<?php //Output sidebar
	if( is_active_sidebar( $sidebar ) ) {
		dynamic_sidebar( $sidebar );
	//Fallback to uncategorized if the sidebar is empty
	} else {
		dynamic_sidebar( 'sidebar-widgets-uncategorized' );
	}?>
</div>
