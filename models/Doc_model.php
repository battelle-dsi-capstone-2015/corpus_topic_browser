<?php 

class Doc_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
		#$this->DB1 = $this->load->database('default', TRUE);
    }
	
	function get_list($limit=1000) 
	{
		$q = $this->db->query("SELECT s.doc_id, s.year, s.title, d.topic_entropy FROM src_all_doi s JOIN doctopic d USING (doc_id) ORDER BY s.title LIMIT $limit"); 
		return $q->result_array();
	}
	
	function get_item($doc_id)
	{
		$q = $this->db->query("SELECT title, year, authors, abstract, doi, cite_count FROM src_all_doi WHERE doc_id = ?",array($doc_id));
		return $q->row_array();
	}
	
	function get_list_by_topic($topic_ids = array())
	{
		$topic_where = array();
		foreach ($topic_ids as $topic_id) { $topic_where[] = "t{$topic_id} >= 0.1"; }
		$topic_where_str = implode(' AND ', $topic_where);
		$q2 = $this->db->query("SELECT d.topic_entropy, s.doc_id, title, year, authors, abstract, doi, cite_count FROM src_all_doi s
			JOIN doctopic d USING(doc_id) 
			WHERE s.doc_id IN (SELECT doc_id FROM doctopic WHERE $topic_where_str)
			ORDER BY d.topic_entropy");
		return $q2->result_array();		
	}
	
	function get_list_by_entropy($hmin, $hmax = NULL)
	{
		$topic_where_str = "topic_entropy >= $hmin";
		if ($hmax) {
			$topic_where_str .= " AND topic_entropy < $hmax";
		}
		$q2 = $this->db->query("SELECT d.topic_entropy, s.doc_id, title, year, authors, abstract, doi, cite_count FROM src_all_doi s
			JOIN doctopic d USING(doc_id) 
			WHERE s.doc_id IN (SELECT doc_id FROM doctopic WHERE $topic_where_str)
			ORDER BY d.topic_entropy");
		return $q2->result_array();		
	}
	
	
	function get_topics($doc_id, $limit = 10)
	{
		$min = 0.05;
		#$min = 0.01;
	    $values = array();
	    $q1 = $this->db->query("SELECT doc_id, topic_id, topic_weight FROM doctopic_long WHERE doc_id = ? AND topic_weight >= $min ORDER BY topic_weight DESC LIMIT $limit", array($doc_id));
	    foreach($q1->result_array() as $r1) {
	        $q2 = $this->db->query("SELECT topic_words FROM topic WHERE topic_id = ?",array($r1['topic_id']));
	        $r2 = $q2->row_array();
	        $values[] = array(
	            'topic_id'      => $r1['topic_id'], 
	            'topic_weight'  => $r1['topic_weight'], 
	            'topic_words'   => $r2['topic_words']
	        );
	    }
	    return $values;
	}
	
	function get_related_docs($doc_id)
	{
		$q = $this->db->query("SELECT s.title, doc_id_2, distance FROM docpair dp JOIN src_all_doi s ON(dp.doc_id_2 = s.doc_id) WHERE dp.doc_id = ? ORDER BY distance", array($doc_id));		
		return $q->result_array();
	}
	
	function get_avg_distance()
	{
		$q = $this->db->query("SELECT AVG(distance) as x FROM docpair");
		$r = $q->row_array();
		return $r['x'];
	}
	
	function get_docs($doc_id,$limit=10)
	{
		$docs = array();		
		$q1 = $this->db->query("
			SELECT d.doc_id, s.title, s.authors, s.year, d.topic_weight, d.topic_id
			FROM doctopic_long d JOIN src_all_doi s USING(doc_id) 
			WHERE d.doc_id != ? AND topic_weight >= 0.1 AND topic_id 
			IN (
				SELECT topic_id 
				FROM doctopic_long 
				WHERE doc_id = ? 
				ORDER BY topic_weight DESC limit 1) 
			ORDER BY topic_weight DESC 
			LIMIT $limit", array($doc_id,$doc_id));
		foreach ($q1->result_array() as $r) 
		{
			$docs[] = array(
				'doc_id' 		=> $r['doc_id'],
				'title' 		=> $r['title'],
				'authors' 		=> $r['authors'],
				'year' 			=> $r['year'],
				'topic_weight'  => $r['topic_weight'],
				'topic_id'		=> $r['topic_id']
			);			
		}
		/*
		$q1 = $this->db->query("SELECT DISTINCT b.doc_id as 'doc_id' 
			FROM doctopic_long a JOIN doctopic_long b USING(topic_id) 
			WHERE a.topic_weight >= 0.1 AND b.topic_weight >= 0.1 AND a.doc_id = ? AND a.doc_id != b.doc_id 
			ORDER BY a.topic_weight DESC, b.topic_weight DESC 
			LIMIT $limit",$doc_id);
		$doc_ids = array();
		foreach($q1->result_array() as $r) {
			$doc_ids[] = $r['doc_id'];
		}
		$doc_ids_str = implode(',',$doc_ids);
		$q2 = $this->db->query("SELECT doc_id, authors, year, title FROM src_all_doi WHERE doc_id in ($doc_ids_str)");
		foreach($q2->result_array() as $r) {
			$docs[] = array(
				'doc_id' 	=> $r['doc_id'],
				'title' 	=> $r['title'],
				'authors' 	=> $r['authors'],
				'year' 		=> $r['year']
			);			
		}
		*/
	    return $docs;
	}
	
	function get_topic_distro($doc_id)
	{
		$q = $this->db->query("SELECT d.topic_id as 'topic_id', t.topic_words as 'topic_words', ROUND(d.topic_weight,2) as 'topic_weight' FROM doctopic_long d JOIN topic t USING (topic_id) WHERE d.doc_id = ? ORDER BY d.topic_weight DESC LIMIT 10",array($doc_id));
		return $q->result_array();
	}
	
	function get_topic_entropy_stats()
	{
		$entropy = array();
		$q1 = $this->db->query("SELECT max(topic_entropy) as 'max_h', min(topic_entropy) as 'min_h', avg(topic_entropy) as 'avg_h' FROM doctopic");
		$r1 = $q1->row_array();
		$entropy['max'] = $r1['max_h'];
		$entropy['min'] = $r1['min_h'];
		$entropy['avg'] = $r1['avg_h'];
		return $entropy;
	}
	
	function get_topic_entropy($doc_id)
	{
	 	$entropy = array();
	
		$q1 = $this->db->query("SELECT max(topic_entropy) as 'max_h', min(topic_entropy) as 'min_h', avg(topic_entropy) as 'avg_h' FROM doctopic");
		$r1 = $q1->row_array();
		$entropy['max'] = $r1['max_h'];
		$entropy['min'] = $r1['min_h'];
		$entropy['avg'] = $r1['avg_h'];
		
		#Work out the Mean (the simple average of the numbers)
    	#Then for each number: subtract the Mean and square the result.
    	#Then work out the mean of those squared differences.
    	#Take the square root of that and we are done!
		
		$q2 = $this->db->query("SELECT topic_entropy FROM doctopic WHERE doc_id = ?",$doc_id);
		$r2 = $q2->row_array();
		$entropy['this'] = $r2['topic_entropy'];
		
		return $entropy;
	}
	
	function get_words($doc_id, $limit=25)
	{
		
		$q = $this->db->query("SELECT doc_id, word_id, word_str, word_count FROM docword WHERE doc_id = ? ORDER BY word_count DESC limit $limit",$doc_id);
		return $q->result_array();
	}
	
	function get_max_words()
	{
		$q = $this->db->query("SELECT MAX(word_count) as 'n' FROM docword");
		$r = $q->row_array();
		return $r['n'];
	}
	
	function get_lonely_docs($limit = 100)
	{
		$q = $this->db->query("SELECT s.title as 'title', d.doc_id as 'doc_id', AVG(d.distance) as 'distance' 
			FROM docpair d
			JOIN src_all_doi s USING(doc_id)
			GROUP BY d.doc_id
			ORDER BY distance DESC
			LIMIT $limit");
		return $q->result_array();
	}
    
	function get_connected_docs($limit = 100)
	{
		$q = $this->db->query("SELECT s.title as 'title', d.doc_id as 'doc_id', AVG(d.distance) as 'distance' 
			FROM docpair d
			JOIN src_all_doi s USING(doc_id)
			GROUP BY d.doc_id
			ORDER BY distance 
			LIMIT $limit");
		return $q->result_array();
	}

}