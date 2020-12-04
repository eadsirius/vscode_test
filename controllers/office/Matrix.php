<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Matrix extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url','admin','search'));
		$this->load->library('form_validation');

		$this -> load -> model('M_office');
		$this -> load -> model('M_point');
		$this -> load -> model('M_member');
		$this -> load -> model('M_admin');
		$this ->lang = get_cookie('lang');

		loginCheck();
		// 2020.07.22 박종훈 추가
		if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {
			$this->output->enable_profiler($this->config->item('profiler'));
		}
	}


	function index()
	{
		$data = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'OFFICE');
	
		$login_id = $this->session->userdata('member_id');
		$data['cnt'] = $this->M_member->get_recommend_chk($login_id); // 총 추천수
		
		$data['account_li'] = $this->M_member->get_recommend_li($login_id); // 어카운트 리스트 가져오기
        foreach ($data['account_li'] as $row) 
        {	
	        /*
			//---------------------------------------------------------------------------------//
			$balance = pay_balance($row->member_id); // 잔고
		
			$data['freeBal'] 		= $balance['freeBal'];		// 캐쉬 잔고
			$data['accuBal'] 		= $balance['accuBal'];		// 예금 잔고
			$data['usesBal'] 		= $balance['usesBal'];		// 코인 잔고
			$row->pay 				= $balance['accuBal'];		// 총 잔고
			//---------------------------------------------------------------------------------//
			*/
			$row->name = $this->M_member->get_member_name($row->member_id);
        }  
		
		$data['auth'] = md5($login_id );		

		layout('office/matrixRe',$data,'office');

	}


	function sp()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'PAY','group'=>'OFFICE'); 
		
		$login_id = $this->session->userdata('member_id');
		
		$mb = $this->M_member->get_member($login_id);
			$data['vlm_left'] 		=$mb->vlm_left;
			$data['vlm_left_point'] 	=$mb->vlm_left_point;
			$data['vlm_right'] 		=$mb->vlm_right;
			$data['vlm_right_point'] =$mb->vlm_right_point;
			$data['vlm_total'] 		=$mb->vlm_left_point + $mb->vlm_right_point;	
			
		if($mb->vlm_left_point >= $mb->vlm_right_point){
			$data['vlm_so'] = 'right';
		}
		else{
			$data['vlm_so'] = 'left';			
		}
		
		//---------------------------------------------------------------------------------//
		// 가공 - 총 매출 금액확인
		$i = 0;
		$amount = 0;
		$data = page_lists('m_volume','vlm_no',$data,'member_id',$login_id);
        foreach ($data['item'] as $row) 
        {
			$i = $i + 1;
			/*
			//---------------------------------------------------------------------------------//
			$balance = pay_balance($row->event_id); // 잔고
		
			$data['freeBal'] 		= $balance['freeBal'];		// 캐쉬 잔고
			$data['accuBal'] 		= $balance['accuBal'];		// 예금 잔고
			$data['usesBal'] 		= $balance['usesBal'];		// 코인 잔고
			$row->pay 				= $balance['accuBal'];		// 총 잔고
			$amount = $amount + $row->pay;
			//---------------------------------------------------------------------------------//
			*/
			$row->name = $this->M_member->get_member_name($row->event_id);
   		}
        
		$data['cnt'] 		= $i;
		$data['amount'] 	= $amount;        
		$data['auth'] 	= md5($login_id);	
		
		layout('office/matrixSp',$data,'office');
	}


}

?>
