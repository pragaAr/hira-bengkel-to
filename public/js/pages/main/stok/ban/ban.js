$.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
  return {
    iStart: oSettings._iDisplayStart,
    iEnd: oSettings.fnDisplayEnd(),
    iLength: oSettings._iDisplayLength,
    iTotal: oSettings.fnRecordsTotal(),
    iFilteredTotal: oSettings.fnRecordsDisplay(),
    iPage: Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
    iTotalPages: Math.ceil(
      oSettings.fnRecordsDisplay() / oSettings._iDisplayLength
    ),
  };
};

$('#banTables').DataTable({
  ordering: true,
  pageLength: 10,
  initComplete: function () {
    var api = this.api();
    $('#banTables_filter input')
      .off('.DT')
      .on('input.DT', function () {
        api.search(this.value).draw();
      });
  },
  lengthChange: false,
  autoWidth: false,
  processing: true,
  serverSide: true,
  ajax: {
    url: 'http://localhost/he/ban/getBan',
    type: 'POST',
    dataType: 'json',
  },
  columns: [
    {
      data: 'id_ban',
      className: 'text-center',
    },
    {
      data: 'no_seri',
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: 'nama_merk',
      render: function (data, type, row) {
        return data.toUpperCase() + ' - ' + row.ukuran_ban;
      },
    },
    {
      data: 'jml_ban',
      className: 'text-center',
      render: function (data, type, row) {
        return data;
      },
    },
    {
      data: 'vulk',
      className: 'text-center',
      render: function (data, type, row) {
        return data == 0
          ? '<button type="button" class="btn btn-sm btn-dark" disabled>Ori</button>'
          : '<button type="button" class="btn btn-sm btn-primary" disabled>Vulk</button>';
      },
    },
    {
      data: 'status_ban',
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: 'date_ban_add',
      className: 'text-center',
      render: function (data, type, row) {
        var date = new Date(data);
        return date.toLocaleDateString('id-ID', {
          day: '2-digit',
          month: '2-digit',
          year: 'numeric',
        });
      },
    },
    {
      data: 'view',
      className: 'text-center',
    },
  ],

  fnDrawCallback: function (oSettings) {
    $('[data-toggle="tooltip"]').tooltip();
  },

  rowCallback: function (row, data, iDisplayIndex) {
    var info = this.fnPagingInfo();
    var page = info.iPage;
    var length = info.iLength;
    var index = page * length + (iDisplayIndex + 1);
    $('td:eq(0)', row).html(index + '.');
  },
});

$('#vulkBan').on('shown.bs.modal', function () {
  $('.selectaksi').select2({
    placeholder: 'Pilih Aksi',
    theme: 'bootstrap4',
  });
});

$('#banTables').on('click', '.btn-ubah-kondisi-ban', function (e) {
  const seri = $(this).data('seri');

  $.ajax({
    url: 'http://localhost/he/ban/getId',
    type: 'POST',
    data: {
      noseri: seri,
    },
    success: function (data) {
      const parsedata = JSON.parse(data);

      $('#no_seri').val(parsedata.no_seri);
      $('#nama_merk').val(parsedata.nama_merk);
      $('#jml_ban').val(parsedata.jml_ban);
      $('#ukuran_ban').val(parsedata.ukuran_ban);

      if (parsedata.vulk == 1) {
        $('#vulk').val('Original');
      } else {
        $('#vulk').val('Vulkanisir');
      }

      $('#vulkBan').modal('show');
      $('[data-toggle="tooltip"]').tooltip('hide');
    },
  });
});

$('#form_vulkBan').on('submit', function () {
  const seri = $('#no_seri').val();
  const aksi = $('#aksi').val();

  $.ajax({
    type: 'POST',
    url: 'http://localhost/he/ban/ubahKondisi',
    data: {
      seri: seri,
      aksi: aksi,
    },
    success: function (data) {
      $('#aksi').val(null).trigger('change');
      $('#no_seri').val('');
      $('#nama_merk').val('');
      $('#jml_ban').val('');
      $('#ukuran_ban').val('');

      $('#vulkBan').modal('hide');

      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Kondisi Ban berhasil diubah, silahkan cek Menu Movement',
      });
      $('#banTables').DataTable().ajax.reload(null, false);
    },
  });

  return false;
});

$(document).on('select2:open', () => {
  document
    .querySelector('.select2-container--open .select2-search__field')
    .focus();
});
