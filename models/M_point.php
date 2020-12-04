<?php
class M_point extends CI_Model {

/* =================================================================
* 포인트 정보 가져오기
================================================================= */

	// 포인트 번호 가져오기
	function get_point_no($table,$idx) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		$this->db->where('point_no',$idx);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	function get_point_id($table,$id) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('member_id',$id);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	function get_point_high($table,$id,$point) {
		$this->db->select('point');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		$this->db->where('point >',$point);
		$this->db->where('kind','complate');
		
		$query = $this->db->get();
		$item = $query->row();
		
		if(empty($item)){$point = 0;}
		else{$point = $item->point;}
		return $point;
	}
	
	function get_kind_first($table,$id,$kind) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		$this->db->where('kind',$kind);
		
		$this->db->order_by("point_no", "asc");
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	function get_point_first($table,$id,$cate) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		$this->db->where('cate',$cate);
		
		$this->db->order_by("point_no", "asc");
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	function get_point_last($table,$id,$cate=NULL,$kind=NULL) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		
		$this->db->where('member_id',$id);
		if($cate != NULL){
			$this->db->where('cate',$cate);			
		}
		if($kind != NULL){
			$this->db->where('kind',$kind);			
		}
		
		$this->db->order_by("point_no", "desc");
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	
	function get_point_li($table,$cate=NULL,$kind=NULL) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		
		if($cate != NULL){
			$this->db->where('cate',$cate);			
		}
		if($kind != NULL){
			$this->db->where('kind',$kind);			
		}
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}function get_point_li2($table,$cate=NULL,$kind=NULL) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		
	

		//$this->db->order_by("point_no desc");
		$this->db->limit(0,12);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	
	function get_point_su_total($table,$id,$end,$kind=NULL) {
		$this->db->select('sum(point) as point');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		if($kind != NULL){
			$this->db->where('kind',$kind);			
		}
		$this->db->where('regdate',$end);
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	function get_point_su_date($table,$end) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('regdate',$end);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	

	// 포인트 가져오기 - 리스트
	function get_point($table,$id,$cate=NULL,$kind=NULL) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		
		$this->db->where('member_id',$id);
		if($cate != NULL){
			$this->db->where('cate',$cate);			
		}
		if($kind != NULL){
			$this->db->where('kind',$kind);			
		}
		
		$this->db->order_by("point_no", "desc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	// 포인트 가져오기 - 리스트
	function get_point_kind($table,$id,$kind=NULL) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		
		$this->db->where('member_id',$id);
		if($kind != NULL){
			$this->db->where('kind',$kind);			
		}
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	// 오더코드로 가져오기 - 매출 취소 시 요긴함
	function get_point_code($table,$order_code) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		$this->db->where('order_code',$order_code);
		
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_point_ordercode($table,$order_code) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		$this->db->where('order_code',$order_code);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	function point_kind_chk($table,$id,$kind) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('member_id',$id);
		$this->db->where('kind',$kind);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 매출횟수 구하기
	function point_in_chk($table,$id) {

		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		$this->db->where('member_id',$id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}

	// 매출횟수 구하기
	function point_txid_chk($table,$tx) {

		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		$this->db->where('office',$tx);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 메인넷 동기화여부 체크
	function point_mainnet_chk($table,$id) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		$this->db->where('member_id',$id);
		$this->db->where('msg','메인넷 동기화');
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	function point_main_net($table,$id) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		$this->db->where('member_id',$id);
		$this->db->where('msg','메인넷 동기화');
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}

	// 포인트 잔고 가져오기 - 수익과매출
	function get_point_balance($table,$id,$cate) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		
		$this->db->where('member_id',$id);
		$this->db->where('cate',$cate);
		
		$query = $this->db->get();
		$list = $query->result();

		$p_point = 0;
		$m_point = 0;
		$item = 0;
		foreach ($list as $row) {
			if ($row->kind == 'rev') {
				$p_point = $p_point + $row->point;
			}
			else if ($row->kind == 'out') {
				$m_point = $m_point + $row->point;
			}
			$item = $p_point - $m_point;
		}

		$item = round($item,3);
		return $item;
	}


	// 소비지갑에서 출금신청 한 지출을 뺀 차액구하기
	// payment, trade 등
	function get_saved_point($table,$id) {		
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		$this->db->where('member_id',$id);
		$this->db->where('kind','payment');
		$query = $this->db->get();
		$list = $query->result();

		$p_point = 0;
		$m_point = 0;
		$item = 0;
		foreach ($list as $row) {
			if ($row->type == 'su') {
				$p_point = $p_point +$row->point;
			}

			if ($row->type == 'out') {
				$m_point = $m_point + $row->point;
			}

			$item = $p_point - $m_point;
		}

		$item = round($item,3);
		return $item;
	}
	
	// 체크하기 하루 한번만 하는지
	function point_ex_chk($table,$id,$cate,$start,$end) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		
		$this->db->where('member_id',$id);
		$this->db->where('cate',$cate);
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);

		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	function point_ex_count($table,$id,$cate,$kind,$start,$end) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		
		$this->db->where('member_id',$id);
		$this->db->where('cate',$cate);
		$this->db->where('kind',$kind);
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	function point_puchase_cnt($id) {
		$this->db->select('*');
		$this->db->from('m_point');
		
		$this->db->where('member_id',$id);
		
		$this->db->where('cate','purchase');
		$this->db->where('kind !=','no');
		$this->db->where('kind !=','apply');
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	function point_puchase_count($id) {
		$this->db->select('*');
		$this->db->from('m_point');
		
		$this->db->where('member_id',$id);
		
		$this->db->where('cate','purchase');
		$this->db->where('kind !=','no');
		$this->db->where('kind !=','apply');
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	
	function point_day_count($id,$point,$kind) {
		$this->db->select('*');
		$this->db->from('m_point_su');
		
		$this->db->where('member_id',$id);
		$this->db->where('saved_point',$point);
		$this->db->where('kind',$kind);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	function point_su_count($id,$kind) {
		$this->db->select('*');
		$this->db->from('m_point_su');
		
		$this->db->where('member_id',$id);
		$this->db->where('kind',$kind);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	
	
	function point_puchase_full_count($id) {
		$this->db->select('*');
		$this->db->from('m_point');
		
		$this->db->where('member_id',$id);
		
		$this->db->where('cate','purchase');
		//$this->db->where('kind !=','no');
		$this->db->where('kind !=','apply');
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	function point_purchase_regdate($id) {
		$this->db->select('regdate');
		$this->db->from('m_point');
		
		$this->db->where('member_id',$id);		
		$this->db->where('cate','purchase');
		//$this->db->where('kind !=','no');	
		$this->db->where('kind !=','apply');	
		$query = $this->db->get();
		$item = $query->row();
		return $item->regdate;
	}
	
	
	function point_puchase_total_date($id,$end) {
		$this->db->select('sum(point) as point');
		$this->db->from('m_point');
		
		$this->db->where('member_id',$id);
		
		$this->db->where('cate','purchase');
		$this->db->where('kind !=','no');	
		$this->db->where('kind !=','apply');
		$this->db->where('regdate <=',$end);
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	function point_puchase_total($id) {
		$this->db->select('sum(point) as point');
		$this->db->from('m_point');
		
		$this->db->where('member_id',$id);
		
		$this->db->where('cate','purchase');
		$this->db->where('kind !=','no');
		$this->db->where('kind !=','apply');
		$query = $this->db->get();
		$item = $query->row();
		//echo "$id -- $item->point<br>";
		return $item->point;
	}
	
	function point_purchase_vlm($id,$start,$regdate) {
		$this->db->select('sum(point) as point');
		$this->db->from('m_point');
		
		$this->db->where('member_id',$id);		
		//$this->db->where('cate','purchase');
		$this->db->where('kind !=','no');
		$this->db->where('kind !=','apply');
		$this->db->where('regdate >',$start);
		$this->db->where('regdate <=',$regdate);
		
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	function point_purchase_date($id,$regdate) {
		$this->db->select('sum(point) as point');
		$this->db->from('m_point');
		
		$this->db->where('member_id',$id);		
		//$this->db->where('cate','purchase');
		$this->db->where('kind !=','no');
		$this->db->where('kind !=','apply');
		$this->db->where('regdate <=',$regdate);
		
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	function point_purchase_datetime($id,$start,$end) {
		$this->db->select('sum(point) as point');
		$this->db->from('m_point');
		
		$this->db->where('member_id',$id);		
		//$this->db->where('cate','purchase');
		$this->db->where('kind !=','no');
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
/* =================================================================
* flower
* cate = 구매자 레벨
* kind = 꽃 레벨
* type = sale, buy, complete
================================================================= */

	function get_flower_no($table,$idx) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('point_no',$idx);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	// 오늘 선택한 장미꽃 -> 판매 수량
	function get_flower_total($table,$kind,$type=NULL,$start=NULL,$end=NULL) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('kind',$kind); // 꽃 레벨
		
		if($type != NULL){
			$this->db->where('type',$type);
		}
		
		if($start != NULL){
			$this->db->where('appdate >=',$start);
		}
		if($end != NULL){
			$this->db->where('appdate <=',$end);
		}
				
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 나의 구매수량
	function get_flower_my_total($table,$id,$kind=NULL,$type=NULL,$start=NULL,$end=NULL) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		
		if($kind != NULL){
			$this->db->where('kind',$kind);
		}
		
		if($type != NULL){
			$this->db->where('type',$type);
		}
		
		if($start != NULL){
			$this->db->where('appdate >=',$start);
		}
		if($end != NULL){
			$this->db->where('appdate <=',$end);
		}
				
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 오늘 판매중인 장미꽃 찾기 -> 모두다 찾기
	function get_flower_sale_date($table,$kind,$start,$end) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('kind',$kind);
		$this->db->where('type','sale');
		$this->db->where('appdate >=',$start);
		$this->db->where('appdate <=',$end);
		
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	// 마지막 것 구하기 $cate = 구매자 레벨 / $kind = 장미레벨 / $type = 판매중, 판매완료 구분자
	function get_flower_last($table,$kind,$type) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->where('cate',$cate);
		$this->db->where('kind',$kind);
		$this->db->where('type',$type);
		$this->db->order_by("point_no", "desc");  // 맨 마지막
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	// 마지막 것 구하기 $cate = 구매자 레벨 / $kind = 장미레벨 / $type = 판매중, 판매완료 구분자
	function get_flower_last_date($table,$id,$kind,$type,$end) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('member_id !=',$id);
		$this->db->where('kind',$kind);
		$this->db->where('type',$type);
		$this->db->where('appdate <=',$end);	// 판매일
		$this->db->order_by("point_no", "asc"); // 맨 처음
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	// 가장 최근에 판매중인 장미꽃 찾기
	function get_flower_sale_desc($table,$kind) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('kind',$kind);
		$this->db->where('type','sale');
		$this->db->order_by("point_no", "asc");
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
/* =================================================================
* 유효 매출금
================================================================= */

	// pay sum
	function get_pay_total($table,$id=NULL,$cate=NULL,$kind=NULL) {
		
		$this->db->select('sum(point) as point');
		//$this->db->from('m_point');
		$this->db->from($table);
		
		if($id != NULL){
			$this->db->where('member_id',$id);
		}
		if($cate != NULL){
			$this->db->where('cate',$cate);	
		}
		if($kind != NULL){
			$this->db->where('kind',$kind);			
		}
		
		//if($table == 'm_point_elpp'){
		//	$this->db->where('type !=','hold');
		//}		

		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	// saved point
	function get_saved_total($table,$id=NULL,$cate=NULL,$kind=NULL) {
		
		$this->db->select('sum(saved_point) as saved_point');
		//$this->db->from('m_point');
		$this->db->from($table);
		
		if($id != NULL){
			$this->db->where('member_id',$id);
		}
		if($cate != NULL){
			$this->db->where('cate',$cate);	
		}
		if($kind != NULL){
			$this->db->where('kind',$kind);			
		}	

		$query = $this->db->get();
		$item = $query->row();
		return $item->saved_point;
	}
	
	// 유효 매출금
	function get_point_total($table,$id,$cate=NULL,$kind=NULL) {
		$this->db->select('sum(point) as point');
		$this->db->from($table);
		//$this->db->from('m_point');
		
		$this->db->where('member_id',$id);
			
		if($cate != NULL){
			$this->db->where('cate',$cate);			
		}
		if($kind != NULL){
			$this->db->where('kind',$kind);			
		}
		
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	// 유효 매출금
	function get_fee_total($table,$id,$cate=NULL,$kind=NULL) {
		$this->db->select('sum(bank_fee) as bank_fee');
		$this->db->from($table);
		//$this->db->from('m_point');
		
		$this->db->where('member_id',$id);
			
		if($cate != NULL){
			$this->db->where('cate',$cate);			
		}
		if($kind != NULL){
			$this->db->where('kind',$kind);			
		}
		
		$query = $this->db->get();
		$item = $query->row();
		return $item->bank_fee;
	}
	
	// 오더코드로 총 수당금액 구하기
	function get_money_code_total($table,$order_code) {
		$this->db->select('sum(point) as point');
		$this->db->from($table);
		
		$this->db->where('order_code',$order_code);		
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}

/* =================================================================
* 기간별
================================================================= */	function get_total_datetime($table,$start,$end) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		$this->db->order_by("point_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	// 수당이 있는지 체크하기
	function get_su_date($table,$member_id,$datetime) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('member_id',$member_id);
		$this->db->where('regdate',$datetime);
		
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	function get_point_date($table,$start,$end) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		$this->db->order_by("point_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}

	function get_point_datetime($table,$id,$start,$end) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('member_id',$id);
		
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		$this->db->order_by("point_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_point_today_sum($table,$id,$start,$end,$cate=NULL,$kind=NULL) {
		$this->db->select('sum(point) as point');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);	
			
		if($cate != NULL){
			$this->db->where('cate',$cate);			
		}
		if($kind != NULL){
			$this->db->where('kind',$kind);			
		}
		
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);

		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	function get_date_sum($table,$id,$kind,$end) {
		$this->db->select('sum(point) as point');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);	
		$this->db->where('kind',$kind);
		$this->db->where('regdate <=',$end);

		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	function get_total_date($table,$id,$end,$cate=NULL,$kind=NULL) {
		$this->db->select('sum(point) as point');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);	
			
		if($cate != NULL){
			$this->db->where('cate',$cate);			
		}
		if($kind != NULL){
			$this->db->where('kind',$kind);			
		}
		
		$this->db->where('regdate <=',$end);
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
/* =================================================================
* 매출 및 수당 등록
================================================================= */
	
	// 보내기 받기
	function pay_exc($table, $order_code, $country, $office, $member_id,$event_id, $point, $saved_point, $cate, $kind, $msg=NULL, $regdate=NULL) {
		
		if($cate == 'out'){
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
			'country' 		=> $country,
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

		if($cate == 'out'){
			$this->db->set('bank_fee', $office_group, FALSE);			
		}
	
		$this->db->insert($table, $query);

	}
	
  function pointDeleteInsert($table,$query) {
    
		$this->db->insert($table, $query);

	}
  
	
	// 보내기 받기
	function insert_pay_su($table,$order_code, $country, $office, $member_id, $event_id, $point, $fee, $saved_point, $cate, $kind, $msg=NULL, $regdate=NULL) {
		
		if($cate == 'out'){
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
			'country' 		=> $country,
			'office' 		=> $office,
			'member_id' 	=> $member_id,
			'event_id' 		=> $event_id,
			
			'cate' 			=> $cate,
			'kind' 			=> $kind,
			'type' 			=> $type,
			
			'point' 		=> $point,
			'bank_fee' 		=> $fee,
			'saved_point' 	=> $saved_point,
			
			'msg' 			=> $msg,
			'regdate' 		=> $regdate,
		);
		
		$this->db->insert($table, $query);

	}
	
	function pay_puchase($table, $order_code, $country, $office_group, $office, $member_id, $point, $saved_point, $cate, $kind, $type, $msg=NULL, $regdate=NULL, $app_date=NULL) 
	{		
		// 메세지 없다면
		if ($msg == NULL) {
			$msg = '';
		}		
		if ($regdate == NULL) {
			$regdate = nowdate();
		}		
		if ($app_date == NULL) {
			$app_date = '0000-00-00 00:00:00';
		}
		
		$query = array(
			'order_code' 	=> $order_code,
			'country' 		=> $country,
			'office' 		=> $office,
			'office_group' 		=> $office_group,
			
			'member_id' 	=> $member_id,
			'event_id' 		=> $member_id,
			
			'cate' 			=> $cate,
			'kind' 			=> $kind,
			'type' 			=> $type,
			
			'point' 		=> $point,
			'saved_point' 	=> $saved_point,
			
			'msg' 			=> $msg,
			'regdate' 		=> $regdate,
			'appdate' 		=> $app_date,
		);

		$this->db->insert($table, $query);

	}
	

											
	function buy_flower($table, $order_code, $country, $office, $member_id, $event_id, 
						$point, $saved_point, $sale_amount, $protg, $rose_sale, $rose_purchase, $count,
							$cate, $kind, $type, $msg=NULL,$regdate=NULL, $appdate=NULL, $memo) {
		
		// 메세지 없다면
		if ($msg == NULL) {
			$msg = '';
		}
		if ($appdate == NULL) {
			$appdate = nowdate();
		}		
		if ($regdate == NULL) {
			$regdate = nowdate();
		}
		
		$query = array(
			'order_code' 	=> $order_code,
			'country' 		=> $country,
			'office' 		=> $office,			
			'member_id' 	=> $member_id,
			'event_id' 		=> $event_id,
			
			'point' 		=> $point,			// 현재 시세가격
			'saved_point' 	=> $saved_point, 	// 구매 코인 수량
			'sale_point' 	=> $sale_amount,	// 3일 후 판매가
			'protg' 		=> $protg,			// 차액 즉 수익금액
			'fee' 			=> $rose_sale,		// 수익 %
			'purchase' 		=> $rose_purchase,	// 시작 판매가격
			'cnt' 			=> $count,			// 구매수량
			
			'cate' 			=> $cate,			// 구분 
			'kind' 			=> $kind,			// 장미꽃 레벨
			'type' 			=> $type,			// 구매 판매 완료 표시
			'msg' 			=> $msg,
			'regdate' 		=> $regdate,
			'appdate' 		=> $appdate,
			'memo' 			=> $memo,
		);

		$this->db->insert($table, $query);
        return $this->db->insert_id();
	}
	
	function point_in($order_code,$point,$cate,$kind,$type,$regdate=NULL,$msg=NULL) {

		// 등록일 값이 없다면
		if ($regdate == NULL) {
			$regdate = nowdate();
		}

		// 메세지 없다면
		if ($msg == NULL) {
			$msg = '';
		}

		$query = array(
			'order_code' 	=> $order_code,
			'member_id' 	=> $this->input->post('member_id'),
			'event_id' 		=> $this->input->post('member_id'),
			'cate' 			=> $cate,
			'kind' 			=> $kind,
			'type' 			=> $type,
			'saved_point' 	=> $this->input->post('amount'),
			'point' 			=> $point,
			'regdate' 		=> $regdate,
			'appdate' 		=> $regdate,
			'msg' 			=> $msg,
		);

		$this->db->insert('m_point', $query);
		$point_no = mysql_insert_id();
		return $point_no;

	}

	function point_up($table,$point_no) 
	{
		$query = array(
			'member_id' 	=> $this->input->post('member_id'),
			'event_id' 		=> $this->input->post('event_id'),
			
			'point' 		=> $this->input->post('point'),
			'saved_point' 	=> $this->input->post('saved_point'),
			
			'cate' 			=> $this->input->post('cate'),
			'msg' 			=> $this->input->post('msg'),
			'regdate' 		=> $this->input->post('regdate'),
			
		);

		$this->db->where('point_no', $point_no);
		$this->db->update($table, $query);
	}
	
	function point_out_up($_param) 
	{
		$query = array(
	
			'kind' 			=> $_param['kind'],
			'tx_id' 			=> $_param['tx_id'],
			
		);

		$this->db->where('point_no',$_param['point_no']);
		$this->db->update($_param['table'], $query);
	}

	function point_out_up2($_param) 
	{
		$query = array(
	
			'kind' 			=> $_param['kind'],
			'tx_id' 			=> $_param['tx_id'],
			'point' 			=> $_param['point'],
			
		);

		$this->db->where('point_no',$_param['point_no']);
		$this->db->update($_param['table'], $query);
	}
	
	function point_out_up_tx($_param) 
	{
		$query = array(
	
			'kind' 			=> $_param['kind'],
			'tx_id' 			=> $_param['tx_id'],
			'appdate' 			=> $_param['appdate'],
			'state' 			=> $_param['state'],
			
		);

		$this->db->where('point_no',$_param['point_no']);
		$this->db->update($_param['table'], $query);
	}

	function point_up_new($table,$point_no) 
	{
		$query = array(
			'member_id' 	=> $this->input->post('member_id'),
			'event_id' 		=> $this->input->post('event_id'),
			
			'bitcoin_count' 		=> $this->input->post('point'),
			'saved_bitcoin_count' 	=> $this->input->post('saved_point'),
			'fee_bitcoin_count' 	=> $this->input->post('bank_fee'),
			
			'cate' 			=> $this->input->post('cate'),
			'kind' 			=> $this->input->post('kind'),
			'msg' 			=> $this->input->post('msg'),
			'regdate' 		=> $this->input->post('regdate'),
			
		);

		$this->db->where('point_no', $point_no);
		$this->db->update($table, $query);
	}

	function bitcoin_up($table,$coin_no) 
	{
		$query = array(
			'member_id' 	=> $this->input->post('member_id'),
			'app_count' 		=> $this->input->post('app_count')*-1,
			'fee' 		=> $this->input->post('fee'),
			'all_count' 		=> $this->input->post('all_count')*-1,
			'app_address' 		=> $this->input->post('app_address'),
			'flgs' 	=> $this->input->post('flgs'),
			'regdate' 		=> $this->input->post('regdate'),
			
		);

		$this->db->where('coin_no', $coin_no);
		$this->db->update($table, $query);
	}

	function pay_out($table, $order_code, $office, $member_id, $event_id, $point, $saved_point, $fee, $cate, $kind, $msg=NULL, $regdate=NULL) {
		
		if($cate == 'out'){
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
			'office' 		=> $office,
			'member_id' 	=> $member_id,
			'event_id' 		=> $event_id,
			
			'cate' 			=> $cate,
			'kind' 			=> $kind,
			'type' 			=> $type,
			
			'point' 		=> $point,
			'saved_point' 	=> $saved_point,
			'bank_fee' 		=> $fee,
			
			'msg' 			=> $msg,
			'regdate' 		=> $regdate,
		);

		$this->db->insert($table, $query);

	}
	

	function point_del($table,$point_no,$member_id,$event_id,$bank_name) 
	{		
		$query = array(
			'member_id' => $member_id,
			'event_id' 	=> $event_id,
			'type' 		=> 'send',
			'bank_name' => $bank_name,
			'appdate'	  => date("Y-m-d H:i:s")
		);

		$this->db->where('point_no', $point_no);
		$this->db->update($table, $query);
	}
// 매출 삭제 테이블
	function point_del_clear($table,$point_no) 
	{		
		$this->db->where('point_no', $point_no);
		$this->db->delete($table);
	}

	function point_del_all_clear($table,$member_id) 
	{		
		$this->db->where('member_id', $member_id);
		$this->db->delete($table);
	}

	//20200909 jjh
	//매출 삭제시 수당 삭제
	function get_point_lists($table, $member_id) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('member_id',$member_id);			
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	function get_point_su_lists($table, $member_id) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('member_id',$member_id);
		$this->db->or_where('event_id', $member_id); 
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}

	function point_lists_in($point_no, $order_code, $country, $office_group, $office, $member_id, $event_id, $cate, $kind, $type, $point, $saved_point, $sale_point, $protg, $msg, $bank_fee, $bank_code,  $bank_holder, $bank_num, $bank_name, $regdate, $appdate, $deldate)
	{		
		if ($msg == NULL) {
			$msg = '';
		}
		if ($bank_code == NULL) {
			$bank_code = '';
		}
		if ($bank_holder == NULL) {
			$bank_holder = '';
		}
		if ($bank_name == NULL) {
			$bank_name = '';
		}
		if ($office_group == NULL) {
			$office_group = '';
		}
		

		$query = array(
			'point_no'			 	=> $point_no,
			'order_code' 			=> $order_code,
			'country' 				=> $country,
			'office_group' 		=> $office_group,
			'office' 					=> $office,
			'member_id' 			=> $member_id,
			'event_id' 				=> $event_id,
			'cate' 						=> $cate,
			'kind' 						=> $kind,
			'type' 						=> $type,
			'point' 					=> $point,
			'saved_point' 		=> $saved_point,
			'sale_point' 			=> $sale_point,
			'protg' 					=> $protg,
			'msg' 						=> $msg,
			'bank_fee' 				=> $bank_fee,
			'bank_code' 			=> $bank_code,
			'bank_holder' 		=> $bank_holder,
			'bank_num' 	    	=> $bank_num,
			'bank_name' 			=> $bank_name,
			'regdate' 				=> $regdate,
			'appdate' 				=> $appdate,
			'deldate' 				=> $deldate,
		);

		$this->db->insert('m_point_deleted', $query);
	}

	function point_su_lists_in($point_no, $order_code, $m_order_code, $country, $office_group, $office, $member_id, $event_id, $cate, $cate1, $kind, $type, $point, $saved_point, $protg, $msg, $bank_fee, $bank_code, $bank_holder, $bank_num, $bank_name, $regdate, $appdate, $deldate)
	{		
		if ($msg == NULL) {
			$msg = '';
		}
		if ($bank_code == NULL) {
			$bank_code = '';
		}
		if ($bank_holder == NULL) {
			$bank_holder = '';
		}
		if ($bank_num == NULL) {
			$bank_num = '';
		}
		if ($bank_name == NULL) {
			$bank_name = '';
		}
		if ($office_group == NULL) {
			$office_group = '';
		}

		$query = array(
			'point_no'			 	=> $point_no,
			'order_code' 			=> $order_code,
			'm_order_code' 			=> $m_order_code,
			'country' 				=> $country,
			'office_group' 		=> $office_group,
			'office' 					=> $office,
			'member_id' 			=> $member_id,
			'event_id' 				=> $event_id,
			'cate' 						=> $cate,
			'cate1' 						=> $cate1,
			'kind' 						=> $kind,
			'type' 						=> $type,
			'point' 					=> $point,
			'saved_point' 		=> $saved_point,
			'protg' 					=> $protg,
			'msg' 						=> $msg,
			'bank_fee' 				=> $bank_fee,
			'bank_code' 			=> $bank_code,
			'bank_holder' 		=> $bank_holder,
			'bank_num' 			=> $bank_num,
			'bank_name' 			=> $bank_name,
			'regdate' 				=> $regdate,
			'appdate' 				=> $appdate,
			'deldate' 				=> $deldate,
		);

		$this->db->insert('m_point_su_deleted', $query);
	}
	
	function point_clear_su_day($table,$member_id) 
	{		
		$this->db->where('kind', 'day');
		$this->db->where('member_id', $member_id);
		$this->db->delete($table);
	}
	function point_clear_su_mc($table2,$member_id) 
	{		
		$this->db->where('kind', 'mc');
		$this->db->where('event_id', $member_id);
		$this->db->or_where('member_id', $member_id); 
		$this->db->delete($table2);
	}


	function pay_out_coin($table, $order_code, $office, $member_id, $event_id, $point, $saved_point, $fee, $cate, $kind, $msg=NULL, $regdate=NULL) {
		
		if($cate == 'out'){
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
			'office' 		=> $office,
			'member_id' 	=> $member_id,
			'event_id' 		=> $event_id,
			
			'cate' 			=> $cate,
			'kind' 			=> $kind,
			'type' 			=> $type,
			
			'point' 		=> $point,
			'saved_point' 	=> $saved_point,
			'bank_fee' 		=> $fee,
			
			'bitcoin_count' 		=> $point,
			'saved_bitcoin_count' 	=> $saved_point,
			'fee_bitcoin_count' 		=> $fee,

			'msg' 			=> $msg,
			'regdate' 		=> $regdate,
		);

		$this->db->insert($table, $query);

	}
/* =================================================================
* balance
================================================================= */
	
	function balance_inout($member_no,$type,$count) 
	{		
		if($type == 'level'){
			$query = array(
				'level' => $count
			);			
		}
		else if($type == 'eth'){
			$query = array(
				'eth' 	=> $count
			);			
		}
		else if($type == 'coin'){
			$query = array(
				'coin' 	=> $count
			);			
		}
		else if($type == 'token'){	
			$query = array(
				'token' 	=> $count
			);			
		}
		
		else if($type == 'point'){	
			$query = array(
				'point' 	=> $count
			);			
		}
		else if($type == 'point_out'){
			$query = array(
				'point_out' 	=> $count
			);			
		}
		else if($type == 'point_fee'){
			$query = array(
				'point_fee' 	=> $count
			);			
		}
		
		else if($type == 'total_point'){
			$query = array(
				'total_point' 	=> $count
			);			
		}
		
		else if($type == 'su_day'){
			$query = array(
				'su_day' 	=> $count
			);			
		}
		else if($type == 'su_day_count'){
			$query = array(
				'su_day_count' 	=> $count
			);			
		}
		
		else if($type == 'su_re'){
			$query = array(
				'su_re' 	=> $count
			);			
		}
		
		else if($type == 'su_re2'){
			$query = array(
				'su_re2' 	=> $count
			);			
		}
		else if($type == 'su_mc'){
			$query = array(
				'su_mc' 	=> $count
			);			
		}
		else if($type == 'su_mc2'){
			$query = array(
				'su_mc2' 	=> $count
			);			
		}
		else if($type == 'su_ct'){
			$query = array(
				'su_ct' 	=> $count
			);			
		}
		else if($type == 'su_ct_re'){
			$query = array(
				'su_ct_re' 	=> $count
			);			
		}
		else if($type == 'su_sp'){
			$query = array(
				'su_sp' 	=> $count
			);			
		}
		else if($type == 'su_roll'){
			$query = array(
				'su_roll' 	=> $count
			);			
		}
		else if($type == 'su_sp_roll'){
			$query = array(
				'su_sp_roll' 	=> $count
			);			
		}
		else if($type == 'su_re_roll'){
			$query = array(
				'su_re_roll' 	=> $count
			);			
		}
		else if($type == 'su_level'){
			$query = array(
				'su_level' 	=> $count
			);			
		}
		else if($type == 'su_level_send'){
			$query = array(
				'su_level_send' 	=> $count
			);			
		}
		
		else if($type == 'volume'){
			$query = array(
				'volume' 	=> $count
			);			
		}
		else if($type == 'volume1'){
			$query = array(
				'volume1' 	=> $count
			);			
		}
		else if($type == 'volume2'){
			$query = array(
				'volume2' 	=> $count
			);			
		}
		else if($type == 'volume_now'){
			$query = array(
				'volume_now' 	=> $count
			);			
		}
		
		else if($type == 'usd'){
			$query = array(
				'usd' 	=> $count
			);			
		}
		
		else if($type == 'card'){
			$query = array(
				'card' 	=> $count
			);			
		}
		
		else if($type == 'purchase'){
			$query = array(
				'purchase' 	=> $count
			);			
		}		
		else if($type == 'purchase_cnt'){
			$query = array(
				'purchase_cnt' 	=> $count
			);			
		}
		
		else if($type == 'count'){
			$query = array(
				'count' 	=> $count
			);			
		}
		
		else if($type == 'loan'){
			$query = array(
				'loan' 	=> $count
			);			
		}		
		
		else if($type == 'today_sp'){
			$query = array(
				'today_sp' 	=> $count
			);			
		}		
		else if($type == 'today_su'){
			$query = array(
				'today_su' 	=> $count
			);			
		}
		
		else if($type == 'vlm_so'){
			$query = array(
				'vlm_so' 	=> $count
			);		
		}
		else if($type == 'vlm_left'){
			$query = array(
				'vlm_left' 	=> $count
			);		
		}
		else if($type == 'vlm_left_point'){
			$query = array(
				'vlm_left_point' 	=> $count
			);		
		}
		else if($type == 'vlm_right'){
			$query = array(
				'vlm_right' 	=> $count
			);		
		}
		else if($type == 'vlm_right_point'){
			$query = array(
				'vlm_right_point' 	=> $count
			);		
		}
		else if($type == 'virtual_left'){
			$query = array(
				'virtual_left' 	=> $count
			);		
		}
		else if($type == 'virtual_right'){
			$query = array(
				'virtual_right' 	=> $count
			);		
		}
		else if($type == 'bitcoin_count'){
			$query = array(
				'bitcoin_count' 	=> $count
			);		
		}
		else if($type == 'saved_bitcoin_count'){
			$query = array(
				'saved_bitcoin_count' 	=> $count
			);		
		}
		else if($type == 'fee_bitcoin_count'){
			$query = array(
				'fee_bitcoin_count' 	=> $count
			);		
		}
		
		else if($type == 'flower_count'){
			$query = array(
				'flower_count' 	=> $count
			);		
		}
		else if($type == 'f1_count'){
			$query = array(
				'f1_count' 	=> $count
			);		
		}
		else if($type == 'f2_count'){
			$query = array(
				'f2_count' 	=> $count
			);		
		}
		else if($type == 'f3_count'){
			$query = array(
				'f3_count' 	=> $count
			);		
		}
		else if($type == 'f4_count'){
			$query = array(
				'f4_count' 	=> $count
			);		
		}
		else if($type == 'f5_count'){
			$query = array(
				'f5_count' 	=> $count
			);		
		}
		else if($type == 'f6_count'){
			$query = array(
				'f6_count' 	=> $count
			);		
		}
		else if($type == 'f7_count'){
			$query = array(
				'f7_buy' 	=> $count
			);		
		}
		else if($type == 'f1_buy'){
			$query = array(
				'f1_buy' 	=> $count
			);		
		}
		else if($type == 'f2_buy'){
			$query = array(
				'f2_buy' 	=> $count
			);		
		}
		else if($type == 'f3_buy'){
			$query = array(
				'f3_buy' 	=> $count
			);		
		}
		else if($type == 'f4_buy'){
			$query = array(
				'f4_buy' 	=> $count
			);		
		}
		else if($type == 'f5_buy'){
			$query = array(
				'f5_buy' 	=> $count
			);		
		}
		else if($type == 'f6_buy'){
			$query = array(
				'f6_buy' 	=> $count
			);		
		}
		else if($type == 'f7_buy'){
			$query = array(
				'f7_buy' 	=> $count
			);		
		}
		else if($type == 'hvrex'){
			$query = array(
				'hvrex' 	=> $count
			);		
		}
		else if($type == 'basic_amount'){
			$query = array(
				'basic_amount' 	=> $count
			);		
		}
		
		else{
			$query = array(
				'office_group' 	=> $count
			);		
		}

		$this->db->where('member_no',$member_no);
		$this->db->update('m_balance', $query);

	}
	
	
	function balance_inout_id($member_id,$type,$count) 
	{		
		if($type == 'level'){
			$query = array(
				'level' => $count
			);			
		}
		else if($type == 'eth'){
			$query = array(
				'eth' 	=> $count
			);			
		}
		else if($type == 'coin'){
			$query = array(
				'coin' 	=> $count
			);			
		}
		else if($type == 'token'){	
			$query = array(
				'token' 	=> $count
			);			
		}
		
		else if($type == 'point'){	
			$query = array(
				'point' 	=> $count
			);			
		}
		else if($type == 'point_out'){
			$query = array(
				'point_out' 	=> $count
			);			
		}
		else if($type == 'point_fee'){
			$query = array(
				'point_trans' 	=> $count
			);			
		}
		
		else if($type == 'total_point'){
			$query = array(
				'total_point' 	=> $count
			);			
		}
		
		else if($type == 'su_day'){
			$query = array(
				'su_day' 	=> $count
			);			
		}
		else if($type == 'su_day_count'){
			$query = array(
				'su_day_count' 	=> $count
			);			
		}
		
		else if($type == 'su_re'){
			$query = array(
				'su_re' 	=> $count
			);			
		}
		
		else if($type == 'su_re2'){
			$query = array(
				'su_re2' 	=> $count
			);			
		}
		else if($type == 'su_mc'){
			$query = array(
				'su_mc' 	=> $count
			);			
		}
		else if($type == 'su_mc2'){
			$query = array(
				'su_mc2' 	=> $count
			);			
		}
		else if($type == 'su_ct'){
			$query = array(
				'su_ct' 	=> $count
			);			
		}
		else if($type == 'su_ct_re'){
			$query = array(
				'su_ct_re' 	=> $count
			);			
		}
		else if($type == 'su_sp'){
			$query = array(
				'su_sp' 	=> $count
			);			
		}
		else if($type == 'su_roll'){
			$query = array(
				'su_roll' 	=> $count
			);			
		}
		else if($type == 'su_sp_roll'){
			$query = array(
				'su_sp_roll' 	=> $count
			);			
		}
		else if($type == 'su_re_roll'){
			$query = array(
				'su_re_roll' 	=> $count
			);			
		}
		else if($type == 'su_level'){
			$query = array(
				'su_level' 	=> $count
			);			
		}
		else if($type == 'su_level_send'){
			$query = array(
				'su_level_send' 	=> $count
			);			
		}
		
		else if($type == 'volume'){
			$query = array(
				'volume' 	=> $count
			);			
		}
		else if($type == 'volume_now'){
			$query = array(
				'volume_now' 	=> $count
			);			
		}
		
		else if($type == 'usd'){
			$query = array(
				'usd' 	=> $count
			);			
		}
		
		else if($type == 'card'){
			$query = array(
				'card' 	=> $count
			);			
		}
		
		else if($type == 'purchase'){
			$query = array(
				'purchase' 	=> $count
			);			
		}		
		else if($type == 'purchase_cnt'){
			$query = array(
				'purchase_cnt' 	=> $count
			);			
		}
		
		else if($type == 'count'){
			$query = array(
				'count' 	=> $count
			);			
		}
		
		else if($type == 'loan'){
			$query = array(
				'loan' 	=> $count
			);			
		}		
		
		else if($type == 'today_sp'){
			$query = array(
				'today_sp' 	=> $count
			);			
		}		
		else if($type == 'today_su'){
			$query = array(
				'today_su' 	=> $count
			);			
		}
		
		else if($type == 'vlm_so'){
			$query = array(
				'vlm_so' 	=> $count
			);		
		}
		else if($type == 'vlm_left'){
			$query = array(
				'vlm_left' 	=> $count
			);		
		}
		else if($type == 'vlm_left_point'){
			$query = array(
				'vlm_left_point' 	=> $count
			);		
		}
		else if($type == 'vlm_right'){
			$query = array(
				'vlm_right' 	=> $count
			);		
		}
		else if($type == 'vlm_right_point'){
			$query = array(
				'vlm_right_point' 	=> $count
			);		
		}
		else if($type == 'virtual_left'){
			$query = array(
				'virtual_left' 	=> $count
			);		
		}
		else if($type == 'virtual_right'){
			$query = array(
				'virtual_right' 	=> $count
			);		
		}
		else if($type == 'bitcoin_count'){
			$query = array(
				'bitcoin_count' 	=> $count
			);		
		}
		else if($type == 'saved_bitcoin_count'){
			$query = array(
				'saved_bitcoin_count' 	=> $count
			);		
		}
		else if($type == 'fee_bitcoin_count'){
			$query = array(
				'fee_bitcoin_count' 	=> $count
			);		
		}
		
		else if($type == 'flower_count'){
			$query = array(
				'flower_count' 	=> $count
			);		
		}
		else if($type == 'f1_count'){
			$query = array(
				'f1_count' 	=> $count
			);		
		}
		else if($type == 'f2_count'){
			$query = array(
				'f2_count' 	=> $count
			);		
		}
		else if($type == 'f3_count'){
			$query = array(
				'f3_count' 	=> $count
			);		
		}
		else if($type == 'f4_count'){
			$query = array(
				'f4_count' 	=> $count
			);		
		}
		else if($type == 'f5_count'){
			$query = array(
				'f5_count' 	=> $count
			);		
		}
		else if($type == 'f6_count'){
			$query = array(
				'f6_count' 	=> $count
			);		
		}
		else if($type == 'f7_count'){
			$query = array(
				'f7_count' 	=> $count
			);		
		}
		else if($type == 'f1_buy'){
			$query = array(
				'f1_buy' 	=> $count
			);		
		}
		else if($type == 'f2_buy'){
			$query = array(
				'f2_buy' 	=> $count
			);		
		}
		else if($type == 'f3_buy'){
			$query = array(
				'f3_buy' 	=> $count
			);		
		}
		else if($type == 'f4_buy'){
			$query = array(
				'f4_buy' 	=> $count
			);		
		}
		else if($type == 'f5_buy'){
			$query = array(
				'f5_buy' 	=> $count
			);		
		}
		else if($type == 'f6_buy'){
			$query = array(
				'f6_buy' 	=> $count
			);		
		}
		else if($type == 'f7_buy'){
			$query = array(
				'f7_buy' 	=> $count
			);		
		}
		else if($type == 'hvrex'){
			$query = array(
				'hvrex' 	=> $count
			);		
		}
		//---------------------------------------------------------
		// 2020.07.30 박종훈 매출, 재매출에 관한 데일리 수당 합계 추가
		else if($type == 'su_day1'){
			$query = array(
				'su_day1' 	=> $count
			);		
		}
		else if($type == 'su_day_count1'){
			$query = array(
				'su_day_count1' 	=> $count
			);			
		}
		else if($type == 'su_day2'){
			$query = array(
				'su_day2' 	=> $count
			);		
		}
		else if($type == 'su_day_count2'){
			$query = array(
				'su_day_count2' 	=> $count
			);			
		}

		else{
			$query = array(
				'office_group' 	=> $count
			);		
		}	

		$this->db->where('member_id',$member_id);
		$this->db->update('m_balance', $query);

	}

function balance_inout_id2($member_id,$type,$count) 
	{		
		if($type == 'level'){
			$query = array(
				'level' => $count
			);			
		}
		else if($type == 'eth'){
			$query = array(
				'eth' 	=> $count
			);			
		}
		else if($type == 'coin'){
			$query = array(
				'coin' 	=> $count
			);			
		}
		else if($type == 'token'){	
			$query = array(
				'token' 	=> $count
			);			
		}
		
		else if($type == 'point'){	
			$query = array(
				'point' 	=> $count
			);			
		}
		else if($type == 'point_out'){
			$query = array(
				'point_out' 	=> $count
			);			
		}
		else if($type == 'point_fee'){
			$query = array(
				'point_trans' 	=> $count
			);			
		}
		
		else if($type == 'total_point'){
			$query = array(
				'total_point' 	=> $count
			);			
		}
		
		else if($type == 'su_day'){
			$query = array(
				'su_day' 	=> $count
			);			
		}
		else if($type == 'su_day_count'){
			$query = array(
				'su_day_count' 	=> $count
			);			
		}
		
		else if($type == 'su_re'){
			$query = array(
				'su_re' 	=> $count
			);			
		}
		
		else if($type == 'su_re2'){
			$query = array(
				'su_re2' 	=> $count
			);			
		}
		else if($type == 'su_mc'){
			$query = array(
				'su_mc' 	=> $count
			);			
		}
		else if($type == 'su_mc2'){
			$query = array(
				'su_mc2' 	=> $count
			);			
		}
		else if($type == 'su_ct'){
			$query = array(
				'su_ct' 	=> $count
			);			
		}
		else if($type == 'su_ct_re'){
			$query = array(
				'su_ct_re' 	=> $count
			);			
		}
		else if($type == 'su_sp'){
			$query = array(
				'su_sp' 	=> $count
			);			
		}
		else if($type == 'su_roll'){
			$query = array(
				'su_roll' 	=> $count
			);			
		}
		else if($type == 'su_sp_roll'){
			$query = array(
				'su_sp_roll' 	=> $count
			);			
		}
		else if($type == 'su_re_roll'){
			$query = array(
				'su_re_roll' 	=> $count
			);			
		}
		else if($type == 'su_level'){
			$query = array(
				'su_level' 	=> $count
			);			
		}
		else if($type == 'su_level_send'){
			$query = array(
				'su_level_send' 	=> $count
			);			
		}
		
		else if($type == 'volume'){
			$query = array(
				'volume' 	=> $count
			);			
		}
		else if($type == 'volume_now'){
			$query = array(
				'volume_now' 	=> $count
			);			
		}
		
		else if($type == 'usd'){
			$query = array(
				'usd' 	=> $count
			);			
		}
		
		else if($type == 'card'){
			$query = array(
				'card' 	=> $count
			);			
		}
		
		else if($type == 'purchase'){
			$query = array(
				'purchase' 	=> $count
			);			
		}		
		else if($type == 'purchase_cnt'){
			$query = array(
				'purchase_cnt' 	=> $count
			);			
		}
		
		else if($type == 'count'){
			$query = array(
				'count' 	=> $count
			);			
		}
		
		else if($type == 'loan'){
			$query = array(
				'loan' 	=> $count
			);			
		}		
		
		else if($type == 'today_sp'){
			$query = array(
				'today_sp' 	=> $count
			);			
		}		
		else if($type == 'today_su'){
			$query = array(
				'today_su' 	=> $count
			);			
		}
		
		else if($type == 'vlm_so'){
			$query = array(
				'vlm_so' 	=> $count
			);		
		}
		else if($type == 'vlm_left'){
			$query = array(
				'vlm_left' 	=> $count
			);		
		}
		else if($type == 'vlm_left_point'){
			$query = array(
				'vlm_left_point' 	=> $count
			);		
		}
		else if($type == 'vlm_right'){
			$query = array(
				'vlm_right' 	=> $count
			);		
		}
		else if($type == 'vlm_right_point'){
			$query = array(
				'vlm_right_point' 	=> $count
			);		
		}
		else if($type == 'virtual_left'){
			$query = array(
				'virtual_left' 	=> $count
			);		
		}
		else if($type == 'virtual_right'){
			$query = array(
				'virtual_right' 	=> $count
			);		
		}
		else if($type == 'bitcoin_count'){
			$query = array(
				'bitcoin_count' 	=> $count
			);		
		}
		else if($type == 'saved_bitcoin_count'){
			$query = array(
				'saved_bitcoin_count' 	=> $count
			);		
		}
		else if($type == 'fee_bitcoin_count'){
			$query = array(
				'fee_bitcoin_count' 	=> $count
			);		
		}
		
		else if($type == 'flower_count'){
			$query = array(
				'flower_count' 	=> $count
			);		
		}
		else if($type == 'f1_count'){
			$query = array(
				'f1_count' 	=> $count
			);		
		}
		else if($type == 'f2_count'){
			$query = array(
				'f2_count' 	=> $count
			);		
		}
		else if($type == 'f3_count'){
			$query = array(
				'f3_count' 	=> $count
			);		
		}
		else if($type == 'f4_count'){
			$query = array(
				'f4_count' 	=> $count
			);		
		}
		else if($type == 'f5_count'){
			$query = array(
				'f5_count' 	=> $count
			);		
		}
		else if($type == 'f6_count'){
			$query = array(
				'f6_count' 	=> $count
			);		
		}
		else if($type == 'f7_count'){
			$query = array(
				'f7_count' 	=> $count
			);		
		}
		else if($type == 'f1_buy'){
			$query = array(
				'f1_buy' 	=> $count
			);		
		}
		else if($type == 'f2_buy'){
			$query = array(
				'f2_buy' 	=> $count
			);		
		}
		else if($type == 'f3_buy'){
			$query = array(
				'f3_buy' 	=> $count
			);		
		}
		else if($type == 'f4_buy'){
			$query = array(
				'f4_buy' 	=> $count
			);		
		}
		else if($type == 'f5_buy'){
			$query = array(
				'f5_buy' 	=> $count
			);		
		}
		else if($type == 'f6_buy'){
			$query = array(
				'f6_buy' 	=> $count
			);		
		}
		else if($type == 'f7_buy'){
			$query = array(
				'f7_buy' 	=> $count
			);		
		}
		else if($type == 'hvrex'){
			$query = array(
				'hvrex' 	=> $count
			);		
		}
		
		else{
			$query = array(
				'office_group' 	=> $count
			);		
		}	

		$this->db->where('member_id',$member_id);
		$this->db->update('m_balance_copy', $query);

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
	
	function get_balance_li() {
		$this->db->select('*');
		$this->db->from('m_balance');
		$this->db->order_by("balance_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_balance_select_li($filed,$str) {
		$this->db->select('*');
		$this->db->from('m_balance');
		$this->db->where($filed,$str);
		$this->db->order_by("balance_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_balance_desc() {
		$this->db->select('*');
		$this->db->from('m_balance');
		$this->db->order_by("balance_no", "desc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_balance_puchase($id) {
		$this->db->select('puchase');
		$this->db->from('m_balance');
		$this->db->where('member_id',$id);
		$query = $this->db->get();
		$item = $query->row();
		return $item->puchase;
	}
	
	function get_balance_level($id) {
		$this->db->select('level');
		$this->db->from('m_balance');
		$this->db->where('member_id',$id);
		$query = $this->db->get();
		$item = $query->row();
		return $item->level;
	}
/* =================================================================
* pay datetime
================================================================= */

	function sum_point_group_date($table,$group,$start,$end) {
		$this->db->select('sum(point) as point');
		$this->db->from($table);
		
		$this->db->where('office_group',$group);
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		
		$this->db->order_by("point_no", "asc");
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	function sum_point_center_date($table,$office,$start,$end) {
		$this->db->select('sum(point) as point');
		$this->db->from($table);
		
		$this->db->where('office',$office);
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		
		$this->db->order_by("point_no", "asc");
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	function sum_point_group_kind_date($table,$group,$kind,$start,$end) {
		$this->db->select('sum(point) as point');
		$this->db->from($table);
		
		$this->db->where('office_group',$group);
		$this->db->where('kind',$kind);
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		
		$this->db->order_by("point_no", "asc");
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	function sum_point_center_kind_date($table,$office,$kind,$start,$end) {
		$this->db->select('sum(point) as point');
		$this->db->from($table);
		
		$this->db->where('office',$office);
		$this->db->where('kind',$kind);
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		
		$this->db->order_by("point_no", "asc");
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	function get_point_country_date($table,$country,$start,$end) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('country',$country);
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		
		$this->db->order_by("point_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_point_group_date($table,$group,$start,$end) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('group',$group);
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		
		$this->db->order_by("point_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_point_center_date($table,$center,$start,$end) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('center',$center);
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		
		$this->db->order_by("point_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_point_kind_date($table,$kind,$start,$end) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('kind',$kind);
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		
		$this->db->order_by("point_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_point_sale_today($table, $start, $end, $member_id = NULL) {
		$this->db->select('*');
		$this->db->from($table);
		
		if ($member_id != NULL) {
			$this->db->where('member_id',$member_id);
		}
		
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	// 매출로 잡는것 - 코인에서 자유로 가는 것도 매출로 잡는다. 자유통장에서 적립통장으로 전환한 것들
	function get_point_sale($member_id = NULL) {
		$this->db->select('*');
		$this->db->from('m_point');
		
		if ($member_id != NULL) {
			$this->db->where('member_id',$member_id);
		}
		
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}


/* =================================================================
* 출금관련
================================================================= */

	// 포인트 환전
	function point_ex($order_code,$member_id,$event_id,$points,$fee,$cate,$kind,$type,$msg=NULL,$regdate=NULL) {

		// 등록일 값이 없다면
		if ($regdate == NULL) {
			$regdate = nowdate();
		}

		// 메세지 없다면
		if ($msg == NULL) {
			$msg = '';
		}
		
		$send_point = $points - $fee;
		$query = array(
			'order_code' => $order_code,
			'member_id' => $member_id,
			'event_id' => $event_id,
			'cate' => $cate,
			'kind' => $kind,
			'type' => $type,
			
			'point' => $send_point,
			'saved_point' => $points,
			'bank_fee' => $fee,
			
			
			'bank_name' => $this->input->post('bank_name'),
			'bank_num' => $this->input->post('bank_number'),
			'bank_holder' => $this->input->post('bank_hoder'),
			'bank_code' => $this->input->post('bank_jumin'),
			
			'regdate' => $regdate,
			'appdate' => $regdate,
			'msg' => $msg,
		);

		//$p = $this->plan_in_chk($member_id); // 플랜에 있어야 최종등록한다.
		//if ($points != 0 and $p != 0) {
			$this->db->insert('m_point', $query);
		//}

	}
	
	
	// 그동안 받안간 수당 개별
	function get_kind_out($kind,$day) {
        $this->db->select('cate,type,kind,sum(point) as point, sum(saved_point) as saved_point');
        $this->db->from('m_point');
        $this->db->where('cate','out');
        if ($kind) {
        	$this->db->where('kind',$kind);
        }
        if ($day == 'day') {        	
        	//$this->db->where('regdate','date_add(curdate(), nterval 1 day)',FALSE);
		}
		
		if ($day == 'today') {
        	$this->db->where('regdate >=','curdate()',FALSE);
		}
		
        $query = $this->db->get();
        $item = $query->row();
        
        if ($item) {
        	$item = $item->point;
        } else {
	        $item = 0;
        }
        return $item;
    }
    

	function get_coin_no($table,$idx) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->from('m_point');
		$this->db->where('coin_no',$idx);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}

	function set_return_point($_param)
	{
		$this->db->insert("m_point_return", $_param);
	}
// 하루에 한번만 매출, 재매출 가능  20200803 jjh
	function get_today_data($table,$id,$cate) {
		$this->db->select('COUNT(member_id) AS today_data');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		$this->db->where('cate',$cate);
		$this->db->where('LEFT(regdate , 10) = LEFT(NOW(),10)');
		
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}

// 하루에 한번만 매출, 재매출 가능  20200803 jjh
	function get_today_out($table,$id,$cate) {
		$this->db->select('COUNT(member_id) AS today_out');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		$this->db->where('cate',$cate);
		$this->db->where('LEFT(regdate , 10) = LEFT(NOW(),10)');
		
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}

	public function admin_search($input) {
		$this->db->select("SQL_CALC_FOUND_ROWS *",false);
	
		$this->db->from("{$input['table']}");

		if(isset($input["start_date"]) && $input["start_date"]) $this->db->where("regdate >=", $input["start_date"]);
		if(isset($input["end_date"]) && $input["end_date"]) $this->db->where("regdate <=", $input["end_date"]);
		$this->db->order_by('regdate',"desc");

		$result['page_list']= $this->db->get()->result();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;

		return $result;
	}

	function get_isfree_cnt($id) {
		$this->db->select('COUNT(office_group) as free_cnt');
		$this->db->from('m_point');
		
		$this->db->where('office_group','free');
		$this->db->where('member_id',$id);
		
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	function get_stake_sum($id) {
		$this->db->select('ifnull(SUM(point),0) as vol');
		$this->db->from('m_point');
		
		$this->db->where('member_id',$id);
		$this->db->group_by('member_id');
		
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	function get_point_out_amount($date, $login_id){
		$this->db->select(' ifnull(SUM(saved_point),0) as vol');
		$this->db->from('m_point_out');
		
		$this->db->where('member_id',$login_id);
		$this->db->where('LEFT(regdate,10)',$date);
		
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}

	function get_sales_terms($login_id){
		$this->db->select('member_id, regdate, appdate,
		(SELECT COUNT(*) FROM m_point WHERE check_su = "Y" AND member_id = "'.$login_id.'") AS cs_y,
		(SELECT COUNT(*) FROM m_point WHERE check_su = "N" AND member_id = "'.$login_id.'") AS cs_n ');
		$this->db->from('m_point');
		
		$this->db->where('member_id',$login_id);
		$this->db->where('check_su','N');
		
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}

	// point_su에 출금 데이터 넣기   jjh
	function set_point_su_out($order_code, $point_out_code, $member_id, $event_id, $point, $saved_point, $fee, $cate, $kind, $bank_name, $bank_holder,$bank_num, $regdate=NULL) {
		
		$type 	= "1";				
		
		if ($regdate == NULL) {
			$regdate = nowdate();
		}
		
		$query = array(
			'order_code' 	=> $order_code,
			'point_out_code' 	=> $point_out_code,
			'member_id' 	=> $member_id,
			'event_id' 		=> $event_id,
			
			'cate' 			=> $cate,
			'kind' 			=> $kind,
			'type' 			=> $type,
			
			'point' 		=> $point,
			'saved_point' 	=> $saved_point,
			'bank_fee' 		=> $fee,

			'bank_name' => $bank_name,
			'bank_holder' => $bank_holder,
			'bank_num' => $bank_num,
			
			'regdate' 		=> $regdate,
		);

		$this->db->insert('m_point_su', $query);
	}
	function get_point_out_q($point_no){
		$this->db->select('*');
		$this->db->from('m_point_out');
		
		$this->db->where('point_no',$point_no);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	function set_point_out_del_in($point_no, $order_code, $office, $member_id, $event_id, $cate, $kind, $type, $point, $saved_point, $protg, $msg, $bank_fee, $regdate, $appdate, $tx_id, $state) {
		$query = array(
			'point_no'       => $point_no,
			'order_code'       => $order_code,
			'office'       => $office,
			'member_id'       => $member_id,
			'event_id'       => $event_id,
			'cate'       => $cate,
			'kind'       => $kind,
			'type'       => $type,
			'point'       => $point,
			'saved_point'       => $saved_point,
			'protg'       => $protg,
			'msg'       => $msg,
			'bank_fee'       => $bank_fee,
			'regdate'       => $regdate,
			'appdate'       => $appdate,
			'tx_id'       => $tx_id,
			'state'       => $state,

		);
			$this->db->insert('m_point_out_deleted', $query);
	}
	function get_re_savepoint($member_id){
		$this->db->select('saved_point');
		$this->db->from('m_point');
		
		$this->db->where('member_id',$member_id);
		$query = $this->db->get();
		$item = $query->row();
		return $item->saved_point;
	}

}
?>
