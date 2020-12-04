<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coinregister extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('file','form', 'url','search'));
		$this->load->library('form_validation');
		$this->load->library('qrcode');

		//$this->load->library('Elwallet_api');
		//$this->load->library('SmsLib');

		//모델 로드
		$this->load->model('M_cfg');
		$this->load->model('M_admin');
		$this->load->model('M_point');
		$this->load->model('M_coin');
		$this->load->model('M_member');
		$this->load->model('M_bbs');

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
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		//---------------------------------------------------------------------------------/	
		$data['country'] = $this->M_member->get_country_li();
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
			$this->M_coin->set_wallet_in($login_id,$address,$qrimg,$type);
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
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		
		$wallet = $this->M_coin->get_wallet_type($login_id,'exchange');
			$data['wallet_no'] 	= $wallet->wallet_no;
			$data['wallet'] 	= $wallet->wallet;
		//---------------------------------------------------------------------------------/	
		$data['country'] = $this->M_member->get_country_li();
		/*-----------------------------------------------------------------------------
			---------------------------------------------------------------------------*/
		
		$this->form_validation->set_rules('address', 'address', 'required'); // 코인주소		
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('token/addressEdit',$data,'office');

		} else {
			/*
			if($site->cfg_phone_out == 1){
				$authcode 		= $this->input->post('authcode');
				$type 			= $this->input->post('type');
				$mobile 		= $this->input->post('mobile');
				
				$mobile = preg_replace("/\s+/","",$mobile);
				
				$chk_mobile = $type .$mobile;
				$save_authcode = $this->M_member->get_sms_authcode($chk_mobile);
				if($save_authcode != $authcode)
				{
					alert("인증키가 올바르지 않습니다.");
				}
			}
			if($site->cfg_mail_bit == 1){
				$email 			= $this->input->post('email');
				$mailcode 		= $this->input->post('mailcode');
				
				$save_authcode = $this->M_member->get_email_authcode($email);
				if($save_authcode != $mailcode)
				{
					alert("The authentication key is incorrect.");
				}
			}
			*/
			$address 	= $this->input->post('address');
			$wallet_no 	= $this->input->post('wallet_no');
			
			if($wallet->wallet != $address)
			{
				$type = 'exchange';
				$addr = $this->input->post('address');
			
				$qrimg_id = $login_id .'_E'; // ico qrcode
				qrcode($qrimg_id,$addr);
			
				$qrimg = $login_id ."_E.png"; // ico qrcode
			
				$query = array(
					'wallet' 		=> $address,
					'qrcode' 		=> $qrimg,
				);
				$this->db->where('wallet_no', $wallet_no);
				$this->db->update('m_wallet', $query);
			
				//$this->M_coin->set_wallet_in($login_id,$addr,$qrimg,$type);
				
			}
				
			
			//-------------------------------------------------------------------------------------------------------------------------------//
			
			alert("Edit a Wallet address", "token/exchange");
		}

	}

}