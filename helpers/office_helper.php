<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function vlm_tree($order_code, $name, $member_id, $sponsor_id, $dep, $amount, $regdate)
{
	$CI =& get_instance();
	
	$get_member = $CI->M_member->get_member($member_id); // 회원정보가져오기

	while ($get_member->sponsor_id != NULL AND $member_id != 'admin') 
	{
		$point = 0;
		
		$side = $CI->M_member->get_sp_side($get_member->sponsor_id,$get_member->member_id); // 나는 스폰서의 좌우 어디에 있나? - 없으면 1
		
		if ($side == '1') {
			$point= $amount;
			$side = 'left';
		}
		else if ($side == '2' ) {
			$side = 'right';
			$point = $amount;
		}
		else{
			$side = 'middle';
			$point = $amount;				
		}
		
		//-------------------------------------------------------------------------------//		
		$sp = $CI->M_member->get_member($get_member->sponsor_id);	// 후원인의 후원인
		//-------------------------------------------------------------------------------//	
		//$side = $CI->M_member->get_side($get_member->member_id);	// 나의 우치
		//-------------------------------------------------------------------------------//
		
		// DB 기록
		$table = "m_volume";
		$CI->M_office->vlm_in($table, $order_code, $name, $get_member->sponsor_id, $member_id, $sp->sponsor_id, $side, $dep, $point, $regdate);
		//echo "$table, $order_code, $name, $get_member->sponsor_id, $member_id, $sp->sponsor_id, $side, $point, $dep, $regdate <br>";
		
		// 상위 유저 찾기 (스폰서)
		$get_member = $CI->M_member->get_member($get_member->sponsor_id); // 회원정보가져오기
			
	}
}	
/* ===============================================================================================*/


function vlm_re_tree($order_code, $name, $member_id, $recommend_id, $dep, $amount, $regdate)
{
	$CI =& get_instance();

	$get_member = $CI->M_member->get_member($member_id); // 회원정보가져오기

	while ($get_member->recommend_id != NULL AND $member_id != 'admin') 
	{
		$side = $CI->M_member->get_re_side($get_member->recommend_id,$get_member->member_id); // 나는 스폰서의 좌우 어디에 있나? - 없으면 1
			
		$point = 0;
		if ($side == '1'){
			$side = 'left';
		}
		else if ($side == '2'){
			$side = 'right';
		}
		else{
			$side = $side;
		}
		
		$top = $CI->M_member->get_member($get_member->recommend_id); // 후원인의 후원인을 넣는다.
		
		// DB 기록
		$table = "m_volume1";
		$CI->M_office->vlm_in($table, $order_code, $name, $get_member->recommend_id, $member_id, $top->recommend_id, $side, $dep, $point, $regdate);
		
		// 상위 유저 찾기 (스폰서)
		$get_member = $CI->M_member->get_member($get_member->recommend_id); // 회원정보가져오기
			
	}
}
/* ===============================================================================================*/


function vlm_sp_tree($order_code,$name,$member_id,$sponsor_id,$amount,$dep,$regdate)
{
	$CI =& get_instance();

	$get_member = $CI->M_office->get_plan($member_id); // 회원정보가져오기

	while ($get_member->sponsor_id != NULL AND $member_id != 'admin') {

		$side = $CI->M_office->get_sp_side($get_member->sponsor_id,$get_member->member_id); // 나는 스폰서의 좌우 어디에 있나? - 없으면 1
			
		$point = $amount;
		if ($side == '1') {
			$side = 'left';
		}
		else if ($side == '2' ) {
			$side = 'right';
		}
		else{
			$side = 'middle';				
		}
		
		$top = $CI->M_office->get_plan($get_member->sponsor_id); // 후원인의 후원인을 넣는다.
		
		//echo "$member_id -- $get_member->sponsor_id // $get_member->member_id --> $get_member->recommend_id";
		// DB 기록
		$table = "m_volume";
		$CI->M_office->vlm_in($table, $order_code,$name,$get_member->sponsor_id, $member_id, $top->sponsor_id, $side, $point, $dep, $regdate);
			
		// 상위 유저 찾기 (스폰서)
		$get_member = $CI->M_office->get_plan($get_member->sponsor_id); // 회원정보가져오기
			
	}
}


