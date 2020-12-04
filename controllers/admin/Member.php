<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Member extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','search','office'));
		
		$this->load->library('form_validation');
		$this->load->library('qrcode');
		$this->load->library('urlapi');
		//$this->load->library('bitcoin');
		
		admin_chk();
			
		//model load
		$this->load-> model('M_member');
		$this->load-> model('M_admin');
		$this->load-> model('M_cfg');
		$this->load-> model('M_office');
		$this->load-> model('M_point');
		$this->load-> model('M_coin');
		
	}

	function index()
	{
		$this->lists();
	}

	function lists()
	{	
    
    if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {
					$this->output->enable_profiler($this->config->item('profiler'));
				}
    
		$data['title'] 	= "회원현황";
		$data['group'] 	= "회원관리";
		$data['site'] 	= $this->M_cfg->get_site();
		
		$data['country'] 	= $this->M_member->get_country_li();
		$data['center'] 	= $this->M_member->get_center_li(); //센터 리스트 가져오기
		//---------------------------------------------------------------------------------//
		
		$data = page_lists('m_member','member_no',$data);
        foreach ($data['item'] as $row) 
        {
			$bal 	= $this->M_coin->getBalanceList($row->member_no,$row->member_id);

				$row->volume 	  = $bal->total_sales;				
				$row->total_su 	= $bal->total_point;

        }

		layout('memberLists',$data,'admin');
	}
	
	//=================================================================================//
	
	function loan()
	{		
		$data['title'] = "외상회원";
		$data['group'] = "회원관리";
		$data['per'] 	= "finish";
		$data['site'] 	= $this->M_cfg->get_site();
		
		$data = page_lists('m_balance','balance_no',$data,'loan >',0);
        foreach ($data['item'] as $row) 
        {
			$mb 		= $this->M_member->get_member($row->member_id);
				$row->mobile = $mb->mobile;
				$row->office = $mb->office;
				$row->name = $mb->name;
				$row->recommend_id = $mb->recommend_id;
        }

		layout('memberLoan',$data,'admin');
	}
	
	//=================================================================================//
	
	function finish()
	{		
		$data['title'] = "활동중지";
		$data['group'] = "회원관리";
		$data['per'] 	= "finish";
		$data['site'] 	= $this->M_cfg->get_site();
		
		$data = page_lists('m_member','member_no',$data,'is_close','1');
        foreach ($data['item'] as $row) 
        {
			$bal 	= $this->M_coin->get_balance($row->member_no);
			if(empty($bal))
			{
				$row->level 	= 0;
				$row->coin 		= 0;
				$row->token 	= 0;
				$row->point 	= 0;
				$row->volume 	= 0;
				$row->total_su	= 0;
				$row->persent 	= 0;
				$row->purchase 	= '';
				
			}
			else
			{
				$row->level 	= $bal->level;
				$row->coin 		= $bal->coin;
				$row->token 	= $bal->token;
				$row->point 	= $bal->point;
				$row->volume 	= $bal->volume;	
				$row->purchase 	= $bal->purchase;				

				$row->total_su 	= $bal->total_point;
				if($bal->volume <= 0){
					$row->persent 	= 0;					
				}
				else{
					$row->persent 	= ($row->total_su / $bal->volume) * 100;					
				}
			}
		
        }

		layout('memberEnd',$data,'admin');
	}
	
	
	function stop()
	{		
		$data['title'] 	= "P2P가능";
		$data['group'] 	= "회원관리";
		$data['per'] 	= "stop";
		$data['site'] 	= $this->M_cfg->get_site();
		
		$data = page_lists('m_member','member_no',$data,'type','1');
        foreach ($data['item'] as $row) 
        {
			$bal 	= $this->M_coin->get_balance($row->member_no);
			if(empty($bal))
			{
				$row->level 	= 0;
				$row->coin 		= 0;
				$row->token 	= 0;
				$row->point 	= 0;
				$row->volume 	= 0;
				$row->total_su	= 0;
				$row->persent 	= 0;
				$row->purchase 	= '';
				
			}
			else
			{
				$row->level 	= $bal->level;
				$row->coin 		= $bal->coin;
				$row->token 	= $bal->token;
				$row->point 	= $bal->point;
				$row->volume 	= $bal->volume;	
				$row->purchase 	= $bal->purchase;				

				$row->total_su 	= $bal->total_point;
				if($bal->volume <= 0){
					$row->persent 	= 0;					
				}
				else{
					$row->persent 	= ($row->total_su / $bal->volume) * 100;					
				}
			}
		
        }

		layout('memberEnd',$data,'admin');
	}
	
	function out()
	{		
		$data['title'] 	= "출금금지";
		$data['group'] 	= "회원관리";
		$data['per'] 	= "out";
		$data['site'] 	= $this->M_cfg->get_site();
		
		$data = page_lists('m_member','member_no',$data,'is_out','1');
        foreach ($data['item'] as $row) 
        {
			$bal 	= $this->M_coin->get_balance($row->member_no);
			if(empty($bal))
			{
				$row->level 	= 0;
				$row->coin 		= 0;
				$row->token 	= 0;
				$row->point 	= 0;
				$row->volume 	= 0;
				$row->total_su	= 0;
				$row->persent 	= 0;
				$row->purchase 	= '';
				
			}
			else
			{
				$row->level 	= $bal->level;
				$row->coin 		= $bal->coin;
				$row->token 	= $bal->token;
				$row->point 	= $bal->point;
				$row->volume 	= $bal->volume;	
				$row->purchase 	= $bal->purchase;				

				$row->total_su 	= $bal->total_point;
				if($bal->volume <= 0){
					$row->persent 	= 0;					
				}
				else{
					$row->persent 	= ($row->total_su / $bal->volume) * 100;					
				}
			}
		
        }

		layout('memberEnd',$data,'admin');
	}	
	
	//-----------------------------------------------------------------------------------------------//
	//----------------------------------------------------------------------------------------------//
	// 회원 등록
	function addMember()
	{
		$data['title'] = "회원정보 수정";
		$data['group'] = "회원관리";
		$data['site'] 	= $this->M_cfg->get_site();

		//---------------------------------------------------------------------------------//
		
		$this->form_validation->set_rules('password', 'password', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			alert("입력을 확인하세요.");	
		} 
		else 
		{	
			$country 		= $this->input->post('country');			
			//-------------------------------------------------------------------------------//
			/*	
			// 전화번호 가입자가 있으면 중복가입 안되게 한다.	
			$mobile 		= $this->input->post('mobile');
			$mobile = preg_replace("/\s+/","",$mobile);
			
			$chk = $this->M_member->get_mobile_check($mobile);
			if(empty($chk))
			{
			}
			else
			{
				if ($lang == "kr") {
					alert("휴대폰이 중복입니다.");
				}
				else{
					alert("The phone is a duplicate.");		
				}	
			}
			
			// 휴대폰 번호가 회원아이디
			$member_id = id_make($mobile);
			if($member_id == 'none'){
				alert("휴대폰 번호를 올바르게 입력해주세요.");
			}
			*/
			//-------------------------------------------------------------------------------//		
			$member_id 		= $this->input->post('member_id');			
			$mb = $this->M_member->get_member($member_id); // 정보 가져오기	
			if($mb){
				alert("Error : ID Checked");				
			}
			//-------------------------------------------------------------------------------//
			$recommend_id 	= $this->input->post('recommend_id');
			$re = $this->M_member->get_member($recommend_id);
			if(!$re){				
				alert("Error : Recommend ID Checked");
			}			
			///-------------------------------------------------------------------------------//
			/*
			$sponsor_id 	= $this->input->post('sponsor_id');			
			if($sponsor_id != ''){
				$sp = $this->M_member->get_member($sponsor_id);
				if(!$sp){				
					alert("Error : Sponsor ID Checked");
				}
			}			
			
			$sp_cnt = $this->M_member->sp_check($sponsor_id);
			if($sp_cnt >= 2){
				if ($lang == "kr") {
					alert("후원산하 2명이 있습니다.");
				}
				else{
					alert("There are two sponsors.");	
				}
			}
				
			if ($sp_cnt == 0){
				$pos = 'left';
			}
			else if ($sp_cnt == 1){
				$pos = 'right';
			}
			else{
				$pos = $sp_cnt;				
			}
			
			// 해당회원을 후원인으로 두는 회원을 찾는다 단, 같은 위치인 경우만-----------------------------
			$postion = 'left';
			$pos = $this->M_member->sp_side_check($sponsor_id,$postion);
			if($pos == 1)
			{
				$pos = 'right';
			}
			else
			{				
				$postion = 'right';
				$pos = $this->M_member->sp_side_check($sponsor_id,$postion);
				if($pos == 1){
					$pos = 'left';
				}
				else{
					$pos = 'left';					
				}				
			}			
			// 해당회원을 후원인으로 두는 회원을 찾는다 단, 같은 위치인 경우만-----------------------------
			
			// 추천 후원 같으면 1명만 내 밑에...
			if($recommend_id == $sponsor_id)
			{
				$Scnt = $this->M_member->samsam_check($sponsor_id);
				if($Scnt >= 1){
					alert("추천,후원이 같은 사람은 1명만 가능합니다.");
				}	
			}
			
			//-------------------------------------------------------------------------------//
			// 비트코인 지갑주소 생성
			$addr = $this->bitcoin->getnewaddress($member_id);
			
			//통신 안될경우 중단
			if(!$addr) {
				alert("Error : 123008 Code");
			}

			$type = 'wns';
			qrcode($member_id,$addr);
			$qrimg = $member_id .".png"; // ico qrcode
			
			$this->M_coin->set_wallet_in($member_id,$addr,$qrimg,$type);
			*/
			//-------------------------------------------------------------------------------//
			//-------------------------------------------------------------------------------//
			include APPPATH."libraries/Node_rpc.php";
			$rpc = new Node_rpc();
				
			$walletAddress = $rpc->newAddress($member_id);

			if( strlen( $walletAddress['privateKey'] ) > 10 )
			{
				$addr_key = $walletAddress['privateKey'];
				$addr = $walletAddress['address'];
			}			

			//통신 안될경우 중단
			if(!$addr) {
				alert("Error : Create WNS Token");
			}
				
			$type = "wns";
			$qrimg_id = $member_id; // ico qrcode
			qrcode($qrimg_id,$addr);
				
			$qrimg = $member_id .".png"; // ico qrcode
			$this->M_member->member_wallet($member_id,$addr,$qrimg,$type,$addr_key);
			//-------------------------------------------------------------------------------//
			// 후원인의 깊이를 가져온다.
			$dep = $this->M_member->get_member_dep($recommend_id);	
				$dep = $dep + 1;
				
			$pos = $this->M_member->get_re_side($recommend_id,$member_id); // 나는 스폰서의 좌우 어디에 있나? - 없으면 1		
			if ($pos == '1'){
				$pos = 'left';
			}
			else if ($pos == '2'){
				$pos = 'right';
			}
			else{
				$pos = $pos;			
			}
			//-------------------------------------------------------------------------------//
			qrcode_mb($member_id);
			//-------------------------------------------------------------------------------
			// 회원 정보 기록
			$this->M_member->member_admin_in($member_id,$dep,$pos);
			//-------------------------------------------------------------------------------
			//기록된 회원 정보 가져오기
			$member = $this->M_member->get_member($member_id);
			$this->M_coin->set_balance_in($member->member_no, $member->member_id);
			//-------------------------------------------------------------------------------
			
			// 볼륨등록
			$order_code = order_code(); //주문코드 생성
			$regdate 	= nowdate();	
			/*
			// 본인을 먼저 넣고 그 다음에 추가로 입력한다.
			$side 	= 'middle';
			$table 	= 'm_volume';
			$this->M_office->vlm_in($table, $order_code, $this->input->post('name'), $member_id, $member_id, $sponsor_id, $side, $dep, 0, $regdate);
			
			vlm_tree($order_code, $this->input->post('name'), $member_id, $sponsor_id, $dep, 0, $regdate);
			*/
			//-------------------------------------------------------------------------------
			$side = 'middle';
			$table = "m_volume1";
			// echo $recommend_id;
			// exit;
			$this->M_office->vlm_in($table, $order_code, $this->input->post('name'), $member_id, $member_id, $recommend_id, $pos, $dep, 0, $regdate);
		
			vlm_re_tree($order_code, $this->input->post('name'), $member_id, $recommend_id, $dep, 0, $regdate);
			//-------------------------------------------------------------------------------
			//---------------------------------------------------------------------------------//
			
			alert("등록 완료 되었습니다", "admin/member/lists");			

		}
	}
	
		
	//---------------------------------------------------------------------------------//
	// 회원정보 수정
	function write()
	{
		$data['title'] = "회원정보 수정";
		$data['group'] = "회원관리";

		$member_id   = $this->uri->segment(4,0);
		
		$data['country'] = $this->M_member->get_country_li();
		$data['center'] = $this->M_member->get_center_li(); //센터 리스트 가져오기
		//$data['group']	= $this->M_member->get_group_li(); //센터 리스트 가져오기
		//---------------------------------------------------------------------------------//
		
		$data['member'] 	= $this->M_member->get_member($member_id); //멤버 정보 가져오기
			$member_no		= $data['member']->member_no;
			
		$data['bal'] 	= $this->M_coin->get_balance($member_no);
		
		//---------------------------------------------------------------------------------//
		//$data = page_lists('m_point','point_no',$data,'member_id',$member_id);
		//---------------------------------------------------------------------------------//
		layout('memberWrite',$data,'admin');

	}
	
	function edit()
	{
		$this->form_validation->set_rules('password', 'password', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			alert("입력을 확인하세요.");	
		} 
		else
		{	
			$member_id = $this->input->post('member_id');

			if($member_id == 'admin' and $this->session->userdata('member_id') != 'admin'){				
				alert("관리자 변경은 회원페이지에서 하세요");
			}
			//--------------------------------------------------------------------------------//
			// 추천인이 바뀌거나 위치가 바뀌는 경우 후원인을 바꾼다.			
			$old_recommend_id 	= $this->input->post('old_recommend_id');
			$recommend_id 		= $this->input->post('recommend_id');
			//$old_sponsor_id 	= $this->input->post('old_sponsor_id');
			//$sponsor_id 		= $this->input->post('sponsor_id');
			
			if($recommend_id == $member_id){				
				alert("추천인이 본인이 될 수 없습니다");
			}
			//--------------------------------------------------------------------------------//
			$this->M_member->member_admin_up($member_id);			
			//--------------------------------------------------------------------------------//
			// 추천인이 바뀌면 다시 한다.
			if($old_recommend_id != $recommend_id and $recommend_id != $member_id  and $member_id != 'admin'){
				
				$this->M_office->plan_re($member_id,$recommend_id);
				
				// 바뀌는 회원을 중심으로 회원산하 전체를 다 바꾼다.
				$order_code = order_code(); //주문코드 생성
				$regdate 	= nowdate();
				$table 		= "m_volume1";
				
				$vlm = $this->M_office->get_vlm_li($table,$member_id);
				foreach ($vlm as $row) 
				{	
					$this->db->where('event_id', $row->event_id);
					$this->db->delete('m_volume1');
					
					$ev 	= $this->M_member->get_member($row->event_id);
					$pos 	= $this->M_member->get_re_side($ev->recommend_id,$member_id); // 나는 스폰서의 좌우 어디에 있나	
					
					// 본인을 먼저 넣고 그 다음에 추가로 입력한다.
					$side = 'middle';
					$this->M_office->vlm_in($table,$order_code,$ev->name,$row->event_id,$row->event_id,$ev->recommend_id,$side,$pos,0,$row->regdate);
					
					vlm_re_tree($order_code,$ev->name,$row->event_id,$ev->recommend_id,0,$pos,$row->regdate);				
				}
			}
			
			//--------------------------------------------------------------------------------//
			/*
			// 바뀌는 회원을 중심으로 회원산하 전체를 다 바꾼다.
			// 후원인이 바뀌면 다시 한다.
			$old_sponsor_id 	= $this->input->post('old_sponsor_id');
			$sponsor_id 		= $this->input->post('sponsor_id');
			
			if($old_sponsor_id != $sponsor_id and $sponsor_id != $member_id  and $member_id != 'admin'){
				$order_code = order_code(); //주문코드 생성
				$regdate 	= nowdate();
				
				$cnt = $this->M_office->get_sponsor_chk($sponsor_id);
				if($cnt >= 2)
				{
					alert("변경할 후원인 산하를 확인해주세요");	
				}
				
				$dep = $this->M_member->get_member_dep($sponsor_id);	
					$dep = $dep + 1;
				
				$this->M_member->member_sp_up($member_id,$sponsor_id); // 후원인 변경
				
				// 본인 포함 본인의 산하를 지우면서 다시 위로 올려준다.				
				$table 		= "m_volume";
				$vlm = $this->M_office->get_vlm_li($table,$member_id);
				foreach ($vlm as $row) 
				{
					$this->db->where('event_id', $row->event_id);
					$this->db->delete('m_volume');

					$mb 	= $this->M_member->get_member($row->event_id);
					//$name 	= $this->M_member->get_member_name($row->event_id);
					
					// 본인을 먼저 넣고 그 다음에 추가로 입력한다.
					$side = 'middle';
					$this->M_office->vlm_in($table,$order_code,$mb->name,$row->event_id,$row->event_id,$mb->sponsor_id,$side,0,$dep,$row->regdate);				
			
					vlm_tree($order_code,$mb->name,$row->event_id,$mb->sponsor_id,0,$dep,$row->regdate);
				}
			}
			
			//--------------------------------------------------------------------------------//
			
			// 수정한 사람 누군지 기록하기
			$str = $member_id ." - edit";
			$query = array(
				'member_id' => $this->session->userdata('member_id'),
				'msg' => $str
			);
			$this->db->set('reg_date', 'now()', FALSE);
			$this->db->insert('m_access_token', $query);
			*/
			//--------------------------------------------------------------------------------//
			
			alert("수정이 완료되었습니다", "admin/member/write/".$member_id ."");			

		}
	}	
	//---------------------------------------------------------------------------------//
	
	// token add
	function exMember()
	{
		$data['title'] = "회원정보 수정";
		$data['group'] = "회원관리";
		
		$site = $this->M_cfg->get_site();
		$data['site'] 		= $site;
		$data['regdate'] 	= nowdate();

		$member_id   = $this->uri->segment(4,0);
		
		$data['member'] 	= $this->M_member->get_member($member_id); //멤버 정보 가져오기
			$member_no		= $data['member']->member_no;
			
		$data['wallet'] = $this->M_coin->get_wallet($member_id);

		$data['bal'] 	= $this->M_coin->get_balance($member_no);
		//---------------------------------------------------------------------------------//
		// 매출횟수를 기록하여 재구매인지 신규인지 보여준다.
		$data['puchase_cnt'] = $this->M_point->point_in_chk('m_point',$member_id);
		//---------------------------------------------------------------------------------//		
		
		layout('memberExchange',$data,'admin');

	}
		
	// 매출등록-------------------------------------------------------------------------------
	function addPuchase()
	{
		$site = $this->M_cfg->get_site();
		//--------------------------------------------------------------------------------//

		$this->form_validation->set_rules('count', 'count', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			alert("입력을 확인하세요.");	
		} 
		else 
		{
			
			$order_code = order_code();  // 주문코드 만들기
			
			$member_name	= $this->input->post('name');
			$member_no 		= $this->input->post('member_no');
			$member_id 		= $this->input->post('member_id');
			$member_wallet	= $this->input->post('member_wallet');
			
			if($member_id == 'admin'){				
				alert("관리자는 매출등록을 할 수 없습니다");
			}
			
			$bal 	= $this->M_coin->get_balance($member_no);
			$mb 	= $this->M_member->get_member($member_id); //멤버 정보 가져오기
			//--------------------------------------------------------------------------------//
			
			$old_recommend_id 	= $this->input->post('old_recommend_id');
			$recommend_id 		= $this->input->post('recommend_id');
			
			$puchase_cnt 	= $this->input->post('puchase_cnt'); 	// 매출 횟수
			$kind 			= $this->input->post('kind');			// 매출 구분
			$msg 			= $this->input->post('msg');			// 메시지
			$regdate		= $this->input->post('regdate');		// 날짜
				
			$app_date = date("Y-m-d 23:59:59", strtotime($regdate."+3month")); // 지급일은 1일 후
			//-------------------------------------------------------------------------
			$amount = $this->input->post('count'); // 매출금액
			//-------------------------------------------------------------------------			
			// 거래소 토큰 시세
			//$USNS_USD 	= get_usd();
			//-------------------------------------------------------------------------
			
			// 금액에 맞게 포인트 수량 구하기
			$svp_point = $amount;
		
			if($bal->point < $svp_point){
				//alert($svp_point ." - SVP Balance Checked");				
			}
			//--------------------------------------------------------------------------------//
				//--------------------------------------------------------------------------------//
			
			if($amount >= 50000 and $amount <= 500000){
				$level 			= 1;
				$thing 			= $site->cfg_lv1_name;
				$amount_start 	= $site->cfg_lv1_purchase;
				$amount_end 	= $site->cfg_lv1_point;
				$su_day	 		= $site->cfg_lv1_day;
				$su_re1	 		= $site->cfg_lv1_re;
				$su_re2	 		= $site->cfg_lv1_re1;
			}
			else if($amount > 500001 and $amount <= 1000000){
				$level 			= 2;
				$thing 			= $site->cfg_lv2_name;
				$amount_start 	= $site->cfg_lv2_purchase;
				$amount_end 	= $site->cfg_lv2_point;
				$su_day	 		= $site->cfg_lv2_day;
				$su_re1	 		= $site->cfg_lv2_re;
				$su_re2	 		= $site->cfg_lv2_re1;
			}
			else{
            	alert("매출 금액이 최소 5만SVP 부터 최대 100만SVP까지 입니다.");					
			}
			//--------------------------------------------------------------------------------//
			
            $type 		= "level";
            $this->M_point->balance_inout($member_no,$type,$level);
			
            $type 		= "purchase";
            $this->M_point->balance_inout($member_no,$type,$thing);
		
			$type 		= "purchase_cnt";
			$purchase_cnt 	= $bal->purchase_cnt + 1;
			$this->M_point->balance_inout($member_no,$type,$purchase_cnt);
            
            //$type 		= "point";
            //$point 		= $bal->point - $svp_point;
            //$this->M_point->balance_inout($member_no,$type,$point);
            
            $type 		= "coin";
            $coin 		= $bal->coin + $svp_point;
            $this->M_point->balance_inout($member_no,$type,$coin);
                
            $type 		= "volume";
            $volume 	= $bal->volume + $amount;
            $this->M_point->balance_inout($member_no,$type,$volume);
            
			//--------------------------------------------------------------------------------//
			$msg 		= $site->cfg_usd;
			$in_table 	= 'm_point';
			$this->M_point->pay_puchase($in_table, $order_code, $mb->country, $mb->office, $member_id, $svp_point, $amount, 'purchase', $kind, $level, $msg,$regdate,$app_date);
			//----------------------------------------------------------------------------------------------------------------------------------------------------------//
			
			alert("매출등록이 완료되었습니다", "admin/member/lists");	
			//alert("매출등록이 완료되었습니다", "admin/member/exMember/".$member_id ."");			

		}
	}
	
	//---------------------------------------------------------------------------------//

	function addPoint()
	{
		$site = $this->M_cfg->get_site();
		//---------------------------------------------------------------------------------//

		$this->form_validation->set_rules('count', 'count', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			alert("입력을 확인하세요.");	
		} 
		else 
		{
			$count 	= $this->input->post('count');
			$svp 	= $this->input->post('svp'); // 보유량
			$kind 	= $this->input->post('kind'); // 충전 혹은 빼내기
			
			$member_no 	= $this->input->post('member_no');
			$member_id 	= $this->input->post('member_id');

			$bal 	= $this->M_coin->get_balance($member_no);
			$mb 	= $this->M_member->get_member($member_id); //멤버 정보 가져오기
			$wallet = $this->M_coin->get_wallet_address($member_id,'wns');
			//--------------------------------------------------------------------------------//
			$order_code = order_code();  	// 주문코드 만들기			
			
			// 충전하기
			if($kind == 'svp_a')
			{				
				$type 	= "point";
				$token 	= $bal->point + $count;
				$this->M_point->balance_inout($member_no,$type,$token);
				
				$thing 		= 'rev';
				$table 		= 'm_point_in';
				$this->M_point->pay_exc($table, $order_code, $mb->country, $mb->office, $member_id, 'master_send', $count, $count, 'point','rev');
				//----------------------------------------------------------------------------------------------------------------------------------------------------------//				
			}
			else if($kind == 'svp_m')
			{
				if($bal->point < $count){
					alert("빼내기 시 보유수량 체크");					
				}
				
				$type 	= "point";
				$token 	= $bal->point - $count;
				$this->M_point->balance_inout($member_no,$type,$token);
				
				$thing 		= 'send';
				$table 		= 'm_point_in';
				$this->M_point->pay_exc($table, $order_code, $mb->country, $mb->office, 'master_rev', $member_id, $count, $count, 'point','send');
				//----------------------------------------------------------------------------------------------------------------------------------------------------------//				
			}
			else{
				alert("전송구분을 선택하세요");
			}
				
			//--------------------------------------------------------------------------------//
			/*
			// 수정한 사람 누군지 기록하기
			$str = $mb_id ." - $order_code : " .$kind;
			$query = array(
				'member_id' => $this->session->userdata('member_id'),
				'msg' => $str
			);
			$this->db->set('reg_date', 'now()', FALSE);
			$this->db->insert('m_access_token', $query);
			*/
			//--------------------------------------------------------------------------------//
			
			alert("전송이 완료되었습니다", "admin/member/exMember/".$member_id ."");			

		}
	}	
	
