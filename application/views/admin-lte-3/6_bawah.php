        <script type="text/javascript">
            $(function () {
                <?php echo $this->session->flashdata('master_toast'); ?>
                <?php echo $this->session->flashdata('medcheck_toast'); ?>
                <?php echo $this->session->flashdata('transaksi_toast'); ?>
                <?php echo $this->session->flashdata('pos_toast'); ?>
                <?php echo $this->session->flashdata('sdm_toast'); ?>
                <?php echo $this->session->flashdata('gudang_toast'); ?>
                <?php echo $this->session->flashdata('laporan_toast'); ?>
            });
        </script>
    </body>
</html>