<?php
/**
 * Plugin Name: ESO Finder Tooltips
 * Plugin URI: https://github.com/wildera/esofinder-tooltips
 * Description: Add tooltips on items from Elder Scrolls Online inside your posts/pages.
 * Version: 1.0
 * Author: WILDERA
 * Author URI: https://github.com/wildera
**/

defined('ABSPATH') or die('No! Bad dog!');

add_action('plugins_loaded', 'esoFinderInit');
add_action('wp_enqueue_scripts', 'esoFinderStyle');
add_action('wp_footer', 'esoFinderScript');

/**
 * Activate ESOF shortcode
**/
function esoFinderInit() {
	add_shortcode('esof', 'esoFinderLink');
}

/**
 * Add ESOF CSS to style tooltips
**/
function esoFinderStyle() {
	$plugin_dir_url = plugin_dir_url(__FILE__);
	wp_enqueue_style('ESOF', $plugin_dir_url . '/esofinder.css');
}

/**
 * Add ESOF JS to activate tooltips
**/
function esoFinderScript() {
	$plugin_dir_url = plugin_dir_url(__FILE__);
	wp_enqueue_script('ESOF', $plugin_dir_url . '/esofinder.js');
}

/**
 * Replace ESOF shortcode by the html link + tooltip
**/
function esoFinderLink($params) {
	// check transient/cache first
	$transient = get_transient('esof_' . serialize($params));
	if ($transient) {
		return $transient;
	}
	
	if (!isset($params['link'])) {
		return '[ESOF: No link provided]';
	}
	
	// get link parameters
	$link = explode('=', $params['link']);
	if (sizeof($link) < 2) {
		return '[ESOF: Wrong link provided]';	
	}
	$type = $link[0];
	$id = $link[1];
	
	// deduce locale by order: lang > wordpress > default
	$locale = get_locale();
	$esoLocale = 'en';
	if (isset($params['lang'])) {
		$esoLocale = $params['lang'];
	} elseif (isset($locale)) {
		$esoLocale = explode('_', $locale)[0];
	}
	
	// request to hermaeus
	$response = wp_remote_get('https://oghma.hermaeusmora.com/api/' . $esoLocale . '/tooltips/' . $type . 's/' . $id);
	$json = json_decode(wp_remote_retrieve_body($response), true);
	
	if (!isset($json['name']) || !isset($json['tooltip'])) {
		return '[ESOF: Item not found]';
	}
	
	// build the html link with tooltip
	$a = '<a class="esof" href="https://esofinder.com/' . $esoLocale . '/' . $type . 's/' . $id . '" target="_blank" rel="noopener" ';
	$a .= 'data-toggle="tooltip" data-html="true" title="' . htmlspecialchars($json['tooltip']) . '">';
	
	// use icon if option and value are present otherwise use name
	if (isset($params['icon']) && $params['icon'] == 'true' && isset($json['icon'])) {
		$a .= '<img class="h-icon-link" src="https://static.hermaeusmora.com/' . str_replace('.dds', '.png', $json['icon']) . '">';
	} else {
		$a .= $json['name'];
	}
	$a .= '</a>';
	
	// transient/cache for 4 hours
	set_transient('esof_' . serialize($params), $a, 14400);
	
	return $a;
}
