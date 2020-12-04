<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		// 라이브러리
		$this->load->library('form_validation');
		//$this->load->library('Elwallet_api');

		//모델 로드
		$this -> load -> model('M_cfg');
		$this -> load -> model('M_member');

        // 메시지
        //$this->lang = get_lang();
        //echo(get_msg('cn', '비밀번호를 잊어버렸습니까?'));
	}

	//로그인
	function index()
	{
		
		$data = array();
		$data['header'] = array('title'=>'Login','group'=>'signup-page');
		$site 			= get_site();
		$data['site'] 	= $site;
		$lang = get_cookie('lang');
		$data['select_lang'] = "kr";

		// 이미 로그인 햇다면
		if ($this->session->userdata('is_login') == TRUE) {
			redirect('/office');
		}

		// 기존 머물렀던 url 존재 한다면
		$is_url = urldecode($this->uri->segment(3));
		$is_url = str_replace('.2F', '/', urlencode($is_url));

		// 폼검증
		$this->form_validation->set_rules('member_id', get_msg($lang, '아이디'), 'required');
		$this->form_validation->set_rules('password', get_msg($lang, '암호'), 'required');

		if ($this->form_validation->run() == FALSE)
		{
			layout('member/login',$data,'login');
		} 
		else 
		{
			$member = $this->M_member->get_member(strtolower($this->input->post('member_id')));

			if (!$member || $this->input->post('password') != $member->password) {

				alert(get_msg($lang, '아이디 비밀번호를 확인해주세요. '));

			} else {				
				
			if($site->cfg_mail == 1){
				if($member->sync == 0){										
					alert(get_msg($lang, '이메일을 확인하십시오!'), "member/login");
				}
				else{
				$member_ses= array(
					'member_id'  => $member->member_id,
					'member_no'  => $member->member_no,
					'level'  => $member->level,
					'is_login' => TRUE,
				);
				$this->session->set_userdata($member_ses);
				// 최근 접속일
				$this->db->where('member_id', $this->session->userdata('member_id'));
				$this->db->set('last_login', 'now()', FALSE);
				$this->db->update('m_member');
					
				}
			}
			else{
				//세션 굽기
				$member_ses= array(
					'member_id'  => $member->member_id,
					'member_no'  => $member->member_no,
					'level'  => $member->level,
					'is_login' => TRUE,
				);
				$this->session->set_userdata($member_ses);
				// 최근 접속일
				$this->db->where('member_id', $this->session->userdata('member_id'));
				$this->db->set('last_login', 'now()', FALSE);
				$this->db->update('m_member');
				
			}


				//---------------------------------------------------------------------------//
				
				redirect('/office');

			}

		}

	}
	
	// 로그아웃
	function out()
	{
		$this->session->sess_destroy();

		redirect('member/login');

	}

}
?>
