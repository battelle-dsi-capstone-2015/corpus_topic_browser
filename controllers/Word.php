<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Word extends CI_Controller {
        
    public function index() 
    { 
         echo "This is default function."; 
    }
        
    public function all() 
    {
        $limit = 100;
		$data['limit'] = $limit;
		$data['words'] = $this->word->get_list($limit);
        #$data['words_with_topics'] = $this->word->get_list_with_topics($limit);
		$data['words_in_topics'] = $this->word->get_top_words_in_topics($limit);
		$data['trending_words'] = $this->word->get_trending_words($limit);
		$data['trend_distro'] = $this->word->get_trend_distro();
        $data['page_title'] = "Words";
        $data['max_words'] = $this->word->get_max_words();
        $this->load->view('templates/header.php', $data);
        $this->load->view('word_list', $data);  
        $this->load->view('templates/footer.php', $data);
    }
    
    public function item($word_str = NULL)
    {
        $data['word_str'] = $word_str;
        $data['word'] = $this->word->get_item($word_str);
		$data['score'] = $this->word->get_score($word_str);
        $data['topics'] = $this->word->get_topics($word_str);
        #$data['words'] = $this->word->get_words($word_str);
        $data['docs'] = $this->word->get_docs($word_str);
        $data['max_words'] = $this->word->get_max_words();
        $data['max_docwords'] = $this->word->get_max_docwords();
		$data['trend'] = $this->word->get_trend($word_str);
        $this->load->view('templates/header.php', $data);
        $this->load->view('word_item', $data);  
        $this->load->view('templates/footer.php', $data);
    }
	
	public function get_string($term)
	{
	    $rows = $this->word->get_string(urldecode($term));
    	print json_encode($rows);
	}
	
  
}