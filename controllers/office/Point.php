<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Point extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('file','form', 'url','search'));
		$this->load->library('form_validation');
		
		$this->load->library('Elwallet_api');
		//$this->load->library('bitcoin');	
		//$this -> load -> model('m_coin');	

		//모델 로드
		$this -> load -> model('M_admin');
		$this -> load -> model('M_cfg');
		$this -> load -> model('M_member');
		$this -> load -> model('M_office');
		$this -> load -> model('M_point');
		$this->load->model('M_coin');
		$this ->lang = get_cookie('lang');
		
		// 미 로그인 상태라면
		loginCheck();
		// 2020.07.22 박종훈 추가
		if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {
			$this->output->enable_profiler($this->config->item('profiler'));
		}
	}
	
	public function index()
	{
		$this->lists();
		
	}


	public function exchange()
	{
		$data = $member 	= array();
		$data['header'] 	= array('title'=>'나의구좌','group'=>'PLAN');
		$data['site'] = $this->M_cfg->get_site();
		
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] = $this->M_member->get_member($login_id);
		//---------------------------------------------------------------------------------/			
			
		$this->form_validation->set_rules('count', 'count', 'required');		
		
		if ($this->form_validation->run() == FALSE)
		{
			alert(get_msg($this ->lang, '출금신청 금액을 확인하세요'));
			
		}
		else 
		{			
			// 활동 중지상태-----------------------------------------------------------------------//
			$member 	= $this->M_member->get_member($login_id); 			// 회원정보
				$member_country 	= $member->country;
				$member_open		= $member->is_close; // 활동정지 여부	
				$member_send		= $member->type; 	// 보내기 가능	
				
			if($member_open == 1){alert(get_msg($this ->lang, '활동 중지상태 입니다.'));}	
			
			$mb 	= $this->M_member->get_member($login_id);
			$bal 	= $this->M_coin->get_balance($member_no);
			$order_code = order_code();  // 주문코드 만들기	
			$regdate 	= nowdate();
			// 락걸기-----------------------------------------------------------------------//
			
			$count 	= trim($this->input->post('count'));
			$fee 	= trim($this->input->post('fee'));
			$amount = trim($this->input->post('amount'));
			
			
			if($count < 100){
				alert(get_msg($this ->lang, '최소출금 금액을 확인하세요'));	
			}	
		
			if($count > $bal->total_point){
				alert(get_msg($this ->lang, '출금 코인 잔고를 확인하세요'));	
			}
			
			$nowDate = nowday();
			$sendDay = yoilDate($regdate);
			if($sendDay == 'n'){
				alert(get_msg($this ->lang, '영업일에만 가능합니다.'));				
			}
			
			$start 		= $nowDate ." 00:00:00";
			$end 		= $nowDate ." 23:59:59";
			$db_table 	= 'm_point';
			$cate		= 'out';
			$chk_send 	= $this->M_point->point_ex_chk($db_table,$login_id,$cate,$start,$end); // 하루한번만
			if($chk_send >= 1){
				alert(get_msg($this ->lang, '출금횟수에 도달하였습니다!'));
			}
			
			$type 		= "total_point";
			$point 		= $bal->total_point - $count;
			$this->M_point->balance_inout($member_no,$type,$point); // 포인트
			
			$type 		= "point_out";
			$point 		= $bal->point_out + $amount;
			$this->M_point->balance_inout($member_no,$type,$point); // 매출금액
			
			$type 		= "point_fee";
			$point 		= $bal->point_fee + $fee;
			$this->M_point->balance_inout($member_no,$type,$point); // 매출금액
			//--------------------------------------------------------------------------------//
			
			$table = 'm_point_out';
			$thing = $fee;
			$this->M_point->pay_exc($table, $order_code, $mb->country, $thing, $mb->office, $login_id, $login_id, $amount, $count, 'out','request');	
			
			//--------------------------------------------------------------------------------//
				
			redirect('/office/point/exok/' .$count ."/" .$fee ."/" .$amount);
		}

	}
	
	
	// 보낸 결과값 보여주기
	public function exok()
	{
		$data = array();
		$data['header'] = array('title'=>'PAY','group'=>'OFFICE');
		
		$login_id = $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] = $this->M_member->get_member($login_id);
		$data['bal'] = $this->M_coin->get_balance($member_no);
		
		$data['send_count'] = $this->uri->segment(4,0);
		$data['send_fee'] = $this->uri->segment(5,0);
		$data['send_amount'] = $this->uri->segment(6,0);
		
		//---------------------------------------------------------------------------------//
		$lang = get_cookie('lang');

		layout('/office/pointOut_exOk',$data,'office');

	}

	public function out()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'나의구좌','group'=>'POINT');
		$data['site'] = $this->M_cfg->get_site();
		
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_member->get_member($login_id);
		//---------------------------------------------------------------------------------//		
		$data['bal'] = $this->M_coin->get_balance($member_no);
			//$data['balSu'] = $data['bal']->su_day + $data['bal']->su_re + $data['bal']->su_re2 + $data['bal']->su_sp_roll + $data['bal']->su_ct + $data['bal']->su_ct_re;
			$data['balSu'] = $data['bal']->total_point;
		//---------------------------------------------------------------------------------//		
		//---------------------------------------------------------------------------------//
		layout('/office/pointOut',$data,'office');
		
	}

	public function outList()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'나의구좌','group'=>'POINT');
		
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_member->get_member($login_id);
			$office = $data['mb']->office;
			$office_group = $data['mb']->office_group;
		
		$data['ct'] = '';
		$ct_jang = $this->M_member->get_center_jang($office);
		if($login_id == $ct_jang){
			$data['ct'] = 'y';
		}
		//---------------------------------------------------------------------------------//		
		$data['bal'] = $this->M_coin->get_balance($member_no);
			//$data['balSu'] = $data['bal']->su_day + $data['bal']->su_re + $data['bal']->su_re2 + $data['bal']->su_sp_roll + $data['bal']->su_ct + $data['bal']->su_ct_re;
			$data['balSu'] = $data['bal']->total_point;

		//---------------------------------------------------------------------------------//
		
		$data = page_lists('m_point_out','point_no',$data,'member_id',$login_id,'cate','out');
		//---------------------------------------------------------------------------------//
		layout('/office/pointOutlist',$data,'office');
		
	}
	
	
	public function lists()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'나의구좌','group'=>'POINT');
		
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_member->get_member($login_id);
			$office = $data['mb']->office;
		
		$data['ct'] = '';
		$ct_jang = $this->M_member->get_center_jang($office);
		if($login_id == $ct_jang){
			$data['ct'] = 'y';
		}
		//---------------------------------------------------------------------------------//		
		$data['bal'] = $this->M_coin->get_balance($member_no);
			//$data['balSu'] = $data['bal']->su_day + $data['bal']->su_re + $data['bal']->su_re2 + $data['bal']->su_sp_roll + $data['bal']->su_ct + $data['bal']->su_ct_re;
			$data['balSu'] = $data['bal']->total_point;
		//---------------------------------------------------------------------------------//
		// 데일리수당 보여주기
		$data['history'] = $this->M_point->get_point('m_point_su',$login_id,'su','day');
		
		$data = page_lists('m_point_su','point_no',$data,'member_id',$login_id,'cate','su');
		//---------------------------------------------------------------------------------//
		layout('/office/pointLists',$data,'office');
		
	}
}