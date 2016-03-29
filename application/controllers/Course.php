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
       // $crudfac = $this->generate_crud('faculties');
        // $crud->columns('author_id', 'category_id', 'title', 'image_url', 'tags', 'publish_time', 'status');
        // $crud->set_field_upload('image_url', UPLOAD_DEMO_BLOG_POST);
        // $crud->set_relation('category_id', 'demo_blog_categories', 'title');
        // $crud->set_relation_n_n('tags', 'demo_blog_posts_tags', 'demo_blog_tags', 'post_id', 'tag_id', 'title');

        $crud->set_rules('couid','Course-ID','required');
        $crud->set_rules('faculty','Faculties-Name','required');
        $crud->set_rules('coutitle','Course-Details','required');
        $crud->set_rules('coutime', 'coutime','required');
        //$crud->set_rules('status','Status','required');
        //set status when insert active


        $crud->callback_edit_field('coutime',array($this,'edit_field_callback_1'));
        $crud->callback_add_field('status',array($this,'edit_field_callback_2'));
        $crud->callback_column('coutime',array($this,'valueToEuro'));


        $crud->fields('couid','faculty','coutitle','status');
        $crud->edit_fields('couid','faculty','coutitle','coutime','status');
        $crud->set_relation('faculty','faculties','facdetails','status=1');

        $crud->display_as('coutime','Time(Month)');
      //  $crud->callback_before_insert(array($this,'encrypt_password_callback'));
        $crud->callback_before_update(array($this,'beforeUpdate'));

        $crud->callback_before_insert(array($this,'beforeInsert'));
       //    $crud->callback_after_insert(array($this, 'after_insert'));
        $this->mTitle.= 'Course';
        $this->render_crud($crud);
    }

    function valueToEuro($value, $row)
    {
        return $value.' Month';
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
    {
        if($post_array['status']=='1'){
            $time=0;
            $id = $this->uri->segment(4);
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

        }
        return TRUE;
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

}