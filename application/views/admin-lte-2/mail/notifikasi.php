<?php if (!empty($barang)) { ?>
<html>
    <body>
        <h1>Notifikasi barang limit</h1>
        <hr/>
        
        <table border="1" cellspacing="0" width="600px">
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Produk</th>
                <th>Jml</th>
            </tr>
            <?php $no = 1 ?>         
            <?php foreach ($barang as $brg) { ?>
                <?php $sql_jml = $this->db->select_sum('stok')->where('id_produk', $brg->id)->get('tbl_m_produk_stok')->row() ?>
                <?php if ($sql_jml->stok <= $limit) { ?>
                    <tr>
                        <td style="text-align: center; vertical-align: middle;"><?php echo $no++ ?></td>
                        <td style="text-align: left; vertical-align: middle;"><?php echo nbs(2) . $brg->kode ?></td>
                        <td style="text-align: left; vertical-align: middle;"><?php echo nbs(2) . $brg->produk ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?php echo nbs(2) . $sql_jml->stok ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
    </body>
</html>
<?php } ?>