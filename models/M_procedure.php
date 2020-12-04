<?php
class M_procedure extends CI_Model {

	public function getDailySudang() {
		$this->db->query("CALL DailySudang()");
	}
}