<?php 

class Topic_model extends CI_Model {
    	
    function __construct()
    {
        parent::__construct();
    }
	
	function get_list() 
	{
		$this->db->from('topic');
		$this->db->order_by("topic_alpha", "desc");
		$query = $this->db->get(); 
		return $query->result_array();
	}
	
	function get_item($topic_id)
	{
		$q = $this->db->query("SELECT topic_id,topic_alpha,total_tokens,topic_words FROM topic WHERE topic_id = ?",array($topic_id));
		return $q->row_array();
	}
	
	function get_max_words()
	{
		$q = $this->db->query("SELECT MAX(word_count) as 'n' FROM topicword_long");
		$r = $q->row_array();
		return $r['n'];
	}
	
	function get_words($topic_id,$limit=25)
	{
		#$q = $this->db->query("SELECT word_id, word_str, t{$topic_id} FROM topicword ORDER BY t{$topic_id} DESC LIMIT $limit");
		$q = $this->db->query("SELECT word_id, word_str, word_count FROM topicword_long WHERE topic_id = ? ORDER BY word_count DESC LIMIT $limit",$topic_id);
		return $q->result_array();
	}
	
	function get_phrases($topic_id)
	{
		$q = $this->db->query("SELECT topic_phrase, phrase_count, phrase_weight FROM topicphrase WHERE topic_id = ?",array($topic_id));
		return $q->result_array();
	}
	
	function get_doc_count_for_topic($topic_id,$threshold = 0.1)
	{
	    $q = $this->db->query("SELECT count(*) as 'n' FROM doctopic_long WHERE topic_id = ? AND topic_weight >= ?", array($topic_id,$threshold));
	    $r = $q->row_array();
	    return $r['n'];
	}
	
	function get_docs($topic_id,$limit=25)
	{
		$docs = array();
		$q1 = $this->db->query("SELECT doc_id, t{$topic_id} as 'tw' FROM doctopic ORDER BY t{$topic_id} DESC LIMIT $limit");
		$rs1 = $q1->result_array();
		foreach($rs1 as $r) {
			$docs[$r['doc_id']]['topic_weight'] = $r['tw'];
		}
		
		$doc_ids = implode(',',array_keys($docs));
		$q2 = $this->db->query("SELECT doc_id, authors, year, title, abstract, doi FROM src_all_doi WHERE doc_id in ($doc_ids)");
		$rs2 = $q2->result_array();
		foreach($rs2 as $r) {
		    $docs[$r['doc_id']]['authors'] = $r['authors'];
		    $docs[$r['doc_id']]['year'] = $r['year'];
			$docs[$r['doc_id']]['title'] = $r['title'];
			$docs[$r['doc_id']]['doi'] = $r['doi'];
			$docs[$r['doc_id']]['abstract'] = $r['abstract'];
		}
		return $docs;
	}
	
	function get_topics($topic_id, $limit=10)
	{
		$topics = array();
		$q1 = $this->db->query("SELECT topic_id1, topic_id2, js_div FROM topicpair WHERE topic_id1 = ? OR topic_id2 = ? ORDER BY js_div	 LIMIT $limit",array($topic_id,$topic_id));
		foreach ($q1->result_array() as $r) {
			$related_topic_id = $r['topic_id1'];
			if ($topic_id == $r['topic_id1']) {
				$related_topic_id = $r['topic_id2'];	
			}
			$topics[$related_topic_id]['js_div'] = $r['js_div'];
		}
		foreach ($topics as $related_topic_id => $inf) {
			$q2 = $this->db->query("SELECT topic_words, topic_alpha FROM topic WHERE topic_id = ?",array($related_topic_id));
			$r = $q2->row_array();
			$topics[$related_topic_id]['topic_words'] = $r['topic_words'];
			$topics[$related_topic_id]['topic_alpha'] = $r['topic_alpha'];
		}
		return $topics;	
	}
	
	function get_topic_cols()
	{
		$tcols = array();
		$query = $this->db->query("SELECT num_topics FROM config LIMIT 1");
		$r = $query->row();
		for ($i = 0; $i < $r->num_rows; $i++) {
			$tcols[] = "t$i";
		}
		return $tcols;
	}
	
	function get_topic_entropy()
	{
		$q = $this->db->query("SELECT count(*) as 'n', round(topic_entropy,-2) as 'h' from doctopic group by round(topic_entropy,1) order by topic_entropy");
		return $q->result_array();		
	}	
 
 	function get_alpha_stats()
	{
		$q = $this->db->query("SELECT max(topic_alpha) as 'max', min(topic_alpha) as 'min', avg(topic_alpha) as 'avg' FROM topic");
		return $q->row_array();
	}
	
    
}