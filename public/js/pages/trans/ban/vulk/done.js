$(document).ready(function () {
	$("tfoot").hide();

	$(function () {
		$("#biaya").on("keydown keyup click change blur", function (e) {
			$(this).val(format($(this).val()));
		});
	});

	$(".selectpay").select2({
		placeholder: "Pilih Pembayaran",
		theme: "bootstrap4",
		minimumResultsForSearch: Infinity,
	});

	$(".selectban").select2({
		placeholder: "Pilih Ban",
		theme: "bootstrap4",
	});

	$(".selecttoko")
		.select2({
			placeholder: "Pilih Toko",
			theme: "bootstrap4",
			ajax: {
				url: "http://localhost/he/toko/getListToko",
				dataType: "json",
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
			},
		})
		.on("select2:select", function (e) {
			const data = e.params.data;

			$("#toko").val(data.text);
			const tempat = $("#tempat").val();

			$.ajax({
				url: "http://localhost/he/vulkanisir/getDataByTempat",
				type: "POST",
				dataType: "json",
				data: {
					tempat: tempat,
				},
				success: function (data) {
					if (data.length == 0) {
						$("#banid").empty().prop("disabled", true);

						reset();
					} else {
						let html = "";
						for (let count = 0; count < data.length; count++) {
							html +=
								'<option value="' +
								data[count].no_seri_vulk +
								'">' +
								data[count].no_seri_vulk +
								"</option>";
						}
						$("#biaya").focus();
						$("#banid").empty();
						$("#banid").prop("disabled", false);
						$("#banid").append(
							`<option value="" selected disabled>Pilih Ban</option>`
						);

						$("#banid").append(html);
					}
				},
			});
		});

	$("#banid").on("select2:select", function () {
		$.ajax({
			url: "http://localhost/he/vulkanisir/getDataBan",
			type: "POST",
			dataType: "json",
			data: {
				seri: $(this).val(),
			},
			success: function (data) {
				$("#merk").val(data.merk_vulk);
				$("#kdvulk").val(data.kd_vulk);
				$("#size").val(data.ukuran_ban_vulk);
				$("#jml").val(data.jml_vulk);
				$("button#tambah").prop("disabled", false);
			},
		});
	});

	$(document).on("click", "#tambah", function (e) {
		const cart = {
			seri: $("#banid").val(),
			merk: $("#merk").val(),
			size: $("#size").val(),
			jml: $("#jml").val(),
		};

		$.ajax({
			url: "http://localhost/he/vulkanisir/cartselesai",
			type: "POST",
			data: cart,
			success: function (data) {
				reset();

				$("table#cart-selesai tbody").append(data);
				$("#totalban").html("<p>" + hitung_totalban() + "</p>");
				$('input[name="totalban_hidden"]').val(hitung_totalban());

				$("tfoot").show();
			},
		});
	});

	$(document).on("click", "#tombol-hapus", function () {
		$(this).closest(".cart-selesai").remove();

		$("#totalban").html("<p>" + hitung_totalban() + "</p>");
		$('input[name="totalban_hidden"]').val(hitung_totalban());

		if ($("tbody").children().length == 0) $("tfoot").hide();
	});

	$('button[type="submit"]').on("click", function () {
		$("#toko").prop("readonly", true);
	});

	function hitung_totalban() {
		let totalban = 0;
		$(".jml").each(function () {
			totalban += parseFloat($(this).text());
		});
		return totalban;
	}

	function reset() {
		$("#banid").val(null).trigger("change");
		$("#merk").val("");
		$("#size").val("");
		$("#jml").val("");
		$("button#tambah").prop("disabled", true);
	}

	$(document).on("select2:open", () => {
		document
			.querySelector(".select2-container--open .select2-search__field")
			.focus();
	});
});
