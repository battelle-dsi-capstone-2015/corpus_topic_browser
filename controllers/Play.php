<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Play extends CI_Controller {
				
  public function index() 
  { 
    $data['topics'] = $this->topic->get_list();
    $data['page_title'] = 'Play';
    $this->load->view('templates/header.php', $data);
    $this->load->view('play', $data);	
    $this->load->view('templates/footer.php', $data);  
  }
  
  public function graph()
  {
    $this->load->library('SVGGraphWrapper',array(),'graph');
    $v1 = array('a' => 1,'b' => 2,'c' => 3,'d' => 4,'e' => 5);
    $g1 = $this->graph->make(400,400);
    $g1->Values($v1);
    $img1 = $g1->Fetch('LineGraph');

    $g2 = $this->graph->make();
    $v2 = array(1 => 5, 2 => 3, 3 => 15);
    $g2->Values($v2);
    $img2 = $g2->Fetch('ScatterGraph');

    print($img1);
    print($img2);
  }
  
  public function entropy($bins = 20)
  {
  	
    $q = $this->db->query("SELECT max(topic_entropy) as 'max', min(topic_entropy) as 'min', avg(topic_entropy) as 'avg' FROM doctopic");
    $h = $q->row_array(); 
    $span = $h['max'] - $h['min']; 
    $bin_width = $span / $bins;
    $left = $h['min'];
    $bars = array();
	$nvals = array();
    for ($i = $h['min']; $i <= $h['max']; $i += $bin_width) {
        if ($i == $left) { continue; }
        $sql = "SELECT count(*) AS 'n' FROM doctopic WHERE (topic_entropy >= $left AND topic_entropy < $i)";
        $q2 = $this->db->query($sql);
        $r = $q2->row_array();
        $bars[] = array(
            'n' => $r['n'],
            'h' => $left,
            'm' => $i
        );
		$nvals[] = $r['n'];
        $left = $i;
    }  
    
	$data['span'] = $span;
	$data['bars'] = $bars;
    $data['nmax'] = max($nvals);
	#$data['hmax'] = $h['max'];
	$this->load->view('templates/header.php', $data);
    $this->load->view('play_entropy', $data);	
    $this->load->view('templates/footer.php', $data);  
        
  }  
}