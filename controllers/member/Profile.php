<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('file','form', 'url','search','file'));
		// 라이브러리
		$this->load->library('form_validation');
		//$this->load->library('upload');
		$this->load->library('qrcode');
		$this->load->library('urlapi');
		$this->load->library('bitcoin');	

		//모델 로드
		$this->load->model('M_cfg');
		$this->load->model('M_bbs');
		$this->load->model('M_coin');
		$this->load->model('M_point');
		$this->load->model('M_member');

		// 미 로그인 상태라면
		loginCheck();
	}

	public function index(){
		$this->edit();
	}

	function edit()
	{
		$data = $member = array();
		$data['site'] = $this->M_cfg->get_site();

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['country'] 	= $this->M_member->get_country_li();
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'wpc');
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		$staking = $this->M_coin->getStaking($login_id);
		$data['staking'] = new \stdClass();
		if($staking) {
			$data['staking']->purchase_hap = $staking->purchase_hap;
			$data['staking']->repurchase_hap = $staking->repurchase_hap;
		} else {
			$data['staking']->purchase_hap	=	0;
			$data['staking']->repurchase_hap	=	0;
		}
		$total_su = $this->M_coin->getTotalSu($login_id);
		$data['total_su'] = new \stdClass();
		if($total_su) {
			$data['total_su']->sum_day = $total_su->sum_day;
			$data['total_su']->sum_re = $total_su->sum_re;
			$data['total_su']->sum_mc = $total_su->sum_mc;
			$data['total_su']->all_su = $data['total_su']->sum_day+$data['total_su']->sum_re+$data['total_su']->sum_mc;
		} else {
			$data['total_su']->sum_day = 0;
			$data['total_su']->sum_re = 0;
			$data['total_su']->sum_mc = 0;
			$data['total_su']->all_su = 0;
		}
		//---------------------------------------------------------------------------------//
		// 2020.08.19 박종훈 투자금, 투자포인트 확인
		$investment 	= $this->M_coin->getDollarDeposit($login_id);
		$data['investment'] 	= $investment;
		//---------------------------------------------------------------------------------//
    $bank_list = $this->M_member->getBankList();
    $data['bankList'] = $bank_list;

		layout('/member/profile',$data,'office');
	
	}

	function phone()
	{
		$data = $member = array();
		$site 			= get_site();
		$data['site'] 	= $site;

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['country'] 	= $this->M_member->get_country_li();
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'wpc');
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------//
		
		$this->form_validation->set_rules('mobile', 'mobile', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{			
			layout('/member/profile/edit',$data,'office');

		} else {
			
			$country 		= $this->input->post('country');
			
			$old_authcode 	= $this->input->post('old_authcode');
			$old_mobile 	= $this->input->post('old_mobile');
			$mobile = preg_replace("/\s+/","",$old_mobile);	
			
			$authcode 		= $this->input->post('authcode');
			$mobile 		= $this->input->post('mobile');				
			$mobile = preg_replace("/\s+/","",$mobile);
			
			if($mobile == $old_mobile){
				alert("휴대폰번호가 같습니다.");				
			}
			//---------------------------------------------------------------------------------//
					
			$old_chk_mobile = $country .$old_mobile;
			$old_save_authcode = $this->M_member->get_sms_authcode($old_chk_mobile);
			if($old_save_authcode != $old_authcode)
			{
				alert("이전 휴대폰번호 인증문자가 틀립니다.");
			}
			
			//---------------------------------------------------------------------------------//
					
			$chk_mobile = $country .$mobile;
			$save_authcode = $this->M_member->get_sms_authcode($chk_mobile);
			if($save_authcode != $authcode)
			{
				alert("새 휴대폰번호 인증문자가 틀립니다.");
			}
			
			//---------------------------------------------------------------------------------//
			$this->db->where('member_id', $login_id);
			$this->db->set('mobile', $mobile, FALSE);
			$this->db->update('m_member');

			alert("수정이 완료되었습니다", "member/profile");	
		}
	
	}

	function email()
	{
		$data = $member = array();
		$site 			= get_site();
		$data['site'] 	= $site;

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['country'] 	= $this->M_member->get_country_li();
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'wpc');
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------//
		
		$this->form_validation->set_rules('email', 'email', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{			
			layout('/member/profile/edit',$data,'office');

		} else {
			// 인증을 거친 후에 처리한다.
			$email 		= $this->input->post('email');
			
			$this->db->where('member_id', $login_id);
			$this->db->set('email', $mobile, FALSE);
			$this->db->update('m_member');

			alert("수정이 완료되었습니다", "member/profile");	
		}
	
	}

	function address()
	{
		$data = $member = array();
		$site 			= get_site();
		$data['site'] 	= $site;

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['country'] 	= $this->M_member->get_country_li();
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'wpc');
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------//
		
		$this->form_validation->set_rules('address', 'address', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{			
			layout('/member/profile/edit',$data,'office');

		} else {
			
			$query = array(
				'post' 		=> $this->input->post('post'),
				'address' 	=> $this->input->post('address'),
				'address1' 	=> $this->input->post('address1'),
			);
			$this->db->where('member_id',$login_id);
			$this->db->update('m_member', $query);

			alert("수정이 완료되었습니다", "member/profile");	
		}
	
	}
	
	//---------------------------------------------------------------------------------//
	function setting()
	{
		$data = $member = array();
		$data['site'] = $this->M_cfg->get_site();

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'wpc');
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------//
		// 추천횟수 - 추천인 몇명인지 가져오기
		//---------------------------------------------------------------------------------//
		$data['reCnt'] = $this->M_member->get_recommend_chk($login_id);
		//---------------------------------------------------------------------------------//
			
		layout('/member/setting',$data,'office');
	
	}
	
	function password()
	{
		$data = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'Member');
		$site 			= get_site();
		$data['site'] 	= $site;
		$data['active'] = "mu6";

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$member = $this->M_member->get_member($login_id);
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'wpc');
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------/	
		$data['country'] = $this->M_member->get_country_li();		
		//---------------------------------------------------------------------------------//
		
		$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_rules('new_password', 'new_password', 'required');
		$this->form_validation->set_rules('new_password_confirm', 'new_password_confirm', 'required');
		
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('/member/password',$data,'office');

		} else {
			
			if (!$member || $this->input->post('password') != $member->password) {
				alert("Password Check!!.");	
			}
			else{	
			
				if($site->cfg_phone_reg == 1 and $site->cfg_phone_view == 1){
					$authcode 		= $this->input->post('authcode');
					$type 			= $this->input->post('type');
					$mobile 		= $this->input->post('mobile');
				
					$mobile = preg_replace("/\s+/","",$mobile);	
						
					$chk_mobile = $type .$mobile;
					$save_authcode = $this->M_member->get_sms_authcode($chk_mobile);
					if($save_authcode != $authcode)
					{
						alert("The authentication key is incorrect.");
					}	
				} 
				else if($site->cfg_phone_view == 1){
					$mobile 		= $this->input->post('mobile');				
					$mobile = preg_replace("/\s+/","",$mobile);
				}
				//---------------------------------------------------------------------------------//
			
				if($site->cfg_mail_view == 1 and $site->cfg_mail_reg == 1){ 
					
					$email 	= $this->input->post('email');	
					$mailcode 	= $this->input->post('mailcode');
					$save_authcode = $this->M_member->get_email_authcode($email);
					if($save_authcode != $mailcode)
					{
						alert("The authentication key is incorrect.");
					}
				}
				else if($site->cfg_mail_view == 1){
					$email 	= $this->input->post('email');
				}
				//---------------------------------------------------------------------------------//
				
				// 비밀번호 수정
				$this->db->where('member_id', $this->session->userdata('member_id'));
				$this->db->set('password', $this->input->post('new_password'), true);
				$this->db->update('m_member');			
			}
			
			alert("Complete Password", "member/login/out");	
		}

	}
	
	
	function passwordEx()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'Member');
		$site 			= get_site();
		$data['site'] 	= $site;
		$data['active'] = "mu6";

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$member = $this->M_member->get_member($login_id);
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'wpc');
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------/	
		$data['country'] = $this->M_member->get_country_li();
		//---------------------------------------------------------------------------------//

		//$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_rules('new_password', 'new_password', 'required');
		$this->form_validation->set_rules('new_password_confirm', 'new_password_confirm', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('/member/password_ex',$data,'office');

		} else {
			
			$new_password = $this->input->post('new_password');
			
			if( preg_match( "/^[0-9]/i", $new_password) ) {
				$pw_cnt = strlen($new_password);
				if($pw_cnt == 6){
					if($new_password == '123456'){
						alert("123456은 불가합니다.");							
					}
				}
				else{
					alert("숫자만 6자리 입력하세요");					
				}
  			}
  			else {
				alert("숫자만 6자리 입력!");
  			}
			
			if (!$member || $member->secret == '') 
			{
				// 비밀번호 수정
				$this->db->where('member_id', $this->session->userdata('member_id'));
				$this->db->set('secret', $this->input->post('new_password'), true);
				$this->db->update('m_member');
			}
			else if (!$member || $member->secret == '123456') 
			{
				// 비밀번호 수정
				$this->db->where('member_id', $this->session->userdata('member_id'));
				$this->db->set('secret', $this->input->post('new_password'), true);
				$this->db->update('m_member');
			}
			else if (!$member || $this->input->post('password') != $member->secret) 
			{
				alert("Send Password Check!");	
			}else{
										
				// 비밀번호 수정
				$this->db->where('member_id', $this->session->userdata('member_id'));
				$this->db->set('secret', $this->input->post('new_password'), true);
				$this->db->update('m_member');			
			}
			
			$lang = get_cookie('lang');
			
			if ($lang == "us" or $lang == "") {
				alert("trans password revision complete", "member/profile/edit");
			}
			if ($lang == "cn") {
				alert("trans password revision complete", "member/profile/edit");	
			}
			if ($lang == "kr") {
				alert("전송 비밀번호 수정이 완료되었습니다", "member/profile/edit");	
			}
		}

	}
	
	
	
	/**
	 * OTP 생성
	 */
	public function auth()
	{
		$data = $member = array();
		$site 			= get_site();
		$data['site'] 	= $site;

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$member = $this->M_member->get_member($login_id);
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'wpc');
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------/	
		$data['country'] = $this->M_member->get_country_li();
		//---------------------------------------------------------------------------------//
		
		$this->form_validation->set_rules('confirm', 'confirm', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('/member/auth',$data,'office');

		} else {	
				
			if (!$member || $this->input->post('confirm') != $member->password) {
				alert("Password Check!!.");	
			}
			else{
				
				$this->db->where('member_id', $this->session->userdata('member_id'));
				$this->db->set('is_auth', 0, true);
				$this->db->update('m_member');
			}
			
			alert("Google Authenticator Otp Delete complete", "member/profile");
		}
		
	}
	
	
	public function authReg()
	{
		$data = $member = array();
		$site 			= get_site();
		$data['site'] 	= $site;

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$member = $this->M_member->get_member($login_id);
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'wpc');
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------/	
		$data['country'] = $this->M_member->get_country_li();
		//---------------------------------------------------------------------------------//
		
		$this->form_validation->set_rules('codeValue', 'codeValue', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('/member/auth_reg',$data,'office');

		} else {	
				
			$codeValue = $this->input->post('codeValue');
			$Gotp = $this->input->post('Gotp');
			
			$this->db->where('member_id', $this->session->userdata('member_id'));
			$this->db->set('is_auth', 1, true);
			$this->db->update('m_member');
			
			alert("Google Authenticator Otp Register complete", "member/profile");
		}
	}

	function bank()
	{
		$data = $member = array();
		$site 			= get_site();
		$data['site'] 	= $site;

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		//---------------------------------------------------------------------------------//
		//---------------------------------------------------------------------------------//
		
		$this->form_validation->set_rules('bank_num', 'bank_num', 'required');
		$this->form_validation->set_rules('bank_name', 'bank_name', 'required');
		$this->form_validation->set_rules('bank_holder', 'bank_holder', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{			
			layout('/member/profile',$data,'office');

		} else {
			
			$query = array(
				'bank_number' 		=> $this->input->post('bank_num'),
				'bank_name' 	=> $this->input->post('bank_name'),
				'bank_holder' 	=> $this->input->post('bank_holder'),
			);
			$this->db->where('member_id',$login_id);
			$this->db->update('m_member', $query);

			alert("수정이 완료되었습니다", "member/profile");	
		}
	
	}

}
?>
