<?php defined('BASEPATH') OR exit('No direct script access allowed');

class News_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function add($news) {
		return $this->db->query('
			INSERT INTO news SET
				title = ' . $this->db->escape($news['title']) . ',
				text = ' . $this->db->escape($news['text']) . ',
				image = ' . $this->db->escape($news['image']) . ',
				user_id = ' . $this->db->escape($news['user_id']) . '
		');
	}

	public function delete($news_id, $user_id) {
		$this->db->query('
			DELETE FROM news WHERE
				news_id = ' . $this->db->escape($news_id) . '
				AND user_id = '. $this->db->escape($user_id)
			);
	}

	public function get($news_id) {
		return $this->db->query('
			SELECT
				n.news_id,
				n.title,
				n.text,
				n.image,
				n.date_add,
				u.email
			FROM
				news n
			LEFT JOIN user u USING(user_id)
			WHERE n.news_id = ' . $this->db->escape($news_id) . '
		')->row();
	}

	public function getRecordsByUser($user_id) {
		return $this->db->query('
			SELECT
				n.news_id,
				n.title,
				n.date_add,
				n.image,
				u.email
			FROM
				news n
			LEFT JOIN user u USING(user_id)
			WHERE u.user_id = ' . $this->db->escape($user_id) . '
			ORDER BY date_add DESC
		')->result();
	}

	public function get_highlights() {
		return $this->db->query('
			SELECT
				n.news_id,
				n.title,
				n.date_add,
				n.image,
				n.text,
				u.email
			FROM
				news n
			LEFT JOIN user u USING(user_id)
			ORDER BY date_add DESC
			LIMIT 10
		')->result();
	}
	
}