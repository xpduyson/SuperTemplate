<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->mTitle = 'Faculty - ';
        $this->push_breadcrumb('Faculty');
    }

    public function index()
    {
        $crud = $this->generate_crud('faculties');
       // $crud->columns('author_id', 'category_id', 'title', 'image_url', 'tags', 'publish_time', 'status');
       // $crud->set_field_upload('image_url', UPLOAD_DEMO_BLOG_POST);
       // $crud->set_relation('category_id', 'demo_blog_categories', 'title');
       // $crud->set_relation_n_n('tags', 'demo_blog_posts_tags', 'demo_blog_tags', 'post_id', 'tag_id', 'title');

       $crud->set_rules('facid','Faculties','required');
        $crud->set_rules('facname','Faculties-Name','required');
        $crud->set_rules('facdetails','Faculties-Details','required');
        $crud->set_rules('startdate','Faculties-Startdate','required');
        $crud->set_rules('enddate','Faculties-EndDate','required');

        $this->mTitle.= 'Faculties';
        $this->render_crud();
    }
}