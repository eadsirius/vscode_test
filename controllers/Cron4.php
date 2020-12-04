<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron4 extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','search','office'));
		
		$this->load->library('form_validation');
		$this->load->library('qrcode');
		$this->load->library('urlapi');
		$this->load-> model('M_point');

		//model load
		$this -> load -> model('M_cfg');
		$this -> load -> model('M_admin');
		$this -> load -> model('M_member');
		$this -> load -> model('M_coin');
		$this -> load -> model('Token_model');
		
	}

	function index()
	{
		$this->token();
		
	}
	

	

	// TX ID체크하기
	function token()
	{
	
		/*------https://etherscan.io/token/0x083f9fa33248883c5da4c7590f99a1121387f5b2------*/
		$apikey = "IWE2ZU6TG49YXT16DKBHY28ZZNBYQE3748"; // 이더스캔 주소필요

		$data = $this->Token_model->GetList();
	
		foreach($data as $row)
		{
		// 보낸리스트가져오기
			if($row->tx_id)
			{
				$tx_id = $row->tx_id;
			
				$url = 'https://api.etherscan.io/api?module=transaction&action=getstatus&txhash='.$tx_id.'&apikey='.$apikey;

				$datas = json_decode(file_get_contents($url),true);
					
				// 에러날경우 다시보내기
				if( $datas['result']['isError'] == 1 )
				{
					//다시보내횟수
					$data = $this->Token_model->ErrSendcnt( $row->point_no, $tx_id );
					$param['table'] = "m_point_out";
					$param['tx_id'] = "";
					$param['kind'] = "request";
					$param['point_no'] = $row->point_no;
					$po = $this->M_point->point_out_up($param);


					


				// 보냄으로 처리하기
				}else 
				{

					$url = 'https://api.etherscan.io/api?module=transaction&action=gettxreceiptstatus&txhash='.$tx_id.'&apikey='.$apikey;

					$datas = json_decode(file_get_contents($url),true);

					// 정상으로 보낼경우 최공저장
					if( $datas['result']['status'] == 1 )
					{
						//정상으로 보낼경우 최종으로 저장하기
						$param['tx_id'] = $tx_id;
						$param['table'] = "m_point_out";
						$param['kind'] = "company";
						$param['point_no'] = $row->point_no;
						$po = $this->M_point->point_out_up($param);

					}
				
				}
			}
			
		}

		
		
	}
	
}	
?>
