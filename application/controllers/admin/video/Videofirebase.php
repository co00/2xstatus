<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videofirebase extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->base_url = BASE_URL_ADMIN.'videofirebase/';
        $this->module_name = 'Videofirebase';

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
        $this->load->view(ADMIN_VIEW.'video/videofirebase',$data);
    }

    public function datatable()
    {
        $this->load->library('datatables');
        $this->datatables->select('
            post.id as id, 
            post.name as name,
            post.image_thumbnail as image_thumbnail, 
            post.video_link as video_link, 
            post.video_view as video_view, 
            post.status as status,  
            post.upload_type as upload_type,  
            cat.name as category');

        $this->datatables->join('category cat','post.category_id = cat.id');
        $this->db->where('upload_type','firebase');
        $this->datatables->from('post_video post');

        $data = json_decode($this->datatables->generate("json"), true);
        # loop through each item and set param identifier

        $row = [];
        $temp_row = [];
        foreach ($data['data'] as $key => $value) {
            $temp_row['id'] = $value['id'];
            $temp_row['name'] = '<b>'.$value['name'].'</b>';
            $temp_row['category'] = '<b>'.$value['category'].'</b>';
            $temp_row['video_view'] = '<b>'.$value['video_view'].'</b>';


            $edit_url = '<a class="p-5 edit-link" href="'.BASE_URL_ADMIN.'video/videofirebase/edit_link/'.$value['id'].'"><i class="icon-pencil3"></i></a>';

            $temp_row['image_thumbnail'] = '<img src="'.$value['image_thumbnail'].'" class="" style="width:50px;height:100px;">';
            $temp_row['video_link'] = '<video width="200" controls> <source src="'.$value['video_link'].'" type="video/mp4"></video>';


            if( $value['status'] == 0 ) {
                $checked = '';
            } else {
                $checked = 'checked';
            }

            //$temp_row['status'] = '<label class="'.$class.'">'.$text.'</label>';

             $temp_row['status'] = '<div class="col-md-10 checkbox checkbox-switchery switchery-sm  "><input type="checkbox" class="switchery change_status" '.$checked.' data-href="'.BASE_URL_ADMIN.'video/videofirebase/change_status/'.$value['id'].'/'.$value['status'].'"></div>';

            $temp_row['action'] = $edit_url;
            $temp_row['action'] .= '<a class="p-5 delete" href="'.BASE_URL_ADMIN.'video/videofirebase/delete/'.$value['id'].'"><i class="icon-trash"></i></a>';

            $row[] = $temp_row;
        }   

        echo json_encode([
            'draw' => $data['draw'],
            'recordsTotal' => $data['recordsTotal'],
            'recordsFiltered' => $data['recordsFiltered'],
            'data' => $row
        ]);
    }

    public function add()
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


        $this->load->view(ADMIN_VIEW.'category/add');
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
        $this->form_validation->set_rules('image_thumbnail','Image link','required');
        $this->form_validation->set_rules('video_link','Video link','required');

        if( !$this->form_validation->run() ) {
            $response = $this->crud->response([], validation_errors(), false);
        } else {

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
            $is_success = $this->crud->delete('post_video',['id' => $id]);
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

    public function edit_link($id = null)
    {

        if( !$this->crud->sub_admin_has_role($this->module_name, 'edit_link') ) {

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
            $result = $this->crud->get_one_row('post_video',['id' => $id]);
            $category = $this->crud->get_with_where('category',['status'=>1,'category_status'=>1]);

            if( !empty($result) ) {

                $content = '<div class="row panel panel-default" style="padding: 20px;">';

                $content .= '<div class="col-md-6"><img src="'.$result->image_thumbnail.'"  style="width:100px; height:150px;" /></div>';

                $content .= '<div class="col-md-6"><video style="width:200px; height:150px;" controls> <source src="'.$result->video_link.'" type="video/mp4"></video></div>';

                $content .= '</div>';

                $content .= '<input type="hidden" value="'.$result->id.'" id="id_link" />';
                $content .= '<input type="hidden" value="'.$result->upload_type.'" id="upload_type" />';


                $content .= '<div class="row panel panel-default" style="padding: 20px;">';

                $content .= '<div class="col-md-6"><b>Image thumbnail</b><br><input type="text" class="form-control" id="image_link_value" value="'.$result->image_thumbnail.'"></div>';

                $content .= '<div class="col-md-6"><b>Video thumbnail</b><br><input type="text" class="form-control" id="video_link_value" value="'.$result->video_link.'"></div>';

                $content .= '<div class="col-md-6" style="margin-top:10px;"><b>Category</b><br><select class="select form-control" id="category_id_value">';

                if (!empty($category)) 
                {
                    $selected = '';
                    foreach ($category as $key => $value) {

                        if ($value->id == $result->category_id) {
                            $selected = 'selected';
                        }else{
                            $selected = '';
                        }

                        $content .= '<option value="'.$value->id.'" '.$selected.'>'.$value->name.'</option>';
                    }
                    
                }

                $content .= '</select></div>';

                $selected_watermark = '';
                if ($result->watermark_status == 1) {
                    $selected_watermark = 'selected';
                }

                 $content .= '<div class="col-md-6" style="margin-top:10px;"><b>Watermark</b><br><select class="select form-control" id="watermark_status_value">';

                  $content .= '<option value="0" '.$selected_watermark.'>Disable</option>';
                  $content .= '<option value="1" '.$selected_watermark.'>Enable</option>';

                 $content .= '</select></div>';

                $content .= '<div class="col-md-12" style="margin-top:10px;"><b>Name</b><br><input type="text" class="form-control" id="name_link" value="'.$result->name.'" /><br></div>';
                $content .= '</div>';

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

    public function updateLink()
    {

        if( !$this->crud->sub_admin_has_role($this->module_name, 'updateLink') ) {

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

        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('image_thumbnail','Image Link','required');
        $this->form_validation->set_rules('video_link','Video Link','required');
        $this->form_validation->set_rules('category_id','Category','required');

        if( !$this->form_validation->run() ) {
            $response = $this->crud->response([], validation_errors(), false);
        } else {

            $post_data['name'] = substr($post_data['name'], 0, 20);
            
            $is_success = $this->crud->update('post_video',$post_data,['id' => $post_data['id']]);

            if( $is_success ) {
                $response = $this->crud->response([], 'Record added successfully', true);
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
        $success = $this->crud->update('post_video', ['status' => !$status], ['id' => $id]);

        $new_status = 0;

        if( $success ) {
            if($status == 0) {
                $new_status = 1;
            }

            $response = $this->crud->response('success','Status changed successfully!',1);
        } else {
            $response = $this->crud->response('error','Something went wrong!',0);
        }

        $response['new_url'] = BASE_URL_ADMIN.'video/videofirebase/change_status/'.$id.'/'.$new_status;
        echo json_encode($response);
    }
}

?>