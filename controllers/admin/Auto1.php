<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auto1 extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','search','office'));
		
		$this->load->library('form_validation');
		//$this->load->library('bitcoin');
		$this->load->library('qrcode');
		$this->load->library('urlapi');
		
		//$this->load->library('GoogleAuthenticator');

		//model load
		$this -> load -> model('M_cfg');
		$this -> load -> model('M_admin');
		$this -> load -> model('M_member');
		$this -> load -> model('M_coin');
		$this -> load -> model('M_office');
		$this -> load -> model('M_point');
		$this -> load -> model('M_deadline');

		$login_id 		= $this->session->userdata('member_id');
		$data['mb'] 	= $this->M_member->get_member($login_id);
	}
	
	function index() 
	{

		exit;;
		//---------------------------------------------------------------------------------//	
		// 달러 시세 가져오기
		$service_url 	= 'https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD';
		$getprice 		= $this->urlapi->get_api($service_url);
		$price_array 	= json_decode($getprice, true);    
		$price 			= $price_array[0]['basePrice'];
		//---------------------------------------------------------------------------------//
		
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
		$usd = $sell;
		$won = $sell * $price;
		
		$cfg_no = 1;		
		$query = array(
			'cfg_usd' 	=> $usd,
			'cfg_won' 	=> $won,
		);
		$this->db->where('cfg_no', $cfg_no);
		$this->db->update('m_site', $query);
		
		
		$site 			= $this->M_cfg->get_site();
		//---------------------------------------------------------------------------------//
		// 거래소에서 보낸 토큰 체크하기
		/*------https://etherscan.io/token/0x083f9fa33248883c5da4c7590f99a1121387f5b2------*/
		$contractaddress = $site->cfg_contract;
		//---------------------------------------------------------------------------------//
		$list = $this->M_member->get_member_li();
		foreach ($list as $row) 
		{	
			$order_code = order_code();  	// 주문코드 만들기
			
			$member_id = $row->member_id;

			$wallet = $this->M_coin->get_wallet_address($member_id,'wns');
			
			//---------------------------------------------------------------------------------//
			
			$url='https://api.etherscan.io/api?module=account&action=tokenbalance&address='.$wallet.'&c=09&page=1&offset=1000&sort=asc&contractaddress='.$contractaddress.'&apikey=YourApiKeyToken';
			$datas = json_decode(file_get_contents($url));
			
			//---------------------------------------------------------------------------------//
		
			sleep(10);
			//토큰이있다면
			if($datas->result > 10000000000000)
			{
				$USNS_Balance = $datas->result/1000000000;
				$USNS_Balance = sprintf('%0.4f', $datas->result/1000000000);
				//---------------------------------------------------------------------------//
				
				$bal 	= $this->M_coin->get_balance_id($member_id);
				
				// 스왑수량 $USNS_Balance 그냥 들어온 그대로 기록한다. 나중에 여기에서 다시 관리자로 빠져나간다.
				$type 		= "token";
				$token		= $bal->token + $USNS_Balance;
				$this->M_point->balance_inout_id($member_id,$type,$token);
				
				
				// 토큰이 있으면 일단 이전 토큰수량을 확인하고 그것을 뺀다. // 뺀 잔액만큼을 추가한다.
				$USNS_Token	= $bal->coin - $USNS_Balance;
				
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
					
					$thing 		= 'swap';
					$table 		= 'm_point_in';
					$this->M_point->pay_exc($table, $order_code, $row->country, $row->office, $member_id, 'master',$UPS_Point, $USNS_Token, 'wns','change');
				}
			}
			//---------------------------------------------------------------------------------//
		
		}
	}
}
?>