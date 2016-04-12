<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Cmr_model');
	}

	public function index()
	{
		if ($this->ion_auth->in_group(array('webmaster'))) {
			$PVC = $this->Cmr_model->getPVCList();
			$DLT = $this->Cmr_model->getDLTList();
			$CL = $this->Cmr_model->getCLList();
			$CM = $this->Cmr_model->getCMList();
			$this->mViewData['CLSize'] = count($CL);
			$this->mViewData['CMSize'] = count($CM);
			$this->mViewData['PVCSize'] = count($PVC);
			$this->mViewData['DLTSize'] = count($DLT);
			$this->mViewData['CourseSize'] = $this->Cmr_model->getCourseSize();
			$this->mViewData['FacultySize'] = $this->Cmr_model->getFacultySize();
			$this->mViewData['CMRSize'] = $this->Cmr_model->getCMRSize();
			$this->mViewData['academicYear'] = $this->Cmr_model->getYearCmr();
			if ($DLT == 0) {
				$this->mViewData['DLT'] = 0;
				$this->mViewData['DLTSize'] = 0;
			} else
				$this->mViewData['DLT'] = $DLT;
			if ($PVC == 0) {
				$this->mViewData['PVC'] = 0;
				$this->mViewData['PVCSize'] = 0;
			} else
				$this->mViewData['PVC'] = $PVC;
			if ($CM == 0) {
				$this->mViewData['CM'] = 0;
				$this->mViewData['CMSize'] = 0;
			} else
				$this->mViewData['CM'] = $CM;
			if ($CL == 0) {
				$this->mViewData['CL'] = 0;
				$this->mViewData['CLSize'] = 0;
			} else
				$this->mViewData['CL'] = $CL;
			$this->render('home');
		}

		if ($this->ion_auth->in_group(array('CL'))) {
			$user = $this->ion_auth->user()->row();
			$user_id = $user->id;
			$CourseWithoutCMRByCL = $this->Cmr_model->getCourseWithoutCMRByCL($user_id);
			$CMRReject = $this->Cmr_model->getCMRRejectByCL($user_id);
			if($CourseWithoutCMRByCL == 0){
				$this->mViewData['CourseOutCMRByCLSize'] = 0;
			}else{
				$this->mViewData['CourseOutCMRByCLSize'] = count($CourseWithoutCMRByCL);
			}
			if($CMRReject == 0){
				$this->mViewData['CMRRejectSize'] = 0;
			}else{
				$this->mViewData['CMRRejectSize'] = count($CMRReject);
			}
			$this->mViewData['CourseOutCMRByCL'] = $CourseWithoutCMRByCL;
			$this->mViewData['CMRReject'] = $CMRReject;
			$role = $this->Cmr_model->getRole($user->id);
			$this->mViewData['CourseSize'] = $this->Cmr_model->getCourseSizeByRole($user_id,$role);
			$this->mViewData['FacultySize'] = $this->Cmr_model->getFacultySizeByRole($user_id,$role);
			$this->mViewData['CMRSize'] = $this->Cmr_model->getCMRSizeByRole($user_id,$role);
			$this->render('home_CL');
		}
		
		if ($this->ion_auth->in_group(array('CM'))) {
			$user = $this->ion_auth->user()->row();
			$user_id = $user->id;
			$CMRNeedApprove = $this->Cmr_model->getCMRNeedApprove($user_id);
			if($CMRNeedApprove == 0){
				$this->mViewData['CMRNeedApproveSize'] = 0;
			}else{
				$this->mViewData['CMRNeedApproveSize'] = count($CMRNeedApprove);
			}
			$this->mViewData['CMRNeedApprove'] = $CMRNeedApprove;
			$role = $this->Cmr_model->getRole($user->id);
			$this->mViewData['CourseSize'] = $this->Cmr_model->getCourseSizeByRole($user_id,$role);
			$this->mViewData['FacultySize'] = $this->Cmr_model->getFacultySizeByRole($user_id,$role);
			$this->mViewData['CMRSize'] = $this->Cmr_model->getCMRSizeByRole($user_id,$role);
			$this->render('home_CM');
		}

		if ($this->ion_auth->in_group(array('PVC'))) {
			$user = $this->ion_auth->user()->row();
			$user_id = $user->id;
			$CMRNeedComment = $this->Cmr_model->getNeededCommentCMR($user->faculty,$user_id);
			if($CMRNeedComment == 0){
				$this->mViewData['CMRNeedCommentSize'] = 0;
			}else{
				$this->mViewData['CMRNeedCommentSize'] = count($CMRNeedComment);
			}
			$this->mViewData['CMRNeedComment'] = $CMRNeedComment;
			$role = $this->Cmr_model->getRole($user->id);
			$this->mViewData['CourseSize'] = $this->Cmr_model->getCourseSizeByFac($user->faculty);
			$this->mViewData['FacultySize'] = $this->Cmr_model->getFacultySizeByRole($user_id,$role);
			$this->mViewData['CMRSize'] = $this->Cmr_model->getCMRSizeByFac($user->faculty);
			$this->render('home_PVC');
		}

		if ($this->ion_auth->in_group(array('DLT'))) {
			$user = $this->ion_auth->user()->row();
			$user_id = $user->id;
			$CMRNeedComment = $this->Cmr_model->getNeededCommentCMR($user->faculty,$user_id);
			if($CMRNeedComment == 0){
				$this->mViewData['CMRNeedCommentSize'] = 0;
			}else{
				$this->mViewData['CMRNeedCommentSize'] = count($CMRNeedComment);
			}
			$this->mViewData['CMRNeedComment'] = $CMRNeedComment;
			$role = $this->Cmr_model->getRole($user->id);
			$this->mViewData['CourseSize'] = $this->Cmr_model->getCourseSizeByFac($user->faculty);
			$this->mViewData['FacultySize'] = $this->Cmr_model->getFacultySizeByRole($user_id,$role);
			$this->mViewData['CMRSize'] = $this->Cmr_model->getCMRSizeByFac($user->faculty);
			$this->render('home_DLT');
		}
	}
	
	public function getReport(){
		$acayear = $this->input->post('year');
			$couOutCMR =  $this->Cmr_model->getCourseWithoutCMR($acayear);
			$cmrOutComment = $this->Cmr_model->getCMRWithoutComment($acayear);
			$cmrOutApproved = $this->Cmr_model->getCMRWithoutApproved($acayear);

		if(count($couOutCMR) == 0)
			$this->session->set_userdata('courseOutCMR', 0);
		else
			$this->session->set_userdata('courseOutCMR', $couOutCMR);


		if(count($cmrOutComment) == 0)
			$this->session->set_userdata('cmrOutComment', 0);
		else
			$this->session->set_userdata('cmrOutComment', $cmrOutComment);


		if(count($cmrOutApproved) == 0)
			$this->session->set_userdata('cmrOutApproved', 0);
		else
			$this->session->set_userdata('cmrOutApproved', $cmrOutApproved);
		
		$result = array(
			'courseOutCMRSize' => count($couOutCMR),
			'cmrOutCommentSize' => count($cmrOutComment),
			'cmrOutApprovedSize' => count($cmrOutApproved)
			
		);
			
			echo json_encode($result);

	}

	
}
