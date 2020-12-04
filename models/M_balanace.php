<?php

/**
 * Created by PhpStorm.
 * User: "kdg@coinpinex.com"
 * Date: 2017-07-31
 * Time: 오후 1:29
 */
class M_balanace extends CI_Model {

	function M_balanace()
	{
		parent::__construct();
	}

	//포인트전체정보
	/**
	 * @param $mb_no
	 * @return mixed
	 */
	public function getInfo($mb_no)
	{
	
		$this->db->select('*');
		$this->db->from('cb_balance');
		$this->db->where('mb_no',$mb_no);

		$query = $this->db->get();
		$item = $query->row();
		return $item;

	}


	/**
	 * @param $coin_type
	 * @param $kind
	 * @param $mb_no
	 * @param $balance
	 * @param $etc
	 */
	public function setBalance($coin_type, $kind, $mb_no, $balance, $etc, $trans = true)
	{
		$balance_info = $this->getInfo($mb_no);	
		$pre = (isset($balance_info->volume)) ? $balance_info->volume: 0;
		$now = ($kind == 1) ? $pre - $balance  : $pre + $balance;
	
		// 현재 금액이 0보다 작을경우 0처리
		$now = ( $now > 0 ) ? $now : 0;

		if ($trans) {
			$this->db->trans_start();
		}
		// 포인트 저장
		$sql = "
				INSERT  cb_balance_history set
				   `mb_no`	  = {$mb_no}	
				  ,`coin_type`  = '{$coin_type}'
				  ,`pre`		  = '{$pre}'
				  ,`change`	  = '{$balance}'
				  ,`now`		  = '{$now}'
				  ,`kind`		  = '{$kind}'
				  ,`etc`		  = '{$etc}'
				  ,`create_at`  = now() 
		";

		$this->db->query($sql);

		$sql = "
				INSERT cb_balance  SET 
					 mb_no		= {$mb_no}
				   ,`coin_type`  = '{$coin_type}'
					,volume		= '{$now}'
				on duplicate key update
				 	volume = '{$now}'
		";

		$this->db->query($sql);
		if ($trans) {
			$this->db->trans_complete();
		}

	}

	public function getBalanceWhere($params)
	{
		$where = array();
		if ($params['mb_no']) {
			$where['mb_no'] = $params['mb_no'];
		}
		if ($params['wl_no']) {
			$where['wl_no'] = $params['wl_no'];
		}

		if ($params['state']) {
			$where['state'] = $params['state'];
		}

		if ($params['kind']) {
			$where['kind'] = $params['kind'];
		}

		if ($params['coin_type']) {
			$where['coin_type'] = $params['coin_type'];
		}

		if ($params['create_at']) {
			$where['DATE_FORMAT(create_at, "%Y%m%d")'] = date("Ymd");
		}

		if ($params['edate']) {
			$where['DATE_FORMAT(create_at, "%Y-%m-%d") <=  "'.$params['edate'].'"' ] = '';
		}

		if ($params['sdate']) {
			$where['DATE_FORMAT(create_at, "%Y-%m-%d")  >= "'.$params['sdate'].'"' ] = '';
		}


		return $where;
	}

	/**
	 * @param $mb_no
	 * @param int $page
	 */

	public function getBalanceCnt($params)
	{
		$where = $this->getBalanceWhere($params);
		$this->select('count(*) as cnt')->from('cb_balance_history');
		$row = $this->fetch($where, 'one');
		return $row['cnt'];
	}


	public function getBalanceHistory($params, $limit = "one")
	{
		$where = $this->getBalanceWhere($params);
		$this->select('*')->from('cb_balance_history');
		$this->order_by("no desc");

		$rows = $this->fetch($where, $limit);
	//	echo $this->db->last_query();	
		return $rows;

	}


	public function balance_update() {
		$sql="UPDATE m_balance a
							INNER JOIN ( SELECT x.member_id, SUM( IFNULL(x.sum_day,0)) sum_day,  SUM( IFNULL(x.sum_re,0)) sum_re,  SUM( IFNULL(x.sum_re2,0)) sum_re2,  
																						SUM( IFNULL(x.sum_mc,0)) sum_mc,  SUM( IFNULL(x.sum_mc2,0)) sum_mc2
							FROM ( 

							SELECT member_id, 
							case
							when kind ='day' then sum(ifnull(point,0))
							END AS sum_day,

							case
							when kind ='re' then sum(ifnull(point,0))
							END AS sum_re,

							case
							when kind ='re2' then sum(ifnull(point,0))
							END AS sum_re2,

							case
							when kind ='mc' then sum(ifnull(point,0))
							END AS sum_mc,

							case
							when kind ='mc2' then sum(ifnull(point,0))
							END AS sum_mc2 
							FROM m_point_su                
							WHERE cate ='su'
							GROUP BY member_id, kind
							) x
							GROUP BY x.member_id 

											) b
							SET su_day = b.sum_day +basic_day
								,su_re  = b.sum_re  +basic_re
								,su_re2 = b.sum_re2 +basic_re2
								,su_mc  = b.sum_mc  +basic_mc
								,su_mc2 = b.sum_mc2 +basic_mc2
								,total_point = ifnull(release_point,0) 
															+ b.sum_day +basic_day 
															+ b.sum_re  +basic_re 
													+ b.sum_re2 +basic_re2 
													+ b.sum_mc  +basic_mc  
													+ b.sum_mc2 +basic_mc2
							WHERE a.member_id = b.member_id";
					$this->db->query($sql);
	}	


	

}