<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->base_url = BASE_URL_2XSTATUS.'index';
    }
    
    public function index()
    {

    	$data['total_visitor'] = $this->crud->countrow('user_analytics',['version_code'=>'1.8']);
        $data['new_user'] = $this->crud->countrow('user_new');

        $current_date = date("Y-m-d");

        $data['days'] = [];
        $data['new_user'] = [];
        $data['user_visitor'] = [];

        for ($i=0; $i <= 2; $i++) 
        { 

            ${'Previous'.$i} = date('Y-m-d', strtotime('-'.$i.' day', strtotime($current_date)));

            $data['new_user'][] = $this->crud->countrow('user_new',["login_date"=>${'Previous'.$i}]);

            $data['user_visitor'][] = $this->crud->countrow('user_analytics',["login_date"=>${'Previous'.$i},'version_code'=>'22']);

            $data['days'][] = date('d-M', strtotime('-'.$i.' day', strtotime($current_date)));

        }



        //echo '<pre>'; print_r($data['new_user']); die();

        $this->load->view(STATUS_VIEW.'index',$data);
    }

    public function show_report()
    {
        $post_data = $this->input->post();


        $current_date = date("Y-m-d");
        $days = [];
        $new_user = [];
        $user_visitor = [];

        for ($i=0; $i <= $post_data['days']; $i++) 
        { 

            ${'Previous'.$i} = date('Y-m-d', strtotime('-'.$i.' day', strtotime($current_date)));

            $new_user[] = $this->crud->countrow('user_new',["login_date"=>${'Previous'.$i},'app_type'=>$post_data['app_type'],'version_code'=>$post_data['version_code']]);

            $user_visitor[] = $this->crud->countrow('user_analytics',["login_date"=>${'Previous'.$i},'app_type'=>$post_data['app_type'],'version_code'=>$post_data['version_code']]);

            $days[] = date('d-M', strtotime('-'.$i.' day', strtotime($current_date)));

        }

        echo json_encode([
                    'response' => true,
                    'days'=>$days,
                    'new_user'=>$new_user,
                    'user_visitor'=>$user_visitor
                ]);
    }
}
