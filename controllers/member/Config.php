<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('file','form', 'url','search'));
		$this->load->library('form_validation');

		$this->load->library('bitcoin');

		$this->load-> model('m_admin');
		$this -> load -> model('m_member');
		$this -> load -> model('m_coin');
		
		// 미 로그인 상태라면
		loginCheck();


	}

	public function index()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'PROFILE');

		$login_id = $this->session->userdata('member_id');
		
		layout('member/config',$data);
	}

	function profile()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'sub_page set05');
		
		$member = $this->m_member->get_member($this->session->userdata('member_id')); // 회원정보
		$data['member'] = $member; // 회원정보

		$this->form_validation->set_rules('hp', 'hp', 'required');
		$this->form_validation->set_rules('email', 'email', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('member/profile',$data);

		} else {			
			// 비밀번호 수정
			$this->db->where('mb_id', $this->session->userdata('member_id'));
			$this->db->set('mb_hp', $this->input->post('hp'), true);
			$this->db->set('mb_email', $this->input->post('email'), true);
			$this->db->update('g5_member');			
			
			$lang = get_cookie('lang');
			
			if ($lang == "us" or $lang == "") {
				alert("Your personal information has been edited", "app/member/profile");
			}
			if ($lang == "cn") {
				alert("Your personal information has been edited", "app/member/profile");	
			}
			if ($lang == "kr") {
				alert("개인정보 수정이 완료되었습니다", "app/member/profile");	
			}
		}
	
	}
	
	
	
	
	function password()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'sub_page set02');
		
		$member = $this->m_member->get_member($this->session->userdata('member_id')); // 회원정보
		$data['member'] = $member; // 회원정보

		$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_rules('new_password', 'new_password', 'required');
		$this->form_validation->set_rules('new_password_confirm', 'new_password_confirm', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('app/member/password',$data);

		} else {
			
			if (!$member || $this->input->post('password') != $member->mb_password) {
				alert("Password Check!");	
			}
			else{			
				// 비밀번호 수정
				$this->db->where('mb_id', $this->session->userdata('member_id'));
				$this->db->set('mb_password', $this->input->post('new_password'), true);
				$this->db->update('g5_member');			
			}
					
			
			$lang = get_cookie('lang');
			
			if ($lang == "us" or $lang == "") {
				alert("Your password edit is complete", "app/member/profile");
			}
			if ($lang == "cn") {
				alert("Your password edit is complete", "app/member/profile");	
			}
			if ($lang == "kr") {
				alert("비밀번호 수정이 완료되었습니다", "app/member/profile");
			}	
		}

	}
	
	function passwordEx()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'sub_page set03');

		
		$member = $this->m_member->get_member($this->session->userdata('member_id')); // 회원정보
		$data['member'] = $member; // 회원정보

		//$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_rules('new_password', 'new_password', 'required');
		$this->form_validation->set_rules('new_password_confirm', 'new_password_confirm', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('app/member/password_ex',$data);

		} else {
			
			if (!$member || $member->mb_3 == '') 
			{			
				// 비밀번호 수정
				$this->db->where('mb_id', $this->session->userdata('member_id'));
				$this->db->set('mb_3', $this->input->post('new_password'), true);
				$this->db->update('g5_member');
			}
			else if (!$member || $this->input->post('password') != $member->mb_3) 
			{
				alert("Password Check!");	
			}
			else{			
				// 비밀번호 수정
				$this->db->where('mb_id', $this->session->userdata('member_id'));
				$this->db->set('mb_3', $this->input->post('new_password'), true);
				$this->db->update('g5_member');			
			}
			
			$lang = get_cookie('lang');
			
			if ($lang == "us" or $lang == "") {
				alert("Modification of withdrawal password is complete", "app/member/profile");
			}
			if ($lang == "cn") {
				alert("Modification of withdrawal password is complete", "app/member/profile");	
			}
			if ($lang == "kr") {
				alert("출금 비밀번호 수정이 완료되었습니다", "app/member/profile");	
			}
		}

	}
	
	function bank()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'sub_page set04');

		$member = $this->m_member->get_member($this->session->userdata('member_id')); // 회원정보
		$data['member'] = $member; // 회원정보

		$this->form_validation->set_rules('bank_name', 'bank_name', 'required');
		$this->form_validation->set_rules('bank_number', 'bank_number', 'required');
		$this->form_validation->set_rules('bank_holder', 'bank_holder', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('app/member/bank',$data);

		} else {			
			// 비밀번호 수정
			$this->db->where('mb_id', $this->session->userdata('member_id'));
			$this->db->set('mb_bank_name', $this->input->post('bank_name'), true);
			$this->db->set('mb_bank_number', $this->input->post('bank_number'), true);
			$this->db->set('mb_bank_holder', $this->input->post('bank_holder'), true);
			$this->db->update('g5_member');	
			
			$lang = get_cookie('lang');
			
			if ($lang == "us" or $lang == "") {
				alert("Your bank information has been edited", "app/member/profile");
			}
			if ($lang == "cn") {
				alert("Your bank information has been edited", "app/member/profile");	
			}
			if ($lang == "kr") {
				alert("은행정보 수정이 완료되었습니다", "app/member/profile");	
			}
		}
		
	}

}
?>
