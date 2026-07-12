{{-- resources/views/layouts/scripts.blade.php --}}
{{-- FIX: Ganti Bootstrap alert biasa dengan SweetAlert2 --}}
{{-- SweetAlert2 sudah didaftarkan di config/adminlte.php (Sweetalert2 plugin active: true) --}}

<script>
$(function () {
    // tooltip bawaan Bootstrap
    $('[data-toggle="tooltip"]').tooltip();

    // ========================================================
    // FIX: SweetAlert2 — tampil otomatis saat ada flash message
    // ========================================================

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ addslashes(session("success")) }}',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ addslashes(session("error")) }}',
        confirmButtonText: 'OK',
        confirmButtonColor: '#e74c3c',
    });
    @endif

    @if(session('warning'))
    Swal.fire({
        icon: 'warning',
        title: 'Perhatian!',
        text: '{{ addslashes(session("warning")) }}',
        confirmButtonText: 'OK',
        confirmButtonColor: '#f39c12',
    });
    @endif

    @if(session('info'))
    Swal.fire({
        icon: 'info',
        title: 'Info',
        text: '{{ addslashes(session("info")) }}',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
    });
    @endif

    // ========================================================
    // SweetAlert2 — konfirmasi hapus / aksi berbahaya
    // Cara pakai di blade:
    //   <button class="btn btn-danger swal-confirm"
    //           data-title="Hapus Data?"
    //           data-text="Data yang dihapus tidak bisa dikembalikan."
    //           data-form="#form-hapus-1">
    // ========================================================
    $(document).on('click', '.swal-confirm', function (e) {
        e.preventDefault();
        const title   = $(this).data('title') || 'Yakin?';
        const text    = $(this).data('text')  || 'Tindakan ini tidak bisa dibatalkan.';
        const formId  = $(this).data('form');
        const href    = $(this).attr('href');

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor:  '#6c757d',
            confirmButtonText: 'Ya, lanjutkan!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                if (formId) {
                    $(formId).submit();
                } else if (href) {
                    window.location.href = href;
                }
            }
        });
    });

    // ========================================================
    // SweetAlert2 — update status kontrol tanpa reload halaman
    // (opsional: uncomment jika ingin AJAX status update)
    // ========================================================
    // $('form[data-status-form]').on('submit', function (e) {
    //     e.preventDefault();
    //     // ... AJAX call
    // });
});
</script>
