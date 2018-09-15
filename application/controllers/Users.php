<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        // Load model
        $this->load->model('user_model'); 
        
    }
	public function get()
    {
        $data = $this->user_model->get_user();
        echo json_encode($data);
    }	
    public function find_get($id)
    {
        //$data = $this->user_model->get_user($id);
        // extend database model
        $data = $this->user_model->get_by('user_id', $id);
		if(empty($data))
        {
            // set status header
            $this->output->set_status_header(400);
        }
        else
        {
            echo json_encode($data);
        }
    }
    public function insert()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $response = $this->user_model->insert_user($data);
        echo json_encode($response);
       
    }
    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $response = $this->user_model->update_user($data);
        echo json_encode($response);
    }
    public function delete($id)
    {
        $response = $this->user_model->delete_user($id);
        echo json_encode($response);
	}
}
