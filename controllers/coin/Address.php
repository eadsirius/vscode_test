<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address extends CI_Controller {
	
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
		$this -> load -> model('M_cfg');
		$this -> load -> model('M_admin');
		$this -> load -> model('M_member');
		$this -> load -> model('M_office');
		$this -> load -> model('M_point');
		$this -> load -> model('M_coin');

		loginCheck();
	}
	
	public function index()
	{
		$data = array();
		$data['site'] = $this->M_cfg->get_site();

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		/*
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'agc');
		$data['hvrex'] = $this->M_coin->get_wallet_address($login_id,'hvrex');
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------//
		$contractaddress = "0x2521ed9624aa976d282bb248aa62257a207ff182";
		$address = $data['hvrex'];
				
		$url='https://api.etherscan.io/api?module=account&action=tokenbalance&address='.$address.'&c=09&page=1&offset=1000&sort=asc&contractaddress='.$contractaddress.'&apikey=YourApiKeyToken';
		$datas = json_decode(file_get_contents($url));
		$Hcoin_Balance = number_format(sprintf('%0.4f', $datas->result/100000000),4);
		
		$type 		= "hvrex";
		$Hcoin 		= $Hcoin_Balance - $bal->hvc;
		$this->M_point->balance_inout_id($login_id,$type,$Hcoin);
		//---------------------------------------------------------------------------------//
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		*/
		//---------------------------------------------------------------------------------//
		//---------------------------------------------------------------------------------//
		layout('coin/address',$data, 'office');	
	}
	
	
}
