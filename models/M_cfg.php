<?
class M_cfg extends CI_Model {

	
/* =================================================================
* 설정값
================================================================= */

	function get_site() {
		$idx = 1;
		$this->db->select('*');
		$this->db->from('m_site');
		$this->db->where('cfg_no',$idx);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	
	function set_site_insert() 
	{		
		$query = array(
			'cfg_site' 		=> $this->input->post('cfg_site'),
			'cfg_admin' 	=> $this->input->post('cfg_admin'),
			'cfg_country' 	=> $this->input->post('cfg_country'),
			'regdate' 		=> $this->input->post('regdate')
		);
		$this->db->insert('m_site', $query);
	}
	
	
	function set_site_update($cfg_no) 
	{		
		$query = array(
			'cfg_site' 			=> $this->input->post('cfg_site'),
			'cfg_admin' 		=> $this->input->post('cfg_admin'),
			'cfg_country' 		=> $this->input->post('cfg_country'),
			'cfg_language' 		=> $this->input->post('cfg_language'),

			'cfg_contract' 		=> $this->input->post('cfg_contract'),
			'cfg_address' 		=> $this->input->post('cfg_address'),
			'cfg_coin' 			=> $this->input->post('cfg_coin'),
			'cfg_send_point' 	=> $this->input->post('cfg_send_point'),
			'cfg_send_persent' 	=> $this->input->post('cfg_send_persent')*0.01,
			'cfg_lv1_day' 			=> $this->input->post('cfg_lv1_day')*0.01,
			'cfg_lv1_re' 			=> $this->input->post('cfg_lv1_re')*0.01,
			'cfg_lv1_re1' 			=> $this->input->post('cfg_lv1_re1')*0.01,
			'cfg_lv1_re2' 			=> $this->input->post('cfg_lv1_re2')*0.01,
			'cfg_re' 				=> $this->input->post('cfg_re')*0.01,
			'cfg_re1' 				=> $this->input->post('cfg_re1'),
			
			'cfg_vip1_start' 		=> $this->input->post('cfg_vip1_start'),
			'cfg_vip1_end' 			=> $this->input->post('cfg_vip1_end'),
			'cfg_vip1_present' 		=> $this->input->post('cfg_vip1_present'),
			
			'cfg_vip2_start' 		=> $this->input->post('cfg_vip2_start'),
			'cfg_vip2_end' 			=> $this->input->post('cfg_vip2_end'),
			'cfg_vip2_present' 		=> $this->input->post('cfg_vip2_present'),
			
			'cfg_vip3_start' 		=> $this->input->post('cfg_vip3_start'),
			'cfg_vip3_end' 			=> $this->input->post('cfg_vip3_end'),
			'cfg_vip3_present' 		=> $this->input->post('cfg_vip3_present'),
			
			'cfg_vip4_start' 		=> $this->input->post('cfg_vip4_start'),
			'cfg_vip4_end' 			=> $this->input->post('cfg_vip4_end'),
			'cfg_vip4_present' 		=> $this->input->post('cfg_vip4_present'),
			
			'cfg_vip5_start' 		=> $this->input->post('cfg_vip5_start'),
			'cfg_vip5_end' 			=> $this->input->post('cfg_vip5_end'),
			'cfg_vip5_present' 		=> $this->input->post('cfg_vip5_present'),
			
			'cfg_vip6_start' 		=> $this->input->post('cfg_vip6_start'),
			'cfg_vip6_end' 			=> $this->input->post('cfg_vip6_end'),
			'cfg_vip6_present' 		=> $this->input->post('cfg_vip6_present'),
			
			'cfg_vip7_start' 		=> $this->input->post('cfg_vip7_start'),
			'cfg_vip7_end' 			=> $this->input->post('cfg_vip7_end'),
			'cfg_vip7_present' 		=> $this->input->post('cfg_vip7_present'),
			
			'cfg_vip8_start' 		=> $this->input->post('cfg_vip8_start'),
			'cfg_vip8_end' 			=> $this->input->post('cfg_vip8_end'),
			'cfg_vip8_present' 		=> $this->input->post('cfg_vip8_present'),
			
			'cfg_vip9_start' 		=> $this->input->post('cfg_vip9_start'),
			'cfg_vip9_end' 			=> $this->input->post('cfg_vip9_end'),
			'cfg_vip9_present' 		=> $this->input->post('cfg_vip9_present'),
			
			'cfg_vip10_start' 		=> $this->input->post('cfg_vip10_start'),
			'cfg_vip10_end' 		=> $this->input->post('cfg_vip10_end'),
			'cfg_vip10_present' 	=> $this->input->post('cfg_vip10_present'),
			
			'regdate' => $this->input->post('regdate')
		);

		$this->db->where('cfg_no', $cfg_no);
		$this->db->update('m_site', $query);
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Code Group 리스팅 가져오기(지정된 언어팩만)
	 * @param $where
	 * @param null $limit
	 * @param string $order_by
	 * @return array|mixed
	 */
	public function getGroups($where, $limit = NULL, $order_by = 'cg_code ASC')
	{
		$this->select('*');
		$this->select('(SELECT mb_login FROM cb_member WHERE cb_member.mb_no=T_CG.cg_updater) mb_login');
		$this->select('IFNULL(
			(SELECT cdd_name FROM cb_code_description TS_CDD WHERE TS_CDD.cg_code=T_CG.cg_code AND TS_CDD.cd_id IS NULL AND TS_CDD.cdd_lang=' . $this->escape($this->_i18n) . '),
			(SELECT cdd_name FROM cb_code_description TS_CDD WHERE TS_CDD.cg_code=T_CG.cg_code AND TS_CDD.cd_id IS NULL AND TS_CDD.cdd_lang=\'ko\')
		) cg_name');
		$this->from('cb_code_group T_CG');
		$this->order_by($order_by);
		$rows = $this->fetch($where, $limit);
		return $rows;
	}

	// ------------------------------------------------------------------------

	/**
	 * 코드 리스트 가져오기(지정된 언어팩만)
	 * @param $where
	 * @param null $limit
	 * @param string $order_by
	 * @return array|mixed
	 */
	public function getRow($where, $limit = NULL, $order_by = 'cd_id ASC')
	{
		$this->select('*');
		$this->select('IFNULL(
			(SELECT cdd_name FROM cb_code_description TS_CDD WHERE TS_CDD.cg_code=T_CD.cg_code AND TS_CDD.cd_id=T_CD.cd_id AND TS_CDD.cdd_lang=' . $this->escape($this->_i18n) . '),
			(SELECT cdd_name FROM cb_code_description TS_CDD WHERE TS_CDD.cg_code=T_CD.cg_code AND TS_CDD.cd_id=T_CD.cd_id AND TS_CDD.cdd_lang=\'ko\')
		) cd_name');
		$this->from('cb_code_list T_CD');

		$this->order_by($order_by);
		$rows = $this->fetch($where, $limit);
		return $rows;
	}

	// ------------------------------------------------------------------------

	/**
	 * 코드 그룹별  모든 언어팩 가져오기
	 * @param $where
	 * @param null $limit
	 * @param string $order_by
	 * @return array|mixed
	 */
	public function getAllGroups($where, $limit = NULL, $order_by = 'T_CG.cg_code ASC')
	{
		$this->select('T_CG.*');
		$this->select('T_CDD.cdd_lang');
		$this->select('T_CDD.cdd_name cg_name');
		$this->from('cb_code_group T_CG');
		$this->join('cb_code_description T_CDD', 'T_CDD.cg_code=T_CG.cg_code AND T_CDD.cd_id IS NULL', 'LEFT');

		$this->order_by($order_by);
		$rows = $this->fetch($where, $limit);
		return $rows;
	}

	// ------------------------------------------------------------------------

	/**
	 * 모든 언어팩의 코드 리스트
	 * @param $where
	 * @param null $limit
	 * @param string $order_by
	 * @return array|mixed
	 */
	public function getAllRows($where, $limit = NULL, $order_by = 'T_CD.cd_id ASC')
	{
		$this->select('*');
		$this->from('cb_code_list T_CD');
		$this->join('cb_code_description T_CDD', 'T_CDD.cg_code=T_CD.cg_code AND T_CD.cd_id=T_CD.cd_id AND T_CDD.cd_id IS NOT NULL');
		$this->order_by($order_by);
		$rows = $this->fetch($where, $limit);
		return $rows;
	}

	// ------------------------------------------------------------------------

	/**
	 * 특정 언어팩 정보만 가져오기
	 * @param $where
	 * @param null $limit
	 * @param string $order_by
	 * @return array|mixed
	 */
	public function getRowDescription($where, $limit = NULL, $order_by = 'cd_id ASC')
	{
		$this->select('*');
		$this->from('cb_code_description T_CDD');
		$this->order_by($order_by);
		$rows = $this->fetch($where, $limit);
		return $rows;
	}

	// ------------------------------------------------------------------------

	/**
	 * 코드리스트를 배열로 가져오기
	 * @param array $groupID
	 * @return array|mixed
	 */
	public function getCodeListArray($groupID = array())
	{
		return $this->getRow(array('cg_code' => $groupID));
	}


	// ------------------------------------------------------------------------

	/**
	 * 단일 코드 : getCodeListAssoc(code1)
	 *    array('A'=>'Active', 'H'=>'Hidden')
	 * 다중 코드 : getCodeListAssoc(code1, code2, .. , codeN)
	 *    array(code1=>array('A'=>'Active', 'H'=>'Hidden'), code2=>array(1=>'One', 2=>'Two'), ...)
	 *
	 * @return array|mixed
	 */
	public function getCodeListAssoc()
	{
		$groupID = func_get_args();
		$this->select('cd_id');

		$this->select('IFNULL(
			(SELECT cdd_name FROM cb_code_description TS_CDD WHERE TS_CDD.cg_code=T_CD.cg_code AND TS_CDD.cd_id=T_CD.cd_id AND TS_CDD.cdd_lang=' . $this->escape($this->_i18n) . '),
			(SELECT cdd_name FROM cb_code_description TS_CDD WHERE TS_CDD.cg_code=T_CD.cg_code AND TS_CDD.cd_id=T_CD.cd_id AND TS_CDD.cdd_lang=\'ko\')
		) cd_name');
		$this->from('cb_code_list T_CD');

		$condition = !count($groupID) ? NULL : array('cg_code' => $groupID);

		if (count($groupID) == 1) {
			$option = 'h:cd_id';
		}
		else {
			$this->select('cg_code');
			$option = 'h:cg_code,cd_id';
		}
		$this->order_by("cd_update_at ASC");
		$rows = $this->fetch($condition, $option);
		return $rows;

	}

	// ------------------------------------------------------------------------

	/**
	 * 코드 그룹 등록 / 업데이트
	 * @param $values
	 * @param null $where
	 * @return bool
	 */
	public function setGroup($values, $where = NULL)
	{
		return is_null($where) ? $this->insert('cb_code_group', $values) : $this->update('cb_code_group', $values, $where);
	}

	// ------------------------------------------------------------------------

	/**
	 * 코드 그룹 언어팩
	 */
	public function setGroupDescription($lang, $group_code, $group_name)
	{
		$values = array('cdd_lang' => $lang, 'cdd_type' => 'G', 'cg_code' => $group_code, 'cdd_name' => $group_name);
		return empty($group_name) ? TRUE : $this->insert('cb_code_description', $values);
	}

	// ------------------------------------------------------------------------

	/**
	 * 코드 등록
	 * @param $values
	 * @param null $where
	 * @return bool
	 */
	public function setRow($values, $where = NULL)
	{
		return is_null($where) ? $this->insert('cb_code_list', $values) : $this->update('cb_code_list', $values, $where);
	}

	// ------------------------------------------------------------------------

	/**
	 * 코드 언어팩
	 */
	public function setRowDescription($lang, $group_code, $code, $name)
	{
		$values = array('cdd_lang' => $lang, 'cdd_type' => 'V', 'cg_code' => $group_code, 'cd_id' => $code, 'cdd_name' => $name);
		return empty($name) ? TRUE : $this->insert('cb_code_description', $values);
	}

	// ------------------------------------------------------------------------

	/**
	 * 코드 삭제
	 * @param $group_code
	 * @param $code
	 * @return mixed
	 */
	public function removeRow($group_code, $code)
	{
		return $this->delete('cb_code_list', array('cg_code' => $group_code, 'cd_id' => $code));
	}

	// ------------------------------------------------------------------------

	/**
	 * 코드 그룹 삭제
	 * @param $group_code
	 * @param null $code
	 * @param null $lang
	 * @return mixed
	 */
	public function removeDescription($group_code, $code = NULL, $lang = NULL)
	{
		$where = array('cg_code' => $group_code);
		//언어
		if (!empty($lang)) {
			$where['cdd_lang'] = $lang;
		}
		// 타입
		if (is_null($code)) {
			$where['cdd_type'] = 'G';
		}
		else {
			$where['cd_id'] = $code;
			$where['cdd_type'] = 'V';
		}
		return $this->delete('cb_code_description', $where);
	}

	// ------------------------------------------------------------------------

	/**
	 * @param $value
	 * @param null $idx
	 * @return bool
	 */
	public function setAdminGroup($value, $idx = NULL)
	{
		$result = $idx > 0 ? $this->update('cb_member_group', $value, array('grp_idx' => $idx)) : $this->insert('cb_member_group', $value);
		return $result;
	}

	// ------------------------------------------------------------------------

	/**
	 * @param null $where
	 * @param null $limit
	 * @return array|mixed
	 */
	public function getAdminGroup($where = NULL, $limit = NULL)
	{
		$this->select('*');
		//$this->select('(SELECT mnu_url FROM ?:menu WHERE mnu_idx=T_GRP.mnu_idx) base_url');
		//$this->select('(SELECT mnd_description FROM ?:menu_description WHERE mnd_mnu_idx=T_GRP.mnu_idx AND mnd_lang_code=' . $this->escape($this->_i18n) . ') menu_name');
		$this->from('cb_member_group T_GRP');
		if (is_numeric($where)) {
			$where = array('grp_idx' => $where);
			if (!$limit) {
				$limit = 'one';
			}
		}

		$rows = $this->fetch($where, $limit);

		return $rows;
	}

	// ------------------------------------------------------------------------

	/**
	 * @return array|mixed
	 */
	public function getAdminGroupAssoc()
	{
		$this->select('grp_code, grp_name');
		$this->from('cb_member_group');
		$option = 'h:grp_code';
		$rows = $this->fetch(NULL, $option);
		return $rows;
	}

	// 2020.08.18 박종훈 코인 시세 변경 히스토리 추가
	public function setCoinpriceHistory()
	{		
		$query = array(
			'before_amount'			=> $this->input->post('before_cfg_won'),
			'after_amount' 			=> $this->input->post('cfg_won'),
			'inputid' 					=> $this->input->post('inputid'),
			'inputip' 					=> $this->input->post('inputip')
		);
		$this->db->insert('TB_COIN_MARKETPRICE_HISTORY', $query);
	}

	// 2020.08.18 박종훈 코인 시세 변경 추가
	public function setCfgwon($cfg_no)
	{
		$query = array(
			'cfg_won' 			=> $this->input->post('cfg_won')
		);

		$this->db->where('cfg_no', $cfg_no);
		$this->db->update('m_site', $query);		
	}

	// 2020.08.18 박종훈 코인 시세 변경 리스트 추가
	public function getCfgwonChangeList()
	{
		$this->db->select("SQL_CALC_FOUND_ROWS *",false);
		$this->db->from("TB_COIN_MARKETPRICE_HISTORY");
		$this->db->order_by("idx", "desc");
		$this->db->limit(10);

		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
}