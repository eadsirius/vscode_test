<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hvrex extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('file','form', 'url','search'));
		// 라이브러리
		$this->load->library('form_validation');
		$this->load->library('Elwallet_api');
		$this->load->library('qrcode');		

		//모델 로드
		$this->load->model('m_cfg');
		$this->load->model('m_coin');
		$this -> load -> model('m_member');

		// 미 로그인 상태라면
		loginCheck();
	}

	public function index()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'Member');
		$site 			= get_site();
		$data['site'] 	= $site;
		$data['active'] = "mu6";

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->m_member->get_member($login_id);
		//---------------------------------------------------------------------------------/	
		$data['country'] = $this->m_member->get_country_li();
		//---------------------------------------------------------------------------------//
		$bal 	= $this->m_coin->get_balance_id($login_id);
		$data['link_img'] 	= '';//$link_img;
		$data['level'] 	= $bal->level;	
		//---------------------------------------------------------------------------------//
		
		$this->form_validation->set_rules('email', 'email', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('/member/hvrex',$data,'office');
		} 
		else 
		{			
			// 개인정보 수정
			$this->m_member->member_up($login_id);

			alert("수정이 완료되었습니다", "member/hvrex");	
		}
	}

	function add()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'Member');
		$site 			= get_site();
		$data['site'] 	= $site;
		$data['active'] = "mu6";

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->m_member->get_member($login_id);
		//---------------------------------------------------------------------------------/	
		$data['country'] = $this->m_member->get_country_li();
		//---------------------------------------------------------------------------------//
		$bal 	= $this->m_coin->get_balance_id($login_id);
		//---------------------------------------------------------------------------------//
		
		$this->form_validation->set_rules('hvrex_id', 'hvrex_id', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{			
			layout('/member/hvrexEdit',$data,'office');

		} else {
			
			// 개인정보 수정
			$this->m_member->member_hvrex($login_id);

			alert("Hvrex 계정을 추가하습니다", "member/hvrex");	
		}
	
	}
}
?>