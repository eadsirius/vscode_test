<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('file','form', 'url','search'));
		$this->load->library('form_validation');
		
		//$this->load->library('Elwallet_api');
		$this->load->library('urlapi');		
		$this->load->library('bitcoin');
		$this->load->library('qrcode');

		//모델 로드
		$this -> load -> model('M_admin');
		$this -> load -> model('M_cfg');
		$this -> load -> model('M_member');
		$this -> load -> model('M_office');
		$this -> load -> model('M_point');
		$this -> load -> model('M_coin');
		
		// 미 로그인 상태라면
		loginCheck();
		// 2020.07.22 박종훈 추가
		if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {
			$this->output->enable_profiler($this->config->item('profiler'));
		}
	}
	
	public function index()
	{	
		$data = $member = array();
		$site 			= $this->M_cfg->get_site();
		$data['site'] 	= $site;

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$total_balance 	= $this->M_coin->getBalanceList($member_no,$login_id);
    $data['mb'] = $total_balance;
    
    if(!empty($total_balance)){
      if($total_balance->active_point > 0){
        $data['total_percent'] = $total_balance->active_total_point/($total_balance->active_point*2)*100;
        $data['daily_percent'] = $total_balance->active_daily_point/($total_balance->active_point*2)*100;
        $data['mc_percent'] = $total_balance->active_mc_point/($total_balance->active_point*2)*100;
        $data['re_percent'] = $total_balance->active_re_point/($total_balance->active_point*2)*100;
      }else{
        $data['total_percent'] = 0;
        $data['daily_percent'] = 0;
        $data['mc_percent'] = 0;
        $data['re_percent'] = 0;
      }
    }else{
      $data['total_percent'] = 0;
      $data['daily_percent'] = 0;
      $data['mc_percent'] = 0;
      $data['re_percent'] = 0;
    }
		//---------------------------------------------------------------------------------//	
		
		layout('office/purchase',$data,'office');		
		
	}
	
	public function purchase_send()
	{
		$data = $member = array();
		$site 			= $this->M_cfg->get_site();
		$data['site'] 	= $site;
		
		$level = $this->uri->segment(4,0);
		//---------------------------------------------------------------------------------//		
		
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_member->get_member($login_id);
		
		if($data['mb']->secret == '123456'){
            alert("전송비밀번호를 먼저 추가(수정) 하시길 바랍니다.", 'member/profile');			
		}
		
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'wns');
		//---------------------------------------------------------------------------------//		
		$bal = $this->M_coin->get_balance($member_no);	
		$data['bal'] = $bal;
				
		$data['country'] = $this->M_member->get_country_li();
		
		//---------------------------------------------------------------------------------//
		$lang = get_cookie('lang');		
		//---------------------------------------------------------------------------------//

		if($level == 1)
		{

			$thing 			= $site->cfg_lv1_name;
			$amount_start 	= $site->cfg_lv1_purchase;
			$amount_end 	= $site->cfg_lv1_point;
			$su_day	 		= $site->cfg_lv1_day;
			$su_re1	 		= $site->cfg_lv1_re;
			$su_re2	 		= $site->cfg_lv1_re1;
		}
		else if($level == 2)
		{
			$thing 			= $site->cfg_lv2_name;
			$amount_start 	= $site->cfg_lv2_purchase;
			$amount_end 	= $site->cfg_lv2_point;
			$su_day	 		= $site->cfg_lv2_day;
			$su_re1	 		= $site->cfg_lv2_re;
			$su_re2	 		= $site->cfg_lv2_re1;
		}
		else{
			alert("The amount is less than the purchase amount.");			
		}
				
		$data['thing'] 				= $thing;
		$data['purchase_start'] 	= $amount_start;
		$data['purchase_end'] 		= $amount_end;
		$data['level'] 				= $level;
		$data['su_day'] 			= $su_day;
		$data['su_re1'] 			= $su_re1;
		$data['su_re2'] 			= $su_re2;
		
		
	
		
		$today_data = $this->M_point->get_today_data('m_point',$login_id, 'purchase');
		$date['today_data'] = $today_data;
		/*
		if ($today_data->today_data > 0) {
			alert("매출은 하루에 한번만 가능합니다.", 'office/purchase');
		}
		*/

		//---------------------------------------------------------------------------------------------------//
		/*
		// 달러 시세 가져오기
		$service_url 	= 'https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD';
		$getprice 		= $this->urlapi->get_api($service_url);
		$price_array 	= json_decode($getprice, true);    
		$price 			= $price_array[0]['basePrice'];
		$data['usd'] 	= $price;
		$price 	= 1200;
		$data['usd'] = $price;
		*/
			
		//---------------------------------------------------------------------------------------------------//
		/*
		// 바이낸스거래소에서 비트코인 시세 가져오기
		$url = 'https://api.binance.com/api/v1/depth?symbol=BTCUSDT';
		$json_string = file_get_contents($url);
		$R = new RecursiveIteratorIterator(
			new RecursiveArrayIterator(json_decode($json_string, TRUE)),
			RecursiveIteratorIterator::SELF_FIRST);
			
		$i = 0;
		foreach ($R as $key=>$val) {
			if(is_array($val)) 
			{ 	// val 이 배열이면
        		//echo "$key:<br/>";
				//echo $key.' (key), value : (array)<br />';
    		} 
    		else 
    		{ 	// 배열이 아니면
	    		$i +=1;
				if($i == 2)
				{
					$usd = $val * 0.02;
					$usd = $val - $usd;
					$won = $val * $price;
					
					$query = array(
						'cfg_usd' 			=> $usd,
						'cfg_won' 			=> $won,
					);
					$this->db->where('cfg_no', $cfg_no);
					$this->db->update('m_site', $query);		    	
	    		}
    		}
		}
		*/
		//---------------------------------------------------------------------------------------------------//
		$site 			= $this->M_cfg->get_site();
