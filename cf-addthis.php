<?php

/*
Plugin Name: CF AddThis
Description: Easy to customize AddThis sharing links
Version: 1.0
Author: Crowd Favorite
Author URI: http://crowdfavorite.com
*/


/**
 * Get AddThis API url
 * Generated for the v0.8 API
 * @param $url string - optional. URL to share
 * @param $title string - optional. Title of bookmark
 * @param $service string - optional. One of the service keywords (see below)
 *
 * @see for valid service keywords http://www.addthis.com/services/list
 * @see v0.8 API docs http://www.addthis.com/help/api-overview
 */
function cfat_get_url($url, $title = '', $service = '') {
	// Build Param Query array
	$q = array(
		'url' => $url
	);
	if ($title) {
		$q['title'] = $title;
	}
	// Turn it into HTTP query get string
	$query = http_build_query($q, '&amp;');
	
	$api_url = apply_filters('cfat_api_url', 'http://api.addthis.com/oexchange/0.8/');
	$endpoint_generic = apply_filters('cfat_api_endpoint_generic', $api_url.'offer%s', $api_url);
	$endpoint_service = apply_filters('cfat_api_endpoint_service', $api_url.'/forward/%s/offer%s', $api_url);
	
	// Decide which endpoint to hit
	switch ($service) {
		// Generic
		case '':
			$add_url = sprintf($endpoint_generic, '?'.$query);
			break;
		// Specific service keyword
		default:
			$add_url = sprintf($endpoint_service, $service, '?'.$query);
			break;
	}
	
	return $add_url;
}

/**
 * Get an addthis API <a> tags
 *
 * Add classes, IDs, etc through attributes array
 */
function cfat_get_share($args = '') {
	$default_args = array(
		// URL to share
		'url' => get_permalink(),
		// Link text
		'text' => 'Share',
		'service' => '',
		// Optional. Will use <title> tag otherwise.
		'title' => '',
		'attributes' => array(
			'onclick' => 'window.open(this.href, \'addthis\', \'height=500,width=490,menubar=no,toolbar=no,location=no\'); return false;'
		)
	);

	$args = wp_parse_args($args, $default_args);
	extract($args);
	
	$add_url = cfat_get_url($url, $title, $service);
	
	$attr = '';
	if (is_array($attributes) && !empty($attributes)) {
		// Build attributes for link
		foreach ($attributes as $key => $value) {
			$attr[] = $key . '="'.$value.'"';
		}
		$attr = implode(' ', $attr);
	}
	
	$return = '<a href="'.$add_url.'" '.$attr.'>'.$text.'</a>';
	
	return $return;
}
function cfat_share($args = '') {
	echo cfat_get_share($args);
}

?>