<?php
/**
 * Textpattern plugin: ckr_image_count
 *
 * Counts images and provides a conditional tag to check if there are X images within category Y
 * 
 * @package		textpatter-plugins
 * @copyright	(c) 2009, all rights reserved
 * @author		Cedric Kastner <cedric.kastner@gpdevelopment.de>
 * @version		1.0
 */

function ckr_image_count($atts)
{
	// Extract attribute from tag
	extract(lAtts(array('category' => false), $atts));
	
	// Category name given, output the count of images within
	if ($category) return safe_count('txp_image', 'category = \''.$category.'\'');
	
	// No category name given, output the count of all images
	return safe_count('txp_image', '1');
	
}

function ckr_if_image_count($atts, $thing)
{
	// Extract attributes from tag
	extract(lAtts(array('category'	=> false,
						'min'		=> false,
						'max'		=> false,
						'equal'		=> false,
						'not'		=> false
					   ), $atts));
						
	// Count the images in specified category if given or globally
	$count = ($category) ? intval(ckr_image_count(array('category' => $category))) : intval(ckr_image_count());
	
	// Instead of almost unreadable if-else syntax...
	// we use this clever true-switch/case-if counstruct :)
	switch (true)
	{
		case ($min && !$max && !$equal && !$not): // Is greater than min value
			return parse(EvalElse($thing, ($count >= intval($min)) ? true : false));
			break;
		
		case ($max && !$min && !$equal && !$not): // Is lesser than max value
			return parse(EvalElse($thing, ($count <= intval($max)) ? true : false));
			break;
		
		case ($equal && !$min && !$max && !$not): // Is equal
			return parse(EvalElse($thing, ($count == intval($equal)) ? true : false));
			break;
			
		case ($not && !$min && !$max && !$equal): // Is not equal
			return parse(EvalElse($thing, ($count != intval($not)) ? true : false));
			break;
			
		case ($min && $max && !$equal && !$not): // Between min and max
			return parse(EvalElse($thing, ($count >= intval($min) && $count <= intval($max)) ? true : false));
			break;
		
		default: // Anything else will output an error message
			return '<!-- ckr_if_image_count: Wrong attribute count or combination. -->';
		
	}
	
}
