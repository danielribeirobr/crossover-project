<?php

class User_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function checkLogin($email, $password) {
		return $this->db->query('
			SELECT
				u.user_id,
				u.email
			FROM
				user u
			WHERE
				u.email = ' . $this->db->escape($email) . '
				and u.password = PASSWORD(' .$this->db->escape($password). ')
				and u.status = 1
		')->row();
	}

	public function changePassword($email, $password) {
		return $this->db->query('
			UPDATE user SET
				status = 1,
				password = PASSWORD(' . $this->db->escape($password) . ')
			WHERE email = ' . $this->db->escape($email) . '
		');
	}

	public function checkToken($email, $token) {
		return $this->db->query('
			SELECT
				u.user_id,
				u.email
			FROM
				user u
			WHERE
				u.email = ' . $this->db->escape($email) . '
				and u.verification = ' .$this->db->escape($token). '
				and u.status = 0
		')->row();
	}

	public function checkStatus($email) {
		$user = $this->db->query('
			SELECT
				u.status
			FROM
				user u
			WHERE
				u.email = ' . $this->db->escape($email) . '
		')->row();
		return $user ? $user->status : false;
	}

	public function addUser($email, $verification) {
		return $this->db->query('
			INSERT INTO user(email, verification, status)
			VALUES ('.$this->db->escape($email).', '.$this->db->escape($verification).', 0);
		');
	}

	public function _generateToken() {
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$token = '';
		for($i=0;$i<=15;$i++)
			$token.= substr($chars, rand(0, strlen($chars)), 1);
		return $token;
	}	
	
}