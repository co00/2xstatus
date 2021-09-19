<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_update extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->base_url = BASE_URL_ADMIN.'app_update/';
        $this->module_name = 'App_update';

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
        
        $data['app_update'] = $this->crud->get_one_row('app_update',['id'=>1]);
        $data['setting'] = $this->crud->get_all('setting');

        foreach ($data['setting'] as $key => $value) {
            
            if ($value->name == 'update') 
            {
                $data['update_id'] = $value->id;
                $data['update_status'] = $value->status;
                $data['update_value'] = $value->value;
            }elseif ($value->name == 'in_app_update') {
                $data['in_app_update_id'] = $value->id;
                $data['in_app_update_status'] = $value->status;
            }
        }

		$this->load->view(ADMIN_VIEW.'app_update/index',$data);
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

        if( !$this->crud->sub_admin_has_role($this->module_name, 'update') ) {

            if ($this->input->is_ajax_request()) {
               
               $response = $this->crud->response('error','You are not authorized by administrator to access this section.', 0);
               echo json_encode($response);
               exit;
               
            } else {

                $this->session->set_flashdata('response','error');
                $this->session->set_flashdata('msg','You are not authorized by administrator to access this section.');

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


            if( !empty($_FILES['image']['name']) ) {

                if( !empty($post_data['old_image']) ) {
                    if(file_exists(FCPATH.BANNER_UPLOADS.$post_data['old_image'])) {
                        unlink(FCPATH.BANNER_UPLOADS.$post_data['old_image']);
                    }
                }

                $upload_data = $this->crud->upload('image',BANNER_UPLOADS,'gif|jpg|jpeg|png');
                if( $upload_data['response'] ) {
                    $post_data['image'] = $upload_data['error'];
                } else {
                    $response = $this->crud->response([], $upload_data['error'], false);
                }
            }else{
                unset($post_data['image']);
            }

            unset($post_data['old_image']);

            $is_success = $this->crud->update('app_update',$post_data,['id' => 1]);

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

        if( !$this->crud->sub_admin_has_role($this->module_name, 'change_status') ) {

            if ($this->input->is_ajax_request()) {
               
               $response = $this->crud->response('error','You are not authorized by administrator to access this section.', 0);
               echo json_encode($response);
               exit;
               
            } else {

                $this->session->set_flashdata('response','error');
                $this->session->set_flashdata('msg','You are not authorized by administrator to access this section.');

                if(isset($_SERVER['HTTP_REFERER'])) {
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    redirect(BASE_URL_ADMIN.'dashboard');
                };
            }
        }


        $new_status = 'inactive';

        if($status == 'inactive') {
            $new_status = 'active';
        }else{
            $new_status = 'inactive';
        }

        $success = $this->crud->update('setting', ['status' => $new_status], ['id' => $id]);



        if( $success ) {
            $response = $this->crud->response('success','Status changed successfully!',1);
        } else {
            $response = $this->crud->response('error','Something went wrong!',0);
        }

        $response['new_url'] = BASE_URL_ADMIN.'app_update/change_status/'.$id.'/'.$new_status;
        echo json_encode($response);
    }


}

?>