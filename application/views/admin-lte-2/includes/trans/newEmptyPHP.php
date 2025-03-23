                                                            <td class="text-right" colspan="6">
                                                                <?php echo form_open(base_url('transaksi/set_nota_jual_upd_item.php')) ?>
                                                                <?php echo form_hidden('id', $this->input->get('id')) ?>
                                                                <?php echo form_hidden('id_satuan', general::enkrip($penj_det->id_satuan)) ?>
                                                                <?php echo form_hidden('id_produk', general::enkrip($produk->id)) ?>
                                                                <?php echo form_hidden('aid', $this->input->get('aid')) ?>
                                                                <div class="input-group date">
                                                                    <select name="edit_satuan" class="form-control">
                                                                        <?php foreach ($sql_satuan as $satuan){ ?>
                                                                            <option value="<?php echo $satuan->satuanBesar ?>" <?php echo ($penj_det->satuan == $satuan->satuan ? 'selected' : '') ?>><?php echo ucwords($satuan->satuanBesar) ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span class="input-group-addon no-border text-bold">&nbsp;</span>
                                                                    <?php echo form_input(array('id'=>'edit_harga', 'name'=>'edit_harga', 'class'=>'form-control', 'value'=>$penj_det->harga)) ?>
                                                                    <span class="input-group-addon no-border text-bold">&nbsp;</span>
                                                                    <?php echo form_input(array('id' => 'edit_jml', 'name' => 'edit_jml', 'class' => 'form-control', 'value'=>$penj_det->jml, 'style'=>'width: 50px;')) ?>
                                                                    <span class="input-group-addon no-border text-bold">&nbsp;</span>
                                                                    <select name="edit_satuan" class="form-control">
                                                                        <?php foreach ($sql_satuan as $satuan){ ?>
                                                                            <option value="<?php echo $satuan->satuanBesar ?>" <?php echo ($penj_det->satuan == $satuan->satuan ? 'selected' : '') ?>><?php echo ucwords($satuan->satuanBesar) ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span class="input-group-addon no-border text-bold">&nbsp;</span>
                                                                    <!--<span class="input-group-addon no-border"><?php echo general::format_angka($penj_det->subtotal, 0) ?></span>-->
                                                                    <!--<span class="input-group-addon no-border text-bold"></span>-->
                                                                    <button type="button" class="btn btn-flat btn-danger" style="vertical-align: text-bottom; margin-bottom: 4px;" onclick="window.location.href='<?php echo base_url('transaksi/trans_jual_edit.php?id='.$this->input->get('id').'#item'.$penj_det->id) ?>'"><i class="fa fa-close"></i></button>
                                                                    <?php echo nbs() ?>
                                                                    <button type="submit" class="btn btn-flat btn-success" style="vertical-align: text-bottom; margin-bottom: 4px;"><i class="fa fa-save"></i></button>
                                                                </div>
                                                                <?php echo form_close() ?>
                                                            </td>