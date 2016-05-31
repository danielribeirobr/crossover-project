<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function login() {
		if(
			$user = $this->user_model->checkLogin(
				$this->input->post('email'),
				$this->input->post('password')
			)
		) {
			$this->session->set_userdata('user', $user);
			$this->session->set_flashdata('message', 'User logged');
		}
		else
			$this->session->set_flashdata('message', 'User not found or invalid password.');
		redirect(base_url());
	}

	public function changePassword() {
		if($this->input->post('password')){
			$this->user_model->changePassword($this->_getUser()->email, $this->input->post('password'));
			$this->session->set_flashdata('message', 'Password changed.');
			redirect(base_url());
		}
		$this->load->view('change-password');
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function addUser() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', validation_errors());
		} else {
			$verificationToken = $this->_generateVerificationToken();
			if($this->_sendWelcomeEmail($this->input->post('email'), $verificationToken)) {
				$this->user_model->addUser($this->input->post('email'), $verificationToken);
				$this->session->set_flashdata('message', 'Check your email in order to complete your profile');
			}
		}
		
		redirect(base_url());
	}

	public function validate() {
		if($user = $this->user_model->checkToken($this->input->get('email'), $this->input->get('token')))
			$this->session->set_userdata('user', $user);
		else
			$this->session->set_flashdata('message', 'Invalid token or email');
		redirect(base_url());		
	}

	protected function _sendWelcomeEmail($email, $verificationToken) {
		require_once(APPPATH . '/third_party/PHPMailer-master/PHPMailerAutoload.php');
		$mail = new PHPMailer;

		//$mail->SMTPDebug = 3;                               // Enable verbose debug output

		//$mail->isSMTP();                                      // Set mailer to use SMTP
		//$mail->Host = 'localhost';  // Specify main and backup SMTP servers
		//$mail->SMTPAuth = true;                               // Enable SMTP authentication
		//$mail->Username = 'user@example.com';                 // SMTP username
		//$mail->Password = 'secret';                           // SMTP password
		//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		//$mail->Port = 587;                                    // TCP port to connect to

		$mail->setFrom('from@example.com', 'Mailer');
		$mail->addAddress($email);     // Add a recipient
		//$mail->addReplyTo('info@example.com', 'Information');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = 'Validate your account';
		$mail->Body    = $this->load->view('email', array('email' => $email, 'verificationToken' => $verificationToken), true);
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		if(!$mail->send()) {
			$this->session->set_flashdata('message', $mail->ErrorInfo);
			return false;
		} else {
		    return true;
		}		
	}

	public function _generateVerificationToken() {
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$token = '';
		for($i=0;$i<15;$i++)
			$token.= substr($chars, rand(0, strlen($chars)), 1);
		return $token;
	}	

}
