<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class Schedule_model extends CI_Model{

		public function __construct() {
			
			$this->load->database();

		}

		public function get_posts($id = FALSE,$section) {

			if($id === FALSE) {
				
				$this->db->order_by('created_at', 'DESC');
				$query = $this->db->get_where('schedule', array('section' => $section));
				return $query->result_array();
				
			}

			$query = $this->db->get_where('schedule', array('id' => $id));

			return $query->row_array();
		}

		public function get_all_posts($id = NULL) {

			if($id === NULL){
				
				$this->db->order_by('created_at', 'DESC');
				$query = $this->db->get_where('schedule');
				return $query->result_array();
				
			}

			$query = $this->db->get_where('schedule', array('id' => $id));

			return $query->row_array();
				
		}

        public function get_public_posts() {

			$this->db->order_by('created_at', 'DESC');
			$this->db->limit(6);
			$query = $this->db->get('schedule');
			
			return $query->result_array();
				
		}
		public function get_single_post($id) {

			$query = $this->db->get_where('schedule', array('id' => $id));
			
			return $query->row_array();
				
		}

		public function create_post($post_image) {
			
$slug = url_title($this->input->post('name'));

			$data = array(
					'name' => $this->input->post('name'),
					'desc' => $this->input->post('desc'),
					'material' => $this->input->post('material'),
					'tujuan' => $this->input->post('tujuan'),
					'target' => $this->input->post('target'),
					'location' => $this->input->post('location'),
					'date' => $this->input->post('date'),
					'durasi' => $this->input->post('durasi'),
					'image' => $post_image,
					'slug' => $slug,
					'created_by' => $this->session->userdata('name'),
					'created_at' => date('Y-m-d H:i:s')
				);

			return $this->db->insert('schedule', $data);

		}

		public function delete_post($id) {

			$this->db->where('id', $id);
			$this->db->delete('schedule');

			return true;

		}

		public function update_post($post_image) {

			$slug = url_title($this->input->post('name'));

			$data = array(
					'name' => $this->input->post('name'),
					'desc' => $this->input->post('desc'),
					'material' => $this->input->post('material'),
					'tujuan' => $this->input->post('tujuan'),
					'target' => $this->input->post('target'),
					'location' => $this->input->post('location'),
					'image' => $post_image,
					'slug' => $slug,
					'date' => $this->input->post('date'),
					'durasi' => $this->input->post('durasi'),
					'created_by' => $this->session->userdata('name'),
					'created_at' => date('Y-m-d H:i:s')
				);

			$this->db->where('id', $this->input->post('id'));

			return $this->db->update('schedule', $data);
		}

	}