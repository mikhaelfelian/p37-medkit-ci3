<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pembelian</li>
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
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Pembelian</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <?php echo $this->session->flashdata('trasnsaksi'); ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Faktur</th>
                                        <th>Supplier</th>
                                        <th>Tgl Tempo</th>
                                        <th>Nominal</th>
                                        <th colspan="2"></th>
                                    </tr>
                                    <?php echo form_open_multipart(base_url('transaksi/beli/set_cari_pemb.php'), 'autocomplete="off"') ?> 
                                    <tr>
                                        <td></td>
                                        <td>
                                            <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan No Faktur ...', 'value' => (!empty($_GET['filter_nota']) ? $_GET['filter_nota'] : ''))) ?>
                                        </td>
                                        <td>
                                            <?php echo form_input(array('id' => 'supplier', 'name' => 'supplier', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Supplier ...', 'value' => (!empty($_GET['filter_supplier']) ? $_GET['filter_supplier'] : ''))) ?>
                                        </td>
                                        <td>
                                            <?php // echo form_input(array('id' => '', 'name' => 'pasien', 'class' => 'form-control', 'placeholder' => 'Isikan Tgl ...', 'value' => (!empty($_GET['filter_nama']) ? $_GET['filter_nama'] : ''))) ?>
                                            <!--<input type="hidden" id="id_medcheck" name="id_medcheck" value="<?php echo (!empty($_GET['id']) ? $_GET['id'] : '') ?>">-->
                                        </td>
                                        <td>
                                            <!--
                                            <select name="status_bayar" class="form-control">
                                                <option value="">[Status Bayar]</option>
                                                <option value="0" <?php // echo ($_GET['filter_bayar'] == '0' ? 'selected' : '')  ?>>Belum</option>
                                                <option value="1" <?php // echo ($_GET['filter_bayar'] == '1' ? 'selected' : '')  ?>>Lunas</option>
                                                <option value="2" <?php // echo ($_GET['filter_bayar'] == '2' ? 'selected' : '')  ?>>Kurang</option>
                                            </select>
                                            -->
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-primary btn-flat">
                                                <i class="fa fa-search-plus"></i> Filter
                                            </button>
                                        </td>
                                    </tr>
                                    <?php echo form_close() ?> 
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($sql_beli)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($sql_beli as $beli) {
                                            $sales = $this->ion_auth->user($beli->id_user)->row();
//                                            $supplier = $this->db->where('id', $beli->id_supplier)->get('tbl_m_supplier')->row();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td style="width: 170px;">
                                                    <?php echo anchor(base_url('transaksi/trans_beli_det.php?id=' . general::enkrip($beli->id)), $beli->no_nota, 'class="text-default"') ?>
                                                    <?php echo br(); ?>
                                                    <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo2($beli->tgl_masuk); ?></span>
                                                    <?php echo br(); ?>
                                                    <small><i><b><?php echo $beli->no_po; ?></b></i></small>
                                                    <?php echo br(); ?>
                                                    <small><i><b>TRX ID : <?php echo $beli->id; ?></b></i></small>
                                                </td>
                                                <td style="width: 450px;">
                                                    <b><?php echo $beli->nama; ?></b>
                                                    <?php if(!empty($beli->npwp) OR $beli->npwp == '-'){ ?>
                                                        <?php echo br(); ?>
                                                        <small><i><?php echo $beli->npwp; ?></i></small>
                                                    <?php } ?>
                                                    <?php if(!empty($beli->alamat) OR $beli->alamat == '-'){ ?>
                                                    <?php echo br(); ?>
                                                        <small><i><?php echo $beli->alamat; ?></i></small>
                                                        <?php echo br(); ?>
                                                        <small><i><b><?php echo $beli->no_tlp.(!empty($beli->cp) ? ' '.$beli->cp : ''); ?></b></i></small>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $this->tanggalan->tgl_indo($beli->tgl_keluar) ?></td>                                                
                                                <td class="text-right"><?php echo general::format_angka($beli->jml_gtotal) ?></td>
                                                <td>
                                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
                                                        <?php echo anchor(base_url('transaksi/beli/trans_beli_edit.php?id='.general::enkrip($beli->id)), '<i class="fa fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                                    <?php } ?>
                                                    <?php echo general::status_bayar($beli->status_bayar) ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
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