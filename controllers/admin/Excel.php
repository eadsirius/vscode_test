<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Excel extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','admin','search'));
		$this->load->helper('download');
		
		$this->load->library('form_validation');

		define('SKIN_DIR', '/views/admin');

		//admin_chk();

		//model load
		$this -> load -> model('M_admin');
		$this -> load -> model('M_member');
		$this -> load -> model('M_office');
		$this -> load -> model('M_point');
		$this -> load -> model('M_coin');

	}
	
	
	//----------------------------------------------------------------------------------------//
	// 지점별
	function center()
	{		
		
		$office   = $this->uri->segment(4,0);
		$office = URLDecode($office); // 한글 인코딩부분 처리
		$login_id = $this->session->userdata('member_id');

		if($office == '' or $office == 0)
		{
			$item = $this->M_member->get_center_li();	
			
			$i = 1;
			$headers = '';
		
			$excel="
			<table width='1400' border='1' cellspacing=0 cellpadding=0>
			<tr bgcolor='#f2f2f2'>
				<td height='35' align='center'>번호</td>
				<td align='center'>그룹</td>
				<td align='center'>지점명</td>
				<td align='center'>지점장아이디</td>
				<td align='center'>지점장이름</td>
				<td align='center'>지점장연락처</td>
				<td align='center'>지점추천인</td>
				<td align='center'>등록일</td>
				</tr>";
		
			foreach ($item as $row) {
				$row->name = $this->M_member->get_member_name($row->member_id);

			$excel.="
			<tr>
				<td height='25' align='center'>".$i."</td>
				<td align='center'>".$row->office_group."</td>
				<td align='center'>".$row->office."</td>
				<td align='center'>".$row->member_id."</td>
				<td align='center'>".$row->name."</td>
				<td align='center'>".$row->mobile."</td>
				<td align='center'>".$row->office_recommend_id."</td>
				<td align='center'>".$row->regdate."</td>
			</tr>";
			$i++;
			}
			$excel.= "</table>"; 

			$excel= iconv("UTF-8", "EUC-KR", $excel);
			$name = 'Center_'.nowday().'.xls';
	
			header( "Content-type: application/vnd.ms-excel; charset=euc-kr"); 
			header( "Content-Disposition: attachment; filename=$name" ); 
			header( "Content-Description: PHP4 Generated Data" ); 
			print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

			echo "$headers\n$excel";
		}
		else
		{			
			$item = $this->M_member->get_member_center($office);
			if(empty($item)){				
				alert("검색한 센타명을 확인하세요. ");	
			}
			//---------------------------------------------------------------------------------//
			
			$i = 1;		
			$headers = '';
 
			$excel="
			<table width='1400' border='1' cellspacing=0 cellpadding=0>
				<tr bgcolor='#f2f2f2'>
				<td height='35' align='center'>번호</td>
				<td align='center'>소속</td>
				<td align='center'>아이디</td>
				<td align='center'>회원이름</td>
				<td align='center'>전화번호</td>
				<td align='center'>추천인</td>
				<td align='center'>후원인</td>
				<td align='center'>직급</td>
				<td align='center'>매출구분</td>
				<td align='center'>코인잔고</td>
				<td align='center'>총매출</td>
				<td align='center'>총수당</td>
				<td align='center'>등록일</td>
			</tr>";
		
			foreach ($item as $row) 
			{
				//---------------------------------------------------------------------------------//
				$bal 	= $this->M_coin->get_balance($row->member_no);
					$su 		= $bal->total_point;
					//$su 		= $bal->su_day + $bal->su_re + $bal->su_re2 + $bal->su_sp_roll + $bal->su_ct + $bal->su_ct_re;
				//---------------------------------------------------------------------------------//

				$excel.="
				<tr>
					<td height='25' align='center'>".$i."</td>
					<td align='center'>".$row->office."</td>
					<td align='center'>".$row->member_id."</td>
					<td align='center'>".$row->name."</td>
					<td align='center'>".$row->mobile."</td>
					<td align='center'>".$row->recommend_id."</td>
					<td align='center'>".$row->sponsor_id."</td>
					<td align='center'>".$bal->level."</td>
					<td align='center'>".$bal->puchase."</td>
					<td align='center' style='mso-number-format:\@'>".$bal->coin."</td>
					<td align='center' style='mso-number-format:\@'>".$bal->volume."</td>
					<td align='center' style='mso-number-format:\@'>".$su."</td>
					<td align='center'>".$row->regdate."</td>
				</tr>";
				$i++;
			}
		
			$excel.= "</table>"; 

			//$excel= iconv("UTF-8", "EUC-KR", $excel);
			$name = $office ."_" .nowday().'.xls';
	
			header( "Content-type: application/vnd.ms-excel; charset=euc-kr"); 
			header( "Content-Disposition: attachment; filename=$name" ); 
			header( "Content-Description: PHP4 Generated Data" ); 
			print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

			echo "$headers\n$excel";
			
		}
		
	}
	
	// 그룹별
	function group()
	{		
			
			$item = $this->M_member->get_group_li();
			
			$i = 1;
			$headers = '';
		
			$excel="
			<table width='1400' border='1' cellspacing=0 cellpadding=0>
			<tr bgcolor='#f2f2f2'>
				<td height='35' align='center'>번호</td>
				<td align='center'>그룹명</td>
				<td align='center'>그룹장아이디</td>
				<td align='center'>그룹장이름</td>
				<td align='center'>등록일</td>
				</tr>";
		
			foreach ($item as $row) {
				$row->name = $this->M_member->get_member_name($row->member_id);

			$excel.="
			<tr>
				<td height='25' align='center'>".$i."</td>
				<td align='center'>".$row->group_name."</td>
				<td align='center'>".$row->member_id."</td>
				<td align='center'>".$row->name."</td>
				<td align='center'>".$row->regdate."</td>
			</tr>";
			$i++;
			}
			$excel.= "</table>"; 

			$excel= iconv("UTF-8", "EUC-KR", $excel);
			$name = 'Group_'.nowday().'.xls';
	
			header( "Content-type: application/vnd.ms-excel; charset=euc-kr"); 
			header( "Content-Disposition: attachment; filename=$name" ); 
			header( "Content-Description: PHP4 Generated Data" ); 
			print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

			echo "$headers\n$excel";
		
	}
	//----------------------------------------------------------------------------------------//
	
	function member()
	{		
		
		$search   	= $this->uri->segment(4,0);
		$search 	= URLDecode($search); // 한글 인코딩부분 처리
		$select   	= $this->uri->segment(5,0);
		$select 	= URLDecode($select); // 한글 인코딩부분 처리
		
		if($search == '' or $search == '0'){
			$item = $this->M_member->get_member_li();
		}
		else{		
			$item = $this->M_member->get_member_select_li($select,$search);	
		}
			
			
			$i = 1;
			$headers = '';
		
			$excel="
			<table width='1400' border='1' cellspacing=0 cellpadding=0>
			<tr bgcolor='#f2f2f2'>
				<td height='35' align='center'>번호</td>
				<td align='center'>아이디</td>
				<td align='center'>회원이름</td>
				<td align='center'>전화번호</td>
				<td align='center'>추천인</td>
				<td align='center'>총매출</td>
				<td align='center'>총수당</td>
				<td align='center'>등록일</td>
				</tr>";
		
		
			foreach ($item as $row) 
			{
				//---------------------------------------------------------------------------------//
				$bal 	= $this->M_coin->getBalanceList($row->member_no,$row->member_id);
				//---------------------------------------------------------------------------------//

				$excel.="
				<tr>
					<td height='25' align='center'>".$i."</td>
					<td align='center'>".$row->member_id."</td>
					<td align='center'>".$row->name."</td>
					<td align='center' style='mso-number-format:\@'>".$row->mobile."</td>
					<td align='center'>".$row->recommend_id."</td>
					<td align='center' style='mso-number-format:\@'>".number_format($bal->total_sales)."</td>
					<td align='center' style='mso-number-format:\@'>".number_format($bal->total_point)."</td>
					<td align='center'>".date("Y-m-d H:i:s",strtotime($row->regdate." +9 hours"))."</td>
				</tr>";
				$i++;
			}
			
			$excel.= "</table>"; 

			$excel= iconv("UTF-8", "EUC-KR", $excel);
			$name = 'Member_'.nowday().'.xls';
	
			header( "Content-type: application/vnd.ms-excel; charset=euc-kr"); 
			header( "Content-Disposition: attachment; filename=$name" ); 
			header( "Content-Description: PHP4 Generated Data" ); 
			print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

			echo "$headers\n$excel";
		
	}
	
	function member_kind()
	{		
		$search   	= $this->uri->segment(5,0);
		$search 	= URLDecode($search); // 한글 인코딩부분 처리
		$select   	= $this->uri->segment(4,0);
		$select 	= URLDecode($select); // 한글 인코딩부분 처리
		
		$item = $this->M_member->get_member_select_li($select,$search);
			
			
			$i = 1;
			$headers = '';
		
			$excel="
			<table width='1400' border='1' cellspacing=0 cellpadding=0>
			<tr bgcolor='#f2f2f2'>
				<td height='35' align='center'>번호</td>
				<td align='center'>그룹명</td>
				<td align='center'>센타명</td>
				<td align='center'>아이디</td>
				<td align='center'>회원이름</td>
				<td align='center'>전화번호</td>
				<td align='center'>추천인</td>
				<td align='center'>후원인</td>
				<td align='center'>직급</td>
				<td align='center'>매출구분</td>
				<td align='center'>코인잔고</td>
				<td align='center'>총매출</td>
				<td align='center'>총수당</td>
				<td align='center'>등록일</td>
				</tr>";
		
		
			foreach ($item as $row) 
			{
				//---------------------------------------------------------------------------------//
				$bal 	= $this->M_coin->get_balance($row->member_no);
					$su 		= $bal->total_point;
					//$su 		= $bal->su_day + $bal->su_re + $bal->su_re2 + $bal->su_sp_roll + $bal->su_ct + $bal->su_ct_re;
				//---------------------------------------------------------------------------------//

				$excel.="
				<tr>
					<td height='25' align='center'>".$i."</td>
					<td align='center'>".$row->office_group."</td>
					<td align='center'>".$row->office."</td>
					<td align='center'>".$row->member_id."</td>
					<td align='center'>".$row->name."</td>
					<td align='center' style='mso-number-format:\@'>".$row->mobile."</td>
					<td align='center'>".$row->recommend_id."</td>
					<td align='center'>".$bal->level."</td>
					<td align='center'>".$bal->puchase."</td>
					<td align='center' style='mso-number-format:\@'>".$bal->coin."</td>
					<td align='center' style='mso-number-format:\@'>".$bal->volume."</td>
					<td align='center' style='mso-number-format:\@'>".$su."</td>
					<td align='center'>".$row->regdate."</td>
				</tr>";
				$i++;
			}
			
			$excel.= "</table>"; 

			$excel= iconv("UTF-8", "EUC-KR", $excel);
			$name = 'Member_'.nowday().'.xls';
	
			header( "Content-type: application/vnd.ms-excel; charset=euc-kr"); 
			header( "Content-Disposition: attachment; filename=$name" ); 
			header( "Content-Description: PHP4 Generated Data" ); 
			print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

			echo "$headers\n$excel";
		
	}
	//----------------------------------------------------------------------------------------//
	
	function member_level()
	{		
		$search   	= $this->uri->segment(5,0);
		$search 	= URLDecode($search); // 한글 인코딩부분 처리
		$select   	= $this->uri->segment(4,0);
		$select 	= URLDecode($select); // 한글 인코딩부분 처리
		
		$item = $this->M_point->get_balance_select_li($select,$search);
			
			
			$i = 1;
			$headers = '';
		
			$excel="
			<table width='1400' border='1' cellspacing=0 cellpadding=0>
			<tr bgcolor='#f2f2f2'>
				<td height='35' align='center'>번호</td>
				<td align='center'>그룹명</td>
				<td align='center'>센타명</td>
				<td align='center'>아이디</td>
				<td align='center'>회원이름</td>
				<td align='center'>전화번호</td>
				<td align='center'>추천인</td>
				<td align='center'>후원인</td>
				<td align='center'>직급</td>
				<td align='center'>매출구분</td>
				<td align='center'>코인잔고</td>
				<td align='center'>총매출</td>
				<td align='center'>적립방잔고</td>	
				<td align='center'>현금방잔고</td>
				<td align='center'>총수당</td>
				<td align='center'>등록일</td>
				</tr>";
		
		
			foreach ($item as $row) 
			{
				//---------------------------------------------------------------------------------//
				$mb 	= $this->M_member->get_member($row->member_id);
					$su 		= $bal->total_point;
					//$su 		= $bal->su_day + $bal->su_re + $bal->su_re2 + $bal->su_sp_roll + $bal->su_ct + $bal->su_ct_re;
				//---------------------------------------------------------------------------------//

				$excel.="
				<tr>
					<td height='25' align='center'>".$i."</td>
					<td align='center'>".$mb->office_group."</td>
					<td align='center'>".$mb->office."</td>
					<td align='center'>".$row->member_id."</td>
					<td align='center'>".$mb->name."</td>
					<td align='center'>".$mb->mobile."</td>
					<td align='center'>".$mb->recommend_id."</td>
					<td align='center'>".$mb->sponsor_id."</td>
					<td align='center'>".$row->level."</td>
					<td align='center'>".$row->puchase."</td>
					<td align='center' style='mso-number-format:\@'>".$row->coin."</td>
					<td align='center' style='mso-number-format:\@'>".$row->volume."</td>
					<td align='center' style='mso-number-format:\@'>".$row->point_accu."</td>
					<td align='center' style='mso-number-format:\@'>".$row->point_free."</td>
					<td align='center' style='mso-number-format:\@'>".$su."</td>
					<td align='center'>".$mb->regdate."</td>
				</tr>";
				$i++;
			}
			
			$excel.= "</table>"; 

			$excel= iconv("UTF-8", "EUC-KR", $excel);
			$name = 'MemberLevel_'.nowday().'.xls';
	
			header( "Content-type: application/vnd.ms-excel; charset=euc-kr"); 
			header( "Content-Disposition: attachment; filename=$name" ); 
			header( "Content-Description: PHP4 Generated Data" ); 
			print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

			echo "$headers\n$excel";
		
	}
	//----------------------------------------------------------------------------------------//
	
	function balance()
	{
		
		$item = $this->M_point->get_balance_li();
			
			
			$i = 1;
			$headers = '';
		
			$excel="
			<table width='1400' border='1' cellspacing=0 cellpadding=0>
			<tr bgcolor='#f2f2f2'>
				<td height='35' align='center'>번호</td>
				<td align='center'>아이디</td>
				<td align='center'>회원이름</td>
				<td align='center'>추천인</td>
				<td align='center'>후원인</td>
				<td align='center'>직급</td>
				<td align='center'>매출구분</td>
				<td align='center'>코인잔고</td>
				<td align='center'>총매출</td>
				<td align='center'>적립방잔고</td>	
				<td align='center'>현금방잔고</td>
				<td align='center'>총수당</td>
				<td align='center'>데일리수당</td>
				<td align='center'>후원수당</td>
				<td align='center'>후원롤업수당</td>
				<td align='center'>추천매칭수당</td>
				<td align='center'>직급수당</td>
				<td align='center'>센타비</td>
				<td align='center'>그룹비</td>
				<td align='center'>등록일</td>
				</tr>";
		
			foreach ($item as $row) 
			{
				//---------------------------------------------------------------------------------//
				$mb 	= $this->M_member->get_member($row->member_id);
				
					$su 		= $row->total_point;
					//$su 		= $bal->su_day + $bal->su_re + $bal->su_re2 + $bal->su_sp_roll + $bal->su_ct + $bal->su_ct_re;
				//---------------------------------------------------------------------------------//

				$excel.="
				<tr>
					<td height='25' align='center'>".$i."</td>
					<td align='center'>".$row->member_id."</td>
					<td align='center'>".$mb->name."</td>
					<td align='center'>".$mb->recommend_id."</td>
					<td align='center'>".$mb->sponsor_id."</td>
					<td align='center'>".$row->level."</td>
					<td align='center'>".$row->puchase."</td>
					<td align='center' style='mso-number-format:\@'>".$row->coin."</td>
					<td align='center' style='mso-number-format:\@'>".$row->volume."</td>
					<td align='center' style='mso-number-format:\@'>".$row->point_accu."</td>
					<td align='center' style='mso-number-format:\@'>".$row->point_free."</td>
					<td align='center' style='mso-number-format:\@'>".$su."</td>
					<td align='center' style='mso-number-format:\@'>".$row->su_day."</td>
					<td align='center' style='mso-number-format:\@'>".$row->su_sp."</td>
					<td align='center' style='mso-number-format:\@'>".$row->su_sp_roll."</td>
					<td align='center' style='mso-number-format:\@'>".$row->su_re_roll."</td>
					<td align='center' style='mso-number-format:\@'>".$row->su_leader."</td>
					<td align='center' style='mso-number-format:\@'>".$row->su_ct."</td>
					<td align='center' style='mso-number-format:\@'>".$row->su_gb."</td>
					<td align='center'>".$mb->regdate."</td>
				</tr>";
				$i++;
			}
			
			$excel.= "</table>"; 

			$excel= iconv("UTF-8", "EUC-KR", $excel);
			$name = 'MemberBalance_'.nowday().'.xls';
	
			header( "Content-type: application/vnd.ms-excel; charset=euc-kr"); 
			header( "Content-Disposition: attachment; filename=$name" ); 
			header( "Content-Description: PHP4 Generated Data" ); 
			print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

			echo "$headers\n$excel";
		
	}
	
	//----------------------------------------------------------------------------------------//
	
	function purchase()
	{
		$i = 1;
		$headers = '';
		
		$excel="
		<table width='1400' border='1' cellspacing=0 cellpadding=0>
		<tr bgcolor='#f2f2f2'>
			<td height='35' align='center'>번호</td>
			<td align='center'>센터명</td>
			<td align='center'>아이디</td>
			<td align='center'>회원이름</td>
			<td align='center'>Point</td>
			<td align='center'>매출</td>
			<td align='center'>구분</td>
			<td align='center'>등록일</td>
		</tr>";
			
		// 가공 - 총 매출 금액확인
		$list = $this->M_point->get_point_li('m_point','purchase');
		
        foreach ($list as $row) 
        {
			$name = $this->M_member->get_member_name($row->member_id);
									
			if($row->kind == 'cash'){
				$kind = '현금매출';
			}
			else if($row->kind == 'complate'){
				$kind = 'SVP매출';
			}
			else if($row->kind == 'card'){
				$kind = '카드매출';
			}
			else if($row->kind == 'no'){
				$kind = '인정매출';
			}
			else{
				$kind = '기타매출';										
			}
				
			$excel.="
			<tr>
				<td height='25' align='center'>".$i."</td>
				<td align='center'>".$row->office."</td>
				<td align='center'>".$row->member_id."</td>
				<td align='center'>".$name."</td>
				<td align='center' style='mso-number-format:\@'>".$row->point."</td>
				<td align='center' style='mso-number-format:\@'>".$row->saved_point."</td>
				<td align='center'>".$kind."</td>
				<td align='center'>".$row->regdate."</td>
			</tr>";
			$i++;
        }
			
		$excel.= "</table>"; 

		$excel= iconv("UTF-8", "EUC-KR", $excel);
		$name = 'Purchase_'.nowday().'.xls';
	
		header( "Content-type: application/vnd.ms-excel; charset=euc-kr"); 
		header( "Content-Disposition: attachment; filename=$name" ); 
		header( "Content-Description: PHP4 Generated Data" ); 
		print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

		echo "$headers\n$excel";
	}
	//----------------------------------------------------------------------------------------//
	
	function pointEx()
	{
		$i = 1;
		$headers = '';
		
		$excel="
		<table width='1400' border='1' cellspacing=0 cellpadding=0>
		<tr bgcolor='#f2f2f2'>
			<td height='35' align='center'>번호</td>
			<td align='center'>아이디</td>
			<td align='center'>회원이름</td>
			<td align='center'>구분</td>
			<td align='center'>출금신청금액</td>
			<td align='center'>수수료</td>
			<td align='center'>실출금금액</td>
			<td align='center'>등록일</td>
			<td align='center'>완료일</td>
		</tr>";
			
		// 가공 - 총 매출 금액확인
		$list = $this->M_point->get_point_li('m_point_out','out');
		
        foreach ($list as $row) 
        {
			$mb = $this->M_member->get_member($row->member_id);
									
			if($row->kind == 'request'){
				$kind = '요청중';
			}
			else{
				$kind = '출금완료';										
			}
				
			$excel.="
			<tr>
				<td height='25' align='center'>".$i."</td>
				<td align='center'>".$row->member_id."</td>
				<td align='center'>".$mb->name."</td>
				<td align='center'>".$kind."</td>
				<td align='center' style='mso-number-format:\@'>".$row->point."</td>
				<td align='center' style='mso-number-format:\@'>".$row->saved_point."</td>
				<td align='center' style='mso-number-format:\@'>".$row->bank_fee."</td>
				<td align='center'>".$row->regdate."</td>
				<td align='center'>".$row->appdate."</td>
			</tr>";
			$i++;
        }
			
		$excel.= "</table>"; 

		$excel= iconv("UTF-8", "EUC-KR", $excel);
		$name = 'Out_'.nowday().'.xls';
	
		header( "Content-type: application/vnd.ms-excel; charset=euc-kr"); 
		header( "Content-Disposition: attachment; filename=$name" ); 
		header( "Content-Description: PHP4 Generated Data" ); 
		print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

		echo "$headers\n$excel";
	}
	
	
	//----------------------------------------------------------------------------------------//
	function pointSu()
	{		
		$this->load->dbforge();
		$this->dbforge->drop_table('m_total_su');
		$fields = array(
			'point_no'=>array(
				'type'=>'INT',
				'constraint'=>11,
				'unsigned'=>TRUE,
				'auto_increment'=>TRUE
			),
			'office'=>array(
				'type'=>'VARCHAR',
				'constraint'=>255
			),
			'name'=>array(
				'type'=>'VARCHAR',
				'constraint'=>255
			),
			'member_id'=>array(
				'type'=>'VARCHAR',
				'constraint'=>255
			),
			'recommend_id'=>array(
				'type'=>'VARCHAR',
				'constraint'=>255
			),
			're_name'=>array(
				'type'=>'VARCHAR',
				'constraint'=>255
			),
			'fee'=>array(
				'type'=>'DOUBLE'
			),
			'point'=>array(
				'type'=>'DOUBLE'
			),
			'saved_point'=>array(
				'type'=>'DOUBLE'
			),
			'day'=>array(
				'type'=>'DOUBLE'
			),
			'mc'=>array(
				'type'=>'DOUBLE'
			),
			'mc2'=>array(
				'type'=>'DOUBLE'
			),
			're'=>array(
				'type'=>'DOUBLE'
			),
			're2'=>array(
				'type'=>'DOUBLE'
			),
			'level'=>array(
				'type'=>'DOUBLE'
			),
			'ct'=>array(
				'type'=>'INT',
				'constraint'=>11,
				'default'=>0
			),	
			'address'=>array(
				'type'=>'VARCHAR',
				'constraint'=>255
			),
			'wallet'=>array(
				'type'=>'VARCHAR',
				'constraint'=>255
			),
			'startdate'=>array(
				'type'=>'VARCHAR',
				'constraint'=>255
			),
			'enddate'=>array(
				'type'=>'VARCHAR',
				'constraint'=>255
			),
			'regdate'=>array(
				'type'=>'VARCHAR',
				'constraint'=>255
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('point_no',TRUE);
		$this->dbforge->create_table('m_total_su');
		//------------------------------------------------------------------------------------------------------//
		$table		= 'm_point_su';
		$db_table	= 'm_total_su';
		$nowdate 	= nowdate();
		$sdate 		= $this->input->post('start');
		$edate 		= $this->input->post('end');	
		//$today		= nowday();
		$sdate 		= $sdate." 00:00:00";				
		$edate 		= $edate." 23:59:59";
		
		$list = $this->M_point->get_total_datetime($table,$sdate,$edate);
		foreach ($list as $row)
		{
			$address 	= $this->M_coin->get_wallet_address($row->member_id,'wns');
			if(empty($address)){$address='';}
			
			$wallet='';
			//$wallet 	= $this->M_coin->get_wallet_address($row->member_id,'exchange');
			//if(empty($wallet)){$wallet='';}
			
			$bal 		= $this->M_point->get_balance_id($row->member_id);
			$mb 		= $this->M_member->get_member($row->member_id);
			
			if($row->member_id == 'admin'){
				$mb->recommend_id 	= '';
				$re_name 			= '';	
			}
			else{
				//echo  "$row->member_id // $mb->recommend_id<br>";
				//$re_name 	= $this->M_member->get_member_name($mb->recommend_id);
				$re_name 			= '';					
			}
			
			$inChk = $this->M_point->get_su_date($db_table,$row->member_id,$nowdate);
			if(empty($inChk))
			{
				$day_point 	= 0;
				$re_point 	= 0;
				$re2_point 	= 0;
				$mc_point 	= 0;
				$mc2_point 	= 0;
				$level_point = 0;
				$ct_point 	= 0;
				
				if($row->kind == 'day'){
					$day_point 		= $row->point;
					$re_point 		= 0;
					$re2_point 		= 0;
					$mc_point 		= 0;
					$mc2_point 		= 0;
					$level_point 	= 0;
					$ct_point 		= 0;
				}
				else if($row->kind == 're'){
					$day_point 		= 0;
					$re_point 		= $row->point;
					$re2_point 		= 0;
					$mc_point 		= 0;
					$mc2_point 		= 0;
					$level_point 	= 0;
					$ct_point 		= 0;
				}
				else if($row->kind == 're2'){
					$day_point 		= 0;
					$re_point 		= 0;
					$re2_point 		= $row->point;
					$mc_point 		= 0;
					$mc2_point 		= 0;
					$level_point 	= 0;
					$ct_point 		= 0;
				}
				else if($row->kind == 'mc'){
					$day_point 		= 0;
					$re_point 		= 0;
					$re2_point 		= 0;
					$mc_point 		= $row->point;
					$mc2_point 		= 0;
					$level_point 	= 0;
					$ct_point 		= 0;
				}
				else if($row->kind == 'mc2'){
					$day_point 		= 0;
					$re_point 		= 0;
					$re2_point 		= 0;
					$mc_point 		= 0;
					$mc2_point 		= $row->point;
					$level_point 	= 0;
					$ct_point 		= 0;
				}
				else if($row->kind == 'level'){
					$day_point 		= 0;
					$re_point 		= 0;
					$re2_point 		= 0;
					$mc_point 		= 0;
					$mc2_point 		= 0;
					$level_point 	= $row->point;
					$ct_point 		= 0;
				}
				else if($row->kind == 'ct'){
					$day_point 		= 0;
					$re_point 		= 0;
					$re2_point 		= 0;
					$mc_point 		= 0;
					$mc2_point 		= 0;
					$level_point 	= 0;
					$ct_point 	= $row->point;
				}
				else{
					$day_point 		= 0;
					$re_point 		= 0;
					$re2_point 		= 0;
					$mc_point 		= 0;
					$mc2_point 		= 0;
					$level_point 	= 0;
					$ct_point 		= 0;
				}
				$query = array(
					'office' 		=> $mb->office,
					'name' 			=> $mb->name,
					'member_id' 	=> $row->member_id,
					'recommend_id' 	=> $mb->recommend_id,
					're_name' 		=> $re_name,
					
					'point' 		=> $row->point,
					'saved_point' 	=> $row->saved_point,
					
					'address' 		=> $address,
					'wallet' 		=> $wallet,
					
					'day' 			=> $day_point,
					're' 			=> $re_point,
					're2' 			=> $re2_point,
					'mc' 			=> $mc_point,
					'mc2' 			=> $mc2_point,
					'level' 		=> $level_point,
					'ct' 			=> $ct_point,
					
					'startdate' 	=> $sdate,		
					'enddate' 		=> $edate,
					'regdate' 		=> $nowdate
				);
				$this->db->insert($db_table, $query);
			}
			else
			{
				$po = $this->M_point->get_point_last($db_table,$row->member_id);
				
				$day_point 	= 0;
				$re_point 	= 0;
				$re2_point 	= 0;
				$mc_point 	= 0;
				$mc2_point 	= 0;
				$level_point 	= 0;
				$ct_point 	= 0;
				
				if($row->kind == 'day'){
					$day_point 	= $po->day + $row->point;
					$re_point 	= $po->re;
					$re2_point 	= $po->re2;
					$mc_point 	= $po->mc;
					$mc_point 	= $po->mc2;
					$level_point 	= $po->level;
					$ct_point 	= $po->ct;
				}
				else if($row->kind == 're'){
					$day_point 	= $po->day;
					$re_point 	= $po->re + $row->point;
					$re2_point 	= $po->re2;
					$mc_point 	= $po->mc;
					$mc_point 	= $po->mc2;
					$level_point 	= $po->level;
					$ct_point 	= $po->ct;
				}
				else if($row->kind == 're2'){
					$day_point 	= $po->day;
					$re_point 	= $po->re;
					$re2_point 	= $po->re2 + $row->point;
					$mc_point 	= $po->mc;
					$mc_point 	= $po->mc2;
					$level_point 	= $po->level;
					$ct_point 	= $po->ct;
				}
				else if($row->kind == 'mc'){
					$day_point 	= $po->day;
					$re_point 	= $po->re;
					$re2_point 	= $po->re2;
					$mc_point 	= $po->mc + $row->point;
					$mc_point 	= $po->mc2;
					$level_point 	= $po->level;
					$ct_point 	= $po->ct;
				}
				else if($row->kind == 'mc2'){
					$day_point 	= $po->day;
					$re_point 	= $po->re;
					$re2_point 	= $po->re2;
					$mc_point 	= $po->mc;
					$mc_point 	= $po->mc2 + $row->point;
					$level_point 	= $po->level;
					$ct_point 	= $po->ct;
				}
				else if($row->kind == 'level'){
					$day_point 	= $po->day;
					$re_point 	= $po->re;
					$re2_point 	= $po->re2;
					$mc_point 	= $po->mc;
					$mc_point 	= $po->mc2;
					$level_point 	= $po->level + $row->point;
					$ct_point 	= $po->ct;
				}
				else if($row->kind == 'ct'){
					$day_point 	= $po->day;
					$re_point 	= $po->re;
					$re2_point 	= $po->re2;
					$mc_point 	= $po->mc;
					$mc_point 	= $po->mc2;
					$level_point 	= $po->level;
					$ct_point 	= $po->ct + $row->point;
				}
				else
				{
					$day_point 	= $po->day;
					$re_point 	= $po->re;
					$re2_point 	= $po->re2;
					$mc_point 	= $po->mc;
					$mc_point 	= $po->mc2;
					$level_point 	= $po->level;
					$ct_point 	= $po->ct;			
				}
				
				$point 			= $po->point + $row->point;
				$saved_point 	= $po->saved_point + $row->saved_point;
				
				$query = array(
					'point' 		=> $point,
					'saved_point' 	=> $saved_point,
					'day' 			=> $day_point,
					're' 			=> $re_point,
					're2' 			=> $re2_point,
					'mc' 			=> $mc_point,
					'mc2' 			=> $mc2_point,
					'level' 		=> $level_point,
					'ct' 			=> $ct_point
				);
				$this->db->where('point_no', $po->point_no);
				$this->db->update($db_table, $query);
				
				//echo "$row->member_id // $row->kind ===>    $point // $saved_point // $day_point  //$re_point 	 // $ct_point //$po->point_no	//<br>";
			}
		}
		//------------------------------------------------------------------------------------------------------//
			
		$i = 1;
		$headers = '';
		
		$excel="
		<table width='1400' border='1' cellspacing=0 cellpadding=0>
		<tr bgcolor='#f2f2f2'>
			<td height='35' align='center'>번호</td>
			<td align='center'>아이디</td>
			<td align='center'>회원이름</td>
			<td align='center'>추천인</td>
			<td align='center'>추천인이름</td>
			
			<td align='center'>총데일리 수당</td>
			<td align='center'>총매칭 수당</td>
			<td align='center'>총매칭2 수당</td>
			<td align='center'>총추천 수당</td>
			<td align='center'>총추천2 수당</td>
			<td align='center'>총프리미엄 수당</td>
			<td align='center'>총센타비</td>
			
			<td align='center'>총수당금액</td>
			<td align='center'>총매출금액</td>
			<td align='center'>출력기간</td>
			<td align='center'>출력일</td>
			<td align='center'>내지갑주소</td>
			<td align='center'>거래소 지갑주소</td>
		</tr>";
		//style='mso-number-format:\@'
		// 가공 - 총 매출 금액확인
		$list = $this->M_point->get_point_li($db_table);		
        foreach ($list as $row) 
        {				
			$excel.="
			<tr>
				<td height='25' align='center'>".$i."</td>
				<td align='center'>".$row->member_id."</td>
				<td align='center'>".$row->name."</td>
				<td align='center'>".$row->recommend_id."</td>
				<td align='center'>".$row->re_name."</td>
				
				<td align='center'>".$row->day."</td>
				<td align='center'>".$row->re."</td>
				<td align='center'>".$row->re2."</td>
				<td align='center'>".$row->mc."</td>
				<td align='center'>".$row->mc2."</td>
				<td align='center'>".$row->level."</td>
				<td align='center'>".$row->ct."</td>
				<td align='center'>".$row->point."</td>
				<td align='center'>".$row->saved_point."</td>
				<td align='center'>".$row->startdate ." ~ " .$row->enddate ."</td>
				<td align='center'>".$row->regdate."</td>
				<td align='center'>".$row->address."</td>
				<td align='center'>".$row->wallet."</td>
			</tr>";
			$i++;
        }
			
		$excel.= "</table>"; 

		//$excel= iconv("UTF-8", "EUC-KR", $excel);
		$name = 'Su_'.nowday().'.xls';
	
		header( "Content-type: application/vnd.ms-excel; charset=euc-kr"); 
		header( "Content-Disposition: attachment; filename=$name" ); 
		header( "Content-Description: PHP4 Generated Data" ); 
		print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

		echo "$headers\n$excel";
		
	}

	//----------------------------------------------------------------------------------------//
	
	function deadline()
	{
		$datetime   	= $this->uri->segment(4,0); // 해당날짜의 수당을 정리한다.
		$search_day 	= $datetime ." 23:59:59";	
			
		$this->db->empty_table('m_point_temp');
		
		// 가공 - 총 매출 금액확인
		$list = $this->M_point->get_point_su_date('m_point_total',$search_day);		
        foreach ($list as $row) 
        {
	        $table = 'm_point_total';
	        $chk = $this->M_point->point_in_chk($table,$row->member_id);
	        if(!$chk)
	        {
				$mb = $this->M_member->get_member($row->member_id);
				
				$db = 'm_point_su';
				$total_su = $this->M_point->get_point_su_total($db,$row->member_id,$search_day);
				$total_su = $total_su;
				if(empty($total_su)){$total_su = 0;}
				
				$su_day = $this->M_point->get_point_su_total($db,$row->member_id,$search_day,'day');
				if(empty($su_day)){$su_day = 0;}
				
				$su_re = $this->M_point->get_point_su_total($db,$row->member_id,$search_day,'re');
				if(empty($su_re)){$su_re = 0;}
				
				$su_sp = $this->M_point->get_point_su_total($db,$row->member_id,$search_day,'sp');
				if(empty($su_sp)){$su_sp = 0;}
				
				$su_roll = $this->M_point->get_point_su_total($db,$row->member_id,$search_day,'roll');
				if(empty($su_roll)){$su_roll = 0;}
				
				$su_mc = $this->M_point->get_point_su_total($db,$row->member_id,$search_day,'mc');
				if(empty($su_mc)){$su_mc = 0;}
				
				$su_level = $this->M_point->get_point_su_total($db,$row->member_id,$search_day,'level');
				if(empty($su_level)){$su_level = 0;}

				$query = array(
					'office_group' 	=> $row->office_group,
					'office' 		=> $row->office,
					'member_id' 	=> $row->member_id,
					'member_name' 	=> $mb->name,
					//'bank_holder' 	=> $mb->bank_holder,
					//'bank_number' 	=> $mb->bank_number,
					//'bank_name' 	=> $mb->bank_name,
			
					'point_all' 	=> $total_su,
					'point_day' 	=> $su_day,
					'point_re' 		=> $su_re,
					'point_sp' 		=> $su_sp,
					'point_roll' 	=> $su_roll,
					'point_mc' 		=> $su_mc,
					'point_leader' 	=> $su_level,
					'regdate' 		=> $datetime,
				);
				$this->db->insert($table, $query);		        
		    }
	        
		}
		
		$i = 1;	
		$headers = '';
		
		$excel="
		<table width='1400' border='1' cellspacing=0 cellpadding=0>
		<tr bgcolor='#f2f2f2'>
			<td height='35' align='center'>번호</td>
			<td align='center'>센터명</td>
			<td align='center'>아이디</td>
			<td align='center'>회원이름</td>
			
			<td align='center'>총수당</td>
			<td align='center'>마이닝보너스</td>
			<td align='center'>마이닝매칭보너스</td>
			<td align='center'>추천보너스</td>
			<td align='center'>후원보너스</td>
			<td align='center'>후원매칭보너스</td>
			<td align='center'>직급보너스</td>
			<td align='center'>등록일</td>
		</tr>";		
			
		$list = $this->M_point->get_point_li('m_point_temp');		
        foreach ($list as $row) 
        {	
			$excel.="
			<tr>
				<td height='25' align='center'>".$i."</td>
				<td align='center'>".$row->office."</td>
				<td align='center'>".$row->member_id."</td>
				<td align='center'>".$row->member_name."</td>
				
				<td align='center' style='mso-number-format:\@'>".$row->point_all."</td>
				<td align='center' style='mso-number-format:\@'>".$row->point_day."</td>
				<td align='center' style='mso-number-format:\@'>".$row->point_roll."</td>
				<td align='center' style='mso-number-format:\@'>".$row->point_re."</td>
				<td align='center' style='mso-number-format:\@'>".$row->point_sp."</td>
				<td align='center' style='mso-number-format:\@'>".$row->point_mc."</td>
				<td align='center' style='mso-number-format:\@'>".$row->point_leader."</td>
				<td align='center'>".$row->regdate."</td>
			</tr>";
			$i++;
        }
			
		$excel.= "</table>"; 

			$excel= iconv("UTF-8", "EUC-KR", $excel);
		$name = 'Dead_'.$datetime.'.xls';
	
		header( "Content-type: application/vnd.ms-excel; charset=euc-kr"); 
		header( "Content-Disposition: attachment; filename=$name" ); 
		header( "Content-Description: PHP4 Generated Data" ); 
		print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

		echo "$headers\n$excel";

	}
	//----------------------------------------------------------------------------------------//
	//----------------------------------------------------------------------------------------//
	
	
	function excelRead()
	{
		require_once APPPATH."/libraries/PHPExcel.php";
		
		// 엑셀 파일 읽기
		$objPHPExcel = PHPExcel_IOFactory::load('/home/ndwoori/www/data/ndwoori_mb.xls');

		// 엑셀 내용을 배열로 바꾸기
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

		for($i=2; $i<136; $i++)
		{			
			$name 			= $sheetData[$i]['A']; // 이름
			$member_id 		= $sheetData[$i]['B']; // id
			$recommend_id 	= $sheetData[$i]['C']; // 추천인
			$sponsor_id 	= $sheetData[$i]['D']; // 후원인
			
			echo "$name // $member_id <br>";		
			
			if($sponsor_id != ''){
				$query = array(
					'sponsor_id' => $sponsor_id,
				);

				$this->db->where('member_id',$member_id);
				$this->db->update('m_member', $query);
				
			}
			
			
			/*
			$secret = 123456;		
			$query = array(
			'member_id' 	=> strtolower($member_id),
			'coin_id' 		=> strtolower($member_id),			
			'password' 		=> $password,
			'level' 		=> $level,
			'secret' 		=> $secret,			
			'name' 			=> $name,
			'mobile' 		=> $mobile,			
			'country' 		=> 'KOR',
			'office' 		=> 'company',
			'recommend_id' 	=> $recommend_id,
			'regdate' 	=> $regdate,
			);
			$this->db->insert('m_member', $query);
			*/
			
			
			//$order_code = order_code();  // 주문코드 만들기
			//$mb 		= $this->M_member->get_member($member_id); //멤버 정보 가져오기	
			//$bal 		= $this->M_pay->get_balance($mb->member_no);
			
			//$type 			= "ucetoken";
			//$total_volume 	= $bal->volume + $purchase;
			//$this->M_point->balance_inout($member_no,$type,$total_volume); // 누적매출			
			/*
			$type 			= "total_point";
			$total_point 	= $point;
			$this->M_point->balance_inout($mb->member_no,$type,$total_point); // PO 누적
			$type 			= "volume";
			$total_point 	= $purchase;
			$this->M_point->balance_inout($mb->member_no,$type,$total_point); // PO 누적
			$type 			= "kind";
			$total_point 	= $kind;
			$this->M_point->balance_inout($mb->member_no,$type,$total_point); // PO 누적
			
			$type 			= "volume";
			$total_point 	= $purchase;
			$this->M_point->balance_inout($mb->member_no,$type,$total_point); // PO 누적
			$type 			= "level";
			$total_point 	= $level;
			$this->M_point->balance_inout($mb->member_no,$type,$total_point); // PO 누적
			
			$msg 		= "Level" .$level;		
			$table		= 'm_point_uce';
			$this->M_point->pay_puchase($table, $order_code, $mb->country, $msg, $mb->office, $member_id, 'admin', $point, $purchase,'puchase', $msg, $kind, $msg, $leverage, $regdate); // 들어옴
			*/
			
		}
		
		
echo '<hr />';
echo '<pre>';
var_dump($sheetData);
echo '</pre>';
		
	}
}

?>