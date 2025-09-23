<?php


class klb_widget_klb_product_categories extends WP_Widget { 
	
	// Widget Settings
	function __construct() {
		$widget_ops = array('description' => esc_html__('For Main Shop Page.','blonwe-core') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'klb_product_categories' );
		 parent::__construct( 'klb_product_categories', esc_html__('Blonwe Product Categories','blonwe-core'), $widget_ops, $control_ops );
	}

	// Widget Output
	function widget($args, $instance) {

			extract($args);
			$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
			$exclude = $instance['exclude'];

			echo $before_widget;

			if($title) {
				echo $before_title . $title . $after_title;
			}


			if($exclude == 'all'){
				$terms = get_terms( array(
					'taxonomy' => 'product_cat',
					'hide_empty' => false,
					'parent'    => 0,
				) );
			} else {
				$str = $exclude;
		    	$arr = explode(',', $str);
		
				$terms = get_terms( array(
					'taxonomy' => 'product_cat',
					'hide_empty' => false,
					'parent'    => 0,
					'exclude'   => $arr,
				) );
			}
			
			wp_enqueue_script( 'klb-widget-product-categories');
			wp_enqueue_style( 'klb-widget-product-categories');
			
			echo '<div class="widget-body">';
			echo '<div class="widget-checkbox-list">';
			echo '<ul>';

			foreach ( $terms as $term ) {
				$term_children = get_terms( array(
									'taxonomy' => 'product_cat',
									'parent' => $term->term_id,
									'hide_empty' => false,
								) );

				$checkbox = '';
				if(isset($_GET['filter_cat'])){
					if(in_array($term->term_id, explode(',',$_GET['filter_cat']))){
						$checkbox = 'checked';
					}
				}
				

				echo '<li>';
				if(is_shop()){
					echo '<a href="'.esc_url(blonwe_get_cat_url($term->term_id)).'" class="product_cat">';
				} else {
					echo '<a href="'.esc_url(get_term_link( $term )).'" class="product_cat">';
				}
				echo '<input name="product_cat[]" value="'.esc_attr($term->term_id).'" id="'.esc_attr($term->name).'" type="checkbox" '.esc_attr($checkbox).' '.blonwe_current_term($term).'>';
				echo '<label ><span></span>'.esc_html($term->name).'</label>';
				echo '</a>';
					if($term_children){
						echo '<ul class="children">';
						
						foreach($term_children as $child){
							$childterm = get_term_by( 'id', $child->term_id, 'product_cat' );
							$term_third_children = get_terms( array(
														'taxonomy' => 'product_cat',
														'parent' => $childterm->term_id,
														'hide_empty' => false,
													) );

							$childcheckbox = '';
							if(isset($_GET['filter_cat'])){
								if(in_array($childterm->term_id, explode(',',$_GET['filter_cat']))){ 
									$childcheckbox .= 'checked';
								}
							} 
							

							echo '<li>';
							if(is_shop()){
								echo '<a href="'.esc_url(blonwe_get_cat_url($childterm->term_id)).'">';
							} else {
								echo '<a href="'.esc_url(get_term_link( $child )).'">';
							}
							echo '<input name="product_cat[]" value="'.esc_attr($childterm->term_id).'" id="'.esc_attr($childterm->name).'" type="checkbox" '.esc_attr($childcheckbox).' '.blonwe_current_term($childterm).'>';
							echo '<label><span></span>'.esc_html($childterm->name).'</label>';
							echo '</a>';
							if($term_third_children){
								
								echo '<ul class="children">';
								foreach($term_third_children as $third_child){
									$thirdchildterm = get_term_by( 'id', $third_child->term_id, 'product_cat' );
									$term_fourth_children = get_terms( array(
																'taxonomy' => 'product_cat',
																'parent' => $thirdchildterm->term_id,
																'hide_empty' => false,
															) );

									$thirdchildcheckbox = '';
									if(isset($_GET['filter_cat'])){
										if(in_array($thirdchildterm->term_id, explode(',',$_GET['filter_cat']))){ 
											$thirdchildcheckbox .= 'checked';
										}
									} 
									
									echo '<li>';
									if(is_shop()){
										echo '<a href="'.esc_url(blonwe_get_cat_url($thirdchildterm->term_id)).'">';
									} else {
										echo '<a href="'.esc_url(get_term_link( $third_child )).'">';
									}
									echo '<input name="product_cat[]" value="'.esc_attr($thirdchildterm->term_id).'" id="'.esc_attr($thirdchildterm->name).'" type="checkbox" '.esc_attr($thirdchildcheckbox).' '.blonwe_current_term($thirdchildterm).'>';
									echo '<label><span></span>'.esc_html($thirdchildterm->name).'</label>';
									echo '</a>';
									if($term_fourth_children){
										
										echo '<ul class="children">';
										foreach($term_fourth_children as $fourth_child){
											$fourthchildterm = get_term_by( 'id', $fourth_child->term_id, 'product_cat' );
														
											$fourthchildcheckbox = '';
											if(isset($_GET['filter_cat'])){
												if(in_array($fourthchildterm->term_id, explode(',',$_GET['filter_cat']))){ 
													$fourthchildcheckbox .= 'checked';
												}
											} 
											
											echo '<li>';
											if(is_shop()){
												echo '<a href="'.esc_url(blonwe_get_cat_url($fourthchildterm->term_id)).'">';
											} else {
												echo '<a href="'.esc_url(get_term_link( $fourth_child )).'">';
											}
											echo '<input name="product_cat[]" value="'.esc_attr($fourthchildterm->term_id).'" id="'.esc_attr($fourthchildterm->name).'" type="checkbox" '.esc_attr($fourthchildcheckbox).' '.blonwe_current_term($fourthchildterm).'>';
											echo '<label><span></span>'.esc_html($fourthchildterm->name).'</label>';
											echo '</a>';
											echo '</li>';
										}
										echo '</ul>';
									}
									echo '</li>';
								}
								echo '</ul>';
							}
							
							echo '</li>';

					
						}
						echo '</ul>';
					} 
				echo '</li>';
			}
			echo '</ul>';
			echo '</div>';
			echo '</div>';


			echo $after_widget;
	
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['exclude'] = strip_tags($new_instance['exclude']);
		
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array('title' => 'Product Categories', 'exclude' => 'All');
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','blonwe-core'); ?></label>
			<input class="widefat"  id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('exclude'); ?>"><?php esc_html_e('Exclude id:','blonwe-core'); ?></label>
			<input class="widefat"  id="<?php echo $this->get_field_id('exclude'); ?>" name="<?php echo $this->get_field_name('exclude'); ?>" value="<?php echo $instance['exclude']; ?>" />
		</p>

	<?php
	}
}

// Add Widget
function klb_widget_klb_product_categories_init() {
	register_widget('klb_widget_klb_product_categories');
}
add_action('widgets_init', 'klb_widget_klb_product_categories_init');

?>