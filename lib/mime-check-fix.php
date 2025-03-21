<?php

add_filter('upload_mimes', 'bodhi_svgs_upload_mimes');
add_filter('wp_prepare_attachment_for_js', 'bodhi_svgs_response_for_svg', 10, 3);

/* Add Mime TypesTypes */
function bodhi_svgs_upload_mimes($mimes = array())
{
	global $bodhi_svgs_options;
	if (empty($bodhi_svgs_options['restrict']) || current_user_can('administrator')) {
		// allow SVG file upload
		$mimes['svg'] = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
		return $mimes;
	} else {
		return $mimes;
	}
}

function bodhi_svgs_response_for_svg($response, $attachment, $meta)
{
	if ($response['mime'] == 'image/svg+xml' && empty($response['sizes'])) {
		$svg_path = get_attached_file($attachment->ID);
		if (!file_exists($svg_path)) {
			// If SVG is external, use the URL instead of the path
			$svg_path = $response['url'];
		}
		$dimensions = bodhi_svgs_get_dimensions($svg_path);
		$response['sizes'] = array(
			'full' => array(
				'url' => $response['url'],
				'width' => $dimensions->width,
				'height' => $dimensions->height,
				'orientation' => $dimensions->width > $dimensions->height ? 'landscape' : 'portrait'
			)
		);
	}
	return $response;
}

function bodhi_svgs_get_dimensions($svg)
{
	$svg = simplexml_load_file($svg);
	if ($svg === FALSE) {
		$width = '0';
		$height = '0';
	} else {
		$attributes = $svg->attributes();
		$width = (string) $attributes->width;
		$height = (string) $attributes->height;
	}
	return (object) array('width' => $width, 'height' => $height);
}

/**
 * Mime Check fix for WP 4.7.1 / 4.7.2
 *
 * Fixes uploads for these 2 version of WordPress.
 * Issue was fixed in 4.7.3 core.
 */
global $wp_version;
if ($wp_version == '4.7.1' || $wp_version == '4.7.2') {
	add_filter('wp_check_filetype_and_ext', 'bodhi_svgs_disable_real_mime_check', 10, 4);
	function bodhi_svgs_disable_real_mime_check($data, $file, $filename, $mimes)
	{
		$wp_filetype = wp_check_filetype($filename, $mimes);
		$ext = $wp_filetype['ext'];
		$type = $wp_filetype['type'];
		$proper_filename = $data['proper_filename'];
		return compact('ext', 'type', 'proper_filename');
	}
}
