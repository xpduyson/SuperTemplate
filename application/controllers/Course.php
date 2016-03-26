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

     //   $crud->set_rules('couid','Course-ID','required');
     //   $crud->set_rules('faculty','Faculties-Name','required');
     //   $crud->set_rules('coutitle','Course-Details','required');
     //   $crud->set_rules('coutime','Time','required');
     //   $crud->set_rules('status','Status','required');
        $crud->callback_before_insert(array($this,'setstatus'));
        if($crud->getState()=='edit'){
            $pk = $crud->getStateInfo()->primary_key;

        }
        $crud->callback_edit_field('coutime',array($this,'edit_field_callback_1'));

        $crud->callback_column('coutime',array($this,'valueToEuro'));
        $crud->callback_before_insert(array($this,'setstatus'));
        $crud->fields('couid','faculty','coutitle','coutime');
        $crud->edit_fields('couid','faculty','coutitle','coutime','status');
        $crud->set_relation('faculty','faculties','facdetails');
        $crud->display_as('coutime','Time(Month)');
       // $crud->set_rules('faculty','faculties','edit_field_callback_1');
       // $crud->set_rules('coutime','Time','max=12');
        $this->mTitle.= 'Course';
        $this->render_crud($crud);
    }
    public function gettime(){


    }
    function valueToEuro($value, $row)
    {
        return $value.' Month';
    }
    function setstatus($post_array)
    {
        if(empty($post_array['status']))
        {
            $post_array['status'] = '1';
        }
        return $post_array;
    }
    function edit_field_callback_1($value)
    {
        $time=0;
        $id = $this->uri->segment(4);
        $faculty = $this->db->where("couid",$id)->get('course')->row()->faculty;
        $result = $this->db->where("faculty",$faculty)->get('course');
        if($result->num_rows() > 0)
        {
            foreach($result->result() as $row)
            {
                if($row->status==1){
                    $time += $row->coutime;
                }
                //$time += $row->coutime;

            }
            echo $time;
            //$time-=$value;
            $a=$time-$value;
            $max=12-$a;
        }


        return ' <input type="number" max="'.$max.'"  value="'.$max.'" name="coutime" style="width:500px">( total month Faculty not >12Moth-Use:'.$a.')';
    }

}