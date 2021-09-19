<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_admin extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->base_url = BASE_URL_ADMIN.'sub_admin/';

		if( !$this->crud->is_user_login() ) {
            redirect(BASE_URL_ADMIN.'login');
        }

	}

	public function index()
	{
		$this->load->view(ADMIN_VIEW.'sub_admin/index');
	}

	public function datatable()
	{

        $this->load->library('datatables');
        $this->datatables->select('id, name, mobile, email, username ,status');
        
        $this->datatables->from('sub_admin');
        $data = json_decode($this->datatables->generate("json"), true); 

        $row = [];
        $temp_row = [];
        foreach ($data['data'] as $key => $value) {
            $temp_row['id'] = $value['id'];
            $temp_row['name'] = $value['name'];
            $temp_row['mobile'] = $value['mobile'];
            $temp_row['email'] = $value['email'];
            $temp_row['username'] = $value['username'];
             
            if( $value['status'] == 0 ) {
                $checked = '';
            } else {
                $checked = 'checked';
            }

            $temp_row['status'] = '<div class="col-md-10 checkbox checkbox-switchery switchery-sm  "><input type="checkbox" class="switchery change_status" '.$checked.' data-href="'.BASE_URL_ADMIN.'sub_admin/change_status/'.$value['id'].'/'.$value['status'].'"></div>';

            $temp_row['id'] = '<label class="label label-warning">' .$temp_row['id'].'</label>';

            $temp_row['action'] = '<a class="p-5" href="'.BASE_URL_ADMIN.'sub_admin/edit/'.$value['id'].'"><i class="icon-pencil3"></i></a>';
            $temp_row['action'] .= '<a class="p-5 delete" href="'.BASE_URL_ADMIN.'sub_admin/delete/'.$value['id'].'"><i class="icon-trash"></i></a>';

            $row[] = $temp_row;
        }   

        echo json_encode([
            'draw' => $data['draw'],
            'recordsTotal' => $data['recordsTotal'],
            'recordsFiltered' => $data['recordsFiltered'],
            'data' => $row
        ]);
    }
 
    public function change_status($id,$status)
    {
        $success = $this->crud->update('sub_admin', ['status' => !$status], ['id' => $id]);

        $new_status = 0;

        if( $success ) {
            if($status == 0) {
                $new_status = 1;
            }

            $response = $this->crud->response('success','Status changed successfully!',1);
        } else {
            $response = $this->crud->response('error','Something went wrong!',0);
        }

        $response['new_url'] = BASE_URL_ADMIN.'sub_admin/change_status/'.$id.'/'.$new_status;
        echo json_encode($response);
    }

	public function add()
	{
        
		$this->load->view(ADMIN_VIEW.'sub_admin/add');
	}

    public function store()
    {
        $post_data = $this->input->post();
        // echo "<pre>"; print_r($post_data); die();
        $this->form_validation->set_rules('name','Name','required|trim'); 
        $this->form_validation->set_rules('password','Password','required|trim'); 
        $this->form_validation->set_rules('mobile','Mobile Number','required|trim|numeric|regex_match[/^[0-9]{10}$/]|is_unique[sub_admin.mobile]');
        $this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[sub_admin.email]');
        $this->form_validation->set_rules('username','username','required|trim|is_unique[sub_admin.username]');
        $this->form_validation->set_rules('status','Status','required'); 
 
        if( !$this->form_validation->run() ) {
            $this->add();
        } else { 

            $modules = [];
            if(isset($post_data['modules'])) {

                $modules = $post_data['modules'];

                unset($post_data['modules']);
            }

            $modules_actions = [];
            if(isset($post_data['modules_actions'])) {

                $modules_actions = $post_data['modules_actions'];

                unset($post_data['modules_actions']);
            }

            $post_data['created_at'] = date('Y-m-d H:i:s');
            $post_data['password'] = md5($post_data['password']);
            $is_success = $this->crud->insert('sub_admin',$post_data);

            if( $is_success ) {

                if(!empty($modules) && is_array($modules)) {

                    $insert_array = [];

                    foreach ($modules as $key => $value) {

                        $sub_admin_modules_id = $this->crud->insert('sub_admin_modules',[
                            'sub_admin_id' => $is_success,
                            'module' => $value,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);

                        if(isset($modules_actions[$value])) {
                            if(!empty($modules_actions[$value]) && is_array($modules_actions[$value])) {

                                foreach( $modules_actions[$value] as $makey => $mavalue ) {
                                    $insert_array[] = [
                                        'sub_admin_id' => $is_success,
                                        'sub_admin_modules_id' => $sub_admin_modules_id,
                                        'name' => $mavalue,
                                        'created_at' => date('Y-m-d H:i:s')
                                    ];
                                }
                            }
                        }

                    }

                    $this->crud->insert_batch('sub_admin_modules_actions',$insert_array);
                }


                $this->session->set_flashdata('response','success');
                $this->session->set_flashdata('msg','Record added successfully');
                redirect($this->base_url);
            } else {
                $this->session->set_flashdata('response','error');
                $this->session->set_flashdata('msg','Something went wrong! Please try again.');
                redirect($this->base_url.'add');
            }
        }
    }

    public function delete($id = null)
    {
        $response = [];
        if( !is_null($id) ) {
            $is_success = $this->crud->delete('sub_admin',['id' => $id]);
            if( $is_success ) {
                $response = $this->crud->response('success','Record deleted successfully.',1);
            } else {
                $response = $this->crud->response('error','Something went wrong. Please try again.',0);
            }
        } else {
            $response = $this->crud->response('error','Direct access to this URL is not allowed.',0);
        }
        echo json_encode($response);
    }

    public function edit($id = null)
    {

        if( !empty($id) ) {

            if(!$this->crud->check_exist('sub_admin',['id' => $id])) {
                $this->session->set_flashdata('response','error');
                $this->session->set_flashdata('msg','Record does not exist.');
                redirect($this->base_url);
            }


            $data['result'] = $this->crud->get_one_row('sub_admin',['id' => $id]);

            $sub_admin_modules = $this->crud->get_with_where('sub_admin_modules', ['sub_admin_id' => $id]);

            $data['sub_admin_modules'] = [];
            $data['sub_admin_modules_actions'] = [];

            if(!empty($sub_admin_modules) && is_array($sub_admin_modules) ) {
                foreach ($sub_admin_modules as $key => $value) {
                    $data['sub_admin_modules'][] = $value->module;
                        
                    $sub_admin_modules_actions = $this->crud->get_with_where('sub_admin_modules_actions',['sub_admin_modules_id' => $value->id]);

                    $data['sub_admin_modules_actions'][ $value->module ] = [];
                    if(!empty($sub_admin_modules_actions) && is_array($sub_admin_modules_actions)) {
                        foreach( $sub_admin_modules_actions as $sama_key => $sama_value ) {
                            $data['sub_admin_modules_actions'][ $value->module ][] = $sama_value->name;
                        }
                    }
                }
            }

            $this->load->view(ADMIN_VIEW.'sub_admin/edit',$data);
        } else {
            $this->session->set_flashdata('response','error');
            $this->session->set_flashdata('msg','Direct access to this URL is not allowed');
            redirect($this->base_url);
        }
    }

    public function update()
    {
        $post_data = $this->input->post();

        $this->form_validation->set_rules('name','Name','required|trim'); 
        $this->form_validation->set_rules('mobile','Mobile Number','required|trim|numeric|regex_match[/^[0-9]{10}$/]|edit_unique[sub_admin.mobile.'.$post_data['id'].']');
        $this->form_validation->set_rules('email','Email','required|trim|valid_email|edit_unique[sub_admin.email.'.$post_data['id'].']');
        $this->form_validation->set_rules('username','username','required|trim|edit_unique[sub_admin.username.'.$post_data['id'].']');
        $this->form_validation->set_rules('status','Status','required');

        if( !$this->form_validation->run() ) {
            $this->edit($post_data['id']);
        } else { 

            $modules = [];
            if(isset($post_data['modules'])) {

                $modules = $post_data['modules'];

                unset($post_data['modules']);
            }

            $modules_actions = [];
            if(isset($post_data['modules_actions'])) {

                $modules_actions = $post_data['modules_actions'];

                unset($post_data['modules_actions']);
            }
            
            if( !empty($post_data['password']) ) {
                $post_data['password'] = md5($post_data['password']);
            } else {
                unset($post_data['password']);
            }

            $is_success = $this->crud->update('sub_admin',$post_data,['id' => $post_data['id']]);

            if( $is_success ) {

                $this->crud->delete('sub_admin_modules', ['sub_admin_id' => $post_data['id'] ]);
                $this->crud->delete('sub_admin_modules_actions', ['sub_admin_id' => $post_data['id'] ]);

                if(!empty($modules) && is_array($modules)) {

                    $insert_array = [];

                    foreach ($modules as $key => $value) {

                        $sub_admin_modules_id = $this->crud->insert('sub_admin_modules',[
                            'sub_admin_id' => $post_data['id'],
                            'module' => $value,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);

                        if(isset($modules_actions[$value])) {
                            if(!empty($modules_actions[$value]) && is_array($modules_actions[$value])) {

                                foreach( $modules_actions[$value] as $makey => $mavalue ) {
                                    $insert_array[] = [
                                        'sub_admin_id' => $post_data['id'],
                                        'sub_admin_modules_id' => $sub_admin_modules_id,
                                        'name' => $mavalue,
                                        'created_at' => date('Y-m-d H:i:s')
                                    ];
                                }
                            }
                        }

                    }

                    if(!empty($insert_array)) {
                        $this->crud->insert_batch('sub_admin_modules_actions',$insert_array);
                    }
                }

                $this->session->set_flashdata('response','success');
                $this->session->set_flashdata('msg','Record update successfully');
                redirect($this->base_url);
            } else {
                $this->session->set_flashdata('response','error');
                $this->session->set_flashdata('msg','Something went wrong! Please try again.');
                redirect($this->base_url.'edit/'.$post_data['id']);
            }
        }
    }

    public function export()
    {
        // Creates New Spreadsheet 
        $spreadsheet = new Spreadsheet();

        // Retrieve the current active worksheet 
        $sheet = $spreadsheet->getActiveSheet(); 
          
        // Set the value of cell A1 
        $sheet->setCellValue('A1', 'ID'); 
        $sheet->setCellValue('B1', 'Name'); 
        $sheet->setCellValue('C1', 'Username'); 
        $sheet->setCellValue('D1', 'Mobile'); 
        $sheet->setCellValue('E1', 'Email'); 
        $sheet->setCellValue('F1', 'Status'); 

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(18);

        $sheet->getStyle("A1:F1")->getFont()->setBold( true );

        $data = $this->crud->get_all('sub_admin');

        $i = 3;

        if(!empty($data) && is_array($data)) {

            foreach ($data as $key => $value) {

                if($value->status) {
                    $status = 'Active';
                } else {
                    $status = 'In-active';
                }

                $sheet->setCellValue('A'.$i, $value->id);
                $sheet->setCellValue('B'.$i, $value->name); 
                $sheet->setCellValue('C'.$i, $value->username); 
                $sheet->setCellValue('D'.$i, $value->mobile); 
                $sheet->setCellValue('E'.$i, $value->email); 
                $sheet->setCellValue('F'.$i, $status); 

                $i++;
            }
        }

        // Write an .xlsx file  
        $writer = new Xlsx($spreadsheet); 

        ob_end_clean();

        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename=sub_admin.xlsx');
        // Save .xlsx file to the current directory 
        $writer->save('php://output');

        exit();
    }

}

?>