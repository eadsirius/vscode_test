<?
class M_coin extends CI_Model {

	
/* =================================================================
* 지갑 정보
================================================================= */

	function get_wallet_chk($id,$type) {
		$this->db->select('*');
		$this->db->from('m_wallet');
		$this->db->where('member_id',$id);
		$this->db->where('type',$type);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	function get_wallet_type($id,$type) {
		$this->db->select('*');
		$this->db->from('m_wallet');
		$this->db->where('member_id',$id);
		$this->db->where('type',$type);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	function get_wallet_address($id,$type) 
	{
		$this->db->select('wallet');
		$this->db->from('m_wallet');
		$this->db->where('member_id',$id);
		$this->db->where('type',$type);
		$query = $this->db->get();
		$item = $query->row();
		if($item)return $item->wallet;
	}

	function get_wallet($id) {
		$this->db->select('*');
		$this->db->from('m_wallet');
		$this->db->where('member_id',$id);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	//주소기준으로 아이디 찾기
	function get_wallet_addr($address) {
		$this->db->select('*');
		$this->db->from('m_wallet');
		$this->db->where('wallet',$address);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	// 아이디와 지갑주소로 찾기
	function get_wallet_useraddr($id,$address) {
		$this->db->select('*');
		$this->db->from('m_wallet');
		$this->db->where('member_id',$id);
		$this->db->where('wallet',$address);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	function get_wallet_mb($id,$type=NULL) {
		$this->db->select('*');
		$this->db->from('m_wallet');
		$this->db->where('member_id',$id);
		if($type){
			$this->db->where('type',$type);			
		}
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_wallet_li($type=NULL) {
		$this->db->select('*');
		$this->db->from('m_wallet');
		if($type){
			$this->db->where('type',$type);			
		}
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
		
	function set_wallet_in($member_id,$addr,$qrcode,$type) 
	{			
		$query = array(
			'member_id' 	=> $member_id,
			'wallet' 		=> $addr,
			'qrcode' 		=> $qrcode,
			'type' 			=> $type,
		);
		$this->db->set('regdate', 'now()', FALSE);
		$this->db->insert('m_wallet', $query);
	}
/* =================================================================
* 코인 정보
================================================================= */
  function getBalanceList($idx,$user_id) {
		$this->db->select('a.*,
    (select ifnull(sum(point),0) from m_point where member_id = "'.$user_id.'") as total_sales,
    (select ifnull(sum(point),0) from m_point_su where member_id = "'.$user_id.'") as total_point,
    (select ifnull(sum(saved_point),0) from m_point_out where member_id = "'.$user_id.'" and state = 1) as withdraw_point,
    (select ifnull(sum(saved_point),0) from m_point_out where member_id = "'.$user_id.'" and state = 2) as Withdrawn_point,
    (select ifnull(sum(point),0) from m_point_su where member_id = "'.$user_id.'" and kind = "day") as day_point,
    (select ifnull(sum(point),0) from m_point_su where member_id = "'.$user_id.'" and kind = "mc") as mc_point,
    (select ifnull(sum(point),0) from m_point_su where member_id = "'.$user_id.'" and kind = "re") as re_point,
    (SELECT ifnull(SUM(c.point),0) FROM m_point_su c JOIN m_point b ON (b.member_id = "'.$user_id.'" AND b.check_su = "N") WHERE c.m_order_code = b.order_code) AS active_total_point,
    (SELECT ifnull(SUM(c.point),0) FROM m_point_su c JOIN m_point b ON (b.member_id = "'.$user_id.'" AND b.check_su = "N") WHERE c.m_order_code = b.order_code AND c.kind = "day") AS active_daily_point,
    (SELECT ifnull(SUM(c.point),0) FROM m_point_su c JOIN m_point b ON (b.member_id = "'.$user_id.'" AND b.check_su = "N") WHERE c.m_order_code = b.order_code AND c.kind = "mc") AS active_mc_point,
    (SELECT ifnull(SUM(c.point),0) FROM m_point_su c JOIN m_point b ON (b.member_id = "'.$user_id.'" AND b.check_su = "N") WHERE c.m_order_code = b.order_code AND c.kind = "re") AS active_re_point,
    (SELECT ifnull(SUM(POINT),0) FROM m_point_su WHERE member_id = "'.$user_id.'" AND kind = "out") AS total_out_point,
    (SELECT POINT FROM m_point WHERE member_id = "'.$user_id.'" AND check_su="N") AS active_point	
    ');
		$this->db->from('m_member a');
		$this->db->where('member_no',$idx);	
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
  
	function get_balance($idx) {
		$this->db->select('*');
		$this->db->from('m_balance');		
		$this->db->where('member_no',$idx);	
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	function get_balance_id($id) {
		$this->db->select('*');
		$this->db->from('m_balance');		
		$this->db->where('member_id',$id);	
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	function get_balance_id2($id) {
		$this->db->select('*');
		$this->db->from('m_balance_copy');		
		$this->db->where('member_id',$id);	
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	
	function get_balance_type_li($type) {
		$this->db->select('*');
		$this->db->from('m_balance');
		
		$this->db->where('coin_type',$type);	
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_balance_list() {
		$this->db->select('*');
		$this->db->from('m_balance');
		$this->db->order_by('balance_no','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_balance_li($idx) {
		$this->db->select('*');
		$this->db->from('m_balance');
		$this->db->where('member_no',$idx);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function set_balance_in($member_no,$member_id) 
	{			
		$query = array(
			'member_no' 	=> $member_no,
			'member_id' 	=> $member_id,
		);
		$this->db->insert('m_balance', $query);
	}
	
	function set_balance_up($member_no,$type,$count) 
	{
		$query = array(
			'volume' 		=> $count,
		);
		$this->db->where('member_no', $member_no);
		$this->db->where('coin_type', $type);
		$this->db->update('m_balance', $query);
	}
	
	
	public function update_tokenInfo($mem_id, $tokenInfo){
		foreach($tokenInfo as $key => $value){
			$data = array(
				'volume' => $value
			);
			$this->db->where('member_no', $mem_id );
			$this->db->where('coin_type', $key );
			$this->db->update('m_balance', $data);
		}
	}
	
/* =================================================================
* 코인 정보
================================================================= */
	// 코인에서 회원정보 가져오기
	function get_coin($member_id) {
		$this->db->select('*');
		$this->db->from('m_coin');
		$this->db->where('member_id',$member_id);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	
	function get_coin_li() {
		$this->db->select('*');
		$this->db->from('m_coin');
		//$this->db->where('member_id','master');
		$this->db->order_by('coin_no','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
    
	// 회원 주체에 따른 구분하기
	function get_coin_mb_li($id) {
		$this->db->select('*');
		$this->db->from('m_coin');
		
		if($id == 'member_id'){
			$this->db->where('member_id',$id);			
		}
		else if($id == 'event_id'){
        	$this->db->or_where('event_id',$id); 			
		}
		
		$this->db->order_by('coin_no','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_coin_mb($id) {
		$this->db->select('*');
		$this->db->from('m_coin');
		$this->db->where('member_id',$id);	
		$this->db->or_where('event_id',$id);
		$this->db->order_by('coin_no','desc');
		$this->db->limit(50);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_coin_mb_rev($id) {
		$this->db->select('*');
		$this->db->from('m_coin');
		
		$this->db->where('member_id',$id);
		
		$this->db->order_by('coin_no','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_coin_mb_send($id) {
		$this->db->select('*');
		$this->db->from('m_coin');
		
		$this->db->where('event_id',$id);
		
		$this->db->order_by('coin_no','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
/* =================================================================
* 코인 관련 합계
================================================================= */

	// 잔여 코인가져오기 - 총 보낸 코인 기준
	function get_coin_last($id) {
		$this->db->select('member_id,event_id,saved_point');
        $this->db->from('m_coin');
		$this->db->where('member_id',$id);
        $this->db->or_where('event_id',$id);        
		$query = $this->db->get();
		$list = $query->result();

		$coin = 0;
		foreach ($list as $row) {
			
			if ($row->event_id == $id) { // 코인받음
				$coin = $coin - $row->saved_point;
			}
			else if ($row->member_id == $id) { // 코인보냄
				$coin = $coin + $row->saved_point;
			}
		}		
		
		$coin = round($coin,4);
		return $coin;
	}

	
	// 받은코인 수량
	function get_coin_receive($member_id,$kind= NULL) {
        $this->db->select('point');
        $this->db->from('m_coin');
        $this->db->where('member_id',$member_id);
        
		if ($kind != '') {
			$this->db->where('cate',$kind);
		}
        
		$query = $this->db->get();		
		$list = $query->result();

		$point = 0;
		foreach ($list as $row) {
			$point = $point + $row->point;
		}

		return $point;
    }
    
	// 보낸코인 수량
	function get_coin_send($member_id,$kind= NULL) {
        $this->db->select('point');
        $this->db->from('m_coin');
        $this->db->where('event_id',$member_id);
        
		if ($kind != '') {
			$this->db->where('cate',$kind);
		}
        
		$query = $this->db->get();		
		$list = $query->result();

		$point = 0;
		foreach ($list as $row) {
			$point = $point + $row->point;
		}

		return $point;
    }
    
/* =================================================================
* 코인 전송정보
================================================================= */

	// 코인전송내역 디비기록
	function coin_in($order_code, $member_id,$member_address, $event_id,$event_address, $unit, $fee, $point, $cate, $kind, $type, $msg=NULL) 
	{		
		$regdate = nowdate();
		
		// 메세지 없다면
		if ($msg == NULL) {
			$msg = '';
		}
		
		$query = array(
			'order_code' 		=> $order_code,
			'member_id' 		=> $member_id,
			'member_address' 	=> $member_address,
			'event_id' 			=> $event_id,
			'event_address' 	=> $event_address,
			
			'cate' 				=> $cate,
			'type' 				=> $type,
			'kind' 				=> $kind,
			
			'point' 			=> $unit,
			'fee' 				=> $fee,
			'saved_point' 		=> $point,
			
			'msg' 				=> $msg,
		);

		$this->db->set('regdate', 'now()', FALSE);
		$this->db->insert('m_coin', $query);

	}
	
/* =================================================================
* 코인 etc
================================================================= */

	function get_coin_date($date) {
		$this->db->select('sum(point) as point');
        $this->db->from('m_coin');

        if ($date == 'yesterday') {
        	$this->db->where('regdate','date_sub(curdate(), interval 1 day)',FALSE); // date_add->날짜 더하기, date_sub->날짜빼기
		}
		else if ($date == 'today') {
        	$this->db->where('regdate >=','curdate()',FALSE);
		}
		
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
    }
    
	function get_coin_total() {
		$this->db->select('point');
		$this->db->from('m_coin');        
		$query = $this->db->get();
		$list = $query->result();

		$item = 0;
		foreach ($list as $row) {
			$item = $item + $row->point;
		}
		$item = round($item,8); 
		
		return $item;
	}

/* =================================================================
* 코인 jhhong
================================================================= */
	function get_balance_coin($idx, $member_id) {
		$this->db->select('*');
		$this->db->from('m_balance');		
		$this->db->where('member_no',$idx);	
		$query = $this->db->get();
		$item = $query->row();


        $query = $this->db->query(
        "SELECT SUM(ROUND(A.point / B.btc_usd, 8)) AS point FROM m_point_su A LEFT JOIN m_deadline AS B on A.order_code = B.order_code WHERE A.member_id = '".$member_id."' GROUP BY A.member_id");
		$data = $query->result();
        if ($data != null) {
            $item->total_point = $data[0]->point;
        } else {
            $item->total_point = 0.0000;
        }

        $query = $this->db->query(
        "SELECT SUM(ROUND(A.point / B.btc_usd, 8)) AS point FROM m_point_su A LEFT JOIN m_deadline AS B on A.order_code = B.order_code WHERE A.member_id = '".$member_id."' AND A.kind = 'day' GROUP BY A.member_id");
		$data = $query->result();
        if ($data != null) {
            $item->su_day = $data[0]->point;
        } else {
            $item->su_day = 0.0000;
        }

        $query = $this->db->query(
        "SELECT SUM(ROUND(A.point / B.btc_usd, 8)) AS point FROM m_point_su A LEFT JOIN m_deadline AS B on A.order_code = B.order_code WHERE A.member_id = '".$member_id."' AND A.kind = 'roll' GROUP BY A.member_id");
		$data = $query->result();
        if ($data != null) {
            $item->su_sp_roll = $data[0]->point;
        } else {
            $item->su_sp_roll = 0.0000;
        }

        $query = $this->db->query(
        "SELECT SUM(ROUND(A.point / B.btc_usd, 8)) AS point FROM m_point_su A LEFT JOIN m_deadline AS B on A.order_code = B.order_code WHERE A.member_id = '".$member_id."' AND A.kind = 're' GROUP BY A.member_id");
		$data = $query->result();
        if ($data != null) {
            $item->su_re = $data[0]->point;
        } else {
            $item->su_re = 0.0000;
        }

        $query = $this->db->query(
        "SELECT SUM(ROUND(A.point / B.btc_usd, 8)) AS point FROM m_point_su A LEFT JOIN m_deadline AS B on A.order_code = B.order_code WHERE A.member_id = '".$member_id."' AND A.kind = 'sp' GROUP BY A.member_id");
		$data = $query->result();
        if ($data != null) {
            $item->su_sp = $data[0]->point;
        } else {
            $item->su_sp = 0.0000;
        }

        $query = $this->db->query(
        "SELECT SUM(ROUND(A.point / B.btc_usd, 8)) AS point FROM m_point_su A LEFT JOIN m_deadline AS B on A.order_code = B.order_code WHERE A.member_id = '".$member_id."' AND A.kind = 'mc' GROUP BY A.member_id");
		$data = $query->result();
        if ($data != null) {
            $item->su_mc = $data[0]->point;
        } else {
            $item->su_mc = 0.0000;
        }

        $query = $this->db->query(
        "SELECT SUM(ROUND(A.point / B.btc_usd, 8)) AS point FROM m_point_su A LEFT JOIN m_deadline AS B on A.order_code = B.order_code WHERE A.member_id = '".$member_id."' AND A.kind = 'level' GROUP BY A.member_id");
		$data = $query->result();
        if ($data != null) {
            $item->su_level = $data[0]->point;
        } else {
            $item->su_level = 0.0000;
        }
		
        $query = $this->db->query(
        "SELECT SUM(ROUND(bitcoin_count, 4)) AS point_out, SUM(ROUND(fee_bitcoin_count, 4)) AS point_fee FROM m_point_out WHERE member_id = '".$member_id."' GROUP BY member_id");
		$data = $query->result();
        if ($data != null) {
            $item->point_out = $data[0]->point_out;
            $item->point_fee = $data[0]->point_fee;
        } else {
            $item->point_out = 0;
            $item->point_fee = 0;
        }
		
		return $item;
	}


    function get_bitcoinTotal($member_id) {
		$this->db->select('SUM(app_count) AS bitcoin_count');
		$this->db->from('m_bitcoin');		
		$this->db->where('member_id',$member_id);	
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}


	function bitcoin_inout($member_id, $in_out, $cate, $app_count, $fee, $all_count, $app_address, $event_id, $event_address, $flgs) {
		$query = array(
			'member_id' 	=> $member_id,
			'in_out' 		=> $in_out,
			'cate' 	=> $cate,

			'app_count' 		=> $app_count,
			'fee' 			=> $fee,
			'all_count' 			=> $all_count,

			'app_address' 			=> $app_address,
			'event_id' 			=> $event_id,
			'event_address' 			=> $event_address,

			'flgs' 			=> $flgs
		);

		$this->db->insert('m_bitcoin', $query);

	}

    function get_bitcoin_last_address($member_id) {
        $query = $this->db->query("SELECT app_address FROM m_bitcoin WHERE member_id = '".$member_id."' AND app_address <> '' ORDER BY coin_no DESC LIMIT 1");
        $item = $query->result();

		if ($item != null) {
			return $item[0]->app_address;
		} else {
			return '';
		}
	}


    function bitcoin_old_action() {
        $query = $this->db->query("SELECT point_no, point, saved_point, bank_fee FROM m_point_out");
        $item = $query->result();

        foreach($item as $row) {
            //$row->point_no
            //$row->point
            //$row->saved_point
            //$row->bank_fee

            $btc_usd = 8000.00;
            $bitcoin_count 			= number_format($row->point / $btc_usd, 4);
            $saved_bitcoin_count 			= number_format($row->saved_point / $btc_usd, 4);
            $fee_bitcoin_count 			= number_format($row->bank_fee / $btc_usd, 4);

            //$this->db->query("UPDATE m_point_out SET bitcoin_count = ". $bitcoin_count .", saved_bitcoin_count = ". $saved_bitcoin_count .", fee_bitcoin_count = ". $fee_bitcoin_count ." WHERE point_no = " . $row->point_no);
        }
		}
	
		
	/* =================================================================
	* 2020.07.22 박종훈 추가 원장 조회, balance 업데이트
	================================================================= */
	public function getFirstPurchase($id)
	{
		$this->db->select("* , 
		case
			when saved_point = '120000' then '1000'
			when saved_point = '360000' then '3000'
			when saved_point = '600000' then '5000'
			when saved_point = '1200000' then '10000'
		END dollar_amt
		");
		$this->db->from('m_point');		
		$this->db->where('member_id',$id);
		$this->db->where('cate','purchase');
		$this->db->order_by('regdate');
		$this->db->limit(1);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	public function getSvpCnt($id)
	{
		$this->db->select('COUNT(*) as cnt,SUM(POINT) point');
		$this->db->from('m_point');		
		$this->db->where('member_id',$id);
		$this->db->where('cate','purchase');
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	public function getReSvpList($id)
	{
		$this->db->select('*');
		$this->db->from('m_point');		
		$this->db->where('member_id',$id);
		$this->db->where('cate','repurchase');
		$this->db->order_by('regdate', 'desc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	public function getReSvpCnt($id)
	{
		$this->db->select('COUNT(*) as cnt,SUM(POINT) point');
		$this->db->from('m_point');		
		$this->db->where('member_id',$id);
		$this->db->where('cate','repurchase');
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	// jjh 추가 0727
	public function getWithdrawCnt($id)
	{
		$this->db->select('SUM(saved_point) sp_sum,SUM(point) point_sum, SUM(bank_fee) fee_sum');
		$this->db->from('m_point_out');		
		$this->db->where('member_id',$id);
		$this->db->where('cate','out');
		$this->db->order_by('point_no','DESC');

		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}

	// 내부 지갑 확인 0810
	function get_wallet_du($wallet_usns,$type) 
	{
		$this->db->select('COUNT(wallet) as cnt');
		$this->db->from('m_wallet');
		$this->db->where('wallet',$wallet_usns);
		$this->db->where('type',$type);

		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}

	
	
	/* =================================================================
	* 2020.08.11 박종훈 추가
	================================================================= */
	public function getStaking($id)
	{
		$this->db->select("x.member_id, SUM( IFNULL(x.purchase_hap,0)) purchase_hap,SUM( IFNULL(x.repurchase_hap,0)) repurchase_hap");
		$this->db->from("(SELECT member_id,
											CASE
													when cate ='purchase' then  ifnull(SUM(saved_point)  ,0)
													END purchase_hap,
											CASE
													when cate ='repurchase' then  ifnull(SUM(saved_point)  ,0)
													END repurchase_hap
											FROM m_point
											WHERE  appdate <> '2020-07-28 23:59:59' AND appdate > NOW()
											GROUP BY member_id,cate ) x");
		$this->db->where('x.member_id', $id);
		$this->db->group_by('x.member_id');
		
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	public function get_total_su()
	{
		$this->db->select("(SELECT ifnull(SUM(saved_point),0) FROM m_point )AS total,
		ifnull(SUM(case when kind = 'day'then POINT ELSE 0 end),0) AS day,
		ifnull(SUM(case when kind = 're' then POINT ELSE 0 end),0) AS re,
		ifnull(SUM(case when kind = 'mc' then POINT ELSE 0 end),0) AS mc");
		$this->db->from("m_point_su");
		$this->db->where('cate', 'su');
		
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	public function get_total_ssu($sdate, $edate)
	{
		if($sdate||$edate){
			$where_1st = "left(date_add(regdate, INTERVAL 9 HOUR),10) BETWEEN '$sdate' AND '$edate'";
		} else {
			$where_1st = "left(date_add(regdate, INTERVAL 9 HOUR),10) BETWEEN '2020-11-24' AND now()";
		}
		$this->db->select("(SELECT ifnull(SUM(saved_point),0) FROM m_point 
		WHERE  $where_1st) AS s_total,
		ifnull(SUM(case when kind = 'day'then POINT ELSE 0 end),0) AS s_day,
		ifnull(SUM(case when kind = 're' then POINT ELSE 0 end),0) AS s_re,
		ifnull(SUM(case when kind = 'mc' then POINT ELSE 0 end),0) AS s_mc");
		$this->db->from("m_point_su");
		$this->db->where('cate', 'su');
		$this->db->where($where_1st);

		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}

	public function get_total_out()
	{
		$this->db->select("ifnull(SUM(case when state = '1' then POINT+bank_fee ELSE 0 end),0) AS req,
											 ifnull(SUM(case when state = '2' then POINT+bank_fee ELSE 0 end),0) AS com");
		$this->db->from("m_point_out");
		
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	public function getTotalSu($id)
	{
		$this->db->select("x.member_id, 
											SUM( IFNULL(x.sum_day,0)) sum_day, 
											SUM( IFNULL(x.sum_re,0)) sum_re, 
											SUM( IFNULL(x.sum_mc,0)) sum_mc ");
		$this->db->from("(SELECT member_id,
											ifnull ( case
												when kind ='day' then sum(ifnull(point,0))
											END ,0 ) AS sum_day,																																	
											ifnull ( case                                                                            
												when kind ='re' then sum(ifnull(point,0))
											END ,0 )  AS sum_re,																																	
											ifnull ( case                                                                            
												when kind ='mc' then sum(ifnull(point,0))
											END ,0 )  AS sum_mc
											FROM m_point_su
											WHERE cate ='su'
											GROUP BY member_id, kind) x");
		$this->db->join('m_balance b', 'x.member_id = b.member_id');
		$this->db->where('x.member_id' , $id);
		$this->db->group_by('x.member_id');
		
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}

	public function getTotalRepurchase($id)
	{
		$this->db->select("member_id, ifnull(SUM(saved_point)  ,0) hap");
		$this->db->from("m_point");
		$this->db->where("cate","repurchase");
		$this->db->where("member_id",$id);
		$this->db->group_by('member_id');

		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}

	public function getTotalOut($id)
	{
		$sql = "(tx_id IS NOT NULL AND kind='company' AND member_id ='".$id."' ) or ( kind <> 'company' AND member_id<>'admin' AND member_id = '".$id."' ) and state = 2";
		$this->db->select("member_id,ifnull(SUM(saved_point),0) withdraw_point,, ifnull(SUM(saved_point-bank_fee),0)  point_out,ifnull(SUM(bank_fee),0) point_fee");
		$this->db->from("m_point_out");
		$this->db->where($sql);
		$this->db->group_by('member_id');

		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}


	public function setStaking($id)
	{
		$sql	=	"
		UPDATE m_balance a
		INNER JOIN (SELECT s.member_id, ifnull(y.purchase_hap,0) purchase_hap, ifnull(y.repurchase_hap,0) repurchase_hap
		FROM m_member s 
		LEFT OUTER JOIN  (
		SELECT  x.member_id, SUM( IFNULL(x.purchase_hap,0)) purchase_hap,
		SUM( IFNULL(x.repurchase_hap,0)) repurchase_hap
		FROM (
		SELECT  member_id,
		CASE
		when cate ='purchase' then  ifnull(SUM(saved_point)  ,0)
		END purchase_hap,
		CASE
		when cate ='repurchase' then  ifnull(SUM(saved_point)  ,0)
		END repurchase_hap
		FROM m_point
		WHERE  appdate <> '2020-07-28 23:59:59' AND appdate > NOW()
		AND member_id = '".$id."'
		GROUP BY member_id,cate
		) x
		GROUP BY x.member_id
		) y
		ON  (s.member_id =y.member_id)
		WHERE s.member_id =  '".$id."'
		) b
		SET  volume = purchase_hap+repurchase_hap
		,volume1 = purchase_hap
		,volume2 =  repurchase_hap
		WHERE a.member_id = b.member_id
		";
		$this->db->query($sql);
	}

	public function setTotalRepurchase($id)
	{
		$sql	=	"
		UPDATE m_balance a
		INNER JOIN ( SELECT s.member_id, ifnull(y.hap,0) hap
								FROM m_member s 
								LEFT OUTER JOIN(
								SELECT member_id, ifnull(SUM(saved_point)  ,0) hap
								FROM m_point
								WHERE cate ='repurchase'
								AND member_id = '".$id."'
								GROUP BY member_id 
								) y
								ON  (s.member_id =y.member_id)
								WHERE s.member_id='".$id."'	) b
		SET loan = b.hap
		WHERE a.member_id = b.member_id
		";
		$this->db->query($sql);
	}

	public function setTotalSu($id)
	{
		$sql="
		UPDATE m_balance a                                                             
		INNER JOIN (
		SELECT s.member_id, ifnull(sum_day , 0)sum_day ,ifnull(sum_re , 0) sum_re,ifnull(sum_re2 ,0) sum_re2, ifnull(sum_mc , 0)sum_mc, ifnull(sum_mc2,0)sum_mc2
		FROM m_member s
		LEFT OUTER JOIN(
		SELECT x.member_id, SUM( IFNULL(x.sum_day,0)) sum_day,
		SUM( IFNULL(x.sum_re,0)) sum_re,
		SUM( IFNULL(x.sum_re2,0)) sum_re2,
		SUM( IFNULL(x.sum_mc,0)) sum_mc,
		SUM( IFNULL(x.sum_mc2,0)) sum_mc2
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
		AND member_id = '".$id."'
		GROUP BY member_id, kind
		) x
		GROUP BY x.member_id
		) y
		ON  (s.member_id =y.member_id)
		WHERE s.member_id='".$id."'                                     
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
		WHERE a.member_id = b.member_id
		";
		$this->db->query($sql);
	}

	public function setTotalOut($id)
	{
		$sql = "
		UPDATE m_balance a
		INNER JOIN (
								SELECT s.member_id, ifnull(y.point_out,0) point_out , ifnull(y.point_fee,0) point_fee
								FROM m_member s 
								LEFT OUTER JOIN(
								SELECT member_id, ifnull(SUM(saved_point-bank_fee)  ,0)  point_out,
								ifnull(SUM(bank_fee)  ,0) point_fee
								FROM m_point_out
								WHERE (tx_id IS NOT NULL AND kind='company' AND member_id = '".$id."')
								OR ( kind <> 'company' AND member_id<>'admin' AND member_id = '".$id."')
								GROUP BY member_id
								) y
								ON  (s.member_id =y.member_id)
								WHERE s.member_id='".$id."'
							 ) b
		SET a.point_out = b.point_out
				,a.point_fee = b.point_fee
		WHERE a.member_id = b.member_id
		";
		$this->db->query($sql);
	}


	// 2020.08.18 박종훈 투자금, 디파짓포인트 구하기
	public function getDollarDeposit($id)
	{
		$this->db->select("
			IFNULL(SUM(
				case
					when saved_point = '36000' then '300'
					when saved_point = '120000' then '1000'
					when saved_point = '360000' then '3000'
					when saved_point = '600000' then '5000'
					when saved_point = '1200000' then '10000'
				END
			),0) dollar_amt ,
			IFNULL(SUM( saved_point ) ,0) deposit_point
		");
		$this->db->from("m_point a");
		$this->db->join("m_member b", "a.member_id = b.member_id" , "RIGHT OUTER");
		$this->db->where("b.member_id",$id);
		$this->db->group_by("a.member_id");

		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}

	public function getTotalRecommendDollar($id)
	{
		$conditional	=	"member_id IN (SELECT member_id FROM m_member WHERE recommend_id = '".$id."')";
		$this->db->select("IFNULL(SUM(
			case
				when saved_point = '36000' then '300'
				when saved_point = '120000' then '1000'
				when saved_point = '360000' then '3000'
				when saved_point = '600000' then '5000'
				when saved_point = '1200000' then '10000'
			END
		),0) total_dollar_amt");
		$this->db->from("m_point");
		$this->db->where($conditional);

		
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
}