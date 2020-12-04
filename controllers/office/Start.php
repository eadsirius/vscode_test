<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Start extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();

		$this->load->library('Elwallet_api');
		$this->load->library('urlapi');	

		//모델 로드
		$this->load->model('M_cfg');
		$this->load->model('M_point');
		$this->load->model('M_office');
		$this->load->model('M_coin');
		$this->load->model('M_member');
		$this->load->model('M_bbs');

		loginCheck();
	}
	
	public function index()
	{
		
		if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {
			$this->output->enable_profiler($this->config->item('profiler'));
		}

		$data = array();
		$site 			= $this->M_cfg->get_site();
		$data['site'] 	= $site;
		$data['select_lang'] = "kr";
		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');

		$data['mb'] 	= $this->M_member->get_member($login_id);
    
    $total_balance = $this->M_coin->getBalanceList($member_no,$login_id);
    $data['total_balance'] = $total_balance;
    
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

		$data['Recnt'] 	= $this->M_member->re_check($login_id);
		$data['USNS_USD'] = $site->cfg_usd;
		$data['USNS_WON'] = $site->cfg_won;;
		$data['POINT_WON'] = $site->cfg_point_won;
    layout('office/start',$data,'office');	
	}
	
}
