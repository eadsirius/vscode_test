<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Start extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		

	}

	function index()
	{
		$this->main();
	}
	
	
	function main()
	{
		$data = $member = array();
		$data['header'] = array('title'=>'OFFICE','group'=>'OFFICE');
		
		if($this->session->userdata('member_id') == ''){
			redirect('/member/login');			
		}
		else{			
			redirect('/office');
		}
		
	}
	
}	
?>