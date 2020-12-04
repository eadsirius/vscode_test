<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Personal extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();

		define('SKIN_DIR', '/views/web/app');


	}
	
	public function index()
	{
		$data = array();
		$data['header'] = array('title'=>SITE_NAME_EN,'group'=>'PRIVACY');
		
		layout('/member/personal',$data);
	}

		
}