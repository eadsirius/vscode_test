<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Token extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('file','form', 'url','search'));
		$this->load->library('form_validation');

		$this->load->library('Elwallet_api');

		//모델 로드
		$this->load->model('M_cfg');
		$this -> load -> model('M_admin');
		$this->load->model('M_point');
		$this->load->model('M_coin');
		$this->load->model('M_member');
		$this->load->model('M_bbs');
		$this ->lang = get_cookie('lang');

		loginCheck();
		// 2020.07.22 박종훈 추가
		if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {
			$this->output->enable_profiler($this->config->item('profiler'));
		}
	}
	
	public function index()
	{
		$data = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'OFFICE');
		$data['site'] = $this->M_cfg->get_site();

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet($login_id);
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------//
		
		$data = page_lists('m_coin','coin_no',$data,'member_id',$login_id);
		//---------------------------------------------------------------------------------//
		
		layout('office/token',$data, 'office');
	}
	
	public function airdrop()
	{
		$data = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'OFFICE');
		$data['site'] = $this->M_cfg->get_site();

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet($login_id);
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------//
		// 에어드롭 지급율 구하기 - 매출금 * %
		$table		= 'm_point';
		$nowday 	= nowday();
		$start 		= $nowday." 00:00:00";		
		$end 		= $nowday." 23:59:59";
		$cate		= 'su';
		$kind		= 'day';
		$send_week = $this->M_point->get_point_today_sum($table,$login_id,$start,$end,$cate,$kind); // 지난주 나간 것 구하기
		
		if($bal->level == 0){
			$day_pre 			= 0;
			$data['send_today'] = 0;
			$data['send_week'] 	= 0;
			$data['send_total'] = 0;			
		}
		else{
			$day_pre 			= $data['site']->cfg_level1_airdrop;
			$data['send_today'] = $bal->total_point * $day_pre;
			$data['send_week'] 	= $send_week + $data['send_today'];
			$data['send_total'] = $bal->su_day + $data['send_week'];			
		}
		//---------------------------------------------------------------------------------//
		
		$data = page_lists('m_point','point_no',$data,'member_id',$login_id,'kind','day');
		//---------------------------------------------------------------------------------//
		layout('office/airdrop',$data, 'office');
		
	}
	
}
