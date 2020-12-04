<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coinregister extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('file','form', 'url','search'));
		$this->load->library('form_validation');
		$this->load->library('qrcode');

		//$this->load->library('Elwallet_api');
		$this->load->library('SmsLib');

		//모델 로드
		$this->load->model('m_cfg');
		$this->load->model('m_admin');
		$this->load->model('m_point');
		$this->load->model('m_coin');
		$this->load->model('m_member');
		$this->load->model('m_bbs');

		loginCheck();
	}
	
	
	public function index()
	{
		$this->send();
	}
	
	
	// 코인보내기 - 락걸기
	public function send()
	{
		$data = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'OFFICE');
		$site 			= get_site();
		$data['site'] 	= $site;
		$data['active'] = "mu2";

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->m_member->get_member($login_id);
		//---------------------------------------------------------------------------------/	
		$data['country'] = $this->m_member->get_country_li();
		/*-----------------------------------------------------------------------------
			---------------------------------------------------------------------------*/
		
		$this->form_validation->set_rules('address', 'address', 'required'); // 코인주소		
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('token/addressReg',$data,'office');

		} else {
		
			$address 	= $this->input->post('address');

			qrcode($login_id,$address);
			
			$type = 'btc';
			$qrimg = $login_id ."_btc.png";
			$this->m_coin->set_wallet_in($login_id,$address,$qrimg,$type);
			//-------------------------------------------------------------------------------------------------------------------------------//
			alert("Register a Bitcoin Wallet address", "/");
		}

	}
	
	public function edit()
	{
		$data = array();
		$data['header'] 	= array('title'=>'OFFICE','group'=>'OFFICE');
		$site 			= get_site();
		$data['site'] 	= $site;
		$data['active'] 	= "mu2";

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->m_member->get_member($login_id);
		$wallet = $this->m_coin->get_wallet($login_id);
			$data['wallet_no'] 	= $wallet->wallet_no;
			$data['wallet'] 	= $wallet->wallet;
		//---------------------------------------------------------------------------------/	
		$data['country'] = $this->m_member->get_country_li();
		/*-----------------------------------------------------------------------------
			---------------------------------------------------------------------------*/
		
		$this->form_validation->set_rules('address', 'address', 'required'); // 코인주소		
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('token/addressEdit',$data,'office');

		} else {
		
			if($site->cfg_phone_out == 1){
				$authcode 		= $this->input->post('authcode');
				$type 			= $this->input->post('type');
				$mobile 		= $this->input->post('mobile');
				
				$mobile = preg_replace("/\s+/","",$mobile);
				
				$chk_mobile = $type .$mobile;
				$save_authcode = $this->m_member->get_sms_authcode($chk_mobile);
				if($save_authcode != $authcode)
				{
					alert("인증키가 올바르지 않습니다.");
				}
			}
			if($site->cfg_mail_bit == 1){
				$email 			= $this->input->post('email');
				$mailcode 		= $this->input->post('mailcode');
				
				$save_authcode = $this->m_member->get_email_authcode($email);
				if($save_authcode != $mailcode)
				{
					alert("The authentication key is incorrect.");
				}
			}
			
			$address 	= $this->input->post('address');

			$query = array(
				'wallet' 		=> $address,
			);
			$this->db->where('wallet_no', $wallet->wallet_no);
			$this->db->update('m_wallet', $query);
			//-------------------------------------------------------------------------------------------------------------------------------//
			
			alert("Edit a Bitcoin Wallet address", "token/address");
		}

	}

}