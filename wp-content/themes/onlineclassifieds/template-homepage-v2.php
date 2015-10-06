<?php
/**
 * Template name: Homepage V2 (with Shop)
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classify
 * @since classify 1.0
 */


get_header(); ?>

<?php 
	$trns_location = $redux_demo['trns_location'];
	$trns_category = $redux_demo['trns_category'];
	$trns_premium_ads = $redux_demo['trns_premium_ads'];
	$trns_categories = $redux_demo['trns_categories'];
	$trns_others = $redux_demo['trns_others'];
	$trns_classify_ads = $redux_demo['trns_classify_ads'];
	$trns_latest_ads = $redux_demo['trns_latest_ads'];
	$trns_popular_ads = $redux_demo['trns_popular_ads'];
	$trns_random_ads = $redux_demo['trns_random_ads'];
	$trns_skeywords = $redux_demo['trns_skeywords'];

	$page = get_page($post->ID);
	$current_page_id = $page->ID;

	$page_slider = get_post_meta($current_page_id, 'page_slider', true); 


	global $redux_demo, $maximRange; 
	$max_range = $redux_demo['max_range'];
	if(!empty($max_range)) {
		$maximRange = $max_range;
	} else {
		$maximRange = 1000;
	}

?>

<?php if($page_slider == "LayerSlider") : ?>

	<section id="layerslider">

		<?php

			$page_layer_slider_shortcode = get_post_meta($current_page_id, 'layerslider_shortcode', true);

			if(!empty($page_layer_slider_shortcode))
			{
		?>

			<?php echo do_shortcode($page_layer_slider_shortcode); ?>

		<?php } else { ?>

			<?php echo do_shortcode('[layerslider id="1"]'); ?>

		<?php } ?>

		<?php 

			global $redux_demo; 

			$header_version = $redux_demo['header-version'];

		?>

		<?php if($header_version == 1) { ?>

		<div id="advanced-search-widget">

			<div class="container">

				<div class="advanced-search-widget-content">

					<div class="advanced-search-title">

						<?php _e( 'Search around my position', 'agrg' ); ?>

					</div>

					<div class="advanced-search-slider">

						<div class="geo-location-button">

							<div class="geo-location-switch off"><i class="fa fa-location-arrow"></i></div>

						</div>

						<div id="advance-search-slider" class="value-slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
								<a class="ui-slider-handle ui-state-default ui-corner-all" href="#">
									
								</a>
								<div class="range-pin">
										<input type="text" name="geo-radius" id="geo-radius" value="100" data-default-value="100" />
								</div>
							</div>

					</div>

				</div>

			</div>

		</div>

		<?php } elseif($header_version == 2) { ?>

		<div id="advanced-search-widget-version2">

			<div class="container">

				<div class="advanced-search-widget-content">

					<form action="<?php echo home_url(); ?>" method="get" id="views-exposed-form-search-view-other-ads-page" accept-charset="UTF-8">

						<div id="edit-search-api-views-fulltext-wrapper" class="views-exposed-widget views-widget-filter-search_api_views_fulltext">
					        <div class="views-widget">
					          	<div class="control-group form-type-textfield form-item-search-api-views-fulltext form-item">
									<div class="controls"> 
										<input placeholder="<?php echo $trns_skeywords; ?>" type="text" id="edit-search-api-views-fulltext" name="s" value="" size="30" maxlength="128" class="form-text">
										<input type="hidden" id="hidden-keyword" name="s" value="all" size="30" maxlength="128" class="form-text">
									</div>
								</div>
						    </div>
						</div>
						          						
						<div id="edit-ad-location-wrapper" class="views-exposed-widget views-widget-filter-field_ad_location">
						   	<div class="views-widget">
						        <div class="control-group form-type-select form-item-ad-location form-item">
									<div class="controls"> 
										<select id="edit-ad-location" name="post_location" class="form-select" style="display: none;">
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
									</div>
								</div>
						    </div>
						</div>

						<div id="edit-field-category-wrapper" class="views-exposed-widget views-widget-filter-field_category">
						    <div class="views-widget">
						        <div class="control-group form-type-select form-item-field-category form-item">
									<div class="controls"> 
										<select id="edit-field-category" name="category_name" class="form-select" style="display: none;">
													
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
														<option value="<?php echo $cat->cat_name; ?>"><?php echo $cat->cat_name; ?></option>
																			
												<?php 
													$args2 = array(
														'hide_empty' => '0',
														'parent' => $catID
													);
													$categories = get_categories($args2);
													foreach ($categories as $cat) { ?>
														<option value="<?php echo $cat->slug; ?>">- <?php echo $cat->cat_name; ?></option>
												<?php } ?>

												<?php } else { ?>
												<?php }
											} ?>

										</select>
									</div>
								</div>
						    </div>
						</div>

						<div class="advanced-search-slider">

							<div class="geo-location-button">

								<div class="geo-location-switch off"><i class="fa fa-location-arrow"></i></div>

							</div>

							<div id="advance-search-slider" class="value-slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
								<a class="ui-slider-handle ui-state-default ui-corner-all" href="#">
									
								</a>
								<div class="range-pin">
										<input type="text" name="geo-radius" id="geo-radius" value="100" data-default-value="100" />
								</div>
							</div>

						</div>


						<input type="text" name="geo-location" id="geo-location" value="off" data-default-value="off">

						<input type="text" name="geo-radius-search" id="geo-radius-search" value="500" data-default-value="500">

						<input type="text" name="geo-search-lat" id="geo-search-lat" value="0" data-default-value="0">

						<input type="text" name="geo-search-lng" id="geo-search-lng" value="0" data-default-value="0">


						<div class="views-exposed-widget views-submit-button">
						    <button class="btn btn-primary form-submit" id="edit-submit-search-view" name="" value="Search" type="submit"><?php printf( __( 'Search', 'agrg' )); ?></button>
						</div>

					</form>

				</div>

			</div>

		</div>

		<?php } ?>

	</section>

