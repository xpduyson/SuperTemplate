<?php
/**
 * Created by PhpStorm.
 * User: Phat
 * Date: 3/22/2016
 * Time: 11:43 AM
 */

class Cmr_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();

    }

    public function getCMR(){
        $this->db->select('cmrid,course.coutitle,courses,academic_year')
                 ->from('cmr')
                 ->join('cmr_status','cmr.c_m_r_status = cmr_status.id','left')
                 ->join('course','course.couid = cmr.courses','left');

        $data = $this->db->get()->result_array();
        return $data;
    }

    public function getCourses(){
        $this->db->select('*')
            ->from('course');
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function getYearCmr(){
        $this->db->select('*')
            ->from('academicyear');
        $data = $this->db->get()->result_array();
        return $data;
    }
    
    
    public function getCmrInfo($key){
        $this->db->select('cmrid,courses,course.coutitle,academic_year,c_m_r__c_w')
                 ->from('cmr')
                 ->join('cmr_status','cmr.c_m_r_status = cmr_status.id','left')
                 ->join('course','cmr.courses = course.couid','left')
                 ->join('cmr_coursework','cmr.c_m_r__c_w = cmr_coursework.id','left')
                 ->where('cmrid',$key);
        $info = $this->db->get()->row();
        return $info;
    }
    
    public function getCmrDetails($key){
        $cw = $this->db->get_where('cmr_coursework',array('id' => $key))->row();
        $cw1 = $this->db->get_where('cmr_detail',array('id' => $cw->cw1))->row();
        $cw2 = $this->db->get_where('cmr_detail',array('id' => $cw->cw2))->row();
        $cw3 = $this->db->get_where('cmr_detail',array('id' => $cw->cw3))->row();
        $cw4 = $this->db->get_where('cmr_detail',array('id' => $cw->cw4))->row();
        $cwoverall = $this->db->get_where('cmr_detail',array('id' => $cw->overall))->row();
        $cwexam = $this->db->get_where('cmr_detail',array('id' => $cw->exam))->row();

        $details = array(
            'cw1' => $cw1,
            'cw2' => $cw2,
            'cw3' => $cw3,
            'cw4' => $cw4,
            'cwoverall' => $cwoverall,
            'cwexam' => $cwexam
        );
        return $details;
    }
    
    public function getNeededCommentCMR(){
        $this->db->select('cmr_status.dlt_comment,cmr_status.date_approved,faculties.facname,course.couid,course.coutitle')
                 ->from('cmr')
                 ->join('cmr_status','cmr.c_m_r_status = cmr_status.id','left')
                 ->join('course','course.couid = cmr.courses','left')
                 ->join('faculties','faculties.facid = course.faculty','left')
                 ->where('dlt_comment','');
        $data = $this->db->get()->result_array();
        return $data;
    }


}