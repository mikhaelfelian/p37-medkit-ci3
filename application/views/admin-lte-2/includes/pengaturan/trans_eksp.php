<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Ekspor <small>Data</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Ekspor</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12"></div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Log Ekspor</h3>
                    </div>
                    <div class="box-body">
                        <button class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('sinkronisasi/export_create.php') ?>'"><i class="fa fa-download"></i> EKSPOR</button>
                        <br/>
                        <br/>
                        <table class="table table-striped">
                            <tr>
                                <th style="width: 25px;">No.</th>
                                <th style="width: 150px;">Tgl</th>
                                <th>File</th>
                                <th></th>
                            </tr>
                            <?php $no = 1 ?>
                            <?php foreach ($trans_exp->result() as $exp){ ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $this->tanggalan->tgl_indo($exp->tgl).' '.$exp->jam ?></td>
                                <td><?php echo anchor(base_url('sinkronisasi/export_download.php?file='.$exp->file),$exp->file) ?></td>
                                <td>
                                    <?php echo anchor(base_url('sinkronisasi/export_download.php?file='.$exp->file),'<i class="fa fa-download"></i> Unduh','class=""').nbs(2) ?>
                                    <?php echo anchor(base_url('sinkronisasi/export_hapus.php?id='.general::enkrip($exp->id).'&file='.$exp->file),'<i class="fa fa-remove"></i> Hapus','class="text-danger" onclick="return confirm(\'Hapus ?\')"') ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php if(isset($_GET['file'])){ ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Raw Eksport Data</h3>
                    </div>
                    <div class="box-body">
                        <pre>
                            <?php print_r($raw_data) ?>
                        </pre>
                        <!--<button class="btn btn-danger btn-flat" onclick="window.location.href = 'http://sia.tunasharumbangsa.sch.id/index.php?page=pengaturan&act=pulito_download'"><i class="fa fa-download"></i> Download</button>-->
                        <?php echo br(2) ?>
                        <?php
                        ?>
<!--                        <textarea class="form-control" rows="50">
                            <?php // echo json_encode(array('tbl_trans_jual' => $trans_back)); ?>
                        </textarea>-->
                    </div>
                </div>
            </div>            
            <div class="col-lg-12">
                <div class="alert alert-warning">
                    <label>Anda Menggunakan :</label>
                    Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.84 Safari/537.36                
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>
<script>
    $(function () {
        $('#cekAbeh').click(function () {
            $('input:checkbox').prop('checked', true);
            $(".itemnya").css("background", "yellow");
            $('#apusPilih').show();
        });

        $('#cekAbehIlang').click(function () {
            $('input:checkbox').prop('checked', false);
            $(".itemnya").css("background", "#f4f4f4");
            $('#apusPilih').hide();
        });

        $('#apusPilih').hide();
        $('#apusPilih').click(function () {
            $('#HapusBanyak').submit();
        });

        /* The todo list plugin */
        $(".todo-list").todolist({
            onCheck: function (ele) {
                $(this).css("background", "yellow");
                $('#apusPilih').show();
                return ele;
            },
            onUncheck: function (ele) {
                $(this).css("background", "#f4f4f4");
                $('#apusPilih').hide();
                return ele;
            }
        });
    });
</script>