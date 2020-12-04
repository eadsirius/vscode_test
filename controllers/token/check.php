<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Check extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		//모델 로드
		$this -> load -> model('M_coin');
		

	}
	
	function addresscheck()
	{
		$rev_id = $this->input->post('rev_id');
		
		$this->db->where('wallet', $rev_id);
		$this->db->from('m_wallet');
		$cnt = $this->db->count_all_results();
		
		if ($cnt) {
				echo "000";
		} else {				
				echo "100";
		}	
		
	}

}