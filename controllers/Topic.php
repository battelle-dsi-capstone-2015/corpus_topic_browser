<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topic extends CI_Controller {
        
    const CACHE = 60;
    
    public function index() 
    { 
         echo "This is default function."; 
    }

    public function all() 
    {
        $this->output->cache(self::CACHE);
        
        $data['topics'] = $this->topic->get_list();
        $data['page_title'] = 'All Topics';
        $data['topic_entropy'] = $this->topic->get_topic_entropy();
        $data['alpha_stats'] = $this->topic->get_alpha_stats();
        
        // Put all this in the model
        $bins = 30; // ... and pass this as a param
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
            
        $this->load->view('templates/header.php', $data);
        $this->load->view('topic_list', $data); 
        $this->load->view('templates/footer.php', $data);    
    }
    
    public function item($topic_id = NULL) 
    {
        $this->output->cache(self::CACHE);
        $data['page_title'] = "Topic $topic_id";
        $data['topic_id'] = $topic_id;
        $data['topic_info'] = $this->topic->get_item($topic_id);
        $data['words'] = $this->topic->get_words($topic_id) ;
        $data['max_words'] = $this->topic->get_max_words();
        $data['phrases'] = $this->topic->get_phrases($topic_id);
        $data['doc_count'] = $this->topic->get_doc_count_for_topic($topic_id);
        $data['docs'] = $this->topic->get_docs($topic_id);
        $data['topics'] = $this->topic->get_topics($topic_id);
        $this->load->view('templates/header.php', $data);
        $this->load->view('topic_item', $data); 
        $this->load->view('templates/footer.php', $data);
    }
          
}