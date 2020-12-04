<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bapi extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','search','office'));
		
		$this->load->library('form_validation');
		$this->load->library('bitcoin');
		$this->load->library('qrcode');

		//model load
		$this -> load -> model('M_cfg');
	}
	
	
	
	function index() {
		exit;
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
			if(is_array($val)) 
			{ // val 이 배열이면
        		//echo "$key:<br/>";
				//echo $key.' (key), value : (array)<br />';
    		} 
    		else 
    		{ // 배열이 아니면
	    		$i +=1;
				if($i == 2)
				{
					//echo $val;
					
					//$usd = $val * 0.02;
					$usd = $val - $usd;
					$won = $val * 1200;
					//echo "===$usd // $won";
					
					$query = array(
						'cfg_usd' 			=> $usd,
						'cfg_won' 			=> $won,
					);
					$this->db->where('cfg_no', $cfg_no);
					$this->db->update('m_site', $query);		    	
	    		}
    		}
		}
	}
	
}