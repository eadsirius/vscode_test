<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Token extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','office','search'));
		$this->load->library('form_validation');
		
		admin_chk();
		
		//model load
		$this->load-> model('M_member');
		$this->load-> model('M_admin');
		$this->load-> model('M_office');
		$this->load-> model('M_point');
		$this->load-> model('M_coin');
		$this -> load -> model('M_cfg');
	}

	function index()
	{
		$this->lists;
	}
	
	
	function lists()
	{		
		$data['title'] = "코인전송내역관리";
		$data['group'] = "토큰관리";
		
		$data = page_lists('m_coin','coin_no',$data);
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
	        if($row->member_id == 'out'){		        
				$row->office = "";
				$row->name = "";
	        }
	        else{
				$row->office = $this->M_member->get_member_office($row->member_id);
				$row->name = $this->M_member->get_member_name($row->member_id);		        
	        }
        }

		layout('tokenLists',$data,'admin');

	}

	function wallet_set()
	{		


		$member_id = $this->input->post('member_id');
	
		$mb = $this->M_member->get_member($member_id);
		$bal 	= $this->M_coin->get_balance($mb->member_no);
		$member_no = $mb->member_no;
	    $exchange = $this->M_coin->get_wallet_address($member_id , "exchange");
		
		$return_point = $this->input->post('return_point');
		$return_fee = $this->input->post('return_fee');
		$site 			= $this->M_cfg->get_site();
		$USNS_Won 	= $return_point * $site->cfg_won; // 현재 온 수량의 총 금액
		$UPS_Point 	= $USNS_Won / 10;
		if($bal->point <=0)
		{
			alert("반품 수량이 없습니다.");	
			exit;
		}if($bal->point < $UPS_Point)
		{
			alert("반품 수량이 더많습니다..");	
			exit;
		}
		else if(!$exchange )
		{
			alert("출금 주소가 없습니다. ");
			exit;
		}


		//실체 출금수량

		$coin_id = "WNS";
		include "/var/www/html/wns/www/application/libraries/Node_rpc.php";
		$rpc = new Node_rpc();
	
		//관리자 지갑 정보가져오기
	
		$admin = $this->M_coin->get_wallet_mb('admin','wns');
		$address = $admin[0]->wallet;
		$password = $admin[0]->wallet_key; // 보내는 주소


		
		$usns  = $return_point ;
		$usns_volume  = $return_point - ( $return_point * ($return_fee/100)) ;
		//$volume  = $rpc->toWei($usns_volume , 1000000000);
		$volume  = sprintf('%0.0f',$usns_volume * 1000000000);

		//내주소. 비밀번호. 수량 // 받는주소 //코인명
		$txID = $rpc->erc_move2($address,  $password , $volume, $exchange, $coin_id);
		if($txID)
		{
			$type 		= "coin";
			$vlm_level	= $bal->coin - $usns;
			$this->M_point->balance_inout($member_no,$type,$vlm_level);		
			$type 		= "point";
			$vlm_level	= $bal->point - $UPS_Point;
			$this->M_point->balance_inout($member_no,$type,$vlm_level);	


			$_param['member_id'] = $member_id;
			$_param['address'] = $exchange;
			$_param['point'] = $UPS_Point;
			$_param['fee'] = $return_fee;
			$_param['wns'] = $usns;
			$_param['tx_id'] = $txID;
			$_param['wdate'] = date("y-m-d H:i:s");
			$this->M_point->set_return_point($_param);
			alert("반품 처리되었습니다.");
	
		exit;
			
			//히트토리 저장하기

			exit;
		}else
		{
			alert("전송 오류 관리자에게  문의 해주세요.");
			exit;
		}



	}
	function wallet()
	{		
		$site 			= $this->M_cfg->get_site();

	
		$data['title'] = "회원별 지갑관리";
		$data['group'] = "구좌관리";
		$data['msg'] = "회원별 페이현황";

		$data = page_lists('m_wallet','wallet_no',$data);
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
			
			$mb = $this->M_member->get_member($row->member_id);
			
			
			//echo 	$exchange;exit;
				$row->name 		= $mb->name;
				$row->office 	= $mb->office;
				
			$bal 	= $this->M_coin->get_balance($mb->member_no);
			if(empty($bal)){
				$row->eth 		= 0;
				$row->coin 		= 0;
				$row->point		= 0;
				$row->volume 	= 0;	
				
			}
			else{
				$row->eth 		= $bal->eth;
				$row->coin 		= $bal->coin;
				$row->point 	= $bal->point;
				$row->volume 	= $bal->volume;		
			
				$row->usns = ( $bal->point * 10 ) /  $site->cfg_won;

			}
        }

		layout('planWallet',$data,'admin');

	}
	function wallet2()
	{		
		$site 			= $this->M_cfg->get_site();

	
		$data['title'] = "회원별 지갑관리";
		$data['group'] = "구좌관리";
		$data['msg'] = "회원별 페이현황";

		$data = page_lists('m_wallet','wallet_no',$data,'type',"exchange");	
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
			
			$mb = $this->M_member->get_member($row->member_id);
			$exchange = $this->M_coin->get_wallet_address($row->member_id,"exchange");
			if($exchange)
			{
				$row->exchange = $exchange;
			}else
			{
				$row->exchange = false;
			}
			//echo 	$exchange;exit;
				$row->name 		= $mb->name;
				$row->office 	= $mb->office;
				
			$bal 	= $this->M_coin->get_balance($mb->member_no);
			if(empty($bal)){
				$row->eth 		= 0;
				$row->coin 		= 0;
				$row->point		= 0;
				$row->volume 	= 0;	
				
			}
			else{
				$row->eth 		= $bal->eth;
				$row->coin 		= $bal->coin;
				$row->point 	= $bal->point;
				$row->volume 	= $bal->volume;		
			
				$row->usns = ( $bal->point * 10 ) /  $site->cfg_won;

			}
        }

		layout('return_token',$data,'admin');

	}
	function return_wallet()
	{		
		$site 			= $this->M_cfg->get_site();
		$data['title'] = "회원별 지갑관리";
		$data['group'] = "반픔관리 ";
		$data['msg'] = "반품 리스트";
		$data = page_lists('m_point_return','idx',$data);
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
			
			$mb = $this->M_member->get_member($row->member_id);
		
			$row->name 		= $mb->name;
			$row->office 	= $mb->office;
				
		
        }

		layout('return_wallet',$data,'admin');

	}

	function getTransList()
	{		

        $data['title'] = "코인전송내역관리";
		$data['group'] = "토큰관리";
		
		$data = page_lists('m_coin','coin_no',$data);
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
	        if($row->member_id == 'out'){		        
				$row->office = "";
				$row->name = "";
	        }
	        else{
				$row->office = $this->M_member->get_member_office($row->member_id);
				$row->name = $this->M_member->get_member_name($row->member_id);		        
	        }
        }
        
		layout('translist',$data,'admin');

	}
}