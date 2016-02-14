<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Word extends CI_Controller {
        
    public function index() 
    { 
         echo "This is default function."; 
    }
        
    public function all() 
    {
        $data['words'] = $this->word->get_list();
        $data['page_title'] = 'All Words';
        $this->load->view('templates/header.php', $data);
        $this->load->view('word_list', $data);  
        $this->load->view('templates/footer.php', $data);
    }
    
    public function item($word_str = NULL)
    {
        $data['word_str'] = $word_str;
        $data['word'] = $this->word->get_item($word_str);
        $data['topics'] = $this->word->get_topics($word_str);
        #$data['words'] = $this->word->get_words($word_str);
        $data['docs'] = $this->word->get_docs($word_str);
        $data['max_words'] = $this->word->get_max_words();
        $data['max_docwords'] = $this->word->get_max_docwords();
        $this->load->view('templates/header.php', $data);
        $this->load->view('word_item', $data);  
        $this->load->view('templates/footer.php', $data);
    }
  
}