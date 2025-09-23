<?php
/*************************************************
## Scripts
*************************************************/
function blonwe_single_low_stock_scripts() {
	wp_enqueue_style( 'klb-single-low-stock',   plugins_url( 'css/single-low-stock.css', __FILE__ ), false, '1.0');
}
add_action( 'wp_enqueue_scripts', 'blonwe_single_low_stock_scripts' );

/*************************************************
## Product Low Stock
*************************************************/
function blonwe_product_low_stock() {
	
	global $product;
	
	$managestock = $product->managing_stock();
	$stock_quantity = $product->get_stock_quantity();
	$stock_format = esc_html__('This item is low in stock.','blonwe');
	$stock_format2 = esc_html__('Item(s) left: %s','blonwe');
	$stock_poor = '';
	$low_stock_amount = wc_get_low_stock_amount($product);
	
	if($managestock && $stock_quantity < $low_stock_amount && $stock_quantity > 0) {
		$stock_poor .= '<div class="product-low-stock">';
			$stock_poor .= '<div class="icon">';
			$stock_poor .= '<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 47.5 47.5" viewBox="0 0 47.5 47.5"><defs><clipPath id="a" clipPathUnits="userSpaceOnUse"><path d="M 0,38 38,38 38,0 0,0 0,38 Z"/></clipPath><clipPath id="b" clipPathUnits="userSpaceOnUse"><path d="m 18.583,27.833 c -2.957,-0.231 -5.666,2.542 -4.666,7.042 l 0,0 c -3.239,-2.386 -3.332,-6.403 -2.333,-9 l 0,0 C 12.625,23.167 11.542,20.917 9,20.667 l 0,0 C 6.161,20.387 4.584,23.709 6.038,29 l 0,0 C 3.52,26.035 2,22.195 2,18 l 0,0 C 2,8.611 9.611,1 19,1 l 0,0 c 9.389,0 17,7.611 17,17 l 0,0 c 0,2.063 -0.367,4.039 -1.04,5.868 l 0,0 C 34.5,18.48 31.627,15.711 28.625,17 l 0,0 c -2.812,1.208 -0.917,5.917 -0.777,8.164 l 0,0 c 0.236,3.809 -0.012,8.169 -6.931,11.794 l 0,0 c 2.875,-5.499 0.333,-8.917 -2.334,-9.125"/></clipPath></defs><g transform="matrix(1.25 0 0 -1.25 0 47.5)"><g clip-path="url(#a)"><path fill="#f4900c" d="M 0,0 C 0,2.063 -0.367,4.039 -1.04,5.868 -1.5,0.479 -4.373,-2.289 -7.375,-1 c -2.813,1.208 -0.917,5.917 -0.777,8.164 0.236,3.809 -0.012,8.169 -6.931,11.794 2.875,-5.5 0.333,-8.916 -2.334,-9.125 -2.958,-0.23 -5.666,2.542 -4.666,7.042 -3.238,-2.386 -3.333,-6.402 -2.334,-9 C -23.375,5.167 -24.458,2.917 -27,2.667 -29.839,2.387 -31.417,5.708 -29.962,11 -32.48,8.035 -34,4.195 -34,0 c 0,-9.389 7.611,-17 17,-17 9.389,0 17,7.611 17,17" transform="translate(36 18)"/></g><g clip-path="url(#b)"><path fill="#ffcc4d" d="m 0,0 c 0,2.187 -0.584,4.236 -1.605,6.001 0.147,-3.084 -2.562,-4.293 -4.02,-3.709 -2.105,0.843 -1.541,2.291 -2.083,5.291 -0.542,3 -2.625,5.084 -5.709,6 2.25,-6.333 -1.247,-8.667 -3.08,-9.084 C -18.369,4.073 -20.25,4.5 -20.465,8.506 -22.648,6.332 -24,3.324 -24,0 c 0,-6.627 5.373,-12 12,-12 6.627,0 12,5.373 12,12" transform="translate(31 7)"/></g></g></svg></div>';
			$stock_poor .= '<div class="info"><span>'.sprintf($stock_format).'</span>';
			$stock_poor .= '<p>'.sprintf($stock_format2, $stock_quantity).'</p>';
			$stock_poor .= '</div>';
		$stock_poor .= '</div>';
	}
	
	echo $stock_poor;
}
add_action( 'woocommerce_after_add_to_cart_button',  'blonwe_product_low_stock' );
