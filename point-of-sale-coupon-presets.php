<?php
/**
 * Plugin Name:       Coupon Presets for POS
 * Plugin URI:        https://github.com/Shirkit/point-of-sale-coupon-presets
 * Description:       Adds some configurable discount presets to display on the Register front-end.
 * Version:           1.0.0
 * Author:            Shirkit
 * License:           MIT License
 * License URI:       https://raw.githubusercontent.com/Shirkit/point-of-sale-coupon-presets/master/LICENSE
 * GitHub Plugin URI: https://github.com/Shirkit/point-of-sale-coupon-presets
 */

add_filter('woocommerce_point_of_sale_general_settings_fields', 'my_custom_wocommerce_pos_settings', 10, 1);

function my_custom_wocommerce_pos_settings($settings) {
	$args = array(
		'posts_per_page'   => -1,
		'orderby'          => 'title',
		'order'            => 'asc',
		'post_type'        => 'shop_coupon',
		'post_status'      => 'publish',
	);
	$coupons = get_posts( $args );
	$list = array();
	foreach ($coupons as $coupon) {
		$list[$coupon->post_name] = $coupon->post_title;
	}
	$settings[] = array(
		'name' => __('Coupon Presets', 'wc_point_of_sale'),
		'desc_tip' => __('Define the preset coupon buttons when applying coupons to the order.', 'wc_point_of_sale'),
		'id' => 'woocommerce_pos_register_coupon_presets',
		'class' => 'wc-enhanced-select',
		'type' => 'multiselect',
		'options' => $list,

	);
	return $settings;
}

add_filter('wc_pos_inline_js', 'my_custom_data_to_register', 10, 1);

function my_custom_data_to_register($inline) {
	$inline['pos_coupon_presets'] = '<script data-cfasync="false" type="text/javascript" class="pos_coupon_presets"> var pos_coupon_presets = ' . json_encode(get_option('woocommerce_pos_register_coupon_presets')) . '; </script>';
	return $inline;
}

add_filter('wc_pos_enqueue_scripts', 'coupon_presets_scripts', 10, 1);
add_filter('wc_pos_enqueue_styles', 'coupon_presets_styles', 10, 1);

function coupon_presets_styles($styles) {
	$styles['coupon_presets'] = plugin_dir_url( __FILE__ ) . 'assets/coupons.css';
	return $styles;
}

function coupon_presets_scripts($scripts) {
	$scripts['coupon_presets'] = plugin_dir_url( __FILE__ ) . 'assets/coupons.js';
	return $scripts;
}
?>
