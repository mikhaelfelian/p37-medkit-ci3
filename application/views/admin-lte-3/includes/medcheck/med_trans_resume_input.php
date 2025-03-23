<?php echo form_open_multipart(base_url('medcheck/'.(isset($sql_medc_resm_hs->id) ? 'set_medcheck_resm_hsl_upd' : 'set_medcheck_resm_hsl').'.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_resume', general::enkrip($sql_medc_rsm_rw->id)); ?>
<?php echo form_hidden('id_resume_hsl', general::enkrip($sql_medc_resm_hs->id)); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?> 
<?php echo form_hidden('route', $this->input->get('route')); ?>

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">RESUME MCU - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">                    
                <?php $hasError = $this->session->flashdata('form_error'); ?>
                <?php if ($this->session->flashdata('medcheck')): ?>
                    <?php echo $this->session->flashdata('medcheck'); ?>
                <?php endif; ?>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Pemeriksaan</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <select name="pemeriksaan" id="pemeriksaan" class="form-control select2bs4 rounded-0<?php echo (!empty($hasError['pemeriksaan']) ? ' is-invalid' : ''); ?>">
                                <option value="">-- Pilih Pemeriksaan --</option>
                                <?php 
                                if(isset($sql_header) && !empty($sql_header)): 
                                    foreach($sql_header as $header): 
                                ?>
                                    <option value="<?php echo $header->id; ?>" <?php echo ($sql_medc_resm_hs->id_mcu_header == $header->id || $sql_medc_resm_hs->param == $header->param) ? 'selected' : ''; ?>><?php echo $header->param; ?></option>
                                <?php 
                                    endforeach; 
                                endif; 
                                ?>
                            </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#paramModal"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Hasil</label>
                    <div class="col-sm-8">
                        <?php echo form_input(array('id' => 'hasil', 'name' => 'hasil', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['pemeriksaan']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Hasil ...', 'value' => $sql_medc_resm_hs->param_nilai)) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?id='.general::enkrip($sql_medc->id).'&status='.$this->input->get('status')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- /.card -->
<?php echo form_close() ?>

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">HASIL RESUME MEDIS</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-left">Pemeriksaan</th>
                            <th class="text-left">Hasil</th>
                            <th class="text-center">#</th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sql_medc_rsm_dt as $det) { ?>
                            <tr>
                                <td class="text-center"><?php echo $no; ?>.</td>
                                <td class="text-left text-bold"><?php echo $det->param; ?></td>
                                <td class="text-left"><?php echo $det->param_nilai; ?></td>
                                <td class="text-left">
                                    <?php echo anchor(base_url('medcheck/tambah.php?act=resm_edit&id='.general::enkrip($sql_medc->id).'&id_resm='.$this->input->get('id_resm').'&status=' . $this->input->get('status').'&id_item='.general::enkrip($det->id)), '<i class="fas fa-edit"></i> Ubah', 'class="btn btn-primary btn-flat btn-xs" style="width: 65px;"') ?>
                                    <?php echo anchor(base_url('medcheck/resume/hapus_hsl.php?act=' . $this->input->get('act') . '&id=' . general::enkrip($sql_medc->id) . '&id_resm='.$this->input->get('id_resm'). '&status=' . $this->input->get('status').'&item_id='.general::enkrip($det->id)), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $det->param . '] ?\')" style="width: 65px;"') ?>
                                </td>
                            </tr>
                            <?php $no++ ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <?php if ($sql_medc->status >= 5) { ?>
                    <!--<button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php // echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?id='.general::enkrip($sql_medc->id).'&status='.$this->input->get('status')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>-->
                <?php } ?>
            </div>
            <div class="col-lg-6 text-right">  
                <?php if (!empty($sql_medc_rsm_dt)) { ?>
                    <?php echo anchor(base_url('medcheck/surat/cetak_pdf_rsm_lab.php?id='.$this->input->get('id').'&id_resm='.$this->input->get('id_resm')), '<i class="fas fa-print"></i> Cetak', 'class="btn btn-primary btn-flat" target="_blank"') ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- /.card -->

<!-- Modal -->
<div class="modal fade" id="paramModal" tabindex="-1" role="dialog" aria-labelledby="paramModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paramModalLabel">Tambah Parameter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="paramForm" method="post">
        <div class="modal-body">
          <div id="paramAlert"></div>
          <div class="form-group">
            <label for="param">Parameter</label>
            <?php echo form_input(array('id' => 'param', 'name' => 'param', 'class' => 'form-control rounded-0', 'placeholder' => 'Masukkan parameter...', 'required' => 'required')) ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary rounded-0">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $('#paramForm').on('submit', function(e) {
    e.preventDefault();
    
    var param = $('#param').val();
    
    if (!param) {
      $('#paramAlert').html('<div class="alert alert-danger">Parameter tidak boleh kosong!</div>');
      return false;
    }
    
    $.ajax({
      url: '<?php echo base_url('medcheck/add_param.php') ?>',
      type: 'POST',
      data: { 
        param: param,
        table: 'tbl_m_mcu_header'
      },
      dataType: 'json',
      beforeSend: function() {
        $('#paramAlert').html('<div class="alert alert-info">Menyimpan parameter...</div>');
      },
      success: function(response) {
        if (response.status) {
            $('#paramAlert').html('<div class="alert alert-success">' + response.message + '</div>');
            
            // Refresh the dropdown with the new parameter
            var newOption = new Option(param, response.data.id, true, true);
            $('#pemeriksaan').append(newOption).trigger('change');
            
            // Clear the form
            $('#param').val('');
            
            // Close the modal after 2 seconds
            setTimeout(function() {
              $('#paramModal').modal('hide');
            }, 2000);
        } else {
          $('#paramAlert').html('<div class="alert alert-danger">' + response.message + '</div>');
        }
      },
      error: function(xhr, status, error) {
        $('#paramAlert').html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
      }
    });
    
    return false;
  });
});
</script>
