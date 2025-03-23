<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Medical Checkup</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical Checkup</a></li>
                        <li class="breadcrumb-item active">Tindakan</li>
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
                <div class="col-lg-8">
                    <!-- Default box -->
                    <?php
                    $case = $this->input->get('act');
                    switch ($case) {

                        default:
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_rm_index', $data);
                            break;

                        case 'rm_input':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_rm_input', $data);
                            break;

                        case 'rm_ubah':
                            $data['sql_medc_rm_rw'] = $sql_medc_rm_rw;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_rm_input', $data);
                            break;

                        case 'rm_detail':
                            $data['sql_medc_rm_rw'] = $sql_medc_rm_rw;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_rm_detail', $data);
                            break;
                    }
                    ?>
                    <!-- /.card -->
                </div>
                <div class="col-lg-4">
                    <?php $data['gtotal'] = $gtotal ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan', $data) ?>
                </div>
            </div>
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

<!--TinyMCE Editor-->
<script src="https://cdn.tiny.cloud/1/791yvh8m8x15hn314u1az9ucxk0sz0qflojtqo5y4z1ygmbm/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        /*
        tinymce.init({
            selector: 'textarea',
            menubar: '',
            toolbar_location: 'bottom',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | bold italic underline | numlist bullist | charmap | removeformat',
            height: "250",
            typography_default_lang: 'en-US',
            charmap_append: [
                <?php // for($x = 28; $x <=42; $x++){ ?>
                   ["85<?php // echo $x ?>","sepertiga"],
                <?php // } ?>              
            ]
        });
        */
        

        <?php if(!empty($sql_medc_rm_rw)){ ?>
        // Autocomplete INA-CBG
        $('#icd').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('medcheck/json_icd.php?status=2') ?>",
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
                //Populate the input fields from the returned values
                $itemrow.find('#id_icd').val(ui.item.id);
                $('#id_icd').val(ui.item.id);
                $('#icd').val(ui.item.diagnosa_en);

                // Give focus to the next input field to recieve input from user
                $('#icd').focus();
                return false;
            }

            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>[" + item.kode + "] " + item.diagnosa_en + "</a>")
                    .appendTo(ul);
        };
        <?php } ?>

<?php echo $this->session->flashdata('medcheck_toast'); ?>
    });
</script>