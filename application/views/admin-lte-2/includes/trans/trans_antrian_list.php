<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Antrian <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Antrian</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <?php echo $this->session->flashdata('transaksi') ?>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <?php echo nbs(3) ?>
                        <table class="table table-border">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No. Invoice</th>
                                    <th colspan="2">Lokasi</th>
                                    <th>Tgl</th>
                                    <th>Kasir</th>
                                </tr>
                            </thead>                            
                            <?php echo form_open(base_url('cart/set_cari_antrian.php')) ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <!--<input type="hidden" id="id_sales" name="id_sales">-->
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <td>
                                        <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control')) ?>
                                    </td>
                                    <td colspan="2">
                                        <?php $cabang = $this->db->get('tbl_pengaturan_cabang')->result(); ?>
                                        <select name="cabang" class="form-control form-inline">
                                            <option value="">- [Lokasi] -</option>
                                            <?php foreach ($cabang as $cabang) { ?>
                                                <option value="<?php echo $cabang->id ?>"><?php echo $cabang->keterangan ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php // } ?>
                                    </td>
                                    <td><?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control')) ?></td>
                                    <td>
                                        <?php echo form_input(array('id' => 'cari_kasir', 'name' => 'nama_kasir', 'class' => 'form-control')) ?>
                                        <input type="hidden" id="kasir" name="kasir">
                                    </td>
                                    <td><button class="btn btn-primary">Filter</button></td>
                                </tr>
                            </tbody>
                            <?php echo form_close() ?>
                            <tbody>
                                <?php
                                if (!empty($penj)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($penj as $penj) {
                                        $tgl        = explode('-', $penj->tgl_masuk);
                                        $sales      = $this->ion_auth->user($penj->id_user)->row();
                                        $sql_lokasi = $this->db->where('no_nota', $penj->no_nota)->get('tbl_trans_jual_lokasi')->row();
                                        $cabang     = $this->db->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                                        
                                        ?>
                                        <?php echo form_open(base_url('cart/set_lokasi_rak.php')) ?>
                                        <?php echo form_hidden('id', $penj->id) ?>
                                        <?php echo form_hidden('no_nota', $penj->no_nota) ?>
                                        <?php echo form_hidden('halaman', $this->input->get('halaman')) ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo anchor('page=transaksi&act=trans_jual_detail&id=' . general::enkrip($penj->no_nota), '#' . $penj->no_nota.'@'.$cabang->keterangan, 'class="text-default"') ?></td>
                                            <td style="width: 345px;">
                                                <?php // echo form_input(array('name'=>'lokasi', 'class'=>'form-control', 'style'=>'width: 100px;')) ?>
                                                <select id="lokasi" name="lokasi" class="form-control select2">
                                                    <option value="">- [Pilih] -</option>
                                                    <?php
                                                    $lokasi = $this->db->get('tbl_m_lokasi')->result();
                                                    if (!empty($lokasi)) {
                                                        foreach ($lokasi as $lokasi) {
//                                                            $sql_tipe = $this->db->where('id', $lokasi->id_grup)->get('tbl_m_pelanggan_grup')->row();
                                                            ?>
                                                            <option value="<?php echo $lokasi->id ?>" <?php echo ($lokasi->id == $sql_lokasi->id_lokasi ? 'selected' : '') ?>><?php echo '[' . $lokasi->kode . '] ' . $lokasi->keterangan ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                            </td>
                                            <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                            
                                            <td><?php echo $sales->first_name ?></td>
                                        </tr>
                                        <?php echo form_close() ?>
                                        <?php $sql_rak = $this->db->select('tbl_trans_jual_lokasi.id, tbl_m_lokasi.keterangan')->join('tbl_m_lokasi','tbl_m_lokasi.id=tbl_trans_jual_lokasi.id_lokasi')->where('no_nota', $penj->no_nota)->get('tbl_trans_jual_lokasi')->result() ?>
                                        <?php foreach ($sql_rak as $rak){ ?>
                                        <tr>
                                            <td colspan="2"><?php echo nbs() ?></td>
                                            <td colspan="5"><?php echo anchor(base_url('cart/trans_lokasi_hapus.php?id=' . general::enkrip($rak->id).'&halaman='.$this->input->get('halaman')), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus ?\')"').nbs(2).$rak->keterangan ?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (!empty($pagination)) { ?>
                        <div class="box-footer">                        
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php echo $pagination ?>
                            </ul>
                        </div>
                    <?php } ?>
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

<!-- Page script -->


<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<script>
    $(function () {
        $('.select2').select2();
//         Tanggale Nota
        $('#tgl').datepicker({
            autoclose: true,
        });

//        Autocomplete Nyari Kasir
        $('#cari_kasir').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo site_url('page=transaksi&act=json_kasir') ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            select: function (event, ui) {
                var $itemrow = $(this).closest('tr');
                // Populate the input fields from the returned values
                $itemrow.find('#cari_kasir').val(ui.item.nama);
                $('#cari_kasir').val(ui.item.nama);
                $('#kasir').val(ui.item.id);

                // Give focus to the next input field to recieve input from user
                $('#cari_kasir').focus();
                return false;
            }
            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.nama + "</a>")
                    .appendTo(ul);
        };
    });
</script>