<?php defined('BASEPATH') OR exit('No direct script access allowed');


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

if ( ! function_exists('bar_graph1'))
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
	function bar_graph1($graph, $values = array(), $h = 200, $w = 300, $label_x = '', $label_y = '', $xmin = NULL, $xmax = NULL)
	{
		$settings = array(
			'back_colour' => '#fff',  
			'stroke_colour' => '#000',
			'back_stroke_width' => 0, 
			'back_stroke_colour' => '#eee',
			'axis_colour' => 'black',  
			'axis_overlap' => 2,
			'axis_font' => 'Garamond', 
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
			'label_x' => $label_x,		
			'label_y' => $label_y,
	  		'thousands' => '',
	  		'pad_top' => 0,
	  		'pad_bottom' => 0,
	  		'pad_left' => 0,
	  		'pad_right' => 0,
		);
		$g = $graph->make($w,$h,$settings);
		$g->Values($values);
		$g->Colours(array('blue'));
		$img = $g->Fetch('BarGraph');	
    	return $img;
	}
}

if ( ! function_exists('sparkline'))
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
	function sparkline($graph, $values = array(), $xmin = NULL, $xmax = NULL, $h = 25, $w = 100)
	{
		$settings = array(
			'bar_space' => 3,	
			'back_colour' => '#fff',
			'stroke_colour' => 'blue',
			'back_stroke_width' => 0, 
			'back_stroke_colour' => '#eee',
			'axis_colour' => 'black',  
			'axis_overlap' => 2,
			'axis_font' => 'Garamond', 
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
		$g = $graph->make($w,$h,$settings);
		$g->Values($values);
		$g->Colours(array('blue'));
		$img = $g->Fetch('BarGraph');	
    	return $img;
	}
}

function draw_graph($graph, $type, $settings = array(), $values = array(), $colors = array(), $h = 300, $w = 200)
{
	$g = $graph->make($w,$h,$settings);
	$g->Values($values);
	$g->Colours($colors);
	$img = $g->Fetch($type);	
	return $img;
}

// ------------------------------------------------------------------------

 