<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Withdraw extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form','url','admin','search','office'));
		
		$this->load->library('form_validation');		
		$this->load->library('Elwallet_api');
		$this->load->library('urlapi');	
		//$this->load->library('GoogleAuthenticator');
		//$this->load->library('bitcoin');	
		//$this -> load -> model('m_coin');	
			
		//model load
		$this->load-> model('M_member');
		$this->load-> model('M_admin');
		$this->load-> model('M_cfg');
		$this->load-> model('M_office');
		$this->load-> model('M_point');
		$this->load-> model('M_coin');
		
		// 미 로그인 상태라면
		loginCheck();
		// 2020.07.22 박종훈 추가
		if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {
			$this->output->enable_profiler($this->config->item('profiler'));
		}
	}
	
	public function index()
	{

		$this->out();
		
	}

	public function out()
	{
	
		$data = $member = array();
		$data['header'] = array('title'=>'나의구좌','group'=>'POINT');
		$site = $this->M_cfg->get_site();
		$data['site'] = $site;
		$data['active'] = "mu5";
		
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_member->get_member($login_id);
		//---------------------------------------------------------------------------------//
		$wallet_chk = $this->M_coin->get_wallet_chk($login_id,'exchange');
		if(empty($wallet_chk)){
            alert("거래소 지갑주소를 등록하세요", 'token/exchange');			
		}
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'exchange');
			//---------------------------------------------------------------------------------//
		// 내부 지갑 주소로 전송 안되게 변경 20200811 jjh
		
		$wallet_ex = $data['wallet'];

		$wallet_du = $this->M_coin->get_wallet_du($wallet_ex,'wns');


		if ($wallet_du->cnt > 0) {
			alert('출금지갑 주소는 MOCA[내부]로 할 수 없습니다. \n 외부지갑 주소를 새로 등록해 주세요.', 'office/withdraw');
		}

		//---------------------------------------------------------------------------------//
		$bal = $this->M_coin->getBalanceList($member_no,$login_id);

		$data['bal'] = $bal;
		//---------------------------------------------------------------------------------//
		
		$data['fee'] = $site->cfg_send_persent;
		//---------------------------------------------------------------------------------//		
		//---------------------------------------------------------------------------------//
		layout('office/withdraw',$data,'office');			
		
	}


	public function exchange()
	{
		
		$data = $member 	= array();
		$data['header'] 	= array('title'=>'나의구좌','group'=>'PLAN');
		$site 				= $this->M_cfg->get_site();
		$data['site'] 		= $site;
		$data['active'] 	= "mu5";
		
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');


		$today_out = $this->M_point->get_today_out('m_point_out',$login_id, 'out');
		$date['today_data'] = $today_out;
		if ($today_out->today_out > 0) {
			alert("출금 신청은 하루에 한번만 가능합니다.", 'office/withdraw');
		}

		if($this->input->post('confing') == ''){
			alert(get_msg($this ->lang, '출금 인증방식을 선택하세요'));			
		}
		$conf 			= $this->input->post('confing');
		$data['conf'] 	= $conf;
		
		
		$fee 				= $site->cfg_send_persent;
		$data['fee'] 		= $fee;
		$data['fee_view'] 	= $fee * 100;

	
		
		$data['mb'] 		= $this->M_member->get_member($login_id);
		//---------------------------------------------------------------------------------//
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'exchange');
		//---------------------------------------------------------------------------------//
		// 내부 지갑 주소로 전송 안되게 변경 20200811 jjh
		
		$wallet_ex = $data['wallet'];

		$wallet_du = $this->M_coin->get_wallet_du($wallet_ex,'wns');


		if ($wallet_du->cnt > 0) {
			alert('출금지갑 주소는 MOCA[내부]로 할 수 없습니다. \n 외부지갑 주소를 새로 등록해 주세요.', 'office/withdraw');
		}
		//---------------------------------------------------------------------------------//
		$bal = $this->M_coin->getBalanceList($member_no,$login_id);
		$data['bal'] = $bal;
		//---------------------------------------------------------------------------------//
		$data['fee'] = $site->cfg_send_persent;
		$data['country'] = $this->M_member->get_country_li();
		/*---------------------------------------------------------------------------------//
		// 거래소 시세가져오기 -> https://www.idcm.asia/
		//---------------------------------------------------------------------------------//
		// 달러 시세 가져오기
		$service_url 	= 'https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD';
		$getprice 		= $this->urlapi->get_api($service_url);
		$price_array 	= json_decode($getprice, true);    
		$price 			= $price_array[0]['basePrice'];
		$data['usd'] 	= $price; 
		//---------------------------------------------------------------------------------//
		$sell = get_usd();
		$usd = $sell;
		$won = $sell * $price;
		$data['USNS_USD'] = $usd;
		$data['USNS_WON'] = $won;
		*/
		$data['USNS_USD'] = $site->cfg_usd;
		$data['USNS_WON'] = $site->cfg_won;
		$cfg_no = 1;		
		/*
		$query = array(
			'cfg_usd' 	=> $usd,
			'cfg_won' 	=> $won,
		);
*/
	//$this->db->where('cfg_no', $cfg_no);
	//	$this->db->update('m_site', $query);
		
		//---------------------------------------------------------------------------------//
		
		layout('office/withdraw_send',$data,'office');			

	}


	public function send()
	{
		$data = $member 	= array();
		$data['header'] 	= array('title'=>'나의구좌','group'=>'PLAN');
		
		$site = $this->M_cfg->get_site();
		$data['site'] = $site;

		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');

	

		
		//---------------------------------------------------------------------------------//
		$wallet = $this->M_coin->get_wallet_address($login_id,'exchange');
		//---------------------------------------------------------------------------------//
		$bal = $this->M_coin->getBalanceList($member_no,$login_id);
			$bal_Withdraw = $bal->total_point - $bal->withdraw_point;
		//---------------------------------------------------------------------------------//
		$fee = $site->cfg_send_persent;
		//---------------------------------------------------------------------------------//
			
			$confing 	= trim($this->input->post('confing'));
			$password 	= trim($this->input->post('password'));
			$address 	= trim($this->input->post('address'));
			
			$count 		= trim($this->input->post('count'));
			$fee 		= trim($this->input->post('fee'));
			$amount 	= trim($this->input->post('amount'));
			$limit 		= trim($this->input->post('limit'));
		  
			// 활동 중지상태-----------------------------------------------------------------------//
			$member 	= $this->M_member->get_member($login_id); 			// 회원정보
				$member_country 	= $member->country;
				$member_open		= $member->is_close; // 활동정지 여부	
				$member_send		= $member->type; 	// 보내기 가능	
				
			//if($member_open == 1){alert(get_msg($this ->lang, '활동 중지상태 입니다.'));}	
			// 락걸기-----------------------------------------------------------------------//
			$date = date("Y-m-d");
			$get_out_amount = $this->M_point->get_point_out_amount($date, $login_id);
//			if($count+$get_out_amount->saved_point > 60000){
//				alert(get_msg($this ->lang, '하루에 보낼 수 있는 최대 출금액은 60,000 POINT 입니다.'), 'office/withdraw');	
//			}
			if($confing == 'p'){
				if($member->secret != $password){
					alert(get_msg($this->lang, '이체비밀번호를 확인하세요'), 'office/withdraw');				
				}
			}
			else{
				$codeValue 	= $this->input->post('codeValue');
				$Gotp 		= $this->input->post('Gotp');
				if($codeValue != $Gotp)
				{
					alert(get_msg($this ->lang, '인증 키가 잘못되었다.'), 'office/withdraw');	
				}		
			}
			
			//----------------------------------------------------------------------------//			
			$order_code = order_code();  // 주문코드 만들기	
			$regdate 	= nowdate();
			//----------------------------------------------------------------------------//
			//----------------------------------------------------------------------------//
			
			$send_fee = $count * $fee;
			$send_count = $count - $send_fee;
			
			if($count < $site->cfg_send_point){
				alert(get_msg($this ->lang, '최소 출금 POINT를 확인하세요'), 'office/withdraw');
			}	
		
			if($count > $bal_Withdraw){
				alert(get_msg($this ->lang, '인출 잔액 확인'), 'office/withdraw');	
			}
			
			$type 		= "point_out";
			$point 		= $bal->point_out + $send_count;
			$this->M_point->balance_inout($member_no,$type,$point); // 매출금액
			
			$type 		= "point_fee";
			$point 		= $bal->point_fee + $send_fee;
			$this->M_point->balance_inout($member_no,$type,$point); // 매출금액
			//--------------------------------------------------------------------------------//
      
			$table = 'm_point_out';
			$this->M_point->pay_out($table, $order_code, $point, $login_id, $address, $amount, $count, $send_fee, 'out','request',$fee);	

			//--------------------------------------------------------------------------------//

			redirect('/office/withdraw/exok/' .$count ."/" .$send_fee ."/" .$amount ."/" .$fee);

	}
	
	
	// 보낸 결과값 보여주기
	public function exok()
	{
		$data = array();
		$data['header'] = array('title'=>'나의구좌','group'=>'POINT');
		$site 			= $this->M_cfg->get_site();
		$data['site'] 	= $site;
		$data['active'] = "mu5";
		
		$login_id 		= $this->session->userdata('member_id');
		$member_no 		= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['bal'] 	= $this->M_coin->get_balance($member_no);
		
		$data['send_count'] 	= $this->uri->segment(4,0);
		$data['send_fee'] 		= $this->uri->segment(5,0);
		$data['send_amount'] 	= $this->uri->segment(6,0);
		$data['fee'] 			= $this->uri->segment(7,0);
		
		//---------------------------------------------------------------------------------//
		$lang = get_cookie('lang');

		layout('/office/pointOut_exOk',$data,'office');

	}

	public function lists()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'나의구좌','group'=>'POINT');
		
		$site = $this->M_cfg->get_site();
		$data['site'] = $site;
		
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_member->get_member($login_id);
		//---------------------------------------------------------------------------------//		
		$data['sum']	=	$this->M_coin->getWithdrawCnt($login_id);
		//---------------------------------------------------------------------------------//	
		$data = page_lists('m_point_out','point_no',$data,'member_id',$login_id,'cate','out');
		//---------------------------------------------------------------------------------//
		layout('office/withdraw_list',$data,'office');			
		
	}
}