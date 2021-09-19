<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->base_url = BASE_URL_ADMIN.'dashboard';

        if( !$this->crud->is_user_login() ) {
            redirect(BASE_URL_ADMIN.'login');
        }
    }
    
    public function index()
    {
        $data['total_visitor'] = $this->crud->countrow('user_analytics',['version_code'=>'1.8']);
        $data['new_user'] = $this->crud->countrow('user_new');

        $current_date = date("Y-m-d");

        for ($i=0; $i <= 10; $i++) 
        { 
            ${'Previous'.$i} = date('Y-m-d', strtotime('-'.$i.' day', strtotime($current_date)));

            $data['previous'.$i.'_visitor'] = $this->crud->countrow('user_analytics',["login_date"=>${'Previous'.$i},'version_code'=>'1.8']);

            $data['previous'.$i.'_new_user'] = $this->crud->countrow('user_new',["login_date"=>${'Previous'.$i}]);

        }

        $this->load->view(ADMIN_VIEW.'dashboard',$data);
    }

    public function change_status($id,$status)
    {
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

        $response['new_url'] = BASE_URL_ADMIN.'dashboard/change_status/'.$id.'/'.$new_status;
        echo json_encode($response);
    }

    public function change_value()
    {
        $post_data = $this->input->post();

        $success = $this->crud->update('setting', $post_data, ['id' => $post_data['id']]);

        if( $success ) {
            $response = $this->crud->response('success','Value update successfully!',1);
        } else {
            $response = $this->crud->response('error','Something went wrong!',0);
        }

        echo json_encode($response);
    }

}
