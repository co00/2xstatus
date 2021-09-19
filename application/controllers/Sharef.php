<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sharef extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->base_url = BASE_URL.'sharef/';

    }

    public function index()
    {
        $this->load->view('sharef');
    }
}

?>