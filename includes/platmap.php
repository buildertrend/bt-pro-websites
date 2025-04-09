<?php
// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}


// Example Usage
// [platmap]
function platmap_shortcode($atts = [])
{
	$attributes = shortcode_atts(
		array(
			'field_name' => 'platmap',
			'fallback' => ''
		),
		$atts
	);

	$field_value = get_field($attributes['field_name']);

	if (empty($field_value)) {
		return $attributes['fallback'];
	}

	return $field_value;
}
add_shortcode('platmap', 'platmap_shortcode');

add_filter('acf/shortcode/allow_unsafe_html', function ($allowed, $atts) {
	if ($atts['field'] === 'platmap') {
		return true;
	}
	return $allowed;
}, 10, 2);