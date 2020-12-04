<?php
class M_deadline extends CI_Model {

	
/* ======================================================*/
/*                   마감관련                               */
/* ======================================================*/	

	// 해당날짜의 마감 찾기
	function get_deadline_today($regdate) 
	{
		$this->db->select('*');
		$this->db->from('m_deadline');
		$this->db->where('regdate =',$regdate);
		$query = $this->db->get();
		$item = $query->row();
	 
		return $item;
	
	}
	
	// 마감 리스트 가져오기
	function get_dead_li() {	
		$this->db->select('*');
		$this->db->from('m_deadline');
		$this->db->order_by("dead_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	// order_code로 마감검색
	function get_deadline($order_code) 
	{		
		$this->db->select('*');
		$this->db->from('m_deadline');
		$this->db->where("order_code", $order_code);
		$query = $this->db->get();
		$item = $query->row();
	 
		return $item;

	}
	
/* ======================================================*/
/* 기록 및 업데이터 - 마감.                                   */
/* ======================================================*/
	
	// 마감 기록
	function deadline_in($order_code,$start_date,$end_date,$regdate) 
	{		
		$CI =& get_instance();
		$query = array(
			'order_code' => $order_code,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'regdate' => $regdate,
		);
		$this->db->insert('m_deadline', $query);
		
		//$dead_no = mysql_insert_id();	
		$dead_no = $CI->db->insert_id();
		return $dead_no;
	}	
	
	// 마감 업데이트
	function deadline_update($dead_no, $in_total, $out_total, $day_total, $re_total, $re2_total, $mc_total, $mc2_total, $leader_total) 
	{		
		$query = array(
			'in_point' 		=> $in_total,
			'out_point' 	=> $out_total,
			'day_point' 	=> $day_total,
			're_point' 		=> $re_total,
			're2_point' 	=> $re2_total,
			'mc_point' 		=> $mc_total,
			'mc2_point' 	=> $mc2_total,
			'leader_point' 	=> $leader_total,
		);
		
		$this->db->where('dead_no',$dead_no);
		$this->db->update('m_deadline', $query);
	}
	
	// 수당지급
	function point_exc($table, $order_code, $point_order_code, $office, $member_id, $event_id, $point, $saved_point, $cate, $kind, $msg=NULL, $regdate=NULL) {
		
		if($table == 'm_point_total' and $kind == 'day'){
			$type 	= "request";				
		}
		else{
			$type 	= "complete";			
		}
		
		// 메세지 없다면
		if ($msg == NULL) {
			$msg = '';
		}
		
		if ($regdate == NULL) {
			$regdate = nowdate();
		}
		
		$query = array(
			'order_code' 	=> $order_code,
			'm_order_code' 	=> $point_order_code,
			'office' 		=> $office,
			'member_id' 	=> $member_id,
			'event_id' 		=> $event_id,
			
			'cate' 			=> $cate,
			'kind' 			=> $kind,
			'type' 			=> $type,
			
			'point' 		=> $point,
			'saved_point' 	=> $saved_point,
			'msg' 			=> $msg,
			'regdate' 		=> $regdate,
		);

		$this->db->insert($table, $query);

	}

	//----------------------------------------------------------
	// 2020.07.30 박종훈 데일리 수당 지급만 변경, 매출, 재매출 구분
	function point_exc_day($table, $order_code, $point_order_code, $office, $member_id, $event_id, $point, $saved_point, $cate, $cate1, $kind, $msg=NULL, $regdate=NULL) {
	
		if($table == 'm_point_total' and $kind == 'day'){
			$type 	= "request";				
		}
		else{
			$type 	= "complete";			
		}
		
		// 메세지 없다면
		if ($msg == NULL) {
			$msg = '';
		}
		
		if ($regdate == NULL) {
			$regdate = nowdate();
		}
		
		$query = array(
			'order_code' 	=> $order_code,
			'm_order_code' 	=> $point_order_code,
			'office' 		=> $office,
			'member_id' 	=> $member_id,
			'event_id' 		=> $event_id,
			
			'cate' 			=> $cate,
			'cate1' 		=> $cate1,
			'kind' 			=> $kind,
			'type' 			=> $type,
			
			'point' 		=> $point,
			'saved_point' 	=> $saved_point,
			'msg' 			=> $msg,
			'regdate' 		=> $regdate,
		);

		$this->db->insert($table, $query);

	}
/* ======================================================*/
/* 기타정보                                                */
/* ======================================================*/

	// 매출합계
	function get_money_in_total($start,$end) {
		$this->db->select('sum(point) as point');
		$this->db->from('m_point');		
		$this->db->where('cate','purchase');
		$this->db->where('kind !=','no');
		$this->db->where('kind !=','apply');
		
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
		echo $end;
	}
	function get_money_in_apply($start,$end) {
		$this->db->select('sum(point) as point');
		$this->db->from('m_point');		
		$this->db->where('cate','purchase');
		$this->db->where('kind','apply');
		$this->db->where('kind !=','apply');
		
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
		//echo $end;
	}
	
	// 출금합계
	function get_money_out_total($start,$end) {
		$this->db->select('sum(point) as point');
		$this->db->from('m_point');		
		$this->db->where('cate','out');
			
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	function get_su_date($table,$write_date) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('regdate',$write_date);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_money_day_total($member_id,$start,$end) {
		$this->db->select('sum(point) as point');
		$this->db->from('m_point_total');
		
		$this->db->where('member_id',$member_id);
		
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	function get_money_li_date($start,$end) {
		$this->db->select('*');
		$this->db->from('m_point');
		$this->db->where('member_id !=','admin');
		$this->db->where('cate','purchase');
		$this->db->where('kind !=','no');
		$this->db->where('kind !=','apply');
		
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	// 인정도 포함
	function get_money_in_chk($member_id,$end) {
		$this->db->select('*');
		$this->db->from('m_point');
		$this->db->where('member_id',$member_id);
		$this->db->where('cate','purchase');
		//$this->db->where('kind !=','no');
		$this->db->where('kind !=','apply');
		
		$this->db->where('regdate <=',$end);
		$this->db->order_by("point_no", "desc");
		$query = $this->db->get();
		$item = $query->num_rows();
		
		
		return $item;
	}
	
	// 인정도 포함
	function get_money_in_checked($member_id) {
		$this->db->select('*');
		$this->db->from('m_point');
		$this->db->where('member_id',$member_id);
		//$this->db->where('cate','purchase');
		$this->db->where('kind !=','no');
		$this->db->where('kind !=','apply');
		$this->db->order_by("point_no", "desc");
		$query = $this->db->get();
		//$item = $query->row();
		$item = $query->result();
		//$item = $query->num_rows();
		
		
		return $item;
	}
	
	function get_purchase_bal($id,$end) {
		$this->db->select('sum(point) as point');
		$this->db->from('m_point');	
			
		$this->db->where('member_id',$id);
		$this->db->where('cate','purchase');
		$this->db->where('kind !=','apply');
		$this->db->where('regdate <=',$end);

		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	function get_point_kind($table,$kind=NULL) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		
		if($kind != NULL){
			$this->db->where('kind',$kind);			
		}
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_money_su_chk($member_id,$kind,$end) {
		$this->db->select('*');
		$this->db->from('m_point_su');
		$this->db->where('member_id',$member_id);
		$this->db->where('kind',$kind);
		
		//$this->db->where('regdate <=',$end);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
/* ======================================================*/
/* 기타정보                                                */
/* ======================================================*/
	
	function get_money_day_count($table,$member_id,$cate,$kind) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('member_id',$member_id);
		$this->db->where('cate',$cate);
		$this->db->where('kind',$kind);
		
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}

	function get_member_date($datetime) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('regdate <=',$datetime);
		$this->db->order_by('member_no','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_money_in_date($end) {
		$this->db->select('*');
		$this->db->from('m_point');
			
		$this->db->where('cate','purchase');
		$this->db->where('kind !=','no');
		$this->db->where('kind !=','apply');
		
		//$this->db->where('regdate <=',$end);//skm 2020.07.13
		$this->db->where('appdate >=',$end);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}

	function get_money_in_date2($end) {
		$this->db->select('*');
		$this->db->from('m_point');
			
		$this->db->where('cate','repurchase');
		$this->db->where('kind !=','no');
		$this->db->where('kind !=','apply');
		
		//$this->db->where('regdate <=',$end);//skm 2020.07.13
		$this->db->where('appdate >=',$end);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_money_app_date($end) {
		$this->db->select('*');
		$this->db->from('m_point');
			
		$this->db->where('cate','purchase');
		$this->db->where('kind !=','no');
		$this->db->where('kind !=','apply');
		
		$this->db->where('appdate',$end);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	
/* ======================================================*/
	
	// 회원의 매출 총 합계 - 누적 - 실매출만
	function get_member_in_total($member_id,$end) {
		$this->db->select('sum(saved_point) as saved_point');
		$this->db->from('m_point');	
		
		$this->db->where('member_id',$member_id);
		$this->db->where('cate','purchase');
		$this->db->where('kind !=','no');
		$this->db->where('kind !=','apply');
		
		$this->db->where('regdate <=',$end);
		$query = $this->db->get();
		$item = $query->row();
		return $item->saved_point;
	}
	
	// 회원의 매출 총 합계 - 누적 - 실매출만
	function get_member_spc_total($member_id,$end) {
		$this->db->select('sum(saved_point) as saved_point');
		$this->db->from('m_point');
		
		$this->db->where('member_id',$member_id);
		//$this->db->where('cate','purchase');
		$this->db->where('kind','no');
		$this->db->where('regdate <=',$end);
		$query = $this->db->get();
		$item = $query->row();
		return $item->saved_point;
	}

	// 모든 플랜 불러오기 - 매출 친 사람 리스트
	function get_plan_li_date($datetime) {	
		$this->db->select('*');
		$this->db->from('m_plan');
		$this->db->where('regdate <=',$datetime);
		$this->db->order_by("plan_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	
	// 모든 회원 불러오기
	function get_member_li_date($datetime) {	
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('regdate <=',$datetime);
		$this->db->order_by("member_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	
	// 볼륨 가져오기 - 이벤트를 중심으로 쭉 위로 가져온다.
	function get_vlm_up($table,$id) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('member_id !=','admin');
		$this->db->where('event_id',$id);
		$this->db->where('side !=','middle');
		$this->db->order_by("vlm_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_point_end($table,$datetime) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('regdate >=',$datetime);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
/* ======================================================*/
/* m_volume                                              */
/* ======================================================*/
	// 볼륨 가져오기 - 매출도 가져오기-------------------------------------
	function get_vlm1($id,$start,$regdate) {

		$CI =& get_instance();
		
		$this->db->select('*');
		$this->db->from('m_volume');		
		$this->db->where('member_id',$id);		
		$this->db->order_by("regdate", "asc");
		$query = $this->db->get();
		$item = $query->result();

		//-------------------------------------------------------------------//
		$vlm_left 			= 0;
		$vlm_left_point 	= 0;
		$vlm_right 			= 0;
		$vlm_right_point 	= 0;

		foreach ($item as $row) 
		{		
			if ($id != $row->event_id) 
			{				
				$sale = $CI->m_point->point_purchase_vlm($row->event_id,$start,$regdate);
				if(empty($sale)){$sale = 0;}	
				
				if ($row->side == 'left') {					
					$vlm_left = $vlm_left + 1;
					$vlm_left_point = $vlm_left_point + $sale;
				}

				if ($row->side == 'right') {
					$vlm_right = $vlm_right + 1;		
					$vlm_right_point = $vlm_right_point + $sale;
				}
				
				//echo "$id==$row->event_id======$regdate=========$sale//  $row->side = $vlm_right_point // $vlm_left_point =========$sale //<br>";	
			}				
		} //end for
		
		//-------------------------------------------------------------------//
		// 어디가 소실적인지
		if($vlm_left_point <= $vlm_right_point)
		{
			$vlm_so = 'left';
		}
		else
		{
			$vlm_so = 'right';
		}	
		
		$vlm['vlm_so'] 			= $vlm_so;		
		$vlm['vlm_left'] 		= $vlm_left;
		$vlm['vlm_left_point'] 	= $vlm_left_point;
		$vlm['vlm_right'] 		= $vlm_right;
		$vlm['vlm_right_point'] = $vlm_right_point;
		
		return $vlm;
	}
	// 볼륨 가져오기 - 매출도 가져오기-------------------------------------
	function get_vlm_date($id,$start,$end) {

		$CI =& get_instance();
		
		$this->db->select('*');
		$this->db->from('m_volume');		
		$this->db->where('member_id',$id);		
		$this->db->order_by("regdate", "asc");
		$query = $this->db->get();
		$item = $query->result();

		//-------------------------------------------------------------------//
		$vlm_left 			= 0;
		$vlm_left_point 	= 0;
		$vlm_right 			= 0;
		$vlm_right_point 	= 0;

		foreach ($item as $row) 
		{		
			if ($id != $row->event_id) 
			{
				$sale = $CI->m_point->point_purchase_vlm($row->event_id,$start,$end);
				if(empty($sale)){$sale = 0;}	
				
				if ($row->side == 'left') {
					$vlm_left = $vlm_left + 1;
					$vlm_left_point = $vlm_left_point + $sale;
				}

				if ($row->side == 'right') {
					$vlm_right = $vlm_right + 1;		
					$vlm_right_point = $vlm_right_point + $sale;
				}
				if($id == '71949984'){
				echo "// $id==$row->event_id======$row->side========$sale//  $row->side = $vlm_right_point // $vlm_left_point =========$sale //<br>";	


//71949984==71949981======500.0000// = 0 // 0 =========500.0000 //
//71949984==71949982=====300.0000// = 0 // 0 =========300.0000 //
//71949984==71949983=====100.0000// = 0 // 0 =========100.0000 //
//71949984==71949985=====1000.0000// = 0 // 0 =========1000.0000 //

//0 <= 0 /// left
				}
			}				
		} //end for
		
		//-------------------------------------------------------------------//
		// 어디가 소실적인지
		if($vlm_left_point <= $vlm_right_point)
		{
			$vlm_so = 'left';
		}
		else
		{
			$vlm_so = 'right';
		}
		
		if($id == '71949984'){
			echo "<br> // $vlm_left_point <= $vlm_right_point /// $vlm_so<br>";
		}
			
		$vlm['vlm_so'] 			= $vlm_so;		
		$vlm['vlm_left'] 		= $vlm_left;
		$vlm['vlm_left_point'] 	= $vlm_left_point;
		$vlm['vlm_right'] 		= $vlm_right;
		$vlm['vlm_right_point'] = $vlm_right_point;
		
		return $vlm;
	}
}
?>