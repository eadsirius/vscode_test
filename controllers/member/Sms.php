<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('SmsLib');
		$this->load->model('m_member');
	}


	// SMS 인증키 발송
	function index() 
	{
		//$mobile = '82' .$this->input->get('mobile');
		
		$mobile = $this->input->get('mobile');
		// 문자열 자르기 국가번호가 안보이면 에러메시지 발송하기

		$authcode = rand(10, 999999);

		$this->m_member->sms_authcode_in($mobile, $authcode);

		//alert($mobile);
		
		$smslib = new SmsLib();
		$response = $smslib->send($mobile, "Your Rose garden verification code is: {$authcode}");

		echo $response;
	}
}

?>

