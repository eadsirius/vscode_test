<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Qmopt extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url', 'office'));
		
		$this->load->library('form_validation');		
		//$this->load->library('bitcoin');
		$this->load->library('qrcode');
		
		$this->load->library('Validtoken');
		
		
		
		$this->load-> model('m_cfg');
		$this->load-> model('m_member');
		$this->load-> model('m_point');
		$this->load-> model('m_coin');
		$this->load-> model('m_office');
		
	}
	
	function index()
	{
		$this->otp_generator();
	}
	
	/**
	 * OTP 생성
	 */
	public function otp_generator()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'Member');
		$site 			= get_site();
		$data['site'] 	= $site;
		$data['active'] = "mu6";

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->m_member->get_member($login_id);
		//---------------------------------------------------------------------------------/	
		$data['country'] = $this->m_member->get_country_li();
		//---------------------------------------------------------------------------------//
		$bal 	= $this->m_coin->get_balance_id($login_id);
		//---------------------------------------------------------------------------------//
		
		
		$this->load->library('otp');

		$secretKey = $this->otp->createSecret();

		//$data['verifyURL'] = '/' . $this->validtoken->create('otp', $member_no, ['secret_key' => $secretKey]);
		
		$data['secretKey'] = $secretKey;
		
		$data['qrCode'] = $this->otp->getQRCodeGoogleUrl('questxmining.' . $login_id, $secretKey, 'qm');
		print json_encode($vars);
		
		
		layout('/member/opt_create',$data,'office');
	}

	// ------------------------------------------------------------------------

	/**
	 * OTP 생성
	 */
	public function otp_remove()
	{
		$this->setLayout('ajax');
		$params = &$this->vars['params'];


		// 신규 비밀번호 확인
		if (empty($params['confirm']) == TRUE) {
			fn_page_back(-1, '비밀번호를 입력하세요.');
		}
		// 현재 비밀번호 유효성 체크
		else if ($this->Account_model->verifyPassword($this->member['mb_no'], $params['confirm']) !== TRUE) {
			fn_page_back(-1, '현재 사용 중인 비밀번호가 일치하지 않습니다.');
		}

		$this->Account_model->trans_begin();
		$remote_addr = $this->vars['REMOTE_ADDR'];
		$agent_id = $this->Account_model->getUserAgentID();
		$this->Account_model->removeAuthStatus($this->member['mb_no'], 'otp');
		$this->Account_model->setAccountHistory([
			'mb_no' => $this->member['mb_no'],
			'mbh_code' => 'otp_remove',
			'mbh_value' =>'',
			'mbh_remote_addr' => ["INET_ATON('{$remote_addr}')", FALSE],
			'mbh_agent_id' => $agent_id
		]);
		if ($this->Account_model->trans_complete() !== TRUE) {
			fn_page_back(-1, 'OTP 삭제에 실패하였습니다.');
		}

		fn_page_back(-1, '등록된 OTP를 삭제하였습니다.');
	}
	
}
?>