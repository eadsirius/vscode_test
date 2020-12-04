<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Config extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('form','url','admin','search','office'));		
		admin_chk();
		
		$this->load->library('form_validation');
			
		//model load
		$this->load->model('M_cfg');
		$this->load->model('M_admin'); // 서치용 및 리스트용
		
	}

	function index()
	{		
		$data = array();
		$data['title'] = "환경설정";
		$data['group'] = "대시보드";
		
		// 설정불러오기
		$data['site'] = $this->M_cfg->get_site();

		$this->form_validation->set_rules('cfg_site', 'cfg_site', 'required');

		if ($this->form_validation->run() == FALSE) {

			layout('config',$data,'admin');

		} 
		else{
			
			// 디비저장하기
			$cfg_no = $this->input->post('cfg_no');
			$this->M_cfg->set_site_update($cfg_no);
			
			alert("수정했습니다.","admin/config");
		}
	}
	
	function page()
	{
		
		$page = $this->uri->segment(4,0);
		$home = $this->uri->segment(5,0);
		
		//세션 굽기
		$member_ses= array(
			'list_page'  => $page
		);
		$this->session->set_userdata($member_ses);
		
		if($home == "group"){
			$go_home = "/admin/center/group";
		}
		else if($home == "center"){
			$go_home = "/admin/center/lists";
		}
		else if($home == "member"){
			$go_home = "/admin/member/lists";
		}
		else if($home == "finish"){
			$go_home = "/admin/member/finish";
		}
		else if($home == "out"){
			$go_home = "/admin/member/out";
		}
		else if($home == "stop"){
			$go_home = "/admin/member/stop";
		}
		else if($home == "level"){
			$go_home = "/admin/member/level";
		}
		else if($home == "planPoint"){
			$go_home = "/admin/plan/planPoint";
		}
		else if($home == "point"){
			$go_home = "/admin/point/lists";
		}
		else if($home == "planlist"){
			$go_home = "/admin/plan/lists";
		}
		else if($home == "volume"){
			$go_home = "/admin/plan/volume";
		}
		else if($home == "volume1"){
			$go_home = "/admin/plan/volume1";
		}
		else{
			$go_home = "/admin/";			
		}
		
		redirect($go_home);
		
	}
	

	function logdate()
	{		
		$data = array();
		$data['title'] = "로그기록";
		$data['group'] = "대시보드";

		$data = page_lists('m_access_token','token_id',$data);
		
		layout('log',$data,'admin');
	}
	
	
	function log_delete()
	{
		$idx = $this->input->post('idx');
		
		$this->db->where('token_id', $idx);
		$this->db->delete('m_access_token');
		
		
		goto_url($_SERVER['HTTP_REFERER']);
		
	}
}