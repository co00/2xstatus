<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class upload extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->base_url = BASE_URL_ADMIN.'upload/';
        $this->module_name = 'Comedy_video';

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

        $this->load->view(ADMIN_VIEW.'comedyvideo/upload');
    }

    public function datatable()
    {
        $this->load->library('datatables');
        $this->datatables->select('id,upload_type,name,video_link,video_view,watermark_status,status');
        $this->db->where('upload_type','upload');
        $this->datatables->from('comedyvideo');

        $data = json_decode($this->datatables->generate("json"), true);
        # loop through each item and set param identifier

        $row = [];
        $temp_row = [];
        foreach ($data['data'] as $key => $value) {
            $temp_row['id'] = $value['id'];
            $temp_row['name'] = '<b>'.$value['name'].'</b>';
            $temp_row['video_view'] = '<b>'.$value['video_view'].'</b>';

            $temp_row['video_link'] = '<video style="width:200px;height:200px;" controls> <source src="'.BASE_URL.COMEDY_VIDEO.$value['video_link'].'" type="video/mp4"></video>';


            if( $value['status'] == 0 ) {
                $checked = '';
            } else {
                $checked = 'checked';
            }

            //$temp_row['status'] = '<label class="'.$class.'">'.$text.'</label>';

             $temp_row['status'] = '<div class="col-md-10 checkbox checkbox-switchery switchery-sm  "><input type="checkbox" class="switchery change_status" '.$checked.' data-href="'.BASE_URL_ADMIN.'comedyvideo/upload/change_status/'.$value['id'].'/'.$value['status'].'"></div>';

            $temp_row['action'] = '<a class="p-5 edit" href="'.BASE_URL_ADMIN.'comedyvideo/upload/edit/'.$value['id'].'"><i class="icon-pencil3"></i></a>';
            $temp_row['action'] .= '<a class="p-5 delete" href="'.BASE_URL_ADMIN.'comedyvideo/upload/delete/'.$value['id'].'"><i class="icon-trash"></i></a>';

            $row[] = $temp_row;
        }   

        echo json_encode([
            'draw' => $data['draw'],
            'recordsTotal' => $data['recordsTotal'],
            'recordsFiltered' => $data['recordsFiltered'],
            'data' => $row
        ]);
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

        $this->form_validation->set_rules('status','Status','required');

         if (empty($_FILES['video_link']['name'])) {
                $this->form_validation->set_rules('video_link','Video Upload','required');
            }

        if( !$this->form_validation->run() ) {
            $response = $this->crud->response([], validation_errors(), false);
        } else {

            if( !empty($_FILES['video_link']['name']) ) {
                    $upload_data1 = $this->crud->upload('video_link',COMEDY_VIDEO.date('M_Y'),'mp4');
                    if( $upload_data1['response'] ) {
                        $post_data['video_link'] = date('M_Y').'/'.$upload_data1['error'];
                    } else {
                        $response = $this->crud->response([], $upload_data1['error'], false);
                    }
                }

            $post_data['upload_date'] = date('M_Y');
            $post_data['video_view'] = '1';
            $is_success = $this->crud->insert('comedyvideo',$post_data);

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

            // $data = $this->crud->get_selected_fields('comedyvideo','image_thumbnail,video_link',['id' => $id,'upload_type'=>'upload']);
            // if( !empty($data[0]->image_thumbnail && $data[0]->video_link) ) {
            //     unlink(FCPATH.IMAGE_THUMBNAIL.$data[0]->image_thumbnail);
            //     unlink(FCPATH.COMEDY_VIDEO.$data[0]->video_link);
            // }

            $is_success = $this->crud->delete('comedyvideo',['id' => $id]);

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
            $result = $this->crud->get_one_row('comedyvideo',['id' => $id]);

            if( !empty($result) ) {

                $content = '<div class="row panel panel-default" style="padding: 20px;">';

                $content .= '<div class="col-md-6"><video style="width:200px; height:150px;" controls> <source src="'.BASE_URL.COMEDY_VIDEO.$result->video_link.'" type="video/mp4"></video></div>';

                $content .= '<div class="col-md-6">';


                $content .= '<div class="col-md-12"><b>Video Upload</b><br><input type="file" class="file-styled" id="video_upload_value" name="video_upload_value" accept="comedyvideo/*"></div>';

                $selected_watermark = '';
                if ($result->watermark_status == 1) {
                    $selected_watermark = 'selected';
                }

                 $content .= '<div class="col-md-12" style="margin-top:10px;"><b>Watermark</b><br><select class="select form-control" id="watermark_status_value">';

                  $content .= '<option value="0" '.$selected_watermark.'>Disable</option>';
                  $content .= '<option value="1" '.$selected_watermark.'>Enable</option>';

                 $content .= '</select></div>';

                $content .= '</div>';

                $content .= '</div>';


                $content .= '<div class="row panel panel-default" style="padding: 20px;">';

                $content .= '<div class="col-md-12" style="margin-top:10px;"><b>Name</b><br><input type="text" class="form-control" id="name_value" value="'.$result->name.'" /><br></div>';
                $content .= '<input type="hidden" id="old_video" value="'.$result->video_link.'" />';
                $content .= '<input type="hidden" id="id_upload" value="'.$result->id.'" />';

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
        $this->form_validation->set_rules('watermark_status','Watermark Status','required|trim');

        if( !$this->form_validation->run() ) {
            $response = $this->crud->response([], validation_errors(), false);
        } else {

            if( !empty($_FILES['video_link']['name']) ) {
                if( !empty($post_data['old_video']) ) {
                    if(file_exists(FCPATH.COMEDY_VIDEO.$post_data['old_video'])) {
                        unlink(FCPATH.COMEDY_VIDEO.$post_data['old_video']);
                    }
                }
                $upload_data = $this->crud->upload('video_link',COMEDY_VIDEO.date('M_Y'),'mp4');
                if( $upload_data['response'] ) {
                    $post_data['video_link'] = date('M_Y').'/'.$upload_data['error'];
                } else {
                    $response = $this->crud->response([], $upload_data['error'], false);
                }
            }else{
                $post_data['video_link'] = $post_data['old_video'];
            }

            unset($post_data['old_video']);

            $post_data['name'] = substr($post_data['name'], 0, 20);
            
            $is_success = $this->crud->update('comedyvideo',$post_data,['id' => $post_data['id']]);

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


        $success = $this->crud->update('comedyvideo', ['status' => !$status], ['id' => $id]);
        $new_status = 0;
        if( $success ) {
            if($status == 0) {
                $new_status = 1;
            }
            $response = $this->crud->response('success','Status changed successfully!',1);
        } else {
            $response = $this->crud->response('error','Something went wrong!',0);
        }

        $response['new_url'] = BASE_URL_ADMIN.'comedyvideo/upload/change_status/'.$id.'/'.$new_status;
        echo json_encode($response);
    }
}

?>