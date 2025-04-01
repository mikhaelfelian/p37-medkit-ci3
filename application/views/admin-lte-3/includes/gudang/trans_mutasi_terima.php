<?php $hasError = $this->session->flashdata('form_error'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">MUTASI STOK</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('gudang/index.php') ?>">Gudang</a></li>
                        <li class="breadcrumb-item active">Mutasi Stok Detail</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-download"></i> Penerimaan</h3>
                        </div>
                        <div class="card-body">
                            <?php echo $this->session->flashdata('gudang') ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>No. Mutasi</th>
                                    <th>:</th>
                                    <td><?php echo $sql_penj->no_nota ?></td>

                                    <th>Petugas</th>
                                    <th>:</th>
                                    <td><?php echo strtoupper($this->ion_auth->user($sql_penj->id_user)->row()->first_name) ?></td>
                                </tr>
                                <tr>
                                    <th>Tgl Transaksi</th>
                                    <th>:</th>
                                    <td><?php echo $this->tanggalan->tgl_indo($sql_penj->tgl_masuk) ?></td>

                                    <th>Gudang Asal</th>
                                    <th>:</th>
                                    <td><?php echo strtoupper($this->db->where('id', $sql_penj->id_gd_asal)->get('tbl_m_gudang')->row()->gudang) ?></td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <th>:</th>
                                    <td><?php echo $sql_penj->keterangan ?></td>

                                    <th>Gudang Tujuan</th>
                                    <th>:</th>
                                    <td><?php echo strtoupper($this->db->where('id', $sql_penj->id_gd_tujuan)->get('tbl_m_gudang')->row()->gudang) ?></td>
                                </tr>
                            </table>
                            <hr/>
                            <br/>
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-left">Kode</th>
                                    <th class="text-left">Produk</th>
                                    <th class="text-right">Jml</th>
                                    <th class="text-right">Jml Diterima</th>
                                    <th class="text-right">Jml Kurang</th>
                                    <th class="text-right"></th>
                                </tr>                               

                                <?php $no = 1; ?>
                                <?php
                                $jml_total = 0;
                                $jml_diskon = 0;
                                $jml_gtotal = 0;
                                ?>
                                <?php foreach ($sql_penj_det as $items) { ?>
                                    <?php
                                    $jml_total = $jml_total + $items->subtotal;
                                    $jml_diskon = $jml_diskon + ($items->diskon + $items->potongan);
                                    $jml_gtotal = $jml_gtotal + $items->subtotal;
                                    $produk = $this->db->where('kode', $items->kode)->get('tbl_m_produk')->row();
                                    ?>
                                    <?php echo form_open(base_url('gudang/trans_mutasi_terima_simpan.php'), 'id="cart_terima_form" autocomplete="off"') ?>
                                    <?php echo form_hidden('id', general::enkrip($items->id)) ?>
                                    <?php echo form_hidden('no_nota', $this->input->get('id')) ?>
                                    <?php echo add_form_protection() ?>
                                    <?php $jml_kurang = $items->jml - $items->jml_diterima; ?>
                                    <?php $jml_item = $jml_item + ($items->jml * $items->jml_satuan); ?>
                                    <?php $jml_item_krg = $jml_item_krg + $jml_kurang; ?>
                                    <tr>
                                        <td class="text-center" style="width: 25px;"><?php echo $no++ ?></td>
                                        <td class="text-left" style="width: 70px;">
                                            <?php echo anchor(base_url('gudang/data_stok_tambah.php?id=' . general::enkrip($produk->id)), $items->kode, 'target="_blank"') ?><br/>
                                            <small><b>ID:</b><?php echo $items->id; ?></small>
                                        </td>
                                        <td class="text-left" style="width: 250px;">                                            
                                            <?php echo ucwords($items->produk); ?>
                                            <br/>
                                            <small><i><?php echo $this->ion_auth->user($items->id_user)->row()->first_name ?></i></small>
                                        </td>
                                        <td class="text-right" style="width: 50px;"><?php echo (!empty($items->keterangan) ? $items->jml : $items->jml) . ' ' . (!empty($items->satuan) ? $items->satuan : '') . (!empty($items->keterangan) ? $items->keterangan : ''); ?></td>
                                        <td class="text-center" style="width: 50px;">
                                            <div class="form-group">
                                                <?php if ($jml_kurang > 0): ?>
                                                    <?php 
                                                    // Calculate remaining stock correctly
                                                    $remaining_stock = $items->jml - $items->jml_diterima;
                                                    echo form_input([
                                                        'name' => 'jml_terima',
                                                        'class' => 'form-control text-middle rounded-0',
                                                        'type' => 'number',
                                                        'min' => '0',
                                                        'max' => $remaining_stock,
                                                        'step' => '1',
                                                        'required' => 'required',
                                                        'placeholder' => 'Max: ' . $remaining_stock,
                                                        'onchange' => 'updateRemainingStock(this, ' . $remaining_stock . ')'
                                                    ]); 
                                                    ?>
                                                    <small class="text-muted">Sisa: <span id="remaining-<?php echo $items->id; ?>"><?php echo $remaining_stock; ?></span></small>
                                                <?php else: ?>
                                                    <?php echo form_input([
                                                        'value' => $items->jml_diterima,
                                                        'class' => 'form-control text-center rounded-0',
                                                        'disabled' => 'true'
                                                    ]); ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="text-center" style="width: 75px;">
                                            <?php if ($jml_kurang > 0): ?>
                                            <div class="form-group">
                                                    <?php echo form_input([
                                                        'id' => 'remaining-display-' . $items->id,
                                                        'class' => 'form-control text-middle rounded-0',
                                                        'value' => $remaining_stock,
                                                        'disabled' => 'true'
                                                    ]); ?>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center" style="width: 50px;">
                                            <?php if ($jml_kurang > 0) { ?>
                                                <div class="form-group">                                                
                                                    <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-check-circle"></i> Terima</button>
                                                </div>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php echo add_double_submit_protection('cart_terima_form') ?>
                                    <?php echo form_close() ?>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('gudang/data_mutasi_terima.php') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <?php // if ($jml_item_krg == '0' && $sql_penj->status_penerimaan == '0') { ?>
                                    <?php if ($jml_kurang == '0' && $sql_penj->status_terima == '0') { ?>
                                        <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/set_trans_mutasi_finish.php?id=' . $this->input->get('id')) ?>'" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Selesai</button>
                                    <?php } ?>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        // Menampilkan Tanggal
        $("[id*='tgl']").datepicker({
            dateFormat: 'dd-mm-yy',
            SetDate: new Date(),
            autoclose: true
        });

        <?php echo $this->session->flashdata('gudang_toast'); ?>
    });

    function updateRemainingStock(input, maxStock) {
        const receivedQty = parseFloat(input.value) || 0;
        const itemId = input.closest('form').querySelector('input[name="id"]').value;
        const remainingDisplay = document.getElementById('remaining-display-' + itemId.replace('general::enkrip(', '').replace(')', ''));
        const remainingSpan = document.getElementById('remaining-' + itemId.replace('general::enkrip(', '').replace(')', ''));
        
        // Validate input
        if (receivedQty < 0) {
            input.value = 0;
        } else if (receivedQty > maxStock) {
            input.value = maxStock;
        }
        
        // Calculate and display remaining stock
        const remaining = maxStock - parseFloat(input.value);
        if (remainingDisplay) {
            remainingDisplay.value = remaining.toFixed(0);
        }
        if (remainingSpan) {
            remainingSpan.textContent = remaining.toFixed(0);
        }
    }
</script>