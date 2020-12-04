<?php
class M_office extends CI_Model {

/* ======================================================*/
/* 플랜 정보가져오기
/* ======================================================*/
	
	// 플랜정보 가져오기
	function get_plan($id) {
		$this->db->select('*');
		$this->db->from('m_plan');
		$this->db->where('member_id',$id);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	// 플랜 정보 가져오기 (idx)
	function get_plan_no($id) {
		$this->db->select('*');
		$this->db->from('m_plan');
		$this->db->where('plan_no',$id);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	// 마지막 구매 정보 가져오기 (날짜로 찾기)
	function get_last_plan($id,$regdate=NULL) {		
		$this->db->select('*');
		$this->db->from('m_plan');
		$this->db->where('member_id',$id);
		
		// 등록일 값이 있다면
		if ($regdate) {
			$this->db->where('regdate <= ',$regdate);
		}
		
		$this->db->order_by("regdate", "desc");		
		$query = $this->db->get();
		$item = $query->row();           
        return $item;
	}
	
/* ======================================================*/
/* 플랜 정보가져오기
/* ======================================================*/
	
	function get_plan_li($id=NULL) {
		$this->db->select('*');
		$this->db->from('m_plan');
		
		if($id != NULL){
			$this->db->where('member_id',$id);			
		}
		
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_plan_parents($id) {
		$this->db->select('*');
		$this->db->from('m_plan');
		$this->db->where('parents_id',$id);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	// 오더코드로 가져오기
	function get_plan_code($order_code) {
		$this->db->select('*');
		$this->db->from('m_plan');
		$this->db->where('order_code',$order_code);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
/* ======================================================*/
/* 가져오기
/* ======================================================*/
	
	// 부모아이디 가져오기
	function get_plan_parents_id($id) {
		$this->db->select('parents_id');
		$this->db->from('m_plan');
		$this->db->where('member_id',$id);
		$query = $this->db->get();
		$item = $query->row();
		return $item->parents_id;
	}
	
	// 회원아이디로 플랜 매출값 가져오기
	function get_plan_amount($id) {
		$this->db->select('amount');
		$this->db->from('m_plan');
		$this->db->where('member_id',$id);
		$query = $this->db->get();
		$item = $query->row();
		return $item->amount;
	}	
	
	// 회원으로 플랜 분신인지 인정인지 가져오기
	function get_plan_cate($id) {
		$this->db->select('cate');
		$this->db->from('m_plan');
		$this->db->where('member_id',$id);
		$query = $this->db->get();
		$item = $query->row();
		return $item->cate;
	}
	
	// 마지막 등록한 코드 숫자 찾기 - 부모아이디로 찾기
	function get_plan_kind($id) {
		$this->db->select('kind');
		$this->db->from('m_plan');
		$this->db->where('parents_id',$id);
		$this->db->order_by("plan_no", "desc");	
		$query = $this->db->get();
		$item = $query->row();
		return $item->kind;
	}
	
	function get_plan_dep($id) {
		$this->db->select('dep');
		$this->db->from('m_plan');
		$this->db->where('member_id',$id);
		$this->db->order_by("plan_no", "asc");	
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	function get_plan_sync($id) {
		$this->db->select('sync');
		$this->db->from('m_plan');
		$this->db->where('member_id',$id);
		$this->db->order_by("plan_no", "asc");	
		$query = $this->db->get();
		$item = $query->row();
		return $item->sync;
	}
	
/* =================================================================
* 체크 및 숫자
================================================================= */

	// 후원횟수
	function get_sponsor_chk($id) {
		$this->db->select('*');
		$this->db->from('m_plan');
		$this->db->where('sponsor_id',$id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}

	// 플랜 등록 여부 확인
	function plan_in_chk($id) {
		$this->db->select('*');
		$this->db->from('m_plan');
		$this->db->where('member_id',$id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}

	// 부모코드 및 분신 등록코드 수 확인
	function plan_parents_chk($id) {
		$this->db->select('*');
		$this->db->from('m_plan');
		$this->db->where('parents_id',$id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}	
	
	// 후원인 직대 몇명있는지 확인
	function plan_sp_chk($id) {
		$this->db->select('*');
		$this->db->from('m_plan');
		$this->db->where('sponsor_id',$id);
		$this->db->order_by("dep", "asc");
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 후원 볼륨 좌우 확인 하기
	function get_sp_side($target,$id) {
		$this->db->select('*');
		$this->db->from('m_plan');
		$this->db->where('sponsor_id',$target);
		$this->db->order_by("plan_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		
		$count = 0;		
		$side = 0;
		foreach ($item as $row) {		
			$count = $count + 1; // 플랜에 없으면 1인된다		
			if ($row->member_id == $id) {		
				$side = $count;
			}
		}		
		return $side;
	}
	
	
	function plan_sponsor_li($member_id) {
		$this->db->select('*');
		$this->db->from('m_plan');
		$this->db->where('sponsor_id',$member_id);
		$query = $this->db->get();
		$item = $query->result();

		return $item;
	}
	
	function plan_recommend_li($member_id) {
		$this->db->select('*');
		$this->db->from('m_plan');
		$this->db->where('recommend_id',$member_id);
		$query = $this->db->get();
		$item = $query->result();

		return $item;
	}
	
	function plan_recommend_last($member_id) {
		$this->db->select('member_id');
		$this->db->from('m_plan');
		$this->db->where('recommend_id',$member_id);
		$this->db->order_by("plan_no", "desc");
		$query = $this->db->get();
		$item = $query->row();
		return $item->member_id;
	}
/* ======================================================*/
/* 플랜등록
/* ======================================================*/
	// 플랜 등록
	function plan_in($order_code, $office_group, $office, $name, $member_id, $coin_id, $recommend_id, $sponsor_id, $dep, $amount, $cate, $kind, $top_id, $regdate=NULL) {
		
		$regdate = nowdate();

		$query = array(
			'order_code' 	=>$order_code,
			'office_group' 	=>$office_group,
			'office' 		=>$office,
			'name' 			=>$name,
			'member_id' 	=> $member_id,
			'parents_id' 	=> $coin_id,
			
			'recommend_id' 	=> $recommend_id,
			'sponsor_id' 	=> $sponsor_id,
			
			'amount' 		=> $amount,
			'dep' 			=> $dep,
			'cate' 			=> $cate,
			'kind' 			=> $kind,
			'top_id' 		=> $top_id,
			'regdate' 		=> $regdate,
		);

		$this->db->insert('m_plan', $query);
	}
	
	// 직산하 증가
	function plan_sync_up($member_id,$sync) {

		$query = array(
			'sync' => $sync,
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_plan', $query);
	}
	
	// 직산하 증가
	function plan_sponsor_up($member_id,$sponsor_id,$dep) {

		$query = array(
			'sponsor_id' => $sponsor_id,
			'dep' => $dep,
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_plan', $query);
	}
	
	function plan_dep_up($member_id,$dep) {

		$query = array(
			'dep' => $dep,
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_plan', $query);
	}
	
	function plan_sp($member_id,$sponsor_id) {

		$query = array(
			'sponsor_id' => $sponsor_id
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_plan', $query);
	}
	function plan_re($member_id,$recommend_id) {

		$query = array(
			'recommend_id' => $recommend_id
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_plan', $query);
	}
/* ======================================================*/
/* 볼륨 관련                                               */
/* ======================================================*/
	
	function get_vlm_li($table,$member_id=NULL) {
		$this->db->select('*');
		$this->db->from($table);
		
		if($member_id != NULL){
			$this->db->where('member_id',$member_id);			
		}
		
		$this->db->order_by("vlm_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_vlm_desc($table,$member_id=NULL) {
		$this->db->select('*');
		$this->db->from($table);
		
		if($member_id != NULL){
			$this->db->where('member_id',$member_id);			
		}
		
		$this->db->order_by("vlm_no", "desc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	// 볼륨 가져오기 - 이벤트를 중심으로 쭉 위로 가져온다.
	function get_vlm_up($table,$id) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('event_id',$id);
		$this->db->where('side !=','middle');
		
		$this->db->order_by("vlm_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_vlm_ev($table,$id) {
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->where('event_id',$id);
		$this->db->where('side !=','middle');		
		$this->db->order_by("vlm_no", "desc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	// 나의 볼륨리스트 가져오기 - 낮음차순
	function get_vlm_my($table,$id,$side=NULL) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('member_id',$id);

		if($side){
			$this->db->where('side',$side);			
		}
		
		$this->db->order_by("vlm_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	
	// 나의 후원인 정보가져오기
	function get_vlm_sponsor($table,$id,$event_id) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('member_id',$id);
		$this->db->where('event_id',$event_id);
		$this->db->order_by("vlm_no", "asc");
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	function get_vlm_line($table,$id) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		//$this->db->where('side',$side);
		$this->db->order_by("vlm_no", "desc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_vlm_line_dep($table,$id,$side) {
		$this->db->select('event_id');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		$this->db->where('side',$side);
		$this->db->order_by("dep", "desc");
		$query = $this->db->get();
		$item = $query->row();
		return $item->event_id;
	}
	
	
	function get_vlm_side_count($table,$id,$side) 
	{
		$CI =& get_instance();
		
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		$this->db->where('side',$side);
		$this->db->order_by("vlm_no", "desc");
		$query = $this->db->get();
		$item = $query->result();
		
		$count 	= 0;
		foreach ($item as $row) 
		{			
			if ($id != $row->event_id) 
			{
				$re_id = $CI->m_member->get_member_recommend($row->event_id);
				if($id == $re_id){
					// 매출친 여부 체크하기
					//$purCount = $CI->m_point->point_puchase_count($row->event_id);
					$purCount = $CI->m_point->point_puchase_cnt($row->event_id);
					if($purCount > 0)
					{
						$count += 1;
					}
				}
			}
			
		}
		
		return $count;
	}
	
	function get_vlm_side_date($table,$id,$side) 
	{
		$CI =& get_instance();
		
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		$this->db->where('side',$side);
		$this->db->order_by("vlm_no", "desc");
		$query = $this->db->get();
		$item = $query->result();
		
		$count 	= 0;
		$side 	= 0;
		$date 	= '';
		foreach ($item as $row) 
		{			
			if ($id != $row->event_id) 
			{
				$re_id = $CI->m_member->get_member_recommend($row->event_id);
				if($id == $re_id){
					
					$purCount = $CI->m_point->point_puchase_count($row->event_id);
					if(empty($purCount)){$purCount = 0;}
					//echo "$row->event_id == $purCount ->  <br>";
					
					if($purCount > 0)
					{
						//$purDate = $CI->m_point->point_purchase_regdate($row->event_id);
						
						if($id == 'questc'){
							//echo "--> $row->event_id == $purCount // $purDate <br>";							
						}
						
						//$date = $purDate;
						//break;						
					}
				}
			}
			
		}
		
		return $date;
	}
	
	function get_vlm_side_datetime($table,$id,$side) 
	{
		$CI =& get_instance();
		
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		$this->db->where('side',$side);
		$this->db->order_by("vlm_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		
		$count 	= 0;
		$side 	= 0;
		$date 	= '';
		foreach ($item as $row) 
		{			
			if ($id != $row->event_id) 
			{
				$re_id = $CI->m_member->get_member_recommend($row->event_id);
				if($id == $re_id){
					
					$purCount = $CI->m_point->point_puchase_full_count($row->event_id);
					if(empty($purCount)){$purCount = 0;}
					//echo "$id ---> $row->event_id == $purCount ->  <br>";
					
					if($purCount > 0)
					{
						$purDate = $CI->m_point->point_purchase_regdate($row->event_id);
						
						//if($id == 'questc'){
							//echo "--> $row->event_id == $purCount // $purDate <br>";							
						//}
						
						$date = $purDate;
						break;						
					}
				}
			}
			
		}
		
		return $date;
	}
/* ======================================================*/
/* 볼륨 입력                                               */
/* ======================================================*/
	
	// 볼륨 등록 - $dep 넣는 이유는 동일한 깊이의 좌우를 비교하여서 매칭을 구하기 위해서 필요 (전체 좌우 매칭이 아니라 동일한 선상에서의 좌우 매칭구할 경우 대비)
	function vlm_in($table, $order_code, $name, $member_id, $event_id, $top_id, $side, $dep, $point, $regdate=NULL, $is_off=NULL)
	{
		// 등록일 값이 없다면
		if ($regdate == NULL) {
			$regdate = nowdate();
		}
		
		// 롤업수당 반영안한거 표시하기
		if ($is_off == NULL) {
			$is_off = 0;
		}
		
		$query = array(
			'order_code' 	=> $order_code,
			'plan' 			=> $name,
			'member_id' 	=> strtolower($member_id),
			'event_id' 		=> strtolower($event_id),
						
			'sponsor_id' 	=> $top_id,
			
			'side' 			=> $side,
			'point' 		=> $point,
			'dep' 			=> $dep,
			'regdate' 		=> $regdate,
			'is_off' 		=> $is_off,
		);
		$this->db->insert($table, $query);
	}

	function vlm_update($vlm_no,$vlm_sponsor_no,$vlm_dep) {		

		$query = array(
			'sponsor_no' 	=> $vlm_sponsor_no,
			'dep' 			=> $vlm_dep,
		);
		$this->db->where('vlm_no', $vlm_no);
		$this->db->update('m_volume', $query);
	}
	
	
/* ======================================================*/
/* 볼륨 수량
/* ======================================================*/
	
	function vlm_my_chk($table,$id) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('member_id',$id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	function vlm_ev_chk($table,$id) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('event_id',$id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 볼륨 등록여부 체크하기
	function vlm_chk($table,$id) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('member_id','admin');
		$this->db->where('event_id',$id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 나의 산하 숫자 가져오기 - 특정인까지
	function get_vlm_my_count($table,$id,$event_id) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		$this->db->where('event_id',$event_id);
		$this->db->order_by("vlm_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		
		$count = 1;
		foreach ($item as $row) {
			if ($event_id == $row->event_id) {
				break;
			}
			$count = $count + 1;
		}
		return $count;
	}
	
	// 볼륨 가져오기 - 좌우 숫자 구하기
	function get_vlm_count($table,$id) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		$this->db->order_by("vlm_no", "asc");
		$query = $this->db->get();
		$item = $query->result();

		$vlm_left = 0;
		$vlm_right = 0;
		$vlm_so = '';
		
		foreach ($item as $row) 
		{
			if ($row->side == 'left') {
				$vlm_left = $vlm_left + 1;
			}
			if ($row->side == 'right') {
				$vlm_right = $vlm_right + 1;
			}				
		} 
		
		// 어디가 소실적인지
		if($vlm_left <= $vlm_right){
			$vlm_so = 'left';
		}else{
			$vlm_so = 'right';
		}
		
		$vlm['vlm_so'] 		= $vlm_so;
		$vlm['vlm_left'] 	= $vlm_left;
		$vlm['vlm_right'] 	= $vlm_right;
		$vlm['vlm_total'] 	= $vlm_left + $vlm_right;
				
		return $vlm;

	}
	
	function get_my_side($table,$id) {
		$this->db->select('side');
		$this->db->from($table);
		$this->db->where('member_id',$id);
		$this->db->where('event_id !=',$id);
		//$this->db->where('point =',$cnt);
		$query = $this->db->get();
		$item = $query->row();		
		return $item->side;
	}
	
	function get_my_count($table,$id) {
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		$this->db->where('point >',0);
		$this->db->order_by("vlm_no", "asc");
		$query = $this->db->get();
		$item = $query->result();

		$vlm_left = 0;
		$vlm_right = 0;
		$vlm_so = '';

		foreach ($item as $row) 
		{
			if ($row->side == 'left') {
				$vlm_left = $vlm_left + 1;
			}
			if ($row->side == 'right') {
				$vlm_right = $vlm_right + 1;
			}				
		} 
		
		// 어디가 소실적인지
		if($vlm_left <= $vlm_right){
			$vlm_so = 'left';
		}else{
			$vlm_so = 'right';
		}
		
		$vlm['vlm_so'] 		= $vlm_so;
		$vlm['vlm_left'] 	= $vlm_left;
		$vlm['vlm_right'] 	= $vlm_right;
				
		return $vlm;

	}
	
/* ======================================================*/
/* 볼륨 가져오기
/* ======================================================*/

	// 나의 볼륨리스트에서 소실적 가져오기
	function get_vlm_my_so($table,$id,$side) {
		
		$CI =& get_instance();
		
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where('member_id',$id);
		$this->db->where('side',$side);
		
		$this->db->order_by("dep", "asc");
		//$this->db->order_by("vlm_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
	
		// 깊이순으로 정렬하여 순차적으로 처리
		$sp_id = "";
		$chkIn = 'n';
		foreach ($item as $row) 
		{			
			if ($id != $row->event_id) 
			{
				if($row->event_id == '')
				{
					$sp_id = 'admin';
					break;
				}
				else
				{
					// 플랜테이블에서 이벤트아이디를 후원인으로 둔 회원 수 구하기
					$pl = $CI->m_office->plan_sp_chk($row->event_id); 
					if(empty($pl)){	
						//echo "@@@@@ $row->event_id // <br>";
						$sp_id = $row->event_id;
						break;						
					}
					else if($pl == 1)
					{
						//echo "///$pl-- $row->event_id <br>";
						
						// 산하 직대로 내 추천인이 있는지 확인하기 있으면 다음을 찾는다. - 내 추천인 이지만 산하에 아무도 없을 경우에는 붙여준다.
						$splist = $CI->m_office->plan_sponsor_li($row->event_id);
						foreach ($splist as $sanha) 
						{
							$chkIn = 'n';
							$relist = $CI->m_office->plan_recommend_li($id);
							foreach ($relist as $myre)
							{
								if($sanha->member_id != $myre->member_id){
									$chkIn = 'y';
									//echo "$chkIn--> $row->event_id //  $sanha->member_id != $myre->member_id<br>";
								}
								else{
									$chkIn = 'n';
									break;
									//echo "$chkIn==> $row->event_id //  $sanha->member_id != $myre->member_id<br>";									
								}								
							}
						}
							
						if($chkIn == 'y'){	
							//echo "%%% $row->event_id //  $sanha->member_id != $myre->member_id /// $chkIn<br>";
							$sp_id = $row->event_id;
							break;
								
						}		
					}				
				}
			}
		} //end for
		
		return $sp_id;
	}
	
	
	
	
/* ======================================================*/
/* 기타 볼륨 정보 관련.                                      */
/* ======================================================*/
	
	//매출이 좌우측 어디에서 올라온지 확인
	function get_side_up($member_id,$in_user){
		$this->db->select('side');
		$this->db->from('m_volume');
		$this->db->where('member_id',$member_id);
		$this->db->where('event_id',$in_user);
		//$this->db->where('point >',0);	
		$this->db->order_by("vlm_no", "asc");
		$query = $this->db->get();
		$item = $query->row();	
		return $item->side;
	}
	
	// 볼륨 가져오기 - 매출도 가져오기-------------------------------------
	function get_vlm_date($id,$end) {

		$CI =& get_instance();
		
		$this->db->select('*');
		$this->db->from('m_volume');		
		$this->db->where('member_id',$id);	
		//$this->db->where('regdate <=',$end);	
		$this->db->order_by("regdate", "asc");
		$query = $this->db->get();
		$item = $query->result();

		$vlm_left 			= 0;
		$vlm_left_point 	= 0;
		$vlm_right 			= 0;
		$vlm_right_point 	= 0;

		foreach ($item as $row) {		
			if ($id != $row->event_id) 
			{			
				$sale = $CI->m_point->point_puchase_total_date($row->event_id,$end);
				//echo "== $row->event_id,$sale ==<br>";
				
				if(empty($sale)){$sale = 0;}	
				
				if ($row->side == 'left') {
					$vlm_left = $vlm_left + 1;
					$vlm_left_point = $vlm_left_point + $sale;	
				}
				else if ($row->side == 'right') {
					$vlm_right = $vlm_right + 1;		
					$vlm_right_point = $vlm_right_point + $sale;
				}	
			}				
		} //end for
		
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
	function get_vlm($id) {

		$CI =& get_instance();
		
		$this->db->select('*');
		$this->db->from('m_volume');
		
		$this->db->where('member_id',$id);		
		$this->db->order_by("regdate", "desc");
		$query = $this->db->get();
		$item = $query->result();

		$vlm_left 			= 0;
		$vlm_left_point 	= 0;
		$vlm_right 			= 0;
		$vlm_right_point 	= 0;

		foreach ($item as $row) {		
			if ($id != $row->event_id) 
			{			
				$sale = $CI->m_point->point_puchase_total($row->event_id);
				if(empty($sale)){$sale = 0;}	
				
				if ($row->side == 'left') {
					$vlm_left = $vlm_left + 1;
					$vlm_left_point = $vlm_left_point + $sale;	
				}

				if ($row->side == 'right') {
					$vlm_right = $vlm_right + 1;		
					$vlm_right_point = $vlm_right_point + $sale;
				}	
			}				
		} //end for
		
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
	
	// 볼륨 가져오기 - 매출도 가져오기-------------------------------------
	function get_vlm1($id,$regdate) {

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
				$sale = $CI->m_point->point_purchase_date($row->event_id,$regdate);
				if(empty($sale)){$sale = 0;}	
				
				if ($row->side == 'left') {
					$vlm_left = $vlm_left + 1;
					$vlm_left_point = $vlm_left_point + $sale;	
				}

				if ($row->side == 'right') {
					$vlm_right = $vlm_right + 1;		
					$vlm_right_point = $vlm_right_point + $sale;
				}
				//echo "$id==$row->event_id======$regdate=========  $row->side = $vlm_right_point // $vlm_left_point =========$sale //<br>";	
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
	
	
	
	
	
	function member_vlm_up($id,$vlm_so,$vlm_left,$vlm_right,$vlm_left_point,$vlm_right_point) {		

		$query = array(
			'vlm_so' 			=> $vlm_so,
			'vlm_left' 			=> $vlm_left,
			'vlm_right' 		=> $vlm_right,
			'vlm_left_point' 	=> $vlm_left_point,
			'vlm_right_point' 	=> $vlm_right_point,
		);
		$this->db->where('member_id', $id);
		$this->db->update('m_member', $query);
	}
		
	// 볼륨 가져오기 - 소실적 구하기
	function get_vlm_row($id) {
		
		$vlm = $this->get_vlm_sub($id,'');		
	
		// 좌우 금액 가공
		if ($vlm['vlm_left'] >= $vlm['vlm_right']) {
			$vlm['vlm_left'] = $vlm['vlm_left'] - $vlm['vlm_right'];
			$vlm['vlm_right'] = $vlm['vlm_right'] - $vlm['vlm_right'];
		} else {
			$vlm['vlm_right'] = $vlm['vlm_right'] - $vlm['vlm_left'];
			$vlm['vlm_left'] = $vlm['vlm_left'] - $vlm['vlm_left'];
		}
			
		return $vlm;
		
	}
	

	// 볼륨 가져오기 - 좌우금액 가져오기
	function get_vlm_max($id) {		
		$vlm = $this->get_vlm_sub($id,'');	
		return $vlm;
	}
	
	
	//해당 뎁스에 몇몇이 있는지 확인
	function get_line_left($id,$event_id,$regdate=NULL) {
		
		$get_account = $this->m_member->get_member($event_id);
		$dep = $get_account->dep;
		
		$this->db->select('*');
		$this->db->from('m_volume');
		$this->db->join('m_member', 'm_volume.event_id = m_plan.member_id', 'left');
		$this->db->where('m_volume.member_id',$id);
		$this->db->where('m_volume.event_id !=',$event_id);
		$this->db->where('m_volume.side','left');
		//$this->db->where('m_plan.dep',$dep); // 해당 깊이에 몇명구하기
		
		if($regdate) {			
			$today = substr($regdate,0,10);
			$this->db->where('m_volume.regdate >=',$today.' 00:00:01');
			$this->db->where('m_volume.regdate <=',$today.' 23:59:59');
		}
		
		$this->db->order_by("vlm_no", "asc");
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	
	//해당 뎁스에 몇몇이 있는지 확인
	function get_line_right($id,$event_id,$regdate=NULL) {
		
		$get_account = $this->m_member->get_member($event_id);
		$dep = $get_account->dep;
		
		$this->db->select('*');
		$this->db->from('m_volume');
		$this->db->join('m_member', 'm_volume.event_id = m_member.member_id', 'left');
		$this->db->where('m_volume.member_id',$id);
		$this->db->where('m_volume.event_id !=',$event_id);
		$this->db->where('m_volume.side','right');
		//$this->db->where('m_plan.dep',$dep); // 해당 깊이에 몇명구하기
		
		if($regdate) {			
			$today = substr($regdate,0,10);
			$this->db->where('m_volume.regdate >=',$today.' 00:00:01');
			$this->db->where('m_volume.regdate <=',$today.' 23:59:59');
		}
		
		$this->db->order_by("vlm_no", "asc");
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}


/* ======================================================*/
/* 볼륨 좌우 구하기                                          */
/* ======================================================*/	
	
	// 전체 좌우 금액 구하기
	function get_vlm_sub($id) {

		$this->db->select('*');
		$this->db->from('m_volume');
		$this->db->where('member_id',$id);
		$this->db->where('is_off','0');
		$this->db->order_by("regdate", "desc");
		$query = $this->db->get();
		$item = $query->result();

		$vlm_left = 0;
		$vlm_right = 0;

		foreach ($item as $row) {		

			if ($row->side == 'left') {
				$vlm_left = $row->point + $vlm_left;
			}

			if ($row->side == 'right') {
				$vlm_right = $row->point + $vlm_right;
			}	
				
		} //end for
		
		$vlm['vlm_left'] = $vlm_left;
		$vlm['vlm_right'] = $vlm_right;
		
		return $vlm;

	}
	
	
	// 오늘의 좌우 금액 구하기
	function get_vlm_today($id,$start,$end) {
	
		$this->db->select('*');
		$this->db->from('m_volume');
		$this->db->where('member_id',$id);
		$this->db->where('is_off','0');
		$this->db->where('regdate >=',$start);
		$this->db->where('regdate <=',$end);
		$this->db->order_by("regdate", "desc");
		$query = $this->db->get();
		$item = $query->result();

		$vlm_left = 0;
		$vlm_right = 0;

		foreach ($item as $row) {
			
			if ($row->side == 'left') {
				$vlm_left = $row->point + $vlm_left;
			}

			if ($row->side == 'right') {
				$vlm_right = $row->point + $vlm_right;
			}
				
		} //end for
		
		$vlm['vlm_left'] = $vlm_left;
		$vlm['vlm_right'] = $vlm_right;
		
		return $vlm;

	}

/* ======================================================*/
/*                  히스토리                             */
/* ======================================================*/

	// 매출 히스토리 가져오기
	function get_plan_his($id) {
		$this->db->select('*');
		$this->db->from('m_plan');
		$this->db->where('parents_id',$id);
		$this->db->order_by("regdate", "asc");
		//$this->db->limit(5);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	

	// 수당 히스토리 가져오기
	function get_per_his($id) {
		$this->db->select('*');
		$this->db->from('m_point');
		$this->db->where('member_id',$id);
		$this->db->where('type !=','hidden');
		$this->db->order_by("regdate", "desc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}


	// 트랜스퍼 히스토리 가져오기
	function get_trans_his($id,$type) {
		$this->db->select('*');
		$this->db->from('m_point');
		$this->db->where('member_id',$id);
		$this->db->where('cate','trade');
		$this->db->where('type','out');
		$this->db->where('kind','transfer');
		$this->db->order_by("regdate", "desc");
		$this->db->limit(30);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	

	// 환전 히스토리 가져오기
	function get_exchange_his($id) {
		$this->db->select('*');
		$this->db->from('m_point_uses');
		$this->db->where('member_id',$id);
		$this->db->where('kind','out');
		//$this->db->where('type','payment');
		$this->db->order_by("regdate", "desc");
		$this->db->limit(50);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	
	// 은행정보 업데이트
	function bank_up() {

		// 계좌번호 번호 가공
		$bank_num = $this->input->post('bank_number');
		$bank_num = explode('-',$bank_num); 
		$bank_num = $bank_num[0].@$bank_num[1].@$bank_num[2].@$bank_num[3];		
		
		$query = array(

		'bank_name' => strtolower($this->input->post('bank_name')),
		'bank_number' => $bank_num,
		'bank_holder' => strtolower($this->input->post('bank_holder')),
		'bank_code' => strtolower($this->input->post('bank_code')),
		);

		$this->db->where('member_id',$this->session->userdata('member_id'));
		$this->db->update('m_member', $query);
	}
	
	function get_day_lists($input) {

		$this->db->select('SQL_CALC_FOUND_ROWS 	x.member_id, x.regdate, IFNULL(sum(x.daySudang),0) DaySudang, 
		IFNULL(sum(x.reSudang),0) ReSudang, IFNULL(sum(x.re2Sudang),0) Re2Sudang, 
		IFNULL(sum(x.mcSudang),0) McSudang, IFNULL(sum(x.mc2Sudang),0) Mc2Sudang',false);
		$this->db->from('(SELECT member_id, 
														case
															when kind ="day" then sum(IFNULL(POINT,0)) 
														END daySudang,
														
														case
															when kind ="re" then sum(IFNULL(POINT,0))   
														END reSudang,
														
														case
															when kind ="re2" then sum(IFNULL(POINT,0))   
														END re2Sudang,
														
														case
															when kind ="mc" then sum(IFNULL(POINT,0))   
														END mcSudang,
														
														case
															when kind ="mc2" then sum(IFNULL(POINT,0)) 
														END mc2Sudang,
														
														LEFT(regdate,10) AS regdate
														FROM m_point_su
														WHERE member_id = "'.$input['login_id'].'"
														group by left(regdate, 10) , kind
														) x');
		$this->db->group_by('x.member_id, x.regdate');
		$this->db->order_by('x.regdate','desc');
		$this->db->limit($input["size"],$input['limit_ofset']);
		
		$result['page_list']= $this->db->get()->result();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return  $result;
	}

	
}
?>
