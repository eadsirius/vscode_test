<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Post extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		define('SKIN_DIR', '/views/member');
		$this -> load -> model('m_member');
		$this -> load -> model('m_office');
	}


	
	
	function search() {
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<font color=red>', '</font>');

		// 폼검증
		$this->form_validation->set_rules('dong', '동을입력하세요', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('member/post_search');
		}
		else {
			$dong = $this->input->post('dong');
			$this->load->helper('file');
			$zipfile = array();
			$zipfile = file('data/member/zip.db');

			$search_count = 0;
			while ($zipcode = each($zipfile))
			{
				if(strstr(substr($zipcode[1],9,512), $dong))
				{
					$post_code[''.$search_count.'']['zip1'] = substr($zipcode[1],0,3);
					$post_code[''.$search_count.'']['zip2'] = substr($zipcode[1],4,3);
					$addr = explode(" ", substr($zipcode[1],8));

					if ($addr[sizeof($addr)-1])
					{
						$post_code[''.$search_count.'']['addr'] = str_replace($addr[sizeof($addr)-1], "", substr($zipcode[1],8));
						$post_code[''.$search_count.'']['bunji'] = trim($addr[sizeof($addr)-1]);
					}
					else {
						$post_code[''.$search_count.'']['addr'] = substr($zipcode[1],8);

						$post_code[''.$search_count.'']['encode_addr'] = urlencode($post_code[''.$search_count.'']['addr']);

					}

				}

				$search_count++;
			}


			$data['lists'] = $post_code;
			$this -> load -> view('member/post_lists',$data);
		}

	}
	
}
?>