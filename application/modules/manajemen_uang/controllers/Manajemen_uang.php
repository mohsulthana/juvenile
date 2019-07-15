<?php

class Manajemen_uang extends MY_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->module('template');
  }

  public function uang_masuk()
  {
    $data['title']            = 'Uang Masuk';
    $this->template->load_view('manajemen_uang/uang_masuk', $data);
  }

  public function uang_keluar()
  {
    $data['title']            = 'Uang Keluar';
    $this->template->load_view('manajemen_uang/uang_keluar', $data);
  }
}