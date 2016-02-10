<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends CI_Controller {
		
	public function index($table='') 
	{ 
		$data = array();
  		$this->load->view('templates/header', $data);
  		$this->load->view('data/readme',      $data);
  		$this->load->view('templates/footer', $data);      
    }
	
	public function topic_entropy () {
		$this->output->set_content_type("text/plain");
		$q = $this->db->query("SELECT count(*) as 'n', round(topic_entropy,2) as 'h' from doctopic group by round(topic_entropy,2) order by topic_entropy");
		foreach ($q->result_array() as $r) {
			print("{$r['n']},{$r['h']}\n");
		}
	}
	
	public function view($table = '', $format = "html", $id_col = NULL, $id_val = NULL, $cols = NULL) 
	{
   
    	$formats = array('text','html','json'); // Use when a format is specified 	
    
	    $args = $this->uri->total_segments();
    	$data['status_message'] = "ARGS: $args";
    
    	$page = 'default';
    	$full_page = TRUE;
    	$run_sql = FALSE;
     
		if ($args == 2) 
		{ // List all tables
      		$page = 'table_list';
      		$data['page_title'] = "Tables";
      		$data['tables'] = $this->db->list_tables();
      		$this->db->close();
    	}
    	elseif ($args >= 3 && $args <= 4) 
    	{ // List all rows for table up to 1000
      		$page = 'table_data';
			$data['table'] = $table;
			$data['page_title'] = " $table";
      
			# DB START
			$data['results'] = array();
			if ($this->db->table_exists($table)) 
			{
		    	$data['field_info'] = $this->db->field_data($table);
				$rs = $this->db->query("SELECT * FROM $table LIMIT 1000");
				$data['row_count'] = $rs->num_rows();
				if ($data['row_count']) 
				{
			  		$data['results'] = $rs->result_array();
				} 
				else 
				{
		  			$page = 'default';
		  			$data['message'] = "<tt>$table</tt> has no data.";
		      		$full_page = TRUE;
		    	} 
		    	$rs->free_result();      
		  	} 
		  	else 
		  	{
		  		$page = 'default';
				$data['message'] = "<tt>$table</tt> is not a table.";
		    	$full_page = TRUE;
		  	}
		  	$this->db->close();
		  	# DB END
      
      		if ($args == 4) 
      		{ // This will be a special format 
        		$full_page = FALSE;
        		if (in_array($format, $formats)) 
        		{
          			$page = 'table_data_'.$format;
          			$this->output->set_content_type("text/$format");                  
        		} 
        		else 
        		{
          			$oldformat = $format;
          			$format = 'html';
          			$page = 'default';
          			$data['message'] = "<tt>$oldformat</tt> is not a recognized format.";
          			$full_page = TRUE;
        		}
      		}
    	}
   		elseif ($args == 5) 
   		{ // ID col only; not cool --> ACTUALLY, SHOW WHOLE COLUMN
   			$full_page  = FALSE;
      		$page       = 'col_data_'.$format;
      		$cols       = explode('--',$id_col);
      
			$data['table']   = $table;
			$data['col']     = $id_col;
			$data['rows']    = array();
      
      		# DB START
      		$cols_ok = 1;
      		foreach ($cols as $col) 
      		{
        		if (!$this->db->field_exists($col, $table)) 
        		{
          			$cols_ok = 0;
          			break;
        		}
      		}
      		if ($cols_ok && $this->db->table_exists($table)) 
      		{
        		$colstr = '`'. implode('`,`',$cols) .'`';
        		$data['colstr']  = $colstr;
        		$rs = $this->db->query("SELECT $colstr FROM `$table` WHERE 1");
        		foreach ($rs->result_array() as $row) 
        		{
          			$data['rows'][] = $row;
        		}
        		$rs->free_result();      
      		} 
      		else 
      		{
        		$format = 'html';
        		$page = 'default';
        		$data['message'] = "<tt>$table</tt> is not a table or <tt>$id_col</tt> not cols";
        		$full_page = TRUE;
      		}
      		$this->db->close();
      		# DB END
		}
    	elseif ($args == 6) 
    	{ // ID col + ID value
    		$data['results'] = array();
      		$data['table'] = $table;
      
      		# DB START
      		if ($this->db->table_exists($table)) 
      		{
        		$rs = $this->db->query("SELECT * FROM `$table` WHERE `$id_col` = ?", array(urldecode($id_val)));
        		$data['row'] = $rs->row_array();
        		$rs->free_result();      
      		} 
      		else 
      		{
        		$format = 'html';
        		$page = 'default';
        		$data['message'] = "<tt>$table</tt> is not a table";
        		$full_page = TRUE;
      		}
      		$this->db->close();
      		# DB END
      
      		$full_page = FALSE;
      		$page = 'row_data_'.$format;
      		//$this->output->set_content_type("text/$format");
   		}
   		elseif ($args == 7) 
   		{ // COL names
      		$data['results'] = array();
      		$data['table'] = $table;
      
      		# DB START
	     	if ($this->db->table_exists($table)) 
	     	{
        		$select = array();
        		foreach (explode('--',$cols) as $col) 
        		{
          			if (preg_match('/^[a-zA-Z0-9_]+$/',$col)) 
          			{
            			$select[] = $col;
          			}
        		}
        		$select_str = implode('`,`',$select);
        		$rs = $this->db->query("SELECT `$select_str` FROM `$table` WHERE `$id_col` = ?", array(urldecode($id_val)));
        		$data['row'] = $rs->row_array();
        		$rs->free_result();      
      		} 
      		else 
      		{
        		$format = 'html';
        		$page = 'default';
        		$data['message'] = "<tt>$table</tt> is not a table";
        		$full_page = TRUE;
      		}
      		$this->db->close();
      		# DB END
      
      		$full_page = FALSE;
      		$page = 'row_data_'.$format;
      		//$this->output->set_content_type("text/html");                  
    	}

    	$this->output->set_content_type("text/$format");                  
      
    	if ($full_page && $page) 
    	{
      		$this->load->view('templates/header', $data);
      		$this->load->view('data/'.$page,      $data);
      		$this->load->view('templates/footer', $data);      
    	} 
    	elseif ($page) 
    	{
      		$this->load->view('data/'.$page, $data);      
    	} 
    	else 
    	{
      		$this->load->view('data/default', $data);            
    	}
    
  	}
	 	  
}