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

$('#stokTables').DataTable({
  ordering: false,
  language: {
    searchPlaceholder: 'Search Part',
  },
  initComplete: function () {
    var api = this.api();
    $('#stokTables_filter input')
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
    url: 'http://localhost/he/stok/getStok',
    type: 'POST',
    dataType: 'json',
  },
  columns: [
    {
      data: 'id_part',
      className: 'text-center',
      searchable: false,
    },
    {
      data: 'jenis_part',
      searchable: true,
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: 'nama_merk',
      className: 'text-center',
      searchable: false,
      render: function (data, type, row) {
        return data === null
          ? '<i class="fas fa-minus fa-sm"></i>'
          : data.toUpperCase();
      },
    },
    {
      data: 'sat',
      className: 'text-center',
      searchable: false,
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: 'part_baru',
      className: 'text-center',
      searchable: false,
      render: function (data, type, row) {
        return data;
      },
    },
    {
      data: 'part_bekas',
      className: 'text-center',
      searchable: false,
      render: function (data, type, row) {
        return data;
      },
    },
    {
      data: 'jml',
      className: 'text-center',
      searchable: false,
      render: function (data, type, row) {
        return data;
      },
    },
    {
      data: 'rak',
      className: 'text-center',
      searchable: false,
      render: function (data, type, row) {
        return data === '' || data === ' '
          ? '<i class="fas fa-minus fa-sm"></i>'
          : data.toUpperCase();
      },
    },
    {
      data: 'part_in',
      searchable: false,
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

$('#btn-add-stok').on('click', function () {
  $('#addStok').modal('show');
});

$('#addStok').on('shown.bs.modal', function () {
  $('input[name="nama"]').focus();

  $('.selectmerk').select2({
    placeholder: 'Pilih Merk',
    theme: 'bootstrap4',
    ajax: {
      url: 'http://localhost/he/merk/getDataMerk',
      dataType: 'JSON',
      delay: 250,
      data: function (params) {
        return {
          q: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: data,
        };
      },
      cache: true,
    },
  });
});

$('#form_addStok').on('submit', function () {
  const nama = $('#nama').val();
  const merk = $('#merk').val();
  const baru = $('#baru').val();
  const bekas = $('#bekas').val();
  const satuan = $('#satuan').val();
  const rak = $('#rak').val();

  $.ajax({
    url: 'http://localhost/he/stok/create',
    type: 'POST',
    data: {
      nama: nama,
      merk: merk,
      baru: baru,
      bekas: bekas,
      satuan: satuan,
      rak: rak,
    },
    success: function (data) {
      $('#nama').val('');
      $('#merk').val(null).trigger('change');
      $('#baru').val(0);
      $('#bekas').val(0);
      $('#satuan').val('');
      $('#rak').val('');
      $('#addStok').modal('hide');

      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Data Stok berhasil ditambah!',
      });
      $('#stokTables').DataTable().ajax.reload(null, false);
    },
  });
  return false;
});

$('#editStok').on('shown.bs.modal', function () {
  $('input[name="namaedit"]').focus();

  $('.selectmerkedit').select2({
    placeholder: 'Pilih Merk',
    theme: 'bootstrap4',
    ajax: {
      url: 'http://localhost/he/merk/getDataMerk',
      dataType: 'JSON',
      delay: 250,
      data: function (params) {
        return {
          q: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: data,
        };
      },
      cache: true,
    },
  });
});

$('#stokTables').on('click', '.btn-edit-stok', function (e) {
  const id = $(this).data('id');

  $.ajax({
    url: 'http://localhost/he/stok/getId',
    type: 'POST',
    data: {
      idstok: id,
    },
    success: function (data) {
      const parsedata = JSON.parse(data);
      const datamerk = parsedata.merk_id;

      $.ajax({
        url: 'http://localhost/he/merk/getDataMerk',
        type: 'GET',
        dataType: 'json',
        success: function (merkdata) {
          const selectmerkedit = $('.selectmerkedit').select2({
            data: merkdata,
          });

          $.each(merkdata, function (i, merk) {
            if (merk.id === datamerk) {
              selectmerkedit.val(merk.id).trigger('change');
              return false;
            }
          });
        },
      });

      $('#idstok').val(parsedata.id_part);
      $('#namaedit').val(parsedata.jenis_part);
      $('#baruedit').val(parsedata.part_baru);
      $('#bekasedit').val(parsedata.part_bekas);
      $('#satuanedit').val(parsedata.sat);
      $('#rakedit').val(parsedata.rak);

      $('#editStok').modal('show');
      $('[data-toggle="tooltip"]').tooltip('hide');
    },
  });
});

$('#form_editStok').on('submit', function () {
  const id = $('#idstok').val();
  const nama = $('#namaedit').val();
  const merk = $('#merkedit').val();
  const baru = $('#baruedit').val();
  const bekas = $('#bekasedit').val();
  const satuan = $('#satuanedit').val();
  const rak = $('#rakedit').val();

  $.ajax({
    type: 'POST',
    url: 'http://localhost/he/stok/update',
    data: {
      id: id,
      nama: nama,
      merk: merk,
      baru: baru,
      bekas: bekas,
      satuan: satuan,
      rak: rak,
    },
    success: function (data) {
      $('#idstok').val('');
      $('#namaedit').val('');
      $('#merkedit').val(null).trigger('change');
      $('#baruedit').val(0);
      $('#bekasedit').val(0);
      $('#satuanedit').val('');
      $('#rakedit').val('');
      $('#editStok').modal('hide');

      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Data Stok berhasil diubah!',
      });
      $('#stokTables').DataTable().ajax.reload(null, false);
    },
  });
  return false;
});

$('#stokTables').on('click', '.btn-delete-stok', function () {
  const id = $(this).data('id');
  Swal.fire({
    title: 'Apakah anda yakin ?',
    text: 'Data akan di hapus !!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Batal',
    confirmButtonText: 'Ya, Hapus !',
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: 'http://localhost/he/stok/delete',
        method: 'POST',
        data: { idstok: id },
        success: function (data) {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Data Stok berhasil dihapus!',
          });
          $('#stokTables').DataTable().ajax.reload(null, false);
        },
      });
    }
  });
});

$(document).on('select2:open', () => {
  document
    .querySelector('.select2-container--open .select2-search__field')
    .focus();
});
