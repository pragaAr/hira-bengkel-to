<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between flex-wrap">
          <h4 class="m-0 font-weight-bold">
            <?= $title ?>
          </h4>
          <div class="btn-group">
            <a href="<?= base_url('oper_ban') ?>" class="btn btn-sm btn-dark mb-2">
              <i class="fas fa-arrow-left fa-sm"></i>
              Kembali
            </a>
          </div>

        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="allPakaiBanTables" width="100%" cellspacing="0">
              <thead class="text-center">
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Kd Pakai</th>
                  <th scope="col">Truck</th>
                  <th scope="col">Seri/Merk/Ukuran</th>
                  <th scope="col">Qty</th>
                  <th scope="col">Status</th>
                  <th scope="col">Ket</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody style="font-size:13px;">

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>
        &copy; <?= date('Y') ?>
        Dibuat Dengan
      </span>
      <i class="fas fa-heart text-danger"></i>
      <a target="_blank" href="https://hira-express.com">PT. Hira Adya Naranata</a>
      Hak cipta di lindungi
      <div class="bullet"></div>
    </div>
  </div>
</footer>
</div>
</div>

<!-- Modal Oper -->
<div class="modal fade" id="operBanModal" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title text-dark">Form Oper Ban</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="font-weight-bold" id="subtitle"></p>
        <small class="font-weight-bold text-danger">--Jumlah yang dioper tidak bisa melebihi jumlah yang dipakai</small>
        <hr>
        <form action="<?= base_url('oper_ban/oper') ?>" method="post">
          <div class="form-row">
            <div class="form-group col-lg-4 col-md-4">
              <label class="font-weight-bold" for="noseri">No Seri</label>
              <input type="text" class="form-control text-uppercase" id="kdpakai" name="kdpakai" readonly>
              <input type="hidden" class="form-control" id="detailpakai_id" name="detailpakai_id" readonly>
              <input type="hidden" class="form-control" id="asal" name="asal" readonly>
              <input type="hidden" class="form-control" id="asalid" name="asalid" readonly>
              <input type="hidden" class="form-control" id="operbanid" name="operbanid" readonly>
              <input type="text" class="form-control" id="totpakai" name="totpakai" readonly>
              <input type="hidden" class="form-control" id="noseri" name="noseri" readonly>
              <input type="hidden" class="form-control" id="banid" name="banid" readonly>
            </div>
            <div class="form-group col-lg-4 col-md-4">
              <label class="font-weight-bold" for="merk">Merk</label>
              <input type="text" class="form-control" id="merk" name="merk" readonly>
              <input type="hidden" class="form-control" id="merkid" name="merkid" readonly>
            </div>
            <div class="form-group col-lg-4 col-md-4">
              <label class="font-weight-bold" for="jml">Jumlah Pakai</label>
              <input type="number" class="form-control" id="jml" name="jml" readonly required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-6 col-md-6">
              <label class="font-weight-bold" for="tujuanid">Oper Ke</label>
              <select name="tujuanid" id="tujuanid" class="form-control selecttruck" required>
                <option value=""></option>

              </select>
              <input type="hidden" class="form-control" id="tujuan" name="tujuan" readonly>
            </div>
            <div class="form-group col-lg-6 col-md-6">
              <label class="font-weight-bold" for="jmloper">Jumlah Oper</label>
              <input type="number" class="form-control" id="jmloper" name="jmloper" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-6 col-md-6">
              <label class="font-weight-bold" for="montir">Montir</label>
              <input type="text" class="form-control text-capitalize" id="montir" name="montir" required>
            </div>
            <div class="form-group col-lg-6 col-md-6">
              <label class="font-weight-bold" for="ket">Keterangan</label>
              <input type="text" class="form-control text-capitalize" id="ket" name="ket" required>
            </div>
          </div>
          <div class="text-right">
            <button type="submit" class="btn btn-primary" style="border:1px solid white">Oper</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<script src="<?= base_url('public/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('public/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="<?= base_url('public/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<script src="<?= base_url('public/') ?>vendor/datatables/jquery.dataTables.min.js"></script>

<script src="<?= base_url('public/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script src="<?= base_url('public/') ?>vendor/select2/select2-full.min.js"></script>

<script src="<?= base_url('public/') ?>vendor/sweetalert2/sweetalert2.all.min.js"></script>

<script src="<?= base_url('public/') ?>js/sb-admin-2.min.js"></script>

<script src="<?= base_url('public/') ?>js/pages/trans/ban/oper/pakai-oper.js"></script>

<script src="<?= base_url('public/') ?>js/pages/main/jam.js"></script>

</body>

</html>