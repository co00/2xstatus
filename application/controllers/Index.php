<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->base_url = BASE_URL.'index';

		/*if( !$this->crud->is_login_user() ) {
			redirect(BASE_URL.'home');
		}*/
	}
	
	public function index()
	{	

		redirect(BASE_URL.'admin');
	}

}

?>