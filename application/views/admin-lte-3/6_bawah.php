        <script type="text/javascript">
            $(function () {
                <?php echo $this->session->flashdata('master_toast'); ?>
                <?php echo $this->session->flashdata('medcheck_toast'); ?>
                <?php echo $this->session->flashdata('trans_toast'); ?>
                <?php echo $this->session->flashdata('apt_toast'); ?>
                <?php echo $this->session->flashdata('sdm_toast'); ?>
                <?php echo $this->session->flashdata('gd_toast'); ?>
                <?php echo $this->session->flashdata('lap_toast'); ?>
                <?php echo $this->session->flashdata('sett_toast'); ?>
                <?php echo $this->session->flashdata('login_toast'); ?>
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
            
            <?php if (akses::hakGudang() == TRUE OR akses::hakAdmin() == TRUE) { ?>
                function checkMutasiNotifications() {
                    $.getJSON("<?= base_url('notification/notif_gudang') ?>", function(response) {
                        if (response.status && response.total > 0) {
                            // Loop through each notification
                            response.data.forEach(function(item) {
                                toastr.info(
                                    item.message + '<br/>' +
                                    '<small>Oleh: ' + item.user + '</small>',
                                    'Mutasi #' + item.nomer
                                );
                            });
                        }
                    }).fail(function() {
                        console.log("Failed to check notifications");
                    });
                }

                    // Set interval to check for notifications every 30 seconds (30000 ms)
                setInterval(checkMutasiNotifications, 30000);
            <?php } ?>

            
            // Update date and time every second (1000 ms)
            setInterval(updateDateTime, 1000);



            function updateDateTime() {
                fetch('<?= base_url("home/tanggal") ?>')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('tanggal-waktu').innerHTML = '<i class="far fa-calendar-alt mr-1"></i> ' + data.datetime;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching date time:', error);
                    });
            }

            setInterval(updateDateTime, 1000);
            updateDateTime(); // muat awal
        </script>
    </body>
</html>