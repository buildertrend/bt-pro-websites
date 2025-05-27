<?php
// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}


add_action('template_redirect', function () {
	if (is_sitemap()) {
		header('X-Debug-Sitemap: logging');
		$headers = headers_list();
		error_log('--- Yoast Sitemap Header Check ---');
		foreach ($headers as $header) {
			error_log($header);
		}
	}
});

add_action('send_headers', function () {
	if (is_sitemap()) {
		header_remove('X-Robots-Tag');
		header('X-Robots-Tag: index, follow'); // Optional: explicitly allow indexing
	}
});

if (!function_exists('is_sitemap')) {
	function is_sitemap()
	{
		return defined('DOING_SITEMAP') && DOING_SITEMAP;
	}
}