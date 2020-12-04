<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','office','search'));
		$this->load->library('form_validation');
		
		admin_chk();
		
		//model load
		$this->load-> model('M_cfg');
		$this->load-> model('M_member');
		$this->load-> model('M_admin');
		$this->load-> model('M_office');
		$this->load-> model('M_point');
		$this->load-> model('M_coin');

	}

	function index()
	{
		$this->lists;
	}
	
	
	function lists()
	{		
		$data['title'] = "구좌관리";
		$data['group'] = "구좌관리";
		$data['msg'] = "구좌등록현황";
		
		$data = page_lists('m_plan','plan_no',$data);
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {	
	        
			$bal 	= $this->M_coin->get_balance_id($row->member_id);
			if(empty($bal)){
				$row->level 	= 0;
				$row->coin 		= 0;
				$row->point 	= 0;
				$row->total_point 	= 0;
				$row->volume 	= 0;	
				
			}
			else{
				$row->level 	= $bal->level;
				$row->coin 		= $bal->coin;
				$row->point		= $bal->point;
				$row->total_point		= $bal->total_point;
				$row->volume 	= $bal->volume;				
			}
        }

		layout('planLists',$data,'admin');

	}
	
	function write()
	{
		$data['title'] = "구좌 상세보기";
		$data['group'] = "구좌관리";
		
		$plan_idx  = $this->uri->segment(4,0);

		$data['item'] = $this->M_office->get_plan_no($plan_idx);
		
		$table = 'm_point_free';
		$data['count'] = $this->M_point->point_in_chk($table,$data['item']->member_id);
		
		$this->form_validation->set_rules('regdate', 'regdate', 'required');

		if ($this->form_validation->run() == FALSE) {			
			
			$this->load->view('admin/planWrite',$data);

		} else {		
		
			$order_code = $data['item']->order_code;
						
			// 회원 정보에서 매출 날짜 수정
			$query = array(
				'regdate' => $this->input->post('regdate'),
			);
				
			$this->db->where('member_id', $data['item']->member_id);
			$this->db->update('m_member ', $query);
			
			alert("저장되었습니다", "admin/plan/write/".$plan_idx."");

		}

	}
	
	// 후원 볼륨관리
	function volume()
	{		
		$data['title'] = "후원볼륨관리";
		$data['group'] = "구좌관리";
		$data['msg'] = "볼륨등록현황";
		$data['table'] = "m_volume";
		
		
		$data = page_lists('m_volume','vlm_no',$data);
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) {
	        
	        /*
			$plan_ck = $this->M_office->plan_in_chk($row->member_id); // 받은 사람 플랜 등록 여부 확인	
			if(empty($plan_ck)){ 
				$row->amount = 0;
			}	
			else{
	        		$row->amount = $this->M_office->get_plan_amount($row->member_id);				
			}
			*/
			$row->amount = $this->M_point->point_puchase_total($row->event_id);
			$row->name = $this->M_member->get_member_name($row->event_id);
        }

		layout('vlmLists',$data,'admin');

	}
	
	//추천 볼륨관리
	function volume1()
	{		
		$data['title'] = "추천볼륨관리";
		$data['group'] = "구좌관리";
		$data['msg'] = "볼륨등록현황";
		$data['table'] = "m_volume1";
		
		
		$data = page_lists('m_volume1','vlm_no',$data);
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) {
	        /*
			$plan_ck = $this->M_office->plan_in_chk($row->member_id); // 받은 사람 플랜 등록 여부 확인	
			if(empty($plan_ck)){ 
				$row->amount = 0;
			}	
			else{
	        		$row->amount = $this->M_office->get_plan_amount($row->member_id);				
			}
			
			$row->name = $this->M_member->get_member_name($row->member_id);
			*/
			
			$row->amount = $this->M_point->point_puchase_total($row->event_id);
			$row->name = $this->M_member->get_member_name($row->event_id);
        }

		layout('vlmLists',$data,'admin');

	}
	
	function vlm_sp()
	{		
		set_time_limit(0);
		ini_set('memory_limit','-1');
		
		$order_code = order_code(); //주문코드 생성
		$table = "m_volume";		
		//$this->db->empty_table($table);
		
		/*
		//$list = $this->M_office->get_plan_li();
		$list = $this->M_member->get_member_li();
		foreach ($list as $row) 
		{
			if($row->member_id != 'admin')
			{
				// 추천인 후원인을 다시 넣는다.
				$mb = $this->M_member->get_member($row->member_id);
				if($mb){
					if($row->recommend_id != $mb->recommend_id){
						$this->M_office->plan_re($row->member_id,$mb->recommend_id);
					}
					if($row->sponsor_id != $mb->sponsor_id){
						$this->M_office->plan_sp($row->member_id,$mb->sponsor_id);
					}
				}
			}
		}
		*/
		//$list = $this->M_office->get_plan_li();
		$list = $this->M_member->get_member_li();
		foreach ($list as $row) 
		{
			if($row->member_id == 'admin')
			{
				$sponsor_id = '';
				$dep 		= 1;
				$side 		= 'middle';
				$this->M_office->vlm_in($table,$order_code,$row->name,$row->member_id,$row->member_id,$row->sponsor_id,$side,0,$dep,$row->regdate);
			}
			else
			{
				//$sponsor_id = $row->sponsor_id;
				//$pl = $this->M_office->get_plan_dep($sponsor_id);	
				//	$dep = $pl->dep + 1;
				
				//$this->M_office->plan_dep_up($row->member_id,$dep);
				
				$dep = $this->M_member->get_member_dep($row->sponsor_id);	
					$dep = $dep + 1;
					
				$this->M_member->member_dep_up($row->member_id,$dep);
				
				// 볼륨등록	// 본인을 먼저 넣고 그 다음에 추가로 입력한다.
				$side = 'middle';
				$this->M_office->vlm_in($table,$order_code,$row->name,$row->member_id,$row->member_id,$row->sponsor_id,$side,0,$dep,$row->regdate);
				
				//echo "$order_code,$row->name,$row->member_id,$row->sponsor_id,0,$dep,$row->regdate <br>";
				vlm_tree($order_code,$row->name,$row->member_id,$row->sponsor_id,0,$dep,$row->regdate);
				//vlm_sp_tree($order_code,$row->name,$row->member_id,$sponsor_id,0,$dep,$row->regdate);				
			}
		}

		alert('후원볼륨 다시 정리하기 완료!');
	}
	
	
	function token_full()
	{		
		set_time_limit(0);
		ini_set('memory_limit','-1');	
		include "/var/www/html/wpc/www/application/libraries/Node_rpc.php";
		$rpc = new Node_rpc();
		$data['title'] = "WNS 토큰관리";
		$data['group'] = "WNS 토큰관관리";
		
		$site 	= $this->M_cfg->get_site();
		//---------------------------------------------------------------------------------//
		set_time_limit(0);
		ini_set('memory_limit','-1');	
		
		$data['title'] = "WNS 토큰관리";
		$data['group'] = "WNS 토큰관관리";
		
		$site 	= $this->M_cfg->get_site();
		//---------------------------------------------------------------------------------//
		
		$list = $this->M_coin->get_wallet_li('wpc');
		$admin = $this->M_coin->get_wallet_mb('admin','wpc');
	
		
		$coin_id = "WNS";

	
		
		$contractaddress = $site->cfg_contract;
		$contractaddress = "0x083f9fa33248883c5da4c7590f99a1121387f5b2";

		$rev_address = $admin[0]->wallet;
		$rev_password = $admin[0]->wallet_key; // 보내는 주소
		$apikey = "IWE2ZU6TG49YXT16DKBHY28ZZNBYQE3748"; // 이더스캔 주소필요
		//MHgwZGI1YTBlNWEyNTk4MGNkZDg0YjZmYTBjNmEzMDUzYjFjNGM4ZjVhODdmNWFjNDU5NjZmNzA4MTk0ZjE3M2Rm
		foreach ($list as $row) 
		{	
			$member_id = $row->member_id;
			// 관리자는 페스하기
			if($member_id == "admin") continue;

			
				$address = $row->wallet;
				$password = $row->wallet_key;
				// 토큰 수량 체크
				$url="https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=".$contractaddress."&address=".$address."&tag=latest&apikey=".$apikey;

				$datas = json_decode(file_get_contents($url));


				if($datas->result > 10000000000000)
				{
					// 이더리움 체크
					$url='https://api.etherscan.io/api?module=account&action=balance&address='.$address.'&tag=latest&apikey='.$apikey;
					
					
					//수수료개 있다면 전송
					$datas_eth = json_decode(file_get_contents($url));				
				
					if($datas_eth->result > 10000000000000)
					{
						//토큰전송				
						$volume =  $datas->result;
						// 확인후보내기
					
			
						//내주소. 비밀번호. 수량 // 받는주소 //코인명
						$txID = $rpc->erc_move2($address,  $password , $volume, $rev_address, $coin_id);
						// 토큰 수량 차감
						$volume = sprintf('%0.8f', $volume / 1000000000);
							
						// 토큰 수량 차감안함
						if($txID ) 
						{
						//	$bal 	= $this->M_coin->get_balance_id($member_id);
							//$type 	= "token";
							//$token 	= $bal->token - $volume;
							//$token =  $token < 0 ? 0 :$volume ;
							//$this->M_point->balance_inout_id($member_id,$type,$token);	
						}
					}else {
						
						 //수수료 전송
						 $rpc->fee_move2($rev_address , $rev_password , $address);
						 
					}
				} else 
				{
					// 이더스캔에 자산없는 없는것은 0ㅇ처리
				//	$type 	= "token";
					////$token = 0;
				//	$this->M_point->balance_inout_id($member_id,$type,$token);	
				
				}
		}
		

		alert('수수료 전송 및 / 토큰전송을 완료 했습니다. \n 미전송이 내역이 있을경우 수수료 전송 중이므로  \n 3시간 이후 시도 해주세요. ');
		exit;
		foreach ($R as $key=>$val) 
		{	
			if(is_array($val)) { // val 이 배열이면
        		//echo "$key:<br/>";
				//echo $key.' (key), value : (array)<br />';
    		} else { // 배열이 아니면
	    		$i +=1;
				if($i == 2){
					
					$eth_go = $val;
					$won = $val * 1200;
					$query = array(
						'cfg_eth_usd' 			=> $val,
						'cfg_eth_won' 			=> $won,
					);
					$this->db->where('cfg_no', $cfg_no);
					$this->db->update('m_site', $query);		    	
	    		}
    		}
		}
		//---------------------------------------------------------------------------------//	
		// 이더 확인하기 잔고
		$list = $this->M_member->get_member_li();
		foreach ($list as $row) 
		{
			$member_id = $row->member_id;
			
			$wallet = $this->M_coin->get_wallet_address($member_id,'wpc');
			//---------------------------------------------------------------------------------//
			
			$address = $wallet;
			$url='http://api.etherscan.io/api?module=account&action=txlist&address=' .$address .'&startblock=0&endblock=99999999&sort=asc&apikey=YourApiKeyToken';
				
			$datas = json_decode(file_get_contents($url));
			if( $datas->result > 0)
			{
				$volume = 0;
				foreach($datas->result  as $val )
				{
					if(strtolower($address) == strtolower($val->to) )
					{
						$volume = $val->value;
						$txID = $val->hash;
					
						$volume = sprintf('%0.8f', $volume / 1000000000);					
						
						if($volume > 0){
							$bal 	= $this->M_coin->get_balance_id($member_id);
							
							$type 	= "eth";
							$eth 	= $bal->eth + $volume;
							$this->M_point->balance_inout_id($member_id,$type,$eth);	
							echo "$member_id // $volume -->$txID<br>";						
						}
					}
				}
			}
		}
		
		
		//---------------------------------------------------------------------------------//
		/*
		$list = $this->M_point->get_balance_li();
		foreach ($list as $row) 
		{
			$member_id = $row->member_id;
			
			$volume = 0;
			$query = array(
				'coin' 			=> 0,
				'token' 		=> 0,
				'point' 		=> 0,
			);
			$this->db->where('member_no', $row->member_no);
			$this->db->update('m_balance', $query);		
		}
		*/
		//---------------------------------------------------------------------------------//
		// 거래소에서 보낸 토큰 체크하기
		//---------------------------------------------------------------------------------//
		/*------https://etherscan.io/token/0x083f9fa33248883c5da4c7590f99a1121387f5b2------*/
		
		/*
		$contractaddress = $site->cfg_contract;
		
		$list = $this->M_member->get_member_li();
		foreach ($list as $row) 
		{
			$member_id = $row->member_id;
			
			$bal 	= $this->M_coin->get_balance_id($member_id);
			$wallet = $this->M_coin->get_wallet_address($member_id,'wpc');
			//---------------------------------------------------------------------------------//

			$url='https://api.etherscan.io/api?module=account&action=tokenbalance&address='.$wallet.'&c=09&page=1&offset=1000&sort=asc&contractaddress='.$contractaddress.'&apikey=YourApiKeyToken';
			$datas = json_decode(file_get_contents($url));
			
			//---------------------------------------------------------------------------------//
			
			sleep(4);
			//토큰이있다면
			if($datas->result > 10000000000000)
			{				
				$USNS_Balance = $datas->result/1000000000000000000;
				$USNS_Balance = sprintf('%0.4f', $datas->result/1000000000000000000);
				
				// 토큰이 있으면 일단 이전 토큰수량을 확인하고 그것을 뺀다. 
				// 뺀 잔액만큼을 추가한다.
				$USNS_Token	= $USNS_Balance - $bal->coin;
			
				$type 		= "token";
				$token		= $bal->token + $USNS_Token;
				$this->M_point->balance_inout_id($member_id,$type,$token);
			
				$type 		= "coin";
				$coin		= $bal->coin + $USNS_Token;
				$this->M_point->balance_inout_id($member_id,$type,$coin);				
				
				// 나머지 잔고를 시세 계산하여 SVP로 바꾼다.
				// 포인트는 10원으로 계산 - 토큰은 거래소 시세 계산
				$USNS_Won 	= $USNS_Token * $site->cfg_won; // 현재 온 수량의 총 금액
				$UPS_Point 	= $USNS_Won / 10;
				
				if($UPS_Point > 0)
				{
					$type 		= "point";
					$USNSPoint	= $bal->point + $UPS_Point;
					$this->M_point->balance_inout_id($member_id,$type,$USNSPoint);
				}
				
				//echo "$member_id 	$USNS_Balance // $wallet // <br>";
				//echo "$USNS_Won 	= $USNS_Token / $site->cfg_won <br>";
				echo "$UPS_Point 	= $USNS_Won / 10 <br><br>";
			}

		}
		*/

		//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
		//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//		
		// 토큰잔고를 옮긴다 이때 코인의 잔고를 같이 줄여서 같게 만든다. 차후 추가 할 경우 대비
		/*
		include "/var/www/html/wpc/www/application/libraries/Node_rpc.php";
		$rpc = new Node_rpc();
		$coin_id = "WNS";
		//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
		
		$contractaddress 	= $site->cfg_contract;
		$rev_address 		= $site->cfg_address; // 받을 이더 및 토큰 지갑주소
		
		$list = $this->M_member->get_member_li();
		foreach ($list as $row) 
		{
			$member_id = $row->member_id;
						
			$wallet = $this->M_coin->get_wallet_type($member_id,'wpc');
			
				// 회원지갑주소가져와서 체크
				$send_address 	= $wallet->wallet; // 보내는 지갑주소 이더리움 0.01000000 하고 WNS 토큰 
				$password 		= $wallet->wallet_key;
			//---------------------------------------------------------------------------------//
		
			$url="https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=".$contractaddress."&address=".$send_address."&tag=latest&apikey=YourApiKeyToken";
			$datas = json_decode(file_get_contents($url));
			
			//---------------------------------------------------------------------------------//
			sleep(4);
			//토큰이있다면
			if($datas->result > 10000000000000)
			{
				// 이더리움 체크
				$url='https://api.etherscan.io/api?module=account&action=balance&address='.$send_address.'&tag=latest&apikey=YourApiKeyToken';
				
				//수수료개 있다면 전송
				$datas_eth = json_decode(file_get_contents($url));				
				
				if($datas_eth->result > 10000000000000)
				{
					//토큰전송				
					$volume =  $datas->result;
					
					//내주소. 비밀번호. 수량 // 받는주소 //코인명
					$txID = $rpc->erc_move2($send_address,  $password , $volume, $rev_address, $coin_id);
			
					//---------------------------------------------------------------------------------//
					$bal 	= $this->M_coin->get_balance_id($member_id);
					
					$type 		= "token";
					$token		= $bal->token - $volume;
					$this->M_point->balance_inout_id($member_id,$type,$token);
			
					$type 		= "coin";
					$coin		= $bal->coin - $volume;
					$this->M_point->balance_inout_id($member_id,$type,$coin);
				
				}else {
					echo 2;exit;
					// 수수료전송 - 수량은 노드에서 자동 계산해서   전송됨
					//마스터지갑주소. 마스터지갑 비밀번호. 수량 // 받는주소 //코인명
					//  $rpc->fee_move2($rev_address,  $password , $volume, $send_address, $coin_id)
				;
				}
			}
		}
		*/
		alert('전체 토큰 수량 체크 및 옮기기 완료했습니다.');
		
	}
	
	// 매출친 회원의 포인트 내역
	function planPoint()
	{		
		$data['title'] = "회원별 매출 관리";
		$data['group'] = "구좌관리";
		$data['msg'] = "회원별 페이현황";

		$data = page_lists('m_member','member_no',$data);
		$all_su = $this->M_coin->get_total_su();
		$data['all_su'] = $all_su;
		$data['all_su']->all = $all_su->day+$all_su->re+$all_su->mc;
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
			$mb = $this->M_member->get_member($row->member_id);
				$row->name 		= $mb->name;
				$row->office 	= $mb->office;

				$staking = $this->M_coin->getStaking($row->member_id);
				$data['staking'] = new \stdClass();
				if($staking) {
					$row->volume1 = $staking->purchase_hap;
					$row->volume2 = $staking->repurchase_hap;
					$row->volume = $row->volume1+$row->volume2;
				} else {
					$row->volume1	=	0;
					$row->volume2	=	0;
					$row->volume = 0;
				}
		
				$total_su = $this->M_coin->getTotalSu($row->member_id);
				$data['total_su'] = new \stdClass();
				if($total_su) {
					$row->su_day = $total_su->sum_day;
					$row->su_re = $total_su->sum_re;
					$row->su_mc = $total_su->sum_mc;
					$row->total_point = $row->su_day + $row->su_re + $row->su_mc;
				} else {
					$row->su_day = 0;
					$row->su_re = 0;
					$row->su_mc = 0;
					$row->total_point = 0;
				}
			}
		layout('planPoint',$data,'admin');

	}
	
	// 수당관련중심
	function planSu()
	{		
		$data['title'] = "회원별 매출 관리";
		$data['group'] = "구좌관리";
		$data['msg'] = "회원별 페이현황";

		$data = page_lists('m_member','member_no',$data);
		
		// 가공 - 총 매출 금액확인
        foreach ($data['item'] as $row) 
        {
			$mb = $this->M_member->get_member($row->member_id);
				$row->name 		= $mb->name;
				$row->office 	= $mb->office;
				
			$bal 	= $this->M_coin->get_balance($mb->member_no);
			
				$row->level 		= $bal->level;
				$row->volume 		= $bal->volume;
				$row->point 		= $bal->point;			// 총 사용한 코인수량
				$row->coin 			= $bal->coin;
				$row->token 		= $bal->token;
				$row->count 		= $bal->count;
				$row->card 			= $bal->card;
				$row->purchase 		= $bal->purchase;
				$row->purchase_cnt 	= $bal->purchase_cnt;
				
				$row->total_point	= $bal->total_point; 	// 총수당
				$row->point_buy		= $bal->point_buy;		// 적립
				$row->point_accu	= $bal->point_accu;		// 적립
				$row->point_out 	= $bal->point_out;		// 출금가능
				$row->point_trans 	= $bal->point_trans;	// 트랜스퍼가능
				
				$row->su_re			= $bal->su_re;			// 추천
				$row->su_sp			= $bal->su_sp;			// 후원
				$row->su_roll		= $bal->su_roll;		// 후원롤업
				$row->su_mc			= $bal->su_mc;			// 판권매칭
				$row->su_level		= $bal->su_level;		// 판권 꽃판매
				$row->su_ct			= $bal->su_ct;			// 센타그룹비 - 헤븐렉스 수익
        }

		layout('planSu',$data,'admin');

	}
	
	// 매출 정보 삭제 - order_code
	function delete()
	{
		$order_code = $this->input->post('order_code');
		$member_id = $this->input->post('member_id');
		
		// 플랜에 삭제할 것들이 산하를 갖고 있으면 삭제불가한다.
		$item = $this->M_office->get_plan_code($order_code);
        foreach ($item as $row) 
        {
	        $down = $this->M_office->plan_sp_chk($row->member_id);
	        if($down > 0){		        
				alert('삭제할 매출 회원들 중에 산하가 존재 합니다. 단계별로 삭제하세요');
	        }
	    }
		
		// 구매취소 시 관련된 것들 모두 삭제한다.	
		$this->db->where('order_code', $order_code);
		$this->db->delete('m_point');
		
		$this->db->where('order_code',$order_code);
		$this->db->delete('m_volume');
		
		$this->db->where('order_code', $order_code);
		$this->db->delete('m_plan');
		
		// 삭제 후 다른 것들을 위로 올린다. - 차후에 적용하기
		
		goto_url($_SERVER['HTTP_REFERER']);
		
		
	}
	
	
}