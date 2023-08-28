<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vulkanisir_model extends CI_Model
{
  public function cekKd()
  {
    $date = date('mdYHis');
    $tr   = "vlk-";
    $kd   = $tr .  $date;

    return $kd;
  }

  public function getData()
  {
    $this->datatables->select('id_vulk, kd_vulk, nama_toko, jml_total_vulk, tgl_vulk')
      ->from('vulkanisir')
      ->join('toko', 'toko.id_toko = vulkanisir.tempat_vulk', 'left')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          <a href="http://localhost/he/vulkanisir/suratJalanKeluar/$2" target="_blank" class="btn btn-info btn-sm btn-print" data-toggle="tooltip" title="Cetak">
            <i class="fas fa-print fa-sm"></i>
          </a>
        </div>',
        'id_vulk, kd_vulk, tempat_vulk, jml_total_vulk, tgl_vulk'
      );

    return $this->datatables->generate();
  }

  public function addData($data_vulk, $detail_vulk, $update_ban)
  {
    $this->db->insert('vulkanisir', $data_vulk);
    $this->db->insert_batch('detail_vulk', $detail_vulk);
    $this->db->update_batch('ban', $update_ban, 'id_ban');
  }

  public function getDetailByKdVulk($kd)
  {
    $this->db->select('*');
    $this->db->from('vulkanisir');
    $this->db->join('detail_vulk', 'detail_vulk.kd_vulk = vulkanisir.kd_vulk');
    $this->db->where('vulkanisir.kd_vulk', $kd);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getVulkKd($kd)
  {
    $this->db->select('kd_vulk, tempat_vulk, tgl_vulk')
      ->from('vulkanisir')
      ->where('kd_vulk', $kd);

    $query = $this->db->get()->row();

    return $query;
  }

  public function getAllData()
  {
    $this->db->select('*');
    $this->db->from('vulkanisir');
    $this->db->join('detail_vulk', 'detail_vulk.kd_vulk = vulkanisir.kd_vulk');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getVulkByTempat($id)
  {
    $status = 0;

    $this->db->select('*')
      ->from('vulkanisir')
      ->join('detail_vulk', 'detail_vulk.kd_vulk = vulkanisir.kd_vulk')
      ->where('tempat_vulk', $id)
      ->where('status', $status);

    $query = $this->db->get()->result();

    return $query;
  }

  public function getBanBySeri($seri)
  {
    $this->db->select('*')
      ->from('detail_vulk')
      ->join('ban', 'ban.no_seri = detail_vulk.no_seri_vulk')
      ->where('no_seri_vulk', $seri);

    $query = $this->db->get()->row();

    return $query;
  }

  public function getDetailAllVulk()
  {
    $this->datatables->select('a.id_detail_vulk, a.kd_vulk, a.no_seri_vulk, a.merk_vulk, a.ukuran_ban_vulk, a.jml_vulk, a.status, a.no_nota, a.tgl_update, b.tempat_vulk, b.tgl_vulk')
      ->from('detail_vulk a')
      ->join('vulkanisir b', 'b.kd_vulk = a.kd_vulk')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          
        </div>',
        'id_detail_vulk, kd_vulk, no_seri_vulk, merk_vulk, ukuran_ban_vulk, jml_vulk, status, no_nota, tgl_update, tempat_vulk, tgl_vulk'
      );

    return $this->datatables->generate();
  }

  public function selectNota()
  {
    $this->db->select('id_vulk_done, no_nota')
      ->from('vulk_done');

    $query = $this->db->get()->result();

    return $query;
  }

  public function selectSearcNota($keyword)
  {
    $this->db->select('id_vulk_done, no_nota')
      ->from('vulk_done')
      ->like('no_nota', $keyword);

    $query = $this->db->get()->result();

    return $query;
  }

  public function getDataByNota($nota)
  {
    $this->db->select('*')
      ->from('vulk_done')
      ->join('vulkanisir', 'vulkanisir.kd_vulk = vulk_done.kd_vulk')
      ->join('detail_vulk', 'detail_vulk.no_nota = vulk_done.no_nota')
      ->where('detail_vulk.no_nota', $nota);

    $query = $this->db->get()->result();

    return $query;
  }

  public function getDataSuratJalan($kd)
  {
    $this->db->select('*')
      ->from('detail_vulk')
      ->where('kd_vulk', $kd);

    $query = $this->db->get()->result();

    return $query;
  }

  public function getKdByNota($nota)
  {
    $this->db->select('*')
      ->from('vulk_done')
      ->where('no_nota', $nota);

    $query = $this->db->get()->row();

    return $query;
  }

  public function addDataDone($vulkDone, $vulkDoneItems)
  {
    $this->db->insert('vulk_done', $vulkDone);
    $this->db->insert_batch('detail_vulk_selesai', $vulkDoneItems);
  }

  public function updateDetailStatus($updateDetailStatus)
  {
    $this->db->update_batch('detail_vulk', $updateDetailStatus, 'no_seri_vulk');
  }

  public function updateStatusBan($updateStatusBan)
  {
    $this->db->update_batch('ban', $updateStatusBan, 'no_seri');
  }

  public function addHistoryVulkDone($historyVulk)
  {
    $this->db->insert_batch('history_ban', $historyVulk);
  }

  public function addHistory($historyVulk)
  {
    $this->db->insert_batch('history_ban', $historyVulk);
  }

  public function addSelesaiVulk($selesai, $updateban)
  {
    $this->db->insert('vulk_done', $selesai);
    $this->db->update_batch('ban', $updateban, 'no_seri');
  }

  public function getDataSuccess($kd)
  {
    $this->db->select('*');
    $this->db->from('vulkanisir');
    $this->db->where('vulkanisir.kd_vulk', $kd);
    $this->db->join('detail_vulk', 'detail_vulk.kd_vulk = vulkanisir.kd_vulk');
    $this->db->join('toko', 'toko.id_toko = vulkanisir.tempat_vulk');
    $query = $this->db->get()->result_array();
    return $query;
  }

  public function updateDetailData($data)
  {
    $this->db->update_batch('detail_vulk', $data, 'no_seri_vulk');
  }
}
