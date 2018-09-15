<?php
class User_model extends MY_Model
{
    public $_table='user';
    
    public function __construct()
    {
        $this->load->database();
    }
    
    public function get_user($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->get('user');
            return $query->result();
        }
        $query = $this->db->get_where('user', array('user_id' => $id));
        return $query->result();
    }

    public function insert_user($data)
    {
        // search name 
        $query = $this->db->get_where('user', array('name' => $data['name']));
        if ($query->num_rows() == 0) 
        {
            $this->db->insert('user', $data);
            //$insert_id = $this->db->insert_id();
            //return $insert_id;
            //return 
            if ($this->db->affected_rows() > 0) 
            {
                return true;
            }
            else
            {
                return false;
            }   
        } 
        else
        {
            return false;
        }
    }
    
    public function update_user($data)
    {
        $this->db->where('user_id', $data['user_id']);
        $this->db->update('user', $data);

        //return 
        if ($this->db->affected_rows() > 0) 
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function delete_user($id)
    {
        $this->db->delete('user', array('user_id' => $id));

        //return 
        if ($this->db->affected_rows() > 0) 
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
