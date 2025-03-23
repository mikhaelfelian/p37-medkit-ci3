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
                            <h3 class="card-title">Data Purchase Order</h3>
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
                                        <th>Keterangan</th>
                                        <th colspan="2"></th>
                                    </tr>
                                    <?php echo form_open_multipart(base_url('transaksi/beli/set_cari_po.php'), 'autocomplete="off"') ?> 
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>
                                            <?php echo form_input(array('id' => 'supplier', 'name' => 'supplier', 'class' => 'form-control', 'placeholder' => 'Isikan Supplier ...', 'value' => (!empty($_GET['filter_supplier']) ? $_GET['filter_supplier'] : ''))) ?>
                                        </td>
                                        <td>
                                            <?php // echo form_input(array('id' => '', 'name' => 'pasien', 'class' => 'form-control', 'placeholder' => 'Isikan Tgl ...', 'value' => (!empty($_GET['filter_nama']) ? $_GET['filter_nama'] : ''))) ?>
                                            <!--<input type="hidden" id="id_medcheck" name="id_medcheck" value="<?php echo (!empty($_GET['id']) ? $_GET['id'] : '') ?>">-->
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
                                            $sql_po_cek = $this->db->where('id_po', $beli->id)->get('tbl_trans_beli');
                                            $sales = $this->ion_auth->user($beli->id_user)->row();
//                                            $supplier = $this->db->where('id', $beli->id_supplier)->get('tbl_m_supplier')->row();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td style="width: 170px;">
                                                    <?php echo anchor(base_url('transaksi/beli/trans_beli_po_det.php?id=' . general::enkrip($beli->id)), $beli->no_nota, 'class="text-default"') ?>
                                                    <?php echo br(); ?>
                                                    <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo2($beli->tgl_masuk); ?></span>
                                                    <?php if($sql_po_cek->num_rows() == 0){ ?>
                                                        <?php echo br(); ?>
                                                        <label class="badge badge-danger"><i class="far fa-solid fa-clock-rotate-left"></i> Belum Faktur</label>
                                                    <?php } ?>
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
                                                <td><?php echo $beli->keterangan ?></td>                                                
                                                <td>
                                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
                                                        <?php echo anchor(base_url('transaksi/beli/trans_beli_po_hapus.php?id='.general::enkrip($beli->id)), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus ['.$beli->no_nota.']?\')" style="width: 55px;"') ?>
                                                        <?php if($sql_po_cek->num_rows() == 0){ ?>
                                                            <?php echo anchor(base_url('transaksi/beli/trans_beli_po_edit.php?id='.general::enkrip($beli->id)), '<i class="fa fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                                        <?php } ?>
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