<?php elseif ($page_slider == "Big Map") : ?>

	<section id="big-map">

		<div id="classify-main-map"></div>

		<script type="text/javascript">
		var mapDiv,
			map,
			infobox;
		jQuery(document).ready(function($) {

			mapDiv = $("#classify-main-map");
			mapDiv.height(650).gmap3({
				map: {
					options: {
						"draggable": true
						,"mapTypeControl": true
						,"mapTypeId": google.maps.MapTypeId.ROADMAP
						,"scrollwheel": false
						,"panControl": true
						,"rotateControl": false
						,"scaleControl": true
						,"streetViewControl": true
						,"zoomControl": true
						<?php global $redux_demo; $map_style = $redux_demo['map-style']; if(!empty($map_style)) { ?>,"styles": <?php echo $map_style; ?> <?php } ?>
					}
				}
				,marker: {
					values: [

					<?php

						$wp_query= null;

						$wp_query = new WP_Query();

						$wp_query->query('post_type=post&posts_per_page=-1');

						


						while ($wp_query->have_posts()) : $wp_query->the_post(); 

						$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
						$post_longitude = get_post_meta($post->ID, 'post_longitude', true);

						$theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 40) ? substr($theTitle,0,37).'...' : $theTitle;

						$post_price = get_post_meta($post->ID, 'post_price', true);


						$category = get_the_category();

						if ($category[0]->category_parent == 0) {

							$tag = $category[0]->cat_ID;

							$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
							if (isset($tag_extra_fields[$tag])) {
								$your_image_url = $tag_extra_fields[$tag]['your_image_url']; //i added this line.
							}

						} else {

							$tag = $category[0]->category_parent;

							$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
							if (isset($tag_extra_fields[$tag])) {
								$your_image_url = $tag_extra_fields[$tag]['your_image_url']; //i added this line.
							}

						}

						if(!empty($your_image_url)) {

					    	$iconPath = $your_image_url;

					    } else {

					    	$iconPath = get_template_directory_uri() .'/images/icon-services.png';

					    }

						if(!empty($post_latitude)) { ?>

							 	{
							 		<?php require_once(TEMPLATEPATH . "/inc/BFI_Thumb.php"); ?>
									<?php $params = array( "width" => 560, "height" => 390, "crop" => true ); $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "single-post-thumbnail" ); ?>

									latLng: [<?php echo $post_latitude; ?>,<?php echo $post_longitude; ?>],
									options: {
										icon: "<?php echo $iconPath; ?>",
										shadow: "<?php echo get_template_directory_uri() ?>/images/shadow.png",
									},
									data: '<div class="marker-holder"><div class="marker-content"><div class="marker-image"><img alt="image" src="<?php echo bfi_thumb( "$image[0]", $params ) ?>" /></div><div class="marker-info-holder"><div class="marker-info"><div class="marker-info-title"><?php echo $theTitle; ?></div><div class="marker-info-extra"><div class="marker-info-price"><?php echo $post_price; ?></div><div class="marker-info-link"><a href="<?php the_permalink(); ?>"><?php _e( "Details", "agrg" ); ?></a></div></div></div></div><div class="arrow-down"></div><div class="close"></div></div></div>'
								}
							,

					<?php } endwhile; ?>	

					<?php wp_reset_query(); ?>
						
					],
					options:{
						draggable: false
					},
					cluster:{
		          		radius: 20,
						// This style will be used for clusters with more than 0 markers
						0: {
							content: "<div class='cluster cluster-1'>CLUSTER_COUNT</div>",
							width: 62,
							height: 62
						},
						// This style will be used for clusters with more than 20 markers
						20: {
							content: "<div class='cluster cluster-2'>CLUSTER_COUNT</div>",
							width: 82,
							height: 82
						},
						// This style will be used for clusters with more than 50 markers
						50: {
							content: "<div class='cluster cluster-3'>CLUSTER_COUNT</div>",
							width: 102,
							height: 102
						},
						events: {
							click: function(cluster) {
								map.panTo(cluster.main.getPosition());
								map.setZoom(map.getZoom() + 2);
							}
						}
		          	},
					events: {
						click: function(marker, event, context){
							map.panTo(marker.getPosition());

							var ibOptions = {
							    pixelOffset: new google.maps.Size(-125, -88),
							    alignBottom: true
							};

							infobox.setOptions(ibOptions)

							infobox.setContent(context.data);
							infobox.open(map,marker);

							// if map is small
							var iWidth = 560;
							var iHeight = 560;
							if((mapDiv.width() / 2) < iWidth ){
								var offsetX = iWidth - (mapDiv.width() / 2);
								map.panBy(offsetX,0);
							}
							if((mapDiv.height() / 2) < iHeight ){
								var offsetY = -(iHeight - (mapDiv.height() / 2));
								map.panBy(0,offsetY);
							}

						}
					}
				}
				 		 	},"autofit");

			map = mapDiv.gmap3("get");
		    infobox = new InfoBox({
		    	pixelOffset: new google.maps.Size(-50, -65),
		    	closeBoxURL: '',
		    	enableEventPropagation: true
		    });
		    mapDiv.delegate('.infoBox .close','click',function () {
		    	infobox.close();
		    });

		    if (Modernizr.touch){
		    	map.setOptions({ draggable : false });
		        var draggableClass = 'inactive';
		        var draggableTitle = "Activate map";
		        var draggableButton = $('<div class="draggable-toggle-button '+draggableClass+'">'+draggableTitle+'</div>').appendTo(mapDiv);
		        draggableButton.click(function () {
		        	if($(this).hasClass('active')){
		        		$(this).removeClass('active').addClass('inactive').text("Activate map");
		        		map.setOptions({ draggable : false });
		        	} else {
		        		$(this).removeClass('inactive').addClass('active').text("Deactivate map");
		        		map.setOptions({ draggable : true });
		        	}
		        });
		    }

		jQuery( "#advance-search-slider" ).slider({
		      	range: "min",
		      	value: 500,
		      	min: 1,
		      	max: <?php echo $maximRange; ?>,
		      	slide: function( event, ui ) {
		       		jQuery( "#geo-radius" ).val( ui.value );
		       		jQuery( "#geo-radius-search" ).val( ui.value );

		       		jQuery( ".geo-location-switch" ).removeClass("off");
		      	 	jQuery( ".geo-location-switch" ).addClass("on");
		      	 	jQuery( "#geo-location" ).val("on");

		       		mapDiv.gmap3({
						getgeoloc:{
							callback : function(latLng){
								if (latLng){
									jQuery('#geo-search-lat').val(latLng.lat());
									jQuery('#geo-search-lng').val(latLng.lng());
								}
							}
						}
					});

		      	}
		    });
		    jQuery( "#geo-radius" ).val( jQuery( "#advance-search-slider" ).slider( "value" ) );
		    jQuery( "#geo-radius-search" ).val( jQuery( "#advance-search-slider" ).slider( "value" ) );

		    jQuery('.geo-location-button .fa').click(function()
			{
				
				if(jQuery('.geo-location-switch').hasClass('off'))
			    {
			        jQuery( ".geo-location-switch" ).removeClass("off");
				    jQuery( ".geo-location-switch" ).addClass("on");
				    jQuery( "#geo-location" ).val("on");

				    mapDiv.gmap3({
						getgeoloc:{
							callback : function(latLng){
								if (latLng){
									jQuery('#geo-search-lat').val(latLng.lat());
									jQuery('#geo-search-lng').val(latLng.lng());
								}
							}
						}
					});

			    } else {
			    	jQuery( ".geo-location-switch" ).removeClass("on");
				    jQuery( ".geo-location-switch" ).addClass("off");
				    jQuery( "#geo-location" ).val("off");
			    }
		           
		    });

		});
		</script>

		<?php 

			global $redux_demo; 

			$header_version = $redux_demo['header-version'];

		?>

		<?php if($header_version == 1) { ?>

		<div id="advanced-search-widget">

			<div class="container">

				<div class="advanced-search-widget-content">

					<div class="advanced-search-title">

						<?php _e( 'Search around my position', 'agrg' ); ?>

					</div>

					<div class="advanced-search-slider">

						<div class="geo-location-button">

							<div class="geo-location-switch off"><i class="fa fa-location-arrow"></i></div>

						</div>

						<div id="advance-search-slider" class="value-slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
								<a class="ui-slider-handle ui-state-default ui-corner-all" href="#">
									
								</a>
								<div class="range-pin">
										<input type="text" name="geo-radius" id="geo-radius" value="100" data-default-value="100" />
								</div>
							</div>

					</div>

				</div>

			</div>

		</div>

		<?php } elseif($header_version == 2) { ?>

		<div id="advanced-search-widget-version2">

			<div class="container">

				<div class="advanced-search-widget-content">

					<form action="<?php echo home_url(); ?>" method="get" id="views-exposed-form-search-view-other-ads-page" accept-charset="UTF-8">

						<div id="edit-search-api-views-fulltext-wrapper" class="views-exposed-widget views-widget-filter-search_api_views_fulltext">
					        <div class="views-widget">
					          	<div class="control-group form-type-textfield form-item-search-api-views-fulltext form-item">
									<div class="controls"> 
										<input placeholder="<?php echo $trns_skeywords; ?>" type="text" id="edit-search-api-views-fulltext" name="s" value="" size="30" maxlength="128" class="form-text">
										<input type="hidden" id="hidden-keyword" name="s" value="all" size="30" maxlength="128" class="form-text">
									</div>
								</div>
						    </div>
						</div>
						          						
						<div id="edit-ad-location-wrapper" class="views-exposed-widget views-widget-filter-field_ad_location">
						   	<div class="views-widget">
						        <div class="control-group form-type-select form-item-ad-location form-item">
									<div class="controls"> 
										<select id="edit-ad-location" name="post_location" class="form-select" style="display: none;">
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
									</div>
								</div>
						    </div>
						</div>

						<div id="edit-field-category-wrapper" class="views-exposed-widget views-widget-filter-field_category">
						    <div class="views-widget">
						        <div class="control-group form-type-select form-item-field-category form-item">
									<div class="controls"> 
										<select id="edit-field-category" name="category_name" class="form-select" style="display: none;">
													
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
														<option value="<?php echo $cat->cat_name; ?>"><?php echo $cat->cat_name; ?></option>
																			
												<?php 
													$args2 = array(
														'hide_empty' => '0',
														'parent' => $catID
													);
													$categories = get_categories($args2);
													foreach ($categories as $cat) { ?>
														<option value="<?php echo $cat->slug; ?>">- <?php echo $cat->cat_name; ?></option>
												<?php } ?>

												<?php } else { ?>
												<?php }
											} ?>

										</select>
									</div>
								</div>
						    </div>
						</div>

						<div class="advanced-search-slider">

							<div class="geo-location-button">

								<div class="geo-location-switch off"><i class="fa fa-location-arrow"></i></div>

							</div>

							<div id="advance-search-slider" class="value-slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
								<a class="ui-slider-handle ui-state-default ui-corner-all" href="#">
									
								</a>
								<div class="range-pin">
										<input type="text" name="geo-radius" id="geo-radius" value="100" data-default-value="100" />
								</div>
							</div>

						</div>


						<input type="text" name="geo-location" id="geo-location" value="off" data-default-value="off">

						<input type="text" name="geo-radius-search" id="geo-radius-search" value="500" data-default-value="500">

						<input type="text" name="geo-search-lat" id="geo-search-lat" value="0" data-default-value="0">

						<input type="text" name="geo-search-lng" id="geo-search-lng" value="0" data-default-value="0">


						<div class="views-exposed-widget views-submit-button">
						    <button class="btn btn-primary form-submit" id="edit-submit-search-view" name="" value="Search" type="submit"><?php printf( __( 'Search', 'agrg' )); ?></button>
						</div>

					</form>

				</div>

			</div>

		</div>

		<?php } ?>

	</section>

