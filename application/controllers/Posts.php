<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

	public function index($slug = NULL) {
		
		$data['title'] = 'Latest Posts';
		
		$data['posts'] = $this->Post_model->get_all_posts($slug);
		
		$data['p'] = $this->Post_model->get_posts(false,'p');
		$data['b'] = $this->Post_model->get_posts(false,'b');
		$data['t'] = $this->Post_model->get_posts(false,'t');
		$data['u'] = $this->Post_model->get_posts(false,'u');
		$data['k'] = $this->Post_model->get_posts(false,'k');
		$data['f'] = $this->Post_model->get_posts(false,'f');

		//print_r($data['p']);
		$this->load->view('member_area/templates/header');
		$this->load->view('posts/index', $data);
		$this->load->view('member_area/templates/footer');

	}

	public function view($slug = NULL) {

		$data['post'] = $this->Post_model->get_all_posts($slug);
		//print_r($data['posts']);

		if(empty($data['post'])) {
			show_404();
		}

		$data['title'] = $data['post']['title'];

		$this->load->view('member_area/templates/header');
		$this->load->view('posts/view', $data);
		$this->load->view('member_area/templates/footer');

	}

	public function create() {

		$data['title'] = 'Create Post';
		$data['error'] = '';
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('body', 'body', 'required');
		$this->form_validation->set_rules('section', 'Section', 'required');

		if($this->form_validation->run() === FALSE){

			$this->load->view('member_area/templates/header');
			$this->load->view('posts/create', $data);
			$this->load->view('member_area/templates/footer');

		} else {

			$config['upload_path']          = './assets/posts/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['max_size']             = 2048;
            $config['max_width']            = 1024;
            $config['max_height']           = 1024;
            $config['file_ext_tolower']		= TRUE;
            $config['remove_spaces']		= TRUE;
            $config['detect_mime']			= TRUE;
            $config['encrypt_name']			= TRUE;	
           
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userfile')) {
                
                $errors = array('error' => $this->upload->display_errors());
                $post_image = null;

            }else{
               
            	$data = array('upload_data' => $this->upload->data());
              	$post_image = $this->upload->data('file_name');

            }

            $this->Post_model->create_post($post_image);

            $this->session->set_flashdata('success', 'Successfully created new article');
            redirect('posts');
			
		}

	}

	public function delete($id) {

		$this->Post_model->delete_post($id);

		$this->session->set_flashdata('success', 'Successfully deleted article');
		redirect('posts');
			
	}

	public function edit($slug) {
		$data['post'] = $this->Post_model->get_all_posts($slug);
		//print_r($data['posts']);

		if(empty($data['post'])) {
			show_404();
		}

		$data['title'] = 'Edit Post';

		$this->load->view('member_area/templates/header');
		$this->load->view('posts/edit', $data);
		$this->load->view('member_area/templates/footer');

	}

	public function update() {

		$config['upload_path']          = './assets/posts/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['max_size']             = 2048;
        $config['max_width']            = 1024;
        $config['max_height']           = 1024;
        $config['file_ext_tolower']		= TRUE;
        $config['remove_spaces']		= TRUE;
        $config['detect_mime']			= TRUE;
        $config['encrypt_name']			= TRUE;	

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
                
            $errors = array('error' => $this->upload->display_errors());
            $post_image = $this->input->post('image');

        }else{
               
          	$data = array('upload_data' => $this->upload->data());
           	$post_image = $this->upload->data('file_name');

        }

		$this->Post_model->update_post($post_image);
		
		$this->session->set_flashdata('success', 'Successfully updated article');
		redirect('posts');

	}

}
