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
	 * Generates an HTML heading tag.
	 *
	 * @param	string	Type of bar (success,info,warning,danger,default)
	 * @param	mixed	Value Now
	 * @param	mixed	Value Min
	 * @param 	mixed	Value Max
	 * @param	int		Width (percent)
	 * @param	string	label
	 * @return	string	an HTML widget
	 */
	function progress_bar($type = 'success', $vnow = 0, $vmin = 0, $vmax = 0, $width = 0, $label = '', $striped = FALSE, $active = FALSE)
	{
		$active ? $active_class = ' active' : $active_class = '';
		$striped ? $striped_class = ' progress-bar-striped' : $striped_class = '';
		$type == 'default' ? $type_class = '' : $type_class = " progress-bar-$type";
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

 