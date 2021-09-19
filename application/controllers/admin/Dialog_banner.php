<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dialog_banner extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->base_url = BASE_URL_ADMIN.'category/';
        $this->module_name = 'Dialog_banner';

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

        $data['dialog_banner'] = $this->crud->get_one_row('dialog_banner',['id'=>1]);
		$this->load->view(ADMIN_VIEW.'dialog_banner/index',$data);
	}

    public function update()
    {

        if( !$this->crud->sub_admin_has_role($this->module_name, 'update') ) {

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

        $this->form_validation->set_rules('link','Link','required|trim');

        if( !$this->form_validation->run() ) {
                $response = $this->crud->response([], validation_errors(), false);
        } else { 


            if( !empty($_FILES['imageurl']['name']) ) {

                if( !empty($post_data['old_image']) ) {
                    if(file_exists(FCPATH.BANNER_UPLOADS.$post_data['old_image'])) {
                        unlink(FCPATH.BANNER_UPLOADS.$post_data['old_image']);
                    }
                }

                $upload_data = $this->crud->upload('imageurl',BANNER_UPLOADS,'gif|jpg|jpeg|png');
                if( $upload_data['response'] ) {
                    $post_data['imageurl'] = $upload_data['error'];
                } else {
                    $response = $this->crud->response([], $upload_data['error'], false);
                }
            }else{
                unset($post_data['imageurl']);
            }

            unset($post_data['old_image']);

            $is_success = $this->crud->update('dialog_banner',$post_data,['id' => 1]);

            if( $is_success ) {
                $response = $this->crud->response([], 'Record update successfully', true);
            } else {
                $response = $this->crud->response([], 'Something went wrong! Please try again.', false);
            }
        }

        echo json_encode($response);
    }

    public function change_status($id,$status)
    {

        if( !$this->crud->sub_admin_has_role($this->module_name, 'change_status') ) {

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


        $new_status = '0';

        if($status == '0') {
            $new_status = '1';
        }else{
            $new_status = '0';
        }

        $success = $this->crud->update('dialog_banner', ['status' => $new_status], ['id' => $id]);



        if( $success ) {
            $response = $this->crud->response('success','Status changed successfully!',1);
        } else {
            $response = $this->crud->response('error','Something went wrong!',0);
        }

        $response['new_url'] = BASE_URL_ADMIN.'dialog_banner/change_status/'.$id.'/'.$new_status;
        echo json_encode($response);
    }


}

?>