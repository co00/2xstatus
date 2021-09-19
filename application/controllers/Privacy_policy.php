<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacy_policy extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->base_url = BASE_URL.'Privacy_policy/';

    }

    public function index()
    {
        $this->load->view('privacy_policy');
    }
}

?>