<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Countcoin extends CI_Controller
{
	
	private $_hRedis;

	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('file','form', 'url','search'));
// 		$this->load->library('form_validation');
		
// 		$this->load->library('Elwallet_api'); 
		
		//모델 로드
		$this->load->model('m_coin');
		$this->load->model('m_rpc_model');
		$this->load->model('m_balanace');
		$this->load->model('m_redis');
		$this->load->model('m_member');
		
		$this->load->library('qrcode');
		
		
		if (!$this->_hRedis) {
			$this->_hRedis = $this->m_redis->getRedisDrive();
		}
		
	}
	
	public function test()
	{
// 		$this->_hRedis->set('UCEblock', 0);
		echo $this->_hRedis->get('UCEblock');
		
		$client = $this->m_rpc_model->getRpcClass('uce');
		$txData = $client->token_getBalance('0x28ea613e849b25d5622b321fab2048eaf65e0696');
		
		echo "<pre>";
		print_r($txData);
		
// 		$member_id = "test2111";
// 		include APPPATH."libraries/CB_Ethereum.php";
		
// 		$rpc = new  CB_Ethereum("112.175.114.104","8589");
// 		$addr = $rpc->personal_newAccount($member_id);
		
// 		qrcode($member_id,$addr);
// 		$qrimg = $member_id .".png"; // ico qrcode
		
// 		$member = $this->m_member->get_member($member_id);
// 		$this->m_coin->set_wallet_in($member_id, $member->member_no, $addr,$qrimg);
		
		
// 		$aa = "9999999979";
// // 		$aa = "9999999979000000000000000000";
// 		$bb = bcdiv( $aa , 1000000000, 18 );
// 		if ($bb >= 1) $bb = $bb + 0;
// 		echo $bb;

// 		echo "<h1>redis 테스트<h1><br/>";
// 		$redis_host = "127.0.0.1";
// 		$redis_port = 6379;
// 		echo "<h1>redis 테스트<h1><br/>";
// 		try {
// 			$redis = new Redis();
// 			$redis->connect($redis_host, $redis_port, 1000);
// 			$key = "mytest:first_key:incr_test"; //키분류는 :(콜론)을 찍는게 일반적
// 			$value = $redis->get($key);
// 			echo "value : ".$value."<br>";
// 			$redis->incr($key); //테스트를 위해 값증가
// 			$redis->expire($key, 3); //3초만 유지함.
// 		} catch(Exception $e) {
// 			die($e->getMessage());
// 		}
		
		
// 		print_r(phpinfo());

// 		exit;
		
	}
	
	
	//uce 입금 체크
	function setDepositUCE()
	{
		$START_ETH  = $this->_hRedis->get('START_UCE');
		
// 		echo $this->_hRedis->get('UCEblock');
		
// 		if( $START_ETH == "N" )
// 		{
// 			//프로세스 진행중 멈춤
// 			exit;
// 		}
		
		$this->_hRedis->set('START_UCE', "N");
		
		$coin_type = "uce";
		$Decimals = 9;
		$msg = "deposit";
		$order_code = order_code();  // 주문코드 만들기
		$contractaddress = "0xd96e8ecd950533b1d611b00a76488c98829c8053";
		$Apietherscan = "https://api.etherscan.io/api?module=account&action=tokentx";
		
// 		error_reporting(E_ALL);
// 		ini_set("display_errors", 1);
		
		
	
		$startblock  = ( $this->_hRedis->get('UCEblock') ) ? $this->_hRedis->get('UCEblock') : "0";

		//uce		 내역 가져오기
		$data = json_decode( file_get_contents( $Apietherscan."&contractaddress=".$contractaddress ."&page=1&offset=50&sort=asc&apikey=YourApiKeyToken&startblock=".$startblock."&sort=asc" ) );
		
		foreach( $data->result as $key => $values )
		{
			$amount = bcdiv( $values->value , 1000000000, $Decimals );	
			$startblock = $values->blockNumber;
			
// 			echo "<pre>";
// 			print_r($data);
// 			echo " amount = ". $amount;
			
			//if (empty($this->m_coin->getTradingCnt($values->hash)) === TRUE) continue;
			
			$address = $this->m_coin->get_wallet_addr($values->to, $coin_type);
			if (empty($address) === TRUE) continue;
			if ( $this->m_coin->getTradingCnt($values->hash) > 0) 
			{
				 continue;			
			}
			
			$this->m_balanace->setBalance($coin_type, 2, $address->mb_no , $amount , $msg, true);
			$this->m_coin->coin_in($order_code, $address->member_id, $values->to, 'admin', $values->from, $amount, $amount, '0', 'complete', 'uce', $msg, $values->hash);

		}
		$this->_hRedis->set('UCEblock', $startblock);
		$this->_hRedis->set('START_UCE', "Y");
	
	}
	
	
	
	//bct 입금 집계
	function count_uce()
	{
	
		$coin_type = "uce";
		$Decimals = 9;
		
		echo date("Y-m-d h:i:s").'UCE 집계 시작\n';
	
		$client = $this->m_rpc_model->getRpcClass($coin_type);
		
		$lastNo  = ( $this->m_coin->getCountLastNum(1) ) ? $this->m_coin->getCountLastNum(1) : "0";
		
		//토큰이력 리스트
		$data = $this->m_coin->getDepositAdm($coin_type);
		
		echo "<pre>";
		print_r($data);
		
		//코인 집계
		foreach( $data as $key => $list ) {
			
			if ($list->coin_no > $lastNo) {
				
				$txData = $client->token_transactions_admin($list->member_address, $list->member_id);
				
				echo "<pre>";
				print_r($txData);
				
				if($txData->log == 'token') {
					$param['no'] = 1;
					$param['member_id'] = $list->member_id;
					$param['send_addr'] = $txData->send_addr;
					$param['to_addr'] = $txData->to_addr;
					$param['txid'] = $txData->txid;
					$param['sendAmount'] = $txData->sendAmount;
					$param['gasFee'] = $txData->gasFee;
					$param['log'] = $txData->log;
					$param['lastNo'] = $list->coin_no;
					$param['coin_type'] = $coin_type;
					
					if ($txData->txid) {
							
						$this->m_coin->updateLastNum($param);		//최신 lastNumber 수정
						$this->m_coin->setCountHistoryAdm($param);	//집계 히스토리
							
						echo "<pre>";
						print_r($param);
					}
				}
				
			}
			
		}
		
		echo date("Y-m-d h:i:s").'UCE 집계 종료\n';
	
	}
	

}

