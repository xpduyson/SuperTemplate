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
        $stat = null;
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
        $crud->columns('cmrid', 'courses', 'academic_year','c_m_r_status');
        $crud->display_as('cmrid','ID');
        $crud->display_as('c_m_r_status','Status');
        $crud->set_relation('c_m_r_status','cmr_status','id');

        $crud->callback_column($this->unique_field_name('c_m_r_status'),function($value, $row) {
            $this->db->select('dlt_comment,cm_checked,reject')
                ->from('cmr_status')
                ->where('id',$value);
            $stat = $this->db->get()->row();
            $result = '';
            if($stat->dlt_comment != '')
                $result.= 'Commented - ';
            else
                $result .= 'No comment - ';
            if($stat->reject == 1)
                $result .= 'Rejected';
            else{
                if($stat->cm_checked == 0)
                    $result .= 'Not Approved';
                if($stat->cm_checked == 1)
                    $result .= 'Approved';
            }



            return $result;
        });

        if ($this->ion_auth->in_group(array('DLT')))
        {

            $crud->callback_column($this->unique_field_name('courses'),function($value, $row) {
                $this->db->select('coutitle')
                    ->from('course')
                    ->where('faculty',$value);
                $title = $this->db->get()->row();
                return $title->coutitle;
            });

            $crud->set_relation('courses','course','faculty');
            $crud->where('faculty',$user->faculty);
            $crud->where('cm_checked',1);
            $crud->unset_edit();
            $crud->unset_add();


        }

        if ($this->ion_auth->in_group(array('PVC')))
        {
            $crud->callback_column($this->unique_field_name('courses'),function($value, $row) {
                $this->db->select('coutitle')
                    ->from('course')
                    ->where('faculty',$value);
                $title = $this->db->get()->row();
                return $title->coutitle;
            });
            $crud->set_relation('courses','course','faculty');
            $crud->where('faculty',$user->faculty);
            $crud->unset_add();
            $crud->unset_edit();
        }

        if ($this->ion_auth->in_group(array('CL')))
        {
            $crud->callback_column($this->unique_field_name('courses'),function($value, $row) {
                $this->db->select('coutitle')
                    ->from('course')
                    ->where('couid',$value);
                $title = $this->db->get()->row();
                return $title->coutitle;
            });
            $crud->set_relation('courses','course','coutitle');
            $crud->set_relation('courses','coursestaff','courses');
            $crud->where('users',$user_id);
            $crud->unset_add();
            $crud->unset_edit();
            $crud->add_action('Delete', '', 'cmr/deleteCMR','ui-icon-plus');

        }

        if ($this->ion_auth->in_group(array('CM')))
        {
            $crud->callback_column($this->unique_field_name('courses'),function($value, $row) {
                $this->db->select('coutitle')
                    ->from('course')
                    ->where('couid',$value);
                $title = $this->db->get()->row();
                return $title->coutitle;
            });
            $crud->set_relation('courses','course','coutitle');
            $crud->set_relation('courses','coursestaff','courses');
            $crud->where('users',$user_id);
            $crud->unset_add();
            $crud->unset_edit();

        }

        if ($this->ion_auth->in_group(array('guest')))
        {
            $crud->callback_column($this->unique_field_name('courses'),function($value, $row) {
                $this->db->select('coutitle')
                    ->from('course')
                    ->where('faculty',$value);
                $title = $this->db->get()->row();
                return $title->coutitle;
            });
            $crud->set_relation('courses','course','faculty');
            $crud->where('faculty',$user->faculty);
            $crud->unset_add();
            $crud->unset_edit();
        }

        if ($this->ion_auth->in_group(array('webmaster')))
        {
            $crud->callback_column($this->unique_field_name('courses'),function($value, $row) {
                $this->db->select('coutitle')
                    ->from('course')
                    ->where('couid',$value);
                $title = $this->db->get()->row();
                return $title->coutitle;
            });
            $crud->set_relation('courses','course','couid');
            $crud->unset_add();
            $crud->unset_edit();
        }

        $crud->unset_delete();
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

        $info = $this->Cmr_model->getCmrInfo($primary_key);
        $status = $this->Cmr_model->getCmrStatus($info->c_m_r_status);
        $name = $this->Cmr_model->getName($info->courses);
        $courseDetails = $this->Cmr_model->getCourseInfo($info->courses);
        
        $this->mTitle = 'CMR Details';
        $this->mViewData['cmrInfo'] = $info;
        $this->mViewData['cmrUser'] = $name;
        $this->mViewData['cmrStatus'] = $status;
        $this->mViewData['courseMark'] = $info->mark_planning;
        $this->mViewData['courseTime'] = $courseDetails['courseTime'];
        $this->mViewData['courseFaculty'] = $courseDetails['faculty'];
        $this->mViewData['courseLevel'] = $courseDetails['courseLevel'];
        $this->mViewData['courseCredit'] = $courseDetails['courseCredit'];
        $this->mViewData['courseStatus'] = $courseDetails['courseStatus'];
        $this->mViewData['coursePVC'] = $courseDetails['PVC'];
        $this->mViewData['courseDLT'] = $courseDetails['DLT'];
        $this->mViewData['courseCM'] = $courseDetails['CM'];
        $date = time();
        $cmrtime = strtotime($info->date_approved);
        $diff = $cmrtime + 1209600;
        $goal = $diff - $date;
        
        $this->mViewData['timeLeft'] = $goal;
            
        $this->session->set_userdata('cmrStatus2',$status->id);
        $this->session->set_userdata('cmrStatus3',$info->cmrid);
        $this->render('cmr/view_cmr');
    }

    public function deleteCMR($primary_key){

        $cmr = $this->db->where('cmrid',$primary_key)->get('cmr')->row();
        $this->db->delete('cmr',array('cmrid' => $primary_key));
        $this->db->delete('cmr_status',array('id' => $cmr->c_m_r_status));
        redirect('cmr');

    }

    public function addCmr(){
        if(isset($_POST['submit']))
        {

            $year = $_POST['acaYear'];
            $couID = $_POST['couID'];
            $mark = $_POST['mark'];
            $user = $this->ion_auth->user()->row();
            $user_id = $user->id;
            if($this->Cmr_model->filterYear($couID,$year))
            {
                if($this->Cmr_model->getCourseStatus($couID) == 1)
                {
                    $arr2 = array(
                        'dlt_comment' => ''
                    );
                    //Add data to cmr_status table
                    $this->db->insert('cmr_status',$arr2);
                    $statusID = $this->db->insert_id();

                    //Generate cmr code
                    $data = $this->db->query('select * from cmr order by cmrid desc limit 1')->row();
                    $cmrID = $data->cmrid;
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
                        'mark_planning' => $mark,
                        'academic_year' => $year,
                    );

                    $this->db->insert('cmr',$arr3);
                    redirect('cmr');
                }
                else{
                    $cou = $this->Cmr_model->getCoursesByID($couID);
                    $this->session->set_flashdata('errorMsg',"Can Not Insert CMR For Inactive Course ". $cou->coutitle);
                    redirect('cmr/Add');
                }

            }
            else{
                $cou = $this->Cmr_model->getCoursesByID($couID);
                $this->session->set_flashdata('errorMsg',$cou->coutitle. " Already Had A CMR");
                redirect('cmr/Add');

            }

        }
    }
    
    function unique_field_name($field_name) {
        return 's'.substr(md5($field_name),0,8);
    }

    public function addComment(){
        $cmt = $_POST['comment'];
        $value = array(
            'dlt_comment' => $cmt
        );
        $this->db->where('id', $this->session->userdata("cmrStatus2"));
        $this->db->update('cmr_status',$value);
        $this->session->set_flashdata('message', 'Comment CMR Successful!!!');
        redirect('cmr');

    }

    public function approveCmr(){

        $value = array(
          'cm_checked' => 1,
        );
        $this->db->where('id',$this->session->userdata("cmrStatus2"));
        $this->db->update('cmr_status',$value);
        $this->session->set_flashdata('message', 'Approved CMR Successful!!!');
        redirect('cmr');
    }

    public function rejectCMR(){

        $value = array(
            'cm_checked' => 0,
            'reject' => 1
        );
        $this->db->where('id',$this->session->userdata("cmrStatus2"));
        $this->db->update('cmr_status',$value);
        $this->session->set_flashdata('message', 'Reject CMR Successful!!!');
        redirect('cmr');
    }
    
    public function getInfo(){
        $course = $this->input->post('course');
        $acayear = $this->input->post('year');
  
        if($course == "")
        {
            echo 'failed';
        }
        else{
            $result = $this->Cmr_model->getCourseInfo($course,$acayear);
            echo json_encode($result);
  
        }
    }

}