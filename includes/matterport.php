<?php
// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}


// Example Usage
// [matterport src="https://my.matterport.com/show/?m=AbCdEfGh" width="100%" height="600px"]
// [matterport src="https://my.matterport.com/show/?m=AbCdEfGh" width="50%"]
// [matterport src="https://my.matterport.com/show/?m=AbCdEfGh"]
// [matterport src="https://my.matterport.com/show/?m=AbCdEfGh" height="600px"]
function matterport_shortcode($atts)
{
	$attributes = shortcode_atts(
		array(
			'src' => 'https://my.matterport.com/show/',
			'width' => '100%',
			'height' => '315px',
		),
		$atts
	);

	return '<iframe width="' . esc_attr($attributes['width']) . '" height="' . esc_attr($attributes['height']) . '" src="' . esc_url($attributes['src']) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen=""></iframe>';
}
add_shortcode('matterport', 'matterport_shortcode');