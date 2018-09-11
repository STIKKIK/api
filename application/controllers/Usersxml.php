<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usersxml extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        // Load helper
        $this->load->helper('xml');
        // Load model
        $this->load->model('user_model'); 
        
    }
	public function get()
    {
        // tutorial
        /*
        $dom = xml_dom();
        $book = xml_add_child($dom, 'book');
        
        xml_add_child($book, 'title', 'Hyperion');
        $author = xml_add_child($book, 'author', 'Dan Simmons');		
        xml_add_attribute($author, 'birthdate', '1948-04-04');

        $profile = xml_add_child($dom, 'profile');
        $name = xml_add_child($profile, 'name');
        xml_add_child($name, 'firstname', 'Thanawat');
        xml_add_child($name, 'lastname', 'Thumbal');
        $author = xml_add_child($profile, 'author', 'Dan Simmons');		
        xml_add_attribute($author, 'birthdate', '1948-04-04');

        xml_print($dom); 
        */

        // get data
        $datausers = $this->user_model->get_user();

        $dom = xml_dom();
        $users = xml_add_child($dom, 'users');
        foreach($datausers as $data)
        {
            $userid = xml_add_child($users, 'userid');
            xml_add_attribute($userid, 'id', $data->user_id);
            xml_add_child($userid, 'name', $data->name);
            xml_add_child($userid, 'age', $data->age);
            xml_add_child($userid, 'create_datetime', $data->create_datetime);
            xml_add_child($userid, 'is_active', $data->is_active);
        }
        
        xml_print($dom);

    }	
    public function find_get($id)
    {
        $datauser = $this->user_model->get_user($id);
		if(empty($datauser))
        {
            // set status header
            $this->output->set_status_header(204);
        }
        else
        {
            $dom = xml_dom();
            $users = xml_add_child($dom, 'users');
            foreach($datauser as $data)
            {
                $userid = xml_add_child($users, 'userid');
                xml_add_attribute($userid, 'id', $data->user_id);
                xml_add_child($userid, 'name', $data->name);
                xml_add_child($userid, 'age', $data->age);
                xml_add_child($userid, 'create_datetime', $data->create_datetime);
                xml_add_child($userid, 'is_active', $data->is_active);
            }
            
            xml_print($dom);
        }
    }
    public function insert()
    {
        $data_user_xml = file_get_contents('php://input');
        $object_data_user = simplexml_load_string($data_user_xml) or die("Error: Cannot create object");
        // read data in attributes
        //var_dump($xml->userid->attributes()->id); exit;
    
        $data_user = array(
            'name' => $object_data_user->userid->name,
            'age' => $object_data_user->userid->age,
            'create_datetime' => date('Y-m-d H:i:s'),
            'is_active' => 1
        );

        $response = $this->user_model->insert_user($data_user);

        // chack response
        if($response)
        {
            $status_code = 200;
            $status_text = "success";
        }
        else
        {
            $status_code = "xxx";
            $status_text = "duplicate";
        }
        // return status
        $dom = xml_dom();
        $status = xml_add_child($dom, 'status');
        xml_add_child($status, 'status_code', $status_code);
        xml_add_child($status, 'status_text', $status_text);
        
        xml_print($dom);
       
    }
    public function update()
    {
        
        $data_user_xml = file_get_contents('php://input');
        $object_data_user = simplexml_load_string($data_user_xml) or die("Error: Cannot create object");
    
        $data_user = array(
            'user_id' => $object_data_user->userid->attributes()->id,
            'name' => $object_data_user->userid->name,
            'age' => $object_data_user->userid->age,
            'create_datetime' => $object_data_user->userid->create_datetime,
            'is_active' => $object_data_user->userid->is_active
        );

        $response = $this->user_model->update_user($data_user);

        // chack response
        if($response)
        {
            $status_code = 200;
            $status_text = "update success";
        }
        else
        {
            $status_code = "xxx";
            $status_text = "not update";
        }
        // return status
        $dom = xml_dom();
        $status = xml_add_child($dom, 'status');
        xml_add_child($status, 'status_code', $status_code);
        xml_add_child($status, 'status_text', $status_text);
        
        xml_print($dom);
    }
    public function delete($id)
    {
        $response = $this->user_model->delete_user($id);
        // chack response
        if($response)
        {
            $status_code = 200;
            $status_text = "delete success";
        }
        else
        {
            $status_code = "xxx";
            $status_text = "not delete";
        }
        // return status
        $dom = xml_dom();
        $status = xml_add_child($dom, 'status');
        xml_add_child($status, 'status_code', $status_code);
        xml_add_child($status, 'status_text', $status_text);
        
        xml_print($dom);
	}
}
