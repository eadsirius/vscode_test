<?
class M_member extends CI_Model 
{	
	
	// 센터 리스트 가져오기
	function get_country_li() {
		$this->db->select('*');
		$this->db->from('country');
		$this->db->order_by('list_order, country_name','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	function get_country_phone($phone_code) {
		$this->db->select('*');
		$this->db->from('country');
		$this->db->where('phone_code',$phone_code);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	function get_country_nick($country_nick) {
		$this->db->select('*');
		$this->db->from('country');
		$this->db->where('country_nick',$country_nick);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
/* =================================================================
* 가져오기
================================================================= */
// 아이디로 찾기
	function get_member_id($id){
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('member_id', $id);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	// 전체 회원리스트
	function get_member_li() {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->order_by('member_no','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_member_select_li($filed,$str) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where($filed,$str);
		$this->db->order_by('member_no','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	// 부모아이디 리스트
	function parent_li($member_id) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('member_id',$member_id);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}

	// 이름으로 회원 검색
	function get_name($name) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->like('name',$name);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}

/* =================================================================
* 가져오기
================================================================= */

	// 회원정보 가져오기
	function get_member($member_id, $filder='*') {
		$this->db->select($filder);
		$this->db->from('m_member');
		$this->db->where('member_id',$member_id);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	// 회원번호로 정보가져오기
	function get_member_idx($idx, $filder='*') {
		$this->db->select($filder);
		$this->db->from('m_member');
		$this->db->where('member_no',$idx);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	// 코인아이디로 정보 가져오기
	function get_id($coin_id, $filder='*') {
		$this->db->select($filder);
		$this->db->from('m_member');
		$this->db->where('coin_id',$coin_id);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}	
	
	
	// 휴대폰으로 회원검색
	function get_mobile($mobile) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('mobile',$mobile);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	// 추천 정보가져오기
	function getRecommendList($member_id) {
		$this->db->select('a.*,ifnull(sum(b.point),0) AS total_point,b.point,ifnull(b.regdate,"-") as sales_regdate');
		$this->db->from('m_member a');
    $this->db->join('m_point b','b.member_id = a.member_id','left');
		$this->db->where('recommend_id',$member_id);
    $this->db->group_by('a.member_id');
    $this->db->order_by('a.member_no desc, b.point_no');
		$query = $this->db->get();
		$item = $query->result();

		return $item;
	}
  
  // 추천 정보가져오기
	function get_recommend_li($member_id) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('recommend_id',$member_id);
		$query = $this->db->get();
		$item = $query->result();

		return $item;
	}
	
	// 추천인 정보가져오기
	function getRecommendTotalSales($member_id) {;
		$this->db->select('sum(b.point) as total_sales');
		$this->db->from('m_member a');
    $this->db->join('m_point b','b.member_id = a.member_id','left');
		$this->db->where('recommend_id',$member_id);
		$query = $this->db->get();
		$item = $query->row();

		return $item;
	}

	// 후원 정보가져오기
	function get_sponsor_li($member_id) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('sponsor_id',$member_id);
		$this->db->order_by("member_no", "asc");
		$query = $this->db->get();
		$item = $query->result();

		return $item;
	}
	
	// 후원 정보가져오기
	function get_sponsor($member_id) {;
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('sponsor_id',$member_id);
		$query = $this->db->get();
		$item = $query->row();

		return $item;
	}
	
	function get_sponsor_side($member_id,$side) {;
		$this->db->select('member_id');
		$this->db->from('m_member');
		$this->db->where('sponsor_id',$member_id);
		$this->db->where('biz',$side);
		$query = $this->db->get();
		$item = $query->row();
		
		if(empty($item)){
			return '';			
		}
		else{
			return $item->member_id;			
		}	
	}
	
	// 분신일 경우 부모아이디로 회원 검색
	function get_parents($parents_id) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('member_id',$parents_id);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}

/* =================================================================
* 단일 필드값 가져오기
================================================================= */

	// 회원검색 이름찾기
	function get_member_name($member_id) {
		$this->db->select('name');
		$this->db->from('m_member');
		$this->db->where('member_id',$member_id);
		$query = $this->db->get();
		$item = $query->row();		
		return $item->name;
	}
	
	function get_member_office($member_id) {
		$this->db->select('office');
		$this->db->from('m_member');
		$this->db->where('member_id',$member_id);
		$query = $this->db->get();
		$item = $query->row();		
		return $item->office;
	}
	
	function get_member_level($member_id) {
		$this->db->select('level');
		$this->db->from('m_balance');
		$this->db->where('member_id',$member_id);
		$query = $this->db->get();
		$item = $query->row();		
		return $item->level;
	}
	
	function get_member_no($member_id) {
		$this->db->select('member_no');
		$this->db->from('m_member');
		$this->db->where('member_id',$member_id);
		$query = $this->db->get();
		$item = $query->row();		
		return $item->member_no;
	}
	
	function get_member_recommend($member_id) {
		$this->db->select('recommend_id');
		$this->db->from('m_member');
		$this->db->where('member_id',$member_id);
		$query = $this->db->get();
		$item = $query->row();		
		return $item->recommend_id;
	}

	function get_member_free($member_id) {
		$this->db->select('is_free');
		$this->db->from('m_member');
		$this->db->where('member_id',$member_id);
		$query = $this->db->get();
		$item = $query->row();		
		return $item->is_free;
	}
/* =================================================================
* 체크 및 숫자
================================================================= */
	
	// 총 회원수
	function total_id_check() {
		$this->db->select('*');
		$this->db->from('m_member');
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 회원 아이디 검사 - 존재유무
	function id_check($id) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('member_id',$id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 휴대폰으로 회원체크
	function get_mobile_check($mobile) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('mobile',$mobile);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	function get_email_check($email) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('email',$email);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	function get_email_id($email) {
		$this->db->select('member_id');
		$this->db->from('m_member');
		$this->db->where('email',$email);
		$query = $this->db->get();
		$item = $query->row();		
		return $item->member_id;
	}
	function get_email_id_check($user_id,$email) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('email',$email);
		$this->db->where('member_id',$user_id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 추천횟수
	function get_recommend_chk($id) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('recommend_id',$id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}

	// 추천회원 수
	function re_check($id) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('recommend_id',$id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}

	// 추천회원 수
	function re_side_check($id,$side) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('recommend_id',$id);
		$this->db->where('biz',$side);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 가장 최근에 매출친 날짜를 가져와야한다.------------------------------------------
	function get_re_side_date($member_id) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('recommend_id',$member_id);
		$this->db->order_by("member_no", "asc");
		$query = $this->db->get();
		$item = $query->result();

		$side = 0;
		$count = 0;
		foreach ($item as $row) {		
			$count = $count + 1; // 플랜에 없으면 1인된다		
			if ($row->member_id == $id) {		
				$side = $count;
			}
		}		
		return $side;
	}
	// 가장 최근에 매출친 날짜를 가져와야한다.------------------------------------------
	
	// 레벨 숫자 가져오기
	function get_level_cnt($start,$end) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('level >=',$start);
		$this->db->where('level <=',$end);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 후원횟수
	function sp_check($id) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('sponsor_id',$id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	function samsam_check($id) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('recommend_id',$id);
		$this->db->where('sponsor_id',$id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 후원 좌우 횟수
	function sp_side_check($id,$side) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('sponsor_id',$id);
		$this->db->where('biz',$side);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 추천 볼륨 좌우 확인 하기
	function get_re_side($target,$id) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('recommend_id',$target);
		$this->db->order_by("member_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		
		$side = 0;
		$count = 0;
		foreach ($item as $row) {		
			$count = $count + 1; // 플랜에 없으면 1인된다		
			if ($row->member_id == $id) {		
				$side = $count;
			}
		}		
		return $side;
	}	
	
	// 볼륨 좌우 확인 하기
	function get_sp_side($target,$id) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('sponsor_id',$target);
		$this->db->order_by("member_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		
		$side = 0;
		$count = 0;	
		foreach ($item as $row) {		
			$count = $count + 1; // 플랜에 없으면 1인된다		
			if ($row->member_id == $id) {		
				$side = $count;
			}
		}		
		return $side;
	}
	
	// 후원 좌우 횟수
	function get_side($id) {
		$this->db->select('biz');
		$this->db->from('m_member');
		$this->db->where('member_id',$id);	
		$query = $this->db->get();
		$item = $query->row();
		return $item->biz;
	}
	
	function get_member_li_dep() {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->order_by('dep','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	function get_member_dep($id) {
		$this->db->select('dep');
		$this->db->from('m_member');
		$this->db->where('member_id',$id);	
		$query = $this->db->get();
		$item = $query->row();
		return $item->dep;
	}
	
	// 왼쪽인지 오른쪽인지 정보
	function get_member_biz($id) {
		$this->db->select('biz');
		$this->db->from('m_member');
		$this->db->where('member_id',$id);	
		$query = $this->db->get();
		$item = $query->row();
		return $item->biz;
	}
	
	function member_dep_up($member_id,$dep) {

		$query = array(
			'dep' => $dep,
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_member', $query);
	}

	function get_member_li_dep_side() {
		$this->db->select('a.*,ifnull(b.point,0) AS sales,
    (SELECT ifnull(SUM(POINT),0) FROM m_point_su c WHERE c.m_order_code = b.order_code) AS total_point');
		$this->db->from('m_member a');
    $this->db->join('m_point b','b.member_id = a.member_id and b.check_su = "N"','left');
		$this->db->order_by('dep','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
  
  function getSalesTotalInfo($login_id) {
		$this->db->select('a.*,ifnull(b.point,0) AS sales,
    (SELECT ifnull(SUM(POINT),0) FROM m_point_su c WHERE c.m_order_code = b.order_code) AS total_point');
		$this->db->from('m_member a');
    $this->db->join('m_point b','b.member_id = a.member_id and b.check_su = "N"','left');
		$this->db->where('a.member_id',$login_id);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
/* =================================================================
* 입력기록
================================================================= */


	// 회원가입시 정보 입력 2020.08.13 박종훈 수정
	function member_admin_in($member_id, $dep, $biz) 
	{
		
		// 핸드폰 번호 가공
		$mobile = $this->input->post('mobile');
		$mobile = preg_replace("/\s+/", "", $mobile);
		$mobile = explode('-',$mobile);
		$mobile = $mobile[0].@$mobile[1].@$mobile[2];
		/*
		// 계좌번호 번호 가공
		$bank_num = $this->input->post('bank_number');
		$bank_num = explode('-',$bank_num);
		$bank_num = $bank_num[0].@$bank_num[1].@$bank_num[2].@$bank_num[3];
		*/
		
		$level 	= 2;
		$secret = 123456;
		
		$query = array(
			'country' 		=> $this->input->post('country'),
			'member_id' 	=> strtolower($member_id),
			
			'password' 		=> $this->input->post('password'),
			'level' 		=> $level,
			'secret' 		=> $secret,
			'dep' 			=> $dep,
			'biz' 			=> $biz,
			
			'name' 			=> $this->input->post('name'),
			'mobile' 		=> $mobile,
			//'email' 		=> $this->input->post('email'),			
			//'office_group' 	=> $this->input->post('office_group'),
			'office' 		=> $this->input->post('office'),
			'recommend_id' 	=> strtolower($this->input->post('recommend_id')),
			//'sponsor_id' 	=> $this->input->post('sponsor_id'),
			// 'regdate' 	=> $this->input->post('regdate'),
		);

		$this->db->set('regdate', 'now()', FALSE);
		$this->db->insert('m_member', $query);
	}
	
	//회원정보 정보 업데이트
	function member_admin_up($member_id) 
	{		
		// 핸드폰 번호 가공
		$mobile = $this->input->post('mobile');
		$mobile = preg_replace("/\s+/", "", $mobile);
		$mobile = explode('-',$mobile);
		$mobile = $mobile[0].@$mobile[1].@$mobile[2];	

		// 계좌번호 번호 가공
		//$bank_num = $this->input->post('bank_number');
		//$bank_num = explode('-',$bank_num);
		//$bank_num = $bank_num[0].@$bank_num[1].@$bank_num[2].@$bank_num[3];
		
		$query = array(
			'password' 	=> $this->input->post('password'),
			'secret' 	=> $this->input->post('secret'),
			'name' 		=> $this->input->post('name'),
			'email' 	=> $this->input->post('email'),
			'mobile' 	=> $mobile,
			
			//'post' 		=> $this->input->post('post'),
			//'address' 	=> $this->input->post('address'),
			//'address' 	=> $this->input->post('address1'),
			
			//'bank_name' => strtolower($this->input->post('bank_name')),
			//'bank_number' => $bank_num,
			//'bank_holder' => strtolower($this->input->post('bank_holder')),
			
			'country' 		=> $this->input->post('country'),
			//'office_group' 		=> $this->input->post('office_group'),
			'office' 		=> $this->input->post('office'),
			'recommend_id' 	=> strtolower($this->input->post('recommend_id')),
			//'sponsor_id' 	=> $this->input->post('sponsor_id'),
			
			//'is_close' 		=> $this->input->post('is_close'),
			'level' 		=> $this->input->post('level'),
			'type' 			=> $this->input->post('type'),
			'is_out' 		=> $this->input->post('is_out'),
			
			'regdate' 	=> $this->input->post('regdate'),
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_member', $query);
	}
	
	
	// 회원가입시 정보 입력
	function member_in($member_id, $dep, $biz) 
	{
		
		// 핸드폰 번호 가공
		$mobile = $this->input->post('mobile');
		$mobile = preg_replace("/\s+/", "", $mobile);
		$mobile = explode('-',$mobile);
		$mobile = $mobile[0].@$mobile[1].@$mobile[2];
		/*
		// 계좌번호 번호 가공
		$bank_num = $this->input->post('bank_number');
		$bank_num = explode('-',$bank_num);
		$bank_num = $bank_num[0].@$bank_num[1].@$bank_num[2].@$bank_num[3];
		*/
		
		$level 	= 2;
		$secret = 123456;
		
		if(($this->input->post('email')) != NULL){
			$email = $this->input->post('email');			
		}else {
			$email = '';
		}	
	
		$query = array(
			'country' 		=> $this->input->post('country'),
			'member_id' 	=> strtolower($member_id),
			
			'password' 		=> $this->input->post('password'),
			'level' 		=> $level,
			'secret' 		=> $secret,
			'dep' 			=> $dep,
			'biz' 			=> $biz,
			
			'name' 			=> $this->input->post('name'),
			'mobile' 		=> $mobile,
			'email' 		=> $email,		
			//'office_group' 	=> $this->input->post('office_group'),
			'office' 		=> $this->input->post('office'),
			'recommend_id' 	=> strtolower($this->input->post('recommend_id')),
			//'sponsor_id' 	=> $this->input->post('sponsor_id'),
		);

		$this->db->set('regdate', 'now()', FALSE);
		$this->db->insert('m_member', $query);
	}
	
	
	//회원정보 정보 업데이트
	function member_up($member_id) 
	{
		// 핸드폰 번호 가공
		$mobile = $this->input->post('mobile');
		$mobile = preg_replace("/\s+/", "", $mobile);
		$mobile = explode('-',$mobile);
		$mobile = $mobile[0].@$mobile[1].@$mobile[2];	
		/*
		// 계좌번호 번호 가공
		$bank_num = $this->input->post('bank_number');
		$bank_num = explode('-',$bank_num);
		$bank_num = $bank_num[0].@$bank_num[1].@$bank_num[2].@$bank_num[3];	
		*/
		
		$query = array(
			'name' 		=> $this->input->post('name'),
			'email' 	=> $this->input->post('email'),
			//'mobile' 	=> $mobile,
			//'bank_name' => strtolower($this->input->post('bank_name')),
			//'bank_number' => $bank_num,
			//'bank_holder' => strtolower($this->input->post('bank_holder'))
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_member', $query);
	}
	
	
	// 레벨을 조정한다. 직급부분
	function member_level_up($member_id,$level) {

		$query = array(
			'level' => $level,
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_member', $query);
	}
	
	
	function bal_level_up($member_id,$level) {

		$query = array(
			'level' => $level,
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_balance', $query);
	}
	
	// 회원 전자지갑 테이블
	function member_wallet($coin_id,$addr,$qrimg,$type,$addr_key = true) {
		
		$query = array(
			'member_id' => $coin_id,
			'wallet' => $addr,
			'wallet_key' => $addr_key,
			'qrcode' => $qrimg,
			'type' => $type,
		);

		$this->db->set('regdate', 'now()', FALSE);
		$this->db->insert('m_wallet', $query);
		//echo $this->db->last_query();
	}
	
	function member_sp_up($member_id,$sponsor_id) {

		$query = array(
			'sponsor_id' => $sponsor_id,
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_member', $query);
	}
	
	function plan_sp_up($member_id,$sponsor_id) {

		$query = array(
			'sponsor_id' => $sponsor_id,
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_plan', $query);
	}
	
	function member_vlm_up($member_id,$vlm_left,$vlm_left_point,$vlm_right,$vlm_right_point,$vlm_so,$sale,$level) {

		$query = array(
			'vlm_left' 			=> $vlm_left,
			'vlm_left_point' 	=> $vlm_left_point,
			'vlm_right' 			=> $vlm_right,
			'vlm_right_point' 	=> $vlm_right_point,
			'vlm_so' 			=> $vlm_so,
			'sale' 				=> $sale,
			'vlm_level' 			=> $level,
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_member', $query);
	}
	
	function member_type_up($member_id,$type) {

		$query = array(
			'type' => $type,
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_member', $query);
	}

	// 센타명 변경
	function member_office_up($member_id,$office) {

		$query = array(
			'office' => $office,
		);

		$this->db->where('member_id',$member_id);
		$this->db->update('m_member', $query);
	}
	
	
	
	
	
	// 회원 복제 - 아이디만 추가
	function member_copy($make_id,$member_id) {
		
		$CI =& get_instance();
		$mb = $CI->m_member->get_member($member_id); //멤버 정보 가져오기

			
		$level = 2;
		$query = array(
			'member_id' => strtolower($make_id),
			'coin_id' => $mb->coin_id,
			'level' => $level,
			'name' => $mb->name,
			'mobile' => $mb->mobile,
			'email' => $mb->email,
			'password' => $mb->password,
			
			'office' => $mb->office,
			'office_admin' => $mb->office_admin,
			'recommend_id' => $mb->recommend_id,
			'sponsor_id' => $mb->sponsor_id,
			
			'bank_name' => $mb->bank_name,
			'bank_number' => $mb->bank_number,
			'bank_holder' => $mb->bank_holder,
			'type' => $mb->type,
		);

		$this->db->set('regdate', 'now()', FALSE);
		$this->db->insert('m_member', $query);
	}
	
/* ======================================================*/
/* 센터                                                   */
/* ======================================================*/

	// 센터 정보 수정
	function center_up($idx) 
	{		
		$query = array(
			'office_group' 			=> $this->input->post('office_group'),
			'state' 				=> $this->input->post('state'),
			'member_id' 			=> $this->input->post('member_id'),
			'office' 				=> $this->input->post('office'),
			'office_recommend_id' 	=> $this->input->post('recommend_id'),
			'member_id' 			=> $this->input->post('member_id'),
			'mobile' 				=> $this->input->post('mobile'),
			'fax' 					=> $this->input->post('fax'),
			'addr1' 				=> $this->input->post('addr1'),
			//'saupja' 				=> $this->input->post('saupja'),
		);
		$this->db->where('center_no', $idx);
		$this->db->update('m_center', $query);
	}
	// 센터 등록
	function center_in() 
	{		
		$query = array(
			'office_group' 			=> $this->input->post('office_group'),
			'state' 				=> $this->input->post('state'),
			'member_id' 			=> $this->input->post('member_id'),
			'office' 				=> $this->input->post('office'),
			'office_recommend_id' 	=> $this->input->post('recommend_id'),
			'addr1' 				=> $this->input->post('addr1'),
			'mobile' 				=> $this->input->post('mobile'),
			'fax' 					=> $this->input->post('fax'),
			//'saupja' 				=> $this->input->post('saupja'),
		);
		$this->db->set('regdate', 'now()', FALSE);
		$this->db->insert('m_center', $query);
	}
	
	// 센터 등록 시 센터장 변경
	function center_admin() 
	{
		$query = array(
			'office' => $this->input->post('office'),
		);
		$this->db->where('member_id', $this->input->post('member_id'));
		$this->db->update('m_member', $query);
	}

	// 센터 등록 시 센터장 변경
	function change_center($idx,$office) 
	{
		$query = array(
			'office' => $office,
		);
		$this->db->where('center_no', $idx);
		$this->db->update('m_center', $query);
	}
	
	function ch_center($idx,$office) 
	{
		$query = array(
			'office' => $office,
		);
		$this->db->where('member_no', $idx);
		$this->db->update('m_member', $query);
	}
	
/* ======================================================*/
/* 그룹                                                   */
/* ======================================================*/
	
	// 센터 정보 수정
	function group_up($idx) 
	{		
		$query = array(
			'group_name' 			=> $this->input->post('group_name'),
			'member_id' 			=> $this->input->post('member_id'),
			'country' 				=> $this->input->post('country'),
			'state' 				=> $this->input->post('state'),
		);
		$this->db->where('group_no', $idx);
		$this->db->update('m_group', $query);
	}
	// 센터 등록
	function group_in() 
	{		
		$query = array(
			'group_name' 			=> $this->input->post('group_name'),
			'member_id' 			=> $this->input->post('member_id'),
			'country' 				=> $this->input->post('country'),
			'state' 				=> $this->input->post('state'),
		);
		$this->db->set('regdate', 'now()', FALSE);
		$this->db->insert('m_group', $query);
	}
	

	// 상세 정보 가져오기
	function get_group($idx) {
		$this->db->select('*');
		$this->db->from('m_group');
		$this->db->where('group_no',$idx);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	// 이름으로 센터찾기	
	function get_group_name($name) {
		$this->db->select('*');
		$this->db->from('m_group');
		$this->db->where('group_name',$name);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	function get_group_li($office=NULL) {
		$this->db->select('*');
		$this->db->from('m_group');
		
		if($office != NULL){
			$this->db->where('group_name',$office);			
		}
		
		$this->db->order_by('group_name','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
  
  function getBankList() {
		$this->db->select('*');
		$this->db->from('m_bank_list');

		$this->db->order_by('idx','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_group_center_count($group) {
		$this->db->select('*');
		$this->db->from('m_center');
		$this->db->where('office_group',$group);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	function get_group_member_count($group) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('office_group',$group);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	function get_group_jang($name) {
		$this->db->select('*');
		$this->db->from('m_group');
		$this->db->where('group_name',$name);
		$query = $this->db->get();
		$item = $query->row();
		return $item->member_id;
	}
/* ======================================================*/
/* 센터                                                   */
/* ======================================================*/

	function get_member_center($office) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('office',$office);	
		$this->db->order_by("member_no", "asc");
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	
	// 센터 리스트 가져오기
	function get_center_li($office=NULL) {
		$this->db->select('*');
		$this->db->from('m_center');
		
		if($office != NULL){
			$this->db->where('office',$office);			
		}
		
		$this->db->where('state !=','운영종료');
		$this->db->order_by('office','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_center_group($office_group) {
		$this->db->select('*');
		$this->db->from('m_center');
		
		$this->db->where('office_group',$office_group);
		
		$this->db->where('state !=','운영종료');
		$this->db->order_by('center_no','asc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	// 이름으로 센터찾기	
	function get_center_name($name) {
		$this->db->select('*');
		$this->db->from('m_center');
		$this->db->where('office',$name);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}

	// 센터장인지 확인
	function center_chk($id) {
		$this->db->select('*');
		$this->db->from('m_center');
		$this->db->where('member_id',$id);
		$this->db->where('state','운영중');
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 센타소속 회원수
	function center_count($office) {
		$this->db->select('*');
		$this->db->from('m_member');
		$this->db->where('office',$office);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	// 센터장 아이디 가져오기
	function get_center_jang($id) {
		$this->db->select('*');
		$this->db->from('m_center');
		$this->db->where('office',$id);
		$query = $this->db->get();
		$item = $query->row();
		return $item->member_id;
	}

	// 센터 상세 정보 가져오기
	function get_center($idx) {
		$this->db->select('*');
		$this->db->from('m_center');
		$this->db->where('center_no',$idx);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	
/* =================================================================
* etc
================================================================= */
	function sms_authcode_in($mobile, $authcode)
	{
		$this->db->where("mobile", $mobile);
		$this->db->delete('m_sms_authcode');

		$query = array(
			'mobile' 				=> $mobile,
			'authcode' 				=> $authcode
		);

		$this->db->insert('m_sms_authcode', $query);
	}

	function get_sms_authcode($mobile)
	{
		//만료기간이 지난 데이터 삭제
		$this->db->where("regdate < DATE_SUB(NOW(), INTERVAL 10 MINUTE)");
		$this->db->delete('m_sms_authcode');

		//인증키를 가져온다.
		$this->db->select('authcode');
		$this->db->from('m_sms_authcode');
		$this->db->where('mobile',$mobile);
		$query = $this->db->get();
		$item = $query->row();
		return $item ? $item->authcode : '';
	}
	
	function email_authcode_in($email, $authcode)
	{
		$this->db->where("email", $email);
		$this->db->delete('m_email_authcode');

		$query = array(
			'email' 				=> $email,
			'authcode' 				=> $authcode
		);

		$this->db->insert('m_email_authcode', $query);
	}

	function get_email_authcode($email)
	{
		//만료기간이 지난 데이터 삭제
		$this->db->where("regdate < DATE_SUB(NOW(), INTERVAL 10 MINUTE)");
		$this->db->delete('m_email_authcode');

		//인증키를 가져온다.
		$this->db->select('authcode');
		$this->db->from('m_email_authcode');
		$this->db->where('email',$email);
		$query = $this->db->get();
		$item = $query->row();
		return $item ? $item->authcode : '';
	}

	function get_txid($tx_id)
	{
		//만료기간이 지난 데이터 삭제
		$this->db->select('*');
		$this->db->from('m_token_hash');
		$this->db->where('tx_id',$tx_id);
		$query = $this->db->get();
		$item = $query->num_rows();
		return $item;
	}
	
	function set_txid($tx_id)
	{
			$query = array(
			'tx_id' 				=> $tx_id
		);

		$this->db->insert('m_token_hash', $query);
	}

	// hcn moca 확인 처리 jjh20200728
	public function user_update($db_input,$input) {
		foreach($db_input as $key=>$value) {
			$this->db->set($key, $value);
		}

		$this->db->where("member_id", $input['member_id']);
		$this->db->update('m_member');
	}

// jjh20200729
	function get_chkyn()
	{
		$this->db->select('count(member_id) AS member_count,
												SUM(case check_hcn when "Y" then 1 ELSE 0 END) chy,
												SUM(case check_hcn when "N" then 1 ELSE 0 END) chn,
												SUM(case check_moca when "Y" then 1 ELSE 0 END) mcy,
												SUM(case check_moca when "N" then 1 ELSE 0 END) mcn'
											);
		$this->db->from('m_member');
		$this->db->where('checking = "Y"');
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	

	// jjh20200729
	function get_chkhcnmoca2($input)
	{
		$this->db->select('SQL_CALC_FOUND_ROWS c.member_id, 
											c.regdate,
											a.point,
											b.basic_date, 
											a.appdate,
											b.elapsed_date,
											b.basic_day, 
											(select COUNT(recommend_id)  FROM m_member WHERE recommend_id= c.member_id )AS re_cnt ,
											b.basic_re_sum,
											b.basic_re2_sum,
											b.basic_re, 
											b.basic_re2, 
											b.basic_mc, 
											b.basic_mc2,
											(b.point_out+b.point_fee) as total_point,
											(b.basic_day+b.basic_re+b.basic_re2+b.basic_mc+b.basic_mc2) AS sum_basic, 
											b.basic_using_svp,
											c.check_hcn,
											c.check_moca
											',false);
		$this->db->from('m_member c');
		$this->db->join('m_point a', 'a.member_id = c.member_id', 'left');
		$this->db->join('m_balance b', 'a.member_id = b.member_id', 'left');
		$this->db->where('b.basic_amount > "0"');
		$this->db->where('a.cate = "purchase"');
		$this->db->order_by('re_cnt','desc');
		$this->db->order_by('member_id','asc');
		$this->db->limit($input["size"],$input['limit_ofset']);
		$result['page_list']= $this->db->get()->result();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return  $result;
	}

	function get_complate($input)
	{
		$this->db->select('SQL_CALC_FOUND_ROWS c.member_id, 
											c.regdate,
											a.point,
											b.basic_date, 
											a.appdate,
											b.elapsed_date,
											b.su_day, 
											(select COUNT(recommend_id)  FROM m_member WHERE recommend_id= c.member_id )AS re_cnt ,
											b.basic_re_sum,
											b.basic_re2_sum,
											b.su_re, 
											b.su_re2, 
											b.su_mc, 
											b.su_mc2,
											(b.point_out+b.point_fee) as total_point,
											(b.basic_day+b.basic_re+b.basic_re2+b.basic_mc+b.basic_mc2) AS sum_basic, 
											b.basic_using_svp,
											c.check_hcn,
											c.check_moca
											',false);
		$this->db->from('m_member c');
		$this->db->join('m_point a', 'a.member_id = c.member_id', 'left');
		$this->db->join('m_balance b', 'a.member_id = b.member_id', 'left');
		$this->db->where('b.basic_amount > "0"');
		$this->db->where('a.cate = "purchase"');
		$this->db->order_by('re_cnt','desc');
		$this->db->order_by('member_id','asc');
		$this->db->limit($input["size"],$input['limit_ofset']);
		$result['page_list']= $this->db->get()->result();
		$result['total_cnt'] =$this->db->query("SELECT FOUND_ROWS() AS total_cnt;")->row()->total_cnt;
		return  $result;
	}

	// 매출등록시 m_member에 외상 필드 업데이트 20200923 jjh
	function set_isFree($member_id, $is_free){
		$query = array(
			'is_free' 	=> $is_free,
		);
	
		$this->db->where('member_id', $member_id);
		$this->db->update('m_member', $query);
		
	}

	// 은행 가져오기
	function get_member_bholder($id){
		$this->db->select('bank_holder');
		$this->db->from('m_member');
		$this->db->where('member_id', $id);
		$query = $this->db->get();
		$item = $query->row();
		return $item->bank_holder;
	}
	function get_member_bnumber($id){
		$this->db->select('bank_number');
		$this->db->from('m_member');
		$this->db->where('member_id', $id);
		$query = $this->db->get();
		$item = $query->row();
		return $item->bank_number;
	}
	function get_member_bname($id){
		$this->db->select('bank_name');
		$this->db->from('m_member');
		$this->db->where('member_id', $id);
		$query = $this->db->get();
		$item = $query->row();
		return $item->bank_name;
	}
}
?>
