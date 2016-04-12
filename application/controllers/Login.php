<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// NOTE: this controller inherits from MY_Controller instead of Admin_Controller,
// since no authentication is required
class Login extends MY_Controller {

	/**
	 * Login page and submission
	 */
	public function index()
	{
		$this->load->library('form_builder');
		$this->load->library("session");
		$form = $this->form_builder->create_form();
		$this->load->model('Cmr_model');

		if ($form->validate())
		{
			// passed validation

			$identity = $this->input->post('username');
			$password = $this->input->post('password');
			$remember = ($this->input->post('remember')=='on');
			
			if ($this->ion_auth->login($identity, $password, $remember))
			{
				// login succeed
				$messages = $this->ion_auth->messages();
				$data = $this->Cmr_model->getNeededCommentCMR($this->ion_auth->user()->row()->faculty);


				$this->session->set_userdata("namelog2", $identity);
				$this->session->set_flashdata('cmrNotComment',$data);
				$this->system_message->set_success($messages);
				redirect('home');
			}
			else
			{
				// login failed
				$errors = $this->ion_auth->errors();
				$this->system_message->set_error($errors);
				refresh();
			}
		}
		
		// display form when no POST data, or validation failed
		$this->mViewData['body_class'] = 'login-page';
		$this->mViewData['form'] = $form;
		$this->mBodyClass = 'login-page';
		$this->render('login', 'empty');
	}
}