/* ===============================================================================================*/
	
	// 회원정보 삭제
	function delete()
	{
		$idx 	= $this->uri->segment(4,0);
		
		if ($idx == "admin") {
			alert('어드민은 삭제불가입니다.');
		}
		
		/*
		// 플랜 상위회원 업데이터 하기
		$plan_ck = $this->M_office->plan_in_chk($chk->member_id); // 받은 사람 플랜 등록 여부 확인	
		if(!empty($plan_ck))
		{
			$mb = $this->M_office->get_plan($idx);
				$mb->sponsor_id;
				$sync = 0;	
			$this->M_office->plan_sp_up($mb->sponsor_id,$sync); // 상위회원 업데이터해주기	
		}		
		*/
		echo $idx;
		//하위라인 확인
		$down_line = $this->M_admin->down_count($idx);		
		if ($down_line > 0 ) {
			alert('내 아래에 회원이 ' .$down_line .'명 존재합니다. 순서대로 삭제하세요');
		}
		
		// 후원인에게 두명이 있고 내가 왼쪽이면
		$ch_pos = '';
		$sp = $this->M_member->get_sponsor_li($mb->sponsor_id);
		foreach ($sp as $spm) 
		{
			if($spm->member_id == $idx and $spm->biz == 'left'){
				$ch_pos = 'y';
			}
			
			if($ch_pos == 'y'){
				if($spm->member_id != $idx and $spm->biz == 'right'){
					
					$query = array(
						'biz' 	=> 'left',	
					);
					$this->db->where('member_no', $spm->member_no);
					$this->db->update('m_member', $query);
				}				
			}
		}
		
		//--------------------------------------------------------------------
		
		$this->db->where('member_id', $idx);
		$this->db->delete('m_member');
		
		$this->db->where('member_id', $idx);
		$this->db->delete('m_balance');
		
		$this->db->where('member_id', $idx);
		$this->db->delete('m_plan');
		
		$this->db->where('member_id', $idx);
		$this->db->delete('m_point');		
		$this->db->where('event_id', $idx);
		$this->db->delete('m_point');
		
		$this->db->where('member_id', $idx);
		$this->db->delete('m_volume');		
		$this->db->where('event_id', $idx);
		$this->db->delete('m_volume');
		
		$this->db->where('member_id', $idx);
		$this->db->delete('m_volume1');		
		$this->db->where('event_id', $idx);
		$this->db->delete('m_volume1');
		
		$this->db->where('member_id', $idx);
		$this->db->delete('m_coin');		
		$this->db->where('member_id', $idx);
		$this->db->delete('m_wallet');
		
		
		$this->db->where('member_id', $idx);
		$this->db->delete('m_point_su');		
		$this->db->where('event_id', $idx);
		$this->db->delete('m_point_su');
		
		$this->db->where('member_id', $idx);
		$this->db->delete('m_point_total');		
		$this->db->where('event_id', $idx);
		$this->db->delete('m_point_total');	
		
		//goto_url($_SERVER['HTTP_REFERER']);
		
		redirect('/admin/member/lists');
		
	}
	
	
	// 회원 히스토리
	function history()
	{
		$data['title'] = "회원 히스토리";
		$data['group'] = "회원관리";
		
		
		$member_id   = $this->uri->segment(4,0);
		$type   = $this->uri->segment(5,0);
		
		if ($type == '') {
			$type = 'su';
		}
		
		$table = 'm_point_free';
		$data['history'] = $this->M_admin->get_per_his($table,$member_id,$type);
		
		// 가공
		foreach ($data['history'] as $row) {
			$row->regdate =  substr($row->regdate,0,10);
		}
		
		$this->load->view('admin/memberHistory',$data);
	}
	

}
?>