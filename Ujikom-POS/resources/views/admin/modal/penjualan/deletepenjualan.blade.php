<script src="{{ URL::asset('js/jquery-3.7.1.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // SweetAlert confirmation
        $('.deleteSwal').click(function() {
            var current_object = $(this);
            var id_transaksi = current_object.data('idtransaksi');
            var action = current_object.data('action');

            Swal.fire({
                title: 'Yakin Untuk Menghapus Data ini ?',
                icon: 'warning',
                iconColor: 'red',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus Data!'
            }).then((result) => {
                if (result.isConfirmed) {// Membuat form untuk mengirim data
                    var form = $('<form>', {
                        'method': 'POST',
                        'action': action,
                        'style': 'display: none;'
                    });

                    // Menambahkan direktif Blade @csrf untuk memasukkan token CSRF
                    form.append('@csrf');

                    // Menambahkan input dengan nama "id" untuk mengirim ID data yang akan dihapus
                    form.append($('<input>', {
                        'name': 'id_deletepenjualan',
                        'value': id_transaksi,
                        'type': 'hidden'
                    }));

                    // Menambahkan form ke body dokumen dan mensubmit secara otomatis
                    $('body').append(form);
                    form.submit();
                } else {
                    swal("Your data is safe!");
                }

            });
        });
    });
</script>
