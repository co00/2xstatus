<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offerstep extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->base_url = BASE_URL_ADMIN.'Offerstep/';

		if( !$this->crud->is_user_login() ) {
            redirect(BASE_URL_ADMIN.'login');
        }

	}

	public function index($id)
	{

        $data['id'] = $id;
		$this->load->view(ADMIN_VIEW.'offerstep/index',$data);
	}

	public function datatable($offer_id)
	{
		$this->load->library('datatables');
        $this->datatables->select('id,name,image,description');
        $this->db->where('offer_id',$offer_id);
        $this->datatables->from('offer_step');

        $data = json_decode($this->datatables->generate("json"), true);
        # loop through each item and set param identifier

        $row = [];
        $temp_row = [];
        $no = 1;
        foreach ($data['data'] as $key => $value) {
        	$temp_row['id'] = $no;
        	$temp_row['image'] = '<img style="width:50px;height:150px;" src="'.BASE_URL.OFFER_UPLOADS.$value['image'].'" class="img-responsive dt-img">';
            $temp_row['name'] = '<div style="width:200px;"><b>'.$value['name'].'</b></div>';

            $temp_row['description'] = '<div style="width:200px;">'.$value['description'].'</div>';

            $temp_row['action'] = '<a class="p-5 edit" href="'.BASE_URL_ADMIN.'Offerstep/edit/'.$value['id'].'"><i class="icon-pencil3"></i></a>';


            $temp_row['action'] .= '<a class="p-5 delete text-danger" href="'.BASE_URL_ADMIN.'Offerstep/delete/'.$value['id'].'"><i class="icon-trash"></i></a>';

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

    public function storeStep()
    {

       $post_data = $this->input->post();

       $this->form_validation->set_rules('name','Name','required');

        // if(empty($_FILES['image']['name']) ) {
        //         $this->form_validation->set_rules('image','Image Upload','required');
        // }


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

            $post_data['created_at'] = date('Y-m-d H:i:s');


            $is_success = $this->crud->insert('offer_step',$post_data);

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
            $data = $this->crud->get_selected_fields('offer_step','image',['id' => $id]);
            if( !empty($data[0]->image) ) {
                unlink(FCPATH.OFFER_UPLOADS.$data[0]->image);
            }

            $is_success = $this->crud->delete('offer_step',['id' => $id]);
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

        if( !empty($id) ) {
            $result = $this->crud->get_one_row('offer_step',['id' => $id]);

            if( !empty($result) ) {

                $content = '';

                $content .= '<div class="col-md-12"><center><img src="'.BASE_URL.OFFER_UPLOADS.$result->image.'"  style="width:100px; height:100px;" /></center></div>';

                $content .= '<div class="col-md-12"><b>Image Update</b><br><input type="file" class="file-styled" id="update-image" name="image"></div><br>';

                $content .= '<div class="col-md-12"><b>Name</b><br><input type="text" class="form-control" id="update-name" value="'.$result->name.'" /><br><input type="hidden" id="update-id" value="'.$result->id.'" /><input type="hidden" id="update-old-img" value="'.$result->image.'" /></div>';

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

            $is_success = $this->crud->update('offer_step',$post_data,['id' => $post_data['id']]);

            if( $is_success ) {
                $response = $this->crud->response([], 'Record update successfully', true);
            } else {
                $response = $this->crud->response([], 'Something went wrong! Please try again.', false);
            }
        }

        echo json_encode($response);
    }
}

?>