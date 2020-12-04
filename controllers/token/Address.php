<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('file','form', 'url','search'));
		$this->load->library('form_validation');

		$this->load->library('Elwallet_api');

		//모델 로드
		$this->load->model('M_cfg');
		$this->load->model('M_admin');
		$this->load->model('M_point');
		$this->load->model('M_coin');
		$this->load->model('M_member');
		$this->load->model('M_bbs');
		
		
		loginCheck();
	}
	
	public function index()
	{
		$data = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'OFFICE');
		$data['site'] = $this->M_cfg->get_site();
		$data['active'] = "mu2";

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		//---------------------------------------------------------------------------------//

		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'wns');
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
	
		//---------------------------------------------------------------------------------//
		
		$data = page_lists('m_coin','coin_no',$data,'member_id',$login_id,'cate','wns');
		//---------------------------------------------------------------------------------//
		layout('token/address',$data, 'office');	
	}
	
}
