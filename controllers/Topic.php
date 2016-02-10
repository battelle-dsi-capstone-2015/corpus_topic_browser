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
		$data['words'] = $this->topic->get_words($topic_id);
		$data['phrases'] = $this->topic->get_phrases($topic_id);
		$data['docs'] = $this->topic->get_docs($topic_id);
		$data['topics'] = $this->topic->get_topics($topic_id);
		$this->load->view('templates/header.php', $data);
		$this->load->view('topic_item', $data);	
	    $this->load->view('templates/footer.php', $data);
    }
	 	
	
	public function one($topic_id = NULL)
	{
	    $this->item();
	}
  
}