$data['cash'] = $site->cfg_won; 
		//$data['cash'] = get_usd(); // 원화시세
		
		//---------------------------------------------------------------------------------------------------//	
		
		layout('office/purchase_send',$data,'office');		
	}

	
	public function purchase_ok()
	{
		$data = $member = array();	
		$site 			= $this->M_cfg->get_site();

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
			
		if($login_id == 'admin'){				
			alert("관리자는 매출등록을 할 수 없습니다");
		}
		
		$mb 		= $this->M_member->get_member($login_id);
		$wallet 	= $this->M_coin->get_wallet_address($login_id,'wns');
		$bal 		= $this->M_coin->get_balance($member_no);		
		//---------------------------------------------------------------------------------//		
		$lang = get_cookie('lang');
		//---------------------------------------------------------------------------------//
		$this->form_validation->set_rules('count', 'count', 'required');		
		
		if ($this->form_validation->run() == FALSE)
		{
            alert("Point Checked");	
		}
		else 
		{
			$cash 	= trim($this->input->post('cash'));		// 거래소 시세
			$level 	= trim($this->input->post('level')); 	// 업그레이드 레벨	
			$count 	= trim($this->input->post('count'));	// 매출코인수량
			//$amount = trim($this->input->post('amount'));
			
			if($level == 1)
			{
				$thing 			= $site->cfg_lv1_name;
				$amount_start 	= $site->cfg_lv1_purchase;
				$amount_end 	= $site->cfg_lv1_point;
				$su_day	 		= $site->cfg_lv1_day;
				$su_re1	 		= $site->cfg_lv1_re;
				$su_re2	 		= $site->cfg_lv1_re1;
			}
			else if($level == 2)
			{
				$thing 			= $site->cfg_lv2_name;
				$amount_start 	= $site->cfg_lv2_purchase;
				$amount_end 	= $site->cfg_lv2_point;
				$su_day	 		= $site->cfg_lv2_day;
				$su_re1	 		= $site->cfg_lv2_re;
				$su_re2	 		= $site->cfg_lv2_re1;
			}
			else{
				alert("$level - The amount is less than the purchase amount.", 'office/purchase');			
			}
			
			if($count < $amount_start){
				alert("레벨 범위 매출P 확인 해주세요", 'office/purchase');
			}
			if($count > $amount_end){
				alert("레벨 범위 매출P 확인 해주세요", 'office/purchase');
			}
			//---------------------------------------------------------------------------------//
			/*
			if ($this->input->post('password') != $mb->secret) {

				//alert(get_msg($lang, '전송 비밀번호를 확인해주세요. '));
			}
			
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
			*/
			
			if($bal->point < $count){
            	alert("P 확인 해주세요", 'office/purchase');				
			}
			
			//---------------------------------------------------------------------------------//
			
			$order_code = order_code();  // 주문코드 만들기
			$db_table 	= 'm_point_su';
			$isvalid 	= 'purchase';
			//---------------------------------------------------------------------------------//
            // 발란스 수정		
            $bal 	= $this->M_coin->get_balance($member_no);
			
            $type 		= "level";
            $this->M_point->balance_inout($member_no,$type,$level);
			
            $type 		= "purchase";
            $this->M_point->balance_inout($member_no,$type,$thing);
		
			$type 		= "purchase_cnt";
			$purchase_cnt 	= $bal->purchase_cnt + 1;
			$this->M_point->balance_inout($member_no,$type,$purchase_cnt);
            
            $type 		= "point";
            $point 		= $bal->point - $count;
            $this->M_point->balance_inout($member_no,$type,$point);
                
            $type 		= "volume";
            $volume 	= $bal->volume + $count;
            $this->M_point->balance_inout($member_no,$type,$volume);
					 
						$type 		= "volume1";
            $volume1 	= $bal->volume1 + $count;
						$this->M_point->balance_inout($member_no,$type,$volume1);
						
						if(($bal->basic_amount) == 0) {
							$type 		      = "basic_amount";
							$basic_amount 	= $count;
							$this->M_point->balance_inout($member_no,$type,$basic_amount);
						}

			//---------------------------------------------------------------------------------//
			//---------------------------------------------------------------------------------//
			$msg 		= $site->cfg_won; // 시세기록하기
			$regdate 	= nowdate();
			$app_date = date("Y-m-d 23:59:59", strtotime($regdate."+3month"));
			
			$in_table 	= 'm_point';
			$this->M_point->pay_puchase($in_table, $order_code, $mb->country, $mb->office, $login_id, $count, $count, 'purchase', 'complete', $level, $msg,$regdate,$app_date);
			//----------------------------------------------------------------------------------------------------------------------------------------------------------//
			//----------------------------------------------------------------------------------------------------------------------------------------------------------//
		}
			
		redirect('/office/purchase/result/' .$count .'/' .$cash .'/' .$level);
	}
		
	public function result()
	{
		$data = array();
		$site 				= $this->M_cfg->get_site();
		$data['site'] 		= $site;
		//------------------------------------------------------------------------------------
		
		$data['count'] 		= $this->uri->segment(4,0);
		$data['cash'] 		= $this->uri->segment(5,0);
		$level 				= $this->uri->segment(6,0);
		$data['level'] 		= $level;
		//------------------------------------------------------------------------------------

		if($level == 1)
		{
			$thing 			= $site->cfg_lv1_name;
			$amount_start 	= $site->cfg_lv1_purchase;
			$amount_end 	= $site->cfg_lv1_point;
			$su_day	 		= $site->cfg_lv1_day;
			$su_re1	 		= $site->cfg_lv1_re;
			$su_re2	 		= $site->cfg_lv1_re1;
		}
		else if($level == 2)
		{
			$thing 			= $site->cfg_lv2_name;
			$amount_start 	= $site->cfg_lv2_purchase;
			$amount_end 	= $site->cfg_lv2_point;
			$su_day	 		= $site->cfg_lv2_day;
			$su_re1	 		= $site->cfg_lv2_re;
			$su_re2	 		= $site->cfg_lv2_re1;
		}
		else{
			alert("The amount is less than the purchase amount.", 'office/purchase');			
		}
			
		$data['thing'] 		= $thing;
		//---------------------------------------------------------------------------------//
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_member->get_member($login_id);
		//---------------------------------------------------------------------------------//		
		$bal = $this->M_coin->get_balance($member_no);		
		$data['bal'] = $bal;
		//---------------------------------------------------------------------------------//
		$wallet 	= $this->M_coin->get_wallet_address($login_id,'wns');
				
		//---------------------------------------------------------------------------------//
		
		$lang = get_cookie('lang');
		layout('/office/purchase_ok',$data,'office');

	}
	
	public function svp()
	{
		if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {
			$this->output->enable_profiler($this->config->item('profiler'));
		}
		$data = $member = array();
		$site 			= $this->M_cfg->get_site();
		$data['site'] 	= $site;
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	



		//---------------------------------------------------------------------------------//		
		

		$today_data = $this->M_point->get_today_data('m_point',$login_id, 'repurchase');
		$date['today_data'] = $today_data;
		if ($today_data->today_data > 0) {
			alert("매출은 하루에 한번만 가능합니다.", 'office/purchase');
		}
	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_member->get_member($login_id);
		
		if($data['mb']->secret == '123456'){
            alert("전송비밀번호를 먼저 추가(수정) 하시길 바랍니다.", 'member/profile');			
		}
		
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'wns');
		//---------------------------------------------------------------------------------//		
		$bal = $this->M_coin->get_balance($member_no);	
		$data['bal'] = $bal;
			$data['bal_Withdraw'] = $bal->total_point - ($bal->release_point + $bal->loan + $bal->point_out + $bal->point_fee);
				
		$data['country'] = $this->M_member->get_country_li();




		//---------------------------------------------------------------------------------//
		$lang = get_cookie('lang');
		//---------------------------------------------------------------------------------//
		//---------------------------------------------------------------------------------//
		//$data['cash'] = get_usd(); // 원화시세
		$site 			= $this->M_cfg->get_site();
		$data['cash'] = $site->cfg_won; 

		//---------------------------------------------------------------------------------//
		// 적립한 금액이 있는지 먼저 체크하기 먼저한것만 가능하다. cate - purchase 있으면 그걸로 한다.
		$first = $this->M_point->get_point_first('m_point',$login_id,'purchase');
		if(empty($first)){
            alert("적립된 P 금액이 없습니다.");	
		}
		else{
			$data['po'] = $first;
		}
		//---------------------------------------------------------------------------------//
		
		layout('office/purchase_svp',$data,'office');		
	}

	
	public function svp_ok()
	{
		$data = $member = array();	
		$site 			= $this->M_cfg->get_site();

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$mb 		= $this->M_member->get_member($login_id);
		$wallet 	= $this->M_coin->get_wallet_address($login_id,'wns');
		$bal 		= $this->M_coin->get_balance($member_no);	
			$bal_Withdraw = $bal->total_point - ($bal->release_point + $bal->loan + $bal->point_out + $bal->point_fee);	
		//---------------------------------------------------------------------------------//		
		$lang = get_cookie('lang');
		//---------------------------------------------------------------------------------//
		$this->form_validation->set_rules('count', 'count', 'required');		
		
		if ($this->form_validation->run() == FALSE)
		{
            alert("Point Checked");	
		}
		else 
		{
			$point_no 	= trim($this->input->post('point_no'));
			$count 	= trim($this->input->post('count'));	// 매출코인수량
			$amount = $count;				
			
			if($bal->total_point < 3000){
				alert("수당금액 3000P 이상 재매출 가능합니다.");					
			}
			
			if($bal_Withdraw < $count){
				alert("금액 범위내에서 재매출 해주세요");					
			}
			//---------------------------------------------------------------------------------//
			
			//---------------------------------------------------------------------------------//
            // 발란스 수정		
            $bal 	= $this->M_coin->get_balance($member_no);
            
            // $type 		= "total_point";
            // $point 		= $bal->total_point - $count;
            // $this->M_point->balance_inout($member_no,$type,$point);
            
            $type 		= "loan";
            $coin 		= $bal->loan + $count;
            $this->M_point->balance_inout($member_no,$type,$coin);
                
            $type 		= "volume";
            $volume 	= $bal->volume + $count;
						$this->M_point->balance_inout($member_no,$type,$volume);
						
            $type 		= "volume2";
            $volume2 	= $bal->volume2 + $count;
            $this->M_point->balance_inout($member_no,$type,$volume2);
			//---------------------------------------------------------------------------------//
			//---------------------------------------------------------------------------------//
			$order_code = order_code();  // 주문코드 만들기
			$db_table 	= 'm_point';
			
			$thing 		= 'add';
			$table 		= 'm_point_in';
			$this->M_point->pay_exc($table, $order_code, $mb->country, $mb->office, $login_id, $login_id, $count, $count, 'point',$point_no);
			
			$po = $this->M_point->get_point_no($db_table, $point_no);
				$po_svp = $po->point + $count;
				$po_amount = $po->point + $amount;
			
			$query = array(
				'point' 	=> $po_svp,
				'saved_point' 	=> $po_amount,	
			);
			//재적립하기
			$order_code = order_code();  // 주문코드 만들기

			$in_table 	= 'm_point';
			$msg 		= $site->cfg_won; // 시세기록하기
			$regdate 	= nowdate();
			$app_date = date("Y-m-d 23:59:59", strtotime($regdate."+3month"));
			$this->M_point->pay_puchase($in_table, $order_code, $mb->country, $mb->office, $login_id, $count, $count, 'repurchase', 'complete', '1', $msg,$regdate,$app_date);
			//$this->db->where('point_no', $point_no);
			//$this->db->update($db_table, $query);
			
			/*-----------------------------------------------------------------------------
			---------------------------------------------------------------------------*/
		}
			
		redirect('/office/purchase/svp_result/' .$amount .'/' .$count .'/' .$po_svp);
	}
		
	public function svp_result()
	{
		$data = array();
		$site 				= $this->M_cfg->get_site();
		$data['site'] 		= $site;
		//------------------------------------------------------------------------------------
		
		$data['amount'] 	= $this->uri->segment(4,0);
		$data['count'] 		= $this->uri->segment(5,0);
		$data['cash'] 		= $this->uri->segment(6,0);
		
		//---------------------------------------------------------------------------------//
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_member->get_member($login_id);
		//---------------------------------------------------------------------------------//		
		$bal = $this->M_coin->get_balance($member_no);		
		$data['bal'] = $bal;
			$data['bal_Withdraw'] = $bal->total_point - ($bal->release_point + $bal->loan + $bal->point_out + $bal->point_fee);
		//---------------------------------------------------------------------------------//
		$wallet 	= $this->M_coin->get_wallet_address($login_id,'wns');
				
		//---------------------------------------------------------------------------------//
		
		$lang = get_cookie('lang');
		layout('/office/purchase_svp_ok',$data,'office');

	}
	
	public function svp_lists()
	{
		if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {
			$this->output->enable_profiler($this->config->item('profiler'));
		}

		$data = array();
		$data['header'] = array('title'=>'PAY','group'=>'OFFICE');
		$data['site'] = $this->M_cfg->get_site();
		$data['active'] = "mu3";
		
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'wns');
		//---------------------------------------------------------------------------------//
		$bal = $this->M_coin->get_balance($member_no);		
		$data['bal'] = $bal;
		//---------------------------------------------------------------------------------//
		// 직급이미지
		//---------------------------------------------------------------------------------//
		$data['level_img'] = '<img src=/assets/images/level/level' .$bal->level .'.png style=width:100%>';
		$data['level_image'] = '<img src=/assets/images/level/level' .$bal->level .'.png style=width:80%>';
		$data['level_total'] = $this->M_point->point_puchase_total($login_id);
		//---------------------------------------------------------------------------------//
		// 추천횟수 - 추천인 몇명인지 가져오기
		//---------------------------------------------------------------------------------//
		$data['reCnt'] = $this->M_member->get_recommend_chk($login_id);
		//---------------------------------------------------------------------------------//
		
		$data = page_lists('m_point_in','point_no',$data,'member_id',$login_id);
		//$data = page_lists('m_coin','coin_no',$data,'event_id',$login_id,'cate','purchase');
		
		//---------------------------------------------------------------------------------//
		
		// 2020.07.22 박종훈 추가
		$list	=	$this->M_coin->getReSvpList($login_id);
		$data['list'] = $list;
		$total	=	$this->M_coin->getReSvpCnt($login_id);
		$data['total']	= $total;
		//---------------------------------------------------------------------------------//
		$lang = get_cookie('lang');		
		layout('office/purchase_svp_list',$data,'office');			
	}
	
	public function lists()
	{
		if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {
			$this->output->enable_profiler($this->config->item('profiler'));
		}

		$data = array();
		$data['header'] = array('title'=>'PAY','group'=>'OFFICE');
		$data['site'] = $this->M_cfg->get_site();
		
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_member->get_member($login_id);
		//---------------------------------------------------------------------------------//
		$bal = $this->M_coin->getBalanceList($member_no,$login_id);		
		$data['bal'] = $bal;
		//---------------------------------------------------------------------------------//
		$data = page_lists('m_point','point_no',$data,'member_id',$login_id,'cate','purchase');
		//$data = page_lists('m_coin','coin_no',$data,'event_id',$login_id,'cate','purchase');

		//---------------------------------------------------------------------------------//
		
		// 2020.07.22 박종훈 추가
		$total	=	$this->M_coin->getSvpCnt($login_id);
		$data['total']	= $total;
		//---------------------------------------------------------------------------------//
		
		$lang = get_cookie('lang');		
		
		layout('office/purchase_list',$data,'office');			
	}
	
}