<?php

class Dashboard extends MY_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->module('template');
  }

  public function index()
  {
    $data['title']            = 'Dashboard';
    $this->template->load_view('dashboard/dashboard', $data);
  }
}