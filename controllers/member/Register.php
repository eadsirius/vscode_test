<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Register extends CI_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->helper(array('form', 'url', 'office'));
		
		$this->load->library('form_validation');		
		$this->load->library('bitcoin');
		$this->load->library('qrcode');
		
		$this->load-> model('M_cfg');
		$this->load-> model('M_coin');
		$this->load-> model('M_office');
		$this->load-> model('M_member');

		//alert("USNS 업그레이드 기간 ( 2020-06-03 ~  2020-06-26 )  중 에는 회원가입이 불가능 합니다. ");
		//exit;
		
	}
	
	
	// 초대장받고온 회원가입
	function _remap($method)
	{
		// 이미 로그인 햇다면
		if ($this->session->userdata('is_login') == TRUE){
			redirect('/office');
		}
		$data = array();
		$data['regdate'] 	= nowdate();
		$site 				= get_site();
		$data['site'] 		= $site;

		$data['center'] 	= $this->M_member->get_center_li();	
		$data['country'] 	= $this->M_member->get_country_li();		
		
		$rem   = $this->uri->segment(3,0);
					
		$data['re_id'] 	= "";
		
		//-------------------------------------------------------------------------------//
		$lang = get_cookie('lang');
		
		$this->form_validation->set_rules('member_id', 'member_id', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_rules('password2', 'password2', 'required');
		//$this->form_validation->set_rules('name', 'name', 'required');
		//$this->form_validation->set_rules('mobile', 'mobile', 'required');

		if ($this->form_validation->run() == FALSE)	
		{
			layout('member/register',$data, 'login');
		} 
		else 
		{
			if($this->input->post('recommend_id') == '' or $this->input->post('recommend_id') == 'index' or $this->input->post('recommend_id') == 'admin1' or $this->input->post('recommend_id') == 'test'){
				alert("Create An Account", "/");
			}
			
			if($site->cfg_mail_view == 1 and $site->cfg_mail_reg == 1)
			{
				$email 	= $this->input->post('email');	
				$mailcode 	= $this->input->post('mailcode');
				
				$mail = $this->M_member->get_email_check($email);
				if(empty($mail)){				
				}
				else{
					alert(get_msg($this ->lang, '이메일이 중복입니다.'));
				}
				
				$save_authcode = $this->M_member->get_email_authcode($email);
				if($save_authcode != $mailcode)
				{
					alert("인증키가 올바르지 않습니다.");
				}
			}
			//-------------------------------------------------------------------------------//
			$country 		= $this->input->post('country');
			$authcode 		= $this->input->post('authcode');
			$type 			= $this->input->post('type');
			$mobile 		= $this->input->post('mobile');
			/*	
			$mobile = preg_replace("/\s+/","",$mobile);
				
			$chk_mobile = $country .$mobile;
			$save_authcode = $this->M_member->get_sms_authcode($chk_mobile);
			if($save_authcode != $authcode)
			{
				alert('인증키가 올바르지 않습니다.');
			}
			
			// 전화번호 가입자가 있으면 중복가입 안되게 한다.			
			$chk = $this->M_member->get_mobile_check($mobile);
			if(empty($chk)){
				
			}
			else if($chk > 1)
			{
				if ($lang == "kr") {
					alert("휴대폰이 중복입니다.");
				}
				else{
					alert("The phone is a duplicate.");		
				}	
			}
			*/
			//-------------------------------------------------------------------------------//
			//-------------------------------------------------------------------------------//	
			$member_id 		= $this->input->post('member_id');
			$member = $this->M_member->get_member($member_id);
			if($member)
			{
				alert("Error : Member ID Checked");
			}
			//-------------------------------------------------------------------------------//
			$recommend_id 	= $this->input->post('recommend_id');
			$re = $this->M_member->get_member($recommend_id);
			if(!$re){
				alert("Error : Recommend ID Checked");
			}
			///-------------------------------------------------------------------------------//
			/*$sponsor_id 	= $this->input->post('sponsor_id');
			$sp = $this->M_member->get_member($sponsor_id);
			if(!$sp){
				alert("Error : Sponsor ID Checked");
			}			
			
			$sp_cnt = $this->M_member->sp_check($sponsor_id);
			if($sp_cnt >= 2){
				if ($lang == "kr") {
					alert("후원산하 2명이 있습니다.");
				}
				else{
					alert("There are two sponsors.");	
				}
			}
				
			if ($sp_cnt == 0){
				$pos = 'left';
			}
			else if ($sp_cnt == 1){
				$pos = 'right';
			}
			else{
				$pos = $sp_cnt;				
			}
			
			// 해당회원을 후원인으로 두는 회원을 찾는다 단, 같은 위치인 경우만-----------------------------
			$postion = 'left';
			$pos = $this->M_member->sp_side_check($sponsor_id,$postion);
			if($pos == 1)
			{
				$pos = 'right';
			}
			else
			{				
				$postion = 'right';
				$pos = $this->M_member->sp_side_check($sponsor_id,$postion);
				if($pos == 1){
					$pos = 'left';
				}
				else{
					$pos = 'left';					
				}				
			}
			*/
			//-------------------------------------------------------------------------------//
			/*
			// 비트코인 지갑주소 생성
			$addr = $this->bitcoin->getnewaddress($member_id);
			
			//통신 안될경우 중단
			if(!$addr) {
				alert("Error : Coin Code");
			}

			$type = 'agc';
			qrcode($member_id,$addr);
			$qrimg = $member_id .".png"; // ico qrcode
			
			$this->M_coin->set_wallet_in($member_id,$addr,$qrimg,$type);
			*/
			//-------------------------------------------------------------------------------//
			
			include APPPATH."libraries/Node_rpc.php";
			$rpc = new Node_rpc();
				
			$walletAddress = $rpc->newAddress($member_id);

			if( strlen( $walletAddress['privateKey'] ) > 10 )
			{
				$addr_key = $walletAddress['privateKey'];
				$addr = $walletAddress['address'];
			}			

			//통신 안될경우 중단
			if(!$addr) {
				alert("Error : Create WNS Token");
			}
				
			$type = "wns";
			$qrimg_id = $member_id; // ico qrcode
			qrcode($qrimg_id,$addr);
				
			$qrimg = $member_id .".png"; // ico qrcode
			$this->M_member->member_wallet($member_id,$addr,$qrimg,$type,$addr_key);
			//-------------------------------------------------------------------------------//
			// 후원인의 깊이를 가져온다.
			$dep = $this->M_member->get_member_dep($recommend_id);	
				$dep = $dep + 1;
				
			$pos = $this->M_member->get_re_side($recommend_id,$member_id); // 나는 스폰서의 좌우 어디에 있나? - 없으면 1		
			if ($pos == '1'){
				$pos = 'left';
			}
			else if ($pos == '2'){
				$pos = 'right';
			}
			else{
				$pos = $pos;			
			}
			//-------------------------------------------------------------------------------//
			qrcode_mb($member_id);
			//-------------------------------------------------------------------------------
			// 회원 정보 기록
			$this->M_member->member_in($member_id,$dep,$pos);
			//-------------------------------------------------------------------------------
			//기록된 회원 정보 가져오기
			$member = $this->M_member->get_member($member_id);
			$this->M_coin->set_balance_in($member->member_no, $member->member_id);
			//-------------------------------------------------------------------------------
			
			// 이메일 후인증이면 
			if($site->cfg_mail_log == 0){
				//세션 굽기
				$member_ses= array(
				'member_id'  => $member->member_id,
				'member_no'  => $member->member_no,
				'level'  	 => 2,
				'is_login'	 => TRUE,
				'login_type' => "default"
				);
				$this->session->set_userdata($member_ses);
			}
			//-------------------------------------------------------------------------------
			
			// 볼륨등록
			$order_code = order_code(); //주문코드 생성
			$regdate 	= nowdate();
			/*
			// 본인을 먼저 넣고 그 다음에 추가로 입력한다.
			$side 	= 'middle';
			$table 	= 'm_volume';
			$this->M_office->vlm_in($table, $order_code, $this->input->post('name'), $member_id, $member_id, $sponsor_id, $side, $dep, 0, $regdate);
			
			vlm_tree($order_code, $this->input->post('name'), $member_id, $sponsor_id, $dep, 0, $regdate);
			*/
			//---------------------------------------------------------------------------------//
			// 본인을 먼저 넣고 그 다음에 추가로 입력한다.				
			$pos 	= 'middle';
			$table 	= "m_volume1";
			$this->M_office->vlm_in($table, $order_code, $this->input->post('name'), $member_id, $member_id, $recommend_id, $pos, $dep, 0, $regdate);
		
			vlm_re_tree($order_code, $this->input->post('name'), $member_id, $recommend_id, $dep, 0, $regdate);
			//-------------------------------------------------------------------------------
			//---------------------------------------------------------------------------------//			
			
			// 가입후 페이징 처리
			if ($this->session->userdata('is_login') == 1) {
				alert(get_msg($this ->lang, '계정이 생성되었습니다.'), "office");
			}
		}

	}


	// 회원가입
	function index() 
	{
		// 이미 로그인 햇다면
		if ($this->session->userdata('is_login') == TRUE){
			redirect('/office');
		}
		
		$data = array();
		$data['regdate'] 	= nowdate();
		$site 				= get_site();
		$data['site'] 		= $site;

		$data['center'] 	= $this->M_member->get_center_li();	
		$data['country'] 	= $this->M_member->get_country_li();		
		
		$rem   = $this->uri->segment(3,0);
					
		$data['re_id'] 	= "";
		
		//-------------------------------------------------------------------------------//
		$lang = get_cookie('lang');
		
		$this->form_validation->set_rules('member_id', 'member_id', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_rules('password2', 'password2', 'required');
		//$this->form_validation->set_rules('name', 'name', 'required');
		//$this->form_validation->set_rules('mobile', 'mobile', 'required');

		if ($this->form_validation->run() == FALSE)	
		{
			layout('member/register',$data, 'login');
		} 
		else 
		{
			if($this->input->post('recommend_id') == '' or $this->input->post('recommend_id') == 'index' or $this->input->post('recommend_id') == 'admin1' or $this->input->post('recommend_id') == 'test'){
				//alert("Create An Account", "/");
			}

			//-------------------------------------------------------------------------------//
			$country 		= $this->input->post('country');
			$authcode 		= $this->input->post('authcode');
			$type 			= $this->input->post('type');
			$mobile 		= $this->input->post('mobile');
				
			$mobile = preg_replace("/\s+/","",$mobile);
				
			$chk_mobile = $country .$mobile;
			$save_authcode = $this->M_member->get_sms_authcode($chk_mobile);
			if($save_authcode != $authcode)
			{
				alert('인증키가 올바르지 않습니다.');
			}
			/*
			// 전화번호 가입자가 있으면 중복가입 안되게 한다.			
			$chk = $this->M_member->get_mobile_check($mobile);
			if(empty($chk)){
				
			}
			else if($chk > 1)
			{
				if ($lang == "kr") {
					alert("휴대폰이 중복입니다.");
				}
				else{
					alert("The phone is a duplicate.");		
				}	
			}
			*/
			//-------------------------------------------------------------------------------//
			//-------------------------------------------------------------------------------//	
			$member_id 		= $this->input->post('member_id');
			$member = $this->M_member->get_member($member_id);
			if($member)
			{
				alert("Error : Member ID Checked");
			}
			//-------------------------------------------------------------------------------//
			if($this->input->post('recommend_id')){
				$recommend_id 	= $this->input->post('recommend_id');
			} else {
				$recommend_id = '';
			}
			$re = $this->M_member->get_member($recommend_id);
			if(!$re){
				alert("Error : Recommend ID Checked");
			}
			///-------------------------------------------------------------------------------//
			/*$sponsor_id 	= $this->input->post('sponsor_id');
			$sp = $this->M_member->get_member($sponsor_id);
			if(!$sp){
				alert("Error : Sponsor ID Checked");
			}			
			
			$sp_cnt = $this->M_member->sp_check($sponsor_id);
			if($sp_cnt >= 2){
				if ($lang == "kr") {
					alert("후원산하 2명이 있습니다.");
				}
				else{
					alert("There are two sponsors.");	
				}
			}
				
			if ($sp_cnt == 0){
				$pos = 'left';
			}
			else if ($sp_cnt == 1){
				$pos = 'right';
			}
			else{
				$pos = $sp_cnt;				
			}
			
			// 해당회원을 후원인으로 두는 회원을 찾는다 단, 같은 위치인 경우만-----------------------------
			$postion = 'left';
			$pos = $this->M_member->sp_side_check($sponsor_id,$postion);
			if($pos == 1)
			{
				$pos = 'right';
			}
			else
			{				
				$postion = 'right';
				$pos = $this->M_member->sp_side_check($sponsor_id,$postion);
				if($pos == 1){
					$pos = 'left';
				}
				else{
					$pos = 'left';					
				}				
			}
			*/
			//-------------------------------------------------------------------------------//
			/*
			// 비트코인 지갑주소 생성
			$addr = $this->bitcoin->getnewaddress($member_id);
			
			//통신 안될경우 중단
			if(!$addr) {
				alert("Error : Coin Code");
			}

			$type = 'agc';
			qrcode($member_id,$addr);
			$qrimg = $member_id .".png"; // ico qrcode
			
			$this->M_coin->set_wallet_in($member_id,$addr,$qrimg,$type);
			*/
			//-------------------------------------------------------------------------------//
			
			include APPPATH."libraries/Node_rpc.php";
			$rpc = new Node_rpc();
				
			$walletAddress = $rpc->newAddress($member_id);

			if( strlen( $walletAddress['privateKey'] ) > 10 )
			{
				$addr_key = $walletAddress['privateKey'];
				$addr = $walletAddress['address'];
			}			

			//통신 안될경우 중단
			if(!$addr) {
				alert("Error : Create WNS Token");
			}
				
			$type = "wns";
			$qrimg_id = $member_id; // ico qrcode
			qrcode($qrimg_id,$addr);
				
			$qrimg = $member_id .".png"; // ico qrcode
			$this->M_member->member_wallet($member_id,$addr,$qrimg,$type,$addr_key);
			//-------------------------------------------------------------------------------//
			// 후원인의 깊이를 가져온다.
			$dep = $this->M_member->get_member_dep($recommend_id);	
				$dep = $dep + 1;
				
			$pos = $this->M_member->get_re_side($recommend_id,$member_id); // 나는 스폰서의 좌우 어디에 있나? - 없으면 1		
			if ($pos == '1'){
				$pos = 'left';
			}
			else if ($pos == '2'){
				$pos = 'right';
			}
			else{
				$pos = $pos;			
			}
			//-------------------------------------------------------------------------------//
			qrcode_mb($member_id);
			//-------------------------------------------------------------------------------
			// 회원 정보 기록
			$this->M_member->member_in($member_id,$dep,$pos);
			//-------------------------------------------------------------------------------
			//기록된 회원 정보 가져오기
			$member = $this->M_member->get_member($member_id);
			$this->M_coin->set_balance_in($member->member_no, $member->member_id);
			//-------------------------------------------------------------------------------
			
			// 이메일 후인증이면 
			if($site->cfg_mail_log == 0){
				//세션 굽기
				$member_ses= array(
				'member_id'  => $member->member_id,
				'member_no'  => $member->member_no,
				'level'  	 => 2,
				'is_login'	 => TRUE,
				'login_type' => "default"
				);
				$this->session->set_userdata($member_ses);
			}
			//-------------------------------------------------------------------------------
			
			// 볼륨등록
			$order_code = order_code(); //주문코드 생성
			$regdate 	= nowdate();
			/*
			// 본인을 먼저 넣고 그 다음에 추가로 입력한다.
			$side 	= 'middle';
			$table 	= 'm_volume';
			$this->M_office->vlm_in($table, $order_code, $this->input->post('name'), $member_id, $member_id, $sponsor_id, $side, $dep, 0, $regdate);
			
			vlm_tree($order_code, $this->input->post('name'), $member_id, $sponsor_id, $dep, 0, $regdate);
			*/
			//---------------------------------------------------------------------------------//
			// 본인을 먼저 넣고 그 다음에 추가로 입력한다.				
			$pos 	= 'middle';
			$table 	= "m_volume1";
			$this->M_office->vlm_in($table, $order_code, $this->input->post('name'), $member_id, $member_id, $recommend_id, $pos, $dep, 0, $regdate);
		
			vlm_re_tree($order_code, $this->input->post('name'), $member_id, $recommend_id, $dep, 0, $regdate);
			//-------------------------------------------------------------------------------
			//---------------------------------------------------------------------------------//			
			
			// 가입후 페이징 처리
			if ($this->session->userdata('is_login') == 1) {
				alert(get_msg($this ->lang, '계정이 생성되었습니다.'), "office");
			}
		}
	}
	
}

?>

