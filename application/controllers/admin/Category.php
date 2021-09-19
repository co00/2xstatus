<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->base_url = BASE_URL_ADMIN.'category/';
        $this->module_name = 'Category';

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

        $data['category'] = $this->crud->get_with_where('category',['category_status'=>1],'*','preference','ASC');
		$this->load->view(ADMIN_VIEW.'category/index',$data);
	}

	public function datatable()
	{
		$this->load->library('datatables');
        $this->datatables->select('id,name,image,category_status');
        $this->db->where('category_status','1');
        $this->datatables->from('category');

        $data = json_decode($this->datatables->generate("json"), true);
        # loop through each item and set param identifier

        $row = [];
        $temp_row = [];
        $no = 1;
        foreach ($data['data'] as $key => $value) {
        	$temp_row['id'] = $no;
        	$temp_row['image'] = '<img style="width:50px;height:50px;" src="'.BASE_URL.CATEGORY_UPLOADS.$value['image'].'" class="img-responsive dt-img">';
            $temp_row['name'] = '<b>'.$value['name'].'</b>';

            $text = '';
            $class = '';
            $icon = '';
            if ($value['category_status'] == 1) 
            {
                $text = 'FullScreen';
                $class = 'label-primary';
                $icon = '<i class=" icon-mobile"></i> ';
            }else{
                $text = 'LandScape';
                $class = 'label-danger';
                $icon = '<i class=" icon-mobile" style="transform: rotate(90deg);"></i> ';
            }

            $temp_row['category_status'] = '<span class="label '.$class.' ">'.$icon.$text.'</span>';

            $temp_row['action'] = '<a class="p-5 edit" href="'.BASE_URL_ADMIN.'category/edit/'.$value['id'].'"><i class="icon-pencil3"></i> Edit</a>';


            $temp_row['action'] .= '<a class="p-5 delete text-danger" href="'.BASE_URL_ADMIN.'category/delete/'.$value['id'].'"><i class="icon-trash"></i> Delete</a>';

            $row[] = $temp_row;

            $no++;
        }	

       	echo json_encode([
       		'draw' => $data['draw'],
       		'recordsTotal' => $data['recordsTotal'],
       		'recordsFiltered' => $data['recordsFiltered'],
       		'data' => $row
       	]);
	}

    public function storeCategory()
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

        $post_data = [];

        if( !empty($_POST['name']) && !empty($_FILES['image']['name']) ) { 

            if( !empty($_FILES['image']['name']) ) {
                $upload_data = $this->crud->upload('image',CATEGORY_UPLOADS,'gif|jpg|png');
                if( $upload_data['response'] ) {
                    $post_data['image'] = $upload_data['error'];
                } else {
                    echo json_encode([
                        'response' => false,
                        'status' => 'success',
                        'msg' => $upload_data['error']
                    ]);
                }
            }

            $post_data['name'] = $_POST['name'];
            $post_data['category_status'] = $_POST['category_status'];
            
            $is_success = $this->crud->insert('category',$post_data);

            if( $is_success ) {
                echo json_encode([
                        'response' => true,
                        'status' => 'success',
                        'msg' => 'Record added successfully'
                    ]);

            } else {
                echo json_encode([
                        'response' => false,
                        'status' => 'success',
                        'msg' => 'Something went wrong! Please try again.'
                    ]);
            }
        }
    }

    public function delete($id = null)
    {

        if( !$this->crud->sub_admin_has_role($this->module_name, 'delete') ) {

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


        if( !is_null($id) ) {
            $data = $this->crud->get_selected_fields('category','image',['id' => $id]);
            // if( !empty($data[0]->image) ) {
            //     unlink(FCPATH.CATEGORY_UPLOADS.$data[0]->image);
            // }

            $is_success = $this->crud->delete('category',['id' => $id]);
            if( $is_success ) {
                echo json_encode([
                    'response' => true,
                    'status' => 'success',
                    'error' => 'Record deleted successfully'
                ]);
            } else {
                echo json_encode([
                    'response' => false,
                    'status' => 'error',
                    'error' => 'Something went wrong. Please try again.'
                ]);
            }
        } else {
            echo json_encode([
                'response' => false,
                'status' => 'error',
                'error' => 'Direct access to this URL is not allowed'
            ]);
        }
    }

    public function edit($id = null)
    {
        if( !$this->crud->sub_admin_has_role($this->module_name, 'edit') ) {

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


        if( !empty($id) ) {
            $result = $this->crud->get_one_row('category',['id' => $id]);

            if( !empty($result) ) {

                $content = '';

                $content .= '<div class="col-md-12"><center><img src="'.BASE_URL.CATEGORY_UPLOADS.$result->image.'"  style="width:100px; height:100px;" /></center></div>';

                $content .= '<div class="col-md-12"><b>Image Update</b><br><input type="file" class="file-styled" id="update-image" name="image"></div><br>';

                $content .= '<div class="col-md-12"><b>Name</b><br><input type="text" class="form-control" id="update-name" value="'.$result->name.'" /><br><input type="hidden" id="update-id" value="'.$result->id.'" /><input type="hidden" id="update-old-img" value="'.$result->image.'" /></div>';

                echo json_encode([
                    'response' => true,
                    'data'=>$content,
                    'status' => 'success',
                    'error' => 'Record deleted successfully'
                ]);
            } else {
                echo json_encode([
                    'response' => false,
                    'status' => 'error',
                    'error' => 'Something went wrong. Please try again.'
                ]);
            }

            //$this->load->view(ADMIN_VIEW.'category/edit',$data);
        } else {
            echo json_encode([
                'response' => false,
                'status' => 'error',
                'error' => 'Direct access to this URL is not allowed'
            ]);
        }
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

        $this->form_validation->set_rules('name','Name','required|trim');

        if( !$this->form_validation->run() ) {
                $response = $this->crud->response([], validation_errors(), false);
        } else { 


            if( !empty($_FILES['image']['name']) ) {
                if( !empty($post_data['old_image']) ) {
                    if(file_exists(FCPATH.CATEGORY_UPLOADS.$post_data['old_image'])) {
                        unlink(FCPATH.CATEGORY_UPLOADS.$post_data['old_image']);
                    }
                }

                $upload_data = $this->crud->upload('image',CATEGORY_UPLOADS,'gif|jpg|jpeg|png');
                if( $upload_data['response'] ) {
                    $post_data['image'] = $upload_data['error'];
                } else {
                    $response = $this->crud->response([], $upload_data['error'], false);
                }
            }else{
                unset($post_data['image']);
            }

            unset($post_data['old_image']);

            $is_success = $this->crud->update('category',$post_data,['id' => $post_data['id']]);

            if( $is_success ) {
                $response = $this->crud->response([], 'Record update successfully', true);
            } else {
                $response = $this->crud->response([], 'Something went wrong! Please try again.', false);
            }
        }

        echo json_encode($response);
    }

    public function preference()
    {

        if( !$this->crud->sub_admin_has_role($this->module_name, 'preference') ) {

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
        foreach ($post_data['preference'] as $key => $value) 
        {
            $is_success = $this->crud->update('category',['preference'=>$key],['id'=>$value]);
        }


         if( $is_success ) {
                $this->session->set_flashdata('response','success');
                $this->session->set_flashdata('msg','Record added successfully');
                redirect(BASE_URL_ADMIN.'category');
            } else {
                $this->session->set_flashdata('response','error');
                $this->session->set_flashdata('msg','Something went wrong! Please try again.');
                redirect(BASE_URL_ADMIN.'category');
            }

    }
}

?>