<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* =================================================================
* 검색 헬퍼
================================================================= */

	// 페이지 네이션
	function page_lists($table,$order_by,$data,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL)
	{
		define('SEARCH_URL', current_url());

		$CI =& get_instance();
		$CI->load->library('pagination');
		
		$sys = $page = $CI->uri->segment(2);
		$smt = $CI->uri->segment(3);
		$page = $CI->uri->segment(4);

		$data['st'] = $CI->uri->segment(7,0);
		$data['sc'] = $CI->uri->segment(9);
		$sc_post = preg_replace("/\s+/", "", $CI->input->post('sc'));
		$data['kind'] =  $CI->input->get('kind');
		// 검색정보가 있다면
		if ($CI->input->post('st') and $CI->input->post('sc') || $CI->input->post('kind') ) {
			redirect('/admin/'.$sys.'/'.$smt.'/page/1/st/'.$CI->input->post('st').'/sc/'. urlencode($sc_post).'?kind='.$CI->input->post('kind'));
		}

		// page 넘버 이후 세그먼트 담기
		if ($CI->uri->segment(6) == "st" and  $CI->uri->segment(8) == "sc") {
			$q = array('st' => $data['st'], 'sc' => $data['sc']);
			$qstr = $CI->uri->assoc_to_uri($q);
			$config['suffix']      = "/".$qstr;
		}

		
		$list_page = $CI->session->userdata('list_page');
		if($list_page == ''){
			$per_page = 20;			
		}
		else{
			$per_page = $list_page;
		}

		$config['per_page'] = $per_page;  //한페이지에 보여줄 게시물
		$config['num_links'] = 5;  // 최대보여줄 페이지 넘버
		$config['base_url'] = '/'.$CI->uri->segment(1).'/'.$sys.'/'.$smt.'/page/';

					

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
		$page_num = $CI->uri->segment(5);
		if ($page_num == 1 or $page_num == NULL ) {
			$page_num = 0;
		}
		else {
			$page_num = $page_num * $config['per_page'] - $config['per_page'];
		}

		// 검색 정보가 있을시 (추후 코드 수정)
		if ($CI->uri->segment(6) == "st" and  $CI->uri->segment(8) == "sc") {

		
			$data['item'] = $CI->M_admin->get_sc_lists($table,$config['per_page'],$page_num,$order_by,$data['st'],$data['sc'],$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
			$config['total_rows'] = $CI->M_admin->get_sc_total($table,$config['per_page'],$page_num,$order_by,$data['st'],$data['sc'],$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
			

		}
		else {
			$data['item'] = $CI->M_admin->get_lists($table,$config['per_page'],$page_num,$order_by,$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
			$config['total_rows'] = $CI->M_admin->get_total($table,$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
		}

		$data['total_count'] = $config['total_rows'] - $page_num;
		// 2020.07.24 박종훈 총 row값 가져오기 추가
		$data['total_rows']  = $config['total_rows'];

		$data['search'] =  urldecode($data['sc']);
		$CI->pagination->initialize($config);
		define('PAGE_URL', $CI->pagination->create_links());
		return $data;

	}
	
	
	
	// 페이지 네이션
	function page_lists2($table,$order_by,$data,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL)
	{define('SEARCH_URL', current_url());

		$CI =& get_instance();
		$CI->load->library('pagination');
		
		$sys = $page = $CI->uri->segment(2);
		$smt = $CI->uri->segment(3);
		$page = $CI->uri->segment(4);

		$data['st'] = $CI->uri->segment(7,0);
		
		
		$data['sc'] = $CI->uri->segment(9);
		$sc_post = preg_replace("/\s+/", "", $CI->input->post('sc'));

		// 검색정보가 있다면
		if ($CI->input->post('st') and $CI->input->post('sc')) {
			redirect('/admin/'.$sys.'/'.$smt.'/page/1/st/'.$CI->input->post('st').'/sc/'. urlencode($sc_post).'');
		}

		// page 넘버 이후 세그먼트 담기
		if ($CI->uri->segment(6) == "st" and  $CI->uri->segment(8) == "sc") {
			$q = array('st' => $data['st'], 'sc' => $data['sc']);
			$qstr = $CI->uri->assoc_to_uri($q);
			$config['suffix']      = "/".$qstr;
		}
		
		
		$list_page = $CI->session->userdata('list_page');
		if($list_page == ''){
			$per_page = 33;			
		}
		else{
			$per_page = $list_page;
		}
		
		$config['per_page'] = $per_page;  //한페이지에 보여줄 게시물
		$config['num_links'] = 5;  // 최대보여줄 페이지 넘버
		$config['base_url'] = '/'.$CI->uri->segment(1).'/'.$sys.'/'.$smt.'/page/';


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
		$page_num = $CI->uri->segment(5);
		if ($page_num == 1 or $page_num == NULL ) {
			$page_num = 0;
		}
		else {
			$page_num = $page_num * $config['per_page'] - $config['per_page'];
		}

		// 검색 정보가 있을시 (추후 코드 수정)
		if ($CI->uri->segment(6) == "st" and  $CI->uri->segment(8) == "sc") {

			$data['item'] = $CI->M_admin->get_sc_lists($table,$config['per_page'],$page_num,$order_by,$data['st'],$data['sc'],$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
			$config['total_rows'] = $CI->M_admin->get_sc_total($table,$config['per_page'],$page_num,$order_by,$data['st'],$data['sc'],$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
		}
		else {
			$data['item'] = $CI->M_admin->get_lists($table,$config['per_page'],$page_num,$order_by,$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
			$config['total_rows'] = $CI->M_admin->get_total($table,$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
		}

		$data['total_count'] = $config['total_rows'] - $page_num;

		$data['search'] =  urldecode($data['sc']);
		$CI->pagination->initialize($config);
		define('PAGE_URL', $CI->pagination->create_links());
		return $data;


	}

	function page_lists_new($table,$order_by,$data,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL)
	{
		define('SEARCH_URL', current_url());

		$CI =& get_instance();
		$CI->load->library('pagination');
		
		$sys = $page = $CI->uri->segment(2);
		$smt = $CI->uri->segment(3);
		$page = $CI->uri->segment(4);

		$data['st'] = $CI->uri->segment(7,0);
		
		
		$data['sc'] = $CI->uri->segment(9);
		$sc_post = preg_replace("/\s+/", "", $CI->input->post('sc'));

		// 검색정보가 있다면
		if ($CI->input->post('st') and $CI->input->post('sc')) {
			redirect('/admin/'.$sys.'/'.$smt.'/page/1/st/'.$CI->input->post('st').'/sc/'. urlencode($sc_post).'');
		}

		// page 넘버 이후 세그먼트 담기
		if ($CI->uri->segment(6) == "st" and  $CI->uri->segment(8) == "sc") {
			$q = array('st' => $data['st'], 'sc' => $data['sc']);
			$qstr = $CI->uri->assoc_to_uri($q);
			$config['suffix']      = "/".$qstr;
		}
		
		
		$list_page = $CI->session->userdata('list_page');
		if($list_page == ''){
			$per_page = 33;			
		}
		else{
			$per_page = $list_page;
		}
		
		$config['per_page'] = $per_page;  //한페이지에 보여줄 게시물
		$config['num_links'] = 5;  // 최대보여줄 페이지 넘버
		$config['base_url'] = '/'.$CI->uri->segment(1).'/'.$sys.'/'.$smt.'/page/';


		// 디자인
		$config['first_tag_open']  = '<li class="footable-page-arrow">';
		$config['first_tag_close']  = '</li>';		
		$config['last_tag_open']  = '<li class="footable-page-arrow">';
		$config['last_tag_close']  = '</li>';		
		$config['cur_tag_open']  = '<li class="footable-page active"><a data-page="0" href="#" onclick="return false;">';
		$config['cur_tag_close']  = '</a></li>';
		$config['next_tag_open']  = '<li class="footable-page-arrow">';
		$config['next_tag_close']  = '</li>';
		$config['prev_tag_open']  = '<li class="footable-page-arrow">';
		$config['prev_tag_close']  = '</li>';
		$config['num_tag_open']  = '<li class="footable-page">';
		$config['num_tag_close']  = '</li>';
		$config['first_link']  = '«';
		$config['prev_link']  = '‹';
		$config['next_link']  = '›';
		$config['last_link']  = '»';


		//페이지 시작페이지가 1이하라면
		$page_num = $CI->uri->segment(5);
		if ($page_num == 1 or $page_num == NULL ) {
			$page_num = 0;
		}
		else {
			$page_num = $page_num * $config['per_page'] - $config['per_page'];
		}

		// 검색 정보가 있을시 (추후 코드 수정)
		if ($CI->uri->segment(6) == "st" and  $CI->uri->segment(8) == "sc") {

			$data['item'] = $CI->M_admin->get_sc_lists($table,$config['per_page'],$page_num,$order_by,$data['st'],$data['sc'],$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
			$config['total_rows'] = $CI->M_admin->get_sc_total($table,$config['per_page'],$page_num,$order_by,$data['st'],$data['sc'],$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
		}
		else {
			$data['item'] = $CI->M_admin->get_lists($table,$config['per_page'],$page_num,$order_by,$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
			$config['total_rows'] = $CI->M_admin->get_total($table,$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
		}

		$data['total_count'] = $config['total_rows'] - $page_num;

		$data['search'] =  urldecode($data['sc']);
		$CI->pagination->initialize($config);
		define('PAGE_URL', $CI->pagination->create_links());
		return $data;

	}

	function page_lists_allowance($table,$order_by,$data,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL)
	{
		define('SEARCH_URL', current_url());

		$CI =& get_instance();
		$CI->load->library('pagination');
		
		$sys = $page = $CI->uri->segment(2);
		$smt = $CI->uri->segment(3);
		$page = $CI->uri->segment(4);

		$data['st'] = $CI->uri->segment(7,0);
		
		
		$data['sc'] = $CI->uri->segment(9);
		$sc_post = preg_replace("/\s+/", "", $CI->input->post('sc'));

		// 검색정보가 있다면
		if ($CI->input->post('st') and $CI->input->post('sc')) {
			redirect('/admin/'.$sys.'/'.$smt.'/page/1/st/'.$CI->input->post('st').'/sc/'. urlencode($sc_post).'');
		}

		// page 넘버 이후 세그먼트 담기
		if ($CI->uri->segment(6) == "st" and  $CI->uri->segment(8) == "sc") {
			$q = array('st' => $data['st'], 'sc' => $data['sc']);
			$qstr = $CI->uri->assoc_to_uri($q);
			$config['suffix']      = "/".$qstr;
		}
		
		
		$list_page = $CI->session->userdata('list_page');
		if($list_page == ''){
			$per_page = 33;			
		}
		else{
			$per_page = $list_page;
		}
		
		$config['per_page'] = $per_page;  //한페이지에 보여줄 게시물
		$config['num_links'] = 5;  // 최대보여줄 페이지 넘버
		$config['base_url'] = '/'.$CI->uri->segment(1).'/'.$sys.'/'.$smt.'/page/';


		// 디자인
		$config['first_tag_open']  = '<li class="footable-page-arrow">';
		$config['first_tag_close']  = '</li>';		
		$config['last_tag_open']  = '<li class="footable-page-arrow">';
		$config['last_tag_close']  = '</li>';		
		$config['cur_tag_open']  = '<li class="footable-page active"><a data-page="0" href="#" onclick="return false;">';
		$config['cur_tag_close']  = '</a></li>';
		$config['next_tag_open']  = '<li class="footable-page-arrow">';
		$config['next_tag_close']  = '</li>';
		$config['prev_tag_open']  = '<li class="footable-page-arrow">';
		$config['prev_tag_close']  = '</li>';
		$config['num_tag_open']  = '<li class="footable-page">';
		$config['num_tag_close']  = '</li>';
		$config['first_link']  = '«';
		$config['prev_link']  = '‹';
		$config['next_link']  = '›';
		$config['last_link']  = '»';


		//페이지 시작페이지가 1이하라면
		$page_num = $CI->uri->segment(5);
		if ($page_num == 1 or $page_num == NULL ) {
			$page_num = 0;
		}
		else {
			$page_num = $page_num * $config['per_page'] - $config['per_page'];
		}

		// 검색 정보가 있을시 (추후 코드 수정)
		if ($CI->uri->segment(6) == "st" and  $CI->uri->segment(8) == "sc") {
			$data['item'] = $CI->M_admin->get_sc_lists_allowance($table,$config['per_page'],$page_num,$order_by,$data['st'],$data['sc'],$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
			$config['total_rows'] = $CI->M_admin->get_sc_total_allowance($table,$config['per_page'],$page_num,$order_by,$data['st'],$data['sc'],$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
		}
		else {
			$data['item'] = $CI->M_admin->get_lists_allowance($table,$config['per_page'],$page_num,$order_by,$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
			$config['total_rows'] = $CI->M_admin->get_total_allowance($table,$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
		}

		//$data['total_count'] = $config['total_rows'] - $page_num;
        $data['total_count'] = $config['total_rows'];

		$data['search'] =  urldecode($data['sc']);
		$CI->pagination->initialize($config);
		define('PAGE_URL', $CI->pagination->create_links());
		return $data;

	}

	// 2020.08.13
	function page_lists_s($table,$order_by,$data,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL)
	{
		define('SEARCH_URL', current_url());

		$CI =& get_instance();
		$CI->load->library('pagination');
		
		$sys = $page = $CI->uri->segment(2);
		$smt = $CI->uri->segment(3);
		$page = $CI->uri->segment(4);

		$data['st'] = $CI->uri->segment(7,0);
		$data['sc'] = $CI->uri->segment(9);
		$sc_post = preg_replace("/\s+/", "", $CI->input->post('sc'));
		$data['kind'] =  $CI->input->get('kind');

		$config['total_rows'] = 0;


		// 검색정보가 있다면
		if ($CI->input->post('st') and $CI->input->post('sc') || $CI->input->post('kind') ) {
			redirect('/admin/'.$sys.'/'.$smt.'/page/1/st/'.$CI->input->post('st').'/sc/'. urlencode($sc_post).'?kind='.$CI->input->post('kind'));
		}

		// page 넘버 이후 세그먼트 담기
		if ($CI->uri->segment(6) == "st" and  $CI->uri->segment(8) == "sc") {
			$q = array('st' => $data['st'], 'sc' => $data['sc']);
			$qstr = $CI->uri->assoc_to_uri($q);
			$config['suffix']      = "/".$qstr;
		}

		
		$list_page = $CI->session->userdata('list_page');
		if($list_page == ''){
			$per_page = 20;			
		}
		else{
			$per_page = $list_page;
		}

		$config['per_page'] = $per_page;  //한페이지에 보여줄 게시물
		$config['num_links'] = 5;  // 최대보여줄 페이지 넘버
		$config['base_url'] = '/'.$CI->uri->segment(1).'/'.$sys.'/'.$smt.'/page/';

					

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
		$page_num = $CI->uri->segment(5);
		if ($page_num == 1 or $page_num == NULL ) {
			$page_num = 0;
		}
		else {
			$page_num = $page_num * $config['per_page'] - $config['per_page'];
		}

		// 검색 정보가 있을시 (추후 코드 수정)
		if ($CI->uri->segment(6) == "st" and  $CI->uri->segment(8) == "sc") {

		
			$data['item'] = $CI->M_admin->get_sc_lists($table,$config['per_page'],$page_num,$order_by,$data['st'],$data['sc'],$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
			// $config['total_rows'] = $CI->M_admin->get_sc_total($table,$config['per_page'],$page_num,$order_by,$data['st'],$data['sc'],$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
			
			$data['total_count'] = 1;
		}

		$data['search'] =  urldecode($data['sc']);
		$CI->pagination->initialize($config);
		define('PAGE_URL', $CI->pagination->create_links());
		return $data;

	}


	function page_lists_date($table,$order_by,$data,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL)
	{
		define('SEARCH_URL', current_url());

		$CI =& get_instance();
		$CI->load->library('pagination');
		
		$sys = $page = $CI->uri->segment(2);
		$smt = $CI->uri->segment(3);
		$page = $CI->uri->segment(4);

		$data['st'] = $CI->uri->segment(11,0);
		$data['sc'] = $CI->uri->segment(13);
		$sc_post = preg_replace("/\s+/", "", $CI->input->post('sc'));
		$data['kind'] =  $CI->input->get('kind');

		$data['sdate']	=	$CI->uri->segment(7);
		$data['edate']	=	$CI->uri->segment(9);

		// 검색정보가 있다면
		if ($CI->input->post('st') and $CI->input->post('sc') || $CI->input->post('kind') || $CI->input->post('sdate') || $CI->input->post('edate')) {
			redirect('/admin/'.$sys.'/'.$smt.'/page/1'.'/sdate/'.$CI->input->post('sdate').'/edate/'.$CI->input->post('edate').'/st/'.$CI->input->post('st').'/sc/'. urlencode($sc_post).'?kind='.$CI->input->post('kind'));
		}

		// page 넘버 이후 세그먼트 담기
		if ($CI->uri->segment(6) == "st" and  $CI->uri->segment(8) == "sc") {
			$q = array('st' => $data['st'], 'sc' => $data['sc']);
			$qstr = $CI->uri->assoc_to_uri($q);
			$config['suffix']      = "/".$qstr;
		}

		
		$list_page = $CI->session->userdata('list_page');
		if($list_page == ''){
			$per_page = 20;			
		}
		else{
			$per_page = $list_page;
		}

		$config['per_page'] = $per_page;  //한페이지에 보여줄 게시물
		$config['num_links'] = 5;  // 최대보여줄 페이지 넘버
		$config['base_url'] = '/'.$CI->uri->segment(1).'/'.$sys.'/'.$smt.'/page/';

					

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
		$page_num = $CI->uri->segment(5);
		if ($page_num == 1 or $page_num == NULL ) {
			$page_num = 0;
		}
		else {
			$page_num = $page_num * $config['per_page'] - $config['per_page'];
		}

	
		

		// 검색 정보가 있을시 (추후 코드 수정)
		if ($CI->uri->segment(10) == "st" and  $CI->uri->segment(12) == "sc" || $CI->uri->segment(6) == 'sdate' || $CI->uri->segment(8) == 'edate' ) {
			$where3	=	'regdate';
			$where4	=	'regdate';
			$clm3 = $data['sdate'];
			$clm4 =	$data['edate'];

			$data['item'] = $CI->M_admin->get_scdate_lists($table,$config['per_page'],$page_num,$order_by,$data['st'],$data['sc'],$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
			$config['total_rows'] = $CI->M_admin->get_scdate_total($table,$config['per_page'],$page_num,$order_by,$data['st'],$data['sc'],$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
		
		}
		else {
			$data['item'] = $CI->M_admin->get_scdate_lists($table,$config['per_page'],$page_num,$order_by,$data['st'],$data['sc'],$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
			$config['total_rows'] = $CI->M_admin->get_total_date($table,$where,$clm,$where2,$clm2,$where3,$clm3,$where4,$clm4,$where5,$clm5);
		}

		$data['total_count'] = $config['total_rows'] - $page_num;
		// 2020.07.24 박종훈 총 row값 가져오기 추가
		$data['total_rows']  = $config['total_rows'];

		$data['search'] =  urldecode($data['sc']);
		$CI->pagination->initialize($config);
		define('PAGE_URL', $CI->pagination->create_links());
		return $data;

	}
?>
