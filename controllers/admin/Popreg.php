<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Popreg extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','search','office'));
		$this->load->library('form_validation');
		//$this->output->enable_profiler(TRUE);

		admin_chk();
				
		define('SKIN_DIR', '/views/admin');

		//model load
		$this -> load -> model('M_member');
		$this -> load -> model('M_admin');
		$this -> load -> model('M_office');
		$this -> load -> model('M_point');

	}
	
	
	function index()
	{		
		$data['sid'] = $this->uri->segment(4);
		
		$this->db->select('*');
		$this->db->from('M_member');
		$this->db->where('sponsor_id',$data['sid']);
		$query = $this->db->get();
		$data['chk'] = $query->num_rows();
		
		$this->load->view('admin/regPop',$data);
	}


	// 회원 검색
	function mbpop()
	{
		$data['title'] = "회원정보 검색";
		
		$this->form_validation->set_rules('name', 'name', 'required');
		if ($this->form_validation->run() == FALSE) {

			$this->load->view('admin/memberPop',$data);

		} else {

			$data['item'] =  $this->M_member->get_name($this->input->post('name'));
		
			$this->load->view('admin/memberPop',$data);

		}
		
	}


	// 추천인 검색
	function repop()
	{
		$data['title'] = "회원정보 검색";
		
		$this->form_validation->set_rules('name', 'name', 'required');
		if ($this->form_validation->run() == FALSE) {

			$this->load->view('admin/memberPop',$data);

		} else {

			$data['item'] =  $this->M_member->get_name($this->input->post('name'));
		
			$this->load->view('admin/popup_re',$data);

		}
		
	}
	
	// 후원인 검색
	function sppop()
	{
		$data['title'] = "회원정보 검색";
		
		$this->form_validation->set_rules('name', 'name', 'required');
		if ($this->form_validation->run() == FALSE) {

			$this->load->view('admin/memberPop',$data);

		} else {

			$data['item'] =  $this->M_member->get_name($this->input->post('name'));
		
			$this->load->view('admin/popup_sp',$data);

		}
		
	}
	
	// 특정회원찾기
	function sendMember()
	{
		$data['title'] = "회원정보 검색";
		
		$this->form_validation->set_rules('name', 'name', 'required');
		if ($this->form_validation->run() == FALSE) {

			$this->load->view('admin/memberPop',$data);

		} else {

			$data['item'] =  $this->M_member->get_name($this->input->post('name'));
		
			$this->load->view('admin/popupMember',$data);

		}
		
	}
	// 특정회원찾기
	function sendMember1()
	{
		$data['title'] = "회원정보 검색";
		
		$this->form_validation->set_rules('name', 'name', 'required');
		if ($this->form_validation->run() == FALSE) {

			$this->load->view('admin/memberPop',$data);

		} else {

			$data['item'] =  $this->M_member->get_name($this->input->post('name'));
		
			$this->load->view('admin/popupMember1',$data);

		}
		
	}
		
}
?>