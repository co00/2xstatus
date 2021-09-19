<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_list extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->base_url = BASE_URL_2XSTATUS.'video_list';
    }
    
    public function index()
    {
        $this->load->view(STATUS_VIEW.'video_list');
    }

    public function list_video($page)
    {
        $pagination = '';

        $limit = 10;
        $start = ($page - 1) * $limit;

        $total = $this->crud->countrow('post_video');
        $page_limit = $total/$limit;

        if ($page_limit > 0) {
                $page_limit = $total/1;
        }

        if($page <= $page_limit)
        {

            $this->db->limit($limit, $start);
            $result = $this->crud->get_with_join('post_video v',
            'v.id as id,
            v.name as name,
            v.image_thumbnail as image_thumbnail,
            v.video_link as video_link,
            v.video_view as video_view,
            v.upload_type as upload_type,
            v.status as status,
            cat.name as category_name
            ', 
            ["v.status"=>1,'v.video_type'=>1],['category cat' => 'v.category_id = cat.id'], ['left'],'v.id','DESC');

            $post_video = '';

            if (!empty($result)) 
            {
                foreach ($result as $key => $value) 
                {
                    $img_path = '';
                    $video_path = '';
                    if ($value->upload_type == 'upload') 
                    {
                        $img_path = BASE_URL.IMAGE_THUMBNAIL.$value->image_thumbnail;
                        $video_path = BASE_URL.VIDEO_THUMBNAIL.$value->video_link;

                        $edit_btn = '<a href="'.BASE_URL_2XSTATUS.'Video_list/edit_upload/'.$value->id.'" class="action_btn mr_10 edit_upload"> <i class="far fa-edit"></i> </a>';

                    }else{
                        $img_path = $value->image_thumbnail;
                        $video_path = $value->video_link;

                        $edit_btn = '<a href="'.BASE_URL_2XSTATUS.'Video_list/edit_link/'.$value->id.'" class="action_btn mr_10 edit_link"> <i class="far fa-edit"></i> </a>';
                    }

                    $post_video .= '<div class="col-md-3">
                        <div class="white_card position-relative mb_20 ">
                            <div class="card-body">';

                    $post_video .= '<img src="'.$img_path.'" alt="" class="" style="width: 100%;height: 350px;border-radius: 5px;" >';

                    $post_video .= '<div class="row my-4">';
                    $post_video .= '<div class="col">
                    <span class="badge_btn_1  mb-1">'.$value->id.'</span>
                    <span class="badge_btn_3  mb-1">'.$value->category_name.'</span>  <a href="#" class="f_w_400 color_text_3 f_s_14 d-block">'.$value->name.'</a></div>';
                    $post_video .= '</div>';


                    $status = 'badge_active3';
                    if ($value->status == '1') {
                        $status = 'badge_active';
                    }
                    
                    $post_video .= '<div class="action_btns d-flex">
                                                            <a href="#" class="'.$status.' mr_10">Active</a>
                                                            '.$edit_btn.'
                                                            <a href="#" class="action_btn"> <i class="fas fa-trash"></i> </a>
                                                        </div>';

                    $post_video .= '</div>
                        </div>
                    </div>';
                }
            }


            $current_page = $page;


            $pagination .= '<nav style="padding: 20px;">
                            <ul class="pagination">';

                            $page_limit = $page_limit;
                            if($current_page > 1) 
                            {

                            $pagination .= '<li class="page-item"><a href="javascript:void(0)" class="page-link pagination-button" data-page="'.($current_page - 1).'">Previous<a/></li>';
                            }

                            if(($current_page - 1) > 1) {
                                $pagination .= '<li class="page-item"><a class="page-link">...<a/></li>';
                             }

                             for ($i=($current_page - 1); $i <= ($current_page +1) ; $i++) {

                                if($i == $current_page) {
                                    $current = 'active';
                                } else {
                                    $current = '';
                                }

                                if($i >= 1 && $i <= $page_limit) {

                                $pagination .= '<li class="page-item '.$current.' pagination-button" data-page="'.$i.'"><a href="javascript:void(0)" class="page-link">'.$i.'<a/></li>';

                                // $pagination .= '<li class="'.$current.'><a href="javascript:void(0)" class="pagination-button" data-page="'.$i.'">'.$i.'</a></li>';

                                 }
                              }

                              if(($current_page + 1) < $page_limit) 
                              {

                                     $pagination .= '<li class="page-item"><a class="page-link">...<a/></li>';
                               }
                           if($current_page < $page_limit){

                             $pagination .= '<li class="page-item"><a href="javascript:void(0)" class="page-link pagination-button" data-page="'.($current_page + 1).'">Next<a/></li>';
                           }

            $pagination .= '</ul>';

            $pagination .= '<p class="justify-content-end">Showing '.($start + 1).'–'.($start + $limit).' of '.$total.' results</p>';

            $pagination .= '</nav>';


            echo json_encode([
                                'response' => true,
                                'pagination' => $pagination,
                                'post_video' => $post_video,
                            ]);
        }


        

    }


    public function edit_upload($id = null)
    {
        if( !empty($id) ) {
            $result = $this->crud->get_one_row('post_video',['id' => $id]);
            $category = $this->crud->get_with_where('category',['status'=>1,'category_status'=>1]);

            if( !empty($result) ) {

                $content = '<div class="row panel panel-default" style="padding: 20px;">';

                $content .= '<div class="col-md-6"><img src="'.BASE_URL.IMAGE_THUMBNAIL.$result->image_thumbnail.'"  style="width:100px; height:150px;" /></div>';

                $content .= '<div class="col-md-6"><video style="width:200px; height:150px;" controls> <source src="'.BASE_URL.VIDEO_THUMBNAIL.$result->video_link.'" type="video/mp4"></video></div>';

                $content .= '</div>';


                $content .= '<div class="row panel panel-default" style="padding: 20px;">';

                $content .= '<div class="col-md-6"><b>Image thumbnail</b><br><input type="file" class="file-styled" id="image_upload_value" name="image_upload_value" accept="image/*""></div>';

                $content .= '<div class="col-md-6"><b>Video Upload</b><br><input type="file" class="file-styled" id="video_upload_value" name="video_upload_value" accept="video/*"></div>';

                $content .= '<div class="col-md-6" style="margin-top:10px;"><b>Category</b><br><select class="select form-control" name="category_id_value" id="category_id_value">
                            <option value="">Select Category</option>';

                if (!empty($category)) 
                {
                    $selected = '';
                    foreach ($category as $key => $value) {

                        if ($value->id == $result->category_id) {
                            $selected = 'selected';
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

                $content .= '<div class="col-md-12" style="margin-top:10px;"><b>Name</b><br><input type="text" class="form-control" id="name_value" value="'.$result->name.'" /><br></div>';


                $content .= '<input type="hidden" id="old_image" value="'.$result->image_thumbnail.'" />';
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

     public function edit_link($id = null)
    {

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

    public function update()
    {
        $post_data = $this->input->post();
        $this->form_validation->set_rules('name','Name','required|trim');

        if( !$this->form_validation->run() ) {
            $response = $this->crud->response([], validation_errors(), false);
        } else {

            if( !empty($_FILES['image_thumbnail']['name']) ) {
                if( !empty($post_data['old_image']) ) {
                    if(file_exists(FCPATH.IMAGE_THUMBNAIL.$post_data['old_image'])) {
                        unlink(FCPATH.IMAGE_THUMBNAIL.$post_data['old_image']);
                    }
                }

                $upload_data = $this->crud->upload('image_thumbnail',IMAGE_THUMBNAIL.date('M_Y'),'gif|jpg|jpeg|png');
                if( $upload_data['response'] ) {
                    $post_data['image_thumbnail'] = date('M_Y').'/'.$upload_data['error'];
                } else {
                    $response = $this->crud->response([], $upload_data['error'], false);
                }
            }else{
                unset($post_data['image_thumbnail']);
            }

            if( !empty($_FILES['video_link']['name']) ) {
                if( !empty($post_data['old_video']) ) {
                    if(file_exists(FCPATH.VIDEO_THUMBNAIL.$post_data['old_video'])) {
                        unlink(FCPATH.VIDEO_THUMBNAIL.$post_data['old_video']);
                    }
                }
                $upload_data = $this->crud->upload('video_link',VIDEO_THUMBNAIL.date('M_Y'),'mp4');
                if( $upload_data['response'] ) {
                    $post_data['video_link'] = date('M_Y').'/'.$upload_data['error'];
                } else {
                    $response = $this->crud->response([], $upload_data['error'], false);
                }
            }else{
                unset($post_data['video_link']);
            }

            unset($post_data['old_image']);
            unset($post_data['old_video']);

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

    public function updateLink()
    {

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
}
