<?php 

class Word_model extends CI_Model {
  
    function __construct()
    {
        parent::__construct();
    }
	
	function get_list($limit=1000) 
	{
		$q = $this->db->query("SELECT * FROM word LIMIT $limit");
		return $q->result_array();
	}
	
	function get_item($word_str)
	{
		$q = $this->db->query("SELECT word_id, word_freq FROM word WHERE word_str = ?",array($word_str));
		return $q->row_array();
	}
	
	function get_max_words()
	{
	    $q = $this->db->query("SELECT max(word_count) as 'max_words' FROM topicword_long");
	    $r = $q->row_array();
	    return $r['max_words'];
	}
	
	function get_topics($word_str)
	{
	    $topics = array();
		$q1 = $this->db->query("SELECT topic_id, word_id, word_count FROM topicword_long WHERE word_str = ? ORDER BY word_count DESC",array($word_str));
    	$rs1 = $q1->result_array();
    	foreach ($rs1 as $r1) {
    	    $q2 = $this->db->query("SELECT topic_words FROM topic WHERE topic_id = ?",array($r1['topic_id']));
    	    $r2 = $q2->row_array();
    	    $topics[] = array(
                'topic_id' => $r1['topic_id'],
                'word_count' => $r1['word_count'],
    	        'topic_words' => $r2['topic_words'],
    	    );
    	}
    	return $topics;
	}
	
	function get_max_docwords()
	{
		$q = $this->db->query("SELECT MAX(word_count) as 'n' FROM docword");
		$r = $q->row_array();
		return $r['n'];
	}

	function get_docs($word_str, $limit = 50)
	{
		$docs = array();
		$q = $this->db->query("
			SELECT s.doc_id, s.title, s.authors, s.year, dw.word_count
			FROM src_all_doi s JOIN docword dw USING(doc_id) 
			WHERE dw.word_str = ?
			ORDER BY dw.word_count DESC 
		 	LIMIT $limit", 
			$word_str);
		foreach ($q->result_array() as $r) {
			$docs[] = array(
				'doc_id' 	 => $r['doc_id'],
				'title' 	 => $r['title'],
				'authors' 	 => $r['authors'],
				'year' 		 => $r['year'],
				'word_count' => $r['word_count'],
			);
		} 
		return $docs;
	}

    
}