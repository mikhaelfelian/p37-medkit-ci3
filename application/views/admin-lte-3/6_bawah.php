        <script type="text/javascript">
            $(function () {
                <?php echo $this->session->flashdata('master_toast'); ?>
                <?php echo $this->session->flashdata('medcheck_toast'); ?>
                <?php echo $this->session->flashdata('trans_toast'); ?>
                <?php echo $this->session->flashdata('apt_toast'); ?>
                <?php echo $this->session->flashdata('sdm_toast'); ?>
                <?php echo $this->session->flashdata('gd_toast'); ?>
                <?php echo $this->session->flashdata('lap_toast'); ?>
            });


            function refreshCsrfToken() {
                $.getJSON("<?= base_url('csrf/refresh') ?>", function(data) {
                    // Perbarui nilai token pada semua form yang memiliki CSRF hidden input
                    $("input[name='" + data.name + "']").val(data.token);
                    
                    // Tampilkan notifikasi menggunakan Toastr
                    // toastr.success("CSRF Token berhasil diperbarui!", "Token Refreshed");
                }).fail(function() {
                    // toastr.error("Gagal memperbarui CSRF Token!", "Error");
                });
            }

            // Setiap 2 menit (120000 ms), refresh token CSRF otomatis
            setInterval(refreshCsrfToken, 120000);
        </script>
    </body>
</html>