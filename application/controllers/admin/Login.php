<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->base_url = BASE_URL_ADMIN.'login';

		if($this->uri->segment(3) != 'logout') {
			$is_login = false;

			if( $this->crud->is_admin_login() ) {
				$is_login = true;
			} elseif( $this->crud->is_sub_admin_login() ) {
				$is_login = true;
			}

			if($is_login) {
				redirect(BASE_URL_ADMIN.'dashboard');
			}
		}
	}
	
	public function index()
	{
		$this->load->view(ADMIN_VIEW.'login');
	}

	public function authenticate()
	{
		$this->form_validation->set_rules('username','Username','trim|required');
		$this->form_validation->set_rules('password','Password','trim|required');
		$this->form_validation->set_rules('check','Select','trim|required');

		if( !$this->form_validation->run() ) {
			$this->index();
		} else {
			$post_data = $this->input->post();


			if ($post_data['check'] == 1) 
			{

				$admin_id = $this->crud->admin_authenticate($post_data['username'], $post_data['password']);

				
				if( $admin_id ) {
					$this->session->set_userdata('admin_id',$admin_id);
					$this->session->set_userdata('admin_username', $post_data['username']);

					$this->session->set_userdata('admin_row',$this->crud->get_one_row('admin', ['id' => $admin_id]));

					$this->session->set_userdata('common_username', $post_data['username']);

					redirect(BASE_URL_ADMIN.'dashboard');
				} else {
					$this->session->set_flashdata('error','Username and password does not match!');
					redirect($this->base_url);
				}

			}elseif ($post_data['check'] == 2) {

				$sub_admin_id = $this->crud->sub_admin_authenticate($post_data['username'], $post_data['password']);
					if( $sub_admin_id ) 
					{

						$this->session->set_userdata('sub_admin_id',$sub_admin_id);
						$this->session->set_userdata('sub_admin_username', $post_data['username']);

						$this->session->set_userdata('sub_admin_row',$this->crud->get_one_row('sub_admin', ['id' => $sub_admin_id]));

						$this->session->set_userdata('common_username', $post_data['username']);
					
						redirect(BASE_URL_ADMIN.'dashboard');
					} else {
						$this->session->set_flashdata('error','Username and password does not match!');
						redirect($this->base_url);
					}

			}

		}
	}

	public function logout()
	{
		if($this->session->has_userdata('admin_id') && $this->session->has_userdata('admin_username')) {
			$this->session->unset_userdata('admin_id');
			$this->session->unset_userdata('admin_username');

			$this->session->unset_userdata('admin_row');

		} elseif( $this->session->has_userdata('sub_admin_id') && $this->session->has_userdata('sub_admin_username') ) {
			$this->session->unset_userdata('sub_admin_id');
			$this->session->unset_userdata('sub_admin_username');

			$this->session->unset_userdata('sub_admin_row');
		}

		$this->session->set_flashdata('response','success');
		$this->session->set_flashdata('msg','Logged out successfully!');

		redirect($this->base_url);
	}
}

?>