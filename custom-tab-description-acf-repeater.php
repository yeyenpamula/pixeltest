<?php
// thanks to https://awhitepixel.com/blog/woocommerce-custom-product-tabs-with-advanced-custom-fields/ 
if (class_exists('acf') && class_exists('WooCommerce')) {
	add_filter('woocommerce_product_tabs', function($tabs) {
		global $post, $product;  // Access to the current product or post
		
		$custom_tabs_repeater = get_field('custom_tabs_repeater', $post->ID);
 
		if (!empty($custom_tabs_repeater)) {
			$counter = 0;
			$start_at_priority = 10;
			foreach ($custom_tabs_repeater as $custom_tab) {
				$tab_id = $counter . '_' . sanitize_title($custom_tab['tab_title']);
				
				$tabs[$tab_id] = [
					'title' => $custom_tab['tab_title'],
					'callback' => 'awp_custom_woocommerce_tabs',
					'priority' => $start_at_priority++
				];
				$counter++;
			}
		}
		return $tabs;
	});
 
	function awp_custom_woocommerce_tabs($key, $tab) {
		global $post;
 
		?><h2><?php echo $tab['title']; ?></h2><?php
 
		$custom_tabs_repeater = get_field('custom_tabs_repeater', $post->ID);
		
		$tab_id = explode('_', $key);
		$tab_id = $tab_id[0];
 
		echo $custom_tabs_repeater[$tab_id]['tab_contents'];
	}
}