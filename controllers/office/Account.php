<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('file','form', 'url','search'));
		$this->load->library('form_validation');
		
		$this->load->library('Elwallet_api');	

		//모델 로드
		$this->load->model('M_admin');
		$this->load->model('M_cfg');
		$this->load->model('M_member');
		$this->load->model('M_office');
		$this->load->model('M_point');
		$this->load->model('M_coin');
		
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
	
	public function lists()
	{
		$data = $member = array();
		$data['site'] = $this->M_cfg->get_site();
		$select_lang = 'kr';
		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->M_coin->getBalanceList($member_no,$login_id);

		$data['reCnt'] = $this->M_member->get_recommend_chk($login_id);
		$data['recommend_total'] = $this->M_member->getRecommendTotalSales($login_id);
		
		// 추천정보 가져오기
		$data['history'] = $this->M_member->getRecommendList($login_id);

		layout('office/account',$data,'office');			
	}

	//---------------------------------------------------------------------------------//
		//---------------------------------------------------------------------------------//
	function matrixRe()
	{
		$data = $member = array();
		$data['site'] = $this->M_cfg->get_site();

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet($login_id);
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		$free 	= $this->M_point->get_point_id('m_point',$member_no);
		$data['free'] = $free;
		//---------------------------------------------------------------------------------//
		// 추천횟수 - 추천인 몇명인지 가져오기
		//---------------------------------------------------------------------------------//
		$data['reCnt'] = $this->M_member->get_recommend_chk($login_id);
    $user_info = $this->M_member->getSalesTotalInfo($login_id);
    $data['user_sales'] = $user_info->sales;
    if($user_info->sales > 0){
      $data['user_percent'] = ($user_info->total_point/($user_info->sales*2))*100;
    }else{
      $data['user_percent'] = 0;
    }
    

		//layout('office/matrixRe',$data,'office');
		layout('office/matrixRecommend',$data,'office');
	}
	
	
	function matrixSp()
	{
		$data = $member = array();
		$data['site'] = $this->M_cfg->get_site();

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet($login_id);
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------//
		// 추천횟수 - 추천인 몇명인지 가져오기
		//---------------------------------------------------------------------------------//
		$data['reCnt'] = $this->M_member->get_recommend_chk($login_id);
		//---------------------------------------------------------------------------------//
		
		$select_id = $this->uri->segment(4,0);
		if(empty($select_id)){
			$select_id = $login_id;
		}
		else{	
			$select_id = $select_id;		
		}
		$data['select_id'] = $select_id;

		$data['mb'] 	= $this->M_member->get_member($data['select_id']);

		//alert("$select_id");
		$choice_id 	= $this->uri->segment(5,0);
		$postion 	= $this->uri->segment(4,0);

		if($select_id == 'left'){			
			redirect('/member/invite/addRegister/'.$choice_id ."/".$postion);
		}
		else if($select_id == 'right'){			
			redirect('/member/invite/addRegister/'.$choice_id ."/".$postion);
		}
		
		/*
		// 가공 - 총 매출 금액확인
		$i = 0;
		$data = page_lists('m_volume','vlm_no',$data,'member_id',$login_id);
        foreach ($data['item'] as $row) 
        {
			$i = $i + 1;
			$row->name = $this->M_member->get_member_name($row->event_id);
   		}
   		*/
		//---------------------------------------------------------------------------------//
		
		layout('member/matrixSp',$data,'office');
	}
	
	function binary()
	{
		$data = $member = array();
		$data['site'] = $this->M_cfg->get_site();

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet($login_id);
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------//
		// 추천횟수 - 추천인 몇명인지 가져오기
		//---------------------------------------------------------------------------------//
		$data['reCnt'] = $this->M_member->get_recommend_chk($login_id);
		//---------------------------------------------------------------------------------//
		
		$select_id = $this->uri->segment(4,0);
		if(empty($select_id)){
			$select_id = $login_id;
		}
		else{	
			$select_id = $select_id;		
		}
		$data['select_id'] = $select_id;

		$data['mb'] 	= $this->M_member->get_member($data['select_id']);

		//alert("$select_id");
		$choice_id 	= $this->uri->segment(5,0);
		$postion 	= $this->uri->segment(4,0);

		if($select_id == 'left'){			
			redirect('/member/invite/addRegister/'.$choice_id ."/".$postion);
		}
		else if($select_id == 'right'){			
			redirect('/member/invite/addRegister/'.$choice_id ."/".$postion);
		}
		/*
		// 가공 - 총 매출 금액확인
		$i = 0;
		$data = page_lists('m_volume','vlm_no',$data,'member_id',$login_id);
        foreach ($data['item'] as $row) 
        {
			$i = $i + 1;
			$row->name = $this->M_member->get_member_name($row->event_id);
   		}
   		*/
		//---------------------------------------------------------------------------------//
		
		layout('member/matrixSp',$data,'office');
	}
	//---------------------------------------------------------------------------------//
		//---------------------------------------------------------------------------------//
	
	function tree()
	{
		$data = $member = array();
		$data['site'] = $this->M_cfg->get_site();
		
		$member_no 	= $this->session->userdata('member_no');
		$login_id = $this->session->userdata('member_id');
				
		$data['mb'] 	= $this->M_member->get_member($login_id);
		//---------------------------------------------------------------------------------//
		
		$table = 'm_volume1';
		$data['re'] 	= $this->M_office->get_vlm_li($table,$login_id);
		$data['reTotal'] 	= $this->M_office->vlm_my_chk($table,$login_id);
		
		//---------------------------------------------------------------------------------//
		
		layout('member/matrixRe',$data,'office');
	}
	
	
	function sp()
	{
		$data = $member = array();
		$data['site'] = $this->M_cfg->get_site();
		
		$member_no 	= $this->session->userdata('member_no');
		$login_id = $this->session->userdata('member_id');
		//---------------------------------------------------------------------------------//
		
		$mb = $this->M_member->get_member($login_id);
			$data['vlm_so'] 			= $mb->vlm_so;
			$data['vlm_left'] 			= $mb->vlm_left;
			$data['vlm_left_point'] 	= $mb->vlm_left_point;
			$data['vlm_right'] 			= $mb->vlm_right;
			$data['vlm_right_point'] 	= $mb->vlm_right_point;
			$data['vlm_total'] 			= $mb->vlm_left_point + $mb->vlm_right_point;	
			
		if($mb->vlm_left_point >= $mb->vlm_right_point){
			$data['vlm_post'] = 'right';
		}
		else{
			$data['vlm_post'] = 'left';			
		}
		
		//---------------------------------------------------------------------------------//
		
		// 가공 - 총 매출 금액확인
		$i = 0;
		$amount = 0;
		$data = page_lists2('m_volume','vlm_no',$data,'member_id',$login_id);
        foreach ($data['item'] as $row) 
        {
			$i = $i + 1;
			$row->name = $this->M_member->get_member_name($row->event_id);
   		}
        
		$data['cnt'] 		= $i;
		$data['amount'] 	= $amount;        
		$data['auth'] 		= md5($login_id);	
		
		layout('office/matrixSp',$data,'office');
	}
	
	
	function re()
	{
		$data = $member = array();
		$data['site'] = $this->M_cfg->get_site();
	
		$member_no 	= $this->session->userdata('member_no');
		$login_id = $this->session->userdata('member_id');
		
		$data['cnt'] = $this->M_member->re_check($login_id); // 총 추천수
		
		$data['account_li'] = $this->M_member->get_recommend_li($login_id); // 어카운트 리스트 가져오기
		
        foreach ($data['account_li'] as $row) 
        {
			$row->name = $this->M_member->get_member_name($row->member_id);
        }  
		
		$data['auth'] = md5($login_id );		

		layout('office/matrixRe',$data,'office');

	}
}