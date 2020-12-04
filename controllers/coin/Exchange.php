<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exchange extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('file','form', 'url','search'));
		$this->load->library('form_validation');

		//$this->load->library('Elwallet_api');
		$this->load->library('SmsLib');
		$this->load->library('urlapi');		
		$this->load->library('bitcoin');
		$this->load->library('qrcode');

		//모델 로드
		$this->load->model('M_cfg');
		$this->load->model('M_admin');
		$this->load->model('M_point');
		$this->load->model('M_coin');
		$this->load->model('M_member');

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
		$data['site'] = $this->M_cfg->get_site();

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'agc');
		$data['hvrex'] = $this->M_coin->get_wallet_address($login_id,'hvrex');
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		/*-----------------------------------------------------------------------------
			---------------------------------------------------------------------------*/
		
		$this->form_validation->set_rules('count', 'count', 'required');		
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('coin/exchange',$data,'office');

		} else {
		
			$lang = get_cookie('lang');
			
			$country 	= $this->input->post('country');
			$authcode 	= $this->input->post('authcode');
			$mobile 	= $this->input->post('mobile');				
			$mobile 	= preg_replace("/\s+/","",$mobile);
					
			$chk_mobile = $country .$mobile;
			$save_authcode = $this->M_member->get_sms_authcode($chk_mobile);
			if($save_authcode != $authcode)
			{
				//alert("인증문자가 틀립니다.");
			}
			//---------------------------------------------------------------------------------//
			// 보내고 받는사람이 
			
			//코인의 경우 소량의 다량이체를 공격을 방지하기 위해 수수료가 발생한다. 이를 위해 잔액에 추가함
			$count 		= $this->input->post('count');
			
			$balance = $bal->hvrex;
			
			$lang = get_cookie('lang');
			
			//예외 처리
			if ($balance <= 0) {	
				if ($lang == "kr") {
					alert("Hcoin 잔액을 확인해주세요");
				}
				else{
					alert("Please check your Hcoin balance.");					
				}
			}
			else if ($count <= 0) {	
				if ($lang == "kr") {
					alert("교환하실 Hcoin 수량을 확인해주세요");
				}
				else{
					alert("Please check your Hcoin quantity");					
				}
			}
			
			if ($balance < $count) {
				if ($lang == "us" or $lang == "") {
				}		
				if ($lang == "kr") {
					alert("Hcoin 잔액이 부족합니다. 수수료포함 잔액체크");
				}
				else{
					alert("Your Hcoin balance is low. Check balance including commission");					
				}
			}
			
			//-------------------------------------------------------------------------------------------------------------------------------//
			// 주소가 맞는지 검증하는 부분 - 차후에 이더주소 검증부분 만들기
			$order_code = order_code();  // 주문코드 만들기
			$isvalid = 'exchange';
			$this->M_coin->coin_in($order_code, $login_id,$data['wallet'], $login_id,$data['hvrex'], $count, 0, $count, 'hvrex', 'exc',$isvalid);
			
			$coin 	= $bal->coin + $count;
			$hvrex 	= $bal->hvrex - $count;
			$hvc 	= $bal->hvc + $count;
			
			$query = array(
				'coin' => $coin,
				'hvrex' => $hvrex,
				'hvc' => $hvc,
			);      
			$this->db->where('member_id', $login_id);
			$this->db->update('m_balance', $query);
			
			//-------------------------------------------------------------------------------------------------------------------------------//
			redirect('/coin/exchange/exchangeok/' .$count);
		}

	}

	// 보낸 결과값 보여주기
	public function exchangeok()
	{
		$data = array();
		$data['site'] = $this->M_cfg->get_site();
		
		$data['count'] 		= $this->uri->segment(4,0);
		
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');
	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'agc');
		$data['hvrex'] = $this->M_coin->get_wallet_address($login_id,'hvrex');
		//---------------------------------------------------------------------------------//		
		$data['bal'] = $this->M_coin->get_balance($member_no);
		//---------------------------------------------------------------------------------//
			
		$lang = get_cookie('lang');
		layout('coin/exchange_ok',$data,'office');

	}
		
}