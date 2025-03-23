<?php $sql_satuan = $this->db->where('id', $barang->id_satuan)->get('tbl_m_satuan')->row() ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Stok <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Data Stok</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-4">
                <?php echo form_open(base_url('gudang/data_stok_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Data Stok</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('master'); ?>
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <div class="form-group <?php echo (!empty($hasError['satKcl']) ? 'has-error' : '') ?>">
                            <label class="control-label">Kode</label>
                            <?php echo form_input(array('name' => 'kode', 'class' => 'form-control', 'value' => $barang->kode, 'readonly'=>'TRUE')) ?>
                        </div>

                        <div class="form-group <?php echo (!empty($hasError['satBsr']) ? 'has-error' : '') ?>">
                            <label class="control-label">Nama Stok</label>
                            <?php echo form_input(array('id' => 'barang', 'name' => 'barang', 'class' => 'form-control', 'value' => $barang->produk, 'readonly'=>'TRUE')) ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">                                
                                <div class="form-group <?php echo (!empty($hasError['jml']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Jumlah</label>
                                    <?php if(akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdmin() == TRUE){ ?>
                                        <?php // echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'readonly'=>'TRUE', 'value' => (isset($barang->jml) ? $barang->jml : '0'))) ?>
                                        <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'readonly'=>'TRUE', 'value' => (isset($barang_stok->jml) ? $barang_stok->jml : '0'))) ?>
                                    <?php }else{ ?>
                                        <?php // echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'readonly'=>'TRUE', 'value' => (isset($barang->jml) ? $barang->jml : '0'))) ?>
                                        <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'readonly'=>'TRUE', 'value' => (isset($barang_stok->jml) ? $barang_stok->jml : '0'))) ?>
                                    <?php } ?>
                                </div>  
                            </div>
                            <div class="col-lg-6">                                
                                <div class="form-group <?php echo (!empty($hasError['jml']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Satuan</label>
                                    <select name="satuan" disabled="TRUE" class="form-control">
                                        <option value="">- Pilih -</option>
                                        <?php foreach ($satuan as $satuan){ ?>
                                        <?php $prod_sat = ($barang->id_satuan == $satuan->id ? $satuan->satuanTerkecil : ''); ?>
                                            <option value="<?php echo $satuan->id ?>" <?php echo ($barang->id_satuan == $satuan->id ? 'selected' : '') ?>><?php echo $satuan->satuanTerkecil ?></option>
                                        <?php } ?>
                                    </select>
                                </div>  
                            </div>
                        </div>                      
                    </div>
                    <div class="box-footer">                        
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/data_stok_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
                            </div>
                            <div class="col-lg-6 text-right">
                                <?php if(akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdmin() == TRUE){ ?>
                                    <!--<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>-->
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <!--
            <?php if(akses::hakSA() == TRUE){ ?>
            <div class="col-lg-4">
                <?php echo form_open(base_url('gudang/data_stok_' . (isset($_GET['id']) ? 'update_br' : 'simpan') . '.php')) ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Input via Barcode</h3>
                    </div>
                    <div class="box-body">
                        <?php // echo $this->session->flashdata('master'); ?>
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <div class="form-group <?php echo (!empty($hasError['satKcl']) ? 'has-error' : '') ?>">
                            <label class="control-label">Kode</label>
                            <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control')) ?>
                        </div>

                        <div class="form-group <?php echo (!empty($hasError['satBsr']) ? 'has-error' : '') ?>">
                            <label class="control-label">Nama Stok</label>
                            <?php echo form_input(array('id' => 'barang', 'name' => 'barang', 'class' => 'form-control', 'value' => $barang->produk, 'readonly'=>'TRUE')) ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">                                
                                <div class="form-group <?php echo (!empty($hasError['jml']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Jumlah</label>
                                    <?php if(akses::hakSA() == TRUE OR akses::hakOwner() == TRUE){ ?>
                                        <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value' => (isset($barang->jml) ? $barang->jml : '0'))) ?>
                                    <?php }else{ ?>
                                        <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'readonly'=>'TRUE', 'value' => (isset($barang->jml) ? $barang->jml : '0'))) ?>
                                    <?php } ?>
                                </div>  
                            </div>
                        </div>                      
                    </div>
                    <div class="box-footer">                        
                        <div class="row">
                            <div class="col-lg-6">
                                
                            </div>
                            <div class="col-lg-6 text-right">
                                <?php if(akses::hakSA() == TRUE OR akses::hakOwner() == TRUE){ ?>
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                <?php }else{ ?>
                                <?php echo nbs(2) ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <?php } ?>
            -->
            <div class="col-lg-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Stok per gudang</h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open('page=gudang&act=data_stok_update_gd', 'autocomplete="off"') ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-center">Nama Gudang</th>
                                    <th colspan="3" class="text-center">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($gudang as $gd){ ?>
                                <tr>
                                    <th><?php echo $gd->gudang; ?></th>
                                    <th>:</th>
                                    <td class="text-right">
                                        <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdmin() == TRUE){ ?>
                                        <?php echo form_input(array('name'=>'jml['.$gd->id.']', 'class'=>'form-control', 'style'=>'width: 75px;','value'=>$gd->jml)); ?>
                                        <?php }else{ ?>
                                        <?php echo form_input(array('name'=>'jml['.$gd->id.']', 'class'=>'form-control', 'style'=>'width: 75px;','value'=>$gd->jml, 'readonly'=>'TRUE')); ?>
                                        <?php } ?>
                                    </td>
                                    <td class="text-left"><?php echo $gd->satuan; ?></td>
                                    <td class="text-left">
                                        <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdmin() == TRUE){ ?>
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i></button>
                                        <?php } ?>
                                    </td>
                                    <td class="text-left"><?php echo general::status_gd($gd->status); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Stok per satuan</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-center">Satuan</th>
                                    <th class="text-center">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($barang_sat as $gd){ ?>
                            <?php $jml_stk = ($barang_stok->jml / $gd->jml); ?>
                            <?php $stk = round($jml_stk); ?>
                                <?php if($stk != '0'){ ?>
                                    <tr>
                                        <th><?php echo $gd->satuan; ?></th>
                                        <th>:</th>
                                        <td class="text-right">
                                            <?php echo $stk; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Mutasi Stok</h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open(base_url('gudang/data_stok_trm_simpan.php'), 'autocomplete="off"') ?>
                        <?php echo $this->session->flashdata('master'); ?>
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE){ ?>
                                    <th>User</th>
                                    <?php } ?>
                                    <th>Gudang</th>
                                    <th>Tgl</th>
                                    <th>Kode</th>
                                    <th class="text-right">Jml</th>
                                    <th>Satuan</th>
                                    <?php if(akses::hakSA() == TRUE){ ?>
                                    <th>Nominal</th>
                                    <?php } ?>
                                    <th>Keterangan</th>
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE){ ?>
                            <tbody>
                                <tr>
                                    <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE){ ?>
                                    <td></td>
                                    <?php } ?>
                                    <td>
                                        <!--<div class="form-group <?php echo (!empty($hasError['gd']) ? 'has-error' : '') ?>">-->
                                                <select name="gudang" class="form-control">
                                                    <option value="">- [Pilih] -</option>
                                                    <?php foreach ($gudang_ls as $gudang) { ?>
                                                        <option value="<?php echo $gudang->id ?>"><?php echo $gudang->gudang ?></option>
                                                    <?php } ?>
                                                </select>
                                            <!--</div>-->
                                    </td>
                                    <td><?php echo form_input(array('id'=>'tgl_terima', 'name'=>'tgl_terima', 'class'=>'form-control')) ?></td>
                                    <td><?php // echo form_input(array('id'=>'no_po', 'name'=>'no_po', 'class'=>'form-control')) ?></td>
                                    <td style="width: 100px;"><?php echo form_input(array('id'=>'jml', 'name'=>'jml', 'class'=>'form-control')) ?></td>
                                    <td style="width: 100px;">
                                        <?php echo form_input(array('id'=>'satuan', 'name'=>'satuan', 'class'=>'form-control', 'value'=>$sql_satuan->satuanTerkecil, 'readonly'=>'TRUE')) ?>
                                    </td>
                                    <?php if(akses::hakSA() == TRUE){ ?>
                                    <td></td>
                                    <?php } ?>
                                    <td><?php echo form_input(array('id'=>'keterangan', 'name'=>'keterangan', 'class'=>'form-control')) ?></td>
                                    <td colspan="2"><button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button></td>
                                </tr>
                            </tbody>
                            <?php } ?>
                            <tbody>
                                <?php $tot_sm = 0; $tot_sk = 0; ?>
                                <?php foreach ($barang_hist as $hist){ ?>
                                <?php $sql_gudang = $this->db->where('id', $hist->id_gudang)->get('tbl_m_gudang')->row() ?>
                                <?php $tot_sm = $tot_sm + ($hist->status == '1' || $hist->status == '2' || $hist->status == '3' ? ($hist->jml * $hist->jml_satuan) : 0); ?>
                                <?php $tot_sk = $tot_sk + ($hist->status == '4' || $hist->status == '5' || $hist->status == '7' ? ($hist->jml * $hist->jml_satuan) : 0); ?>
                                <tr>
                                    <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE){ ?>
                                    <td style="width: 150px;"><?php echo $this->ion_auth->user($hist->id_user)->row()->first_name ?></td>
                                    <?php } ?>
                                    <td style="width: 250px;"><?php echo $sql_gudang->gudang ?></td>
                                    <td style="width: 100px;"><?php echo (!empty($hist->tgl_masuk) ? $this->tanggalan->tgl_indo($hist->tgl_masuk) : $this->tanggalan->tgl_indo($hist->tgl_simpan)) ?></td>
                                    <!--<td style="width: 100px;"><?php echo $this->tanggalan->tgl_indo($hist->tgl_masuk) ?></td>-->
                                    <td style="width: 180px;"><?php echo $hist->kode ?></td>
                                    <td style="width: 100px;" class="text-right"><?php echo $hist->jml * $hist->jml_satuan; //($hist->status == '3' ? $hist->jml * $hist->jml_satuan : $hist->jml) ?></td>
                                    <td style="width: 150px;">
                                        <?php echo $sql_satuan->satuanTerkecil; // $hist->satuan.' ('.$hist->jml * $hist->jml_satuan.' '.$sql_satuan->satuanTerkecil.')' ?>
                                    </td>
                                    <?php if(akses::hakSA() == TRUE){ ?>
                                        <td class="text-right"><?php echo general::format_angka($hist->nominal) ?></td>
                                    <?php } ?>
                                    <td style="width: 600px;">
                                        <?php if(akses::hakAdmin() == TRUE || akses::hakAdminM() == TRUE || akses::hakGudang() == TRUE && $hist->status != '3' && $hist->status != '2'){ ?>
                                            <?php $nota_beli = $this->db->where('id', $hist->id_pembelian)->get('tbl_trans_beli')->row(); ?>
                                            <?php
                                            switch ($hist->status){
                                                case '1':
                                                    $sql_nota = $this->db->where('id', $hist->id_pembelian)->get('tbl_trans_beli');
                                                    $nota_rw  = $sql_nota->num_rows();
                                                    $nota_id  = $hist->id_pembelian;
                                                    $nota     = (!empty($hist->no_nota) && !empty($hist->id_pembelian) ? 'Pembelian '.$hist->no_nota : (!empty($hist->keterangan) ? $hist->keterangan : '-'));
                                                    break;
                                                
                                                case '2':
                                                    $sql_nota = '';
                                                    $nota_rw  = '';
                                                    $nota_id  = '';
                                                    $nota     = (!empty($hist->keterangan) ? $hist->keterangan : '-');
                                                    break;
                                                
                                                case '3':
                                                    $sql_nota = $this->db->where('id', $hist->id_penjualan)->get('tbl_trans_retur_jual');
                                                    $nota_rw  = $sql_nota->num_rows();
                                                    $nota_id  = $hist->id_penjualan;
                                                    $nota     = (!empty($nota_rw) ? 'Retur Penjualan '.anchor(base_url('transaksi/trans_retur_jual_det.php?id='.general::enkrip($hist->id_penjualan)), $sql_nota->row()->no_retur.(!empty($sql_nota->row()->kode_nota_blk) ? $sql_nota->row()->kode_nota_blk : ''), 'target="_blank"') : $hist->keterangan); //.anchor(base_url('transaksi/trans_retur_jual_det.php?id='.general::enkrip($hist->id_penjualan), $sql_nota->row()->no_retur.(!empty($sql_nota->row()->kode_nota_blk) ? $sql_nota->row()->kode_nota_blk : ''), 'target="_blank"'))
                                                    break;
                                                
                                                case '4':
                                                    $sql_nota = $this->db->where('id', $hist->id_penjualan)->get('tbl_trans_jual');
                                                    $nota_rw  = $sql_nota->num_rows();
                                                    $nota_id  = $hist->id_penjualan;
                                                    $nota     = (akses::hakGudang() == TRUE ? 'Penjualan '.$sql_nota->row()->no_nota.(!empty($sql_nota->row()->kode_nota_blk) ? '/'.$sql_nota->row()->kode_nota_blk : '') : 'Penjualan '.anchor(base_url('transaksi/trans_jual_det.php?id='.general::enkrip($hist->id_penjualan)), $sql_nota->row()->no_nota.(!empty($sql_nota->row()->kode_nota_blk) ? '/'.$sql_nota->row()->kode_nota_blk : ''), 'target="_blank"'));
                                                    break;
                                                
                                                case '5':
                                                    $sql_nota = $this->db->where('id', $hist->id_pembelian)->get('tbl_trans_retur_beli');
                                                    $nota_rw  = $sql_nota->num_rows();
                                                    $nota_id  = $hist->id_pembelian;
                                                    $nota     = (!empty($nota_rw) ? 'Retur Pembelian '.anchor(base_url('transaksi/trans_retur_beli_det.php?id='.general::enkrip($hist->id_pembelian)), '#'.sprintf('%05s',$hist->id_pembelian).(!empty($sql_nota->row()->kode_nota_blk) ? $sql_nota->row()->kode_nota_blk : ''), 'target="_blank"') : $hist->keterangan);
                                                    break;
                                                
                                                case '6':
                                                    $sql_nota = '';
                                                    $nota_rw  = '';
                                                    $nota_id  = '';
                                                    $nota     = (!empty($hist->keterangan) ? $hist->keterangan : '-');
                                                    break;
                                                
                                                case '7':
                                                    $sql_nota = '';
                                                    $nota_rw  = '';
                                                    $nota_id  = '';
                                                    $nota     = (!empty($hist->keterangan) ? $hist->keterangan : '-');
                                                    break;
                                                
                                                case '8':
                                                    $nota     = $hist->keterangan.' ['.anchor(base_url('gudang/trans_mutasi_det.php?id='.general::enkrip($hist->id_penjualan)), '#'.$hist->no_nota).']';
                                                    break;
                                                    
                                            }
                                            
                                            $keterangan = (!empty($nota_id) ? (!empty($nota_rw) ? $nota : $hist->keterangan) : $hist->keterangan);
                                            echo (empty($keterangan) ? $hist->keterangan : $keterangan);
                                            ?>
                                        <?php }else{ ?>
                                            <?php
                                            switch ($hist->status){
                                                case '1':
                                                    $sql_nota = $this->db->where('id', $hist->id_pembelian)->get('tbl_trans_beli');
                                                    $nota_rw  = $sql_nota->num_rows();
                                                    $nota_id  = $hist->id_pembelian;
                                                    $nota     = (!empty($hist->no_nota) && !empty($hist->id_pembelian) ? 'Pembelian '.anchor(base_url('transaksi/trans_beli_det.php?id='.general::enkrip($hist->id_pembelian)), $hist->no_nota, 'target="_blank"') : (!empty($hist->keterangan) ? $hist->keterangan : '-'));
                                                    break;
                                                
                                                case '2':
                                                    $sql_nota = '';
                                                    $nota_rw  = '';
                                                    $nota_id  = '';
                                                    $nota     = (!empty($hist->keterangan) ? $hist->keterangan : '-');
                                                    break;
                                                
                                                case '3':
                                                    $sql_nota = $this->db->where('id', $hist->id_penjualan)->get('tbl_trans_retur_jual');
                                                    $nota_rw  = $sql_nota->num_rows();
                                                    $nota_id  = $hist->id_penjualan;
                                                    $nota     = (!empty($nota_rw) ? 'Retur Penjualan '.anchor(base_url('transaksi/trans_retur_jual_det.php?id='.general::enkrip($hist->id_penjualan)), $sql_nota->row()->no_retur.(!empty($sql_nota->row()->kode_nota_blk) ? $sql_nota->row()->kode_nota_blk : ''), 'target="_blank"') : $hist->keterangan); //.anchor(base_url('transaksi/trans_retur_jual_det.php?id='.general::enkrip($hist->id_penjualan), $sql_nota->row()->no_retur.(!empty($sql_nota->row()->kode_nota_blk) ? $sql_nota->row()->kode_nota_blk : ''), 'target="_blank"'))
                                                    break;
                                                
                                                case '4':
                                                    $sql_nota = $this->db->where('id', $hist->id_penjualan)->get('tbl_trans_jual');
                                                    $nota_rw  = $sql_nota->num_rows();
                                                    $nota_id  = $hist->id_penjualan;
                                                    $nota     = (!empty($nota_rw) ? 'Penjualan '.anchor(base_url('transaksi/trans_jual_det.php?id='.general::enkrip($hist->id_penjualan)), $sql_nota->row()->no_nota.(!empty($sql_nota->row()->kode_nota_blk) ? '/'.$sql_nota->row()->kode_nota_blk : ''), 'target="_blank"') : $hist->keterangan);
                                                    break;
                                                
                                                case '5':
                                                    $sql_nota = $this->db->where('id', $hist->id_pembelian)->get('tbl_trans_retur_beli');
                                                    $nota_rw  = $sql_nota->num_rows();
                                                    $nota_id  = $hist->id_pembelian;
                                                    $nota     = (!empty($nota_rw) ? 'Retur Pembelian '.anchor(base_url('transaksi/trans_retur_beli_det.php?id='.general::enkrip($hist->id_pembelian)), '#'.sprintf('%05s',$hist->id_pembelian).(!empty($sql_nota->row()->kode_nota_blk) ? $sql_nota->row()->kode_nota_blk : ''), 'target="_blank"') : $hist->keterangan);
                                                    break;
                                                
                                                case '6':
                                                    $sql_nota = '';
                                                    $nota_rw  = '';
                                                    $nota_id  = '';
                                                    $nota     = (!empty($hist->keterangan) ? $hist->keterangan : '-');
                                                    break;
                                                
                                                case '7':
                                                    $sql_nota = '';
                                                    $nota_rw  = '';
                                                    $nota_id  = '';
                                                    $nota     = (!empty($hist->keterangan) ? $hist->keterangan : '-');
                                                    break;
                                                
                                                case '8':
                                                    $nota     = $hist->keterangan.' ['.anchor(base_url('gudang/trans_mutasi_det.php?id='.general::enkrip($hist->id_penjualan)), '#'.$hist->no_nota).']';
                                                    break;                                                    
                                            }
                                            
                                            $keterangan = (!empty($nota_id) ? (!empty($nota_rw) ? $nota : $hist->keterangan) : $hist->keterangan);
                                            echo $nota;//(empty($keterangan) ? $hist->keterangan : $keterangan);
                                            ?>
                                        <?php } ?>
                                    </td>
                                    <?php if(akses::hakOwner2() == TRUE){ ?>
                                        <td></td>
                                    <?php }else{ ?>
                                        <td>
                                            <?php echo general::status_stok($hist->status) ?>
                                        </td>
                                    <?php } ?>
                                    <td>
                                        <?php // if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakOwner2() == TRUE || akses::hakAdmin() == TRUE && $hist->status != '3'){ ?>
                                        <?php //  || akses::hakOwner() == TRUE ?>
                                        <?php if(akses::hakSA() == TRUE){ ?>
                                                <?php echo anchor(base_url('gudang/data_stok_hapus_hist.php?id=' . general::enkrip($hist->id)).'&uid='.$this->input->get('id'), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $hist->kode . '] ? \')" class="label label-danger"') ?>
                                                <?php echo nbs() ?>
                                        <?php }elseif(akses::hakOwner() == TRUE AND $hist->status =='2'){ ?>
                                                <?php echo anchor(base_url('gudang/data_stok_hapus_hist.php?id=' . general::enkrip($hist->id)).'&uid='.$this->input->get('id'), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $hist->kode . '] ? \')" class="label label-danger"') ?>
                                                <?php echo nbs() ?>
                                        <?php }elseif(akses::hakAdminM() == TRUE AND $hist->status =='2'){ ?>
                                                <?php echo anchor(base_url('gudang/data_stok_hapus_hist.php?id=' . general::enkrip($hist->id)).'&uid='.$this->input->get('id'), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $hist->kode . '] ? \')" class="label label-danger"') ?>
                                                <?php echo nbs() ?>
                                        <?php }elseif(akses::hakAdmin() == TRUE){ ?>
                                            <?php if($hist->status != '1'){ ?>
                                                <?php // echo anchor(base_url('gudang/data_stok_hapus_hist.php?id=' . general::enkrip($hist->id)).'&uid='.$this->input->get('id'), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $hist->kode . '] ? \')" class="label label-danger"') ?>
                                                <?php echo nbs() ?>
                                            <?php } ?>
                                        <?php }else{ ?>
                                            <!--<label class="label label-default" ><i class="fa fa-remove"></i> Hapus</label>-->
                                            <?php // echo nbs() ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if(akses::hakSA() == TRUE){ ?>
                                <tr>
                                    <th colspan="4" class="text-right">Total Stok Masuk</th>
                                    <td class="text-right"><?php echo $tot_sm ?></td>
                                    <td colspan="4" class="text-left"><?php echo $prod_sat; ?></td>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Total Stok Keluar</th>
                                    <td class="text-right"><?php echo $tot_sk ?></td>
                                    <td colspan="4" class="text-left"><?php echo $prod_sat; ?></td>
                                </tr>
                                <?php $sisa_st = $tot_sm - $tot_sk ?>
                                <tr>
                                    <th colspan="4" class="text-right">Sisa</th>
                                    <td class="text-right"><?php echo (int)$sisa_st; ?></td>
                                    <td colspan="4" class="text-left"><?php echo $prod_sat; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php echo form_close() ?>
                    </div>
                    <div class="box-footer">                        
                        <div class="row">
                            <div class="col-lg-6">
                                <!--<button type="button" onclick="window.location.href = '<?php echo base_url('gudang/data_stok_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>-->
                            </div>
                            <div class="col-lg-6 text-right">
                                <!--<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>-->
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>

<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script>
$(function () {
    $('#kode').focus();
    $("#harga_beli").autoNumeric({aSep: '.', aDec: ',', aPad: false});
    $("#harga_jual").autoNumeric({aSep: '.', aDec: ',', aPad: false});
    $("#harga_grosir").autoNumeric({aSep: '.', aDec: ',', aPad: false});
    
    $("[name*='tgl_terima']").datepicker({autoclose: true});
    $("[name*='jml']").keydown(function (e) {
        // kibot: backspace, delete, tab, escape, enter .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // kibot: Ctrl+A, Command+A
                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // kibot: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // Biarin wae, ga ngapa2in return false
                    return;
                }
                // Cuman nomor
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
});
</script>