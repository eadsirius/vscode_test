<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Check extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		define('SKIN_DIR', '/views/_base/member');

		//모델 로드
		$this -> load -> model('M_member');
		

	}
	
	function idcheck()
	{
		$member_id = $this->input->post('member_id');
		
		$this->db->where('member_id', $member_id);
		$this->db->from('m_member');
		$cnt = $this->db->count_all_results();
		
		// 이메일 체크
		//$check_email=preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $member_id);
		//if($check_email==true){
			//preg_match("/^([a-z1-5])+$/i", $userid)
		
		if (preg_match("/[^0-9a-z_]+/i", $member_id)) {
			echo "110"; // 유효하지 않은 회원아이디
		} else if (strlen($member_id) < 6) {
    		echo "120"; // 3보다 작은 회원아이디
		} else {
			
			if ($cnt) {
				echo "130";
			} else {				
				echo "000";
			}

		}		
		
	}
	
	function mbcheck()
	{
		$member_id = $this->input->post('member_id');
		
		$this->db->where('member_id', $member_id);
		$this->db->from('m_member');
		$cnt = $this->db->count_all_results();
		
		if (preg_match("/[^0-9a-z_]+/i", $member_id)) {
			echo "110"; // 유효하지 않은 회원아이디
		} else if (strlen($member_id) < 3) {
    		echo "120"; // 3보다 작은 회원아이디
		} else {
			
			if ($cnt) {		
				echo "000";
			} else {				
				echo "130";
			}

		}		
		
	}
	
	
	function account_idcheck()
	{
		$member_id = $this->input->post('account_id');
		
		$this->db->where('account_id', $member_id);
		$this->db->from('m_account');
		$cnt = $this->db->count_all_results();
		
		if (preg_match("/[^0-9a-z_]+/i", $member_id)) {
			echo "110"; // 유효하지 않은 회원아이디
		} else if (strlen($member_id) < 3) {
    		echo "120"; // 3보다 작은 회원아이디
		} else {
			
			if ($cnt) {
				echo "130";
			} else {
				
				echo "000";
			}

		}		
		
	}
	
	
	
	function recheck()
	{
		
		$member_id = $this->input->post('recommend_id');
		
		$this->db->where('member_id', $member_id);
		$this->db->from('m_member');
		$cnt = $this->db->count_all_results();
		
		if (preg_match("/[^0-9a-z_]+/i", $member_id)) {
			echo "110"; // 유효하지 않은 회원아이디
		} else if (strlen($member_id) < 3) {
    		echo "120"; // 3보다 작은 회원아이디
		} else {
			
			if ($cnt) {
				echo "000";
			} else {
				
				echo "130";
			}

		}		
		
	}
	
	
	
	function spcheck()
	{	
		$mb_id 		= $this->session->userdata('member_id');
		$member_id 	= $this->input->post('sponsor_id');
		
		$this->db->where('member_id', $member_id);
		$this->db->from('m_member');
		$cnt = $this->db->count_all_results();		
		
		$this->db->where('sponsor_id', $member_id);
		$this->db->from('m_member');
		$two = $this->db->count_all_results();		
		
		if (preg_match("/[^0-9a-z_]+/i", $member_id)) 
		{
			echo "110"; // 유효하지 않은 회원아이디
		} 
		else if (strlen($member_id) < 3) 
		{
    		echo "120"; // 3보다 작은 회원아이디
		} 
		else if ($member_id == $mb_id) 
		{		
			$samsam = $this->M_member->samsam_check($mb_id);
			if($samsam > 0){				
				echo "150";
			}
		}
		else 
		{			
			if ($two > 1) {
				echo "130";
			}
			else if ($cnt < 1) {
				echo "130";
			} 
			else {
				echo "000";	
			}

		}		
		
	}
	
	
	function docheck()
	{
		$member_id = $this->input->post('member_id');
		
		$this->db->where('member_id', $member_id);
		$this->db->from('m_member');
		$cnt = $this->db->count_all_results();
		
		if (preg_match("/[^0-9a-z_]+/i", $member_id)) {
			echo "110"; // 유효하지 않은 회원아이디
		} else if (strlen($member_id) < 3) {
    		echo "120"; // 3보다 작은 회원아이디
		} else {
			
			if ($cnt) {
				echo "000";
			} else {				
				echo "130"; // 아이디 존재
			}

		}		
		
	}

        
	function idsearchInfo()
	{
		$member_id = $this->input->post('member_id');
		
		$this->db->where('member_id', $member_id);
		$this->db->from('m_member');
		$query = $this->db->get();
        $item = $query->row();
        // $item->name
        // $item->mobile
	
		if ($item != null) {
            $name = mb_substr($item->name, '0', -2) . "***";
            $mobile = mb_substr($item->mobile, '0', -3) . "***";

            echo($name . "|" . $mobile);
        } else {
            echo("none");
        }
	}
}
	
?>