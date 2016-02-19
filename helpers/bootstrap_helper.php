<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * My Bootstrap Helpers
 *
 * @package		Battelle
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Rafael Alvarado
 * @link		
 */

// ------------------------------------------------------------------------

if ( ! function_exists('progress_bar'))
{
	/**
	 * Heading
	 *
	 * Generates a Bootstrap Progress Bar component.
	 *
	 * @param	string	Type of bar (success,info,warning,danger,default)
	 * @param	mixed	Value Now
	 * @param	mixed	Value Min
	 * @param 	mixed	Value Max
	 * @param	string	label
	 * @return	string	a Boostrap Progress Bar snippet
	 */
	function progress_bar($type = 'success', $vnow = 0, $vmin = 0, $vmax = 0, $label = '', $striped = FALSE, $active = FALSE)
	{
	    # Do some validation
	    if (!is_numeric($vnow) || !is_numeric($vmin) || !is_numeric($vmax)) {
	        return "<span class='label label-danger'>One or more non-numeric values</span>";
	    }  
	    if ($vmin >= $vmax || $vmin > $vnow || $vnow > $vmax) {
	        return "<span class='label label-danger'>One or more illogical values</span>";
	    }
	    
	    # Do this to prevent weird handling of small numbers by the widget
	    if ($vmax < 100 && $vmax >= 10) {
	        $vmax = $vmax * 10;
	        $vnow = $vnow * 10;
	    }
	    	    
	    # We do this internally now; no need to pass
	    $width = round(($vnow - $vmin)/($vmax - $vmin),2) * 100;

        # Handle various class attributes
		$active ? $active_class = ' active' : $active_class = '';
		$striped ? $striped_class = ' progress-bar-striped' : $striped_class = '';
		$type == 'default' ? $type_class = '' : $type_class = " progress-bar-$type";

        # Generate the widget
		$widget = '<div class="progress">'
		. "<div class=\"progress-bar{$type_class}{$striped_class}{$active_class}\" role=\"progressbar\" "
		. "aria-valuenow=\"{$vnow}\" aria-valuemin=\"{$vmin}\" aria-valuemax=\"{$vmax}\" style=\"width:{$width}%\">"
    	. $label
  		. '</div>'
		. '</div>';
		return $widget;
	}
}

// ------------------------------------------------------------------------

 