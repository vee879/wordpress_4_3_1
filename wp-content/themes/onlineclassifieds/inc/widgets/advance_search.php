<?php 

class AdvanceSearch_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'foo_widget', // Base ID
			__( 'JoinWebs Advance Search', 'agrg' ), // Name
			array( 'description' => __( 'Advance Search Widget', 'agrg' ), ) // Args
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
	public function widget( $argz, $instance ) {
		echo $argz['before_widget'];
		global $redux_demo;			
		$trns_location = $redux_demo['trns_location'];
		$trns_category = $redux_demo['trns_category'];
		$trns_skeywords = $redux_demo['trns_skeywords'];
		if ( ! empty( $instance['title'] ) ) {
			echo $argz['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $argz['after_title'];
		} ?>
		<div class="advance_search_widget">
	<form action="<?php echo home_url(); ?>" method="get" id="views-exposed-form-search-view-other-ads-page" accept-charset="UTF-8">
	<input placeholder="<?php echo $trns_skeywords; ?>" type="text" id="edit-search-api-views-fulltext" name="s" value="" size="30" maxlength="128" class="form-text">
	
	<select id="edit-ad-location" name="post_location" class="form-select fa fa-caret-square-o-down fa-lg" style="display: none;">
		<option value="All" selected="selected"><?php echo $trns_location; ?>...</option>

		<?php

			$args_location = array( 'posts_per_page' => -1 );
			$lastposts = get_posts( $args_location );

			$all_post_location = array();
			foreach( $lastposts as $post ) {
				$all_post_location[] = get_post_meta( $post->ID, 'post_location', true );
			}

			$directors = array_unique($all_post_location);
			foreach ($directors as $director) { ?>
				<option value="<?php echo $director; ?>"><?php echo $director; ?></option>
			<?php }

		?>

		<?php wp_reset_query(); ?>

	</select>

	<select id="edit-field-category-advance-search" name="category_name" class="form-select" style="display: none;">
				
		<option value="All" selected="selected"><?php echo $trns_category; ?>...</option>
		<?php
		$args = array(
			'hierarchical' => '0',
			'hide_empty' => '0'
		);
		$categories = get_categories($args);
			foreach ($categories as $cat) {
				if ($cat->category_parent == 0) { 
					$catID = $cat->cat_ID;
				?>
					<option value="<?php echo strtolower($cat->slug); ?>"><?php echo $cat->cat_name; ?></option>
										
			<?php 
				$args2 = array(
					'hide_empty' => '0',
					'parent' => $catID
				);
				$categories = get_categories($args2);
				foreach ($categories as $cat) { ?>
					<option value="<?php echo strtolower($cat->slug); ?>" data-id="">- <?php echo $cat->cat_name; ?></option>
			<?php } ?>

			<?php } else { ?>
			<?php }
		} ?>

	</select>


	<input type="text" name="geo-location" id="geo-location" value="off" data-default-value="off">

	<input type="text" name="geo-radius-search" id="geo-radius-search" value="500" data-default-value="500">

	<input type="text" name="geo-search-lat" id="geo-search-lat" value="0" data-default-value="0">

	<input type="text" name="geo-search-lng" id="geo-search-lng" value="0" data-default-value="0">
	<script type="text/javascript">
		jQuery(document).ready(function(e) {
			jQuery("#edit-field-category-advance-search").change(function(e) {
			  jQuery(".custom-field-cat").hide();
			  jQuery(".custom-field-cat-" + jQuery(this).val()).show();
			});
		});
	</script>
	<?php 
	
	$args = array(
	  'hide_empty' => false,
	  'orderby' => count,
	  'order' => 'ASC'
	);

	$inum = 0;

	$categories = get_categories($args);
	global $wpdb;
	$sql = "select * from ".$wpdb->prefix."postmeta where meta_key='custom_field'";
	$rs= mysql_query($sql) or die(mysql_error());
	$field_values = array();
	while($r = mysql_fetch_array($rs)) : 
		$values = maybe_unserialize($r['meta_value']);
		if(!empty($values)) {
			$post_categories = wp_get_post_categories( $r['post_id'] );
			if(!empty($post_categories))
			foreach($post_categories as $c){
				$cat = $c;
			}
			$cat = intval($cat);
			foreach($values as $val) {
				$key= $val[0];
				$field_values[$cat][$key][] = $val[1];
			}
		}
	endwhile;
	foreach($categories as $category) {
		$inum++;
		$cat_name = $category->name;
		$cat_id = $category->term_id; 
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		$fields = $tag_extra_fields[$cat_id]['category_custom_fields'];
		for ($i = 0; $i < (count($fields)); $i++) {
	?>
	<div id="edit-search-api-views-fulltext-wrapper" class="views-exposed-widget views-widget-filter-search_api_views_fulltext custom-field-cat custom-field-cat-All custom-field-cat-<?php echo $category->slug; ?>" style="display:none;">
		<div class="views-widget">
			<div class="control-group form-type-textfield form-item-search-api-views-fulltext form-item">
				<div class="controls"> 
					<select name="custom_fields[]" class="form-select" style="display: none;">
						<option value=""><?php echo $fields[$i][0]; ?>...</option>
						<?php $key = $fields[$i][0]; if(!empty($field_values[$cat_id][$key])) : 
							foreach($field_values[$cat_id][$key] as $val) : ?>
							<option value="<?php echo $val; ?>"><?php echo $val; ?></option>
						<?php endforeach; endif; ?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
<?php } ?>

	
	<input class="search-submit" type="submit" value="Search" name="" style="width:auto; height:35px;">

</form>
</div>
	<?php 			
		echo $argz['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Advance Search', 'agrg' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
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

} // class AdvanceSearch_Widget

function register_advancesearch_widget() {
    register_widget( 'AdvanceSearch_Widget' );
}
add_action( 'widgets_init', 'register_advancesearch_widget' );