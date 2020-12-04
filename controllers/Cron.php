<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','search','office'));
		
		$this->load->library('form_validation');
		$this->load->library('qrcode');
		$this->load->library('urlapi');

		//model load
		$this -> load -> model('M_cfg');
		$this -> load -> model('M_admin');
		$this -> load -> model('M_member');
		$this -> load -> model('M_coin');
		$this -> load -> model('M_point');
		
	}

	function index()
	{
		$this->token();
		
	}
	

	

	
	function token()
	{
		
		// 달러 시세 가져오기
		$service_url 	= 'https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD';
		$getprice 		= $this->urlapi->get_api($service_url);
		$price_array 	= json_decode($getprice, true);    
		$price1 			= $price_array[0]['basePrice']; // 실시간 달러시세
		
		$cfg_no = 1;
		// 1개당가격
		
		$apikey= "15ee7340e5c295";
		$time = time();
		$arr = [
			'type' => 'WNS',
			'symbol' => 'krw_btc',
			'timestamp' => $time,
			'apiKey' => $apikey,
			'apiSecret' => 'b4a589894a387f5d75d4a4560e39742b05ee7340e'
		];
		ksort($arr);
		$string = implode('', array_values($arr));
		$sign = md5($string);
		// $url = "https://openapi.digifinex.kr/v2/ticker?apiKey=".$apikey."&symbol=krw_mcc";
		// $datas = json_decode(file_get_contents($url));
		
		// $won = $datas->ticker->krw_mcc->last;
		// $won = '350';

		$site = $this->M_cfg->get_site();
		$won =	$site->cfg_won;

		$price = '1200';
		// 0보다클경우에만실행
		if(	$won > 0 )
		{
	
			$usd = 	sprintf('%0.4f',$won/$price);
			$query = array(
				'cfg_usd' 	=> $usd,
				'cfg_won' 	=> $won,
			);
			$this->db->where('cfg_no', $cfg_no);
			$this->db->update('m_site', $query);
			
		}
		exit;
		// 입금처리는 메인페이지에서 처리하기
		$site 			= $this->M_cfg->get_site();
		//---------------------------------------------------------------------------------//
		// 거래소에서 보낸 토큰 체크하기
		/*------https://etherscan.io/token/0x083f9fa33248883c5da4c7590f99a1121387f5b2------*/
		//$contractaddress = $site->cfg_contract;
		// 모카 코인컨트렉주소
		$contractaddress = "0x083f9fa33248883c5da4c7590f99a1121387f5b2";
		$apikey = "IWE2ZU6TG49YXT16DKBHY28ZZNBYQE3748"; // 이더스캔 주소필요
		//---------------------------------------------------------------------------------//
		$list = $this->M_member->get_member_li();
		foreach ($list as $row) 
		{	
			$order_code = order_code();  	// 주문코드 만들기
			
			$member_id = $row->member_id;

			$wallet = $this->M_coin->get_wallet_address($member_id,'wns');
		
				
					
					$url='https://api.etherscan.io/api?module=account&action=tokentx&address='.$wallet.'&c=09&page=1&offset=1000&sort=asc&contractaddress='.$contractaddress.'&apikey='.$apikey;
					
					$datas = json_decode(file_get_contents($url));
			
			

					if($datas->result)
					{
						foreach($datas->result  as $val )
						{
							if(strtolower($wallet) == strtolower($val->to) )
							{
								$volume = $val->value;
								$txID = ($val->hash);
							
							
								$cnt = $this->M_member->get_txid($txID);
								if($cnt)
								{
									
									continue;
								}


								$this->M_member->set_txid($txID);

							
								$USNS_Token = sprintf('%0.4f', $volume/1000000000);
								//---------------------------------------------------------------------------//

								$bal 	= $this->M_coin->get_balance_id($member_id);
								
								// 스왑수량 $USNS_Balance 그냥 들어온 그대로 기록한다. 나중에 여기에서 다시 관리자로 빠져나간다.
								

								// 토큰이 있으면 일단 이전 토큰수량을 확인하고 그것을 뺀다. // 뺀 잔액만큼을 추가한다.
							

								$type 		= "coin";
								$coin		= $bal->coin + $USNS_Token;
						
								$this->M_point->balance_inout_id($member_id,$type,$coin);


								// 나머지 잔고를 시세 계산하여 SVP로 바꾼다.
								// 포인트는 10원으로 계산 - 토큰은 거래소 시세 계산
								//$site->cfg_won 거래소 금액
								$USNS_Won 	= $USNS_Token * $site->cfg_won; // 현재 온 수량의 총 금액
								$UPS_Point 	= $USNS_Won / 10;
								
								if($UPS_Point > 0)
								{
									$type 		= "point";
									$USNSPoint	= $bal->point + $UPS_Point;
									$this->M_point->balance_inout_id($member_id,$type,$USNSPoint);
									
									$thing 		= 'swap';
									$table 		= 'm_point_in';
									$this->M_point->pay_exc($table, $order_code, $row->country, $row->office, $member_id, 'master',$UPS_Point, $USNS_Token, 'wns','change');
								}



							}
						}
				
					}else {
					
						continue;
					}
				
			
			
		}
		
		
	}
	
	function move_token()
	{
		
	
		include "/var/www/html/wns/www/application/libraries/Node_rpc.php";
		$rpc = new Node_rpc();
		
		$site 	= $this->M_cfg->get_site();
		//---------------------------------------------------------------------------------//
		
		$list = $this->M_coin->get_wallet_li('wns');
		$admin = $this->M_coin->get_wallet_mb('admin','wns');
	
		
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
				//$address = ""
				// 토큰 수량 체크
				$url="https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=".$contractaddress."&address=".$address."&tag=latest&apikey=".$apikey;

				$datas = json_decode(file_get_contents($url));


				if($datas->result > 10000000000000)
				{
					// 이더리움 체크
					$url='https://api.etherscan.io/api?module=account&action=balance&address='.$address.'&tag=latest&apikey='.$apikey;
					
					
					//수수료개 있다면 전송
					$datas_eth = json_decode(file_get_contents($url));				

					if($datas_eth->result > 1800000000000000)
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
						//	$type 	= "token";
							//$token 	= $bal->token - $volume;
						//	$token =  $token < 0 ? 0 :$volume ;
							//$this->M_point->balance_inout_id($member_id,$type,$token);	
						}
					}else {
							
						 //수수료 전송
						$txID =  $rpc->fee_move2($rev_address , $rev_password , $address);
						
					}
				} else 
				{
					// 이더스캔에 자산없는 없는것은 0ㅇ처리
				//	$type 	= "token";
				//	$token = 0;
				//	$this->M_point->balance_inout_id($member_id,$type,$token);	
				//
				}
		}
	
	}

	public function adminEthMove()
	{
		include "/var/www/html/wns/www/application/libraries/Node_rpc.php";
		$rpc = new Node_rpc();

		$txID =  $rpc->fee_move3();	

		echo $txID;
	}
}	
?>
