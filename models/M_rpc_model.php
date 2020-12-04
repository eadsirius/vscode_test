<?php

class m_rpc_model extends CI_Model {

	/**
	 * @param $coin_type
	 * @return CB_Ethereum|CB_RpcClient
	 */
	public function getRPCClass($coin_type)
	{
		$driver = 'CB_Ethereum';
		$host_name = NULL;
		$port = NULL;

		switch ($coin_type) {
			case 'smit' :
				$driver = 'Eth_rpc';
				$host_name = '210.122.45.117:8545/'; //"노드서버아이피 :8545";
				break;
			default:
				return NULL;
				break;
		}

		if (class_exists($driver) !== TRUE) require_once APPPATH . "libraries/{$driver}.php";
		return new $driver($host_name, $port);
	}

}
