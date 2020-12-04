<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Board extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','search','file'));
		$this->load->library('form_validation');

		admin_chk();

		define('IMG_DIR', '/views/web/admin'.'/images');
		//model load
		$this -> load -> model('M_member');
		$this -> load -> model('M_admin');
		$this -> load -> model('M_board');

	}

	function index()
	{
		$this->boardlists();
	}

/* =================================================================
* 게시판관리
=================================================================*/

	// 게시판 리스트
	function boardlists()
	{
		$data['title'] = "게시판 리스트";
		$data['group'] = "게시판관리";
		$data['msg'] = "게시판의 신규 생성 및 운영중인 게시판 현황을 확인하실 수 있습니다";

		$data['page'] = $this->uri->segment(4,0);
		$data['pageLink'] = $this->uri->segment(5,0);
		if(empty($data['page'])){
			$data['link'] = "lists/page/";			
		}
		else{
			$data['link'] = "";
		}
		
		if(empty($data['pview'])){
			$data['pview'] = 0;			
		}
		
		
		$data = $this->page_lists('m_board_config','table_id',$data);

		layout('board_lists',$data,'admin');
	}


	// 게시판 등록
	function boardwrite()
	{
		$this -> load -> model('m_admin');

		$data['title'] = "게시판 등록";
		$data['group'] = "게시판관리";
		$data['msg'] = "게시판을 신규 생성 합니다.";

		// 스킨 디렉토리 목록을 받아 배열로 넘긴다
		$this->load->helper('directory');
		$data['skin'] = directory_map ('views/web/skin/board/',1);

		$this->form_validation->set_rules('table_id', '테이블명', 'required');
		if ($this->form_validation->run() == FALSE) {
			layout('board_write',$data,'admin');
		} else {
			$this->M_board->board_write();
			alert("등록이 완료되었습니다", "admin/board/BoardLists");
		}
	}


	// 게시판 수정
	function boardedit()
	{

		$table_id = $this->uri->segment(3,0);
		$this -> load -> model('m_admin');

		$data['title'] = "게시판 수정";
		$data['group'] = "게시판 관리";
		$data['msg'] = "게시판 정보를 수정 합니다.";


		// 스킨 디렉토리 목록을 받아 배열로 넘긴다
		$this->load->helper('directory');
		$data['skin'] = directory_map ('views/skin/board/',1);

		$this->form_validation->set_rules('table_id', '테이블명', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['item']= $this->M_board->get_board_config($table_id);
			layout('board_write',$data,'admin');
		} else {
			$this->M_board->board_edit($table_id);
			alert("수정이 완료되었습니다", "admin/BoardEdit/".$table_id."");
		}
	}

	//게시판 삭제
	function boarddelete()
	{

		if ( $this->session->userdata('level') <> 1  ) {
			alert("게시판 삭제 권한이 없습니다","admin/BoardLists");
		}

		$drop_table = "m_board_".$this->input->post('table_id');
		$this->db->delete('m_board_config', array('table_id' => $this->input->post('table_id')));
		$this->load->dbforge();
		$this->dbforge->drop_table($drop_table);
		alert("삭제가 완료되었습니다", "admin/BoardLists");
	}

	// 페이지 네이션
	function page_lists($table,$order_by,$data)
	{
		$this -> load -> model('m_admin');

		define('SEARCH_URL', current_url());

		$CI =& get_instance();
		$CI->load->library('pagination');

		$sys = $page = $this->uri->segment(2);
		$page = $this->uri->segment(4);

		$data['st'] = $this->uri->segment(7);
		$data['sc'] = $this->uri->segment(9);

		// POST 에 검색정보가 있다면
		if ($this->input->post('st') and $this->input->post('sc')) {
			redirect('/admin/'.$sys.'/lists/page/1/st/'.$this->input->post('st').'/sc/'. urlencode($this->input->post('sc')).'');
		}

		// page 넘버 이후 세그먼트 담기
		if ($this->uri->segment(6) == "st" and  $this->uri->segment(8) == "sc") {
			$q = array('st' => $data['st'], 'sc' => $data['sc']);
			$qstr = $this->uri->assoc_to_uri($q);
			$config['suffix']	   = "/".$qstr;
		}

		$config['per_page'] = 10;  //한페이지에 보여줄 게시물
		$config['num_links'] = 10;  // 최대보여줄 페이지 넘버
		$config['base_url'] = '/admin/'.$sys.'/lists/page/';


		// 디자인
		$config['first_tag_open']  = '<span id=page>';
		$config['first_tag_close']  = '</span>';
		$config['last_tag_open']  = '<span id=page>';
		$config['last_tag_close']  = '</span>';
		$config['cur_tag_open']  = '<span id=page_con>';
		$config['cur_tag_close']  = '</span>';
		$config['next_tag_open']  = '<span id=page>';
		$config['next_tag_close']  = '</span>';
		$config['prev_tag_open']  = '<span id=';
		$config['prev_tag_open']  = '<span id=page>';
		$config['prev_tag_close']  = '</span>';
		$config['num_tag_open']  = '<span id=page>';
		$config['num_tag_close']  = '</span>';


		//페이지 시작페이지가 1이하라면
		$page_num = $this->uri->segment(5);
		if ($page_num == 1 or $page_num == NULL ) {
			$page_num = 0;
		}else {
			$page_num = $page_num * $config['per_page'] - $config['per_page'];
		}

		// 검색 정보가 있을시 (추후 코드 수정)
		if ($this->uri->segment(6) == "st" and  $this->uri->segment(8) == "sc") {
			$data['item'] = $this->M_board->get_sc_lists($table,$config['per_page'],$page_num,$order_by,$data['st'],$data['sc']);
			$config['total_rows'] = $this->db->count_all_results();
		}else {
			$data['item'] = $this->M_board->get_lists($table,$config['per_page'],$page_num,$order_by);
			$config['total_rows'] = $this->M_board->get_total($table);
		}

		$data['total_count'] = $config['total_rows'] - $page;
		$data['search'] =  urldecode($data['sc']);
		$this->pagination->initialize($config);
		define('PAGE_URL', $this->pagination->create_links());
		return $data;

	}


}
?>