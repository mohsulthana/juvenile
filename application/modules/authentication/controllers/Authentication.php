<?php

class Authentication extends MY_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->module('Template');
    $this->load->model('authentication_m', 'auth_m');
  }

  public function index()
  {
    $data['content']      = 'Hello';
    $data['title']        = 'Juvenile | Login';
    $this->load->view('authentication/login_v', $data);
  }
  
  public function login()
  {
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $data['title']        = 'Juvenile | Login';

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('login_v', $data);
    } else {
      $username    = $this->post('username');
      $password = $this->post('password');

      // cek apakah user ada di database
      $user_exist = $this->auth_m->get(['user_username' => $username]);

      if (count($user_exist) === 0) {
        $this->flashmsg('User does not exist. Register one', 'danger');
        redirect('login');
      } else {
        $data = [
          'user_username' => $username,
          'user_password' => $password,
        ];
        $user = $this->auth_m->validating($password);

        if ($user === true) {
          $userdata = [
            'user_id'     => $user->user_id,
            'username'    => $user->user_username,
            'name'        => $user->user_name,
            'role'        => $user->user_role
          ];
					$this->auth_m->update($userdata['user_id'], ['last_login' => date("Y-m-d H:i:s")]);
          $this->session->set_userdata(['token' => $userdata]);
          redirect('dashboard');
        } else {
          redirect('login');
        }
      }
    }
  }

  public function register()
  {
    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $data['title']        = 'Register';

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('register_v', $data);
    } else {
      $name     = $this->post('name');
      $username = $this->post('username');
      $email    = $this->post('email');
      $password = $this->post('password');
      
      $user_exist = $this->auth_m->get(['user_username' => $username]);

      if (count($user_exist) > 0) {
        $this->flashmsg('Username is exist. Go to login', 'danger');
      } else {
        date_default_timezone_get('Asia/Jakarta');

        $data = [
          'user_name'       => $name,
          'user_username'   => $username,
          'user_mail'       => $email,
          'user_password'   => password_hash($password, PASSWORD_ARGON2ID),
          'user_created_at' => date("Y-m-d H:i:s"),
        ];
        
        $this->db->trans_start();
        $this->auth_m->insert($data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
          $this->flashmsg('Something wrong. Contact administrator', 'danger');
          $this->load->view('register_v', $data);
        } else {
          $this->flashmsg('Your account has been created. Login now', 'success');
          redirect('login');
        }
      }
    }
  }
}