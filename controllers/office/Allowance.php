<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Allowance extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('file','form', 'url','search'));
		$this->load->library('form_validation');
		
		$this->load->library('Elwallet_api');
		$this->load->library('urlapi');		
		$this->load->library('bitcoin');

		//모델 로드
		$this->load->model('M_admin');
		$this->load->model('M_cfg');
		$this->load->model('M_member');
		$this->load->model('M_office');
		$this->load->model('M_point');
		$this->load->model('M_coin');
		
		// 미 로그인 상태라면
		loginCheck();

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
		$data['header'] = array('title'=>'Allowance','group'=>'POINT');
		$site = $this->M_cfg->get_site();
		$data['site'] = $site;
		$data['active'] = "mu4";
		
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_member->get_member($login_id);
			$office = $data['mb']->office;
			
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'wns');
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;		
		//---------------------------------------------------------------------------------//
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

		$cfg_no = 1;		
		$query = array(
			'cfg_usd' 	=> $usd,
			'cfg_won' 	=> $won,
		);
	//	$this->db->where('cfg_no', $cfg_no);
	//	$this->db->update('m_site', $query);
		
			$site 			= $this->M_cfg->get_site();
			$data['USNS_USD'] = $site->cfg_usd;
			$data['USNS_WON']  = $site->cfg_won;

		//---------------------------------------------------------------------------------//
		$data = page_lists('m_point_su','point_no',$data,'member_id',$login_id);
		//$data['history'] = $this->M_point->get_point('m_point_su',$login_id,'su','day');
		//---------------------------------------------------------------------------------//		

		layout('office/allowance',$data,'office');			
	}
	
	public function day()
	{	
		if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {
			$this->output->enable_profiler($this->config->item('profiler'));
		}

		$data = $member = array();
		$data['header'] = array('title'=>'Allowance','group'=>'POINT');
		$site = $this->M_cfg->get_site();
		$data['site'] = $site;
		
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_coin->getBalanceList($member_no,$login_id);

		$data = page_lists('m_point_su','regdate , point_no',$data,'member_id',$login_id,'kind','day');
		
		//---------------------------------------------------------------------------------//		

		layout('office/allowance',$data,'office');				
	}
	
	public function re()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'Allowance','group'=>'POINT');
		$site = $this->M_cfg->get_site();
		$data['site'] = $site;
		$data['active'] = "mu4";
		
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_coin->getBalanceList($member_no,$login_id);

		//---------------------------------------------------------------------------------//
		// 데일리수당 보여주기
		$data = page_lists('m_point_su','point_no',$data,'member_id',$login_id,'kind','re');
		//---------------------------------------------------------------------------------//		

		layout('office/allowance',$data,'office');			
		
	}
	
	
	public function mc()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'Allowance','group'=>'POINT');
		$site = $this->M_cfg->get_site();
		$data['site'] = $site;
		$data['active'] = "mu4";
		
		$login_id = $this->session->userdata('member_id');	
		$member_no 	= $this->session->userdata('member_no');	
		//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_coin->getBalanceList($member_no,$login_id);
		//---------------------------------------------------------------------------------//
		// 데일리수당 보여주기
		$data = page_lists('m_point_su','regdate',$data,'member_id',$login_id,'kind','mc');
		//---------------------------------------------------------------------------------//		

		layout('office/allowance',$data,'office');			
		
	}

	public function totalDaySu()
	{
		$data = array();
		$data['header'] = array('title'=>'Allowance','group'=>'POINT');
		$site = $this->M_cfg->get_site();
		$data['site'] = $site;

		$page	= $this->input->get('page');
		$size =15;
		if(empty($page) || !isInt($page)) $page = 1;

		$input["page"]      	= $page;
		$input["size"]      	= $size;
		$input["limit_ofset"]	= ($page-1) * $size;
		
		$login_id = $this->session->userdata('member_id');	
    $member_no 	= $this->session->userdata('member_no');	
		$input["login_id"] = $login_id;
			//---------------------------------------------------------------------------------//
		$data['mb'] = $this->M_coin->getBalanceList($member_no,$login_id);
	
		$day_list = $this->M_office->get_day_lists($input);
		// $data = page_lists_total_day('m_point_su','x.regdate',$data,'member_id',$login_id);
		//---------------------------------------------------------------------------------//		
		$data['list']		= $day_list['page_list'];
		$data['total_count']	= $day_list['total_cnt'];
		$data['input']		= $input;
		
		layout('office/total_day',$data,'office');			
		
	}
	


}