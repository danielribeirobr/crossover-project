<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller {

	public $layout = 'default';

	public function __construct() {
		parent::__construct();
		$this->loadUserBox();
	}

	public function index() {
		$data['highlights'] = $this->news_model->get_highlights();
		$this->load->view('index', $data);
	}

	public function myitens() {
		if(!$this->_getUser())
			redirect(base_url());
		$this->load->view('my-news', array('news' => $this->news_model->getRecordsByUser($this->_getUser()->user_id)));
	}

	public function rss() {
		$this->layout = 'rss';
		$data['highlights'] = $this->news_model->get_highlights();
		$this->load->view('rss', $data);
	}

	public function pdf($news_id) {
		$data = $this->news_model->get($news_id);
		require_once(APPPATH . '/third_party/fpdf181/fpdf.php');
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(90,10,'PDF Version of Item post!');
		$pdf->Ln(10);
		$pdf->SetFont('Arial','B', 12);
		$pdf->Cell(190,10, $data->title);
		$pdf->Ln(10);
		$pdf->Image(realpath(APPPATH . '../') . '/images/' . $data->image,10,30,80,50,'','http://www.fpdf.org');
		$pdf->Ln(55);	
		$pdf->SetFont('Arial', '', 10);
		$pdf->write(5, $data->text);
		$pdf->Output();
		exit;
	}

	public function add() {
		if(!$this->_getUser())
			redirect(base_url());

		if($this->input->post()) {
			$this->load->library('form_validation');

			// form validation
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('text', 'Text', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('message', validation_errors());
			} else {
				$result = $this->_saveImage();
				if(!isset($result['file_name'])) {
					$this->session->set_flashdata('message', $result);
				} else {
					$this->news_model->add(array(
						'title'		=> $this->input->post('title'),
						'text'		=> $this->input->post('text'),
						'image'		=> $result['file_name'],
						'user_id'	=> $this->_getUser()->user_id
					));
					redirect(base_url() . 'news/myitens');					
				}
			}
		}

		$this->load->view('add-news');
	}

	public function delete($news_id) {
		// remove image
		@unlink(realpath(APPPATH . '../') . '/images/' . $this->news_model->get($news_id)->image);

		//remove record
		$this->news_model->delete($news_id, $this->_getUser()->user_id);
		$this->session->set_flashdata('message', 'Item removed');
		redirect(base_url() . 'news/myitens');
	}

	public function view($news_id) {
		$data['news_item'] = $this->news_model->get($news_id);
		$this->load->view('item', $data);
	}

	protected function _saveImage() {
		$this->load->library('upload', array(
			'upload_path'		=> realpath(APPPATH . '../') . '/images/',
			'allowed_types'		=> 'gif|jpg|png'
		));

		if (!$this->upload->do_upload('image'))
			return $this->upload->display_errors();
		else {
			$data = $this->upload->data();
			$this->load->library('image_lib', array(
				'image_library'		=> 'gd2',
				'source_image'		=> $data['full_path'],
				'create_thumb'		=> TRUE,
				'maintain_ratio'	=> TRUE,
				'width'				=> 200,
				'height'			=> 200				
			));
			$this->image_lib->resize();

			// remove original image and rename thumb to original name
			unlink($data['full_path']);
			rename(
				$this->_thumbName($data['full_path']),
				$data['full_path']
			);

			return $data;			
		}
	}

	protected function _thumbName($n) {
		$p = 0;
		$s = strlen($n);
		for($i=1;$i<=$s;$i++) {
			if(substr($n, 0-$i, 1) == '.') {
				$p = $s-$i;
				break;
			}
		}
		return substr($n, 0, $p) . '_thumb' . substr($n, $p);
	}

}
