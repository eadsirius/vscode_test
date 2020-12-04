<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complate extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();

		// define('SKIN_DIR', '/views/web/app');
		//모델 로드
		$this->load->helper(array('file','form', 'url','search'));
		$this->load->model('M_admin');
		$this->load->model('M_cfg');
		$this->load->model('M_member');
		$this->load->model('M_office');
		$this->load->model('M_point');
		$this->load->model('M_coin');
	}
	
	public function index()
	{	/*
		$data = array();
		$data['header']       = array('title'=>SITE_NAME_EN,'group'=>'PRIVACY');
		$data['list']	      	= $this->M_member->get_chkhcnmoca();
		$data['chkyn']		    = $this->M_member->get_chkyn();
		layout('/member/checkmoca',$data,'single');
		*/

		$data = array();
		$data['header'] = array('title'=>SITE_NAME_EN,'group'=>'PRIVACY');
		
		$page	= $this->input->get('page');
		$size =50;
		if(empty($page) || !isInt($page)) $page = 1;

		$input["page"]      	= $page;
		$input["size"]      	= $size;
		$input["limit_ofset"]	= ($page-1) * $size;

		$chkhcnmoca	     = $this->M_member->get_complate($input);

		$data['list']		= $chkhcnmoca['page_list'];
		$data['total_count']	= $chkhcnmoca['total_cnt'];
		$data['input']		= $input;
		$data['chkyn']	= $this->M_member->get_chkyn();
		
		layout('/member/complate',$data,'single');

	}

	public function state()
	{
		$gubn	=	$this->input->post('gubn',true);
		$member_id	=	$this->input->post('member_id',true);
		
		if(empty($member_id)) {
			http_response_code(400);
			echo json_encode(array("status"=>400, "message"=>"정보가 올바르지 않습니다.","action"=>"self"));
			return;	
		}
		
		$input["member_id"]	= $member_id;
		switch($gubn) {
			case 'hcn':$db_input["check_hcn"]   = 'Y'; break;
			case 'moca':$db_input["check_moca"]	= 'Y'; break;
		}
	
		$this->M_member->user_update($db_input,$input);
		echo json_encode(array("status"=>200, "message"=>"OK" ,"action"=>""));
		http_response_code(200);	
	}
}