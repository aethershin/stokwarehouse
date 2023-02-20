<?php

class Site_model extends CI_Model{
	
	function get_site_data(){
		$query = $this->db->get('detail_website', 1);
		return $query;
	}

	
}