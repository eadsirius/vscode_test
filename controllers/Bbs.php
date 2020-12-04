<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bbs extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','search','office'));
		$this->load->library('form_validation');

		$this->load-> model('M_member');
		$this->load-> model('M_admin');
		$this->load-> model('M_bbs');
		$this->load->model('M_coin');
		$this->load->model('M_cfg');
		
		// 미 로그인 상태라면
		loginCheck();
	}
	

	public function index(){
		$this->lists();
$data['select_lang'] = 'kr';

	}
	
	public function lists()
	{
		$data = array();
		$site 			= $this->M_cfg->get_site();
		$data['site'] 	= $site;

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$wallet = $this->M_coin->get_wallet_address($login_id,'wns');
		$data['wallet'] = $wallet;
		$bal 			= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		
		//----------------------------------------------------------------------//
		$bbs_name = $this->uri->segment(3,0);
		$data['bbs_name'] = $bbs_name;
		
		if($bbs_name == 0)
		{
			$bbs_table = "m_bbs_notice";
			$data['table'] = $bbs_table;
			$data['title'] = "공지사항";
			$data['bbs_name'] = 'notice';
			
			$data = page_lists($bbs_table,'bbs_no',$data);
		}
		else if($bbs_name== "qna")
		{			
			$bbs_table 		= "m_bbs_qna";
			$data['table'] 	= $bbs_table;
			$data['title'] 	= "1:1문의";
			
			$data = page_lists($bbs_table,'bbs_no',$data, 'member_id',$login_id);
		}
		else
		{
			$bbs_table 		= "m_bbs_notice";
			$data['table'] 	= $bbs_table;
			$data['title'] 	= "공지사항";
			
			$data = page_lists($bbs_table,'bbs_no',$data);
		}
		//----------------------------------------------------------------------//
		
		layout('/bbs/lists',$data,'office');
	}
	
	public function views()
	{
		$data = array();
		$site 			= $this->M_cfg->get_site();
		$data['site'] 	= $site;

		// 회원정보에서 나의 지갑 주소를 얻음
		$login_id 	= $this->session->userdata('member_id');
		$member_no 	= $this->session->userdata('member_no');
		
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$wallet = $this->M_coin->get_wallet_address($login_id,'wns');
		$data['wallet'] = $wallet;
		$bal 			= $this->M_coin->get_balance($member_no);
		$data['bal'] 	= $bal;
		
		//----------------------------------------------------------------------//
		$bbs_name = $this->uri->segment(3,0);
		$data['bbs_name'] = $bbs_name;
		$idx = $this->uri->segment(4,0);
		$data['idx'] = $idx;
		
		if($bbs_name == 0)
		{
			$bbs_table = "m_bbs_notice";
			$data['table'] = $bbs_table;
			$data['title'] = "공지사항";
			$data['bbs_name'] = 'notice';
			
			$data['item'] = $this->M_bbs->get_bbs_views_no($bbs_table ,$idx);
		}
		else if($bbs_name== "qna")
		{			
			$bbs_table 		= "m_bbs_qna";
			$data['table'] 	= $bbs_table;
			$data['title'] 	= "1:1문의";
			
			$data['item'] = $this->M_bbs->get_bbs_views_my($bbs_table,$idx,$login_id);
		}
		else
		{
			$bbs_table 		= "m_bbs_notice";
			$data['table'] 	= $bbs_table;
			$data['title'] 	= "공지사항";
			
			$data['item'] = $this->M_bbs->get_bbs_views_no($bbs_table ,$idx);
		}
		
		if(empty($data['item'])){
			alert("해당글이 존재하지 않습니다.", "bbs/lists/".$bbs_name);				
		}
		
		//----------------------------------------------------------------------//

		layout('/bbs/views',$data,'office');
	}
	
	public function writer()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'나의구좌','group'=>'POINT');
		
		$login_id = $this->session->userdata('member_id');	
		$member 			= $this->M_member->get_member($login_id); // 회원정보
		$data['member'] 	= $member;
		//----------------------------------------------------------------------//
		
		$data['cat'] = $this->uri->segment(2,0);
		$table = $this->uri->segment(3,0);	
		$data['table'] = $table;
		
		if($table == 'notice'){
			$bbs = "m_notice";
			$data['title'] = "공지사항";
		}
		else{
			$bbs = "m_qna";	
			$data['title'] = "1:1문의";		
		}
		
		//----------------------------------------------------------------------//
		$this->form_validation->set_rules('subject', 'subject', 'required');
		$this->form_validation->set_rules('contents', 'contents', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('/bbs/write',$data,'office');

		} else {
			
			$this->M_bbs->bbs_write($bbs,$member->password);			
			
			alert("글 작성을 완료되었습니다", "bbs/lists/".$table);	
		}
		
	}
	
	public function edit()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'BBS');
			
		$login_id = $this->session->userdata('member_id');	
		$member = $this->M_member->get_member($login_id); // 회원정보
		$data['member'] 	= $member;
		//----------------------------------------------------------------------//
		
		$data['cat'] = $this->uri->segment(2,0);	
		$table 		= $this->uri->segment(3,0);	
		$bbs_no 		= $this->uri->segment(4,0);
		$data['table'] = $table;
		
		if($table == 'notice'){
			$bbs = "m_notice";
			$data['title'] = "공지사항";
			$data['item'] = $this->M_bbs->get_bbs_views_no($bbs,$bbs_no);
		}
		else{
			$bbs = "m_qna";	
			$data['title'] = "1:1문의";
			echo $table;
			$data['item'] = $this->M_bbs->get_bbs_views_my($bbs,$bbs_no,$login_id);		
		}
		
		//----------------------------------------------------------------------//
		$this->form_validation->set_rules('subject', 'subject', 'required');
		$this->form_validation->set_rules('contents', 'contents', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			layout('bbs/write',$data,'office');

		} else {
			
			$this->M_bbs->member_update($bbs,$bbs_no);			
			
			alert("글 수정을 완료되었습니다", "bbs/edit/".$table ."/" .$bbs_no);	
		}
		
	}
	
	
	function del()
	{	
		$table = $this->uri->segment(3,0);
		$idx = $this->uri->segment(4,0);
		
		if($table == 'notice'){
			$bbs = "m_notice";
		}
		else{
			$bbs = "m_qna";	
		}
		
		$this->db->where('bbs_no', $idx);
		$this->db->delete($bbs);
		
		alert("글 삭제 되었습니다", "bbs/lists/".$table);
		
	}
	
	
}