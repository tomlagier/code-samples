<?php

/**
 * This file contains the definition of the Recent Posts widget, 
 * customized for the CFE Intranet theme.
 */

/**
 * Adds Foo_Widget widget.
 */
class TW_Related_Posts extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'tw_related_posts', // Base ID
			'TW Related Pages/Posts Widget', // Name
			array( 'description' => 'Displays a list of pages and posts from the same category as the current post. If the current page/post is not in a display category, displays a list of all top-level display categories', ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
	
     	echo $args['before_widget'];
		
		//Widget title
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		
		$display_categories = tw_get_display_categories();

		//Get the post display categories
		$post_display_category_slugs = tw_get_post_display_categories( $display_categories, get_the_category() );

		//If the current post is in the display categories, output posts from the display category
		if( $post_display_category_slugs ){

			//Concat the post display categories
			$category_name_string = implode( ',', $post_display_category_slugs );

			//Set up related posts query
			$related_posts_args = array(
				'category_name'  => $category_name_string,
				'post_type' 	 => array( 'post', 'page' ),
				'posts_per_page' => '15',
				'post__not_in' 	 => array( get_the_ID() )
			);

			//Execute query
			$related_posts = new WP_Query( $related_posts_args );

			//Output related posts
			if( $related_posts->have_posts() ){

				$this->output_posts( $related_posts );
				
			} else {

				$this->output_categories( $display_categories );

			}

		}
		//Else, display the default category links
		else {
			$this->output_categories( $display_categories );
		}
		
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		} ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		 	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>This widget will automatically display related posts from the category of the current post. If the current post does not have a display category, it will display the a list of the top-level display categories.</p>

		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

	/**
	 * Formats and outputs a list of posts
	 * @param  array $posts Array of WP post objects to be output
	 * @return none, prints output
	 */
	public function output_posts( $posts ){

		echo '<div class="sidebar-posts sidebar-list">';

		while( $posts->have_posts() ){
			$posts->the_post();

			echo '<div class="sidebar-posts">';
				echo '<div class="sidebar-post-title sidebar-item">';
					echo '<a class="sidebar-post-link sidebar-link" href="' . get_permalink( get_the_ID() ) . '">' . get_the_title() . '</a>';
				echo '</div>';
			echo '</div>';
		}

		echo '</div>';

		wp_reset_query();

	}

	/**
	 * Formats and outputs a list of categories
	 * @param  array $categories Array of WP category objects to be output
	 * @return none, prints output
	 */
	public function output_categories( $categories ){

		echo '<div class="sidebar-categories sidebar-list">';

		foreach( $categories as $category ){

			echo '<div class="sidebar-category">';
				echo '<div class="sidebar-category-title sidebar-item">';
					echo '<a class="sidebar-category-link sidebar-link" href="' . get_category_link( $category->term_id ) . '">' . $category->cat_name . '</a>';
				echo '</div>';
			echo '</div>';

		}
		
		echo '</div>';

	}

} // class Foo_Widget

/** Register widget for use **/

add_action( 'widgets_init', function(){
     register_widget( 'TW_Related_Posts' );
});