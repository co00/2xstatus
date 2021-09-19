<?php
class Crud extends CI_Model
{
	public function check_exist($table,$where)
	{
		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get($table);

		if( $query->num_rows() > 0 ) {
			return true;
		}
		return false;
	}

    public function response($data, $message, $statuscode)
    {
        $response = [
            'data' => $data,
            'message' => $message,
            'statuscode' => $statuscode
        ];

        return $response;
    }

	public function get_selected_fields($table,$select,$where = null)
	{
		$this->db->select($select);

        if( !is_null($where) ) {
		  $this->db->where($where);
        }
        
		$query = $this->db->get($table);

		if( $query->num_rows() > 0 ) {
			return $query->result();
		}
		return false;
	}

    // Get Select Liit

    public function get_selected_limit($table,$select,$where = null)
    {
        $this->db->select($select);

        if( !is_null($where) ) {
          $this->db->where($where);
        }

        $this->db->limit(6);
        
        $query = $this->db->get($table);

        if( $query->num_rows() > 0 ) {
            return $query->result();
        }
        return false;
    }


    // Count Number of the Result ...

    public function countrow($table,$where = null)
    {
        $this->db->select('*');
        if( !is_null($where) ) {
          $this->db->where($where);
        }
        $query = $this->db->get($table);

        if( $query->num_rows() > 0 ) {
            return $query->num_rows();
        }
        return 0;
    }

    


// Admin Login

    public function admin_authenticate($username,$password)
    {
        if( $this->check_exist('admin',['username' => $username ]) ) {
            $db_row = $this->get_selected_fields('admin','id,password',['username' => $username]);

            if( md5($password) == $db_row[0]->password ) {
                return $db_row[0]->id;
            }
        }
        return false;
    }

    public function sub_admin_authenticate($username,$password)
    {
        if( $this->check_exist('sub_admin',['username' => $username ]) ) {
            $db_row = $this->get_selected_fields('sub_admin','id,password',['username' => $username]);
            if( md5($password) == $db_row[0]->password ) {
                return $db_row[0]->id;
            }
        }
        return false;
    }

 public function authenticate($username,$password)
    {
        if( $this->check_exist('admin',['username' => $username ]) ) {
            $db_password = $this->get_selected_fields('admin','id,password',['username' => $username]);

            if( md5($password) == $db_password[0]->password ) {
                return $db_password[0]->id;
            }
        }
        return false;
    }


    public function is_admin_login()
    {
        if( $this->session->has_userdata('admin_id') && !empty($this->session->userdata('admin_id')) ) {
            return $this->session->userdata('admin_id');
        }
        return false;
    }

    public function is_user_login()
    {
        if( $this->session->has_userdata('admin_id') && !empty($this->session->userdata('admin_id')) ) {
            return $this->session->userdata('admin_id');

        } elseif( $this->session->has_userdata('sub_admin_id') && !empty($this->session->userdata('sub_admin_id')) ) {
            return $this->session->userdata('sub_admin_id');

        } 
        return false;
    }

    public function is_sub_admin_login()
    {
        if( $this->session->has_userdata('sub_admin_id') && !empty($this->session->userdata('sub_admin_id')) ) {
            return $this->session->userdata('sub_admin_id');
        }
        return false;
    }

    public function is_user_authorized($module) {

        if($this->session->has_userdata('sub_admin_id')) {

            $sub_admin_modules = $this->crud->get_one_column('sub_admin_modules','module',['sub_admin_id' => $this->session->userdata('sub_admin_id')]);

            if( is_array($sub_admin_modules) ) {

                if( !in_array($module, $sub_admin_modules)) {
                    return false;
                }
            }
        }

        return true;
    }

