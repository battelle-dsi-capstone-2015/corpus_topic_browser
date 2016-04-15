<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(BASEPATH.'../application/libraries/SVGGraph/SVGGraph.php');

/**
 * My SVGGraph Helpers
 *
 * @package		Battelle
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Rafael Alvarado
 * @link		
 */

// ------------------------------------------------------------------------

if (!function_exists('bar_graph1'))
{
	/**
	 * Heading
	 *
	 * Generates an SVGGraph Bar Graph.
	 *
	 * @param	object	SVGGraphWrapper object
	 * @param	array 	data to populate graph
	 * @return	string	an SVG snippet containing a bar graph
	 */
	function bar_graph1($values = array(), $h = 200, $w = 300, $label_x = '', $label_y = '', $xmin = NULL, $xmax = NULL)
	{
		$settings = array(
			'back_colour' => 'white',  
			'stroke_colour' => 'lightblue',
			'back_stroke_width' => 0, 
			'back_stroke_colour' => 'gray',
			'axis_colour' => 'black',  
			'axis_overlap' => 2,
			'axis_font' => 'arial', 
			'axis_font_size' => 12,
			'grid_colour' => 'white',  
			'label_colour' => 'black',
			'pad_right' => 0,        
			'pad_left' => 0,
			'link_base' => '/',       
			'link_target' => '_top',
			'minimum_grid_spacing' => 20,
			'axis_min_h' => $xmin,		
			'axis_max_h' => $xmax,
			'axis_min_v' => 0,		
			'label_x' => $label_x,		
			'label_y' => $label_y,
	  		'thousands' => '',
	  		'pad_top' => 0,
	  		'pad_bottom' => 0,
	  		'pad_left' => 0,
	  		'pad_right' => 0,
	  		'axis_text_angle_h' => -45,
  			'label_font_size' => 14,	
		);
		$g = new SVGGraph($w,$h,$settings);	
		$g->Values($values);
		$g->Colours(array('blue'));
		$img = $g->Fetch('BarGraph');	
    	return $img;
	}
}

if (!function_exists('sparkline'))
{
	/**
	 * Heading
	 *
	 * Generates an SVGGraph Bar Graph.
	 *
	 * @param	object	SVGGraphWrapper object
	 * @param	array 	data to populate graph
	 * @return	string	an SVG snippet containing a bar graph
	 */
	function sparkline($values = array(), $xmin = NULL, $xmax = NULL, $h = 25, $w = 100)
	{
		$settings = array(
			'bar_space' => 3,	
			'back_colour' => '#fff',
			'stroke_colour' => 'lightblue',
			'back_stroke_width' => 0, 
			'back_stroke_colour' => '#eee',
			'axis_colour' => 'black',  
			'axis_overlap' => 2,
			'axis_font' => 'arial', 
			'axis_font_size' => 10,
			'grid_colour' => 'white',  
			'label_colour' => '#000',
			'pad_right' => 0,        
			'pad_left' => 0,
			'link_base' => '/',       
			'link_target' => '_top',
			'minimum_grid_spacing' => 20,
			'axis_min_h' => $xmin,		
			'axis_max_h' => $xmax,
			'axis_min_v' => 0,		
			#'_axis_max_v' => $max_w,
			'label_x' => '',		
			'label_y' => '',
	  		'thousands' => '',
	  		'pad_top' => 0,
	  		'pad_bottom' => 0,
	  		'pad_left' => 0,
	  		'pad_right' => 0,
	  		'show_data_labels' => false,
	  		'show_axes' => false,
	  		#'show_axis_text_h' => false,
	  		#'show_axis_text_v' => false,
			'show_grid' => false,
			
		);
		$g = new SVGGraph($w,$h,$settings);	
		$g->Values($values);
		$g->Colours(array('blue'));
		$img = $g->Fetch('BarGraph');	
    	return $img;
	}
}

if (!function_exists('draw_graph'))
{
	function draw_graph($type, $settings = array(), $values = array(), $colors = array(), $links = array(), $h = 300, $w = 200)
	{
		$g = new SVGGraph($w,$h,$settings);
		$g->Values($values);
		$g->Colours($colors);
		$g->Links($links);
		$img = $g->Fetch($type);	
		return $img;
	}	
}


// ------------------------------------------------------------------------

 