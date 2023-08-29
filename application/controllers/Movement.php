<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Movement extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('Movement_model', 'Move');

    if (empty($this->session->userdata('id_user'))) {
      $this->session->set_flashdata('flashceklogin', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Perpindahan Ban';

    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar');
    $this->load->view('template/navbar');
    $this->load->view('trans/ban/move', $data);
  }

  public function getMovement()
  {
    header('Content-Type: application/json');

    echo $this->Move->getData();
  }
}
