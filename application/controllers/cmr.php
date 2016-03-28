<?php
/**
 * Created by PhpStorm.
 * User: Phat
 * Date: 3/22/2016
 * Time: 11:42 AM
 */


class Cmr extends Admin_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cmr_model');
        $this->load->helper('url');

    }

    public function index()
    {
       $this->view();
    }


    public function view(){
        $user = $this->ion_auth->user()->row();
        $user_id = $user->id;
        $crud = $this->generate_crud('cmr');
        $crud->set_theme('datatables');
        $crud->columns('cmrid', 'courses', 'academic_year');
        $crud->callback_column($this->unique_field_name('courses'),function($value, $row) {
            $this->db->select('coutitle')
                ->from('course')
                ->where('couid',$value);
            $title = $this->db->get()->row();
            return $title->coutitle;
        });

        $crud->set_relation('courses','course','coutitle');
        $crud->display_as('cmrid','ID');
        $crud->set_relation('courses','coursestaff','courses');

        $crud->where('users',$user_id);



        // only admin can change member groups
        if ($crud->getState()=='list' || $this->ion_auth->in_group(array('webmaster', 'admin')))
        {
            $crud->set_relation_n_n('groups', 'users_groups', 'groups', 'user_id', 'group_id', 'name');
        }
        // disable direct create / delete Frontend User

        $crud->unset_add();
        $crud->unset_delete();
        $crud->add_action('Delete', '', 'cmr/deleteCMR','ui-icon-plus');
        $crud->unset_read();
        $crud->add_action('Details', '', 'cmr/detailsCMR','ui-icon-plus');
        $this->mTitle = 'Course Monitoring Report';
        $this->render_crud();
    }
    public function Add(){
        $this->mTitle = 'ADD CMR';
        $this->mViewData['cmrDrop'] = $this->Cmr_model->getCMR();
        $this->mViewData['cmrYear'] = $this->Cmr_model->getYearCmr();
        $this->mViewData['cmrCourses'] = $this->Cmr_model->getCourses();
        $this->render('cmr/add_cmr');

    }
    
    public function detailsCMR($primary_key){
        if($this->uri->segment(1) == 'detailsCMR'){
            $this->uri->set_segment(2,$primary_key);
        }
        $info = $this->Cmr_model->getCmrInfo($primary_key);
        $details = $this->Cmr_model->getCmrDetails($info->c_m_r__c_w);
        $this->mTitle = 'CMR Details';
        $this->mViewData['cmrInfo'] = $info;
        $this->mViewData['cmrDetails'] = $details;
        $this->render('cmr/view_cmr');
    }

    public function deleteCMR($primary_key){

        $cmr = $this->db->where('cmrid',$primary_key)->get('cmr')->row();
        $this->db->delete('cmr',array('cmrid' => $primary_key));
        $this->db->delete('cmr_status',array('id' => $cmr->c_m_r_status));
        $cw = $this->db->where('id',$cmr->c_m_r__c_w)->get('cmr_coursework')->row();
        $this->db->delete('cmr_detail',array('id' => $cw->cw1));
        $this->db->delete('cmr_detail',array('id' => $cw->cw2));
        $this->db->delete('cmr_detail',array('id' => $cw->cw3));
        $this->db->delete('cmr_detail',array('id' => $cw->cw4));
        $this->db->delete('cmr_detail',array('id' => $cw->overall));
        $this->db->delete('cmr_detail',array('id' => $cw->exam));
        $this->db->delete('cmr_coursework',array('id' => $cmr->c_m_r__c_w));
        redirect('cmr');

    }

    public function addCmr(){
        if(isset($_POST['submit']))
        {
            $year = $_POST['acaYear'];
            $couID = $_POST['couID'];
            foreach($_POST['details'] as $detail)
            {
                $this->db->insert('cmr_detail', $detail);
            }
            $data = $this->db->query('select * from cmr_detail order by id desc limit 6')->result_array();
            $count = 0;
            $arr = array();
            foreach ($data as $value)
            {
                if($count == 0)
                    $arr['overall'] = $value['id'];
                if($count == 1)
                    $arr['exam'] = $value['id'];
                if($count == 2)
                    $arr['cw4'] = $value['id'];
                if($count == 3)
                    $arr['cw3'] = $value['id'];
                if($count == 4)
                    $arr['cw2'] = $value['id'];
                if($count == 5)
                    $arr['cw1'] = $value['id'];
                $count++;
            }

            //Add data to cmr_coursework table
            $this->db->insert('cmr_coursework', $arr);
            $cwID = $this->db->insert_id();

            $arr2 = array(
                'dlt_comment' => ''
            );

            //Add data to cmr_status table
            $this->db->insert('cmr_status',$arr2);
            $statusID = $this ->db->insert_id();


            $data2 = $this->db->query('select * from cmr order by cmrid desc limit 1')->row();
            $cmrID = $data2->cmrid;
            $subID = substr($cmrID,-3);
            $resultID = '';
            if($subID <= 9)
                $resultID = '00'.($subID + 1);
            if($subID < 100 && $subID >= 9)
                $resultID = '0'.($subID+1);

            $resultID = 'cmr'.$resultID;
            $arr3 = array(
                'cmrid' => $resultID,
                'courses' => $couID,
                'c_m_r_status' => $statusID,
                'c_m_r__c_w' => $cwID,
                'academic_year' => $year
            );

            $this->db->insert('cmr',$arr3);
            redirect('cmr');
        }
    }

    public function getTimeLeft(){
        $cmr = $this->Cmr_model->getNeededCommentCMR();
        $dateleft = array();

        foreach ($cmr as $item) {
            $currentTime = time();
            $cmrtime = strtotime($item['date_approved']);
            if(($currentTime - $cmrtime) > 1209600 )
                $dateleft[] = -1;
            else
                $dateleft[] = ($currentTime - $cmrtime);

        }
        return $this->mViewData['dateleft'] = $dateleft;
    }

    public function idToTitle($value, $row)
    {

        $this->db->select('coutitle')
                 ->from('course')
                 ->where('couid',$row->couid);
        $title = $this->db->get()->result_array();
        return $title;
    }
    function unique_field_name($field_name) {
        return 's'.substr(md5($field_name),0,8);
    }

}