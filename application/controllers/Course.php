<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->mTitle = 'Course - ';
        $this->push_breadcrumb('Course');
    }

    public function index()
    {
        $crud = $this->generate_crud('course');

        $crud->set_rules('couid','Course-ID','required');
        $crud->set_rules('faculty','Faculties-Name','required');
        $crud->set_rules('coutitle','Course-Details','required');
        $crud->set_rules('coutime', 'coutime','required');

        $crud->callback_edit_field('coutime',array($this,'edit_field_callback_1'));
        $crud->callback_edit_field('users',array($this,'edit_field_callback_3'));
        $crud->callback_add_field('status',array($this,'edit_field_callback_2'));
        $crud->callback_column('coutime',array($this,'valueToEuro'));
        $crud->callback_column('users',array($this,'valueUser'));
        $crud->fields('couid','faculty','coutitle','status');
        $crud->edit_fields('couid','faculty','coutitle','coutime','CourseStaff','status');
        $crud->set_relation('faculty','faculties','facdetails','status=1');
        $crud->set_relation_n_n('CourseStaff','coursestaff','users','courses','users','username');
       // $crud->set_relation_n_n('users', 'users_groups', 'users', 'user_id', 'group_id', 'username');

        $crud->display_as('couid','Course ID');
        $crud->display_as('faculty','Faculty');
        $crud->display_as('coutitle','Course Title');
        $crud->display_as('coutime','Course Time(Month)');
       $crud->callback_before_update(array($this,'beforeUpdate'));
       $crud->callback_before_insert(array($this,'beforeInsert'));

        $this->mTitle.= 'Course';
        $this->render_crud($crud);
    }

    function valueToEuro($value, $row)
    {
        return $value.' Month';
    }
    function valueUser($value, $row)
    {   $asd=$row->couid;
        $c=$asd+'';
       // $iduser = $this->db->where("courses",$row->couid)->get('coursestaff')->row()->users;
       // $nameuser = $this->db->where('id',$iduser)->get('users')->row()->username;



        return $c.'-'.$row->couid;
    }
    function encrypt_password_callback($post_array) {

    //$post_array['status'] = $this->encrypt->encode($post_array['password'], $key);

    return $post_array;
}
    function beforeInsert($post_array)
    {
        echo 'before update';
        $post_array['status'] = '0';
        //echo $post_array['status'];

        return $post_array;
    }
    function beforeUpdate($post_array)
    {   $id = $this->uri->segment(4);

      //  $idUser = $this->db->where("username",$post_array['asd'])->get('users')->row()->id;
       // $data = array('courses' => $id, 'users' => $post_array['asd']);

      //  $this->db->insert('coursestaff', $data);

        if($post_array['status']=='1'){
            $time=0;

            $faculty = $this->db->where("couid",$id)->get('course')->row()->faculty;
            $coutime = $this->db->where("couid",$id)->get('course')->row()->coutime;
            $result = $this->db->where("faculty",$faculty)->get('course');
            if($result->num_rows() > 0)
            {
                foreach($result->result() as $row)
                {
                    if($row->status==1){
                        $time += $row->coutime;
                    }
                }
                $time-=$coutime;
            }
            if($post_array['coutime']+$time>12){
                $this->load->library('form_validation');
                $this->form_validation->set_message('beforeUpdate', 'asdasd');

                return FALSE;
            }
            return true;
        }

        return true;
    }
    public function get_form_validation(){
        if($this->form_validation === null)
        {
            $this->form_validation = new grocery_CRUD_Form_validation();
            $ci = &get_instance();
            $ci->load->library('form_validation');
            $ci->form_validation = $this->form_validation;
        }
        return $this->form_validation;
    }
    function edit_field_callback_1($value)
    {
        $time=0;
        $id = $this->uri->segment(4);
        $faculty = $this->db->where("couid",$id)->get('course')->row()->faculty;
        $status = $this->db->where("couid",$id)->get('course')->row()->status;
        $result = $this->db->where("faculty",$faculty)->get('course');
        if($result->num_rows() > 0)
        {
            foreach($result->result() as $row)
            {
                if($row->status==1){
                    $time += $row->coutime;
                }
            }

            if($status==1){
                $a=$time-$value;
                $max=12-$a;
            }else{
                $a=$time;
                $max=12-$a;
            }


        }


        return ' <input type="number" value="'.$max.'" name="coutime" style="width:500px">( total month Faculty not >12Moth-Use:'.$a.')';
    }
    function edit_field_callback_2($value)
{



    return 'inactive';
}
    function edit_field_callback_3($value)
    {
       // $id = $this->uri->segment(4);
       // $users = $this->db->get('users');
       // $row=$users->row();
      //  $options = array();
       // foreach($users->result() as $row)
       // {
           // $row=$users->row()->username;
       //     $options[$row->id] = $row->username;
       // }

      //  $status = $this->db->where("couid",$id)->get('course')->row()->status;
       // $result = $this->db->where("faculty",$faculty)->get('course');
      //  $this->load->helper('form');
        // $options = array();
       // return  form_dropdown('asd', $options, $value,'asd');
    }


}