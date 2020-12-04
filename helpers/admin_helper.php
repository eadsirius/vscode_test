<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/* =================================================================
* 관리자용 헬퍼
================================================================= */

function admin_chk() {
	$CI =& get_instance();
	$level = $CI->session->userdata('level');
	
	if ( $level < 7  ) {
		alert("$level - Not Admin", "/");
	}
}

?>
