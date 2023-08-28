<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Mpdf\Mpdf;

class Vulkanisir extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('Vulkanisir_model', 'Vulk');

    if (empty($this->session->userdata('id_user'))) {
      $this->session->set_flashdata('flashceklogin', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Vulkanisir';

    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar');
    $this->load->view('template/navbar');
    $this->load->view('trans/ban/vulk/index', $data);
  }

  public function getVulkanisir()
  {
    header('Content-Type: application/json');

    echo $this->Vulk->getData();
  }

  public function addData()
  {
    $data['title']  = 'Form Tambah Data Vulkanisir';
    $data['kd']     = $this->Vulk->cekKd();

    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar');
    $this->load->view('template/navbar');
    $this->load->view('trans/ban/vulk/add', $data);
  }

  public function cart()
  {
    $this->load->view('trans/ban/vulk/cart');
  }

  public function proses()
  {
    $jmlvulk  = count($this->input->post('banid_hidden'));

    $kdvulk   = $this->input->post('kd');
    $tokoid   = $this->input->post('tokoid');
    $toko     = $this->input->post('toko');
    $total    = $this->input->post('totalban_hidden');
    $date     = date('Y-m-d H:i:s');

    $banid    = $this->input->post('banid_hidden');
    $size     = $this->input->post('size_hidden');
    $noseri   = $this->input->post('noseri_hidden');
    $jml      = $this->input->post('jml_hidden');
    $merk     = $this->input->post('merk_hidden');
    $ket      = $this->input->post('ket_hidden');

    $data_vulk = [
      'kd_vulk'           => $kdvulk,
      'tempat_vulk'       => $toko,
      'jml_total_vulk'    => $total,
      'tgl_vulk'          => $date,
    ];

    $detail_vulk = [];

    for ($i = 0; $i < $jmlvulk; $i++) {
      array_push($detail_vulk, ['no_seri_vulk'  => $noseri[$i]]);
      $detail_vulk[$i]['kd_vulk']             = $kdvulk;
      $detail_vulk[$i]['merk_vulk']           = $merk[$i];
      $detail_vulk[$i]['jml_vulk']            = $jml[$i];
      $detail_vulk[$i]['ukuran_ban_vulk']     = $size[$i];
      $detail_vulk[$i]['status']              = 0;
      $detail_vulk[$i]['no_nota']             = '';
      $detail_vulk[$i]['tgl_update']          = '0000-00-00 00:00:00';
    }

    $historyVulk = [];

    for ($k = 0; $k < $jmlvulk; $k++) {
      array_push($historyVulk,  ['kd_history_ban' => $kdvulk]);
      $historyVulk[$k]['no_seri_history']   = $noseri[$k];
      $historyVulk[$k]['ket_history']       =  "Divulkanisir di " . $toko;
      $historyVulk[$k]['ket_trans']         = $ket[$k];
      $historyVulk[$k]['tgl_add_history']   = $date;
      $historyVulk[$k]['user_history']      = $this->session->userdata('username');
    }

    $update_ban = [];

    for ($j = 0; $j < $jmlvulk; $j++) {
      array_push($update_ban, ['id_ban'   => $banid[$j]]);
      $update_ban[$j]['status_ban']       = "Divulkanisir di " . $toko;
      $update_ban[$j]['date_ban_update']  = $date;
    }

    $this->Vulk->addData($data_vulk, $detail_vulk, $update_ban);
    $this->Vulk->addHistory($historyVulk);

    $this->session->set_flashdata('success', 'Ban berhasil divulkanisir');

    redirect('vulkanisir');
  }

  public function selesai()
  {
    $data['title']    = 'Form Selesai Vulkanisir';

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('template/navbar');
    $this->load->view('trans/ban/vulk/selesai', $data);
  }

  public function getDataByTempat()
  {
    $id   = $this->input->post('tempat');
    $data = $this->Vulk->getVulkByTempat($id);

    echo json_encode($data);
  }

  public function getDataBan()
  {
    $seri   = $this->input->post('seri');
    $data   = $this->Vulk->getBanBySeri($seri);

    echo json_encode($data);
  }

  public function cartselesai()
  {
    $this->load->view('trans/ban/vulk/cart-selesai');
  }

  public function prosesselesai()
  {
    $jml        = count($this->input->post('seri_hidden'));

    $seri      = $this->input->post('seri_hidden');
    $merk       = $this->input->post('merk_hidden');
    $size       = $this->input->post('size_hidden');
    $jmlban     = $this->input->post('jml_hidden');
    $kdvulk     = $this->input->post('kdvulk');
    $toko       = $this->input->post('toko');
    $biaya      = preg_replace("/[^0-9\.]/", "", $this->input->post('biaya'));
    $pay        = $this->input->post('pay');
    $nota       = $this->input->post('nota');
    $user       = $this->session->userdata('id_user');
    $date       = date('Y-m-d H:i:s');

    $vulkDone = array(
      'no_nota'           => $nota,
      'kd_vulk'           => $kdvulk,
      'tempat_vulk'       => $toko,
      'biaya'             => $biaya,
      'pembayaran'        => $pay,
      'jml_vulk_selesai'  => $jml,
      'tgl_selesai'       => $date,
      'user_id'           => $user,
    );

    $vulkDoneItems = [];

    for ($i = 0; $i < $jml; $i++) {
      array_push($vulkDoneItems, ['kd_vulk' => $kdvulk]);
      $vulkDoneItems[$i]['no_seri']         = $seri[$i];
      $vulkDoneItems[$i]['merk']            = $merk[$i];
      $vulkDoneItems[$i]['jml']             = $jmlban[$i];
      $vulkDoneItems[$i]['ukuran']          = $size[$i];
    }

    $updateDetailStatus = [];

    for ($i = 0; $i < $jml; $i++) {
      array_push($updateDetailStatus, ['no_seri_vulk' => $seri[$i]]);
      $updateDetailStatus[$i]['kd_vulk']             = $kdvulk;
      $updateDetailStatus[$i]['merk_vulk']           = $merk[$i];
      $updateDetailStatus[$i]['jml_vulk']            = $jmlban[$i];
      $updateDetailStatus[$i]['ukuran_ban_vulk']     = $size[$i];
      $updateDetailStatus[$i]['status']              = 1;
      $updateDetailStatus[$i]['no_nota']             = $nota;
      $updateDetailStatus[$i]['tgl_update']          = $date;
    }

    $historyVulk = [];

    for ($k = 0; $k < $jml; $k++) {
      array_push($historyVulk,  ['kd_history_ban' => $nota]);
      $historyVulk[$k]['no_seri_history']   = $seri[$k];
      $historyVulk[$k]['ket_history']       = "Selesai Vulkanisir dari " . $toko;
      $historyVulk[$k]['ket_trans']         = "Vulkanisir Selesai";
      $historyVulk[$k]['tgl_add_history']   = $date;
      $historyVulk[$k]['user_history']      = $user;
    }

    $updateStatusBan = [];

    for ($j = 0; $j < $jml; $j++) {
      array_push($updateStatusBan, ['no_seri' => $seri[$j]]);
      $updateStatusBan[$j]['vulk']             = 1;
      $updateStatusBan[$j]['status_ban']       = "Gudang";
      $updateStatusBan[$j]['date_ban_update']  = $date;
    }

    $this->Vulk->addDataDone($vulkDone, $vulkDoneItems);
    $this->Vulk->updateDetailStatus($updateDetailStatus);
    $this->Vulk->updateStatusBan($updateStatusBan);
    $this->Vulk->addHistoryVulkDone($historyVulk);

    $this->session->set_flashdata('success', 'Vulkanisir berhasil diupdate');

    redirect('vulkanisir');
  }

  public function allDetailVulk()
  {
    $data['title']    = 'Detail Vulkanisir';

    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar');
    $this->load->view('template/navbar');
    $this->load->view('trans/ban/vulk/detail-all', $data);
  }

  public function getAllDetail()
  {
    header('Content-Type: application/json');

    echo $this->Vulk->getDetailAllVulk();
  }

  public function getNota()
  {
    $keyword = $this->input->get('q');

    if (!$keyword) {

      $data = $this->Vulk->selectNota();

      $response = [];
      foreach ($data as $nota) {
        $response[] = [
          'id' => $nota->id_vulk_done,
          'text' => strtoupper($nota->no_nota),
        ];
      }

      echo json_encode($response);
    } else {
      $data = $this->Vulk->selectSearcNota($keyword);

      $response = [];
      foreach ($data as $nota) {
        $response[] = [
          'id' => $nota->id_vulk_done,
          'text' => strtoupper($nota->no_nota),
        ];
      }

      echo json_encode($response);
    }
  }

  public function printDo()
  {
    $nota     = $this->input->post('nota');
    $head     = $this->Vulk->getKdByNota($nota);
    $detail   = $this->Vulk->getDataByNota($nota);

    $data['head']     = $head;
    $data['detail']   = $detail;

    $content  = $this->load->view('trans/ban/vulk/print-selesai', $data, true);

    $mpdf = new Mpdf([
      'mode' => 'utf-8',
      'format' => 'A4',
      'orientation' => 'L'
    ]);

    $mpdf->WriteHTML($content);

    $mpdf->Output();
  }

  public function suratJalanKeluar($kd)
  {
    $dt   = $this->Vulk->getDataSuratJalan($kd);
    $head = $this->Vulk->getVulkKd($kd);

    $data['head']     = $head;
    $data['dtvulk']   = $dt;

    $content  = $this->load->view('trans/ban/vulk/print-sj', $data, true);

    $mpdf = new Mpdf([
      'mode' => 'utf-8',
      'format' => 'A4',
      'orientation' => 'L'
    ]);

    $mpdf->WriteHTML($content);

    $mpdf->Output();
  }
}
