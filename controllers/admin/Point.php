<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Point extends CI_Controller {

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
		$this->load-> model('M_cfg');

	}

	function index()
	{
		$this->lists;
	}
	
	
	function lists()
	{		
		$data['title'] = "매출관리";
		$data['group'] = "토큰관리";
		$data['table'] = "m_point";
		
		$data = page_lists('m_point','point_no',$data,'cate','purchase');
		$all_su = $this->M_coin->get_total_su();
		$data['all_su'] = $all_su;
		$data['all_su']->all = $all_su->day+$all_su->re+$all_su->mc;
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
					$row->name = $this->M_member->get_member_name($row->member_id);
					$row->is_free = $this->M_member->get_member_free($row->member_id);
        }

		layout('pointLists',$data,'admin');
	}
	function del_lists()
	{		
		$data['title'] = "매출 삭제 리스트";
		$data['group'] = "토큰관리";
		$data['table'] = "m_point";
		
		$data = page_lists('m_point_deleted','deldate',$data,'cate','purchase');
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
			// $row->name = $this->M_member->get_member_name($row->member_id);
			// $row->is_free = $this->M_member->get_member_free($row->member_id);

        }

		layout('pointDelLists',$data,'admin');
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// 가스비를 통해서 토큰 발송하기
	function exSend()
	{
		$data['title'] = "토큰 외부전송 관리";
		$data['group'] = "토큰 관리";
		$data['nowday'] = nowdate();

		$table = "m_point_out";
		$point_no = $this->input->post('point_no');
		$appdate	= $this->input->post('appdate');
		if(empty($appdate)) {
			$appdate = date('Y-m-d h:i:s');
		}
		$tx_id		= $this->input->post('tx_id');
		$mem_id		= $this->input->post('member_id');

		$bholder		= $this->input->post('bank_holder');
		$bnumber		= $this->input->post('bank_number');
		$bname		= $this->input->post('bank_name');

		$po	= $this->M_point->get_point_no($table,$point_no);
		
		// if(empty($point_no) || empty($tx_id)){
		// 	alert("정보가 올바르지 않습니다.");
		// 	exit;
		// }

		if(empty($po->point_no)){
			alert("출금내역이 존재하지 않습니다.");
			exit;
		}
		
		/*
			전송내역업데이트(txhash,전송일)
		*/
		$param['table'] = "m_point_out";
		$param['tx_id'] = $tx_id;
		$param['kind'] = "company";
		$param['point_no'] = $point_no;
		$param['appdate'] = $appdate;
		$param['state'] = '2';
		$this->M_point->point_out_up_tx($param);

		$order_code     = order_code();
		$point_out_code = $point_no;
		$member_id      = $mem_id;
		$event_id       = $mem_id;
		$point          = '-'.($po->point+$po->bank_fee);
		$saved_point    = '-'.($po->point+$po->bank_fee);
		$fee            = '';
		$cate           = $po->cate;
		$kind           = 'out';
		$bank_holder    = $bholder;
		$bank_num       = $bnumber;
		$bank_name      = $bname;
		$regdate        = date("Y-m-d h:i:s");
		$this->M_point->set_point_su_out($order_code,$point_out_code, $member_id, $event_id, $point, $saved_point, $fee, $cate, $kind, $bank_holder, $bank_num, $bank_name, $regdate);

		alert($po->point ." 전송 완료하였습니다.");

		/*
		$table = "m_point_out";
		$point_no = $this->uri->segment(4,0);
		$po = $this->M_point->get_point_no($table,$point_no);
		$coin_id = "MCC";
		include "/home/usns/www/application/libraries/Node_rpc.php";
		$rpc = new Node_rpc();
	
		//관리자 지갑 정보가져오기
	
		$admin = $this->M_coin->get_wallet_mb('admin','usns');
		$address	= $admin[0]->wallet;
		$password = $admin[0]->wallet_key; // 보내는 주소

		//수당 출금하기
		$volume  = sprintf('%0.0f',$po->point * 1000000000000000000);
	
		//내주소. 비밀번호. 수량 // 받는주소 //코인명
		$txID = $rpc->erc_move2($address,  $password , $volume, $po->event_id, $coin_id);
		if($txID&& $txID != 'FALSE')
		{
			$param['table'] = "m_point_out";
			$param['tx_id'] = $txID;
			$param['kind']	= "Pending";
			$param['point_no'] = $point_no;
			$po = $this->M_point->point_out_up($param);
			alert($po->point ."MCC 전송 중입니다. TXid=".$txID);
			exit;
		}else
		{
			alert("전송 오류 관리자에게  문의 해주세요.");
			exit;
		}
		*/
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// PO 받음
	function pointRev()
	{		
		$data['title'] = "매수신청 관리";
		$data['group'] = "토큰관리";
		$data['kind'] = "";
		$data['table'] = "m_point";
		$data['nowday'] = nowdate();
		
		$data = page_lists('m_point','point_no',$data,'kind','apply');
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
			$row->name = $this->M_member->get_member_name($row->member_id);
        }

		layout('poLists',$data,'admin');

	}
	function pointRev_write()
	{		
		$data['title'] = "Point 관리";
		$data['group'] = "수당관리";
		$data['nowday'] = nowdate();
		
		$table = $this->uri->segment(5,0);
		$point_no = $this->uri->segment(4,0);
		
		$data['table'] = $table;
		$data['point_no'] = $point_no;
		
		$data['po'] = $this->M_point->get_point_no($table,$point_no);

		//------------------------------------------------------------------------------------//
		
		layout('pointRev_Write',$data,'admin');

	}
	
	function pointRev_edit()
	{		
		$data['title'] = "Point 관리";
		$data['group'] = "수당관리";	
		$data['nowday'] = nowdate();	

		//------------------------------------------------------------------------------------//
		$this->form_validation->set_rules('point_no', 'point_no', 'required');
		$this->form_validation->set_rules('table', 'table', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			alert("입력을 확인하세요.");	
		} 
		else 
		{
			$table 		= $this->input->post('table');
			$point_no 	= $this->input->post('point_no');
			$kind 		= $this->input->post('kind');
			
			$member_id = $this->input->post('member_id');
			$member_no = $this->M_member->get_member_no($member_id); 
		
			// 발란스 수정		
			$bal 		= $this->M_coin->get_balance($member_no);
						
			$kind 				= $this->input->post('kind');
			$old_kind 			= $this->input->post('old_kind');
					
			$point 				= $this->input->post('point');
			$old_point 			= $this->input->post('old_point');
			$saved_point 		= $this->input->post('saved_point');
			$old_saved_point 	= $this->input->post('old_saved_point');
				
			if($old_saved_point != $saved_point and $old_point == $point){					
				alert("매출금액을 수정하시면 그에 맞게 매출포인트도 같이 수정해주세요");									
			}
			else if($old_saved_point == $saved_point and $old_point != $point){					
				alert("매출포인트를 수정하시면 그에 맞게 매출금액도 같이 수정해주세요");									
			}
		
			$this->M_point->point_up($table,$point_no);
			
			alert("매출승인 수정했습니다");	
		
		}

	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function pointSpc()
	{		
		$data['title'] = "매수인정 관리";
		$data['group'] = "토큰관리";
		$data['kind'] = "no";
		$data['table'] = "m_point";
		$data['nowday'] = nowdate();
		
		$data = page_lists('m_point','point_no',$data,'kind','no');
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
			$row->name = $this->M_member->get_member_name($row->member_id);
        }

		layout('pointSpc_Lists',$data,'admin');

	}
	function pointSpc_write()
	{		
		$data['title'] = "Point 관리";
		$data['group'] = "수당관리";
		$data['nowday'] = nowdate();
		
		$table = $this->uri->segment(5,0);
		$point_no = $this->uri->segment(4,0);
		
		$data['table'] = $table;
		$data['point_no'] = $point_no;
		
		$data['po'] = $this->M_point->get_point_no($table,$point_no);

		//------------------------------------------------------------------------------------//
		

		layout('pointSpc_Write',$data,'admin');

	}
	
	function pointSpc_edit()
	{		
		$data['title'] = "Point 관리";
		$data['group'] = "수당관리";	
		$data['nowday'] = nowdate();	

		//------------------------------------------------------------------------------------//
		$this->form_validation->set_rules('point_no', 'point_no', 'required');
		$this->form_validation->set_rules('table', 'table', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			alert("입력을 확인하세요.");	
		} 
		else 
		{
			$table 		= $this->input->post('table');
			$point_no 	= $this->input->post('point_no');
			$kind 		= $this->input->post('kind');
			
			$member_id = $this->input->post('member_id');
			$member_no = $this->M_member->get_member_no($member_id); 
		
			// 발란스 수정		
			$bal 		= $this->M_coin->get_balance($member_no);
						
			$kind 				= $this->input->post('kind');
			$old_kind 			= $this->input->post('old_kind');
					
			$point 				= $this->input->post('point');
			$old_point 			= $this->input->post('old_point');
			$saved_point 		= $this->input->post('saved_point');
			$old_saved_point 	= $this->input->post('old_saved_point');
				
			if($old_saved_point != $saved_point and $old_point == $point){					
				alert("매출금액을 수정하시면 그에 맞게 매출포인트도 같이 수정해주세요");									
			}
			else if($old_saved_point == $saved_point and $old_point != $point){					
				alert("매출포인트를 수정하시면 그에 맞게 매출금액도 같이 수정해주세요");									
			}
			
			// 매출금액 -  매출승인 아니면
			if($old_saved_point != $saved_point){
				$type 		= "volume";
				$vlm_level	= $bal->volume - $old_saved_point;	
				$this->M_point->balance_inout($member_no,$type,$vlm_level);	
			
				$type 		= "volume";
				$vlm_level	= $bal->volume + $saved_point;	
				$this->M_point->balance_inout($member_no,$type,$vlm_level);					
			}	
			
			// 포인트 - 매출승인 아니면
			if($old_point != $point){
				$type 		= "point";
				$vlm_level	= $bal->point - $old_point;	
				$this->M_point->balance_inout($member_no,$type,$vlm_level);	
			
				$type 		= "point";
				$vlm_level	= $bal->point + $point;	
				$this->M_point->balance_inout($member_no,$type,$vlm_level);			
			}
			
			// 인정인데 인정아닌걸로 바꾸면 -	 매출승인 아님
			if($old_kind == 'no' and $kind != 'no'){				
				$type 		= "purchase";
				$vlm_level	= $kind;	
				$this->M_point->balance_inout($member_no,$type,$vlm_level);				
			}
			else if($kind == 'no' and $old_kind != 'no'){				
				$type 		= "purchase";
				$vlm_level	= $kind;	
				$this->M_point->balance_inout($member_no,$type,$vlm_level);				
			}
		
			$this->M_point->point_up($table,$point_no);
			
			alert("매출 인정 수정했습니다");	
		
		}

	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// PO 받음
	function apply()
	{
		$data['title'] = "매수신청 승인관리";
		$data['group'] = "토큰관리";
		$data['table'] = "m_point";
		$site = $this->M_cfg->get_site();
		
		$point_no   = $this->uri->segment(4,0);
		
		$po = $this->M_point->get_point_no('m_point',$point_no);
			$order_code = $po->order_code;
			$count 		= $po->point;
			$member_id 	= $po->member_id;
		
		$mb 	= $this->M_member->get_member($member_id); //멤버 정보 가져오기	
		//--------------------------------------------------------------------------------//
		
		$nowday 		= nowdate();
		$appdate 		= date("Y-m-d 23:59:59", strtotime($nowday."+3month")); // 지급일은 1일 후
		
		// 업데이트하기
		$table = 'm_point';
		$query = array(
			'kind' 	=> 'complete',
			'msg' 	=> $site->cfg_usd,
			'regdate' 	=> $nowday,
			'appdate' 	=> $appdate,
		);
		$this->db->where('point_no', $point_no);
		$this->db->update($table, $query);
		
		//--------------------------------------------------------------------------------//
		//--------------------------------------------------------------------------------//
		// 발란스 수정		
		$bal 	= $this->M_coin->get_balance($mb->member_no);
			
		// $type 		= "coin";
		// $coin 		= $bal->coin + $po->point;
		// $this->M_point->balance_inout($mb->member_no,$type,$coin);
		
		$type 		= "point";
		$point 		= $bal->point - $po->point;
		$this->M_point->balance_inout($mb->member_no,$type,$point);
		
		$type 		= "purchase_cnt";
		$purchase_cnt 	= $bal->purchase_cnt + 1;
		$this->M_point->balance_inout($mb->member_no,$type,$purchase_cnt);
		
		$type 		= "volume";
		$volume 	= $bal->volume + $po->saved_point;
		if($volume < 0){$volume = 0;}
		$this->M_point->balance_inout($mb->member_no,$type,$volume);
		
		//--------------------------------------------------------------------------------//		
		$type 			= "level";
		$this->M_point->balance_inout($mb->member_no,$type,$po->type);
        
        $type 		= "purchase";
        $this->M_point->balance_inout($mb->member_no,$type,'complete');
		//--------------------------------------------------------------------------------//
		
		redirect('/admin/point/pointRev');

	}
	
	// PO 받음
	function applyOut()
	{		
		$data['title'] = "매수신청 승인관리";
		$data['group'] = "토큰관리";
		$data['table'] = "m_point";
		$site = $this->M_cfg->get_site();
		
		$point_no   = $this->uri->segment(4,0);
		
		$po = $this->M_point->get_point_no('m_point',$point_no);
			$order_code = $po->order_code;
			$count 		= $po->point;
			$member_id 	= $po->member_id;
		//--------------------------------------------------------------------------------//
		$member_wallet = $this->M_coin->get_wallet_address($member_id,'wpc');
		
		$mb 	= $this->M_member->get_member($member_id); //멤버 정보 가져오기
		//--------------------------------------------------------------------------------//
		
		// 업데이트하기
		$table = 'm_point';
		$query = array(			
			'kind' 	=> 'apply',
			'msg' 	=> '0',
			'regdate' 	=> '2020-01-01 00:00:00',
			'appdate' 	=> '2020-01-01 23:59:59',
		);
		$this->db->where('point_no', $point_no);
		$this->db->update($table, $query);
		//--------------------------------------------------------------------------------//
		// 취소 시 10% 뺀 나머지를 지급한다.
		// 날짜가 3개월 되어서 취소하는 건 원금 100% 지급한다.
		//--------------------------------------------------------------------------------//
		$nowday 		= nowdate();
		$appdate 		= date("Y-m-d 23:59:59", strtotime($nowday));
		
		if($po->appdate < $appdate){
			$point_fee = $po->point * 0.1;
		}
		else{
			$point_fee = 0;			
		}
		$point = $po->point - $point_fee;
		//--------------------------------------------------------------------------------//
		
		// 발란스 수정		
		$bal 	= $this->M_coin->get_balance($mb->member_no);
			
		// $type 		= "coin";
		// $coin 		= $bal->coin - $point;
		// $this->M_point->balance_inout($mb->member_no,$type,$coin);
		
		// $type 		= "point";
		// $point 		= $bal->point + $point;
		// $this->M_point->balance_inout($mb->member_no,$type,$point);
		
		$type 		= "purchase_cnt";
		$purchase_cnt 	= $bal->purchase_cnt - 1;
		$this->M_point->balance_inout($mb->member_no,$type,$purchase_cnt);
		
		$type 		= "volume";
		$volume 	= $bal->volume - $po->saved_point;
		if($volume < 0){$volume = 0;}
		$this->M_point->balance_inout($mb->member_no,$type,$volume);
		//--------------------------------------------------------------------------------//
		
		redirect('/admin/point/lists');

	}

	function applyOut_new()
	{		
		$data['title'] = "매수신청 승인관리";
		$data['group'] = "토큰관리";
		$data['table'] = "m_point";
		$site = $this->M_cfg->get_site();
		
		$point_no   = $this->uri->segment(4,0);
		
		$po = $this->M_point->get_point_no('m_point',$point_no);
			$order_code = $po->order_code;
			$count 		= $po->point;
			$member_id 	= $po->member_id;
		//--------------------------------------------------------------------------------//
		$member_wallet = $this->M_coin->get_wallet_address($member_id,'wpc');
		
		$mb 	= $this->M_member->get_member($member_id); //멤버 정보 가져오기
		//--------------------------------------------------------------------------------//
		
		// 업데이트하기
		$table = 'm_point';
		$query = array(			
			'kind' 	=> 'apply',
			'msg' 	=> '0',
			'regdate' 	=> '2020-01-01 00:00:00',
			'appdate' 	=> '2020-01-01 23:59:59',
		);
		$this->db->where('point_no', $point_no);
		$this->db->update($table, $query);
		//--------------------------------------------------------------------------------//
		// 취소 시 10% 뺀 나머지를 지급한다.
		// 날짜가 3개월 되어서 취소하는 건 원금 100% 지급한다.
		//--------------------------------------------------------------------------------//
		$nowday 		= nowdate();
		$appdate 		= date("Y-m-d 23:59:59", strtotime($nowday));
		
		if($po->appdate < $appdate){
			$point_fee = $po->point * 0.1;
		}
		else{
			$point_fee = 0;			
		}
		$point = $po->point - $point_fee;
		//--------------------------------------------------------------------------------//
		
		// 발란스 수정		
		$bal 	= $this->M_coin->get_balance($mb->member_no);
			
		$type 		= "coin";
		$coin 		= $bal->coin - $point;
		if($coin < 0){$coin = 0;}

		$this->M_point->balance_inout($mb->member_no,$type,$coin);
		
		$type 		= "point";
		$point 		= $bal->point + $point;
		$this->M_point->balance_inout($mb->member_no,$type,$point);
		
		$type 		= "purchase_cnt";
		$purchase_cnt 	= $bal->purchase_cnt - 1;
		$this->M_point->balance_inout($mb->member_no,$type,$purchase_cnt);
		
		$type 		= "volume";
		$volume 	= $bal->volume - $po->saved_point;
		if($volume < 0){$volume = 0;}
		$this->M_point->balance_inout($mb->member_no,$type,$volume);
		//--------------------------------------------------------------------------------//
		
		redirect('/admin/point/lists');

	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function pointOut()
	{		
		if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {
			$this->output->enable_profiler($this->config->item('profiler'));
		}

		$data['title'] = "수당 출금 관리";
		$data['group'] = "토큰관리";
		$data['table'] = "m_point_out";
		$data['nowday'] = nowdate();

		$where2  = $this->input->get('kind') ? "kind" : false;
		$where3  = $this->input->post('sdate') ? "regdate" : false;
		$where4  = $this->input->post('edate') ? "regdate" : false;

		$clm2 = $this->input->get('kind');
		$clm3 = $this->input->post('sdate');
		$clm4 =	$this->input->post('edate');
				

		echo	$clm3;
		echo	$clm4;
		$data = page_lists_date('m_point_out','point_no',$data,'cate','out',$where2,$clm2,$where3, $clm3,$where4,$clm4);
		$all_out = $this->M_coin->get_total_out();
		$data['all_out'] = $all_out;
		$data['all_out']->all = $all_out->req+$all_out->com;
		// $mem= array();
		// 가공 - 총 매출 금액확인
		foreach ($data['item'] as $row) 
		{
			$row->name = $this->M_member->get_member_name($row->member_id);
			$row->bank_holder  = $this->M_member->get_member_bholder($row->member_id);
			$row->bank_number  = $this->M_member->get_member_bnumber($row->member_id);
			$row->bank_name  = $this->M_member->get_member_bname($row->member_id);
			
		}

		layout('pointOutLists',$data,'admin');

	}
	
	function pointOut_write()
	{		
		$data['title'] = "Point 관리";
		$data['group'] = "수당관리";
		$data['nowday'] = nowdate();
		
		$table = $this->uri->segment(5,0);
		$point_no = $this->uri->segment(4,0);
		
		$data['table'] = $table;
		$data['point_no'] = $point_no;
		
		$data['po'] = $this->M_point->get_point_no($table,$point_no);

		//------------------------------------------------------------------------------------//
		
		layout('pointOut_Write',$data,'admin');

	}
	function pointOut_edit()
	{		
		$data['title'] = "Point 관리";
		$data['group'] = "수당관리";	
		$data['nowday'] = nowdate();
		//------------------------------------------------------------------------------------//
		$this->form_validation->set_rules('point_no', 'point_no', 'required');
		$this->form_validation->set_rules('table', 'table', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			alert("입력을 확인하세요.");	
		} 
		else 
		{
			$table = $this->input->post('table');
			$point_no = $this->input->post('point_no');
			$msg = $this->input->post('msg');
			$point 				= $this->input->post('point');
			$bank_fee 			= $this->input->post('bank_fee');
			$saved_point 		= $this->input->post('saved_point');
			$old_saved_point 	= $this->input->post('old_saved_point');	
		
			$member_id = $this->input->post('member_id');
			$member_no = $this->M_member->get_member_no($member_id); 
		
			// 발란스 수정	
			if($old_saved_point != $saved_point){
				$bal 		= $this->M_coin->get_balance($member_no);
/*				
				$type 		= "point_out";
				$point 		= $bal->point_out - $point;
				$this->M_point->balance_inout($member_no,$type,$point); // 매출금액
			
				$type 		= "point_fee";
				$point 		= $bal->point_fee - $bank_fee;
				$this->M_point->balance_inout($member_no,$type,$point); // 매출금액	
				
				
				$bal 		= $this->M_coin->get_balance($member_no);				
					$fee 		= $saved_point * $msg;
					$amount 	= $saved_point - $fee;
				
				$type 		= "point_out";
				$point 		= $bal->point_out + $amount;
				$this->M_point->balance_inout($member_no,$type,$point); // 매출금액
			
				$type 		= "point_fee";
				$point 		= $bal->point_fee + $fee;
				$this->M_point->balance_inout($member_no,$type,$point); // 매출금액				
*/
			}
		
			$this->M_point->point_up_new($table,$point_no);
			
			alert("출금 신청 수정했습니다");	
		
		}

	}


	function bitcoinOut()
	{		
		$data['title'] = "비트코인 출금 신청";
		$data['group'] = "토큰관리";
		$data['table'] = "m_bitcoin";
		$data['nowday'] = nowdate();
		
		$data = page_lists('m_bitcoin','coin_no',$data,'cate','O');
		
        /*
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
			$row->name = $this->M_member->get_member_name($row->member_id);
        }
        */

		layout('bitcoinOutLists',$data,'admin');

	}
	function bitcoinOut_write()
	{		
		$data['title'] = "비트코인 출금 신청 관리";
		$data['group'] = "수당관리";
		$data['nowday'] = nowdate();
		
		$table = $this->uri->segment(5,0);
		$coin_no = $this->uri->segment(4,0);
		
		$data['table'] = $table;
		$data['coin_no'] = $coin_no;
		
		$data['po'] = $this->M_point->get_coin_no($table,$coin_no);

		//------------------------------------------------------------------------------------//
		

		layout('bitcoinOut_write',$data,'admin');

	}
	function bitcoinOut_edit()
	{		
		$data['title'] = "비트코인 출금 신청 관리";
		$data['group'] = "수당관리";	
		$data['nowday'] = nowdate();
		//------------------------------------------------------------------------------------//
		$this->form_validation->set_rules('coin_no', 'coin_no', 'required');
		$this->form_validation->set_rules('table', 'table', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			alert("입력을 확인하세요.");	
		} 
		else 
		{
			$table = $this->input->post('table');
			$coin_no = $this->input->post('coin_no');
			$app_count 				= $this->input->post('app_count');
			$fee 				= $this->input->post('fee');
			$all_count 				= $this->input->post('all_count');
			$app_address 			= $this->input->post('app_address');
			$flgs 			= $this->input->post('flgs');

		
			$member_id = $this->input->post('member_id');
			$member_no = $this->M_member->get_member_no($member_id); 
		
			$this->M_point->bitcoin_up($table,$coin_no);
			
			alert("출금 신청 수정했습니다");	
		
		}

	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// 매출수정하기
	function purchase_write()
	{		
		$data['title'] = "Point 관리";
		$data['group'] = "수당관리";
		$data['nowday'] = nowdate();
		
		$table = $this->uri->segment(5,0);
		$point_no = $this->uri->segment(4,0);
		
		$data['table'] = $table;
		$data['point_no'] = $point_no;
		
		$data['po'] = $this->M_point->get_point_no($table,$point_no);

		//------------------------------------------------------------------------------------//

		layout('purchaseWrite',$data,'admin');

	}
	function purchase_edit()
	{		
		$data['title'] = "Point 관리";
		$data['group'] = "수당관리";	
		$data['nowday'] = nowdate();	

		//------------------------------------------------------------------------------------//
		$this->form_validation->set_rules('point_no', 'point_no', 'required');
		$this->form_validation->set_rules('table', 'table', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			alert("입력을 확인하세요.");	
		} 
		else 
		{
			$table 		= $this->input->post('table');
			$point_no 	= $this->input->post('point_no');
			$kind 		= $this->input->post('kind');
			
			$member_id = $this->input->post('member_id');
			$member_no = $this->M_member->get_member_no($member_id); 
		
			// 발란스 수정		
			$bal 		= $this->M_coin->get_balance($member_no);
						
			$kind 				= $this->input->post('kind');
			$old_kind 			= $this->input->post('old_kind');
					
			$point 				= $this->input->post('point');
			$old_point 			= $this->input->post('old_point');
			$saved_point 		= $this->input->post('saved_point');
			$old_saved_point 	= $this->input->post('old_saved_point');
				
			if($old_saved_point != $saved_point and $kind != 'apply' and $old_point == $point){					
				alert("매출금액을 수정하시면 그에 맞게 매출포인트도 같이 수정해주세요");									
			}
			else if($old_saved_point == $saved_point and $kind != 'apply' and $old_point != $point){					
				alert("매출포인트를 수정하시면 그에 맞게 매출금액도 같이 수정해주세요");									
			}
			
			// 매출금액 -  매출승인 아니면
			if($old_saved_point != $saved_point){
				$type 		= "volume";
				$vlm_level	= $bal->volume - $old_saved_point + $saved_point;	
				$this->M_point->balance_inout($member_no,$type,$vlm_level);	
				
				$type 		= "volume1";
				$vlm_level	= $bal->volume1 - $old_saved_point + $saved_point;	
				$this->M_point->balance_inout($member_no,$type,$vlm_level);	
		
			}
		
			$this->M_point->point_up($table,$point_no);
			
			alert("수정했습니다");	
		
		}

	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// 각 테이블 구분해서 삭제한다.
	function delete()
	{
		$table = $this->uri->segment(5,0);
		$point_no = $this->uri->segment(4,0);
				
		$po 	= $this->M_point->get_point_no($table,$point_no);
		
		$mb_no 	= $this->M_member->get_member_no($po->member_id);
		$bal 	= $this->M_point->get_balance_id($po->member_id);
		
		// 매출삭제이면 - 토탈포인트, 코인, 볼륨, 매출횟수 지움

				// 업데이트하기
		
			
		if($table == 'm_point')
		{

			if($po->kind == 'no'){
				$type 		= "volume";
				$vlm_level	= $bal->volume - $po->saved_point;	
				$this->M_point->balance_inout($mb_no,$type,$vlm_level);

				$type 		= "point";
				$vlm_level	= $bal->point - $po->point;	
				$this->M_point->balance_inout($mb_no,$type,$vlm_level);

				$type 		= "volume1";
				$vlm_level	= $bal->volume1 - $po->saved_point;	
				$this->M_point->balance_inout($mb_no,$type,$vlm_level);	
					
				$type 		= "basic_amount";
				$vlm_level	= $bal->basic_amount - $po->saved_point;	
				$this->M_point->balance_inout($mb_no,$type,$vlm_level);
			}
			else if($po->kind == 'purchase'){
				$type 		= "volume";
				$vlm_level	= $bal->volume - $po->saved_point;	
				$this->M_point->balance_inout($mb_no,$type,$vlm_level);	
			
				$type 		= "volume1";
				$vlm_level	= $bal->volume1 - $po->saved_point;	
				$this->M_point->balance_inout($mb_no,$type,$vlm_level);	
					
				$type 		= "point";
				$vlm_level	= $bal->point - $po->point;	
				$this->M_point->balance_inout($mb_no,$type,$vlm_level);	
				
				// $type 		= "volume_now";
				// $vlm_level	= $bal->volume_now - $po->saved_point;	
				// $this->M_point->balance_inout($mb_no,$type,$vlm_level);
			
				$type 		= "basic_amount";
				$vlm_level	= $bal->basic_amount - $po->saved_point;	
				$this->M_point->balance_inout($mb_no,$type,$vlm_level);
			}
		}
		if($table == 'm_point_out')
		{			
			$out_list = $this->M_point->get_point_out_q($point_no);
			
			$this->M_point->set_point_out_del_in($out_list->point_no, $out_list->order_code, $out_list->office, $out_list->member_id, $out_list->event_id, $out_list->cate, $out_list->kind, $out_list->type, $out_list->point, $out_list->saved_point, $out_list->protg, $out_list->msg, $out_list->bank_fee, $out_list->regdate, date("Y-m-d h:i:s"), $out_list->tx_id, $out_list->state);
			$this->M_point->point_del_clear($table, $point_no);
			
		}
		if($table == 'm_point_su')
		{
			$Bal 	= $this->M_point->get_balance_id($po->member_id);
			
			$type 			= "total_point";
			$total_point 	= $Bal->total_point - $po->point;
			$this->M_point->balance_inout_id($po->member_id,$type,$total_point); // 누적
				
			if($po->kind == 'ct'){
				$type 		= "su_ct";				
				$total_su 	= $Bal->su_ct - $po->point;
				$this->M_point->balance_inout_id($po->member_id,$type,$total_su); // 누적
			}
			else if($po->kind == 'ctre'){
				$type 		= "su_ct_re";				
				$total_su 	= $Bal->su_ct_re - $po->point;
				$this->M_point->balance_inout_id($po->member_id,$type,$total_su); // 누적
			}
			else if($po->kind == 'day'){
				$type 		= "su_day";				
				$total_su 	= $Bal->su_day - $po->point;
				$this->M_point->balance_inout_id($po->member_id,$type,$total_su); // 누적
			}
			else if($po->kind == 're'){
				$type 		= "su_re";				
				$total_su 	= $Bal->su_re - $po->point;
				$this->M_point->balance_inout_id($po->member_id,$type,$total_su); // 누적
			}
			else if($po->kind == 'sp'){
				$type 		= "su_sp";				
				$total_su 	= $Bal->su_sp - $po->point;
				$this->M_point->balance_inout_id($po->member_id,$type,$total_su); // 누적
			}
			else if($po->kind == 'roll'){
				$type 		= "su_sp_roll";				
				$total_su 	= $Bal->su_sp_roll - $po->point;
				$this->M_point->balance_inout_id($po->member_id,$type,$total_su); // 누적
			}
			else if($po->kind == 'mc'){
				$type 		= "su_mc";				
				$total_su 	= $Bal->su_mc - $po->point;
				$this->M_point->balance_inout_id($po->member_id,$type,$total_su); // 누적
			}
			else if($po->kind == 'level'){
				$type 		= "su_level";				
				$total_su 	= $Bal->su_level - $po->point;
				$this->M_point->balance_inout_id($po->member_id,$type,$total_su); // 누적
			}
		}
		
		// 매출 취소
		$this->M_point->point_del($table,$point_no,'admin',$po->member_id,$po->event_id);
		// 수당일 경우 등등 다른거 삭제할 경우에 대해서 조정할거
		
		// 구매취소 시 관련된 것들 모두 삭제한다.	
		//$this->db->where('point_no', $point_no);
		//$this->db->delete($table);
		
		
		// 삭제 후 다른 것들을 위로 올린다. - 차후에 적용하기		
		goto_url($_SERVER['HTTP_REFERER']);
		
		
	}
	function delete_point_lists()
	{
		$table = $this->uri->segment(5,0);
		$point_no = $this->uri->segment(4,0);
				
		$po 	= $this->M_point->get_point_no($table,$point_no);
		
		$mb_no 	= $this->M_member->get_member_no($po->member_id);
		$bal 	= $this->M_point->get_balance_id($po->member_id);
		

		$this->M_point->point_del_clear($table,$point_no);
    
    $query = array(
      'point_no'      => $po->point_no,
      'order_code'    => $po->order_code,
      'country'       => $po->country,
      'office_group'  => $po->office_group,
      'office'        => $po->office,
      'member_id'     => $po->member_id,
      'event_id'      => $po->event_id,
      'cate'          => $po->cate,
      'kind'          => $po->kind,
      'point'         => $po->point,
      'saved_point'   => $po->saved_point,
      'sale_point'    => $po->sale_point,
      'protg'         => $po->protg,
      'msg'           => $po->msg,
      'bank_fee'      => $po->bank_fee,
      'bank_code'     => $po->bank_code,
      'bank_holder'   => $po->bank_holder,
      'bank_num'      => $po->bank_num,
      'bank_name'     => $po->bank_name,
      'regdate'       => $po->regdate,
      'appdate'       => $po->appdate,
      'deldate'       => date("Y-m-d H:i:s")  
    );
    
    $this->M_point->pointDeleteInsert('m_point_deleted',$query);

		goto_url($_SERVER['HTTP_REFERER']);
	}

	function clear_point()
	{
		$table = $this->uri->segment(5,0);
		$point_no = $this->uri->segment(4,0);
		$table2 = 'm_point_su';

		$po 	= $this->M_point->get_point_no($table,$point_no);
		$mb_no 	= $this->M_member->get_member_no($po->member_id);
		$bal 	= $this->M_point->get_balance_id($po->member_id);
		
		$deldate = date('Y-m-d h:m:s');
		
		$po_list 	= $this->M_point->get_point_lists($table, $po->member_id);
		// print_r($po_list);
		// exit;
		if (!empty($po_list)){
			foreach ($po_list as $row) 
			{
				$this->M_point->point_lists_in($row->point_no, $row->order_code, $row->country, $row->office_group, $row->office, $row->member_id, $row->event_id, $row->cate, $row->kind, $row->type, $row->point, $row->saved_point, $row->sale_point, $row->protg, $row->msg, $row->bank_fee, $row->bank_code,  $row->bank_holder,  $row->bank_num, $row->bank_name, $row->regdate, $row->appdate, $deldate);
			}
		}

		$po_su_list 	= $this->M_point->get_point_su_lists($table2, $po->member_id);
		if (!empty($po_su_list)){
			foreach ($po_su_list as $rows) 
			{
				$this->M_point->point_su_lists_in($rows->point_no, $rows->order_code, $rows->m_order_code, $rows->country, $rows->office_group, $rows->office, $rows->member_id, $rows->event_id, $rows->cate, $rows->cate1, $rows->kind, $rows->type, $rows->point, $rows->saved_point, $rows->protg, $rows->msg, $rows->bank_fee, $rows->bank_code, $rows->bank_holder, $rows->bank_num, $rows->bank_name, $rows->regdate, $rows->appdate, $deldate);
			}
		}

		


		// 매출삭제이면 - 토탈포인트, 코인, 볼륨, 매출횟수 지움

				// 업데이트하기
			
		if($table == 'm_point')
		{
			$type 		= "volume";
			$vlm_level	= 0;	
			$this->M_point->balance_inout($mb_no,$type,$vlm_level);	
		
			$type 		= "volume1";
			$vlm_level	= 0;	
			$this->M_point->balance_inout($mb_no,$type,$vlm_level);	
				
			$type 		= "purchase_cnt";
			$vlm_level 	= 0;
			$this->M_point->balance_inout($mb_no,$type,$vlm_level);

			// $type 		= "basic_amount";
			// $vlm_level	= $bal->basic_amount - $po->saved_point;	
			// $this->M_point->balance_inout($mb_no,$type,$vlm_level);
		}

	


		$this->M_point->point_del_all_clear($table,$po->member_id);
		$this->M_point->point_clear_su_day($table2,$po->member_id);
		$this->M_point->point_clear_su_mc($table2,$po->member_id);
		
		goto_url($_SERVER['HTTP_REFERER']);
	}



	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function write()
	{		
		$data['title'] = "Point 관리";
		$data['group'] = "수당관리";
		$data['nowday'] = nowdate();
		
		$table = $this->uri->segment(5,0);
		$point_no = $this->uri->segment(4,0);
		
		$data['table'] = $table;
		$data['point_no'] = $point_no;
		
		$data['po'] = $this->M_point->get_point_no($table,$point_no);
		//------------------------------------------------------------------------------------//	

		layout('pointWrite',$data,'admin');

	}
	
	// 수당 수정
	function edit()
	{		
		$data['title'] = "Point 관리";
		$data['group'] = "수당관리";	
		$data['nowday'] = nowdate();	

		//------------------------------------------------------------------------------------//
		$this->form_validation->set_rules('point_no', 'point_no', 'required');
		$this->form_validation->set_rules('table', 'table', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			alert("입력을 확인하세요.");	
		} 
		else 
		{
			$table = $this->input->post('table');
			$point_no = $this->input->post('point_no');
			$kind = $this->input->post('kind');
			
		
			$member_id = $this->input->post('member_id');
			$member_no = $this->M_member->get_member_no($member_id); 
		
			// 발란스 수정		
			$Bal 		= $this->M_coin->get_balance($member_no);
						
			$kind 				= $this->input->post('kind');
					
			$point 				= $this->input->post('point');
			$old_point 			= $this->input->post('old_point');
			$saved_point 		= $this->input->post('saved_point');
			$old_saved_point 	= $this->input->post('old_saved_point');
			
			if($table == 'm_point_su' and $point != $old_point)
			{
				$type 			= "total_point";
				$total_point 	= $Bal->total_point - $old_point;
				$this->M_point->balance_inout_id($member_id,$type,$total_point); // 누적	
				
				$type 			= "total_point";
				$total_point 	= $Bal->total_point + $point;
				$this->M_point->balance_inout_id($member_id,$type,$total_point); // 누적
				
				if($kind == 'ct'){
					$type 		= "su_ct";				
					$total_su 	= $Bal->su_ct - $old_point;
					$this->M_point->balance_inout_id($member_id,$type,$total_su); // 누적
					
					$type 		= "su_ct";				
					$total_su 	= $Bal->su_ct + $point;
					$this->M_point->balance_inout_id($member_id,$type,$total_su); // 누적
				}
				else if($kind == 'ctre'){
					$type 		= "su_ct_re";				
					$total_su 	= $Bal->su_ct_re - $old_point;
					$this->M_point->balance_inout_id($member_id,$type,$total_su); // 누적
					
					$type 		= "su_ct_re";				
					$total_su 	= $Bal->su_ct_re + $point;
					$this->M_point->balance_inout_id($member_id,$type,$total_su); // 누적
				}
				
				else if($kind == 'day'){
					$type 		= "su_day";				
					$total_su 	= $Bal->su_day - $old_point;
					$this->M_point->balance_inout_id($member_id,$type,$total_su); // 누적
					
					$type 		= "su_day";				
					$total_su 	= $Bal->su_day + $point;
					$this->M_point->balance_inout_id($member_id,$type,$total_su); // 누적
				}
				
				else if($kind == 're'){
					$type 		= "su_re";				
					$total_su 	= $Bal->su_re - $old_point;
					$this->M_point->balance_inout_id($member_id,$type,$total_su); // 누적
					
					$type 		= "su_re";				
					$total_su 	= $Bal->su_re + $point;
					$this->M_point->balance_inout_id($member_id,$type,$total_su); // 누적
				}
				
				else if($kind == 'sp'){
					$type 		= "su_sp";				
					$total_su 	= $Bal->su_sp - $old_point;
					$this->M_point->balance_inout_id($member_id,$type,$total_su); // 누적
					
					$type 		= "su_sp";				
					$total_su 	= $Bal->su_sp + $point;
					$this->M_point->balance_inout_id($member_id,$type,$total_su); // 누적
										
				}
				
				else if($kind == 'roll'){
					$type 		= "su_sp_roll";				
					$total_su 	= $Bal->su_sp_roll - $old_point;
					$this->M_point->balance_inout_id($member_id,$type,$total_su); // 누적
					
					$type 		= "su_sp_roll";				
					$total_su 	= $Bal->su_sp_roll + $point;
					$this->M_point->balance_inout_id($member_id,$type,$total_su); // 누적
				}
				
				else if($kind == 'mc'){
					$type 		= "su_mc";				
					$total_su 	= $Bal->su_mc - $old_point;
					$this->M_point->balance_inout_id($$member_id,$type,$total_su); // 누적
					
					$type 		= "su_mc";				
					$total_su 	= $Bal->su_mc + $point;
					$this->M_point->balance_inout_id($$member_id,$type,$total_su); // 누적
				}
				
				else if($kind == 'level'){
					$type 		= "su_level";				
					$total_su 	= $Bal->su_level - $old_point;
					$this->M_point->balance_inout_id($member_id,$type,$total_su); // 누적
					
					$type 		= "su_level";				
					$total_su 	= $Bal->su_level + $point;
					$this->M_point->balance_inout_id($member_id,$type,$total_su); // 누적
				}
			}

			$this->M_point->point_up($table,$point_no);
			
			alert("수정했습니다");	
		
		}

	}
	//------------------------------------------------------------------------------------//
		
	function su_all()
	{		
		$data['title'] = "총 수당관리";
		$data['group'] = "수당관리";
		$data['table'] = "m_point_su";
		$data['cat'] = "all";
		$data['nowday'] = nowdate();
		
		$data = page_lists('m_point_su','point_no',$data);
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
					$row->name = $this->M_member->get_member_name($row->member_id);
				

        }

		layout('pointSu',$data,'admin');

	}
	
	function su_day()
	{
    if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {
			$this->output->enable_profiler($this->config->item('profiler'));
		}
    
		$data['title'] = "데일리수당 관리";
		$data['group'] = "수당관리";
		$data['table'] = "m_point_su";
		$data['nowday'] = nowdate();
    
    $where2  = $this->input->get('kind') ? "kind" : false;
		$where3  = $this->input->post('sdate') ? "regdate" : false;
		$where4  = $this->input->post('edate') ? "regdate" : false;

		$clm2 = $this->input->get('kind');
		$clm3 = $this->input->post('sdate');
		$clm4 =	$this->input->post('edate');

		$sdate	=	$this->uri->segment(7);
		$edate	=	$this->uri->segment(9);

		$data = page_lists_date('m_point_su','point_no',$data,'kind','day',$where2,$clm2,$where3, $clm3,$where4,$clm4);

		$all_su = $this->M_coin->get_total_su();
		$all_ssu = $this->M_coin->get_total_ssu($sdate, $edate);
		$data['all_su'] = $all_su;
		$data['all_ssu'] = $all_ssu;
	
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
			$row->name = $this->M_member->get_member_name($row->member_id);
				}
		

		layout('pointSu',$data,'admin');

	}
	
	function su_re()
	{		
		$data['title'] = "공유수당 관리";
		$data['group'] = "수당관리";
		$data['table'] = "m_point_su";
		$data['nowday'] = nowdate();
		
		$where2  = $this->input->get('kind') ? "kind" : false;
		$where3  = $this->input->post('sdate') ? "regdate" : false;
		$where4  = $this->input->post('edate') ? "regdate" : false;

		$clm2 = $this->input->get('kind');
		$clm3 = $this->input->post('sdate');
		$clm4 =	$this->input->post('edate');

		$sdate	=	$this->uri->segment(7);
		$edate	=	$this->uri->segment(9);

		$data = page_lists_date('m_point_su','point_no',$data,'kind','re',$where2,$clm2,$where3, $clm3,$where4,$clm4);
		$all_su = $this->M_coin->get_total_su();
		$all_ssu = $this->M_coin->get_total_ssu($sdate, $edate);
		$data['all_su'] = $all_su;
		$data['all_ssu'] = $all_ssu;
	
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
					$row->name = $this->M_member->get_member_name($row->member_id);
					$row->dep = $this->M_member->get_member_dep($row->member_id);
					$row->re_sp = $this->M_point->get_re_savepoint($row->member_id);
        }

		layout('pointSu',$data,'admin');

	}
	
	function su_re2()
	{		
		$data['title'] = "간접추천수당 관리";
		$data['group'] = "수당관리";
		$data['table'] = "m_point_su";
		$data['nowday'] = nowdate();
		
		$data = page_lists('m_point_su','point_no',$data,'kind','re2');
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
			$row->name = $this->M_member->get_member_name($row->member_id);
        }

		layout('pointSu',$data,'admin');

	}
	
	function su_mc()
	{		
		$data['title'] = "데일리매칭수당 관리";
		$data['group'] = "수당관리";
		$data['table'] = "m_point_su";
		$data['nowday'] = nowdate();
		
		$where2  = $this->input->get('kind') ? "kind" : false;
		$where3  = $this->input->post('sdate') ? "regdate" : false;
		$where4  = $this->input->post('edate') ? "regdate" : false;

		$clm2 = $this->input->get('kind');
		$clm3 = $this->input->post('sdate');
		$clm4 =	$this->input->post('edate');

		$sdate	=	$this->uri->segment(7);
		$edate	=	$this->uri->segment(9);

		$data = page_lists_date('m_point_su','point_no',$data,'kind','mc',$where2,$clm2,$where3, $clm3,$where4,$clm4);
		$all_su = $this->M_coin->get_total_su();
		$all_ssu = $this->M_coin->get_total_ssu($sdate, $edate);
		$data['all_su'] = $all_su;
		$data['all_ssu'] = $all_ssu;
	
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
			$row->name = $this->M_member->get_member_name($row->member_id);
			$row->dep = $this->M_member->get_member_dep($row->member_id);
        }

		layout('pointSu',$data,'admin');

	}
	
	function su_mc2()
	{		
		$data['title'] = "데일리매칭2수당 관리";
		$data['group'] = "수당관리";
		$data['table'] = "m_point_su";
		$data['nowday'] = nowdate();
		
		$data = page_lists('m_point_su','point_no',$data,'kind','mc2');
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
			$row->name = $this->M_member->get_member_name($row->member_id);
        }

		layout('pointSu',$data,'admin');

	}	
	
	function su_lv()
	{		
		$data['title'] = "프리미엄수당 관리";
		$data['group'] = "수당관리";
		$data['table'] = "m_point_su";
		$data['nowday'] = nowdate();
		
		$data = page_lists('m_point_su','point_no',$data,'kind','level');
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
			$row->name = $this->M_member->get_member_name($row->member_id);
        }

		layout('pointSu',$data,'admin');

	}	

	// 2020.08.12 박종훈 매출등록 추가
	function purchase()
	{		
		$data['title'] = "매출등록";
		$data['group'] = "토큰관리";
		$data['table'] = "m_point";
		$data['total_count'] = 0;
        
		$data = page_lists_s('m_member','member_no',$data);

        if($data['total_count'] > 0) {
            foreach ($data['item'] as $row) 
            {
								$total_balance 	= $this->M_coin->getBalanceList($row->member_no,$row->member_id);
									if(!empty($total_balance)){
										if($total_balance->total_sales > 0){
											if($total_balance->total_sales != 0){
												$row->total_percent = $total_balance->active_total_point/($total_balance->active_point*2)*100;
											} else {
												$row->total_percent = 0;
											}
											$row->total_sales = $total_balance->total_sales;
											$row->total_all_point = $total_balance->total_point-($total_balance->total_out_point);
											$row->active_point = $total_balance->active_point;
											$row->active_total_point = $total_balance->active_total_point;
										}else{
											$row->total_percent = 0;
											$row->daily_percent = 0;
											$row->total_all_point = 0;
											$row->mc_percent = 0;
											$row->re_percent = 0;
											$row->total_sales = 0;
											$row->total_point = 0;
											$row->active_point = 0;
											$row->active_total_point = 0;
										}
									}else{
										$row->total_percent = 0;
										$row->daily_percent = 0;
										$row->total_all_point = 0;
										$row->mc_percent = 0;
										$row->re_percent = 0;
										$row->total_sales = 0;
										$row->total_point = 0;
										$row->active_point = 0;
										$row->active_total_point = 0;
									}
            }
        }
        

		layout('pointPurchaseLists',$data,'admin');

		}
    function adminPurchase()
    {
        $member_no = $this->input->post('member_no');
        $member_id = $this->input->post('member_id');
        $count = $this->input->post('count');
        $type_free = $this->input->post('type');
        $level = 1;
        $thing 			= 'Level1';

        if($member_no == '') {
            alert("올바른 아이디를 입력해 주세요.");
            return false;
        }

        if($count == '') {
            alert("금액을 선택해 주세요..");
            return false;
				}
				$sales_terms = $this->M_point->get_sales_terms($member_id);
				
        $order_code = order_code();  // 주문코드 만들기
        $db_table 	= 'm_point_su';
        $isvalid 	= 'purchase';
        //---------------------------------------------------------------------------------//
				// 발란스 수정		
			
				if($type_free==1){
					$bal 	= $this->M_coin->get_balance($member_no);
        
					$type 		= "level";
					$this->M_point->balance_inout($member_no,$type,$level);
					
					$type 		= "purchase";
					$this->M_point->balance_inout($member_no,$type,$thing);
			
					$type 		= "purchase_cnt";
					$purchase_cnt 	= $bal->purchase_cnt + 1;
					$this->M_point->balance_inout($member_no,$type,$purchase_cnt);
					/*
					$type 		= "point";
					$point 		= $bal->point - $count;
					$this->M_point->balance_inout($member_no,$type,$point);
					*/  
					$type 		= "volume";
					$volume 	= $bal->volume + $count;
					$this->M_point->balance_inout($member_no,$type,$volume);
									 
					$type 		= "volume1";
					$volume1 	= $bal->volume1 + $count;
					$this->M_point->balance_inout($member_no,$type,$volume1);
											
					// if(($bal->basic_amount) == 0) {
					//     $type 		      = "basic_amount";
					//     $basic_amount 	= $count;
					//     $this->M_point->balance_inout($member_no,$type,$basic_amount);
					// }
	
					//---------------------------------------------------------------------------------//
					//---------------------------------------------------------------------------------//
					
					$site = $this->M_cfg->get_site();
	
					// $msg 		= '350.0000'; // 시세기록하기
					$msg =	$site->cfg_won;
					$regdate 	= nowdate();
					$app_date = date("Y-m-d 23:59:59", strtotime($regdate."+12month"));
					
					$in_table 	= 'm_point';

					$sales_terms = $this->M_point->get_sales_terms($member_id);
					if(empty($sales_terms)){
						$this->M_point->pay_puchase($in_table, $order_code, '82', '', 'company', $member_id, $count, $count, 'purchase', 'complete', $level, $msg,$regdate,$app_date);
						$me = $member_id." 님 ".number_format($count)." Point 등록이 완료 되었습니다.";
						alert($me, "admin/point/purchase");
					} elseif($sales_terms->cs_n > 0) {
						$me = $member_id." 님 진행중인 투자가 있습니다. 수당을 200% 전부 받으신 분만 투자하실 수 있습니다.";
						alert($me, "admin/point/purchase");
					} else {
						$me = $member_id." 님 진행중인 투자가 있습니다. 수당을 200% 전부 받으신 분만 투자하실 수 있습니다.";
						alert($me, "admin/point/purchase");
					}
				}
        
    }
    function adminPurchaseFree()
    {
        $member_no = $this->input->post('member_no');
        $member_id = $this->input->post('member_id');
        $count1 = $this->input->post('count1');
        $type_free = $this->input->post('type');
        $level = 1;
        $thing 			= 'Level1';

        if($member_no == '') {
            alert("올바른 아이디를 입력해 주세요.");
            return false;
        }

        if($count1 == '') {
            alert("금액을 선택해 주세요..");
            return false;
        }

        $order_code = order_code();  // 주문코드 만들기
        $db_table 	= 'm_point_su';
        $isvalid 	= 'purchase';
        //---------------------------------------------------------------------------------//
				// 발란스 수정		
				if($type_free==2){
					$bal 	= $this->M_coin->get_balance($member_no);
        
					$type 		= "level";
					$this->M_point->balance_inout($member_no,$type,$level);
					
					$type 		= "purchase";
					$this->M_point->balance_inout($member_no,$type,$thing);
			
					$type 		= "purchase_cnt";
					$purchase_cnt 	= $bal->purchase_cnt + 1;
					$this->M_point->balance_inout($member_no,$type,$purchase_cnt);
					/*
					$type 		= "point";
					$point 		= $bal->point - $count;
					$this->M_point->balance_inout($member_no,$type,$point);
					*/  
					$type 		= "volume";
					$volume 	= $bal->volume + $count1;
					$this->M_point->balance_inout($member_no,$type,$volume);
									 
					$type 		= "volume1";
					$volume1 	= $bal->volume1 + $count1;
					$this->M_point->balance_inout($member_no,$type,$volume1);

			
					$site = $this->M_cfg->get_site();
	
					// $msg 		= '350.0000'; // 시세기록하기
					$msg =	$site->cfg_won;
					$regdate 	= nowdate();
					$app_date = date("Y-m-d 23:59:59", strtotime($regdate."+12month"));
					
					$in_table 	= 'm_point';
					$this->M_point->pay_puchase($in_table, $order_code, '82', 'free', 'company', $member_id, $count1, $count1, 'purchase', 'complete', $level, $msg,$regdate,$app_date);
	
					// 맴버 테이블 외상데이터 업데이트 20200923 jjh
					$is_free = 'F';
					$this->M_member->set_isFree($member_id, $is_free); 
					
	
					$me = $member_id." 님 ".number_format($count1)." Point 외상 매출 등록이 완료 되었습니다";
					
					alert($me, "admin/point/purchase");
				}
    }
}