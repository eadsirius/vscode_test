<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Center extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','search'));
		$this->load->library('form_validation');

		define('SKIN_DIR', '/views/admin');

		admin_chk();

		//model load
		$this -> load -> model('M_member');
		$this -> load -> model('M_admin');
		$this -> load -> model('M_point');

	}

	function index()
	{
		$this->lists();
	}


	function lists()
	{
		$data['title'] 	= "센터 등록 현황";
		$data['group'] 	= "회원관리";
		$data['msg'] 	= "센터 등록 현황을 확인 합니다.";
		//$data['group'] = $this->M_member->get_group_li(); //센터 리스트 가져오기
		//---------------------------------------------------------------------------------//
		
		$data = page_lists('m_center','regdate',$data);
        foreach ($data['item'] as $row) 
        {
			$row->name = $this->M_member->get_member_name($row->member_id);
			$row->member_cnt = $this->M_member->center_count($row->office);
			
			if($row->office_recommend_id != '' )
			{
				//$row->recommend_name = $this->M_member->get_member_name($row->office_recommend_id);
			}
			else
			{
				//$row->recommend_name = "";
			}
        }
        
		layout('centerLists',$data,'admin');
	}
	
	function addCenter()
	{
		$data['title'] 	= "센터 정보 등록및 수정";
		$data['group'] 	= "센터관리";
		//---------------------------------------------------------------------------------//
		
		$this->form_validation->set_rules('office', 'office', 'required');
		$this->form_validation->set_rules('member_id', 'member_id', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			alert("입력을 확인하세요.");	
		} 
		else 
		{
			//지사 정보 가져오기
			$member_id = $this->input->post('member_id');
			$jang = $this->M_member->get_center_jang($member_id);
			if ($jang) {
				alert("센타장이 존재합니다.");	
			}
			
			$office = $this->input->post('office');
			$name = $this->M_member->get_center_name($office);
			if ($name) {
				alert("센타명이 존재합니다.");	
			}
			
			$this->M_member->center_in();
				
			// 센터장 될 사람의 정보 같이 변경하기
			$this->M_member->center_admin();
				
			alert("등록이 완료되었습니다", "admin/center/lists");	
		}
	}
	
	
	//---------------------------------------------------------------------------------//
	// 정보 수정
	function write()
	{
		$data['title'] 	= "센터 정보 등록및 수정";
		$data['group'] 	= "센터관리";

		$idx   = $this->uri->segment(4,0);
		
		$data['center'] = $this->M_member->get_center($idx); //센터 리스트 가져오기
		//$data['group'] = $this->M_member->get_group_li(); //센터 리스트 가져오기
		//---------------------------------------------------------------------------------//		
		
		$data['jang_name'] = $this->M_member->get_member_name($data['center']->member_id);
		$data['member_cnt'] = $this->M_member->center_count($data['center']->office);

		//---------------------------------------------------------------------------------//
		layout('centerWrite',$data,'admin');

	}
	
	function edit()
	{
		$data['title'] 	= "센터 정보 등록및 수정";
		$data['group'] 	= "센터관리";

		$this->form_validation->set_rules('office', 'office', 'required');
		$this->form_validation->set_rules('member_id', 'member_id', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			alert("입력을 확인하세요.");	
		} 
		else 
		{	
			$idx = $this->input->post('center_no');

			$this->M_member->center_up($idx);
			
			//--------------------------------------------------------------------------------//
			
			$old_office = $this->input->post('old_office');
			$office = $this->input->post('office');
			
			if($old_office != $office){
				$list = $this->M_member->get_member_center($old_office);
				foreach ($list as $row)
				{
					$this->M_member->ch_center($row->member_no,$office);
				}
			}
			
			//--------------------------------------------------------------------------------//
			// 수정한 사람 누군지 기록하기
			$str = $idx ." - center edit";
			$query = array(
				'member_id' => $this->session->userdata('member_id'),
				'msg' => $str
			);
			$this->db->set('reg_date', 'now()', FALSE);
			$this->db->insert('m_access_token', $query);
		
			//--------------------------------------------------------------------------------//
			
			alert("완료되었습니다", "admin/center/lists");
			//alert("수정이 완료되었습니다", "admin/center/write/".$idx ."");			

		}
	}
	//---------------------------------------------------------------------------------//

	function del()
	{
		$idx   = $this->uri->segment(4,0);
		
		$this->db->delete('m_center', array('center_no' => $idx));
		
		//$this->M_member->center_admin();
		
		alert("삭제 되었습니다", "admin/center/lists");
	}

	//---------------------------------------------------------------------------------//

	function groupLists()
	{
		$data['title'] 	= "그룹 등록 현황";
		$data['group'] 	= "회원관리";
		//---------------------------------------------------------------------------------//
		
		$total_center = 0;
		$total_member = 0;
		$data = page_lists('m_group','regdate',$data);
        foreach ($data['item'] as $row) 
        {
			$row->name = $this->M_member->get_member_name($row->member_id);
			$row->center_count 	= $this->M_member->get_group_center_count($row->group_name);
			$row->member_count 	= $this->M_member->get_group_member_count($row->group_name);

			$total_center += $row->center_count;
			$total_member += $row->member_count;
        }
		$data['total_center'] 	= $total_center;
		$data['total_member'] 	= $total_member;
        
		layout('groupLists',$data,'admin');
	}

	
	function addGroup()
	{
		$data['title'] 	= "그룹 정보 등록및 수정";
		$data['group'] 	= "센터관리";
		//---------------------------------------------------------------------------------//
		
		$this->form_validation->set_rules('group_name', 'group_name', 'required');
		$this->form_validation->set_rules('member_id', 'member_id', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			alert("입력을 확인하세요.");	
		} 
		else 
		{
			
			$group_name = $this->input->post('group_name');
			$name = $this->M_member->get_group_name($group_name);
			if ($name) {
				alert("그룹명이 존재합니다.");	
			}
			
			$this->M_member->group_in();
				
			alert("그룹등록이 완료되었습니다", "admin/center/groupLists");	
		}
	}
	// 정보 수정
	function groupWrite()
	{
		$data['title'] 	= "그룹 정보 등록및 수정";
		$data['group'] 	= "센터관리";

		$idx   = $this->uri->segment(4,0);
		
		$data['group'] = $this->M_member->get_group($idx); //센터 리스트 가져오기
		//---------------------------------------------------------------------------------//		
		
		$data['jang_name'] = $this->M_member->get_member_name($data['group']->member_id);
		$data['member_cnt'] = $this->M_member->center_count($data['group']->group_name);

		//---------------------------------------------------------------------------------//
		layout('groupWrite',$data,'admin');

	}
	
	function groupEdit()
	{
		$data['title'] 	= "그룹 정보 등록및 수정";
		$data['group'] 	= "센터관리";

		$this->form_validation->set_rules('group_name', 'group_name', 'required');
		$this->form_validation->set_rules('member_id', 'member_id', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			alert("입력을 확인하세요.");	
		} 
		else 
		{	
			$idx = $this->input->post('group_no');

			$this->M_member->group_up($idx);
			
			//--------------------------------------------------------------------------------//
			// 수정한 사람 누군지 기록하기
			$str = $idx ." - group edit";
			$query = array(
				'member_id' => $this->session->userdata('member_id'),
				'msg' => $str
			);
			$this->db->set('reg_date', 'now()', FALSE);
			$this->db->insert('m_access_token', $query);
		
			//--------------------------------------------------------------------------------//
			
			alert("수정이 완료되었습니다", "admin/center/groupWrite/".$idx ."");			

		}
	}
	//---------------------------------------------------------------------------------//

	function groupDel()
	{
		$idx   = $this->uri->segment(4,0);
		
		$this->db->delete('m_group', array('group_no' => $idx));
		
		
		alert("삭제 되었습니다", "admin/center/groupLists");
	}
	
}
?>