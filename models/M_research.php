<?
class M_research extends CI_Model {

	function M_stats()
	{
		parent::__construct();
	}

/* =================================================================
* laster
================================================================= */
	// 회원테이블 가져오기
	function get_member_his() {
		$this->db->select('*');
		$this->db->from('m_member');
		
		$this->db->order_by("member_no", "desc");
		$this->db->limit(5);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_pay_out() {
		$this->db->select('*');
		$this->db->from('m_point');
		
		$this->db->where('cate','out');
		$this->db->order_by("point_no", "desc");
		$this->db->limit(5);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	
	
	function get_pay_coin() {
		$this->db->select('*');
		$this->db->from('m_coin');
		
		$this->db->where('type','uce');
		$this->db->order_by("coin_no", "desc");
		$this->db->limit(10);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_pay_accu() {
		$this->db->select('*');
		$this->db->from('m_pay_accu');
		
		$this->db->where('cate','free');
		$this->db->where('kind','rev');
		$this->db->order_by("point_no", "desc");
		$this->db->limit(10);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
/* =================================================================
* total
================================================================= */
	// 전체 회원수 가져오기
	function get_member_total() {
		$this->db->select('member_id');
		$this->db->from('m_member');
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 전체 센터수 가져오기
	function get_center_total() {
		$this->db->select('center_no');
		$this->db->from('m_center');
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 페이 전체수량
	function get_point_total($table) {
		$this->db->select('sum(point) as point');
		$this->db->from($table);
		
		$this->db->where('type','in');
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	// 코인 전체수량
	function get_coin_total($id) {
		$this->db->select('sum(point) as point');
		$this->db->from('m_coin');
		$this->db->where('event_id',$id);	
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	
	// 유효 매출금
	function get_money_total($is_ok=NULL) {
		$this->db->select('amount');
		$this->db->from('m_plan');
		
		if ($is_ok) {
			$this->db->where('is_give',0);
			$this->db->where('buy_type','new');
			$this->db->where('is_approval',0);

		}
		
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	// 유효 매출금 신규
	function get_trans_total() {
		$this->db->select('member_id, point, kind, type');
		$this->db->from('m_point');
		$this->db->where('member_id','sabaitex');
		$this->db->where('type','out');
		$this->db->where('point >=','1200');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	
	
	//총 지출 건
	function get_out_money() {
		$this->db->select('point_no,point,saved_point, coin_point, cate,type');
		$this->db->from('m_point');
		$this->db->where('cate','payment');
		$this->db->where('type','in');
		$this->db->where('kind !=','hold');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	
	
	// 총 환전 금액
	function get_out_exchange() {
		$this->db->select('point_no,point,cate,kind,type,bank_fee');
		$this->db->from('m_point');
		$this->db->where('kind','exchange');
		$this->db->where('type','out');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}



	// 총 적립금
	function get_out_saved() {
		$this->db->select('point_no,sum(saved_point) as saved_point,cate,type');
		$this->db->from('m_point');
		$this->db->where('cate','payment');
		$this->db->where('type','in');
		$query = $this->db->get();
		$item = $query->row();
		return $item->saved_point;
	}

	// 총 적립금
	function get_in_saved() {
		$this->db->select('point_no,sum(saved_point) as saved_point,cate,type');
		$this->db->from('m_point');
		$this->db->where('cate','payment');
		$this->db->where('type','out');
		$query = $this->db->get();
		$item = $query->row();
		return $item->saved_point;
	}
	

	// 총 적립금
	function get_out_kind($kind) {
		$this->db->select('point_no,sum(point) as point,cate,kind,type');
		$this->db->from('m_point');
		$this->db->where('kind',$kind);
		$this->db->where('type','in');
		$query = $this->db->get();
		$item = $query->row();
		return $item->point;
	}
	
	
	

}

?>
