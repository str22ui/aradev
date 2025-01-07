{{-- Struktur footer untuk blade templating --}}
<footer>
	<div class="footer clearfix mb-0 text-muted">
		<div class="float-start">
			<p>{{ date('Y') }} &copy; Aradev Copyright</p>
		</div>
		<div class="float-end">
			<p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a href="#">Aradev Copyright</a></p>
		</div>
	</div>
</footer>
</div>
</div>

@stack('modal')

<script src="{{ asset('vendors/jquery/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('vendors/apexcharts/apexcharts.js') }}"></script>

<script src="{{ asset('vendors/toastify/toastify.js') }}"></script>

<script src="{{ asset('vendors/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/datatable/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
<script src="{{ asset('vendors/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/flatpickr/id.js') }}"></script>
<script src="/ckeditor/ckeditor.js"></script>
<script>
	$(function () {
		$(".select2").select2();

		$("input[type=date]").flatpickr({
			dateFormat: "Y-m-d",
			locale: "id",
		});

		$.extend(true, $.fn.dataTable.defaults, {
			language: {
				url: "{{ asset('vendors/datatable/plugins/id.json') }}",
			},
			"pageLength": 5,
			"lengthMenu": [[5, 20, 25, 50, -1], [5, 20, 25, 50, 'All']]
		});

		$("#datatable").on('click', '.delete-notification', function (e) {
			e.preventDefault();
			Swal.fire({
				title: "Hapus?",
				text: "Data tersebut akan dihapus!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				cancelButtonText: "Tidak",
				confirmButtonText: "Ya!",
				reverseButtons: true,
			}).then((result) => {
				if (result.isConfirmed) {
					$(this).parent().submit();
				}
			});
		});

		$("#datatable").on('click', '.restore-button', function (e) {
			e.preventDefault();
			Swal.fire({
				title: "Kembalikan?",
				text: "Data yang dipilih akan dikembalikan",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				cancelButtonText: "Tidak",
				confirmButtonText: "Ya!",
				reverseButtons: true,
			}).then((result) => {
				if (result.isConfirmed) {
					$(this).parent().submit();
				}
			});
		});

		$("#datatable").on('click', '.delete-permanent-button', function (e) {
			e.preventDefault();
			Swal.fire({
				title: "Hapus permanen?",
				text: "Data yang dipilih tidak akan bisa dikembalikan lagi!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				cancelButtonText: "Tidak",
				confirmButtonText: "Ya!",
				reverseButtons: true,
			}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire({
						title: "Yakin?",
						text: "Anda yakin ingin menghapus data tersebut?",
						icon: "warning",
						showCancelButton: true,
						confirmButtonColor: "#3085d6",
						cancelButtonColor: "#d33",
						cancelButtonText: "Tidak",
						confirmButtonText: "Ya!",
						reverseButtons: true
					}).then((result) => {
						if (result.isConfirmed) {
							$(this).parent().submit();
						}
					});
				}
			});
		});

		$('#logout').click(function (e) {
			e.preventDefault();
			Swal.fire({
				title: "Logout?",
				text: "Anda akan keluar dari aplikasi.",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				cancelButtonText: "Tidak",
				confirmButtonText: "Ya!",
				reverseButtons: true,
			}).then((result) => {
				if (result.isConfirmed) {
					$(this).submit();
				}
			})
		});
	});

    function toggleMonthYearDropdown() {
        var exportOption = document.getElementById('exportOption').value;
        var monthYearDropdown = document.getElementById('monthYearDropdown');
        if (exportOption == 'month_year') {
            monthYearDropdown.style.display = 'block';
        } else {
            monthYearDropdown.style.display = 'none';
        }
    }
//     function removeImage(button, imagePath) {
//     if (confirm('Yakin ingin menghapus gambar ini?')) {
//         fetch('/admin/perumahan/remove-image', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//             },
//             body: JSON.stringify({ image: imagePath })
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 button.parentElement.remove();
//             } else {
//                 alert('Gagal menghapus gambar!');
//             }
//         })
//         .catch(error => console.error('Error:', error));
//     }
// }

fetch('/admin/perumahan/remove-image', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    body: JSON.stringify({ image: imagePath }),
})
    .then(response => {
        console.log('HTTP Response:', response); // Periksa status HTTP
        return response.json();
    })
    .then(data => {
        console.log('Response Data:', data); // Log respon JSON dari server
        if (data.success) {
            button.parentElement.remove(); // Hapus dari tampilan
        } else {
            alert(data.message || 'Gagal menghapus gambar!');
        }
    })
    .catch(error => console.error('Error:', error));


    function removeInput(button) {
    button.parentElement.remove(); // Menghapus elemen induk (input + tombol)
}
// function formatHarga(input) {
//     // Menghapus semua karakter yang bukan angka
//     let value = input.value.replace(/\D/g, '');

//     // Menambahkan titik pada 3 digit terakhir
//     if (value.length > 3) {
//         const lastThreeDigits = value.slice(-3);
//         const otherDigits = value.slice(0, -3);
//         value = otherDigits + '.' + lastThreeDigits;
//     }

//     // Mengupdate nilai input
//     input.value = value;
// }
function formatHarga(input) {
    // Menghapus semua karakter yang bukan angka
    let value = input.value.replace(/\D/g, '');

    // Memformat angka dengan menambahkan titik setiap 3 digit
    let formattedValue = '';
    for (let i = 0; i < value.length; i++) {
        // Tambahkan titik setiap 3 digit dari belakang
        if (i > 0 && (value.length - i) % 3 === 0) {
            formattedValue += '.';
        }
        formattedValue += value[i];
    }

    // Mengupdate nilai input
    input.value = formattedValue;
}
</script>

@stack('js')

{{-- @include('utilities.toastify-flash-message') --}}

</body>

</html>