    public function sub_admin_has_role($module, $module_action) {

        if($this->session->has_userdata('sub_admin_id')) {

            $sub_admin_modules = json_decode( json_encode( $this->crud->get_with_where('sub_admin_modules',['sub_admin_id' => $this->session->userdata('sub_admin_id')]) ), true);

            if( is_array($sub_admin_modules) ) {

                $sub_admin_modules_key = $this->array_search_multidimensional($sub_admin_modules, 'module', $module);

                if( $sub_admin_modules_key !== false ) {
                    
                    $sub_admin_modules_id = $sub_admin_modules[ $sub_admin_modules_key ]['id'];

                    $check_exist = $this->check_exist('sub_admin_modules_actions', ['sub_admin_modules_id' => $sub_admin_modules_id, 'name' => $module_action]);

                    if(!$check_exist) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    public function array_search_multidimensional($array, $column, $value){
        return (array_search($value, array_column($array, $column)));
    }

// User Login...



    public function authenticate_user($username,$password)
    {
    	if( $this->check_exist('usermaster',['mobile' => $username ]) ) {
    		$db_password = $this->get_selected_fields('usermaster','id,password',['mobile' => $username]);

    		if( base64_encode($password) == $db_password[0]->password ) {
    			return $db_password[0]->id;
    		}
    	}
    	return false;
    }

    public function is_login_user()
    {
    	if( $this->session->has_userdata('user_id') && !empty($this->session->userdata('user_id')) ) {
    		return true;
    	}
    	return false;
    }


    // Merchant.....

    public function authenticate_merchant($username,$password)
    {
        if( $this->check_exist('merchant_user',['mobile' => $username ]) ) {
            $db_password = $this->get_selected_fields('merchant_user','id,password',['mobile' => $username]);

            if( base64_encode($password) == $db_password[0]->password ) {
                return $db_password[0]->id;
            }
        }
        return false;
    }

    public function is_login_merchant()
    {
        if( $this->session->has_userdata('merchant_id') && !empty($this->session->userdata('merchant_id')) ) {
            return true;
        }
        return false;
    }  


    // 

    // Merchant.....

    public function authenticate_ads($username,$password)
    {
        if( $this->check_exist('ads_user',['mobile' => $username ]) ) {
            $db_password = $this->get_selected_fields('ads_user','id,password',['mobile' => $username]);

            if( base64_encode($password) == $db_password[0]->password ) {
                return $db_password[0]->id;
            }
        }
        return false;
    }

    public function is_login_ads()
    {
        if( $this->session->has_userdata('ads_id') && !empty($this->session->userdata('ads_id')) ) {
            return true;
        }
        return false;
    }   


    

    public function insert($table, $data)
    {
    	$this->db->insert($table,$data);
        return $this->db->insert_id();

    }

    public function insert_batch($table, $data) {
        
        $this->db->insert_batch($table, $data);
        return $this->db->insert_id();
    }
    
    public function update_batch($table, $data, $where_column) {
        return $this->db->update_batch($table, $data, $where_column);
    }

    public function delete($table, $where) 
    {
        return $this->db->delete($table,$where);
    }

    public function upload_with_size($filename,$path,$allowed_types,$width,$height,$size)
    {
        $config['upload_path']          = $path;
        $config['allowed_types']        = $allowed_types;
        $config['max_size']             = $size;
        $config['max_width']            = 170000;
        $config['max_height']           = 2300000;
        $config['encrypt_name']           = TRUE;
        $config['overwrite']           = FALSE;
        if( !file_exists($path) ) {
            mkdir($path);
        }
        $this->load->library('upload', $config);
        $response = array();
        if ( !$this->upload->do_upload($filename))
        { 
            $response['response'] = false;
            $response['error'] = $this->upload->display_errors();
        }
        else
        {
            $response['response'] = true;
            $data = $this->upload->data();
            $file_name = $data['file_name'];
            $config['image_library'] = 'gd2';
            $config['source_image'] = $path.$file_name;
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = $width;
            $config['height'] = $height;
            $config['new_image'] = $path.$file_name;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $response['error'] = $file_name;
        }
        //$params = array('gambar' => $file_name);
       // echo '<pre>'; print_r($config); die();
        return $response;
    }

    public function upload($filename,$path,$allowed_types)
    {
        $config['upload_path']          = $path;
        $config['allowed_types']        = $allowed_types;
        // $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
        $config['file_name'] = substr(md5(time()), 0, 28);
        $config['overwrite'] = false;

        if( !file_exists($path) ) {
            mkdir($path);
        }

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $response = array();
        if ( !$this->upload->do_upload($filename))
        {   
            $response['response'] = false;
            $response['error'] = $this->upload->display_errors();
        }
        else
        {
            $response['response'] = true;
            $data = $this->upload->data();
            $response['error'] = !empty($data['file_name']) ? $data['file_name'] : '';
        }
        return $response;
    }

    public function get_one_row($table,$where)
    {
        $this->db->select('*');
        $this->db->where($where);
        $query = $this->db->get($table);
        if( $query->num_rows() > 0 ) {
            return $query->row();
        }
        return false;
    }

    public function get_one_column($table, $column, $where = null)
    {
        $this->db->select($column);

        if( !is_null($where) ) {
            $this->db->where($where);
        }

        $query = $this->db->get($table);
        if( $query->num_rows() > 0 ) {
            $result = $query->result_array();
            $return_val = [];
            foreach ($result as $key => $value) {
                $return_val[] = $value[$column];
            }
            return $return_val;
        }
        return false;
    }

    public function update($table, $data, $where, $increment_col = []) 
    {
        if(!empty($data)) {
            $this->db->set($data);
        } 
        if(!empty($increment_col)) {
            foreach ($increment_col as $key => $value) {
                $this->db->set($key, $value, false);
            }
        }
        $this->db->where($where);
        return $this->db->update($table);

    }

    public function get_with_join($table, $select, $where = null, $join_array = null, $join_type = null,$order_col = null, $order_by = 'DESC')
    {
        $this->db->select($select);

        if( !empty($where) ) {
            $this->db->where($where);
        }

        if( !empty($join_array) ) {
            $i = 0;
            foreach ($join_array as $join_table => $join_condition) {

                if( !is_null($join_type) && is_array($join_type) && (count($join_array) == count($join_type)) ) {
                    $this->db->join($join_table, $join_condition, $join_type[$i]);
                } else {
                    $this->db->join($join_table, $join_condition);
                }
                $i++;
            }
        }


        if(!is_null($order_col)) {
            $this->db->order_by($order_col,$order_by);
        }

        $query = $this->db->get($table);
        if( $query->num_rows() > 0 ) {
            return $query->result();
        }
        return false;
    }

    public function get_all($table) 
    {
        $this->db->select('*');
        $query = $this->db->get($table);
        if( $query->num_rows() > 0 ) {
            return $query->result();
        }
        return false;
    }

    public function get_with_where($table, $where, $select = '*',$order_col = null, $order_by = 'DESC')
    {
        $this->db->select($select);
        $this->db->where($where);

        if(!is_null($order_col)) {
            $this->db->order_by($order_col,$order_by);
        }

        $query = $this->db->get($table);

        if( $query->num_rows() > 0 ) {
            return $query->result();
        }
        return false;
    }

    public function change_balance( $user_id, $amount, $type = '1') 
    {
        if( $type == '1' ) {
            $value = "wallet+$amount";
        } else {
            $value = "wallet-$amount";
        }
        $this->db->set('wallet',$value,false);
        $this->db->where(['id' => $user_id]);
        $response = $this->db->update('usermaster');
        return $response;
    }


    // Order By Asending and Desending...

    public function get_with_where_orderby($table, $where, $order_by, $select = '*')
    {
        $this->db->select($select);
        $this->db->where($where);
       $this->db->order_by($order_by);
        $query = $this->db->get($table);

        if( $query->num_rows() > 0 ) {
            return $query->result();
        }
        return false;
    }

    // Search Result Like ...

    public function get_with_like($table,$like,$select = '*',$where = null)
    {
        $this->db->select($select);
        if(!is_null($where)) {
            $this->db->where($where);
        }
        $this->db->like($like);
        $query = $this->db->get($table);

        if( $query->num_rows() > 0 ) {
            return $query->result();
        }
        return false;
    }

    public function get_with_like_not($table,$like,$likenot,$select = '*',$where = null)
    {
        $this->db->select($select);
        if(!is_null($where)) {
            $this->db->where($where);
        }


        $this->db->like($like);
        $this->db->not_like($likenot);
        $query = $this->db->get($table);

        if( $query->num_rows() > 0 ) {
            return $query->result();
        }
        return false;
    }


    // Limit Buy in .. Like

    public function get_with_like_limit($table,$like,$select = '*',$where = null)
    {
        $this->db->select($select);
        if(!is_null($where)) {
            $this->db->where($where);
        }
        $this->db->limit(6);
        $this->db->like($like);
        $query = $this->db->get($table);

        if( $query->num_rows() > 0 ) {
            return $query->result();
        }
        return false;
    }

    public function get_with_like_not_limit($table,$like,$likenot,$select = '*',$where = null)
    {
        $this->db->select($select);
        if(!is_null($where)) {
            $this->db->where($where);
        }

        $this->db->limit(6);
        $this->db->like($like);
        $this->db->not_like($likenot);
        $query = $this->db->get($table);

        if( $query->num_rows() > 0 ) {
            return $query->result();
        }
        return false;
    }



    public function get_order_by_limit($table, $order_col, $order_by, $limit, $where = null)
    {

        $this->db->select('*');

        if(!is_null($where)) {
            $this->db->where($where);
        }

        $this->db->order_by($order_col, $order_by);
        $this->db->limit($limit);
        $query = $this->db->get($table);

        if($query->num_rows() > 0) {
            return $query->result();
        }
        return false;

    }


    // Send Mail Function...

    public function send_mail($to,$subject,$message,$attachment = null) 
    {
        //Load email library 
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => SMTP_HOST,
            'smtp_port' => SMTP_PORT,
            'smtp_user' => SMTP_FROM,
            'smtp_pass' => SMTP_PASS,
            'charset'    => 'utf-8',
            'newline'    => "\r\n",
            'mailtype' => 'html',
            'validation' => FALSE
        );
        $this->load->library('email',$config); 

        $this->email->set_newline("\r\n");  
        $this->email->from(SMTP_FROM, SMTP_USER); 
        $this->email->to($to);
        $this->email->subject($subject); 
        $this->email->message($message); 

        if( !is_null($attachment) ) {
            foreach ($attachment as $key => $value) {
                $this->email->attach($value);
            }
        }

        //Send mail 
        return $this->email->send(); 
    }


    // New All Ads Show in the ...

    public function get_with_age($table,$where,$dob,$select = '*') 
    {
        

       $query = $this->db->select($select)
              ->from($table)
              ->where($where)
              ->group_start() // Open bracket
              
                ->where(['age' => 0, 'age_max' => 0])
                ->or_group_start()
                    ->where(['age <=' => $dob, 'age_max >=' => $dob])
                ->group_end()
              
              ->group_end()
              ->get(); // Close bracket

        if( $query->num_rows() > 0 ) {
            return $query->result();
        }
        return false;
    }

    




    public function get_where_in($table, $where, $where_in, $select = '*')
    {
        $this->db->select($select);
        $this->db->where($where);

        if(!empty($where_in)) {
            foreach($where_in as $key => $value) {
                $this->db->where_in($key, $value);
            }
        }
        $query = $this->db->get($table);

        if($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function sendMessage($data) 
    {
                $content      = array(
                    "en" => $data['messsage']
                );      

                $headings      = array(
                    "en" => $data['title']
                );

                // if (!empty($data['web_buttons']) && $data['web_buttons'] == 'enable') 
                // {
                //     array_push($hashes_array, array(
                //         "id" => "like-button-2",
                //         "text" => "Like2",
                //         "icon" => "http://i.imgur.com/N8SN8ZS.png",
                //         "url" => "https://yoursite.com"
                //     ));
                //      $web_buttons = true;
                // }else{
                //     $web_buttons = false;
                // }
                
                $fields = array(
                    'app_id' => ONESIGNAL_APP_ID,
                    'included_segments' => array(
                        'All'
                    ),
                    'data' => array(
                        "foo" => "bar"
                    ),
                    'contents' => $content,
                    'headings'=> $headings,
                    'chrome_web_image' => $data['image']
                );
                
                $fields = json_encode($fields);
                print("\nJSON sent:\n");
                print($fields);
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic '.ONESIGNAL_REST_KEY
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                
                $response = curl_exec($ch);
                curl_close($ch);
                
                return $response;
            }
}

?>