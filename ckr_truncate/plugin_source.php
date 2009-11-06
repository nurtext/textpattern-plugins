<?php
/**
 * Textpattern plugin: ckr_truncate
 *
 * Truncates a given string to a predefined length
 * 
 * @package		textpattern-plugins
 * @copyright	(c) 2009, all rights reserved
 * @author		Cedric Kastner <cedric@nur-text.de>
 * @version		1.0
 */

function ckr_truncate($atts, $thing)
{
	// Extract attributes from tag
	extract(lAtts(array('length' => '90',
				 'etc' => '&hellip;'), $atts));
	
	// No length given, do nothing and return original string
	if ((int)$length === 0) return parse($thing);
	
	// String is longer then max length, so we start truncating 
	if (strlen(parse($thing)) > (int)$length)
	{
		// Calculate remaining length
		$length -= min((int)$length, strlen(html_entity_decode($etc)));
	
		// Returns the truncated string plus etc string (default "…")
		return substr(parse($thing), 0, (int)$length) . $etc;
		
	}
	
	// The if-condition wasn't evaluated, so just return the original string
	return parse($thing);
	
}