<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->base_url = BASE_URL_ADMIN.'offer/';

		if( !$this->crud->is_user_login() ) {
            redirect(BASE_URL_ADMIN.'login');
        }

	}

	public function index()
	{
		$this->load->view(ADMIN_VIEW.'offer/index');
	}

	public function datatable()
	{
		$this->load->library('datatables');
        $this->datatables->select('id,md5,name,image,link,description,status');
        $this->datatables->from('offer');

        $data = json_decode($this->datatables->generate("json"), true);
        # loop through each item and set param identifier

        $row = [];
        $temp_row = [];
        $no = 1;
        foreach ($data['data'] as $key => $value) {
        	$temp_row['id'] = $no;
        	$temp_row['image'] = '<img style="width:50px;height:50px;" src="'.BASE_URL.OFFER_UPLOADS.$value['image'].'" class="img-responsive dt-img">';
            $temp_row['name'] = '<b>'.$value['name'].'</b>';
            $temp_row['link'] = '<b>'.$value['link'].'</b><br>';

            $temp_row['link'] .= '<button style="width:100%;" class="btn btn-danger btn-copylink" data-clipboard-text="'.BASE_URL.'offer/'.$value['md5'].'">Copy link</button>';



            $temp_row['description'] = '<div style="width:200px;">'.$value['description'].'</div>';


            if( $value['status'] == 0 ) {
                $checked = '';
            } else {
                $checked = 'checked';
            }

             $temp_row['status'] = '<div class="col-md-10 checkbox checkbox-switchery switchery-sm  "><input type="checkbox" class="switchery change_status" '.$checked.' data-href="'.BASE_URL_ADMIN.'offer/change_status/'.$value['id'].'/'.$value['status'].'"></div>';

            $temp_row['action'] = '<a class="p-5 edit" href="'.BASE_URL_ADMIN.'offer/edit/'.$value['id'].'"><i class="icon-pencil3"></i></a>';


            $temp_row['action'] .= '<a class="p-5 delete text-danger" href="'.BASE_URL_ADMIN.'offer/delete/'.$value['id'].'"><i class="icon-trash"></i></a>';


            $temp_row['action'] .= '<br><br><a style="width:100%;" class="btn btn-primary" href="'.BASE_URL_ADMIN.'offerstep/'.$value['md5'].'">Step</a>';

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

    public function store()
    {

       $post_data = $this->input->post();



       $this->form_validation->set_rules('name','Name','required');
       $this->form_validation->set_rules('link','Link','required');
       $this->form_validation->set_rules('status','status','required');

        if(empty($_FILES['image']['name']) ) {
                $this->form_validation->set_rules('image','Image Upload','required');
        }


       if( !$this->form_validation->run() ) {
            $response = $this->crud->response([], validation_errors(), false);
        } else {


            if( !empty($_FILES['image']['name']) ) {
                $upload_data = $this->crud->upload('image',OFFER_UPLOADS,'gif|jpg|png');
                if( $upload_data['response'] ) {
                    $post_data['image'] = $upload_data['error'];
                } else {
                    $response = $this->crud->response([], $upload_data['error'], false);
                }
            }

            //echo '<pre>'; print_r($post_data['image']); die();

            $post_data['at_date'] = date('Y-m-d');
            $post_data['created_at'] = date('Y-m-d H:i:s');


            $insert_id = $this->crud->insert('offer',$post_data);

            $is_success = $this->crud->update('offer',['md5'=>md5($insert_id)],['id'=>$insert_id]);

            if( $is_success ) {
                $response = $this->crud->response([], 'Record added successfully ', true);
            } else {
                $response = $this->crud->response([], 'Something went wrong! Please try again.', false);
            }

           
        }

        echo json_encode($response);
    }

    public function delete($id = null)
    {

        if( !is_null($id) ) {
            $data = $this->crud->get_selected_fields('offer','image,md5',['id' => $id]);
            if( !empty($data[0]->image) ) {
                unlink(FCPATH.OFFER_UPLOADS.$data[0]->image);
            }

            $is_success = $this->crud->delete('offer',['id' => $id]);
            if( $is_success ) {
                 $is_success = $this->crud->delete('offer_step',['offer_id' => $data[0]->md5]);
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

        if( !empty($id) ) {
            $result = $this->crud->get_one_row('offer',['id' => $id]);

            if( !empty($result) ) {

                $content = '';

                $content .= '<div class="col-md-12"><center><img src="'.BASE_URL.OFFER_UPLOADS.$result->image.'"  style="width:100px; height:100px;" /></center></div>';

                $content .= '<div class="col-md-12"><b>Image Update</b><br><input type="file" class="file-styled" id="update-image" name="image"></div><br>';

                $content .= '<div class="col-md-12"><br><b>Name</b><br><input type="text" class="form-control" id="update-name" value="'.$result->name.'" /><br><input type="hidden" id="update-id" value="'.$result->id.'" /><input type="hidden" id="update-old-img" value="'.$result->image.'" /></div>';

                $content .= '<div class="col-md-12"><b>Link</b><br><input type="text" class="form-control" id="update-link" value="'.$result->link.'" /><br></div>';

                $content .= '<div class="col-md-12"><b>Description</b><br><input type="text" class="form-control" id="update-description" value="'.$result->description.'" /><br></div>';

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
        $this->form_validation->set_rules('link','Link','required|trim');

        if( !$this->form_validation->run() ) {
                $response = $this->crud->response([], validation_errors(), false);
        } else { 


            if( !empty($_FILES['image']['name']) ) {
                if( !empty($post_data['old_image']) ) {
                    if(file_exists(FCPATH.OFFER_UPLOADS.$post_data['old_image'])) {
                        unlink(FCPATH.OFFER_UPLOADS.$post_data['old_image']);
                    }
                }

                $upload_data = $this->crud->upload('image',OFFER_UPLOADS,'gif|jpg|jpeg|png');
                if( $upload_data['response'] ) {
                    $post_data['image'] = $upload_data['error'];
                } else {
                    $response = $this->crud->response([], $upload_data['error'], false);
                }
            }else{
                unset($post_data['image']);
            }

            unset($post_data['old_image']);

            $is_success = $this->crud->update('offer',$post_data,['id' => $post_data['id']]);

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

        $success = $this->crud->update('offer', ['status' => !$status], ['id' => $id]);
        $new_status = 0;
        if( $success ) {
            if($status == 0) {
                $new_status = 1;
            }
            $response = $this->crud->response('success','Status changed successfully!',1);
        } else {
            $response = $this->crud->response('error','Something went wrong!',0);
        }

        $response['new_url'] = BASE_URL_ADMIN.'offer/change_status/'.$id.'/'.$new_status;
        echo json_encode($response);
    }
}

?>