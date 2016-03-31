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
  
  public function vis($d = 4)
  {
  	
	$labels = array();
  	$q1 = $this->db->query("SELECT topic_id as id, topic_words || '\na=' || (ROUND(topic_alpha,2)) as label, topic_alpha as 'value' FROM topic");
	$rs1 = $q1->result_array();
	for($i = 0; $i < count($rs1); $i++) {
		$label = $rs1[$i]['label'];
		$new_label = preg_replace("/(\w+ \w+)/","$1\n",$label);
		$labels[$rs1[$i]['id']]['label'] = $new_label;
		$labels[$rs1[$i]['id']]['value'] = $rs1[$i]['value'];
	}
	
	$dd = $d / 10;
  	$q2 = $this->db->query("SELECT topic_id1 as 'from', topic_id2 as 'to' FROM topicpair WHERE js_div < ? ORDER BY js_div LIMIT 200",array($dd));
	$edges = $q2->result_array();
	$data['edges'] = json_encode($edges);
	
	$nodes = array();
	foreach($edges as $edge) {
		$nodes[$edge['from']] = 1;		
		$nodes[$edge['to']] = 1;	
	}
	$nodes2 = array();
	foreach($nodes as $k => $v) {
		$topic_url = base_url("topic/item/$k");
		$label = $labels[$k]['label'];
		$value = $labels[$k]['value'];
		$nodes2[] = array('id' => $k, 'label' => $label, 'title' => "<a href='$topic_url' target='_blank'>$k</a>", 'value' => $value);
	}
	$data['nodes'] = json_encode($nodes2);	
    
    $this->load->view('templates/header.php', $data);
    $this->load->view('play_vis', $data);	
    $this->load->view('templates/footer.php', $data);  
  }
  
  public function vis_words($limit = 100)
  {
	#AND a.word_id < b.word_id
	$cutoff = 1000;
  	$q = $this->db->query("SELECT DISTINCT a.word_str as 'from', b.word_str as 'to'
		FROM topicword_long a JOIN topicword_long b USING(topic_id)
		WHERE a.word_count > $cutoff AND b.word_count > $cutoff
		AND a.word_id != b.word_id 
		ORDER BY a.word_id, b.word_id
		LIMIT $limit");
	$edges = $q->result_array();
	$data['edges'] = json_encode($edges);

	$nodes = array();
	foreach($edges as $edge) {
		$nodes[$edge['from']] = 1;		
		$nodes[$edge['to']] = 1;	
	}
	$nodes2 = array();
	foreach($nodes as $k => $v) {
		$nodes2[] = array('id' => $k, 'label' => $k);
	}
	$data['nodes'] = json_encode($nodes2);
	
	$data['page_title'] = 'Word Net';
  	$this->load->view('templates/header.php', $data);
    $this->load->view('play_vis', $data);	
    $this->load->view('templates/footer.php', $data);  
  }

  public function graph($topic_id = NULL)
  {
    	
    $this->load->library('SVGGraphWrapper',array(),'graph');
    
    $q1 = $this->db->query("SELECT MAX(topic_weight) AS max_w FROM doctopic_long");
	$r1 = $q1->row_array();
	$max_w = $r1['max_w'];
	
	$sql = "SELECT doc_label AS year, AVG(topic_weight) AS w 
		FROM doctopic_long dt JOIN doc d USING(doc_id)
		WHERE topic_id = ?
		GROUP BY doc_label
		ORDER BY doc_label";
	$q = $this->db->query($sql,array($topic_id));
	$vals = array();
	$rs = $q->result_array();
	foreach($rs as $r) {
		$vals['Y'.$r['year']] = $r['w'];
	}
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
	  'axis_min_h' => 2005,		
	  'axis_max_h' => 2015,
	  'axis_min_v' => 0,		
	  '_axis_max_v' => $max_w,
	  'label_x' => 'YEAR',		
	  'label_y' => 'Average Topic Weight',
	  'thousands' => '',
	);
    $g3 = $this->graph->make(600,400,$settings);
	$g3->Values($vals);
	$g3->Colours(array('blue'));
	$img3 = $g3->Fetch('BarGraph');
    print($img3);
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