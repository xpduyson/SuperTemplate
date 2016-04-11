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
        $user = $this->ion_auth->user()->row();
        $user_id = $user->id;
        $this->db->select('*')
            ->from('course')
            ->join('coursestaff','course.couid = coursestaff.courses')
            ->where('coursestaff.users',$user_id);
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function getCoursesByID($key){
        $this->db->select('*')
                ->from('course')
                ->where('couid',$key);
        $data = $this->db->get()->row();
        return $data;
    }

    public function getYearCmr(){
        $this->db->select('*')
            ->from('academicyear');
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function getCmrInfo($key){
        $this->db->select('cmrid,courses,course.coutitle,academic_year,c_m_r_status,mark_planning')
                 ->from('cmr')
                 ->join('cmr_status','cmr.c_m_r_status = cmr_status.id','left')
                 ->join('course','cmr.courses = course.couid','left')
                 ->where('cmrid',$key);
        $info = $this->db->get()->row();
        return $info;
    }
    
    public function getCmrStatus($key){
        $this->db->select('*')
            ->from('cmr_status')
            ->where('id',$key);
        $info = $this->db->get()->row();
        return $info;
    }

    public function getNeededCommentCMR($key){
        $this->db->select('cmrid,cmr_status.dlt_comment,cmr_status.date_approved,faculties.facname,
                           course.couid,course.coutitle,users.id,users_groups.group_id')
                 ->from('cmr')
                 ->join('cmr_status','cmr.c_m_r_status = cmr_status.id','left')
                 ->join('course','course.couid = cmr.courses','left')
                 ->join('faculties','faculties.facid = course.faculty','left')
                 ->join('users','users.faculty = faculties.facid','left')
                 ->join('users_groups','users.id = users_groups.user_id','left')
                 ->where('dlt_comment',null)
                 ->where('users.faculty',$key)
                 ->where('users_groups.group_id',3)
                 ->where('cmr_status.cm_checked',1);
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function getName($key){
        $this->db->select('users.first_name')
            ->from('coursestaff')
            ->join('users','users.id = coursestaff.users')
            ->join('course','course.couid = coursestaff.courses')
            ->join('cmr','cmr.courses = course.couid ')
            ->where('cmr.cmrid',$key);
        return $this->db->get()->row();

    }

    public function filterYear($cou,$year){
    $this->db->select('courses,academic_year')
             ->from('cmr')
             ->where('courses',$cou)
             ->where('academic_year',$year);
      $num = $this->db->get()->num_rows();
      if($num > 0 )
          return false;
      else
          return true;
  }
    
    public function getCourseInfo($cou){

        $this->db->select('*')
            ->from('course')
            ->join('faculties','faculties.facid = course.faculty')
            ->join('af','af.faculty = faculties.facid')
            ->where('couid',$cou);
        $data = $this->db->get()->row();
        $CM = $this->getCM($data->couid);
        $PVC = $this->getPVC($data->faculty);
        $DLT = $this->getDLT($data->faculty);
        $faculty = $this->getFalName($data->faculty);
        $status = $this->getCourseStatus($cou);
        if($status == 0)
            $stat = 'Inactive';
        else
            $stat = 'Active';
        $result = array(
            'faculty' => $faculty,
            'CM' => $CM,
            'PVC' => $PVC,
            'DLT' => $DLT,
            'courseTime' => $data->coutime,
            'courseLevel' => $data->coulevel,
            'courseCredit' => $data->coucredit,
            'courseStatus' => $stat,
            'courseYear' => $data->academicyear
        );
        return $result;
  }

    public function getCourseStatus($key){
        $this->db->select('*')
            ->from('course')
            ->where('couid',$key);
        $data = $this->db->get()->row();
        return $data->status;
    }

    public function getFalName($key){
        $this->db->select('*')
            ->from('faculties')
            ->where('facid',$key);
        $data = $this->db->get()->row();
        return $data->facname;
    }

    public function getPVC($key){
        $this->db->select('*')
            ->from('users')
            ->join('users_groups','users_groups.user_id = users.id','left')
            ->where('faculty',$key)
            ->where('users_groups.group_id',2);
        $data = $this->db->get();
        if($data->num_rows() == 0)
            return "Not Assigned";
        else
            return $data->row()->first_name;
    }

    public function getDLT($key){
        $this->db->select('*')
            ->from('users')
            ->join('users_groups','users_groups.user_id = users.id','left')
            ->where('faculty',$key)
            ->where('users_groups.group_id',3);
        $data = $this->db->get();
        if($data->num_rows() == 0)
            return "Not Assigned";
        else
            return $data->row()->first_name;
    }

    public function getCM($key){
        $this->db->select('*')
            ->from('users')
            ->join('users_groups','users_groups.user_id = users.id','left')
            ->join('coursestaff','coursestaff.users = users.id','left')
            ->where('coursestaff.courses',$key)
            ->where('users_groups.group_id',5);
        $data = $this->db->get();
        if($data->num_rows() == 0)
            return "Not Assigned";
        else
            return $data->row()->first_name;
    }
    
    public function getCMForInsert($key){
        $this->db->select('users.id')
            ->from('users')
            ->join('coursestaff','users.id = coursestaff.users')
            ->join('users_groups','users_groups.user_id = users.id')
            ->join('course','course.couid = coursestaff.courses')
            ->where('course.couid',$key)
            ->where('users_groups.group_id',5);
        $data = $this->db->get();
        if($data->num_rows() > 0)
            return $data->row();
        else
            return null;
    }

    public function getPVCList(){
        $this->db->select('*')
            ->from('users')
            ->join('users_groups','users_groups.user_id = users.id','left')
            ->join('faculties','users.faculty = faculties.facid','left')
            ->join('af','faculties.facid = af.faculty','left')
            ->where('users_groups.group_id',2);
        $data = $this->db->get();
        if($data->num_rows() == 0)
            return 0;
        else
            return $data->result_array();
    }

    public function getDLTList(){
        $this->db->select('*')
            ->from('users')
            ->join('users_groups','users_groups.user_id = users.id','left')
            ->join('faculties','users.faculty = faculties.facid','left')
            ->join('af','faculties.facid = af.faculty','left')
            ->where('users_groups.group_id',3);
        $data = $this->db->get();
        if($data->num_rows() == 0)
            return 0;
        else
            return $data->result_array();
    }
    
    public function getCMList(){
        $this->db->select('*')
            ->from('users')
            ->join('users_groups','users_groups.user_id = users.id','left')
            ->join('faculties','users.faculty = faculties.facid','left')
            ->join('af','faculties.facid = af.faculty','left')
            ->join('course','course.faculty = faculties.facid','left')
            ->where('users_groups.group_id',5);
        $data = $this->db->get();
        if($data->num_rows() == 0)
            return 0;
        else
            return $data->result_array();
    }
    
    public function getCLList(){
        $this->db->select('*')
            ->from('users')
            ->join('users_groups','users_groups.user_id = users.id','left')
            ->join('faculties','users.faculty = faculties.facid','left')
            ->join('af','faculties.facid = af.faculty','left')
            ->join('course','course.faculty = faculties.facid','left')
            ->where('users_groups.group_id',4);
        $data = $this->db->get();
        if($data->num_rows() == 0)
            return 0;
        else
            return $data->result_array();
    }
    
    public function getCourseSize(){
        $this->db->select('*')
                 ->from('course');
        $data = $this->db->get()->result_array();
        return count($data);
    }
    
    public function getFacultySize(){
        $this->db->select('*')
            ->from('faculties');
        $data = $this->db->get()->result_array();
        return count($data);
    }
    
    public function getCMRSize(){
        $this->db->select('*')
            ->from('cmr');
        $data = $this->db->get()->result_array();
        return count($data);
    }
    
    public function getCourseWithoutCMR($key)
    {
        $sql = "select *
        from course
        LEFT JOIN af on course.faculty = af.faculty
        LEFT JOIN faculties on faculties.facid = af.faculty
        where af.academicyear = ? AND not exists(select * from cmr where cmr.courses = course.couid)";
        $data = $this->db->query($sql,array($key))->result_array();
        return $data;
    }

    public function getCMRWithoutComment($key)
    {
        $sql = "select *
                from cmr
                LEFT JOIN course on course.couid = cmr.courses
                LEFT JOIN cmr_status on cmr.c_m_r_status = cmr_status.id
                LEFT JOIN af on course.faculty = af.faculty
                where af.academicyear = ? AND cmr_status.dlt_comment is null";
        $data = $this->db->query($sql,array($key))->result_array();
        return $data;
    }

    public function getCMRWithoutApproved($key)
    {
        $sql = "select *
                from cmr
                LEFT JOIN course on course.couid = cmr.courses
                LEFT JOIN cmr_status on cmr.c_m_r_status = cmr_status.id
                LEFT JOIN af on course.faculty = af.faculty
                where af.academicyear = ? AND cmr_status.cm_checked = 0";
        $data = $this->db->query($sql,array($key))->result_array();
        return $data;
    }
}