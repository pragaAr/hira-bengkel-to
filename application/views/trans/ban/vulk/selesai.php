<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between flex-wrap">
          <h4 class="m-0 font-weight-bold">
            <?= $title ?>
          </h4>
          <div class="btn-group">
            <a href="<?= base_url('vulkanisir') ?>" class="btn btn-sm btn-dark mb-2">
              <i class="fas fa-arrow-left fa-sm"></i>
              Kembali
            </a>
          </div>

        </div>
        <div class="card-body">
          <h6 class="text-danger font-weight-bold mb-3">
            <em>--Harap teliti dalam menginput data--</em>
          </h6>
          <hr>
          <form action="<?= base_url('vulkanisir/prosesselesai') ?>" method="POST">

            <div class="form-row">
              <div class="form-group col-lg-3 col-md-3">
                <label class="font-weight-bold" for="nota">No Nota</label>
                <input type="text" name="nota" id="nota" class="form-control text-uppercase" autofocus required>
              </div>
              <div class="form-group col-lg-3 col-md-3">
                <label class="font-weight-bold" for="tempat">Tempat</label>
                <select name="tempat" id="tempat" class="form-control selecttoko" style="width:100%" required>
                  <option value=""></option>

                </select>
                <input type="hidden" name="toko" id="toko" class="form-control" readonly>
              </div>
              <div class="form-group col-lg-3 col-md-3">
                <label class="font-weight-bold" for="biaya">Biaya</label>
                <input type="text" name="biaya" id="biaya" class="form-control" required>
              </div>
              <div class="form-group col-lg-3 col-md-3">
                <label class="font-weight-bold" for="pay">Pembayaran</label>
                <select name="pay" id="pay" class="form-control selectpay" style="width:100%" required>
                  <option value=""></option>
                  <option value="Cash">Cash</option>
                  <option value="Tempo">Tempo</option>
                </select>
              </div>
            </div>

            <h5>Data Ban</h5>
            <hr>

            <div class="form-row">
              <div class="form-group col-lg-3 col-md-3">
                <label class="font-weight-bold" for="banid">No Seri</label>
                <select name="banid" id="banid" class="form-control selectban" style="width:100%" disabled>
                  <option value=""></option>

                </select>
              </div>
              <div class="form-group col-lg-3 col-md-3">
                <label class="font-weight-bold" for="merk">Merk</label>
                <input type="text" name="merk" id="merk" class="form-control" readonly>
                <input type="hidden" name="kdvulk" id="kdvulk" class="form-control" readonly>
              </div>
              <div class="form-group col-lg-3 col-md-3">
                <label class="font-weight-bold" for="size">Ukuran</label>
                <input type="text" name="size" id="size" class="form-control" readonly>
              </div>
              <div class="form-group col-lg-3 col-md-3">
                <label class="font-weight-bold" for="jml">Jumlah</label>
                <input type="number" name="jml" id="jml" class="form-control" readonly>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md">
                <button disabled type="button" class="btn btn-primary btn-block" id="tambah" style="border:1px solid white">
                  <i class="fa fa-plus"></i>
                  Tambah
                </button>
              </div>
            </div>

            <div class="mt-4">
              <h5>Data Vulkanisir Selesai</h5>
              <hr>
              <div class="table-responsive">
                <table class="table table-bordered" id="cart-selesai">
                  <thead class="text-center" class="font-weight-bold">
                    <tr>
                      <th scope="col">No Seri</th>
                      <th scope="col">Merk</th>
                      <th scope="col">Ukuran</th>
                      <th scope="col">Qty</th>
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot class="text-center">
                    <tr>
                      <td colspan="3">
                        <h5 class="font-weight-bold">Total Ban Selesai Vulkanisir : </h5>
                      </td>
                      <td>
                        <h5 class="font-weight-bold text-danger" id="totalban"></h5>
                      </td>
                      <td>
                        <input type="hidden" name="totalban_hidden" value="">
                        <button type="submit" class="btn btn-success" data-toggle="tooltip" title="Simpan">
                          <i class="fa fa-save"></i>
                        </button>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </form>
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

<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<script src="<?= base_url('public/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('public/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="<?= base_url('public/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<script src="<?= base_url('public/') ?>vendor/select2/select2-full.min.js"></script>

<script src="<?= base_url('public/') ?>vendor/sweetalert2/sweetalert2.all.min.js"></script>

<script src="<?= base_url('public/') ?>js/sb-admin-2.min.js"></script>

<script src="<?= base_url('public/') ?>js/pages/main/format.js"></script>

<script src="<?= base_url('public/') ?>js/pages/trans/ban/vulk/done.js"></script>

<script src="<?= base_url('public/') ?>js/pages/main/jam.js"></script>

</body>

</html>