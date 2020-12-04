<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('file','form', 'url','search'));
		$this->load->library('form_validation');

		//$this->load->library('Elwallet_api');
		//$this->load->library('SmsLib');
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
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;		
		/*-----------------------------------------------------------------------------
			---------------------------------------------------------------------------*/
		
		$this->form_validation->set_rules('rev_id', 'rev_id', 'required'); // 코인주소
		$this->form_validation->set_rules('count', 'count', 'required');		
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('coin/send',$data,'office');

		} else {
		
			$lang = get_cookie('lang');
			/*
			$mb = $this->M_member->get_member($login_id);
			
			$password = $this->input->post('password');
			if($password != $mb->secret)
			{
				alert(" Check! Trans Password");				
			}
			*/
			$country 	= $this->input->post('country');
			$authcode 	= $this->input->post('authcode');
			$mobile 	= $this->input->post('mobile');				
			$mobile 	= preg_replace("/\s+/","",$mobile);
					
			$chk_mobile = $country .$mobile;
			$save_authcode = $this->M_member->get_sms_authcode($chk_mobile);
			if($save_authcode != $authcode)
			{
				alert("인증문자가 틀립니다.");
			}
			//---------------------------------------------------------------------------------//
			// 보내고 받는사람이 
			
			//코인의 경우 소량의 다량이체를 공격을 방지하기 위해 수수료가 발생한다. 이를 위해 잔액에 추가함
			$count 		= $this->input->post('count');
			$fee 		= $this->input->post('fee');
			$amount 	= $this->input->post('amount');
			
			$balance = $bal->coin;
			
			$lang = get_cookie('lang');
			
			//예외 처리
			if ($balance <= 0) {	
				if ($lang == "kr") {
					alert("AGC 잔액을 확인해주세요");
				}
				else{
					alert("Please check your AGC balance.");					
				}
			}
			else if ($count <= 0) {	
				if ($lang == "kr") {
					alert("보내실 AGC 수량을 확인해주세요");
				}
				else{
					alert("Please check your AGC quantity");					
				}
			}
			
			if ($balance < $count) {
				if ($lang == "us" or $lang == "") {
				}		
				if ($lang == "kr") {
					alert("AGC 잔액이 부족합니다. 수수료포함 잔액체크");
				}
				else{
					alert("Your AGC balance is low. Check balance including commission");					
				}
			}
			
			//-------------------------------------------------------------------------------------------------------------------------------//
			// 주소가 맞는지 검증하는 부분 - 차후에 이더주소 검증부분 만들기
			$order_code = order_code();  // 주문코드 만들기
			
			// 공백제거
			$send_id 		= $login_id; 				// 보내는 사람아이디
			$send_wallet 	= $data['wallet']; 			// 보내는 사람 지갑주소			
			$rev_wallet 	= trim($this->input->post('rev_id')); 	// 받는사람 지갑주소
			
			$rev = $this->M_coin->get_wallet_addr($rev_wallet); // 주소로 받는사람 정보가져오기
			if($rev)
			{
				$rev_id = trim($rev->member_id);
				$revBal 	= $this->M_coin->get_balance($sned->member_no);
					
				$type 		= "coin";
				$send 		= $revBal->coin + $amount;
				$this->M_point->balance_inout_id($rev_id,$type,$send);
				//---------------------------------------------------------------------------------------------------------------------//
				$isvalid = 'move';
				$move = $this->bitcoin->move($send_id, $rev_id, $amount); // 보내는 사람아이디, 받는사람, 수량
				$this->M_coin->coin_in($order_code, $rev_id,$rev_wallet, $send_id,$send_wallet, $amount, $fee, $count, 'coin', 'agc',$isvalid);										
			}
			// 지갑주소가 없으면 외부주소이다.
			else
			{
				$send = $this->bitcoin->sendfrom($send_id, $rev_wallet, $amount);
				
				$rev_id = 'out_id';
				$isvalid = 'out';
				$this->M_coin->coin_in($order_code, 'out',$rev_wallet, $send_id,$send_wallet, $amount, $fee, $count, 'coin', 'agc',$isvalid);			
			}	
        
			//=============================================================//이자->받은자가 지급함
			$fee_id 	= 'master_rev';
			$fee_wallet = 'mTYnVwv2AwAdm73DQKsejASBxD52sGD13D';
			$fBal 		= $this->M_coin->get_balance_id($fee_id);
        
			$type 		= "coin";
        	$fee 		= $fBal->coin + $fee;
			$this->M_point->balance_inout_id($fee_id,$type,$fee);
        
			$isvalid = 'move';
			$move = $this->bitcoin->move($send_id, $fee_id, $fee); // 보내는 사람아이디, 받는사람, 수량
			$this->M_coin->coin_in($order_code, $fee_id, $fee_wallet, $send_id,$send_wallet, $fee, 0, $fee, 'coin', 'fee', $count, $isvalid);
			//=============================================================================================================================================================//
			
			$type 		= "coin";
			$coin 	= $bal->coin - $count;
			$this->M_point->balance_inout_id($send_id,$type,$coin);
			
			//-------------------------------------------------------------------------------------------------------------------------------//
			redirect('/coin/send/sendok/' .$amount .'/' .$count .'/' .$fee .'/' .$rev_wallet  .'/' .$rev_id);
		}

	}


	// 보낸 결과값 보여주기
	public function sendok()
	{
		$data = array();
		$data['site'] = $this->M_cfg->get_site();
		
		$data['count'] 		= $this->uri->segment(4,0);
		$data['send_count'] = $this->uri->segment(5,0);
		$data['fee'] 		= $this->uri->segment(6,0);	
		$data['rev_wallet'] = $this->uri->segment(7,0);	
		$data['rev_id'] 	= $this->uri->segment(8,0);	
		
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');
	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'agc');
		//---------------------------------------------------------------------------------//		
		$data['bal'] = $this->M_coin->get_balance($member_no);
		//---------------------------------------------------------------------------------//
			
		$lang = get_cookie('lang');
		layout('coin/send_ok',$data,'office');

	}
	
	
	// 코인 전송내역 트랜스퍼 기록
	public function lists()
	{
		$data = array();
		$data['site'] = $this->M_cfg->get_site();

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'agc');
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------//
		
		$data['send'] = $this->M_coin->get_coin_mb_send($login_id);
		
		//$data['rev'] = $this->M_coin->get_coin_mb_rev($login_id);
		
		//---------------------------------------------------------------------------------//		
		//리스트
		$data = page_lists('m_coin','coin_no',$data,'member_id',$login_id);		
		//$data['item'] = (array)$this->bitcoin->listtransactions($mb->coin_id);
	
		//---------------------------------------------------------------------------------//
		
		$lang = get_cookie('lang');
		layout('coin/send_list',$data,'office');

	}
		
}