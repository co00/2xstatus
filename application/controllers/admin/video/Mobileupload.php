<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobileupload extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->base_url = BASE_URL_ADMIN.'mobileupload/';
        $this->module_name = 'Mobileupload';

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
		$this->load->view(ADMIN_VIEW.'video/mobileupload',$data);
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

        //$this->form_validation->set_rules('name','Name','required|trim|is_unique[post_video.name]');
        $this->form_validation->set_rules('category_id','Category','required');

         if (empty($_FILES['video_link']['name'])) {
                $this->form_validation->set_rules('video_link','Video Upload','required');
            }

        if( !$this->form_validation->run() ) {
            $response = $this->crud->response([], validation_errors(), false);
        } else {

            if( !empty($_FILES['video_link']['name']) ) {
                    $upload_data1 = $this->crud->upload('video_link',VIDEO_THUMBNAIL.date('M_Y'),'mp4');
                    if( $upload_data1['response'] ) {
                        $post_data['video_link'] = date('M_Y').'/'.$upload_data1['error'];
                    } else {
                        $response = $this->crud->response([], $upload_data1['error'], false);
                    }
                }

            $file = IMAGE_THUMBNAIL.date('M_Y')."/thum".time().".png";
            $uri = substr($post_data['image_thumbnail'],strpos($post_data['image_thumbnail'], ",") + 1);
            file_put_contents($file, base64_decode($uri));

            $post_data['image_thumbnail'] = date('M_Y')."/thum".time().".png";

            $name_temp = pathinfo($post_data['image_thumbnail'], PATHINFO_FILENAME);
            $post_data['name'] = substr($name_temp, 0, 20);

            $post_data['upload_date'] = date('M_Y');
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