<?php endif; ?>
<?php if($page_slider  != "Big Map" && $page_slider != "LayerSlider") { ?>

		<div id="advanced-search-widget-version2" style="position:relative">

			<div class="container">

				<div class="advanced-search-widget-content">

					<form action="<?php echo home_url(); ?>" method="get" id="views-exposed-form-search-view-other-ads-page" accept-charset="UTF-8">

						<div id="edit-search-api-views-fulltext-wrapper" class="views-exposed-widget views-widget-filter-search_api_views_fulltext">
					        <div class="views-widget">
					          	<div class="control-group form-type-textfield form-item-search-api-views-fulltext form-item">
									<div class="controls"> 
										<input placeholder="<?php echo $trns_skeywords; ?>" type="text" id="edit-search-api-views-fulltext" name="s" value="" size="30" maxlength="128" class="form-text">
										<input type="hidden" id="hidden-keyword" name="s" value="all" size="30" maxlength="128" class="form-text">
									</div>
								</div>
						    </div>
						</div>
						          						
						<div id="edit-ad-location-wrapper" class="views-exposed-widget views-widget-filter-field_ad_location">
						   	<div class="views-widget">
						        <div class="control-group form-type-select form-item-ad-location form-item">
									<div class="controls"> 
										<select id="edit-ad-location" name="post_location" class="form-select" style="display: none;">
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
									</div>
								</div>
						    </div>
						</div>

						<div id="edit-field-category-wrapper" class="views-exposed-widget views-widget-filter-field_category">
						    <div class="views-widget">
						        <div class="control-group form-type-select form-item-field-category form-item">
									<div class="controls"> 
										<select id="edit-field-category" name="category_name" class="form-select" style="display: none;">
													
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
														<option value="<?php echo $cat->cat_name; ?>"><?php echo $cat->cat_name; ?></option>
																			
												<?php 
													$args2 = array(
														'hide_empty' => '0',
														'parent' => $catID
													);
													$categories = get_categories($args2);
													foreach ($categories as $cat) { ?>
														<option value="<?php echo $cat->slug; ?>">- <?php echo $cat->cat_name; ?></option>
												<?php } ?>

												<?php } else { ?>
												<?php }
											} ?>

										</select>
									</div>
								</div>
						    </div>
						</div>

						<div class="advanced-search-slider">

							<div class="geo-location-button">

								<div class="geo-location-switch off"><i class="fa fa-location-arrow"></i></div>

							</div>

							<div id="advance-search-slider" class="value-slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
								<a class="ui-slider-handle ui-state-default ui-corner-all" href="#">
									
								</a>
								<div class="range-pin">
										<input type="text" name="geo-radius" id="geo-radius" value="100" data-default-value="100" />
								</div>
							</div>

						</div>


						<input type="text" name="geo-location" id="geo-location" value="off" data-default-value="off">

						<input type="text" name="geo-radius-search" id="geo-radius-search" value="500" data-default-value="500">

						<input type="text" name="geo-search-lat" id="geo-search-lat" value="0" data-default-value="0">

						<input type="text" name="geo-search-lng" id="geo-search-lng" value="0" data-default-value="0">


						<div class="views-exposed-widget views-submit-button">
						    <button class="btn btn-primary form-submit" id="edit-submit-search-view" name="" value="Search" type="submit"><?php printf( __( 'Search', 'agrg' )); ?></button>
						</div>

					</form>

				</div>

			</div>

		</div>

    <?php 
	}
		global $redux_demo; 

		$featured_ads_option = $redux_demo['featured-options-on'];

	?>

	<?php if($featured_ads_option == 1) { ?>

    <section id="featured-abs">
        
        <div class="container">
            
            <h2 class="main-title"><?php echo $trns_premium_ads; ?></h2>
            
            <div id="tabs" class="full">
			    	
                <?php $cat_id = get_cat_ID(single_cat_title('', false)); ?>
			    	
                <ul class="tabs quicktabs-tabs quicktabs-style-nostyle"> 
			    	<li class="grid-feat-ad-style"><a class="" href="#">Grid View</a></li>
			    	<li class="list-feat-ad-style"><a class="" href="#">List View</a></li>
                </ul>

                <div class="pane">
                 
                    <div id="carousel-buttons">
			    	    <a href="#" id="carousel-prev"><i class="fa fa-angle-left"></i></a>
			    	    <a href="#" id="carousel-next"><i class="fa fa-angle-right"></i></a>
			        </div>

					<div id="projects-carousel">

			    		<?php

							global $paged, $wp_query, $wp;

							$args = wp_parse_args($wp->matched_query);

							$temp = $wp_query;

							$wp_query= null;

							$wp_query = new WP_Query();

							$wp_query->query('post_type=post&posts_per_page=-1');

							$current = -1;

						?>

						<?php while ($wp_query->have_posts()) : $wp_query->the_post();

							$featured_post = "0";

							$post_price_plan_activation_date = get_post_meta($post->ID, 'post_price_plan_activation_date', true);
							$post_price_plan_expiration_date = get_post_meta($post->ID, 'post_price_plan_expiration_date', true);
							$post_price_plan_expiration_date_noarmal = get_post_meta($post->ID, 'post_price_plan_expiration_date_normal', true);
							$todayDate = strtotime(date('m/d/Y h:i:s'));
							$expireDate = $post_price_plan_expiration_date;

							if(!empty($post_price_plan_activation_date)) {

								if(($todayDate < $expireDate) or $post_price_plan_expiration_date == 0) {
									$featured_post = "1";
								}

						} ?>

						<?php if($featured_post == "1") { 

							$current++;

						?>

						<div class="ad-box span3">
							<?php
								if ( has_post_thumbnail()) {
								   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
								   echo '<a class="ad-image" href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
								   echo get_the_post_thumbnail($post->ID, 'single-post-image'); 
								   echo '</a>';
								 }
							?>
			    			

			    			<div class="ad-hover-content">
			    				<div class="ad-category">
			    					
			    					<?php
 
						        		$category = get_the_category();

						        		if ($category[0]->category_parent == 0) {

											$tag = $category[0]->cat_ID;

											$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
											if (isset($tag_extra_fields[$tag])) {
											    $category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
											    $category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
											}

										} else {

											$tag = $category[0]->category_parent;

											$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
											if (isset($tag_extra_fields[$tag])) {
											    $category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
											    $category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
											}

										}

										if(!empty($category_icon_code)) {

									?>

					        		<div class="category-icon-box" style="background-color: <?php echo $category_icon_color; ?>;"><?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?></div>

					        		<?php } 

					        		$category_icon_code = "";

					        		?>

			    				</div>
								<?php $post_price = get_post_meta($post->ID, 'post_price', true); ?>
								<div class="add-price"><span><?php echo $post_price; ?></span></div> 
								
			    			</div>	
							
								<div class="post-title">
									<a href="<?php the_permalink(); ?>"><?php $theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 40) ? substr($theTitle,0,37).'...' : $theTitle; echo $theTitle; ?></a>
								</div>
			    				

			    			

						</div>

			    		<?php } ?>

			    		<?php endwhile; ?>	
												
						<?php wp_reset_query(); ?>

			    	</div>

			    	<?php wp_enqueue_script( 'jquery-carousel', get_template_directory_uri().'/js/jquery.carouFredSel-6.2.1-packed.js', array('jquery'),'',true); ?>
										
					<script>

						jQuery(document).ready(function () {
							"use strict";
							jQuery('#projects-carousel').carouFredSel({
								auto: false,
								prev: '#carousel-prev',
								next: '#carousel-next',
								pagination: "#carousel-pagination",
								mousewheel: true,
								swipe: {
									onMouse: true,
									onTouch: true
								} 
							});

						});
											
					</script>
					<!-- end scripts -->

			    </div>



			</div>
        
        </div>

    </section>

    <?php }else{ ?>

    <section id="featured-abs">
        
        <div class="container">
            
            <h2 class="main-title"><?php echo $trns_premium_ads; ?></h2>
            
            <div id="tabs" class="full">
			    	
                <?php $cat_id = get_cat_ID(single_cat_title('', false)); ?>
			    	
                <ul class="tabs quicktabs-tabs quicktabs-style-nostyle"> 
			    	<li class="grid-feat-ad-style"><a class="" href="#">Grid View</a></li>
			    	<li class="list-feat-ad-style"><a class="" href="#">List View</a></li>
                </ul>

                <div class="pane">
                 
                    <div id="carousel-buttons">
			    	    <a href="#" id="carousel-prev"><i class="fa fa-angle-left"></i></a>
			    	    <a href="#" id="carousel-next"><i class="fa fa-angle-right"></i></a>
			        </div>

					<div id="projects-carousel">

			    		<?php

							global $paged, $wp_query, $wp;							
							
							$featured_cat = $redux_demo['featured_cat'];
							
							$args = wp_parse_args($wp->matched_query);

							$temp = $wp_query;

							$wp_query= null;

							$wp_query = new WP_Query();

							$wp_query->query('post_type=post&posts_per_page=-1&category_name='.$featured_cat.'');

							$current = -1;

						?>

						<?php while ($wp_query->have_posts()) : $wp_query->the_post();

							$featured_post = "1";

							$post_price_plan_activation_date = get_post_meta($post->ID, 'post_price_plan_activation_date', true);
							$post_price_plan_expiration_date = get_post_meta($post->ID, 'post_price_plan_expiration_date', true);
							$post_price_plan_expiration_date_noarmal = get_post_meta($post->ID, 'post_price_plan_expiration_date_normal', true);
							?>

						<?php if($featured_post == "1") { 

							$current++;

						?>

						<div class="ad-box span3">
							<?php
								if ( has_post_thumbnail()) {
								   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
								   echo '<a class="ad-image" href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
								   echo get_the_post_thumbnail($post->ID, 'single-post-image'); 
								   echo '</a>';
								 }
							?>
			    			

			    			<div class="ad-hover-content">
			    				<div class="ad-category">
			    					
			    					<?php
 
						        		$category = get_the_category();

						        		if ($category[0]->category_parent == 0) {

											$tag = $category[0]->cat_ID;

											$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
											if (isset($tag_extra_fields[$tag])) {
											    $category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
											    $category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
											}

										} else {

											$tag = $category[0]->category_parent;

											$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
											if (isset($tag_extra_fields[$tag])) {
											    $category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
											    $category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
											}

										}

										if(!empty($category_icon_code)) {

									?>

					        		<div class="category-icon-box" style="background-color: <?php echo $category_icon_color; ?>;"><?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?></div>

					        		<?php } 

					        		$category_icon_code = "";

					        		?>

			    				</div>
								<?php $post_price = get_post_meta($post->ID, 'post_price', true); ?>
								<div class="add-price"><span><?php echo $post_price; ?></span></div> 
								
			    			</div>	
							
								<div class="post-title">
									<a href="<?php the_permalink(); ?>"><?php $theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 40) ? substr($theTitle,0,37).'...' : $theTitle; echo $theTitle; ?></a>
								</div>
			    				

			    			

						</div>

			    		<?php } ?>

			    		<?php endwhile; ?>	
												
						<?php wp_reset_query(); ?>

			    	</div>

			    	<?php wp_enqueue_script( 'jquery-carousel', get_template_directory_uri().'/js/jquery.carouFredSel-6.2.1-packed.js', array('jquery'),'',true); ?>
										
					<script>

						jQuery(document).ready(function () {
							jQuery('#projects-carousel').carouFredSel({
								auto: false,
								prev: '#carousel-prev',
								next: '#carousel-next',
								pagination: "#carousel-pagination",
								mousewheel: true,
								swipe: {
									onMouse: true,
									onTouch: true
								} 
							});

						});
											
					</script>
					<!-- end scripts -->

			    </div>


			</div>
        
        </div>

    </section>

    <?php } 

		global $redux_demo; 

		$category_block = $redux_demo['category-block'];

	?>

	<?php if($category_block == 1) { ?>
    <section id="categories-homepage">
        
        <div class="container">

	        <?php $categories = get_categories('hide_empty=0');

		    	$currentCat = 0;
							      
				foreach ($categories as $category) { 

					if ($category->category_parent == 0) {

						$currentCat++;

					}

				}

			?>
            
            <h2 class="main-title"><?php echo $trns_categories; ?></h2>

            <div class="full">

					<?php
						$argsmain = array(
										'order'                    => 'DESC',
										'hide_empty'               => 1,						
										'number'                   => '8',
										'taxonomy'                 => 'category',
										'pad_counts'               => false 

									); 
										
					//$categories = get_categories('hide_empty=1','number=8');
					$cat_counter = $redux_demo['home-cat-counter'];
					$categories = get_terms(
					'category', 
					array('hide_empty' => 0,'parent' => 0,'number' => $cat_counter,'order'=> 'ASC')	
					);
						$current = -1;
						//print_r($categories);		      
						foreach ($categories as $category) { 



								$tag = $category->term_id;

								$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
								if (isset($tag_extra_fields[$tag])) {
									$category_icon_code = $tag_extra_fields[$tag]['category_icon_code']; 
									$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
								}

								$cat = $category->count;
								$catName = $category->term_id;

								$current++;
								$allPosts = 0;

								$categories = get_categories('child_of='.$catName); 
								foreach ($categories as $category) {
									$allPosts += $category->category_count;
								}

					 ?>

					<div class="category-box span3 <?php if($current%4 == 0) { echo 'first'; } ?>">

						<div class="category-header">

							<div class="category-icon">
								<?php if(!empty($category_icon_code)) { ?>

									<div class="category-icon-box"><?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?></div>

								<?php } ?>
							</div>

							<div class="cat-title"><a href="<?php echo get_category_link( $catName ) ?>"><h4><?php echo get_cat_name( $catName ); ?></h4></a></div>


						</div>

						<div class="category-content">

							<ul>   

								<?php

									$currentCat = 0;

									$args2 = array(
										'type' => 'post',
										'child_of' => $catName,
										'parent' => get_query_var(''),
										'orderby' => 'name',
										'order' => 'ASC',
										'hide_empty' => 0,
										'hierarchical' => 1,
										'exclude' => '',
										'include' => '',
										'number' => '',
										'taxonomy' => 'category',
										'pad_counts' => true );

									$categories2 = get_categories($args2);

									foreach($categories2 as $category2) { 
										$currentCat++;
									}

									$args = array(
										'type' => 'post',
										'child_of' => $catName,
										'parent' => get_query_var(''),
										'orderby' => 'name',
										'order' => 'ASC',
										'hide_empty' => 0,
										'hierarchical' => 1,
										'exclude' => '',
										'include' => '',
										'number' => '5',
										'taxonomy' => 'category',
										'pad_counts' => true );

									$categories = get_categories($args);
									foreach($categories as $category) {
								?>

									<li>
										<a href="<?php echo get_category_link( $category->term_id )?>" title="View posts in <?php echo $category->name?>">
											<?php $categoryTitle = $category->name; $categoryTitle = (strlen($categoryTitle) > 30) ? substr($categoryTitle,0,27).'...' : $categoryTitle; echo $categoryTitle; ?>
										</a>
										<span class="category-counter">( <?php echo $category->count ?> )</span>
									</li>

								<?php } ?> 

								<?php if($currentCat > 5) { ?>

									<li>
										<a href="<?php echo get_category_link( $catName ) ?>"><?php _e( 'Others', 'agrg' ); ?> </a>
										<span class="category-counter"><?php echo $allPosts; ?></span>
									</li>

								<?php } ?>

							</ul>

						</div>

					</div>

					<?php }  ?>

			</div>

        </div>

    </section>
	<?php } ?>
	<section id="custom-ads">
		<?php 
		
		$homeAdImg = $redux_demo['home_ad']['url']; 
		$homeAdImglink = $redux_demo['home_ad_link']; 
		$homeAdCode = $redux_demo['home_ad_code_client']; 
		$homeAdCodeslot = $redux_demo['home_ad_code_slot']; 
		$homeAdCodewidth = $redux_demo['home_ad_code_width']; 
		$homeAdCodeheight = $redux_demo['home_ad_code_height']; 
		if(!empty($homeAdCode) || !empty($homeAdImg)){
		if(!empty($homeAdCode)){
				$homeAd = '<ins class="adsbygoogle"
						 style="display:inline-block;width:'.$homeAdCodewidth.'px;height:'.$homeAdCodeheight.'px"
						 data-ad-client="'.$homeAdCode.'"
						 data-ad-slot="'.$homeAdCodeslot.'"></ins>';
		}else{
				$homeAd = '<a href="'.$homeAdImglink.'" target="_blank"><img alt="image" src="'.$homeAdImg.'" /></a>';
		}
		}
		?>
	
		<div class="container">
			<div class="home-page-ad">				
				<?php echo $homeAd; ?>
			</div>
		</div>
	</section>
	<?php	$homepage_callout_on = $redux_demo['homepage-callout-on'];
			if($homepage_callout_on == 1){ ?>
	<div class="container ">
		<div class="callout clearfix">
		<?php
			$calloutTitle= ''; 
			$calloutDesc= ''; 
			$calloutBTn= ''; 
			$calloutBTnURL= '';
			
			$calloutTitle= $redux_demo['callout_title']; 
			$calloutDesc= $redux_demo['callout_desc']; 
			$calloutBTn= $redux_demo['callout_btn_text']; 
			$calloutBTnURL= $redux_demo['callout_btn_url'];	
			$calloutQuotes = preg_match_all('/".*?"|\'.*?\'/', $calloutTitle, $matches);
			$calloutQuotes = trim($matches[0][0],'"');			
			$calloutTitle = str_replace($calloutQuotes,"<span>".$calloutQuotes."</span>",$calloutTitle);
		?>
			<div class="callout-inner">
				<div class="callout-title"><h4><?php echo $calloutTitle; ?></h4></div>
				<div class="callout-desc">
					<p><?php echo $calloutDesc; ?></p>
				</div>
			</div>
			<div class="callbutton">
				<div class="callbutton-inner">
					<a href="<?php echo $calloutBTnURL; ?>">
						<span><?php echo $calloutBTn; ?></span>
					</a>
				</div>
			</div>	
			
		</div>
	</div>	
	<?php } ?>
	<?php	$locations_box_on = $redux_demo['homepage-adloc-on'];
			if($locations_box_on == 1){ ?>
	<section id="locations">
	<div class="container">
		<h2 class="main-title"><?php _e( 'AD LOCATIONS', 'agrg' ); ?></h2>
			<div class="h2-seprator"></div>
		<div class="location clearfix">
		<?php
			$locationTemplate = $wpdb->get_results("SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` ='_wp_page_template' AND `meta_value` = 'template-locations.php' ", ARRAY_A);
			$locationTemplatePermalink = get_permalink($locationTemplate[0]['post_id']);
			global $wp_rewrite;
			if ($wp_rewrite->permalink_structure == ''){
			//we are using ?page_id
			$locationURL = $locationTemplatePermalink."&location=";
			}else{
			//we are using permalinks
			$locationURL = $locationTemplatePermalink."?location=";
			}
			$args_location = array( 'posts_per_page' => -1 );
			$lastposts = get_posts( $args_location );
			$all_post_location = array();
			foreach( $lastposts as $post ) {
			$all_post_location[] = get_post_meta( $post->ID, 'post_location', true );
			}
			$directors = array_unique($all_post_location);
			foreach ($directors as $director) {
				if(!empty($director)){
			?>
			<div class="span2">
			<a href="<?php echo $locationURL; ?><?php echo $director; ?>"><i class="fa fa-map-marker"></i><?php echo $director; ?></a>
			</div>
			<?php }} ?>
		<?php wp_reset_query(); ?>
		</div>
		</div>
	</section>
	<?php } ?>
	

    <section id="ads-homepage">
	
		  <h2 class="main-title"><?php echo $trns_classify_ads; ?></h2>
        
        <div class="container">

        	<ul class="tabs quicktabs-tabs quicktabs-style-nostyle">
			    <li >
			    	<a style="font-size: 14px !important; " class="current" href="#"><?php echo $trns_latest_ads; ?></a>
			    </li>
			    <li>
			    	<a style="font-size: 14px !important;" class="" href="#"><?php echo $trns_popular_ads; ?></a>
			    </li>
			    <li>
			    	<a style="font-size: 14px !important;" class="" href="#"><?php echo $trns_random_ads; ?></a>
			    </li>
			</ul>

			<div class="pane latest-ads-holder">

				<div class="latest-ads-grid-holder">

				<?php

					global $paged, $wp_query, $wp;

					$args = wp_parse_args($wp->matched_query);

					if ( !empty ( $args['paged'] ) && 0 == $paged ) {

						$wp_query->set('paged', $args['paged']);

						$paged = $args['paged'];

					}

					$cat_id = get_cat_ID(single_cat_title('', false));

					$temp = $wp_query;

					$wp_query= null;
					$ads_counter = $redux_demo['home-ads-counter'];

					$wp_query = new WP_Query();

					$wp_query->query('post_type=post&posts_per_page='.$ads_counter.'&paged='.$paged.'&cat='.$cat_id);

					$current = -1;
					$current2 = 0;

					?>

					<?php while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++; ?>

						<div class="ad-box span3 latest-posts-grid <?php if($current%4 == 0) { echo 'first'; } ?>">

							<?php
								if ( has_post_thumbnail()) {
								   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
								   echo '<a class="ad-image" href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
								   echo get_the_post_thumbnail($post->ID, '291x250'); 
								   echo '</a>';
								 }
							?>

				    		<div class="ad-hover-content">

				    			<div class="ad-category">
				    					
				    				<?php

							        	$category = get_the_category();

							        	if ($category[0]->category_parent == 0) {

											$tag = $category[0]->cat_ID;

											$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
											if (isset($tag_extra_fields[$tag])) {
												$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
												$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
											}

										} else {

											$tag = $category[0]->category_parent;

											$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
											if (isset($tag_extra_fields[$tag])) {
												$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
												$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
											}

										}

										if(!empty($category_icon_code)) {

									?>

						        	<div class="category-icon-box" style="background-color: <?php echo $category_icon_color; ?>;"><?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?></div>

						        	<?php } 

						        	$category_icon_code = "";

						        	?>

				    			</div>

				    			
				    			<?php $post_price = get_post_meta($post->ID, 'post_price', true); ?>
								<div class="add-price"><span><?php echo $post_price; ?></span></div> 
								
				    		</div>
								<div class="post-title">
									<a href="<?php the_permalink(); ?>"><?php $theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 50) ? substr($theTitle,0,47).'...' : $theTitle; echo $theTitle; ?></a>
								</div>

						</div>

					<?php endwhile; ?>

				</div>
											
			<!-- Begin wpcrown_pagination-->	
			<?php get_template_part('pagination'); ?>
			<!-- End wpcrown_pagination-->	
																
			<?php wp_reset_query(); ?>

			</div>

			<div class="pane popular-ads-grid-holder">

				<div class="popular-ads-grid">

					<?php

						global $paged, $wp_query, $wp;

						$args = wp_parse_args($wp->matched_query);

						if ( !empty ( $args['paged'] ) && 0 == $paged ) {

							$wp_query->set('paged', $args['paged']);

							$paged = $args['paged'];

						}

						$cat_id = get_cat_ID(single_cat_title('', false));
						$ads_counter = $redux_demo['home-ads-counter'];

						$current = -1;
						$current2 = 0;


						$popularpost = new WP_Query( array( 'posts_per_page' => $ads_counter, 'cat' => $cat_id, 'posts_type' => 'post', 'paged' => $paged, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'  ) );										

						while ( $popularpost->have_posts() ) : $popularpost->the_post(); $current++; $current2++;

						?>

						<div class="ad-box span3 popular-posts-grid <?php if($current%4 == 0) { echo 'first'; } ?>">

							<?php
								if ( has_post_thumbnail()) {
								   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
								   echo '<a class="ad-image" href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
								   echo get_the_post_thumbnail($post->ID, '291x250'); 
								   echo '</a>';
								 }
							?>

				    		<div class="ad-hover-content">

				    			<div class="ad-category">
				    					
				    				<?php

							        	$category = get_the_category();

							        	if ($category[0]->category_parent == 0) {

											$tag = $category[0]->cat_ID;

											$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
											if (isset($tag_extra_fields[$tag])) {
												$category_icon_code = $tag_extra_fields[$tag]['category_icon_code']; 
												$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
											}

										} else {

											$tag = $category[0]->category_parent;

											$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
											if (isset($tag_extra_fields[$tag])) {
												$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
												$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
											}

										}

										if(!empty($category_icon_code)) {

									?>

						        	<div class="category-icon-box" style="background-color: <?php echo $category_icon_color; ?>;"><?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?></div>

						        	<?php } 

						        	$category_icon_code = "";

						        	?>

				    			</div>

				    			
				    			<?php $post_price = get_post_meta($post->ID, 'post_price', true); ?>
								<div class="add-price"><span><?php echo $post_price; ?></span></div> 
								
								

				    		</div>
							<div class="post-title">
									<a href="<?php the_permalink(); ?>"><?php $theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 50) ? substr($theTitle,0,47).'...' : $theTitle; echo $theTitle; ?></a>

							</div>

						</div>

					<?php endwhile; ?>

				</div>
											
				<!-- Begin wpcrown_pagination-->	
				<?php get_template_part('pagination'); ?>
				<!-- End wpcrown_pagination-->	
																
				<?php wp_reset_query(); ?>

			</div>

			<div class="pane random-ads-grid-holder">

				<div class="random-ads-grid">

					<?php

					global $paged, $wp_query, $wp;

					$args = wp_parse_args($wp->matched_query);

					if ( !empty ( $args['paged'] ) && 0 == $paged ) {

						$wp_query->set('paged', $args['paged']);

						$paged = $args['paged'];

					}

					$cat_id = get_cat_ID(single_cat_title('', false));

					$temp = $wp_query;

					$wp_query= null;
					
					$ads_counter = $redux_demo['home-ads-counter'];

					$wp_query = new WP_Query();

					$wp_query->query('orderby=title&post_type=post&posts_per_page='.$ads_counter.'&paged='.$paged.'&cat='.$cat_id);

					$current = -1;
					$current2 = 0;

					?>

					<?php while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++; ?>

						<div class="ad-box span3 random-posts-grid <?php if($current%4 == 0) { echo 'first'; } ?>">

							<?php
								if ( has_post_thumbnail()) {
								   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
								   echo '<a class="ad-image" href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
								   echo get_the_post_thumbnail($post->ID, '291x250'); 
								   echo '</a>';
								 }
							?>

				    		<div class="ad-hover-content">

				    			<div class="ad-category">
				    					
				    				<?php

							        	$category = get_the_category();

							        	if ($category[0]->category_parent == 0) {

											$tag = $category[0]->cat_ID;

											$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
											if (isset($tag_extra_fields[$tag])) {
												$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
												$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
											}

										} else {

											$tag = $category[0]->category_parent;

											$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
											if (isset($tag_extra_fields[$tag])) {
												$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
												$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
											}

										}

										if(!empty($category_icon_code)) {

									?>

						        	<div class="category-icon-box" style="background-color: <?php echo $category_icon_color; ?>;"><?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?></div>

						        	<?php } 

						        	$category_icon_code = "";

						        	?>

				    			</div>

				    			<?php $post_price = get_post_meta($post->ID, 'post_price', true); ?>
								<div class="add-price"><span><?php echo $post_price; ?></span></div> 

				    		</div>
							<div class="post-title">
								
				    			<a href="<?php the_permalink(); ?>"><?php $theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 50) ? substr($theTitle,0,47).'...' : $theTitle; echo $theTitle; ?></a>

							</div>
						</div>

					<?php endwhile; ?>

				</div>
											
				<!-- Begin wpcrown_pagination-->	
				<?php get_template_part('pagination'); ?>
				<!-- End wpcrown_pagination-->	
																
				<?php wp_reset_query(); ?>

			</div>

        </div>

    </section>
	<section id="container" style="background: none;">

    	<div id="content" class="woocommerce" style="margin-top: 30px;">

    		<h2><?php _e( 'Recent Products', 'agrg' ); ?></h2>

    		<div style="margin-bottom: 0; margin-top: 20px;">
    			<?php echo do_shortcode( "[recent_products per_page='12' columns='4']" ) ?>
    		</div>

    	</div>

    </section>
    <script>
		// perform JavaScript after the document is scriptable.
		jQuery(function() {
		"use strict";
			jQuery("ul.tabs").tabs("> .pane", {effect: 'fade', fadeIn: 200});
		});
	</script>

<?php get_footer(); ?>