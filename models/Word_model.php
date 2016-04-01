<?php 

class Word_model extends CI_Model {
  
    function __construct()
    {
        parent::__construct();
    }
	
	function get_list($limit=1000) 
	{
		$q = $this->db->query("SELECT word_id,word_str,word_freq FROM word ORDER BY word_freq DESC LIMIT $limit");
		return $q->result_array();
	}
	
	function get_score($word_str,$ttf_min=0,$ttf_max=100000,$idf_min=0,$score_min=0)
	{
		
		$q1 = $this->db->query("SELECT MAX(trendiness) as 'score_max' FROM word_stats");
		$r1 = $q1->row_array();
		$score_max = $r1['score_max'];
		
		$q2 = $this->db->query("SELECT COUNT(*) AS 'n' FROM doc");
		$r2 = $q2->row_array(); 
		$idf_max = $r2['n'];

		#ttf = prevelance idf = specificty	
		$q3 = $this->db->query("SELECT trendiness, ttf, idf, df
			FROM word_stats 
			WHERE trendiness > ? AND trendiness <= ? 
			AND ttf > ? AND ttf <= ? 
			AND idf > ? AND idf <= ? 
			AND word_str = ?",array($score_min,$score_max,$ttf_min,$ttf_max,$idf_min,$idf_max,$word_str));
		return $q3->row_array();
	}
	
	function get_list_with_topics($limit=1000)
	{
	    $q = $this->db->query("
	        SELECT tw.word_count as 'word_count', tw.word_id as 'word_id', tw.word_str as 'word_str', t.topic_words, t.topic_id
	        FROM topicword_long tw 
	        JOIN topic t USING(topic_id) 
	        ORDER BY tw.word_count DESC 
	        LIMIT 1000");
	    return $q->result_array();
	}
		
	function get_top_words_in_topics($limit=1000)
	{
		$q = $this->db->query("
			SELECT word_id, word_str, sum(word_count) as 'word_count'
			FROM topicword_long 
			WHERE 1
			GROUP BY word_id
			ORDER BY word_count DESC
			LIMIT $limit");
		return $q->result_array();
	}
	
	function get_item($word_str)
	{
		$q = $this->db->query("SELECT word_id, word_freq FROM word WHERE word_str = ?",array($word_str));
		return $q->row_array();
	}
	
	function get_max_words()
	{
	    $q = $this->db->query("SELECT max(word_freq) as 'n' FROM word");
	    $r = $q->row_array();
	    return $r['n'];
	}
	
	function get_trending_words($limit = 100)
	{
		$q = $this->db->query("SELECT word_str, trendiness 
			FROM word_stats 
			WHERE word_str NOT LIKE '%0%' 
			AND word_str NOT LIKE '%1%'
			AND word_str NOT LIKE '%2%'
			AND word_str NOT LIKE '%3%'
			AND word_str NOT LIKE '%4%'
			AND word_str NOT LIKE '%5%'
			AND word_str NOT LIKE '%6%'
			AND word_str NOT LIKE '%7%'
			AND word_str NOT LIKE '%8%'
			AND word_str NOT LIKE '%9%'
			ORDER BY trendiness DESC 
			LIMIT $limit");
		return $q->result_array();
	}
	
	function get_trendiness($word_str)
	{
		$q = $this->db->query("SELECT trendiness FROM word_stats WHERE word_str = ?", array($word_str));
		$r = $q->row_array();
		return $r['trendiness'];
	}
	
	function get_word_counts_by_year()
	{
		$counts = array();
		$q = $this->db->query("SELECT SUM(word_count) as 'total', year FROM wordfreq GROUP BY year");
		$rs = $q->result_array();
		foreach($rs as $r)
		{
			$counts[$r['year']] = $r['total'];
		}
		return $counts;
	}
	
	function get_trend_distro($word_str)
	{
		$trend = array();
		$counts = $this->get_word_counts_by_year();
		$q = $this->db->query("SELECT word_str, year, word_count FROM wordfreq WHERE word_str LIKE ?", array($word_str));
		$rs = $q->result_array();
		foreach ($rs as $r)
		{
			if (!array_key_exists($r['year'],$trend)) 
			{
				$trend[$r['year']] = $r['word_count'] / $counts[$r['year']];
			}
			else
			{
				$trend[$r['year']] += $r['word_count'] / $counts[$r['year']];
			}
		}
		return $trend;
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