/* ===============================================================================================*/


function so_tree($vlm){

	$so_point = 0;
		
	// 볼륨 합계 구하기
	if ($vlm['or_side'] == 'left') {
		$vlm['vlm_left'] = $vlm['vlm_left'];
	} else {
		$vlm['vlm_right'] = $vlm['vlm_right'];
	}

	// 좌우금액 가공
	if ($vlm['vlm_left'] >= $vlm['vlm_right']) {
		$big = 'left';
		$vlm['vlm_left'] = $vlm['vlm_left'] - $vlm['vlm_right'];
		$vlm['vlm_right'] = $vlm['vlm_right'] - $vlm['vlm_right'];
	} else {
		$big = 'right';
		$vlm['vlm_right'] = $vlm['vlm_right'] - $vlm['vlm_left'];
		$vlm['vlm_left'] = $vlm['vlm_left'] - $vlm['vlm_left'];
	}

	//대실적을 기준으로 좌우 볼륨이 다른것을 찾기
	if ($big != $vlm['or_side']) {
		
		// 현재 매출 포함하여 재가공
		if( $vlm['or_side'] == 'left') {
			$so_right = $vlm['vlm_right'];
			$so_left = $vlm['vlm_left'] + $vlm['or_point'];
		} else {
			$so_left = $vlm['vlm_left'];
			$so_right = $vlm['vlm_right']  + $vlm['or_point'];
		}

		// 현재 매출을 포함하여 소실적 비교
		if ( $so_left >= $so_right ) {
			$so_point = $so_right;
		} else {
			$so_point = $so_left;
		}
		
	} //end if
			
	return $so_point;
			
}


/* ===============================================================================================*/

function mom_chk($id,$point,$regdate){

	$CI =& get_instance();

	// 마지막 매출 정보 가져오기
	$get_mom = $CI->M_office->get_last_plan($id,$regdate);

	$mom_amount = 0;
	$su_point = 0;
	
	if ($get_mom) { // 몸값이 존재 한다면

		$mom_amount = $get_mom->amount * MAX_MOM * 0.01;
		
		// 그동안 받아간 수당 가져오기
		$su_point = $CI->M_point->get_payment($id,$get_mom->regdate);
	}
	
	///// 순환 검증 ////
	//남은 몸값
	$my_mom = $mom_amount - $su_point ;

	//포인트가 남은 몸값 보다 크다면
	if ($my_mom <= $point) {

		if ($su_point > $mom_amount) 
		{
			$point = 0;

			return $point;

		} 
		else {
			$over = $point - $my_mom;  // 오버잔액 구하기
			$point =  $point - $over;
			
			return $point;
		}
	} 
	else {
		return $point;
	}

}


function auto_mom_chk($taget,$point,$regdate){

	$CI =& get_instance();


	// 마지막 매출 정보 가져오기
	$get_mom = $CI->M_office->get_last_plan($taget,$regdate);

	$mom_amount = 0;
	$su_point = 0;
	
	if ($get_mom) { // 몸값이 존재 한다면
		
		$cc = $CI->M_office->plan_in_chk($taget);
		$mom_amount = $get_mom->amount * DAY_MAX_MOM * 0.01;
		
		
		
		// 재구매 횟수가 2회이상
		if ($cc > 1){
			
			$co = $cc - 1;
			$co = $co * 300000;
			
			$mom_amount = $mom_amount + $co;
			
		}
		
		// echo $cc.'--'.$taget.'=='.$mom_amount.'<br>';
		
		// 그동안 받아간 수당 가져오기
		$su_point = $CI->M_point->get_payment($taget,$get_mom->regdate);
	}
	
	
	///// 순환 검증 ////
	
	//남은 몸값
	$my_mom = $mom_amount - $su_point ;

	//포인트가 남은 몸값 보다 크다면
	if ($my_mom <= $point) {

		if ($su_point > $mom_amount) {

			$point = 0;

			return $point;

		} else {

			$over = $point - $my_mom;  // 오버잔액 구하기
			$point =  $point - $over;
			
			if ($point > 0) {
				$point = $point; 
			} else {
				$point = 0;
			}
			
			return $point;

		}


	} else {

		return $point;

	}

}

?>
