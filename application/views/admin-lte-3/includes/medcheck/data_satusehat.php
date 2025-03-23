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
                        <li class="breadcrumb-item active">Log Satu Sehat</li>
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
                            <h3 class="card-title">Data Satu Sehat</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php echo $this->session->flashdata('medcheck'); ?>
                            
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tgl</th>
                                        <th>No Register</th>
                                        <th>Status</th>
                                        <th>Response</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($sql_log)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($sql_log as $det) {
                                            $err = json_decode($det->response_status);
                                            ?>
                                            <tr>
                                                <td class="text-center" style="width: 50px;"><?php echo $no++ ?>.</td>
                                                <td style="width: 150px; font-color: #fff;">
                                                    <?php echo $this->tanggalan->tgl_indo5($det->postdate) ?>
                                                </td>
                                                <td style="width: 100px; font-color: #fff;">
                                                    <?php if($det->id_medcheck != 0){ ?>
                                                        <?php echo anchor(base_url('medcheck/tindakan.php?id='.general::enkrip($det->id_medcheck)), $det->no_register, 'target="_blank"') ?>
                                                    <?php }else{ ?>
                                                        <?php echo $det->no_register ?>
                                                    <?php } ?>
                                                </td>
                                                <td style="width: 150px; font-color: #fff;">
                                                    <?php echo $det->status ?>
                                                </td>
                                                <td style="width: 400px; font-color: #fff;">
                                                    <?php 
                                                        $r = 1;
                                                        foreach ($err as $err){ 
                                                            echo $r.'. '.$err->details->text.br();
                                                            
                                                            $r++;
                                                        }
                                                    ?>
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
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- /.content-wrapper -->
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#tgl").datepicker({
            format: 'dd/mm/yyyy',
            //defaultDate: "+1w",
//            SetDate: new Date(),
            changeMonth: true,
//            minDate: dateToday,
            autoclose: true
        });

//        // Data Pasien
//        $('#pasien').autocomplete({
//            source: function (request, response) {
//                $.ajax({
//                    url: "<?php // echo base_url('medcheck/json_medcheck_ant.php')  ?>",
//                    dataType: "json",
//                    data: {
//                        term: request.term
//                    },
//                    success: function (data) {
//                        response(data);
//                    }
//                });
//            },
//            minLength: 1,
//            select: function (event, ui) {
//                var $itemrow = $(this).closest('tr');
//                //Populate the input fields from the returned values
//                $itemrow.find('#id_daftar').val(ui.item.id);
//                $('#id_daftar').val(ui.item.id);
//                $('#no_antrian').val(ui.item.no_urut);
//                $('#pasien').val(ui.item.nama2);
//
//                // Give focus to the next input field to recieve input from user
//                $('#pasien').focus();
//                return false;
//            }
//
//            // Format the list menu output of the autocomplete
//        }).data("ui-autocomplete")._renderItem = function (ul, item) {
//            return $("<li></li>")
//                    .data("item.autocomplete", item)
//                    .append("<a>" + item.nama2 + "</a> <a>(" + item.jns_klm + ")</a></br><a>" + item.tgl_lahir + "</a></br><a>" + item.alamat + "</a><br/>-------------------------------------------------------------------------------------</a>")
//                    .appendTo(ul);
//        };
    });
</script>