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
	
	public function index($id)
	{	

		$data['offer'] = $this->crud->get_one_row('offer',['md5'=>$id,'status'=>1]);

		if (!empty($data['offer'])) 
		{
			$data['offer_step'] = $this->crud->get_with_where('offer_step',['offer_id'=>$id]);
			$this->load->view(OFFER_VIEW.'index',$data);
		}else{
			redirect(BASE_URL);
		}

		
	}

}

?>