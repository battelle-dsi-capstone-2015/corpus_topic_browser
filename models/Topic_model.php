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
		$query = $this->db->query("SELECT value as 'num_topics' FROM config WHERE key = 'num_topics'");
		$r = $query->row();
		for ($i = 0; $i < $r->num_topics; $i++) {
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
	
	function get_common_docs($topic_id_x,$topic_id_y,$min = 0.1)
	{
	  $sql = "SELECT d.title as title, a.doc_id as doc_id, (a.topic_weight * b.topic_weight) AS combo_weight
  		FROM doctopic_long a
       		JOIN doctopic_long b USING (doc_id)
       		JOIN src_all_doi d ON (d.doc_id = a.doc_id)
 		WHERE (a.topic_id = ? AND b.topic_id = ?) AND (a.topic_weight >= $min AND b.topic_weight >= $min) 
 		ORDER BY combo_weight DESC
 		LIMIT 25";
	  $q = $this->db->query($sql,array($topic_id_x,$topic_id_y));
	  return $q->result_array();
	}

	function get_common_words($topic_id_x,$topic_id_y) 
	{
	  $sql = "SELECT a.word_str as word_str, 
		a.word_count as word_count_x, b.word_count as word_count_y, 
		(a.word_count + b.word_count - abs(a.word_count - b.word_count)) as intersection
		FROM topicword_long a JOIN topicword_long b USING (word_id)
		WHERE a.topic_id = ? and b.topic_id = ?
		ORDER BY intersection DESC";
	  $q = $this->db->query($sql,array($topic_id_x,$topic_id_y));
	  return $q->result_array();
	}
	
	function get_js_div_ends()
	{
		$q = $this->db->query("SELECT MAX(js_div) as 'max', MIN(js_div) as 'min' FROM topicpair");
		return $q->row_array();
	}
    
	function get_js_div($topic_id_x, $topic_id_y)
	{
		$topic_id_x < $topic_id_y ? $vars = array($topic_id_x,$topic_id_y) : $vars = array($topic_id_y,$topic_id_x);
		$q = $this->db->query("SELECT js_div FROM topicpair WHERE topic_id1 = ? AND topic_id2 = ?", $vars);
		$r = $q->row_array();
		return $r['js_div'];
	}
	
	function get_topic_trend($topic_id)
	{
		$trend = array();
		$q = $this->db->query("SELECT doc_label as 'year', AVG(t{$topic_id}) as 'weight' FROM doctopic GROUP BY year ORDER BY year");
		$rs = $q->result_array();
		foreach ($rs as $r)
		{
			if (!array_key_exists($r['year'],$trend)) 
			{
				$trend[$r['year']] = $r['weight'];
			}
			else
			{
				$trend[$r['year']] += $r['weight'];
			}
		}
		return $trend;
	}
	
	function get_topic_trends()
	{
		$trends = array();
		$tcols = $this->get_topic_cols();
		$where = array();
		foreach($tcols as $col)
		{
			$where[] = "AVG($col) as '{$col}_weight'";
		}
		$where_str = implode(", ", $where);
		$sql = "SELECT doc_label as 'year', $where_str FROM doctopic GROUP BY year ORDER BY year";
		$q = $this->db->query($sql);
		$rs = $q->result_array();
		foreach ($rs as $r)
		{
			foreach($tcols as $col)
			{
				$trends[$col][$r['year']] = $r["{$col}_weight"];
			}
		}
		return $trends;
	}	
	
}