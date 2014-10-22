<?php

/**
 * This file contains the definition for footer sponsor logos
 */

$sponsor_args = array( 
	'post_type' 	=> 'attachment',
	'post_status' 	=> 'any',
	'category_name' => 'sponsor-logos',
	'orderby' 		=> 'title',
	'order'			=> 'ASC'
 );

$sponsor_query = new WP_Query( $sponsor_args );

if( $sponsor_query->have_posts() ){ ?>	

<div class="sponsor-logos container animated">

	<?php while( $sponsor_query->have_posts() ){ 
		
		$sponsor_query->the_post(); 

		?>

		<div class="sponsor-logo">

			<?php 

			if ( get_the_content() !== "" ){
				echo '<a href="' . get_the_content() . '" class="wharf-sponsor-link" target="_blank"><img src="' . wp_get_attachment_url( get_the_ID() ) . '" /></a>'; 
			} else {
				echo '<div class="wharf-sponsor-link"><img src="' . wp_get_attachment_url( get_the_ID() ) . '" /></div>';
			} 

			?>

		</div>
	
	<?php } ?>

</div>

<?php } ?>