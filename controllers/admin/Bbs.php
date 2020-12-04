<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bbs extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','search','file'));
		$this->load->library('form_validation');

		admin_chk();

		//model load
		$this -> load -> model('M_admin');
		$this -> load -> model('M_bbs');
		$this -> load -> model('M_member');

	}

	function index()
	{
		$this->lists();		
	}
	
	
	function lists()
	{		
		$data['title'] = "게시판 리스트";
		$data['group'] = "게시판관리";		

		$data['page'] = $this->uri->segment(4,0); // 게시판며	
		
		//----------------------------------------------------------------------//
		$bbs_name = $this->uri->segment(4,0);
		$data['bbs_name'] = $bbs_name;
		
		if($bbs_name == 0)
		{
			$bbs_table = "m_bbs_notice";
			$data['table'] = $bbs_table;
			$data['title'] = "공지사항";
			$data['bbs_name'] = 'notice';
		}
		else if($bbs_name== "qna")
		{			
			$bbs_table 		= "m_bbs_qna";
			$data['table'] 	= $bbs_table;
			$data['title'] 	= "1:1문의";
		}
		else
		{
			$bbs_table 		= "m_bbs_notice";
			$data['table'] 	= $bbs_table;
			$data['title'] 	= "공지사항";	
		}
		
		$data = page_lists($bbs_table,'bbs_no',$data);

		//----------------------------------------------------------------------//
		layout('bbsLists',$data,'admin');
	}
	
	//--------------------------------------------------------------------------------------------------------//
	
	function writer()
	{
		$data = array();
		$data['title'] = "글쓰기";
		$data['group'] = "게시판관리";
		$data['mode'] = 'edit';
		$data['regdate'] = nowdate();
		
		$idx = $this->uri->segment(4,0);
		$data['idx'] = $idx;
		$bbs_name = $this->uri->segment(5,0);
		$data['bbs_name'] = $bbs_name;
		
		if($bbs_name == 0)
		{
			$bbs_table = "m_bbs_notice";
			$data['table'] = $bbs_table;
			$data['title'] = "공지사항";
			$data['bbs_name'] = 'notice';
		}
		else if($bbs_name== "qna")
		{			
			$bbs_table 		= "m_bbs_qna";
			$data['table'] 	= $bbs_table;
			$data['title'] 	= "1:1문의";
		}
		else
		{
			$bbs_table 		= "m_bbs_notice";
			$data['table'] 	= $bbs_table;
			$data['title'] 	= "공지사항";	
		}
		
		if($idx > 0){
			$data['item'] = $this->M_bbs->get_bbs($bbs_table,$idx);
		}
		//----------------------------------------------------------------------//
			
		$this->form_validation->set_rules('subject', 'subject', 'required');
		$this->form_validation->set_rules('contents', 'contents', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			layout('bbsWrite',$data,'admin');
			
		} else {
			
			$bbs_name 	= $this->input->post('bbs_name');
			$idx 		= $this->input->post('idx');
			$regdate 	= $this->input->post('regdate');
			
			if($bbs_name == 'qna')
			{
				// 답변달기
				$this->M_bbs->memo_update($bbs_table,$idx); // 등록하는 경로를 정해서 구분하기

				alert("답변 완료 되었습니다","admin/bbs/add");	
			}
			else
			{
        		// Uload Config 설정
				$config = array(
            		'upload_path' 	=> '/var/www/html/wns/www/data/uploads/',
					'allowed_types' => '*',
					'max_size' 		=> '1000',
					'max_width'  	=> '1920',
					'max_height'  	=> '1080',
					'encrypt_name' 	=> TRUE,
					'remove_spaces' => TRUE
				);   
				$this->load->library('upload', $config);
				
				$this->upload->initialize($config);
				if ( !$this->upload->do_upload("up_file"))
				{
					echo $idx;
					$file_name = '';
					$this->M_bbs->bbs_update($bbs_table,$idx,$file_name,$regdate);
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());
					$file_name = $data["upload_data"]["file_name"];
					echo $file_name;
					
					$this->M_bbs->bbs_update($bbs_table,$idx,$file_name,$regdate);
				}
			
				//alert("수정이 되었습니다","admin/bbs/lists/".$bbs_name);
				
			}
			
		}
		
	}
	
	function add()
	{
		$data = array();
		$data['title'] = "글쓰기";
		$data['group'] = "게시판관리";
		$data['regdate'] = nowdate();
		
		$member = $this->M_member->get_member($this->session->userdata('member_id')); // 회원정보
		$data['member'] = $member;
		$password = $member->password;		
		
		$bbs_name = $this->uri->segment(4,0);
		$data['bbs_name'] = $bbs_name;
		
		if($bbs_name == 0)
		{
			$bbs_table = "m_bbs_notice";
			$data['table'] = $bbs_table;
			$data['title'] = "공지사항";
		}
		else if($bbs_name== "qna")
		{			
			$bbs_table 		= "m_bbs_qna";
			$data['table'] 	= $bbs_table;
			$data['title'] 	= "1:1문의";
		}
		else
		{
			$bbs_table 		= "m_bbs_notice";
			$data['table'] 	= $bbs_table;
			$data['title'] 	= "공지사항";	
		}
			
		//----------------------------------------------------------------------//
		$this->form_validation->set_rules('subject', 'subject', 'required');
		$this->form_validation->set_rules('contents', 'contents', 'required');

		if ($this->form_validation->run() == FALSE) 
		{
			layout('bbsAdd',$data,'admin');

		} else {
			
			$regdate 		= $this->input->post('regdate');
			
        	// Uload Config 설정
        	$config = array(
            	'upload_path' 	=> '/var/www/html/wns/www/data/uploads/',
				'allowed_types' => '*',
				'max_size' 		=> '1000',
				'max_width'  	=> '1920',
				'max_height'  	=> '1080',
            	'encrypt_name' 	=> TRUE,
				'remove_spaces' => TRUE
			);   
			$this->load->library('upload', $config);
			
			$this->upload->initialize($config);
			if ( !$this->upload->do_upload("up_file"))
			{
				$file_name = '';
				$this->M_bbs->bbs_in($bbs_table,$file_name,$password,$regdate);	
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				$file_name = $data["upload_data"]["file_name"];
				$this->M_bbs->bbs_in($bbs_table,$file_name,$password,$regdate); // 등록하는 경로를 정해서 구분하기
			}
			
			alert("등록완료 되었습니다","admin/bbs/lists/".$bbs_name);
			
			/*
			if($this->upload->do_upload('upfile'))
			{
				$data = array('upload_data' => $this->upload->data());
				echo var_dump($data);
				
				$file_name = $data["upload_data"]["file_name"];
				
				$this->M_bbs->bbs_in($bbs_table,$file_name,$password,$regdate); // 등록하는 경로를 정해서 구분하기
			}
			else
			{
				$file_name = '';
				$this->M_bbs->bbs_in($bbs_table,$file_name,$password,$regdate);				
			}
			
			
			if ( !$this->upload->do_upload("up_file"))
			{
				$error = array('error' => $this->upload->display_errors());
				echo "파일업로드 실패:".var_dump($error);
				exit;
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				//var_dump($data);
				$file_name = $data["upload_data"]["file_name"];
				echo $file_name;
			}
			*/	
			
		}
		
	}
	
	
	function delete()
	{	
		//$table = $this->input->post('table');
		//$idx = $this->input->post('idx');
		
		$idx = $this->uri->segment(4,0);
		$table = $this->uri->segment(5,0);
		
		if($table == 'qna'){
			$bbs_table 		= "m_bbs_qna";
		}
		else{
			$bbs_table = "m_bbs_notice";
		}
		
		$this->db->where('bbs_no', $idx);
		$this->db->delete($bbs_table);

		goto_url($_SERVER['HTTP_REFERER']);
	}
	
}