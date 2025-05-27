<?php
// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

// Usage example: [format-number value="1234567"]
// Usage example: [format-number field="custom_field_name" post_id="123"]
// Usage example: [format-number field="custom_field_name"]
// Usage example: [format-number]1234567[/format-number]
// Usage example: [format-number]{{ custom_field_name }}[/format-number]
function format_number($atts, $content = null)
{
    $atts = shortcode_atts(array(
        'value' => '',
        'field' => '',     // Custom field name
        'post_id' => '',   // Optional post ID (defaults to current post)
    ), $atts);
    
    // If content is provided, use that
    if ($content) {
        $num = do_shortcode($content);
    } 
    // If a custom field is specified, retrieve its value
    elseif (!empty($atts['field'])) {
        $post_id = !empty($atts['post_id']) ? $atts['post_id'] : get_the_ID();
        // Get value from custom field (works with ACF and native custom fields)
        $num = get_post_meta($post_id, $atts['field'], true);
        
        // Alternative for ACF if you prefer that function
        // if (function_exists('get_field')) {
        //     $num = get_field($atts['field'], $post_id);
        // }
    }
    // Otherwise use the direct value
    else {
        $num = $atts["value"];
    }

    return $num ? number_format((float)$num, 0, '.', ',') : '';
}
add_shortcode("format-number", "format_number");