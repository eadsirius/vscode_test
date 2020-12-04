<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exchange extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('file','form', 'url','search'));
		$this->load->library('form_validation');

		$this->load->library('Elwallet_api');
		$this->load->library('qrcode');

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

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		//---------------------------------------------------------------------------------//

		$data['mb'] 	= $this->M_member->get_member($login_id);
		$bal 	= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		//---------------------------------------------------------------------------------//
		$chk = $this->M_coin->get_wallet_chk($login_id,'exchange');
		//---------------------------------------------------------------------------------//
		if(empty($chk)){			
		}
		else
		{
			$data['wallet'] = $this->M_coin->get_wallet_address($login_id,'exchange');			
		}
		//---------------------------------------------------------------------------------//
		$this->form_validation->set_rules('address', 'address', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			if(empty($chk)){
				layout('token/addressReg',$data, 'office');				
			}
			else{
				layout('token/wallet',$data, 'office');	
			}
		
		}
		else
		{
			if(empty($chk))
			{
				$type = 'exchange';
				$addr = $this->input->post('address');
			
				$qrimg_id = $login_id .'_E'; // ico qrcode
				qrcode($qrimg_id,$addr);
			
				$qrimg = $login_id ."_E.png"; // ico qrcode
			
				$this->M_coin->set_wallet_in($login_id,$addr,$qrimg,$type);
			
				redirect('/token/exchange');
			}
			else{
				
			}
			
		}
	}
	
}