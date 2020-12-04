<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Start extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('form','url','admin','office','search'));
		$this->load->library('form_validation');

		admin_chk();
		
		//model load
		$this -> load -> model('M_cfg');
		$this -> load -> model('M_coin');
		$this -> load -> model('M_admin');
		$this -> load -> model('M_member');
		$this -> load -> model('M_research');
		$this -> load -> model('M_point');
		$this -> load -> model('M_office');

	}

	function index()
	{
		$this->lists();
	}
	
	
	function lists()
	{		

		$login_id 	= $this->session->userdata('member_id');
		$data['mb'] 	= $this->M_member->get_member($login_id);
		$data['title'] = "대시보드";
		$data['group'] = "대시보드";
		

		$data['member_total'] 	= $this->M_research->get_member_total() - 1; 	// 가입 회원수
		
		$data['center_total'] 	= $this->M_research->get_center_total(); 		// 가입 센터수
		
		$data['uce_total'] 		= $this->M_research->get_point_total('m_point'); 		// 총 매출
		
		$data['laster'] 		= $this->M_research->get_member_his(); 			// 최근 가입한 회원
		
		$data['laster_out'] 	= $this->M_research->get_pay_out(); 			// 출금신청한 회원
		
		$data['laster_coin'] 	= $this->M_research->get_pay_coin(); 			// 
		
		/*==================================================================================*/		

		// 오늘 매출리스트
		$table 		= 'm_point';
		$start 		= nowday()." 00:00:00";
		$end 		= nowday()." 23:59:59";
		
		$data['sale'] = $this->M_point->get_point_sale_today($table,$start,$end); // 매출등록한 회원
		
		$i = 0;
		$ct = $this->M_member->get_center_li();
        foreach ($ct as $row) 
        {
	        $i = $i + 1;
			$data['ct_name'][$i] 	= $row->office;
			$data['ct_in'][$i] 		= $this->M_point->sum_point_center_date($table,$row->office,$start,$end);
			$data['ct_out'][$i] 	= $this->M_point->sum_point_center_kind_date($table,$row->office,'out',$start,$end);	        
	    }
	    $data['cnt'] = $i;
	    
	    
		/*==================================================================================*/	
			
		$data['site'] = $this->M_cfg->get_site();
		$data['change_list']	=	$this->M_cfg->getCfgwonChangeList();

		layout('start',$data,'admin');
	}

	
	function lotto()
	{		
		$data['title'] = "대시보드";
		$data['group'] = "대시보드";
	    
	    
		layout('lottery',$data,'admin');
	}

	public function setCfgwon()
	{
		$cfg_no = $this->input->post('cfg_no');
		// 2020.08.18 박종훈 코인 시세 변경 추가
		$this->M_cfg->setCoinpriceHistory();
		$this->M_cfg->setCfgwon($cfg_no);

		alert("코인 시세가 변경 되었습니다", "admin");
	}
}
?>