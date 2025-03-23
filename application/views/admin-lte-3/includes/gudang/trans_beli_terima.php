<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">PENERIMAAN BARANG</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('gudang/index.php') ?>">Gudang</a></li>
                        <li class="breadcrumb-item active">Form Penerimaan</li>
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
                <?php if (!empty($sql_beli)) { ?>
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Form Penerimaan Barang</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">

                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>No. Faktur</th>
                                                <th>:</th>
                                                <td><?php echo $sql_beli->no_nota ?></td>

                                                <th>Supplier</th>
                                                <th>:</th>
                                                <td><?php echo '[' . $sql_supplier->kode . '] ' . $sql_supplier->nama ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tgl Faktur</th>
                                                <th>:</th>
                                                <td><?php echo $this->tanggalan->tgl_indo2($sql_beli->tgl_masuk) ?></td>

                                                <th>Tgl Pengiriman</th>
                                                <th>:</th>
                                                <td><?php echo $this->tanggalan->tgl_indo2($sql_beli->tgl_keluar) ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-left">Item</th>
                                                    <th class="text-center">Jml</th>
                                                    <th class="text-center">Gudang</th>
                                                    <th class="text-center">Tgl Diterima</th>
                                                    <th class="text-center">Jml Diterima</th>
                                                    <th class="text-center">Kekurangan</th>
                                                    <th class="text-center"></th>
                                                </tr>                                    
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($sql_beli_det)) { ?>
                                                    <?php $no = 1 ?>
                                                    <?php foreach ($sql_beli_det as $cart) { ?>
                                                        <?php $sql_mut  = $this->db->where('id_pembelian', $sql_beli->id)->where('id_pembelian_det', $cart->id)->where('id_produk', $cart->id_produk)->where('status', '1')->get('tbl_m_produk_hist')->result(); ?>
                                                
                                                        <?php echo form_open(base_url('gudang/trans_beli_terima_simpan.php'), 'autocomplete="off"') ?>
                                                        <?php echo form_hidden('id', general::enkrip($cart->id)) ?>
                                                        <?php echo form_hidden('no_nota', $this->input->get('id')) ?>
                                                
                                                        <?php $jml_kurang   = $cart->jml - $cart->jml_diterima; ?>
                                                        <?php $jml_item     = $jml_item + ($cart->jml * $cart->jml_satuan); ?>
                                                        <?php $jml_item_krg = $jml_item_krg + $jml_kurang; ?>
                                                        <tr>
                                                            <td class="text-center" style="width: 15px;"><?php echo $no; ?></td>
                                                            <td class="text-left" style="width: 350px;">
                                                                <?php echo anchor(base_url('gudang/data_stok_tambah.php?id='.general::enkrip($cart->id_produk)), $cart->produk, 'target="_blank"'); ?>
                                                            </td>
                                                            <td class="text-center" style="width: 100px;">
                                                                <?php echo form_input(array('id' => '', 'name' => '', 'class' => 'form-control text-center rounded-0' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan jml ...', 'value' => (float)$cart->jml, 'disabled'=>'true')) ?>
                                                            </td>
                                                            <td class="text-center" style="width: 150px;">                                                                
                                                                <div class="form-group <?php echo (!empty($hasError['gd']) ? 'has-error' : '') ?>">
                                                                    <select name="gudang" class="form-control rounded-0">
                                                                        <!--<option value="">- [Pilih] -</option>-->
                                                                        <?php foreach ($sql_gudang as $gudang) { ?>
                                                                            <option value="<?php echo $gudang->id ?>"><?php echo $gudang->gudang ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td class="text-center" style="width: 200px;">
                                                                <div class="form-group">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                        </div>
                                                                        <?php echo form_input(array('id' => '', 'name' => 'tgl_terima', 'class' => 'form-control text-middle rounded-0' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Inputkan tgl ...', 'value' => (isset($_GET['tgl']) ? $this->tanggalan->tgl_indo($_GET['tgl']) : ''))) ?>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center" style="width: 150px;">
                                                                <div class="form-group">
                                                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml_terima', 'class' => 'form-control text-middle rounded-0' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Inputkan jml ...', 'value' => (isset($_GET['tgl']) ? $this->tanggalan->tgl_indo($_GET['tgl']) : ''))) ?>
                                                                </div>
                                                            </td>
                                                            <td class="text-center" style="width: 70px;">
                                                                <?php echo form_input(array('id' => '', 'name' => '', 'class' => 'form-control text-center rounded-0' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan jml ...', 'value' => $jml_kurang.' '.$sql_satuan->satuanTerkecil, 'disabled'=>'true')) ?>
                                                            </td>
                                                            <td class="text-center" style="width: 120px;">
                                                                <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-check-circle"></i> Terima</button>
                                                            </td>
                                                        </tr>
                                                        
                                                        <?php foreach ($sql_mut as $ph){ ?>
                                                        <?php $sql_gd  = $this->db->where('id', $ph->id_gudang)->get('tbl_m_gudang')->row(); ?>
                                                        <tr>
                                                            <td class="text-center" style="width: 15px;"></td>
                                                            <td class="text-left" style="width: 350px;"></td>
                                                            <td class="text-center" style="width: 100px;"></td>
                                                            <td class="text-center" style="width: 150px;">[<?php echo $sql_gd->gudang ?>]</td>
                                                            <td class="text-center" style="width: 200px;">
                                                                <?php echo $this->tanggalan->tgl_indo($ph->tgl_masuk) ?>
                                                            </td>
                                                            <td class="text-center" style="width: 150px;"><?php echo ($ph->jml * $ph->jml_satuan).' '.$ph->satuan ?></td>
                                                            <td class="text-center" style="width: 70px;"></td>
                                                            <td class="text-center" style="width: 120px;">
                                                                <?php echo anchor(base_url('gudang/trans_beli_terima_hapus.php?&id='.general::enkrip($ph->id).'&uid='.general::enkrip($ph->id_produk).'&route=gudang/trans_beli_terima.php'), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" style="width: 65px;" onclick="return confirm(\'Hapus Penerimaan ?\')"') ?>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                        
                                                        <?php $no++; ?>
                                                        <?php echo form_close() ?>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <tr>
                                                        <th class="text-center" colspan="7">Tidak Ada Data</th>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'gudang/trans_beli_list.php') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <?php if(akses::hakSA() == TRUE){ ?>
                                            <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/set_beli_terima_reset.php?id='.$this->input->get('id')) ?>'" class="btn btn-danger btn-flat"><i class="fa fa-check"></i> Reset</button>
                                        <?php } ?>
                                        <?php if($jml_item_krg == '0' && $sql_beli->status_penerimaan == '0'){ ?>
                                            <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/set_beli_terima_finish.php?id='.$this->input->get('id')) ?>'" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Simpan</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
        $(function () {
            // Mengcover tanggal masuk dan tempo
            $("[name*='tgl_terima']").datepicker({
                format: 'mm/dd/yyyy',
                //defaultDate: "+1w",
                SetDate: new Date(),
                changeMonth: true,
                changeYear: true,
                yearRange: '2022:<?php echo date('Y') ?>',
                autoclose: true
            });
            
            <?php echo $this->session->flashdata('gudang_toast'); ?>
        });
</script>