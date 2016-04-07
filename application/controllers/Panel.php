<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Panel management, includes:
 *    - Admin Users CRUD
 *    - Admin User Groups CRUD
 *    - Admin User Reset Password
 *    - Account Settings (for login user)
 */
class Panel extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->mTitle = 'Admin Panel - ';
        $this->load->model('Admin_user_model');
    }

    // Admin Users CRUD
    public function admin_user()
    {

        $crud = $this->generate_crud('users');
        $crud->columns('groups', 'username', 'first_name', 'last_name', 'faculty', 'active');

        $crud->callback_edit_field('faculty', array($this, 'edit_field_callback_1'));

        $crud->set_theme('datatables');

        $facId = $this->Admin_user_model->getFacId();

        //$this->unset_crud_fields('ip_address', 'last_login');

        // cannot change Admin User groups once created
        if ($crud->getState() == 'list') {
            $crud->set_relation_n_n('groups', 'users_groups', 'groups', 'user_id', 'group_id', 'name');
        }

        // only webmaster can reset Admin User password
        if ($this->ion_auth->in_group(array('webmaster', 'admin'))) {
            $crud->add_action('Reset Password', '', 'panel/admin_user_reset_password', 'fa fa-repeat');
        }

        // disable direct create / delete Admin User
        $crud->unset_add();
        $crud->unset_delete();

        $this->mTitle .= 'Admin Users';
        $this->render_crud();
    }

    function edit_field_callback_1($value, $primary_key)
    {
        $facId = $this->Admin_user_model->getFacId();
        $this->mViewData['faculties'] = $facId;

        $fac = $this->Admin_user_model->getFacNamebyId($primary_key);
        //$this->session->userdata("facName");
        $this->session->set_userdata['facName'] = $fac;


        //return '+30 <input type="text" maxlength="50" value="' . $value . '" name="phone" style="width:462px">';
        return '<select required name="faculty" id="faculties">
                        <?php
                       
                        echo $this->session->userdata("facName");
                            ?>
                            <?php
                        
                            foreach ($faculties as $value) {
                                ?>
                                <option name="faculty" value="$value">
                                    <?php echo $value[\'facname\']; ?></option>
                                <?php
                            }
                         ?>

                    </select>';
    }


    // Create Admin User
    public function admin_user_create()
    {
        // (optional) only top-level admin user groups can create Admin User
        //$this->verify_auth(array('webmaster'));

        $form = $this->form_builder->create_form();

        if ($form->validate()) {
            // passed validation
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'faculty' => $this->input->post('faculty')
            );
            $groups = $this->input->post('groups');

            // create user (default group as "members")
            $user = $this->ion_auth->register($username, $password, $additional_data, $groups);
            if ($user) {
                // success
                $messages = $this->ion_auth->messages();
                $this->system_message->set_success($messages);
            } else {
                // failed
                $errors = $this->ion_auth->errors();
                $this->system_message->set_error($errors);
            }
            refresh();
        }

        $groups = $this->ion_auth->groups()->result();
        unset($groups[0]);    // disable creation of "webmaster" account
        $this->mViewData['groups'] = $groups;
        $this->mTitle .= 'Create Admin User';

        $facId = $this->Admin_user_model->getFacId();
        $this->mViewData['faculties'] = $facId;

        $this->mViewData['form'] = $form;
        $this->render('panel/admin_user_create');
    }

    // Admin User Groups CRUD
    public function admin_user_group()
    {
        $crud = $this->generate_crud('groups');
        $this->mTitle .= 'Admin User Groups';
        $this->render_crud();
    }

    // Admin User Reset password
    public function admin_user_reset_password($user_id)
    {
        // only top-level users can reset Admin User passwords
        $this->verify_auth(array('webmaster'));

        $form = $this->form_builder->create_form();
        if ($form->validate()) {
            // pass validation
            $data = array('password' => $this->input->post('new_password'));
            if ($this->ion_auth->update($user_id, $data)) {
                $messages = $this->ion_auth->messages();
                $this->system_message->set_success($messages);
            } else {
                $errors = $this->ion_auth->errors();
                $this->system_message->set_error($errors);
            }
            refresh();
        }

        $this->load->model('admin_user_model', 'admin_users');
        $target = $this->admin_users->get($user_id);
        $this->mViewData['target'] = $target;

        $this->mViewData['form'] = $form;
        $this->mTitle .= 'Reset Admin User Password';
        $this->render('panel/admin_user_reset_password');
    }

    // Account Settings
    public function account()
    {
        // Update Info form
        $form1 = $this->form_builder->create_form('panel/account_update_info');
        $form1->set_rule_group('panel/account_update_info');
        $this->mViewData['form1'] = $form1;

        // Change Password form
        $form2 = $this->form_builder->create_form('panel/account_change_password');
        $form1->set_rule_group('panel/account_change_password');
        $this->mViewData['form2'] = $form2;

        $this->mTitle = "Account Settings";
        $this->render('panel/account');
    }

    // Submission of Update Info form
    public function account_update_info()
    {
        $data = $this->input->post();
        if ($this->ion_auth->update($this->mUser->id, $data)) {
            $messages = $this->ion_auth->messages();
            $this->system_message->set_success($messages);
        } else {
            $errors = $this->ion_auth->errors();
            $this->system_message->set_error($errors);
        }

        redirect('panel/account');
    }

    // Submission of Change Password form
    public function account_change_password()
    {
        $data = array('password' => $this->input->post('new_password'));
        if ($this->ion_auth->update($this->mUser->id, $data)) {
            $messages = $this->ion_auth->messages();
            $this->system_message->set_success($messages);
        } else {
            $errors = $this->ion_auth->errors();
            $this->system_message->set_error($errors);
        }

        redirect('panel/account');
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $this->ion_auth->logout();
        redirect('login');
    }
}
