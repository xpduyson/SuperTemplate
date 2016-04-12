<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->mTitle = 'Course - ';
        $this->push_breadcrumb('Course');
    }

    public function index()
    {
        $iduser=$this->db->where('username',$this->session->userdata("namelog2"))->get('users')->row()->id;
        $userRoll=$this->db->where('user_id',$iduser)->get('users_groups')->row()->group_id;

        $fac=$this->db->where('username',$this->session->userdata("namelog2"))->get('users')->row()->faculty;

        if($fac==''){
            $crud = $this->generate_crud('course');
            $this->mTitle.= 'All Course';
        }else{
            $crud = $this->generate_crud('course')->where('faculty',$fac);
            $facuname=$this->db->where('facid',$fac)->get('faculties')->row()->facname;
            $facudetail=$this->db->where('facid',$fac)->get('faculties')->row()->facdetails;
            $this->mTitle.= $facuname.'|'.$facudetail;

        }


        $crud->set_rules('couid','Course-ID','required');
        $crud->set_rules('faculty','Faculties-Name','required');
        $crud->set_rules('coutitle','Course-Details','required');
        $crud->set_rules('coutime', 'coutime','required');


        $crud->callback_add_field('status',array($this,'edit_field_callback_status'));
        $crud->callback_column('coutime',array($this,'valueMonth'));
        $crud->callback_column('users',array($this,'valueUser'));
        $crud->callback_column('CourseStaff',array($this,'valuestaff'));
        $crud->columns('couid','coutitle','coutime','coulevel','coucredit','CourseStaff','status');
        $crud->fields('couid','faculty','coutitle','status');
        $crud->edit_fields('couid','faculty','coutitle','coutime','coulevel','coucredit','CourseStaff','status');
        //set ralation faculty
       // $crud->set_relation('faculty','faculties','facdetails','status=1');
        //check and get staff
        $users_groups = $this->db->where("group_id",4)->get('users_groups')->row()->user_id;
        $crud->set_relation_n_n('CourseStaff','coursestaff','users','courses','users','username',null,'id='.$users_groups);

        //set table and display
        $crud->display_as('couid','Course ID');
        $crud->display_as('faculty','Faculty');
        $crud->display_as('coutitle','Course Title');
        $crud->display_as('coutime','Course Time(Month)');
        $crud->set_theme('datatables');
        //check before update
       $crud->callback_before_update(array($this,'beforeUpdate'));
       $crud->callback_before_insert(array($this,'beforeInsert'));
        //add setcourse and button active
        if($userRoll==2){
            $crud->add_action('Edit', '', 'course/edit','ui-icon-pencil');
            $crud->add_action('In/Active', '', 'course/active','ui-icon-power');
        }

        //not set edit and delete
        $crud->unset_delete();
        $crud->unset_edit();
        $crud->unset_add();

        $this->render_crud($crud);
    }
    function edit($value)
    {

        $this->mTitle.= 'Edit Course';
        $this->render('course/edit');
    }
    function AddPage()
    {

        $this->mTitle.= 'Add Course';
        $this->render('course/new');
    }
    function Error()
    {

        $this->mTitle.= 'Error';
        $this->render('course/Error');
    }
    function active($value)
    {   //get status from id
        $active = $this->db->where('couid',$value)->get('course')->row()->status;
        //update status
        if($active==1){
            $data = array('status' => 0);
            $this->db->where('couid',$value);
            $this->db->update('course', $data);
            redirect('course');
        }else{
            $data = array('status' => 1);
            $this->db->where('couid',$value);
            $this->db->update('course', $data);
            redirect('course');
        }

    }
    function valueMonth($value, $row)
    {
        return $value.' Month';
    }
    function valuestaff($value, $row)
    {
        return $value;
    }

    function edit_field_callback_status($value)
{
    return 'inactive';
}

    function editCourse()
    {
        //get data from page edit
        $id=$_POST['txtid'];
        $title=$_POST['txtinputtitle'];
        $time=$_POST['txttime'];
        $level=$_POST['level'];
        $credit=$_POST['txtcredit'];
        $cl=$_POST['cl'];
        $cm=$_POST['cm'];
        //set data update course
          $data = array('coutitle' => $title,
              'coutime' => $time,
              'coulevel' => $level,
              'coucredit' => $credit
          );
        $this->db->where('couid',$id);
         $this->db->update('course', $data);
        //find data cl,cm in coursestaff and edit
        $idcoursestaff = $this->db->where("courses",$id)->get('coursestaff')->num_rows();
        $idcl = $this->db->where("username",$cl)->get('users')->row()->id;
        $idcm = $this->db->where("username",$cm)->get('users')->row()->id;
        if($idcoursestaff>0){
            $datacl = array('users' => $idcl,'courses' => $id);
            $datacm = array('users' => $idcm,'courses' => $id);
            $this->db->delete('coursestaff', array('courses' => $id));
            $this->db->insert('coursestaff', $datacl);
            $this->db->insert('coursestaff', $datacm);
        }else{
            $datacl = array('users' => $idcl,'courses' => $id);
            $datacm = array('users' => $idcm,'courses' => $id);
            $this->db->insert('coursestaff', $datacl);
            $this->db->insert('coursestaff', $datacm);
        }
        redirect('course');
    }

    /**
     *
     */
    function addCourse()
    {
        $fac=$this->db->where('username',$this->session->userdata("namelog2"))->get('users')->row()->faculty;
        if($fac==''){
            $this->mTitle.= 'Error';
            $this->render('course/Error');
        }
       else{
           //get data from page edit
           $id=$_POST['txtid'];
           $fac=$fac;
           $title=$_POST['txtinputtitle'];
           $time=$_POST['txttime'];
           $level=$_POST['level'];
           $credit=$_POST['txtcredit'];
           $cl=$_POST['cl'];
           $cm=$_POST['cm'];
           $status=$_POST['rdactive'];
           //set data update course
           $countID=$this->db->where("couid",$id)->get('course')->num_rows();
           if($countID==1){
               $this->mTitle.= 'Error';
               $this->render('course/Error');
           }else{
               $data = array(
                   'couid' => $id,
                   'faculty' => $fac,
                   'coutitle' => $title,
                   'coutime' => $time,
                   'coulevel' => $level,
                   'coucredit' => $credit,
                   'status' => $status
               );

               $this->db->insert('course', $data);
               $datacl = array(
                   'users' => $cl,
                   'courses' => $id
               );
               $this->db->insert('coursestaff',$datacl);
               $datacm = array(
                   'users' => $cm,
                   'courses' => $id
               );
               $this->db->insert('coursestaff',$datacm);
               redirect('course');

           }

       }



    }

}