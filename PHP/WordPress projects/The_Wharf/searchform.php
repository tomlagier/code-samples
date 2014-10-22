<?php

/**
 * Custom search form definition
 */

?>

<form role="search" method="get" id="searchform" class="searchform" action="/">
	<div>
		<label class="screen-reader-text" for="s"><?php _x( 'Search for:', 'label' ); ?></label>
		<input type="text" value="<?php echo get_search_query(); ?>" name="s" class="input input-upper--search" id="s" placeholder="Search The Wharf" />
		<button type="submit" id="searchsubmit" class="button-blank button-upper--search header-upper--searchButton" />
			<i class="fa fa-search"></i>
		</button>
	</div>
</form>