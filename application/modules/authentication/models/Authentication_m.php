<?php

class Authentication_m extends MY_Model {
  public function __construct()
  {
    parent::__construct();
    $this->data['table_name']	= 'users';
		$this->data['primary_key']	= 'user_id';
  }

  public function validating($password)
  {
    // Cek username
    $row = $this->db->query("SELECT user_password FROM users")->result();

    if (password_verify($password, $row[0]->user_password)) {
      return true;
    } else {
      return $this->flashmsg('Your password is incorrect', 'danger');
    }
  }
}