<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron2 extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','search','office'));
		$this->load->library('form_validation');

		//admin_chk();
		$this->load->library('bitcoin');
        $this->load->library('urlapi');

		//model load
		$this -> load -> model('M_member');
		$this -> load -> model('M_admin');
		$this -> load -> model('M_cfg');
		$this -> load -> model('M_coin');
		$this -> load -> model('M_office');
		$this -> load -> model('M_point');
		$this -> load -> model('M_deadline');

	}
	
	
	function lists()	
	{				
		$data['title'] = "일 마감";
		$data['group'] = "마감관리";
		/*
		$data['page'] = $this->uri->segment(4,0);
		$data['pageLink'] = $this->uri->segment(5,0);
		if(empty($data['page'])){
			$data['link'] = "lists/page/";
		}
		else{
			$data['link'] = "";
		}
		
		if(empty($data['pview'])){
			$data['pview'] = 0;
		}
		*/
		$data = page_lists('m_deadline','dead_no',$data);
		
		// 가공
		foreach ($data['item'] as $row) {
			 $row->start_date =  substr($row->start_date,0,10);
			 $row->end_date =  substr($row->end_date,0,10);
		}
		
		layout('deadLists',$data,'admin');
	}
	
	
	// 마감처리하기
	function start()
	{	
		
		$this->load->helper('log');
		$data['title'] = "마감처리";
		$data['group'] = "마감관리";	
		
		set_time_limit(0);
		ini_set('memory_limit','-1');		
		
		$site 			= $this->M_cfg->get_site();
		$order_code 	= order_code(); //주문코드 생성			

		//-----------------------------------------------------------------------------------------------------------------------------------//				
		$count_date 	= date("Y-m-d");
		// 마감이 안 돈 경우 날짜가공 하여 마감일을 찾는다
		// $count_date 	= '2020-08-10'; // 8월 9일 현재 마감이 안되었다고 연락오면 하루전으로 수정해서 마감돌릴것.
		
		$start 			= $count_date." 00:00:00";				
		$end 			= $count_date." 23:59:59";		
		$regdate		= $end;
		
		// $day_send		= '-' .$site->cfg_day_send_start .'day';
		// $day_start = date("Y-m-d 23:59:59", strtotime($end.$day_send)); // 14일 전의 것을 가져와서 데일리 수당 지급한다.		
		$write_date = date("Y-m-d 23:59:59", strtotime($end."+1day")); // 지급일은 1일 후

		//-----------------------------------------------------------------------------------------------------------------------------------//	
		
		// 월~일 날짜 구하기 // 월요일 마감 목요일 지급하기 // 월요일이 아니면 지난주
		$week_send = "n"; // 주마감 적용
		$yoil = array("일","월","화","수","목","금","토");
		$day_yoil = $yoil[date('w', strtotime($count_date))];
		if($day_yoil == "일"){
			$week_send = "n";
			$week_date = date("Y-m-d 00:00:00", strtotime($end."-6day")); 	// 일주일전거 7일간
			$week_end = date("Y-m-d 00:00:00", strtotime($end));	
		}
		else if($day_yoil == "월"){	
			$week_send = "y";
			$week_date = date("Y-m-d 00:00:00", strtotime($end."-7day")); 	// 일주일전거 7일간
			$week_end = date("Y-m-d 00:00:00", strtotime($end."-1day"));
		}
		else if($day_yoil == "화"){
			$week_send = "n";
			$week_date = date("Y-m-d 00:00:00", strtotime($end."-1day")); 	// 일주일전거 7일간
			$week_end = date("Y-m-d 00:00:00", strtotime($end));	
		}
		else if($day_yoil == "수"){
			$week_send = "n";
			$week_date = date("Y-m-d 00:00:00", strtotime($end."-2day")); 	// 일주일전거 7일간
			$week_end = date("Y-m-d 00:00:00", strtotime($end));	
		}	
		else if($day_yoil == "목"){
			$week_send = "n";
			$week_date = date("Y-m-d 00:00:00", strtotime($end."-3day")); 	// 일주일전거 7일간
			$week_end = date("Y-m-d 00:00:00", strtotime($end));	
		}
		else if($day_yoil == "금"){
			$week_send = "n";
			$week_date = date("Y-m-d 00:00:00", strtotime($end."-4day")); 	// 일주일전거 7일간
			$week_end = date("Y-m-d 00:00:00", strtotime($end));	
		}	
		else if($day_yoil == "토"){
			$week_send = "n";
			$week_date = date("Y-m-d 00:00:00", strtotime($end."-5day")); 	// 일주일전거 7일간
			$week_end = date("Y-m-d 00:00:00", strtotime($end));	
		}
		
		// 영업일 구하기
		$day_send = "n"; // 영업일 적용
		$week_send = "n"; // 주마감 적용
		$yoil = array("일","월","화","수","목","금","토");
		$day_yoil = $yoil[date('w', strtotime($count_date))];
		if($day_yoil == "일"){
			$day_send = "n";
			
			//$week_send = "y";
			//$week_date = date("Y-m-d 00:00:00", strtotime($end."-6day")); // 일주일전거 7일간	
		}
		else if($day_yoil == "토"){
			$day_send = "n";
		}
		else{
			$day_send = "y";
		}
		/*
		$Y_date =array(
			'2019-01-01', // 새해
			'2019-02-04', // 설날
			'2019-02-05', // 설날
			'2019-02-06', // 설날
			'2019-03-01', // 삼일절
			'2019-05-05', // 어린이날
			'2019-05-06', // 어린이날
			'2019-05-12', // 부처님 오신 날
			'2019-06-06', // 현충일
			'2019-08-15', // 광복절
			'2019-09-12', // 추석
			'2019-09-13', // 추석
			'2019-09-14', // 추석
			'2019-10-03', // 개천절
			'2019-10-09', // 한글날
			'2019-12-25', // 크리스마스
			'2020-01-01', // 새해
			'2020-01-24', // 설날
			'2020-01-25', // 설날
			'2020-01-26', // 설날
			'2020-03-01', // 삼일절
			'2020-04-30', // 부처님 오신 날
			'2020-05-05', // 어린이날
			'2020-06-06', // 현충일
			'2020-08-15', // 광복절
			'2020-09-30', // 추석
			'2020-10-01', // 추석
			'2020-10-02', // 추석
			'2020-10-03', // 개천절
			'2020-10-09', // 한글날
			'2020-12-25', // 크리스마스
		); 		

		$holyday = array_search($count_date,$Y_date); 
		if($holyday){ 
			$day_send = "n";
		}
		*/
		$day_cnt = date('t'); // 해당달의 일수
		
		//-----------------------------------------------------------------------------------------------------------------------------------//	
		
		// 마감을 먼저 기록하기 - 있으면 삭제 후 다시 기록하기
		$chk = $this->M_deadline->get_deadline_today($regdate);
		if(empty($chk)){
			$dead_no = $this->M_deadline->deadline_in($order_code,$start,$end,$regdate);			
		}
		else
		{							
			$this->db->where('dead_no', $chk->dead_no);
			$this->db->delete('m_deadline');
			
			// $order_code 수당 모두 삭제
			$this->db->where('order_code', $chk->order_code);
			$this->db->delete('m_coin');
			
			$this->db->where('order_code', $chk->order_code);
			$this->db->delete('m_point');			
		
			$table = 'm_point_su';
			$list = $this->M_point->get_point_code($table,$chk->order_code);
			foreach ($list as $row) 
			{
				$Bal 	= $this->M_coin->get_balance_id($row->member_id);
			
				$type 			= "total_point";
				$total_point 	= $Bal->total_point - $row->point;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_point); // 누적	
			
				if($row->kind == 'ct'){
					$type 		= "su_ct";				
					$total_su 	= $Bal->su_ct - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				}
				else if($row->kind == 'ctre'){
					$type 		= "su_ct_re";				
					$total_su 	= $Bal->su_ct_re - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				}
				
				else if($row->kind == 'day'){
					$type 		= "su_day";				
					$total_su 	= $Bal->su_day - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
					
					$type 		= "su_day_count";				
					$total_su 	= $Bal->su_day_count - 1;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				}
				
				else if($row->kind == 're'){
					$type 		= "su_re";				
					$total_su 	= $Bal->su_re - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				}
				
				else if($row->kind == 're2'){
					$type 		= "su_re2";				
					$total_su 	= $Bal->su_re2 - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적										
				}
				
				else if($row->kind == 'mc'){
					$type 		= "su_mc";				
					$total_su 	= $Bal->su_mc - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				}
				
				else if($row->kind == 'mc2'){
					$type 		= "su_mc2";				
					$total_su 	= $Bal->su_mc2 - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				}
				
				else if($row->kind == 'level'){
					$type 		= "su_level";				
					$total_su 	= $Bal->su_level - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				}
						
			}
		
			$this->db->where('order_code', $chk->order_code);
			$this->db->delete('m_point_su');
			//--------------------------------------------------------------------------------------
			//--------------------------------------------------------------------------------------
			// 임시 센타비를 저장하는곳			
			$this->db->where('order_code', $chk->order_code);
			$this->db->delete('m_point_total');
		
			$dead_no = $this->M_deadline->deadline_in($order_code,$start,$end,$regdate);
		}
		
		//-----------------------------------------------------------------------------------------------------------------------------------//
		
		$in_total = $this->M_deadline->get_money_in_total($start,$end); // 오늘 매출
		if(empty($in_total)) $in_total = 0;
		
		// 출금 신청한 것들 합계 구하기
		$out_total = $this->M_deadline->get_money_out_total($start,$end);
		if(empty($out_total)){$out_total = 0;}	
			
		//-----------------------------------------------------------------------------------------------------------------------------------//
		$list = $this->M_point->get_balance_li();
		foreach ($list as $row) 
		{	
			$type 			= "today_su";
			$total_point 	= 0;
			$this->M_point->balance_inout_id($row->member_id,$type,$total_point); // 초기화
		}
		
		$re_total 		= 0;
		$re2_total 		= 0;
		/* 2020.08.12 박종훈 추천수당 주석처리 추후 삭제예정
		//-----------------------------------------------------------------------------------------------------------------------------------//
		// 오늘 적립신청한 매출을 찾아서 추천수당을 지급한다.		
		$re_point 		= 0;		
		$re2_point 		= 0;
		$re_total 		= 0;
		$re2_total 		= 0;
		//-----------------------------------------------------------------------------------------------------------------------------------//
		$list = $this->M_deadline->get_money_li_date($start,$end);
		foreach ($list as $row) 
		{
			$add_volume 	= 0;
			
			// 추천인 위로 해당자 찾기
			$table = 'm_volume1';
			$Revlm = $this->M_office->get_vlm_up($table,$row->member_id);
			foreach ($Revlm as $Rup) 
			{
				$balance = $this->M_deadline->get_purchase_bal($Rup->member_id,$end);
				if($balance > $add_volume)
				{							
					$recommend_id = $Rup->member_id;						
					break;					
				}
				else{
					$recommend_id = 'admin';							
				}
			}
				
			$mb 	= $this->M_member->get_member($recommend_id);
			//-----------------------------------------------------
			$rebal 	= $this->M_coin->get_balance_id($recommend_id);
				$volume 	= $rebal->volume;
			//-----------------------------------------------------
				
			// SVP 포인트로 지급 - 10원
			$re_persent = $site->cfg_re;
			$re_point = $row->point * $re_persent;
			//-----------------------------------------------------------------------------------------
			// 추천수당 지급하기				
			if($re_point > 0 and $recommend_id != 'admin')
			{					
				$type 			= "today_su";
				$total_point 	= $rebal->today_su + $re_point;
				$this->M_point->balance_inout_id($recommend_id,$type,$total_point); // 누적
				//---------------------------------------------------------------------------
			
				$type 			= "su_re";
				$total_su 		= $rebal->su_re + $re_point;
				$this->M_point->balance_inout_id($recommend_id,$type,$total_su); // 누적
					
				$type 			= "total_point";
				$total_point 	= $rebal->total_point + $re_point;
				$this->M_point->balance_inout_id($recommend_id,$type,$total_point); // 누적
				//---------------------------------------------------------------------------
				$msg 	= $re_persent;
				$table 	= 'm_point_su';				
				//---------------------------------------------------------------------------
				// 2020.07.30 박종훈 m_point의 order코드를 m_point_su에 추가
				$this->M_deadline->point_exc($table, $order_code, $row->order_code, $mb->office, $recommend_id, $row->member_id, $re_point, $row->point, 'su', 're', $msg, $write_date);
				// $this->M_deadline->point_exc($table, $order_code, $mb->office, $recommend_id, $row->member_id, $re_point, $row->point, 'su', 're', $msg, $write_date);
				//-----------------------------------------------------------------------------------------------------------------------------------//		
				$re_total = $re_total + $re_point;
					
				//-----------------------------------------------------------------------------------------------------------------------------------//	
				// 2대 지급한다.
				$re 	= $this->M_member->get_member($mb->recommend_id);
				//-----------------------------------------------------
				$re2bal 	= $this->M_coin->get_balance_id($mb->recommend_id);
					$volume 	= $re2bal->volume;
				//-----------------------------------------------------
				
				// SVP 포인트로 지급 - 10원
				$re2_persent = $site->cfg_re1;
				$re2_point = $row->point * $re2_persent;
				//-----------------------------------------------------------------------------------------
				// 추천수당 지급하기				
				if($re2_point > 0)
				{					
					$type 			= "today_su";
					$total_point 	= $re2bal->today_su + $re2_point;
					$this->M_point->balance_inout_id($mb->recommend_id,$type,$total_point); // 누적
					//---------------------------------------------------------------------------
			
					$type 			= "su_re2";
					$total_su 		= $re2bal->su_re2 + $re2_point;
					$this->M_point->balance_inout_id($mb->recommend_id,$type,$total_su); // 누적
					
					$type 			= "total_point";
					$total_point 	= $re2bal->total_point + $re2_point;
					$this->M_point->balance_inout_id($mb->recommend_id,$type,$total_point); // 누적
					//---------------------------------------------------------------------------
					$msg 	= $re2_persent;
					$table 	= 'm_point_su';
					//---------------------------------------------------------------------------
					// 2020.07.30 박종훈 m_point의 order코드를 m_point_su에 추가
					$this->M_deadline->point_exc($table, $order_code, $row->order_code, $re->office, $mb->recommend_id, $row->member_id, $re2_point, $row->point, 'su', 're2', $msg, $write_date);
					// $this->M_deadline->point_exc($table, $order_code, $re->office, $mb->recommend_id, $row->member_id, $re2_point, $row->point, 'su', 're2', $msg, $write_date);
				
					$re2_total = $re2_total + $re2_point;
				
				}
			}
				
		
		}
		*/
		

		//-----------------------------------------------------------------------------------------------------------------------------------//	
		// 데일리 수당 지급하기	
		$day_point 		= 0;
		$day_total 		= 0;
		$mc_point 		= 0;
		$mc_total 		= 0;
		$mc2_point 		= 0;
		$mc2_total 		= 0;
		//-----------------------------------------------------------------------------------------------------------------------------------//

		$list = $this->M_deadline->get_money_in_date($end);
		foreach ($list as $row) 
		{
			$mb 	= $this->M_member->get_member($row->member_id);
			//-----------------------------------------------------
			$daybal 	= $this->M_coin->get_balance_id($row->member_id);
				$volume 	= $daybal->volume;
			//-----------------------------------------------------
				
			// 매출금액에 따라 지급율이 다르다.
			/*
			if($row->type == 1){
				$persent 		= $site->cfg_lv1_day;
				$mc_persent 	= $site->cfg_lv1_re;
				$mc2_persent 	= $site->cfg_lv1_re1;
			}
			else if($row->type == 2){
				$persent 		= $site->cfg_lv2_day;
				$mc_persent 	= $site->cfg_lv2_re;
				$mc2_persent 	= $site->cfg_lv2_re1;
			}
			else{
				$persent 		= 0;
				$mc_persent 	= 0;
				$mc2_persent 	= 0;				
			}
			*/

			switch($row->point) {
				case $row->point >= 120000 and $row->point < 360000: $persent = 0.013;break;
				case $row->point >= 360000 and $row->point < 600000: $persent = 0.014;break;
				case $row->point >= 600000 and $row->point < 1200000: $persent = 0.015;break;
				case $row->point >= 1200000 : $persent = 0.017;break;
				default:$persent = 0;break;
			}


			$day_point = $row->point * $persent;
			//-----------------------------------------------------------------------------------------
			// 추천수당 지급하기				
			if($day_point > 0)
			{
				$type 			= "today_su";
				$total_point 	= $daybal->today_su + $day_point;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_point); // 누적
				//---------------------------------------------------------------------------

				$type 			= "su_day";
				$total_su 		= $daybal->su_day + $day_point;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적

				$type 			= "su_day_count";
				$total_su 		= $daybal->su_day_count + 1;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적

				$type 			= "total_point";
				$total_point 	= $daybal->total_point + $day_point;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_point); // 누적
				//---------------------------------------------------------------------------
				// 2020.07.30 박종훈 매출에 관한 데일리수당 합계 추가
				$type 			= "su_day1";
				$total_su 		= $daybal->su_day1 + $day_point;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				
				$type 			= "su_day_count1";
				$total_su 		= $daybal->su_day_count1 + 1;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				//---------------------------------------------------------------------------
				$msg 	= $persent;
				$table 	= 'm_point_su';
				//---------------------------------------------------------------------------
				// 2020.07.30 박종훈 m_point의 order코드를 m_point_su에 추가 , 데일리수당 지급은 cate1 구분값 추가로 다른 모델 사용
				$this->M_deadline->point_exc_day($table, $order_code, $row->order_code, $mb->office, $row->member_id, $row->member_id, $day_point, $row->point, 'su', 'purchase', 'day', $msg, $write_date);
				// $this->M_deadline->point_exc($table, $order_code, $mb->office, $row->member_id, $row->member_id, $day_point, $row->point, 'su', 'day', $msg, $write_date);
				//echo "//$row->member_id, $day_point, $row->point <br>";
				
				$day_total = $day_total + $day_point;
					
			}
			
			/*
			//-----------------------------------------------------------------------------------------------------------------------------------//	
			// 추천매칭수당 지급하기				
			if($day_point > 0 and $row->member_id != 'admin')
			{

				$re 	= $this->M_member->get_member($mb->recommend_id);
				//-----------------------------------------------------
				$mcbal 	= $this->M_coin->get_balance_id($mb->recommend_id);
				$volume 	= $mcbal->volume;
				//-----------------------------------------------------
				
				// SVP 포인트로 지급 - 10원
				$mc_point = $day_point * $mc_persent;
				
				//-----------------------------------------------------------------------------------------
				// 추천매칭수당 지급하기				
				if($mc_point > 0 and $mb->recommend_id != 'admin')
				{					
					$type 			= "today_su";
					$total_point 	= $mcbal->today_su + $mc_point;
					$this->M_point->balance_inout_id($mb->recommend_id,$type,$total_point); // 누적
					//---------------------------------------------------------------------------
			
					$type 			= "su_mc";
					$total_su 		= $mcbal->su_mc + $mc_point;
					$this->M_point->balance_inout_id($mb->recommend_id,$type,$total_su); // 누적
					
					$type 			= "total_point";
					$total_point 	= $mcbal->total_point + $mc_point;
					$this->M_point->balance_inout_id($mb->recommend_id,$type,$total_point); // 누적
					//---------------------------------------------------------------------------
					$msg 	= $mc_persent;
					$table 	= 'm_point_su';
					//---------------------------------------------------------------------------
					// 2020.07.30 박종훈 m_point의 order코드를 m_point_su에 추가
					$this->M_deadline->point_exc($table, $order_code, $row->order_code, $re->office, $mb->recommend_id, $row->member_id, $mc_point, $row->point, 'su', 'mc', $msg, $write_date);
					// $this->M_deadline->point_exc($table, $order_code, $re->office, $mb->recommend_id, $row->member_id, $mc_point, $row->point, 'su', 'mc', $msg, $write_date);
					
					$mc_total = $mc_total + $mc_point;
					//-----------------------------------------------------------------------------------------------------------------------------------//
					// 추천2수당 지급하기	
					if($re->recommend_id != '')
					{				
						$re2 	= $this->M_member->get_member($re->recommend_id);
						//-----------------------------------------------------
						$mc2bal 	= $this->M_coin->get_balance_id($re->recommend_id);
							$volume 	= $mc2bal->volume;
						//-----------------------------------------------------
				
						// SVP 포인트로 지급 - 10원
						$mc2_point = $day_point * $mc2_persent;
						//-----------------------------------------------------------------------------------------
										
						$type 			= "today_su";
						$total_point 	= $mc2bal->today_su + $mc2_point;
						$this->M_point->balance_inout_id($re->recommend_id,$type,$total_point); // 누적
						//---------------------------------------------------------------------------
			
						$type 			= "su_mc2";
						$total_su 		= $mc2bal->su_mc2 + $mc2_point;
						//echo "$total_su 		= $re2bal->su_mc2 + $mc2_point // su_mc2 <br><br>";
						$this->M_point->balance_inout_id($re->recommend_id,$type,$total_su); // 누적
					
						$type 			= "total_point";
						$total_point 	= $mc2bal->total_point + $mc2_point;
						$this->M_point->balance_inout_id($re->recommend_id,$type,$total_point); // 누적
						//---------------------------------------------------------------------------
						$msg 	= $mc2_persent;
						$table 	= 'm_point_su';
						//---------------------------------------------------------------------------
						// 2020.07.30 박종훈 m_point의 order코드를 m_point_su에 추가
						$this->M_deadline->point_exc($table, $order_code, $row->order_code, $re2->office, $re->recommend_id, $row->member_id, $mc2_point, $row->point, 'su', 'mc2', $msg, $write_date);
						// $this->M_deadline->point_exc($table, $order_code, $re2->office, $re->recommend_id, $row->member_id, $mc2_point, $row->point, 'su', 'mc2', $msg, $write_date);
						//echo "//$row->member_id, $day_point, $row->point // $mb->recommend_id -> $mc_point = $day_point * $mc_persent // $re->recommend_id -> $mc2_point = $day_point * $mc2_persent<br>";
					
						$mc2_total = $mc2_total + $mc2_point;
					}				
				}
			}
			*/
		}
		//재매출 반영하기
		log_mon("재매출 반영하기",$start."|".$end);
		$list = $this->M_deadline->get_money_in_date2($end);
		foreach ($list as $row) 
		{
			$mb 	= $this->M_member->get_member($row->member_id);
			//-----------------------------------------------------
			$daybal 	= $this->M_coin->get_balance_id($row->member_id);
				$volume 	= $daybal->volume;
			//-----------------------------------------------------
				
			// 매출금액에 따라 지급율이 다르다.
			if($row->type == 1){
				$persent 		= $site->cfg_lv1_day;
				$mc_persent 	= $site->cfg_lv1_re;
				$mc2_persent 	= $site->cfg_lv1_re1;
			}
			else if($row->type == 2){
				$persent 		= $site->cfg_lv2_day;
				$mc_persent 	= $site->cfg_lv2_re;
				$mc2_persent 	= $site->cfg_lv2_re1;
			}
			else{
				$persent 		= 0;
				$mc_persent 	= 0;
				$mc2_persent 	= 0;				
			}

			$day_point = $row->point * $persent;
			//-----------------------------------------------------------------------------------------
			// 추천수당 지급하기				
			if($day_point > 0)
			{	
				log_mon("수당 지급하기",$row->member_id."|".$row->point);

				$type 			= "today_su";
				$total_point 	= $daybal->today_su + $day_point;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_point); // 누적
				//---------------------------------------------------------------------------

				$type 			= "su_day";
				$total_su 		= $daybal->su_day + $day_point;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적

				$type 			= "su_day_count";
				$total_su 		= $daybal->su_day_count + 1;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적

				$type 			= "total_point";
				$total_point 	= $daybal->total_point + $day_point;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_point); // 누적
				//---------------------------------------------------------------------------
				// 2020.07.30 박종훈 재매출에 관한 데일리 수당 합계
				$type 			= "su_day2";
				$total_su 		= $daybal->su_day2 + $day_point;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적

				$type 			= "su_day_count2";
				$total_su 		= $daybal->su_day_count2 + 1;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				//---------------------------------------------------------------------------
				$msg 	= $persent;
				$table 	= 'm_point_su';
				//---------------------------------------------------------------------------
				// 2020.07.30 박종훈 m_point의 order코드를 m_point_su에 추가
				$this->M_deadline->point_exc_day($table, $order_code, $row->order_code, $mb->office, $row->member_id, $row->member_id, $day_point, $row->point, 'su', 'repurchase','day', $msg, $write_date);

				// $this->M_deadline->point_exc($table, $order_code, $mb->office, $row->member_id, $row->member_id, $day_point, $row->point, 'su', 'day', $msg, $write_date);
				//echo "//$row->member_id, $day_point, $row->point <br>";
				
				$day_total = $day_total + $day_point;
			}
		}
		//-----------------------------------------------------------------------------------------------------------------------------------//
		//---------------------------------------------------------------------------------//
		// 거래소 시세가져오기 -> https://www.idcm.asia/
		//---------------------------------------------------------------------------------//
		// 달러 시세 가져오기
		/*
		$service_url 	= 'https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD';
		$getprice 		= $this->urlapi->get_api($service_url);
		$price_array 	= json_decode($getprice, true);    
		$price 			= $price_array[0]['basePrice'];
		$data['usd'] 	= $price; 
		//---------------------------------------------------------------------------------//
		$sell = get_usd();
		$usd = $sell;
		$won = $sell * $price;

		$cfg_no = 1;		
		$query = array(
			'cfg_usd' 	=> $usd,
			'cfg_won' 	=> $won,
		);
		$this->db->where('cfg_no', $cfg_no);
	//		$this->db->update('m_site', $query);
			--------------------------------------------------------------------------//		

	*/
		//---------------------------------------------------------

		$site  = $this->M_cfg->get_site();
		$usd = $site->cfg_usd;
		$won = $site->cfg_won;
		$leader_point 		= 0;
		$leader_total 		= 0;
		
		// 프리미엄 수당 - 매출 등록한 것에서 3개월이 되는 것을 찾아서 지급한다.
	/*
	프리미엄수당없애기
		$list = $this->M_deadline->get_money_app_date($end);
		foreach ($list as $row) 
		{
			$vip_present = 0;
			
			// 진입 시 금액을 원화로 표시한다.
			$price_first 	= $row->msg; // 진입시
			$price_end 		= $won; // 원화로 계산
			
			$price_chk 		= $row->point * ($price_end / $price_first);
						
			$price_today 	= $price_chk / $row->point;
			
			if($site->cfg_vip1_start > $price_today and $site->cfg_vip1_end <= $price_today){
				$vip_present = $site->cfg_vip1_present;
			}
			else if($site->cfg_vip2_start > $price_today and $site->cfg_vip2_end <= $price_today){
				$vip_present = $site->cfg_vip2_present;
			}
			else if($site->cfg_vip3_start > $price_today and $site->cfg_vip3_end <= $price_today){
				$vip_present = $site->cfg_vip3_present;
			}
			else if($site->cfg_vip4_start > $price_today and $site->cfg_vip4_end <= $price_today){
				$vip_present = $site->cfg_vip4_present;
			}
			else if($site->cfg_vip5_start > $price_today and $site->cfg_vip5_end <= $price_today){
				$vip_present = $site->cfg_vip5_present;
			}
			else if($site->cfg_vip6_start > $price_today and $site->cfg_vip6_end <= $price_today){
				$vip_present = $site->cfg_vip6_present;
			}
			else if($site->cfg_vip7_start > $price_today and $site->cfg_vip7_end <= $price_today){
				$vip_present = $site->cfg_vip7_present;
			}
			else if($site->cfg_vip8_start > $price_today and $site->cfg_vip8_end <= $price_today){
				$vip_present = $site->cfg_vip8_present;
			}
			else if($site->cfg_vip9_start > $price_today){
				$vip_present = $site->cfg_vip9_present;
			}
			else{
				$vip_present = 0;				
			}
			
			//-----------------------------------------------------------------------------------------
			$leader_point = $row->point * $vip_present;
			//-----------------------------------------------------------------------------------------
			
			if($leader_point > 0)
			{

				$rebal 	= $this->M_coin->get_balance_id($row->member_id);


				$type 			= "today_su";
				$total_point 	= $rebal->today_su + $leader_point;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_point); // 누적
				//---------------------------------------------------------------------------

				$type 			= "su_day";
				$total_su 		= $rebal->su_level + $leader_point;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적

				$type 			= "total_point";
				$total_point 	= $rebal->total_point + $leader_point;
				$this->M_point->balance_inout_id($row->member_id,$type,$total_point); // 누적
				//---------------------------------------------------------------------------
				$msg 	= $vip_present;
				$table 	= 'm_point_su';
				$this->M_deadline->point_exc($table, $order_code, $price_today, $row->member_id, $row->member_id, $leader_point, $row->point, 'su', 'level', $msg, $write_date);
				//echo "//$row->member_id, $day_point, $row->point <br>";
				
				$leader_total = $leader_total + $leader_point;
					
			}
		
		}
		*/
		
		//-----------------------------------------------------------------------------------------------------------------------------------//	
		$ct_point 		= 0;
		$ct_total 		= 0;
		//-----------------------------------------------------------------------------------------------------------------------------------//	
				
		// 총 들어온 매출, 총 전환한 금액, 총 일지급금액, 총 적립추천처리금액,
		$this->M_deadline->deadline_update($dead_no, $in_total, $out_total, $day_total, $re_total, $re2_total, $mc_total, $mc2_total, $leader_total);
		echo 1;exit;
		//alert("마감완료! $count_date", "admin/deadline/lists");
		
	}

	//-----------------------------------------------------------------------------------------------------------------------------------//
		//-----------------------------------------------------------------------------------------------------------------------------------//
	// 불륨 처리
	function vlm_tree($order_code,$name,$member_id,$sponsor_id,$amount,$dep,$regdate){

		$get_member = $this->M_member->get_member($member_id); // 회원정보가져오기

		while ($get_member->sponsor_id != NULL AND $member_id != 'admin') {

			$side = $this->M_office->get_sp_side($get_member->sponsor_id,$get_member->member_id); // 나는 스폰서의 좌우 어디에 있나? - 없으면 1
			
			if ($side == '1') {
				$point= $amount;
				$side = 'left';
			}
			else if ($side == '2' ) {
				$side = 'right';
				$point = $amount;
			}
			else{
				$side = 'middle';
				$point = $amount;
				
			}
			
			// DB 기록
			$this->M_office->vlm_in($order_code,$name,$get_member->sponsor_id,$member_id,$get_member->recommend_id,$side,$point,$dep,$regdate);
			
			// 상위 유저 찾기 (스폰서)
			$get_member = $this->M_member->get_member($get_member->sponsor_id); // 회원정보가져오기
				
		}
	}

	// 마감삭제 - 수당에서도 삭제한다.
	function delete()
	{	
		$order_code = $this->input->post('order_code');
		
		$De = $this->M_point->get_point_ordercode('m_deadline', $order_code);
			$regdate = date("Y-m-d", strtotime($De->regdate));
			
		$this->db->where('order_code', $order_code);
		$this->db->delete('m_deadline');
		
		
		$this->db->where('order_code', $order_code);
		$this->db->delete('m_point');			
		
		$table = 'm_point_su';
		$list = $this->M_point->get_point_code($table,$order_code);
		foreach ($list as $row) 
		{
			$Bal 	= $this->M_coin->get_balance_id($row->member_id);
			
			$type 			= "total_point";
			$total_point 	= $Bal->total_point - $row->point;
			$this->M_point->balance_inout_id($row->member_id,$type,$total_point); // 누적	
			
				if($row->kind == 'ct'){
					$type 		= "su_ct";				
					$total_su 	= $Bal->su_ct - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				}
				else if($row->kind == 'ctre'){
					$type 		= "su_ct_re";				
					$total_su 	= $Bal->su_ct_re - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				}
				
				else if($row->kind == 'day'){
					$type 		= "su_day";				
					$total_su 	= $Bal->su_day - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
					
					$type 		= "su_day_count";				
					$total_su 	= $Bal->su_day_count - 1;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
					//---------------------------------------------------------------------------
					// 2020.07.30 박종훈 매출, 재매출 삭제 추가 
					/*
					if($row->cate1 == 'purchase') {
						$type 			= "su_day1";
						$total_su 		= $Bal->su_day1 - $row->point;
						$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
						
						$type 			= "su_day_count1";
						$total_su 		= $Bal->su_day_count1 - 1;
						$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
					} else if($row->cate1 == 'repurchase') {
						$type 			= "su_day2";
						$total_su 		= $Bal->su_day2 - $row->point;
						$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
						
						$type 			= "su_day_count2";
						$total_su 		= $Bal->su_day_count2 - 1;
						$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
					}
					*/
					//---------------------------------------------------------------------------
				}
				
				else if($row->kind == 're'){
					$type 		= "su_re";				
					$total_su 	= $Bal->su_re - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				}
				
				else if($row->kind == 're2'){
					$type 		= "su_re2";				
					$total_su 	= $Bal->su_re2 - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적										
				}
				
				else if($row->kind == 'mc'){
					$type 		= "su_mc";				
					$total_su 	= $Bal->su_mc - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				}
				
				else if($row->kind == 'mc2'){
					$type 		= "su_mc2";				
					$total_su 	= $Bal->su_mc2 - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				}
				
				else if($row->kind == 'level'){
					$type 		= "su_level";				
					$total_su 	= $Bal->su_level - $row->point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적
				}
		}
		
		$this->db->where('order_code', $order_code);
		$this->db->delete('m_point_su');
		
		//--------------------------------------------------------------------------------------		
		//--------------------------------------------------------------------------------------
		// 임시 센타비를 저장하는곳			
		$this->db->where('order_code', $order_code);
		$this->db->delete('m_point_total');

		goto_url($_SERVER['HTTP_REFERER']);
		
	}

	public function repurchase() {
		$this->load->helper('log');
		$count_date 	= date("Y-m-d");
		$count_date 	= '2020-07-19';
		
		$start 			= $count_date." 00:00:00";				
		$end 			= $count_date." 23:59:59";		
		$regdate		= $end;
		$write_date = date("Y-m-d 23:59:59", strtotime($end."+1day")); // 지급일은 1일 후

		$site 			= $this->M_cfg->get_site();
		
		$order_code 	='200719235901268'; //주문코드 생성			
		$list = $this->M_deadline->get_money_in_date2($end);
		foreach ($list as $row) 
		{
			$mb 	= $this->M_member->get_member($row->member_id);
			//-----------------------------------------------------
			$daybal 	= $this->M_coin->get_balance_id($row->member_id);
				$volume 	= $daybal->volume;
			//-----------------------------------------------------
				
			// 매출금액에 따라 지급율이 다르다.
			if($row->type == 1){
				$persent 		= $site->cfg_lv1_day;
				$mc_persent 	= $site->cfg_lv1_re;
				$mc2_persent 	= $site->cfg_lv1_re1;
			}
			else if($row->type == 2){
				$persent 		= $site->cfg_lv2_day;
				$mc_persent 	= $site->cfg_lv2_re;
				$mc2_persent 	= $site->cfg_lv2_re1;
			}
			else{
				$persent 		= 0;
				$mc_persent 	= 0;
				$mc2_persent 	= 0;				
			}

			$day_point = $row->point * $persent;
			//-----------------------------------------------------------------------------------------
			// 추천수당 지급하기	
			
			if($day_point > 0)
			{
				//echo "id::".$row->member_id."::point::".$day_point."row->point".$row->point."<br>";
				if($row->member_id=='578900') {
					$type 			= "today_su";
					$total_point 	= $daybal->today_su + $day_point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_point); // 누적
					//---------------------------------------------------------------------------

					$type 			= "su_day";
					$total_su 		= $daybal->su_day + $day_point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적

					$type 			= "su_day_count";
					$total_su 		= $daybal->su_day_count + 1;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_su); // 누적

					$type 			= "total_point";
					$total_point 	= $daybal->total_point + $day_point;
					$this->M_point->balance_inout_id($row->member_id,$type,$total_point); // 누적
					//---------------------------------------------------------------------------
					$msg 	= $persent;
					$table 	= 'm_point_su';
					//---------------------------------------------------------------------------
					// 2020.07.30 박종훈 m_point의 order코드를 m_point_su에 추가
					$this->M_deadline->point_exc($table, $order_code, $row->order_code, $mb->office, $row->member_id, $row->member_id, $day_point, $row->point, 'su', 'day', $msg, $write_date);
					// $this->M_deadline->point_exc($table, $order_code, $mb->office, $row->member_id, $row->member_id, $day_point, $row->point, 'su', 'day', $msg, $write_date);
					//echo "//$row->member_id, $day_point, $row->point <br>";
					
					$day_total = $day_total + $day_point;
				}
				
				
			}
			
		}

	}
}
?>
