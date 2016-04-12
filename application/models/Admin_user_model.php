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
    public function getRole($key){
        $this->db->select('*')
            ->from('users')
            ->join('users_groups','users.id=users_groups.user_id','left')
            ->join('groups','users_groups.group_id = groups.id')
            ->where('users.id', $key);
        $data = $this->db->get()->row();
        return $data;
    }
}
//TODO - Thong tin ve CL( soan bao nhieu, bao nhieu da submit, ....)