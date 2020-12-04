<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sudang extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this -> load -> model('M_procedure');
	}

	function dailySudang()
	{
		$this->M_procedure->getDailySudang();
	}
}	
?>
