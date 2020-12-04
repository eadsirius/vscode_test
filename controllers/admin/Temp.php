<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Temp extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','search','office'));
		
		$this->load->library('form_validation');
		$this->load->library('bitcoin');
		$this->load->library('qrcode');
		$this->load->library('urlapi');
		
		$this->load->library('GoogleAuthenticator');

		//model load
		$this -> load -> model('M_cfg');
		$this -> load -> model('M_admin');
		$this -> load -> model('M_member');
		$this -> load -> model('M_coin');
		$this -> load -> model('M_office');
		$this -> load -> model('M_point');
		$this -> load -> model('M_deadline');
	}	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// 포인트 제조정
	function ckPoint()
	{		
		$list = $this->M_point->get_balance_li();
		foreach ($list as $row) 
		{
			
			$count = $this->M_point->point_in_chk('m_point',$row->member_id);
			
			if($count == 1)
			{
						
				$po = $this->M_point->get_point_id('m_point',$row->member_id);
				
				$won = 1212.5 * $po->msg;
					
				// 누적토큰에서 
				$point = ($row->coin * $won) / 10;
				
				//echo "$count // $row->member_id // $won  == $po->msg<br>";
			
				// 매출자 중에서 
				if($row->volume > 0){
				
					if($point > $row->volume){
						
						$sum = $point - $row->volume;
						echo "$count // $row->member_id // $row->coin // $sum // $point ==> $row->volume  ////<br>";
						
						$query = array(
							'point' 		=> $sum,
						);
						$this->db->where('member_no', $row->member_no);
						$this->db->update('m_balance', $query);		
					}
				}
				
			}
			else if($count == 2){
				
				$po = $this->M_point->get_point_id('m_point',$row->member_id);
				
				$won = 1212.5 * $po->msg;
					
				// 누적토큰에서 
				$point = ($row->coin * $won) / 10;
				
				//if($point > $row->volume){
					
					$sum = $point - $row->volume;
					
					$query = array(
						'point' 		=> 0,
					);
					$this->db->where('member_no', $row->member_no);
					$this->db->update('m_balance', $query);
							
					//echo "$won // $po->msg  == $count // $row->member_id // $row->coin // $sum // $point ==> $row->volume  ////<br>";	
				//}
				
			}
			
			
			/*// 총 적립금
			$sk = $this->M_point->point_puchase_total($row->member_id);
			if(empty($sk)){$sk=0;}
			
				$query = array(
					'point' 		=> 0,
					'volume' 		=> $sk,
				);
				$this->db->where('member_no', $row->member_no);
				$this->db->update('m_balance', $query);
			*/
				
			/*
			if($sk> 0){
				echo "$row->member_id // $row->volume /// $sk <br>";
			}
			*/
			
			
			
			
			
		}
	}
	
	
	
	// 토큰 확인 함수
	function revs_token()
	{		
		$site 	= $this->M_cfg->get_site();
		
			$member_id = 'ksj2880';
			$bal 	= $this->M_coin->get_balance_id($member_id);
			
			$wallet = $this->M_coin->get_wallet_address($member_id,'wns');
			//---------------------------------------------------------------------------------//
			// 거래소에서 보낸 토큰 체크하기
			//---------------------------------------------------------------------------------//
			/*------https://etherscan.io/token/0x083f9fa33248883c5da4c7590f99a1121387f5b2------*/
			$contractaddress = $site->cfg_contract;
			
			$url='https://api.etherscan.io/api?module=account&action=tokenbalance&address='.$wallet.'&c=09&page=1&offset=1000&sort=asc&contractaddress='.$contractaddress.'&apikey=YourApiKeyToken';
			$datas = json_decode(file_get_contents($url));
		
			$USNS_Balance = $datas->result/1000000000;
			$USNS_Balance = sprintf('%0.4f', $datas->result/z);
		
			echo "$member_id 	// $USNS_Balance // $wallet // 13,600,000<br><br>";
			// 포인트는 10원으로 계산 - 토큰은 거래소 시세 계산		
			$USNS_Token		= $USNS_Balance - $bal->coin;
			$USNS_Won 		= $USNS_Token * $site->cfg_won; // 현재 온 수량의 총 금액
			$UPS_Point 		= $USNS_Won / 10;
			
			echo "$USNS_Won 		= $USNS_Token / $site->cfg_won <br><br>";
			echo "$UPS_Point 		= $USNS_Won / 10 <br><br>";
			
			//---------------------------------------------------------------------------------//
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// 코인옮기기
	function send_token()
	{
		$site 	= $this->M_cfg->get_site();
		
		include "/var/www/html/wns/www/application/libraries/Node_rpc.php";
		$rpc = new Node_rpc();
		$coin_id = "WNS";
		//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
		
		$contractaddress 	= "0x083f9fa33248883c5da4c7590f99a1121387f5b2";
		$rev_address 		= '0x358630e449327E59BD8413b6180aE86d752aF9C0'; // 받을 이더 및 토큰 지갑주소
		//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//	
		
			$member_id = 'jjs2456';
			
			$bal 	= $this->M_coin->get_balance_id($member_id);			
			$wallet = $this->M_coin->get_wallet_type($member_id,'wns');
			
				// 회원지갑주소가져와서 체크
				$send_address 	= $wallet->wallet; // 보내는 지갑주소 이더리움 0.01000000 하고 USNS 토큰 
				$password 		= $wallet->wallet_key;
			//---------------------------------------------------------------------------------//

			$url="https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=".$contractaddress."&address=".$send_address."&tag=latest&apikey=YourApiKeyToken";
			$datas = json_decode(file_get_contents($url));

			//---------------------------------------------------------------------------------//
			sleep(4);
			//토큰이있다면
			if($datas->result > 10000000000000)
			{
				$USNS_Balance = $datas->result/1000000000;
				$USNS_Balance = sprintf('%0.4f', $datas->result/1000000000);
				echo $USNS_Balance;
				//---------------------------------------------------------------------------//
				
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
				
				}else {
					exit;
					// 수수료전송 - 수량은 노드에서 자동 계산해서   전송됨
					//마스터지갑주소. 마스터지갑 비밀번호. 수량 // 받는주소 //코인명
					//  $rpc->fee_move2($rev_address,  $password , $volume, $send_address, $coin_id)
				}
			}
	}
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function time_btc()
	{	
		$url = 'https://api.binance.com/api/v1/depth?symbol=BTCUSDT';

		$json_string = file_get_contents($url);

		$R = new RecursiveIteratorIterator(
			new RecursiveArrayIterator(json_decode($json_string, TRUE)),
			RecursiveIteratorIterator::SELF_FIRST);
			// $R : array data
			// json_decode : JSON 문자열을 PHP 배열로 바꾼다
			// json_decode 함수의 두번째 인자를 true 로 설정하면 무조건 array로 변환된다.
		
		$cfg_no = 1;
		$i = 0;
		foreach ($R as $key=>$val) {
	
			//if($key = "bids"){
			if(is_array($val)) { // val 이 배열이면
        		//echo "$key:<br/>";
				//echo $key.' (key), value : (array)<br />';
    		} else { // 배열이 아니면
	    		$i +=1;
				if($i == 2){
					
					$won = $val;
					echo "바이낸스 : $val";
	    		}
    		}
		}
	
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function time_money()
	{	
		exit;
		//---------------------------------------------------------------------------------//	
		// 달러 시세 가져오기
		$service_url 	= 'https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD';
		$getprice 		= $this->urlapi->get_api($service_url);
		$price_array 	= json_decode($getprice, true);    
		$price 			= $price_array[0]['basePrice'];
		//---------------------------------------------------------------------------------//
		
		$data['Symbol'] = "WNS-USDT";
		$data['Symbol'] = "BTC-USDT";
		//$data['Symbol'] = "ETH-USDT";
		$url = "https://api.IDCM.cc:8323/api/v1/getticker";
		$postvars = json_encode($data);
		$APIKEY = 'GpI1P7lhkGN_FmL6OaEog';

$SIGNATURE='PY7lZ1ZLEXelgyQa3ZycbbmXvFh5awnHd8XMyVMe7RPCJFfsBjpTj6cECaQkKTB8zw87A4B8dk4jlJdPqOuQ6uo6Wj9o5suegH3cx7RxHhFZ1SiTW0TVpK1582bhUd2LPQ3EG1ijXW9POo430gr4zyOwFX3vVADteU9bPEdVIzYtBchJX8gDLXcg1xYIXNnmjFATfTdl3wmZAlUsFkxNjZHhIS9iGuXUcC9VCnu4UVAfAcGGCw3Dfz2kXibmJUFz';
		
		$headers = array(
			"X-IDCM-APIKEY:".$APIKEY,
			"X-IDCM-SIGNATURE:".$SIGNATURE,
			"X-IDCM-INPUT:".$postvars
		);
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $postvars);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
		curl_setopt($ch,CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	
		$result = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($result,true);

		$sell = $response["data"]["sell"];
		$usd = $sell;
		$won = $sell * $price;
		
		echo "원화 : $won = 달러 : $sell";
		
		$cfg_no = 1;		
		$query = array(
			'cfg_usd' 	=> $usd,
			'cfg_won' 	=> $won,
		);
		$this->db->where('cfg_no', $cfg_no);
		$this->db->update('m_site', $query);
	}
	//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	// 토큰 확인 함수
	function rev_token()
	{		
		$site 	= $this->M_cfg->get_site();
		
		//$list = $this->M_member->get_member_li();
		//foreach ($list as $row) 
		//{
			$member_id = 'admin';
			$bal 	= $this->M_coin->get_balance_id($member_id);
			
			$wallet = $this->M_coin->get_wallet_address($member_id,'wns');
			//---------------------------------------------------------------------------------//
			// 거래소에서 보낸 토큰 체크하기
			//---------------------------------------------------------------------------------//
			/*------https://etherscan.io/token/0x083f9fa33248883c5da4c7590f99a1121387f5b2------*/
			$contractaddress = $site->cfg_contract;
			
			$url='https://api.etherscan.io/api?module=account&action=tokenbalance&address='.$wallet.'&c=09&page=1&offset=1000&sort=asc&contractaddress='.$contractaddress.'&apikey=YourApiKeyToken';
			$datas = json_decode(file_get_contents($url));
		
			$USNS_Balance = $datas->result/1000000000;
			$USNS_Balance = sprintf('%0.4f', $datas->result/1000000000);
		
			// 포인트는 10원으로 계산 - 토큰은 거래소 시세 계산		
			$USNS_Token		= $USNS_Balance - $bal->coin;
			$USNS_Won 		= $USNS_Token * $site->cfg_won; // 현재 온 수량의 총 금액
			$UPS_Point 		= $USNS_Won / 10;
			
			echo "$member_id 	// $USNS_Balance // $wallet // <br><br>";
			echo "$USNS_Won 		= $USNS_Token / $site->cfg_won <br><br>";
			echo "$UPS_Point 		= $USNS_Won / 10 <br><br>";
			
			$type 		= "token";
			//$this->M_point->balance_inout_id($member_id,$type,$USNS_Token);
			
			$type 		= "coin";
			//$this->M_point->balance_inout_id($member_id,$type,$USNS_Balance);
			
			if($UPS_Point > 0){
				$type 		= "point";
				$USNSPoint	= $bal->point + $UPS_Point;
				//$this->M_point->balance_inout_id($member_id,$type,$USNSPoint);				
			}
			//---------------------------------------------------------------------------------//
		
		//}
	}
	
	//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	// 이더 확인함수
	function chk_eth()
	{
		$site 			= $this->M_cfg->get_site();
		//---------------------------------------------------------------------------------------------------------//

		$url = 'https://api.binance.com/api/v1/depth?symbol=ETHUSDT';
		$json_string = file_get_contents($url);
		$R = new RecursiveIteratorIterator(
			new RecursiveArrayIterator(json_decode($json_string, TRUE)),
			RecursiveIteratorIterator::SELF_FIRST);
			// $R : array data
			// json_decode : JSON 문자열을 PHP 배열로 바꾼다
			// json_decode 함수의 두번째 인자를 true 로 설정하면 무조건 array로 변환된다.
		
		$cfg_no = 1;
		$i = 0;
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
		//---------------------------------------------------------------------------------------------------------//		
		//---------------------------------------------------------------------------------------------------------//
		$eth_count = 1;
		$agc_usd = $site->cfg_usd;
		
		$eth_usd = 1 * $eth_go;
		
		$agc_count = $eth_usd / $site->cfg_usd;
		
		echo "달러시세 : $val -- 원화시세 : $won <br><br>";
		echo "<br>-------------------------------<br>";
		
		//---------------------------------------------------------------------------------------------------------//
		
		$address = '0x358630e449327E59BD8413b6180aE86d752aF9C0';
		//$address = '0xA930C5F199Dbc15B07a78BF4bfa930A4811d07a0';
		$url='http://api.etherscan.io/api?module=account&action=txlist&address=' .$address .'&startblock=0&endblock=99999999&sort=asc&apikey=YourApiKeyToken';
		
		$datas = json_decode(file_get_contents($url));
		if( $datas->result > 0)
		{
			foreach($datas->result  as $val )
			{
				if(strtolower($address) == strtolower($val->to) )
				{
					$volume = $val->value;
					$txID = $val->hash;
					
					$volume = sprintf('%0.8f', $volume / 1000000000);					
					
					echo "$volume //";
					$type 		= "eth";
					$this->M_point->balance_inout_id('admin',$type,$volume);
				}
			}
		}
		
		//"value":"1000000000"

	}
	//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// 발란스 초기화하기
	function set_date()
	{
		$end = "2020-04-01 23:59:59";
		$write_date = date("Y-m-d 23:59:59", strtotime($end."+1day")); // 지급일은 1일 후
		$app_date = date("Y-m-d 23:59:59", strtotime($end."+3month")); // 지급일은 1일 후
		
		echo "$end  // $write_date // $app_date";
	}
	
	// 발란스 초기화하기
	function set_balance()
	{
		set_time_limit(0);
		ini_set('memory_limit','-1');
		$su_table = 'm_point_su';
		$in_table = 'm_point';
		
		
		$list = $this->M_member->get_member_li();
		foreach ($list as $row) 
		{
			$this->M_coin->set_balance_in($row->member_no, $row->member_id);
		}
		
	}
	
	//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
	
	function change_country()
	{		
		$list = $this->M_member->get_member_li();
		foreach ($list as $row) 
		{
			$country 	= $row->country;
			if($country == 'KOR'){	
				$query = array(
					'country' 		=> '82',
				);
				$this->db->where('member_id',$row->member_id);
				$this->db->update('m_member', $query);
			}
		
		}
		
	}
	
	function chk_sub()
	{
		//$data['Symbol'] = "BTC-USDT";
		$data['Symbol'] = "USNS-USDT";
		
		$url = "https://api.IDCM.cc:8323/api/v1/getticker";
		$postvars = json_encode($data);
		$APIKEY = 'GpI1P7lhkGN_FmL6OaEog';
		
$SIGNATURE='PY7lZ1ZLEXelgyQa3ZycbbmXvFh5awnHd8XMyVMe7RPCJFfsBjpTj6cECaQkKTB8zw87A4B8dk4jlJdPqOuQ6uo6Wj9o5suegH3cx7RxHhFZ1SiTW0TVpK1582bhUd2LPQ3EG1ijXW9POo430gr4zyOwFX3vVADteU9bPEdVIzYtBchJX8gDLXcg1xYIXNnmjFATfTdl3wmZAlUsFkxNjZHhIS9iGuXUcC9VCnu4UVAfAcGGCw3Dfz2kXibmJUFz';
		
		$headers = array(
			"X-IDCM-APIKEY:".$APIKEY,
			"X-IDCM-SIGNATURE:".$SIGNATURE,
			"X-IDCM-INPUT:".$postvars
		);
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $postvars);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
		curl_setopt($ch,CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($result,true);

		$sell = $response["data"]["sell"];
		$vlm = $sell * 1000;
		//echo $response["data"]["sell"];//float 부동소수점 실수 유효숫자𝑒지수=유효숫자×10지수
		echo "/// $vlm  <br>";

		//var_dump($response);
		//echo "/// <pre>";
		//print_r($response);exit;
		
		
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function create_token()
	{
		include APPPATH."libraries/Node_rpc.php";
		$rpc = new Node_rpc();
		
		$list = $this->M_point->get_balance_li();
		foreach ($list as $row) 
		{
			$member_id = $row->member_id;
			
			$usns = $this->M_coin->get_wallet_address($member_id,'wns');
			
			if(empty($usns))
			{
				echo "$member_id <br>";
				
				$walletAddress = $rpc->newAddress($member_id);

				if( strlen( $walletAddress['privateKey'] ) > 10 )
				{
					$addr_key = $walletAddress['privateKey'];
					$addr = $walletAddress['address'];
				}			

				//통신 안될경우 중단
				if(!$addr) {
					alert("Error : Create Hvrex Token");
				}
				
				qrcode_mb($member_id);
				
				$type = "wns";
				$qrimg_id = $member_id; // ico qrcode
				qrcode($qrimg_id,$addr);
				
				$qrimg = $member_id .".png"; // ico qrcode
				$this->M_member->member_wallet($member_id,$addr,$qrimg,$type,$addr_key);
				echo "$addr <br>";
				
			}
		
		}
		
	}
	
	
	function chk_token1()
	{
		$site 	= $this->M_cfg->get_site();
		
		//include APPPATH."libraries/Node_rpc.php";
		$contractaddress = $site->cfg_contract;
		
		$list = $this->M_point->get_balance_li();
		foreach ($list as $row) 
		{
			$member_id = $row->member_id;
			
			$bal 	= $this->M_coin->get_balance($row->member_no);			
			$wallet = $this->M_coin->get_wallet_address($row->member_id,'wns');
			
			echo "$member_id // $wallet <br>";
			
			if($member_id == 'admin')
			{
				$address = "0x358630e449327E59BD8413b6180aE86d752aF9C0";
				$apikey = "MHgwZGI1YTBlNWEyNTk4MGNkZDg0YjZmYTBjNmEzMDUzYjFjNGM4ZjVhODdmNWFjNDU5NjZmNzA4MTk0ZjE3M2Rm";
				$url="https://api.etherscan.io/api?module=account&action=tokentx&address=".$address."&c=09&page=1&offset=1000&sort=asc&contractaddress=".$contractaddress."&apikey=".$apikey .'"';

				$datas = json_decode(file_get_contents($url));
				if( $datas->result > 0)
				{
					foreach($datas->result  as $val )
					{
						if(strtolower($address) == strtolower($val->to) )
						{

							$volume = $val->value;
							$txID = $val->hash;
					
							$volume = sprintf('%0.8f', $volume / 1000000000 );
					
							$order_code = order_code();
							$cnt1 = $this->m_coin->getDeposit_tx($txID);
					
							if($cnt1 )
							{
								continue;
							}
							$fee = 0;
							$isvalid = 'deposit';
						
							echo "$volume //";
						
							///$this->m_coin->coin_in($order_code,$member_id,$address,$member_id,$member_id,$val->from,'0',$volume,$fee,$flg,$isvalid,$txID);							
							//$bal 	= $this->m_coin->get_balance($member_no);
							//$type 	= "token";
							//$token 	= $bal->token + $volume;
							//$this->m_coin->balance_inout($member_no,$type,$token);
						}
					}
			
				}
				
			}
		
		}
		
	}
	
	
	function chk_token()
	{
		//include APPPATH."libraries/Node_rpc.php";		
		$contractaddress = "0x2521ed9624aa976d282bb248aa62257a207ff182";
		
		$list = $this->M_point->get_balance_li();
		foreach ($list as $row) 
		{
			$member_id = $row->member_id;
			
			if($member_id == 'company')
			{
				$address = "0xE44841bB8e15C68015A389374063bC06Ae9cd332";
				
				$url='https://api.etherscan.io/api?module=account&action=tokenbalance&address='.$address.'&c=09&page=1&offset=1000&sort=asc&contractaddress='.$contractaddress.'&apikey=YourApiKeyToken';
				$datas = json_decode(file_get_contents($url));
				$FCN_Balance = number_format(sprintf('%0.4f', $datas->result/100000000),4);
					
				//$datas = json_decode(file_get_contents($url));
			
				//$url='https://api.etherscan.io/api?module=account&action=balance&address='.$address.'&tag=latest&&apikey=YourApiKeyToken';				
				//$datas = json_decode(file_get_contents($url));
				//$ETH_Balance =  number_format(sprintf('%0.8f', $datas->result/1000000000),8);
				
				echo "$FCN_Balance ";
			}
		
		}
		
	}
	
	function add_hvrex()
	{
		$list = $this->M_point->get_balance_li();
		foreach ($list as $row) 
		{
			$member_id = $row->member_id;
			
			// 이더토큰 지갑생성하기
			include APPPATH."libraries/CB_Ethereum.php";
			$rpc = new  CB_Ethereum("121.254.175.42","7789");
			$addr = $rpc->personal_newAccount($member_id);

			//통신 안될경우 중단
			if(!$addr) {
				alert("Error : Create Hvrex Token");
			}
			
			$type = "hvrex";
			qrcode($member_id,$addr);
			$qrimg = $member_id ."_H.png"; // ico qrcode
			$this->m_member->member_wallet($member_id,$addr,$qrimg,$type);
			
			
			

			include APPPATH."libraries/Node_rpc.php";


			$rpc = new Node_rpc();
				
			$walletAddress = $rpc->newAddress($coin_id);

			if( strlen( $walletAddress['privateKey'] ) > 10 )
			{
				$addr_key = $walletAddress['privateKey'];
				$addr = $walletAddress['address'];
			}

			

			//통신 안될경우 중단
			if(!$addr) {
				alert("Error : Create FCN Token");
			}
			
			
				// 마스터지갑 에서출금하기
				//외부 출금 성공시
				$isvalid ="transfer";
				include APPPATH."libraries/Node_rpc.php";
				$from = "0xC9d4FF9167c6cCb9e78a5621EF8d6cC1AC3b897e";
				$password = "MHg2ZGNkNWE4MDYwMWRmN2Q5ZDljNWYwOWE5ODFjZDE3Y2Q1NTE5NmY4NzBhNzc5Y2RkNjdlNDI2MmIxMjNjN2Rj";
				$rpc = new Node_rpc();
				// 보낸 주소 // 받는 주소 // 수량  // 비밀번호 // 코인명
				$tx_id = $rpc->erc_move($from,$rev_wallet, $send_count, $password,"FCN");
				if(!$tx_id || $tx_id =='false'){
					alert("외부지갑 출금오류 관리자에개  문의 해주세요.");
				}

				$rev_id = $rev_wallet; // 받을지갑주소
				// 외부출금 주소 성공시  코인 전송
				$this->m_coin->coin_in($order_code,'out',$rev_wallet,'out',$send_id,$send_wallet,'0',$send_count,$fee,$flg,$isvalid,$tx_id);
				
				
		
			$contractaddress = "0x2e1A7C9fc3D30db36153C1e7529024Cc6e7FeC46";
			$address = $data['wallet'];
			//$address = "0x80b6351Bab107604db32305AbB70591958e878BD";

			$url='https://api.etherscan.io/api?module=account&action=tokentx&address='.$address.'&c=09&page=1&offset=1000&sort=asc&contractaddress='.$contractaddress.'&apikey=YourApiKeyToken';
				
			$flg = 'hvrex';
				
				

			$datas = json_decode(file_get_contents($url));
			if( $datas->result > 0)
			{
				foreach($datas->result  as $val )
				{
					if(strtolower($address) == strtolower($val->to) )
					{

						$volume = $val->value;
						$txID = $val->hash;
					
						$volume = sprintf('%0.8f', $volume / 1000000000 );
					
						$order_code = order_code();
						$cnt1 = $this->m_coin->getDeposit_tx($txID);
					
						if($cnt1 )
						{
							continue;
						}
						$fee = 0;
						$isvalid = 'deposit';
						
						$this->m_coin->coin_in($order_code,$coin_id,$address,$coin_id,$coin_id,$val->from,'0',$volume,$fee,$flg,$isvalid,$txID);

							
						$bal 	= $this->m_coin->get_balance($member_no);
						$type 	= "token";
						$token 	= $bal->token + $volume;
						$this->m_coin->balance_inout($member_no,$type,$token);


						
				}
				}
			
			}
				
		}
	}
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
	function put_coin()
	{
		$site = $this->M_cfg->get_site();
		$order_code = order_code(); //주문코드 생성	

		$list = $this->M_point->get_balance_li();
		foreach ($list as $row) 
		{
			if($row->member_id == 'mck7752'){
				// 관리자 충전
				$cate = 'point';
				$add_point = $this->M_coin->get_coin_receive($row->member_id,$cate);
				
				// 매출등록
				$cate = 'purchase';
				$add_purchase = $this->M_coin->get_coin_send($row->member_id,$cate);
				
				$cate = 'su';
				$add_su = $this->M_coin->get_coin_receive($row->member_id,$cate);
				
				$cate = 'coin';
				$add_rev = $this->M_coin->get_coin_receive($row->member_id,$cate);
				
				$cate = 'coin';
				$add_send = $this->M_coin->get_coin_send($row->member_id,$cate);
				
				$cate = 'flower';
				$add_flower = $this->M_coin->get_coin_send($row->member_id,$cate);
				
				$bal = ($add_point + $add_su + $add_rev) - ($add_purchase + $add_send);
				
				echo "$bal//$row->member_id // $add_point // 매출 : $add_purchase // 수당 : $add_su // (받은것)$add_rev = $add_send(보낸것) // $add_flower ";
				
			}
		}
	}
				
	function balance_coin()
	{
		$site = $this->M_cfg->get_site();
		$order_code = order_code(); //주문코드 생성	
		
		$send_id 		= 'master_send';
		$send_wallet 	= 'mWM5k3cn8YTNepbkbsgs9Mn7dhjiYJ15xc';

		$list = $this->M_point->get_balance_li();
		foreach ($list as $row) 
		{
			$coin = $this->bitcoin->getbal($row->member_id);
			
			if($coin > 0){
				//$move = $this->bitcoin->move($row->member_id, $send_id, $coin); // 보내는 사람아이디 , 받는사람, 수량
			}
			
			
			echo "$row->member_id // $coin <br>";
			
			$query = array(
				'coin' 			=> $coin,
			);
			$this->db->where('member_no', $row->member_no);
			$this->db->update('m_balance', $query);
		}
	}
	
	/*
	function reset_datetime()
	{
		$table = 'm_point';
		$list = $this->M_point->get_point_li($table);
		foreach ($list as $row) 
		{
			$sdate = substr($row->regdate,0,8);
			$edate = substr($row->regdate,10);
			$new_date = $sdate .'01' .$edate;
			$query = array(
				'regdate' 			=> $new_date,
			);
			$this->db->where('point_no', $row->point_no);
			$this->db->update($table, $query);
		}
		
		$table = 'm_point_in';
		$list = $this->M_point->get_point_li($table);
		foreach ($list as $row) 
		{
			$sdate = substr($row->regdate,0,8);
			$edate = substr($row->regdate,10);
			$new_date = $sdate .'01' .$edate;
			$query = array(
				'regdate' 			=> $new_date,
			);
			$this->db->where('point_no', $row->point_no);
			$this->db->update($table, $query);
		}
		
		$table = 'm_point_su';
		$list = $this->M_point->get_point_li($table);
		foreach ($list as $row) 
		{
			$sdate = substr($row->regdate,0,8);
			$edate = substr($row->regdate,10);
			$new_date = $sdate .'01' .$edate;
			$query = array(
				'regdate' 			=> $new_date,
			);
			$this->db->where('point_no', $row->point_no);
			$this->db->update($table, $query);
		}
		
	}
	*/
	/*
	function balance_resert()
	{
		$site = $this->M_cfg->get_site();
		$order_code = order_code(); //주문코드 생성	
		
		
		$list = $this->M_point->get_balance_li();
		foreach ($list as $row) 
		{
			$coin = $this->bitcoin->getbal($row->member_id);
			$query = array(								
				'level' 		=> 0,
				'coin' 			=> $coin,				
				'point' 		=> 0,
				'point_out' 	=> 0,
				'point_buy' 	=> 0,
				'point_trans' 	=> 0,
				'point_accu' 	=> 0,
				'volume' 		=> 0,
				'purchase_cnt' 	=> 0,
				'purchase' 		=> '',
				'count' 		=> 0
			);
			$this->db->where('member_no', $row->member_no);
			$this->db->update('m_balance', $query);
			
			$query = array(								
				'total_point' 	=> 0,								
				'su_day' 		=> 0,							
				'su_day_count' 	=> 0,
				'su_re' 		=> 0,
				'su_sp' 		=> 0,
				'su_roll' 		=> 0,
				'su_level' 		=> 0,
				'su_ct' 		=> 0,
				'su_mc' 		=> 0,
			);
			$this->db->where('member_no', $row->member_no);
			$this->db->update('m_balance', $query);
			
			$query = array(								
				'f1_count' 	=> 0,								
				'f2_count' 	=> 0,								
				'f3_count' 	=> 0,								
				'f4_count' 	=> 0,								
				'f5_count' 	=> 0,								
				'f6_count' 	=> 0,								
				'f7_count' 	=> 0,
			);
			$this->db->where('member_no', $row->member_no);
			$this->db->update('m_balance', $query);
		}
		
	}
	*/
	
	
	function create_bal()	
	{		
		// 코인통장에서 자유통장으로 보낸 금액 합 구하기
		$list = $this->M_member->get_member_li();
		foreach ($list as $row) 
		{
			$this->M_coin->set_balance_in($row->member_no, $row->member_id);			
			
		}
		
	}
	
	function qrcode()	
	{		
		// 코인통장에서 자유통장으로 보낸 금액 합 구하기
		$list = $this->M_member->get_member_li();
		foreach ($list as $row) 
		{
			$member_id = $row->member_id;
			$address = $this->M_coin->get_wallet_address($member_id,'agc');
			
			qrcode($member_id,$address);
			
			qrcode_mb($member_id);
			
		}
		
	}
	
	function create_address()	
	{		
		// 코인통장에서 자유통장으로 보낸 금액 합 구하기
		$list = $this->M_member->get_member_li();
		foreach ($list as $row) 
		{
			$type = 'agc';			
			$member_no = $row->member_no;
			$member_id = $row->member_id;
			
			$cnt = $this->M_coin->get_wallet_chk($member_id,$type);
			if(empty($cnt))
			{
				// 비트코인 지갑주소 생성
				$addr = $this->bitcoin->getnewaddress($member_id);
			
				//통신 안될경우 중단
				if(!$addr) {
					alert("Error : 123008 Code");
				}

				qrcode($member_id,$addr);
				$qrimg = $member_id .".png"; // ico qrcode
			
				$this->M_coin->set_wallet_in($member_id,$addr,$qrimg,$type);			
			}
		}
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// 추천인 구하기
	function add_vlm_re()	
	{
		$order_code = order_code(); //주문코드 생성
		$table = "m_volume1";
		
		$list = $this->M_member->get_member_li();
		foreach ($list as $row) 
		{		
			$regdate 	= nowdate();	
			
			// 본인을 먼저 넣고 그 다음에 추가로 입력한다.
			$side = 'middle';
			$this->M_office->vlm_in($table,$order_code,$row->name,$row->member_id,$row->member_id,$row->recommend_id,$side,0,0,$row->regdate);
			
			vlm_re_tree($order_code,$row->name,$row->member_id,$row->recommend_id,0,0,$row->regdate);
			
		}
		
	}
	
	function add_vlm_sp()	
	{
		set_time_limit(0);
		ini_set('memory_limit','-1');
		
		$order_code = order_code(); //주문코드 생성
		$table = "m_volume";		
		$this->db->empty_table($table);
		
		$list = $this->M_member->get_member_li();
		foreach ($list as $row) 
		{
			// 볼륨에 있는지 체크하기
			// 볼륨에 제대로 등록했는지 체크하기
			$input = $this->M_office->vlm_chk($table,$row->member_id);
			if(empty($input))
			{
							
				$chk = $this->M_office->vlm_ev_chk($table,$row->member_id);
				if($chk){
					$this->db->where('event_id', $row->member_id);
					$this->db->delete($table);					
				}
			
				$dep 	= $this->M_member->get_member_dep($row->sponsor_id);	
					$dep = $dep + 1;
				
				$this->M_member->member_dep_up($row->member_id,$dep);
			
				// 본인을 먼저 넣고 그 다음에 추가로 입력한다.
				$side 	= 'middle';
				$table 	= 'm_volume';
				$this->M_office->vlm_in($table, $order_code, $row->name, $row->member_id, $row->member_id, $row->sponsor_id, $side, $dep, 0, $row->regdate);
			
				vlm_tree($order_code, $row->name, $row->member_id, $row->sponsor_id, $dep, 0, $row->regdate);

				echo "$row->member_id,$row->member_id,$row->sponsor_id,$side,0,$dep,$row->regdate <br>";

			}
			
		}

	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	 
	public function qmail() 
	{
		$email = 'helpgo12@gmail.com';
		$member_id = 'kkkk';
		
		$this->mail_send($email,$member_id);
	}
	 public function mail_send($email,$member_id) 
	 {
		$this->load->library('email');
		 
		$config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'email.recovery119@gmail.com';
        $config['smtp_pass']    = 'Gksrmfskf1009';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      

        $this->email->initialize($config);

        $this->email->from('email.recovery119@gmail.com', 'WNS wallet email');
        $this->email->to($email);
        
$message = "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta name='viewport' content='width=device-width' />
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<title>QuestXmining</title>
<link rel='stylesheet' type='text/css' href='http://questxmining.com/assets/css/email.css' />
<link href='http://questxmining.com/assets/css/dark-style.css' rel='stylesheet'/>
<link href='http://questxmining.com/assets/plugins/bootstrap/css/bootstrap.min.css' rel='stylesheet' />
</head>
<body bgcolor='#FFFFFF'>
<!-- HEADER -->
<table class='head-wrap'>
	<tr>
		<td class='header container' >
			<div class='content'><img src='http://questxmining.com/assets/images/qmB.png' /></div>
		</td>
	</tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class='body-wrap'>
	<tr>
		<td class='container' bgcolor='#FFFFFF'>
			<div class='content'>
			<table>
				<tr>
					<td>
						<h3>Hi, $member_id</h3>
						<p class='lead'>Thank you for signing up with questxmining.com</p>
						<p>To provide you the best service possible, we require you to verify your email address. </p>
						<!-- Callout Panel -->
						<p class='callout'>
							<a href='http://questxmining.com/member/email/$member_id'> <button type='button' class='btn btn-info' style='height: 46px;'><i class='fa fa-check'></i> Yes, This is my email</button></a>
						</p><!-- /Callout Panel -->					

					</td>
				</tr>
			</table>
			</div><!-- /content -->			
		</td>
	</tr>
</table><!-- /BODY -->
</body>
</html>
";

        $this->email->subject('QuestXmining Mail ');
        $this->email->message($message); 

        $this->email->send();

        echo $this->email->print_debugger();


	 }
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function api()	
	{
		$exchange_url="https://api.binance.com/api/v1/ticker/24hr";
		
		//$ch = curl_init();
		//curl_setopt($ch, CURLOPT_URL, $exchange_url);
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);
		//$rt = curl_exec($ch);
		//curl_close($ch);
		
        
		$json_string = file_get_contents($exchange_url);
		$R = new RecursiveIteratorIterator(
			new RecursiveArrayIterator(json_decode($json_string, TRUE)),
			RecursiveIteratorIterator::SELF_FIRST);
		$cfg_no = 1;
		$i = 0;
		foreach ($R as $key=>$val) 
		{	
			//if($key = "bids"){
			if(is_array($val)) 
			{ // val 이 배열이면
        		echo "$key:<br/>";
				//echo $key.' (key), value : (array)<br />';
    		}
    		else
    		{ // 배열이 아니면
	    		$i +=1;
	    		
				//if($i >= 241 and $i <= 245){
				//if($i == 241){
				echo "-> $val:<br/>";
					
				//}
    		}
			//}
		}
		
		
		//echo $rt;
		//var_dump($rt);        //결과 값 출력
		//echo $rt[0][0];
		echo "<br><br>==============<br>";
        
        //var_dump(json_decode($rt, true));
		/*
		const Binance = require('node-binance-api');
		const binance = new Binance().options({
			APIKEY: '718jQnqfZVmtijrkzFz7MKhZMj2PTF3PY8S1CinBYKMCzOsK9THnvHOcByASjHP4', //발급받은 API KEY를 적어주세요.
			APISECRET: 'j7Wv7mqNbaqhkwlVZcdLpCYxT9tjkZMsOsGHKZDJUtgr8I29Ne4rAQn6B1zc9VHF', //발급받은 SECRET API KEY를 적어주세요.
			useServerTime: true, // If you get timestamp errors, synchronize to server time at startup
			test: true // If you want to use sandbox mode where orders are simulated
		});

		binance.depth("ETHBTC", (error, depth, symbol) => {
			console.log(symbol+" market depth", depth);
		});
		*/
		
		/*
		//-------------------------------------------------------------------------
		// 거래소 시세가져오기		
		$service_url 	= 'http://api.nd-exk.com/public/quotes/btc';
		$getinfo 		= $this->urlapi->get_api($service_url);
		$json_string 	= $getinfo;
		$data_array 	= json_decode($json_string, true);
		$BTC_cash 		= $data_array['CASH']['BTC'];
		$BTC_btc 		= $data_array['BTC']['BTC'];
		
		echo "$BTC_btc // $BTC_cash<br> ---";
		
		// 달러 시세가져오기
		$service_url = 'https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD';
		$getprice = $this->urlapi->get_api($service_url);
		$price_array = json_decode($getprice, true);    
		$price = $price_array[0]['basePrice'];
		
		$coin_volume = $BTC_cash / $price;
		$data['coin_volume'] 	= round($coin_volume,2);
		
		
		//echo "$coin_volume = $dcp_cash / $price <br> ---";
		//-------------------------------------------------------------------------
		*/
	}
	
	/*
	function USDapi() {
		$exchange_url="https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $exchange_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);
		$rt = curl_exec($ch);
		curl_close($ch);

        
        //var_dump(json_decode($rt, true));
        
		//echo $rt;
		//var_dump($rt);        //결과 값 출력
		
		
		
		$url = 'https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD';
		$json_string = file_get_contents($url);
		$R = new RecursiveIteratorIterator(
			new RecursiveArrayIterator(json_decode($json_string, TRUE)),
			RecursiveIteratorIterator::SELF_FIRST);
		$cfg_no = 1;
		$i = 0;
		foreach ($R as $key=>$val) {
	
			//if($key = "bids"){
			if(is_array($val)) { // val 이 배열이면
        		echo "$key:<br/>";
				//echo $key.' (key), value : (array)<br />';
    		} else { // 배열이 아니면
				$won = $val * 1200;
	    		$i +=1;
				if($i == 9){
				echo "---------$val:<br/>";
					
				}
    		}
			//}
		}
		
	}
	
	
	function api() {
		$exchange_url="http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22USDKRW,EURKRW,JPYKRW,CNYKRW%22)&format=json&env=store://datatables.org/alltableswithkeys&callback=";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $exchange_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);
		$rt = curl_exec($ch);
		curl_close($ch);

		$url = 'https://api.binance.com/api/v1/depth?symbol=BTCUSDT';

		$json_string = file_get_contents($url);

		$R = new RecursiveIteratorIterator(
			new RecursiveArrayIterator(json_decode($json_string, TRUE)),
			RecursiveIteratorIterator::SELF_FIRST);
			// $R : array data
			// json_decode : JSON 문자열을 PHP 배열로 바꾼다
			// json_decode 함수의 두번째 인자를 true 로 설정하면 무조건 array로 변환된다.
		
		$cfg_no = 1;
		$i = 0;
		foreach ($R as $key=>$val) {
	
			//if($key = "bids"){
			if(is_array($val)) { // val 이 배열이면
        		//echo "$key:<br/>";
				//echo $key.' (key), value : (array)<br />';
    		} else { // 배열이 아니면
	    		$i +=1;
				if($i == 2){
					
					$won = $val * 1200;
					$query = array(
						'cfg_usd' 			=> $val,
						'cfg_won' 			=> $won,
					);
					$this->db->where('cfg_no', $cfg_no);
					$this->db->update('m_site', $query);		    	
	    		}
    		}
			//}
		}
	}
	*/
}
?>