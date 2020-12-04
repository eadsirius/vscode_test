<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qrcode extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('file','form', 'url','search'));
		$this->load->library('form_validation');
		
		$this->load->library('Elwallet_api');		

		//모델 로드
		$this->load->model('M_cfg');
		$this->load->model('M_point');
		$this -> load -> model('M_coin');
		$this -> load -> model('M_admin');
		$this -> load -> model('M_member');

		loginCheck();
		
	}
	
	function _remap($method)
	{	
		$data = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'OFFICE');
		$data['site'] = $this->M_cfg->get_site();
		$data['active'] = "mu2";

		$address   = $this->uri->segment(3,0);
		
		$chk = explode('-', $address);
		if($chk[0] == 'R'){
			$data['addr'] 	= $chk[0]; 
		}
		
		//$data['addr'] 	= $address; 
		
		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet($login_id);
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		
		/*-----------------------------------------------------------------------------
			---------------------------------------------------------------------------*/
		
		$this->form_validation->set_rules('rev_id', 'rev_id', 'required'); // 코인주소
		$this->form_validation->set_rules('count', 'count', 'required');		
		
		if ($this->form_validation->run() == FALSE)
		{
			$lang = get_cookie('lang');

			if ($lang == "kr") {
				layout('token/send_kr',$data,'office');	
			}
			else{
				layout('token/send',$data,'office');
			}

		} else {
			
			$password = $this->input->post('password');
			if($password != $data['mb']->secret){
				alert(" Check! Trans Password");				
			}
			
			//코인의 경우 소량의 다량이체를 공격을 방지하기 위해 수수료가 발생한다. 이를 위해 잔액에 추가함
			$count 		= $this->input->post('count');
			$fee 		= $this->input->post('fee');
			$amount 	= $this->input->post('amount');
			
			$balance = $bal->ucetoken;
			
			$lang = get_cookie('lang');
			
			//예외 처리
			if ($balance <= 0) {	
				if ($lang == "kr") {
					alert("UCEToken 잔액을 확인해주세요");
				}
				else{
					alert("Please check your UCEToken balance.");					
				}
			}
			else if ($count <= 0) {	
				if ($lang == "kr") {
					alert("보내실 UCEToken 수량을 확인해주세요");
				}
				else{
					alert("Please check your UCEToken quantity");					
				}
			}
			
			if ($balance < $count) {
				if ($lang == "us" or $lang == "") {
				}		
				if ($lang == "kr") {
					alert("UCEToken 잔액이 부족합니다. 수수료포함 잔액체크");
				}
				else{
					alert("Your UCEToken balance is low. Check balance including commission");					
				}
			}
			
			//-------------------------------------------------------------------------------------------------------------------------------//
			// 주소가 맞는지 검증하는 부분 - 차후에 이더주소 검증부분 만들기
			$order_code = order_code();  // 주문코드 만들기
			
			// 공백제거
			$send_id 		= $login_id; 				// 보내는 사람아이디
			$send_wallet 	= $data['wallet']->wallet; 	// 보내는 사람 지갑주소			
			$rev_wallet 	= trim($this->input->post('rev_id')); 	// 받는사람 지갑주소
			
			$rev = $this->M_coin->get_wallet_addr($rev_wallet); // 주소로 받는사람 정보가져오기
			if($rev)
			{
				$rev_id = trim($rev->member_id);
				$send_ck = $this->M_coin->get_wallet_useraddr($rev_id, $rev_wallet); // 주소로 받는사람 정보가져오기
				
				// 지갑주소가 없으면 외부주소이다.
				if($send_ck){
					$isvalid = 'move';
					$this->M_coin->coin_in($order_code, $rev_id,$rev_wallet, $send_id,$send_wallet, $amount, $count, $fee, 'uce',$isvalid);						
				}
				else{
					$rev_id = 'out';
					$isvalid = 'out';
					$this->M_coin->coin_in($order_code, 'out',$rev_wallet, $send_id,$send_wallet, $amount, $count, $fee, 'uce',$isvalid);			
				}
			}
			else
			{	
				if ($lang == "kr") {
					alert("외부출금 준비중");
				}
				else{
					alert("Preparing for external withdrawal system");					
				}					
			}
			
			//-------------------------------------------------------------------------------------------------------------------------------//
			redirect('/token/send/sendok/' .$count .'/' .$send_count .'/' .$fee .'/' .$rev_wallet  .'/' .$rev_id);
			//$this->sendok();
			//layout('send_ok',$data,'coin');
		}

	}
	
}