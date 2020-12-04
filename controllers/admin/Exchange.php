<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Exchange extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','search'));
		$this->load->library('form_validation');
		//$this->output->enable_profiler(TRUE);

		admin_chk();
				
		define('SKIN_DIR', '/views/admin');

		//model load
		$this -> load -> model('m_member');
		$this -> load -> model('m_admin');
		$this -> load -> model('m_office');
		$this -> load -> model('m_point');

	}


	function index()
	{
		$this->lists;
	}
	
	
	function lists()
	{
		$data['title'] = "출금신청 리스트";
		$data['group'] = "출금관리";

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
		
		
		$data = page_lists('m_point_uses','regdate',$data,'kind','out');
        foreach ($data['item'] as $row) {
			$row->name = $this->m_member->get_member_name($row->member_id);
        }

		layout('exchangeLists',$data,'admin');
		
	}
	
	
	function complete()
	{
		$data['title'] = "출금완료 리스트";
		$data['group'] = "출금관리";

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
		
		
		$data = page_lists('m_point_uses','regdate',$data,'kind','out','type','complete');
        foreach ($data['item'] as $row) {
			$row->name = $this->m_member->get_member_name($row->member_id);
        }

		layout('exchangeLists',$data,'admin');
		
	}
	
	
	function request()
	{
		$data['title'] = "출금신청 중 리스트";
		$data['group'] = "출금관리";

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
		
		
		$data = page_lists('m_point_uses','regdate',$data,'kind','out','type','request');
        foreach ($data['item'] as $row) {
			$row->name = $this->m_member->get_member_name($row->member_id);
        }

		layout('exchangeLists',$data,'admin');
		
	}


	
	function write()
	{
		$data['title'] = "출금신청 신청하기";
		$data['group'] = "출금관리";


		$point_idx  = $this->uri->segment(4,0);
		
		$this->form_validation->set_rules('hidden', 'hidden', 'required');

		$data['item'] = $this->m_point->get_point_no('m_point_uses',$point_idx);

		if ($this->form_validation->run() == FALSE) {

			$this->load->view('admin/exchangeWrite',$data);

		} else {
			
			$this->m_admin->exchange_edit('m_point_uses',$point_idx);
			alert("저장이 완료 되었습니다", "admin/exchange/write/".$point_idx."");

		}
	}
	
	
	// 출금정보 삭제
	function delete()
	{
		$idx = $this->input->post('idx');
				
		$this->db->where('point_no', $idx);
		$this->db->delete('m_point');
		
		goto_url($_SERVER['HTTP_REFERER']);
		
	}
	
	
	// 팝업창 출금리스트
	function find()
	{
		$data['title'] = "환전 신청 리스트검색";
		$data['group'] = "출금관리";
		

		$this->form_validation->set_rules('startday', 'startday', 'required');

		if ($this->form_validation->run() == FALSE) {
			
			$this->load->view('admin/exchangeFind',$data);

		} else {
		
			$start = $this->input->post('startday').' 00:00:00';
			$end = $this->input->post('endday').' 23:59:59';
			$type = $this->input->post('kind');
			
			$table = 'm_point_uses';
			$data['item'] = $this->m_admin->exchangefind($table,$start,$end,$type);
			
			// 가공
			$data['total'] = 0;
			foreach ($data['item'] as $row) {
				$member = $this->m_member->get_member($row->member_id);
					$row->mobile = $member->mobile;
					$row->name = $member->name;
					$row->regdate =  substr($row->regdate,0,10);
					
				$data['total'] = $data['total'] + $row->saved_point;
			}
		
			$this->load->view('admin/exchangeFindLists',$data);

		}		
	}
	
	
	// 출금 리스트 일괄 승인
	function findset()
	{
		$data['title'] = "환전 신청 리스트검색";
		$data['group'] = "출금관리";
		
		$start = $this->input->post('startday').' 00:00:00';
		$end = $this->input->post('endday').' 23:59:59';		
		
		$table = 'm_point_uses';
		$this->m_admin->exchangeupdate($table,$start,$end);
		alert("저장이 완료 되었습니다", "admin/exchange/find");
		
	}
	

	//관리용
	function excel1()
	{
		$this->load->helper('download');
		$nowDay = nowday();
		$headers = '';
		$start = $this->input->post('startday');
		$end = $this->input->post('endday');
		
		$sendDay = date("Y-m-d", strtotime($end."+3day")); // 지급일은 다음날
	
		$kind = $this->input->post('kind');
		$table = 'm_point_uses';
		$item = $this->m_admin->banking_list1($table,$start,$end,$kind);	
			
		$excel="
		<table width='1400' border='1' cellspacing=0 cellpadding=0>
		<tr>
			<td height='50' width='100%' align='center' style='font-size: 30px;' colspan='10'><b>"
			.$end
			." 출금신청 (지급일 = "
			.$sendDay
			.")"
			."</b></td>
		</tr>"; 
		$excel.= "</table>";								

		$i = 1;
		$excel.="
		<table width='1400' border='1' cellspacing=0 cellpadding=0>
		<tr bgcolor='#f2f2f2'>
			<td height='40' align='center' style='font-size: 14px;'><b>신청No</b></td>
			<td align='center' style='font-size: 14px;'><b>번호</b></td>
			<td align='center' style='font-size: 14px;'><b>그룹</b></td>
			<td align='center' style='font-size: 14px;'><b>지점</b></td>
			<td align='center' style='font-size: 14px;'><b>아이디</b></td>
			<td align='center' style='font-size: 14px;'><b>이름</b></td>
			<td align='center' style='font-size: 14px;'><b>예금주</b></td>
			<td align='center' style='font-size: 14px;'><b>계좌번호</b></td>
			<td align='center' style='font-size: 14px;'><b>은행명</b></td>
			<td align='center' style='font-size: 14px;'><b>신청금액</b></td>
			<td align='center' style='font-size: 14px;'><b>송금액</b></td>
			<td align='center' style='font-size: 14px;'><b>수수료</b></td>
			<td align='center' style='font-size: 14px;'><b>여행페이5%</b></td>	
			<td align='center' style='font-size: 14px;'><b>신청일</b></td>
		</tr>";
		
		foreach ($item as $row) {
			
			$row->reg_pay 	= $row->point;
			$row->bank_fee 	= $row->point * 0.1;
			
			if($row->point < 200000){
				$row->tour_pay 	= 0;				
			}
			else{
				$row->tour_pay 	= $row->point * 0.05;				
			}
			
			$row->point 		= $row->point - ($row->bank_fee + $row->tour_pay);
			
			$mb = $this->m_member->get_member($row->member_id);
			//$row->point = $row->point * 1000;
		$excel.="
		<tr>
			<td height='30' align='center' style='font-size: 12px;'>".$row->point_no."</td>
			<td align='center' style='font-size: 12px;'>".$i."</td>
			<td align='center' style='font-size: 12px;'>".$mb->office_group."</td>
			<td align='center' style='font-size: 12px;'>".$mb->office."</td>
			<td align='center' style='font-size: 12px;'>".$row->member_id."</td>
			<td align='center' style='font-size: 12px;'>".$mb->name."</td>
			<td align='center' style='font-size: 12px;'>".$mb->bank_holder."</td>
			<td align='center' style='font-size: 12px; mso-number-format:\@'>".$mb->bank_number."</td>
			<td align='center' style='font-size: 12px;'>".$mb->bank_name."</td>
			<td align='center' style='font-size: 12px;'>".number_format($row->reg_pay)."</td>
			<td align='center' style='font-size: 12px;'>".number_format($row->point)."</td>
			<td align='center' style='font-size: 12px;'>".number_format($row->bank_fee)."</td>
			<td align='center' style='font-size: 12px;'>".number_format($row->tour_pay)."</td>
			<td align='center' style='font-size: 12px;'>".$row->regdate."</td>
		</tr>";
		$i++;
		}
		
		$excel.= "</table>"; 


		//$excel= iconv("UTF-8", "ISO-8859-1", $excel);
		//$excel= iconv("UTF-8", "EUC-KR", $excel);
		//$excel= iconv("CP949", "UTF-8//TRANSLIT", $excel);
		//$excel=iconv("UTF-8", "ISO-8859-1//TRANSLIT", $excel);
		//$excel=iconv("UTF-8", "ISO-8859-1//IGNORE", $excel);
		//$excel=iconv("UTF-8", "ISO-8859-1", $excel); 
		
		//echo 'Original : ', $excel, PHP_EOL; 
		//echo 'TRANSLIT : ', iconv("UTF-8", "ISO-8859-1//TRANSLIT", $excel), PHP_EOL; 
		//echo 'IGNORE  : ', iconv("UTF-8", "ISO-8859-1//IGNORE", $excel), PHP_EOL; 
		//echo 'Plain    : ', iconv("UTF-8", "ISO-8859-1", $excel), PHP_EOL;

		$name = 'AdminBank_'.nowday().'.xls';
		
		//header("Content-type: application/vnd.ms-excel; charset=euc-kr");
		//header("Content-Description: PHP4 Generated Data");
		//header("Content-Disposition: attachment; filename=$name.xls");
		//print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");



		header( "Content-type: application/vnd.ms-excel; charset=euc-kr"); 
		header( "Content-Disposition: attachment; filename=$name" ); 
		header( "Content-Description: PHP4 Generated Data" ); 
		print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

		echo "$headers\n$excel";
		

	}


	
	// 은행용
	function excel2()
	{
		$this->load->helper('download');
		
			$headers = '';
			$start = $this->input->post('startday');
			$end = $this->input->post('endday');
			$kind = $this->input->post('kind');
			
		$table = 'm_point_uses';
			$item = $this->m_admin->banking_list1($table,$start,$end,$kind);
			
			
		$i = 1;

		$excel="

		<table width='1400' border='1' cellspacing=0 cellpadding=0>
		<tr bgcolor='#f2f2f2'>
			
			<td align='center'>은행명</td>
			<td align='center'>계좌번호</td>
			<td align='center'>실입금액</td>
			<td align='center'>예금주</td>
			<td align='center'>회원명</td>
		</tr>";
		
		foreach ($item as $row) {
			
			$row->reg_pay 	= $row->point;
			$row->bank_fee 	= $row->point * 0.1;
			$row->tour_pay 	= $row->point * 0.05;
			$row->point 		= $row->point - ($row->bank_fee + $row->tour_pay);
			
			$mb = $this->m_member->get_member($row->member_id);
		
		
		
		$excel.="
		<tr>
			
			<td align='center'>".$mb->bank_name."</td>
			<td align='center' style='mso-number-format:\@'>".$mb->bank_number."</td>
			<td align='center'>".number_format($row->point)."</td>
			<td align='center'>".$mb->bank_holder."</td>
			<td align='center'>".$row->member_id."</td>
			
		</tr>";
		$i++;
		}
		
		$excel.= "</table>"; 
		


		$excel= iconv("UTF-8", "EUC-KR", $excel);


		$name = 'ITBank_'.nowday().'.xls';
		
		header( "Content-type: application/vnd.ms-excel; charset=euc-kr"); 
		header( "Content-Disposition: attachment; filename=$name" ); 
		header( "Content-Description: PHP4 Generated Data" ); 
		print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

		echo "$headers\n$excel";
		

	}
}
?>