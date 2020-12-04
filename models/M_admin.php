<?php
class M_admin extends CI_Model {

/* =================================================================
* 회원 관리
================================================================= */

	// 특정테이블 특정필드의 값 리스트하기
	function table_li($table,$filed=NULL,$volume=NULL) {
		$this->db->select('*');
		$this->db->from($table);
		if($filed != NULL && $volume != NULL){
			$this->db->where($filed,$volume);			
		}
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	// 회원테이블 가져오기
	function get_member_his() {
		$this->db->select('*');
		$this->db->from('g5_member');
		$this->db->order_by("mb_no", "asc");
		//$this->db->limit(5);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	

	// 회원정보 수정
	function member_up($id) {
		
		//날짜 수정
		$reg =  $this->input->post('regdate');
		$regdate = $reg.' 00:00:00';
		
		// 핸드폰 번호 가공
		$mobile = $this->input->post('mobile');
		$mobile = explode('-',$mobile); 
		$mobile = $mobile[0].@$mobile[1].@$mobile[2];

		// 계좌번호 번호 가공
		$bank_num = $this->input->post('bank_number');
		$bank_num = explode('-',$bank_num); 
		$bank_num = $bank_num[0].@$bank_num[1].@$bank_num[2].@$bank_num[3];
		
		$query = array(
			'mb_office' => $this->input->post('office'),
			'mb_sponsor' => strtolower($this->input->post('sponsor_id')),
			'mb_recommend' => strtolower($this->input->post('recommend_id')),
			'mb_password' => $this->input->post('password'),
			'mb_email' => $this->input->post('email'),
			'mb_hp' => $mobile,
			'mb_name' => $this->input->post('name'),
			// 'level' => $this->input->post('level'),
			'mb_bank_number' => $bank_num,
			'mb_bank_name' => $this->input->post('bank_name'),
			'mb_bank_holder' => $this->input->post('bank_holder'),
			'mb_datetime' =>$regdate,
		);
		$this->db->where('mb_id', $id);
		$this->db->update('g5_member', $query);
	}


	// 다운라인 카운트 (삭제시 산하 조회)
	function down_count($id) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('sponsor_id',$id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	


/* =================================================================
* 포인트 관련
================================================================= */

	// 수당 히스토리 가져오기
	function get_per_his($id,$type) {
		$this->db->select('*');
		$this->db->from('m_point');
		$this->db->where('cate',$type);
		$this->db->where('member_id',$id);
		$this->db->order_by("point_no", "desc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	

/* =================================================================
* 환전 관리
================================================================= */

	function point_exchange($order_code){
		
		// 계좌번호 번호 가공
		$bank_num = $this->input->post('bank_number');
		$bank_num = explode('-',$bank_num); 
		$bank_num = $bank_num[0].@$bank_num[1].@$bank_num[2].@$bank_num[3];
		
		$ex = $this->input->post('amount') - $this->input->post('fee');
		
		$query = array(
			'order_code' => $order_code,
			'member_id' => $this->session->userdata('member_id'),
			'event_id' => 'Company',
			'cate' => 'payment',
			'type' => 'out',
			'point' => $this->input->post('amount'),
			'kind' => 'exchange',
			'bank_fee' => $this->input->post('fee'),
			'swi_code' => $this->input->post('swi_code'),
			'bank_name' => $this->input->post('bank_name'),
			'bank_num' => $bank_num,
			'bank_holder' => $this->input->post('bank_holder'),
			'regdate' => nowdate(),
			'appdate' => nowdate(),
			'msg' => '송금 대기중',
				
		);

		$this->db->insert('m_point', $query);

	}
	

	function ex($order_code) {
        $this->db->select('member_id,type,appdate,sum(point) as point');
        $this->db->from('m_point');
        $this->db->where('order_code', $order_code);
        $this->db->group_by('member_id');
        $query = $this->db->get();
        $item = $query->result();
        return $item;
   	}
    
    
   	// 해당 회원의 출금 관련 수정하기
	function exchange_edit($idx) {

		$kind = $this->input->post('kind');

		if($kind == "complete") {
			$type = "out";
			$appdate = nowdate();
		}
		
		if($kind == "hold") {
			$type = "out";
			$appdate = '0000-00-00 00:00:00';
		}		

		if($kind == "request") {
			$type = "out";
			$appdate = '0000-00-00 00:00:00';
		}

		$query = array(
			'kind' => $kind,
			'appdate' => $appdate,
		);

		$this->db->where('point_no', $idx);
		$this->db->update('m_point', $query);
	}
	
	
	// 출금 송금 관련 리스트
	function exchangefind($start,$end,$kind) {
		$this->db->select('*');
		$this->db->from('m_point');
		$this->db->where('regdate >', $start);
		$this->db->where('regdate <', $end);
		$this->db->where('cate', 'out');
		$this->db->where('kind', $kind);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	
	// 송금대기중인 것들 일괄 송금완료 처리
	function exchangeupdate($start,$end) {
	
		$query = array(
			'msg' => '송금 완료',
			'kind' => 'complete',
			'appdate' => nowdate()
		);
		
		$this->db->where('regdate >', $start);
		$this->db->where('regdate <', $end);
		$this->db->where('cate', 'out');
		$this->db->where('kind', 'request');
		$this->db->where('msg', '송금 대기중');
		$this->db->update('m_point', $query);

	}
	

/* =================================================================
* 송금 관리
================================================================= */

    function banking_list2($start,$end,$kind) {
        $this->db->select('*');
        $this->db->from('m_point');
		$this->db->where('regdate >', $start.' 00:00:00');
		$this->db->where('regdate <', $end.' 23:59:59');
		$this->db->where('cate', 'out');
		$this->db->where('kind', $kind);
        $query = $this->db->get();
        $item = $query->result();
        return $item;
    }
    
    
    function banking_list1($start,$end,$kind) {
        $this->db->select('*');
        $this->db->from('m_point');
		$this->db->where('regdate >', $start.' 00:00:00');
		$this->db->where('regdate <', $end.' 23:59:59');
		$this->db->where('cate', 'out');
		$this->db->where('kind', $kind);
        $query = $this->db->get();
        $item = $query->result();
        return $item;
    }
    
	function get_total_point($holder,$order_code) {	
		$this->db->select('*');
        $this->db->from('m_point');
        $this->db->where('order_code', $order_code);
        $this->db->where('bank_holder', $holder);
        $this->db->where('kind','exchange');
		$query = $this->db->get();
		$item = $query->result();

		$point = 0;
		foreach ($item as $row) {
			$point =  $row->point + $point; 
		}
		
		return $point;
		
	}
	
/* =================================================================
* 계좌 관리
================================================================= */

	function bank_page($order_code) {
		$this->db->select('m_point.member_id,g5_member.mb_name,g5_member.mb_office, g5_member.mb_bank_holder, g5_member.mb_bank_name, g5_member.mb_bank_holder, g5_member.mb_bank_number, m_point.kind, m_point.regdate, sum(m_point.point) as point, sum(m_point.saved_point) as saved_point');
		$this->db->from('m_point');
		$this->db->join('g5_member', 'm_point.member_id = g5_member.mb_id', 'left');
		$this->db->where('m_point.regdate', $order_code);
		$this->db->where('m_point.kind !=','hold');
		$this->db->where('m_point.kind !=','sang');
		$this->db->group_by('m_point.member_id');
		$this->db->order_by("g5_member.mb_office", "asc");
		
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	
	
	function bank_li($order_code) {
		$this->db->select('m_point.member_id,g5_member.mb_name, g5_member.mb_office, g5_member.mb_bank_holder, g5_member.mb_bank_name, g5_member.mb_bank_holder, g5_member.mb_bank_number, m_point.kind, m_point.regdate, sum(m_point.point) as point, sum(m_point.saved_point) as saved_point');
		$this->db->from('m_point');
		$this->db->join('g5_member', 'm_point.member_id = g5_member.mb_id', 'left');
		$this->db->where('m_point.regdate', $order_code);
		$this->db->where('m_point.kind !=','hold');
		$this->db->where('m_point.kind !=','sang');
		$this->db->group_by('m_point.member_id');
		$this->db->order_by("g5_member.mb_office", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function bank_li_send($order_code) {
		$this->db->select('m_point.member_id,g5_member.mb_name,g5_member.mb_office,  g5_member.mb_bank_holder, g5_member.mb_bank_name, g5_member.mb_bank_holder, g5_member.mb_bank_number, m_point.type, m_point.kind, m_point.regdate, sum(m_point.point) as point, sum(m_point.saved_point) as saved_point');
		$this->db->from('m_point');
		$this->db->join('g5_member', 'm_point.member_id = g5_member.mb_id', 'left');
		$this->db->where('m_point.regdate', $order_code);
		$this->db->where('m_point.kind !=','hold');
		$this->db->where('m_point.kind !=','sang');
		$this->db->group_by('g5_member.mb_bank_number');
		$this->db->order_by("g5_member.mb_office", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
/* =================================================================
* 매출 관리
================================================================= */

	function sales_lists($limit,$page,$st,$sc) {

		$sel = "m_plan.plan_no, m_plan.member_id as member_id, m_plan.amount, m_plan.chayoung, m_plan.order_code, g5_member.mb_office, g5_member.mb_level, m_plan.buy_type, m_plan.pay, m_plan.regdate, m_plan.is_approval, g5_member.mb_name";
		$this->db->select($sel);
		$this->db->from('m_plan');
		$this->db->join('g5_member', 'm_plan.member_id = g5_member.mb_id');
		
		if($sc) {
			$this->db->like($st,$sc);
		}
		$this->db->limit($limit,$page);

		$this->db->order_by('plan_no','desc');

		$query = $this->db->get();
		$item['lists'] = $query->result();
		
		
		//검색용
		$this->db->select($sel);
		$this->db->from('m_plan');
		$this->db->join('m_member', 'm_plan.member_id = m_member.member_id');
		
		if($sc) {
			$this->db->like($st,$sc);
		}
		$query = $this->db->get();
		$item['lists_total'] = $query->num_rows();
		
		return $item;
	}
	

	function sales_profitedit($idx) {
	
		$query = array(
			'regdate' => $this->input->post('regdate'),
			'is_give' => $this->input->post('is_give'),
			'is_approval' => $this->input->post('is_approval'),
			'amount' => $this->input->post('amount'),
			'pay' => $this->input->post('payment'),
			'chayoung' => $this->input->post('chayoung'),
		);

		$this->db->where('plan_no', $idx);
		$this->db->update('m_plan', $query);
	}

	// 매출 자료중 지출 포인트 수정
	function sales_beneedit($idx) {
		$query = array(
			'point' => $this->input->post('point'),
			'regdate' => $this->input->post('regdate'),
			'memo' => "Admin Edit",
		);
		$this->db->where('point_no', $idx);
		$this->db->update('m_point', $query);
	}


/* =================================================================
* 검색 관리
================================================================= */

	//총 게시물수 가져오기
	function get_total($table_id,$where,$clm,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		//게시물 TOTAL 수
		$this->db->from($table_id);
		if ($where != NULL) {
			
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where($where2,$clm2);
		}
		if ($where3 != NULL) {
			$this->db->where($where3,$clm3);
		}
		
		if ($where4 != NULL) {
			$this->db->where($where4,$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		$item =  $this->db->count_all_results();
		return $item;
	}


	//게시물 리스트 가져오기
	function get_lists($table,$limit,$page,$order_by,$where,$clm,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->join('m_member', 'member_id = member_id','left');
		$this->db->limit($limit,$page);
		if ($where != NULL) {
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where($where2,$clm2);
		}
		if ($where3 != NULL) {
			$this->db->where($where3,$clm3);
		}
		
		if ($where4 != NULL) {
			$this->db->where($where4,$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		
		$this->db->order_by($order_by,'desc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;


	}


	//검색 리스트 가져오기
	function get_sc_lists($table,$limit,$page,$order_by,$st,$sc,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		$sc = urldecode($sc);
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->join('m_member', $table.'.member_id = m_member.member_id','inner');
		$this->db->where($st,$sc);

		if ($where != NULL) {
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where($where2,$clm2);
		}
		if ($where3 != NULL) {
			$this->db->where($where3,$clm3);
		}
		
		if ($where4 != NULL) {
			$this->db->where($where4,$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		
		
		$this->db->order_by($order_by,'desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}

	function get_search_lists($table,$limit,$page,$order_by,$st,$sc,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		$sc = urldecode($sc);
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->join('m_member', $table.'.member_id = m_member.member_id','inner');
		$this->db->where($st,$sc);

		if ($where != NULL) {
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where("'$where2'>='$clm2'");
		}
		if ($where3 != NULL) {
			$this->db->where("'$where3'<='$clm3'");
		}
		
		if ($where4 != NULL) {
			$this->db->where($where4,$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		
		
		$this->db->order_by($order_by,'desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}

	//검색시 총 게시물수 가져오기
	function get_sc_total($table,$limit,$page,$order_by,$st,$sc,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		$sc = urldecode($sc);
		$this->db->select('*');
		$this->db->from($table);
		$this->db->like($st,$sc);

		
		if ($where != NULL) {
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where($where2,$clm2);
		}
		if ($where3 != NULL) {
			$this->db->where($where3,$clm3);
		}
		
		if ($where4 != NULL) {
			$this->db->where($where4,$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		
		
		$this->db->order_by($order_by,'desc');
		$item = $this->db->count_all_results();
		return $item;
	}


	function get_search_total($table,$limit,$page,$order_by,$st,$sc,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		$sc = urldecode($sc);
		$this->db->select('*');
		$this->db->from($table);
		$this->db->like($st,$sc);

		
		if ($where != NULL) {
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where("'$where2'>='$clm2'");
		}
		if ($where3 != NULL) {
			$this->db->where("'$where3'>='$clm3'");
		}
		
		if ($where4 != NULL) {
			$this->db->where($where4,$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		
		
		$this->db->order_by($order_by,'desc');
		$item = $this->db->count_all_results();
		return $item;
	}


	function get_total_allowance($table,$where,$clm,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		//게시물 TOTAL 수
		$this->db->select('A.kind, SUM(A.point) AS point, A.regdate, A.member_id, A.cate, B.btc_usd, B.btc_won, B.usd_won');
		$this->db->from($table);
		$this->db->join('m_deadline AS B', 'A.order_code = B.order_code','left');
		$this->db->group_by("A.kind, A.regdate, A.member_id, A.cate, B.btc_usd, B.btc_won, B.usd_won");
		//$this->db->join('m_member', 'member_id = member_id','left');
		if ($where != NULL) {
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where($where2,$clm2);
		}
		if ($where3 != NULL) {
			$this->db->where($where3,$clm3);
		}
		
		if ($where4 != NULL) {
			$this->db->where($where4,$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}

		$this->db->where("A.office <> 'surplus'");

		$query = $this->db->get();
		$item = $query->result();
		return COUNT($item);
	}


	//게시물 리스트 가져오기
	function get_lists_allowance($table,$limit,$page,$order_by,$where,$clm,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		$this->db->select('A.kind, SUM(A.point) AS point, A.regdate, A.member_id, A.cate, B.btc_usd, B.btc_won, B.usd_won');
		$this->db->from($table);
		$this->db->join('m_deadline AS B', 'A.order_code = B.order_code','left');
		$this->db->group_by("A.kind, A.regdate, A.member_id, A.cate, B.btc_usd, B.btc_won, B.usd_won");
		//$this->db->join('m_member', 'member_id = member_id','left');
		$this->db->limit($limit,$page);
		if ($where != NULL) {
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where($where2,$clm2);
		}
		if ($where3 != NULL) {
			$this->db->where($where3,$clm3);
		}
		
		if ($where4 != NULL) {
			$this->db->where($where4,$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		
		$this->db->where("A.office <> 'surplus'");

		$this->db->order_by($order_by,'desc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}

	function get_lists_allowance_detail($member_id, $kind, $regdate) {
		$this->db->select('A.kind, A.point, A.regdate, A.member_id, A.cate, A.event_id, B.btc_usd, B.btc_won, B.usd_won');
		$this->db->from("m_point_su A");
		$this->db->join('m_deadline AS B', 'A.order_code = B.order_code','left');

		$this->db->where("A.member_id",$member_id);
		$this->db->where("A.cate","su");
		$this->db->where("A.kind",$kind);
		$this->db->where("A.regdate",'20' . $regdate . ' 23:59:59');
		
		$this->db->where("A.office <> 'surplus'");

		$this->db->order_by("A.point_no",'desc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}

	//검색 리스트 가져오기 (수당)
	function get_sc_lists_allowance($table,$limit,$page,$order_by,$st,$sc,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		$sc = urldecode($sc);
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->join('m_member', $table.'.member_id = m_member.member_id','inner');
		$this->db->like($st,$sc);

		if ($where != NULL) {
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where($where2,$clm2);
		}
		if ($where3 != NULL) {
			$this->db->where($where3,$clm3);
		}
		
		if ($where4 != NULL) {
			$this->db->where($where4,$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		
		$this->db->where("A.office <> 'surplus'");
		
		$this->db->order_by($order_by,'desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}

	//검색시 총 게시물수 가져오기 (수당)
	function get_sc_total_allowance($table,$limit,$page,$order_by,$st,$sc,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		$sc = urldecode($sc);
		$this->db->select('*');
		$this->db->from($table);
		$this->db->like($st,$sc);

		
		if ($where != NULL) {
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where($where2,$clm2);
		}
		if ($where3 != NULL) {
			$this->db->where($where3,$clm3);
		}
		
		if ($where4 != NULL) {
			$this->db->where($where4,$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		
		$this->db->where("A.office <> 'surplus'");
		
		$this->db->order_by($order_by,'desc');
		$item = $this->db->count_all_results();
		return $item;
	}






		// 2020.09.03 박종훈 추가
		function get_scdate_lists($table,$limit,$page,$order_by,$st=NULL,$sc=NULL,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
			$sc = urldecode($sc);
			$this->db->select('*');
			$this->db->from($table);

			if ($where != NULL) {
				$this->db->like($st,$sc);
			}
			if ($where != NULL) {
				$this->db->where($where,$clm);
			}
			if ($where2 != NULL) {
				$this->db->where($where2,$clm2);
			}
			if ($where3 != NULL) {
				$this->db->where("left(date_add(".$where3.",interval +9 HOUR),10)>=",$clm3);
			}
			
			if ($where4 != NULL) {
        $this->db->where("left(date_add(".$where4.",interval +9 HOUR),10)<=",$clm4);
			}
			
			if ($where5 != NULL) {
				$this->db->where($where5,$clm5);
			}
			
			
			$this->db->order_by($order_by,'desc');
			$this->db->limit($limit,$page);
			$query = $this->db->get();
			$item = $query->result();
			return $item;
		}
	//검색시 총 게시물수 가져오기
	function get_scdate_total($table,$limit,$page,$order_by,$st,$sc,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		//게시물 TOTAL 수
		$this->db->from($table);
		if ($where != NULL) {
			$this->db->like($st,$sc);
		}
		if ($where != NULL) {
			
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where($where2,$clm2);
		}
		if ($where3 != NULL) {
			$this->db->where("left(date_add(".$where3.",interval +9 HOUR),10)>=",$clm3);
		}
		
		if ($where4 != NULL) {
			$this->db->where("left(date_add(".$where4.",interval +9 HOUR),10)<=",$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		$item =  $this->db->count_all_results();
		return $item;
	}
	function get_total_date($table_id,$where,$clm,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		//게시물 TOTAL 수
		$this->db->from($table_id);
		if ($where != NULL) {
			
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where($where2,$clm2);
		}
		if ($where3 != NULL) {
			$this->db->where("left(".$where3.",10)>=",$clm3);
		}
		
		if ($where4 != NULL) {
			$this->db->where("left(".$where4.",10)<=",$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		$item =  $this->db->count_all_results();
		return $item;
	}
}

?>
