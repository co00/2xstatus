<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Firebaseupload extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->base_url = BASE_URL_ADMIN.'firebaseupload/';
        $this->module_name = 'Firebaseupload';

		if( !$this->crud->is_user_login() ) {
            redirect(BASE_URL_ADMIN.'login');
        }


        if( !$this->crud->is_user_authorized($this->module_name) ) {
            $this->session->set_flashdata('response','error');
            $this->session->set_flashdata('msg','You are not authorized by administrator to access this section.');

            if(isset($_SERVER['HTTP_REFERER'])) {
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                redirect(BASE_URL_ADMIN.'dashboard');
            };
        }

	}

	public function index()
	{

        if( !$this->crud->sub_admin_has_role($this->module_name, 'view') ) {

            if ($this->input->is_ajax_request()) {
               
               $response = $this->crud->response('error','You are not authorized by administrator to access this section.', 0);
               echo json_encode($response);
               exit;
               
            } else {

                $this->session->set_flashdata('response','error');
                $this->session->set_flashdata('msg','You are not authorized by administrator to access this section. 1');

                if(isset($_SERVER['HTTP_REFERER'])) {
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    redirect(BASE_URL_ADMIN.'dashboard');
                };
            }
        }


        $data['category'] = $this->crud->get_selected_fields('category','id,name',['category_status'=>1]);
		$this->load->view(ADMIN_VIEW.'video/firebaseupload',$data);
	}

	public function store()
    {
        if( !$this->crud->sub_admin_has_role($this->module_name, 'add') ) {

            if ($this->input->is_ajax_request()) {
               
               $response = $this->crud->response('error','You are not authorized by administrator to access this section.', 0);
               echo json_encode($response);
               exit;
               
            } else {

                $this->session->set_flashdata('response','error');
                $this->session->set_flashdata('msg','You are not authorized by administrator to access this section. 1');

                if(isset($_SERVER['HTTP_REFERER'])) {
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    redirect(BASE_URL_ADMIN.'dashboard');
                };
            }
        }
        $post_data = $this->input->post();
        $this->form_validation->set_rules('category_id','Category','required');
        if( !$this->form_validation->run() ) {
            $response = $this->crud->response([], validation_errors(), false);
        } else {
        	
            // $name_temp = pathinfo($post_data['image_thumbnail'], PATHINFO_FILENAME);
            // $post_data['name'] = substr($name_temp, 0, 20);

            $post_data['name'] = substr($post_data['name'], 0, 20);
            
            $is_success = $this->crud->insert('post_video',$post_data);

            if( $is_success ) {
                $response = $this->crud->response([], 'Record added successfully', true);
            } else {
                $response = $this->crud->response([], 'Something went wrong! Please try again.', false);
            }
        }

        echo json_encode($response);
    }

}

?>