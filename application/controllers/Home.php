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
		if($DLT == 0)
		{
			$this->mViewData['DLT'] = 0;
			$this->mViewData['DLTSize'] = 0;
		}
		else
			$this->mViewData['DLT'] = $DLT;
		if($PVC == 0)
		{
			$this->mViewData['PVC'] = 0;
			$this->mViewData['PVCSize'] = 0;
		}
		else
			$this->mViewData['PVC'] = $PVC;
		if($CM == 0)
		{
			$this->mViewData['CM'] = 0;
			$this->mViewData['CMSize'] = 0;
		}
		else
			$this->mViewData['CM'] = $CM;
		if($CL == 0)
		{
			$this->mViewData['CL'] = 0;
			$this->mViewData['CLSize'] = 0;
		}
		else
			$this->mViewData['CL'] = $CL;
		$this->render('home');
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
