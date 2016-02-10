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
	 	
 
}