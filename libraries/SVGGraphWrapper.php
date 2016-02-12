<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require_once('SVGGraph/SVGGraph.php');

class SVGGraphWrapper {

  function make($width = 400, $height = 300, $settings = array()) 
  {
    $g = new SVGGraph($width,$height,$settings);
    return $g;
  }

}