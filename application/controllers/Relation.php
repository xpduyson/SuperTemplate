<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// NOTE: this controller inherits from MY_Controller instead of Admin_Controller,
// since no authentication is required
class Relation extends Admin_Controller {

    /**
     * Login page and submission
     */

    public function index()
    {
        $crud = $this->generate_crud('course');
        $crud->set_relation_n_n('users', 'users_groups', 'users', 'user_id', 'group_id', 'username');
        $this->mTitle.= 'CourseStaff';
        $this->render_crud($crud);
    }
}
