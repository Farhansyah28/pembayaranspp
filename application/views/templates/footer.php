<!-- Flowbite JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

<!-- Global Notifications Engine -->
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: '#ffffff',
        color: '#1f2937',
        showClass: {
            popup: 'animate__animated animate__fadeInRight animate__faster'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutRight animate__faster'
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    <?php if ($this->session->flashdata('success')): ?>
        Toast.fire({
            icon: 'success',
            title: '<?= addslashes($this->session->flashdata('success')) ?>'
        });
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        Toast.fire({
            icon: 'error',
            title: '<?= addslashes($this->session->flashdata('error')) ?>'
        });
    <?php endif; ?>

    <?php if ($this->session->flashdata('info')): ?>
        Toast.fire({
            icon: 'info',
            title: '<?= addslashes($this->session->flashdata('info')) ?>'
        });
    <?php endif; ?>

    <?php if ($this->session->flashdata('warning')): ?>
        Toast.fire({
            icon: 'warning',
            title: '<?= addslashes($this->session->flashdata('warning')) ?>'
        });
    <?php endif; ?>

    // Global Confirmation Handler
    document.addEventListener('click', function (e) {
        const target = e.target.closest('.confirm-action');
        if (target) {
            e.preventDefault();
            const url = target.getAttribute('href');
            const title = target.getAttribute('data-title') || 'Apakah Anda yakin?';
            const text = target.getAttribute('data-text') || 'Tindakan ini tidak dapat dibatalkan.';
            const icon = target.getAttribute('data-icon') || 'warning';
            const confirmText = target.getAttribute('data-confirm-text') || 'Ya, Lanjutkan!';

            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none transition animate__animated animate__fadeInUp animate__faster',
                    cancelButton: 'text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 transition animate__animated animate__fadeInUp animate__faster',
                    popup: 'rounded-2xl shadow-2xl border-none',
                    title: 'text-xl font-bold text-gray-900',
                    htmlContainer: 'text-gray-600'
                },
                reverseButtons: true,
                showClass: {
                    popup: 'animate__animated animate__zoomIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    });
</script>
</body>

</html>