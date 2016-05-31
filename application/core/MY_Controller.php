<?php

class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();	
		$this->load->model('news_model');		
		$this->load->model('user_model');
		$this->_checkUserChangePassword();
	}

	protected function _getUser() {
		return $this->session->userdata('user');
	}

	protected function _checkUserChangePassword() {
		$user = $this->_getUser();
		if(
			!(strtolower($this->uri->segment(1)) == 'user' 				// controller
			&& strtolower($this->uri->segment(2)) == 'changepassword') 	// action
			&& isset($user->email)
			&& !$this->user_model->checkStatus($user->email)
		)
			redirect(base_url() . 'user/changepassword');
	}

	protected function loadUserBox() {
		if(
			!(strtolower($this->uri->segment(1)) == 'news' 		// controller
			&& strtolower($this->uri->segment(2)) == 'rss') 	// action
		) {
			$this->load->view('user-box', array('user_data' => $this->session->userdata('user')));
		}
	}

}
