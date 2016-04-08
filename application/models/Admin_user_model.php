<?php

class Admin_user_model extends MY_Model
{
    public function getFacId()
    {
        $this->db->select('*')
            ->from('faculties');
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function getFacNamebyId($key){
        $this->db->select('*')
            ->from('faculties')
            ->where('facid', $key);
        $data = $this->db->get()->row();
        return $data;
    }
}