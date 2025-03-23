<!-- HEADER -->
<table border="0" style="width: 365px;" cellspacing="0">
    <tr>
        <th style="width: 75px; text-align: left; font-size: 11px;" colspan="6">
            <img src="<?php echo base_url('/assets/theme/admin-lte-3/dist/img/kop.png') ?>" width="365px">
        </th>
    </tr>
    <tr>
        <th style="width: 65px; text-align: left; font-size: 11px;">No. Faktur</th>
        <th style="font-size: 11px;">:</th>
        <td style="font-size: 11px;"><?php echo (!empty($sql_medc->no_nota) ? $sql_medc->no_nota : '') ?></td>

        <th style="width: 50px; text-align: left; font-size: 11px;">No. RM</th>
        <th style="font-size: 11px;">:</th>
        <td style="font-size: 11px;"><?php echo $sql_pasien->kode_dpn . $sql_pasien->kode ?></td>
    </tr>
    <tr>
        <th style="width: 50px; text-align: left; font-size: 11px;">Nama</th>
        <th style="font-size: 11px;">:</th>
        <td style="font-size: 11px;"><?php echo $sql_pasien->nama_pgl ?></td>

        <th style="width: 50px; text-align: left; font-size: 11px;">Tanggal</th>
        <th style="font-size: 11px;">:</th>
        <td style="font-size: 11px;"><?php echo $this->tanggalan->tgl_indo2($sql_medc->tgl_masuk) ?><br/><?php echo $this->tanggalan->wkt_indo($sql_medc->tgl_masuk) ?> - <?php echo $this->tanggalan->wkt_indo($sql_medc->tgl_keluar) ?></td>
    </tr>
    <tr>
        <th style="width: 50px; text-align: left; font-size: 11px;">Tgl Lahir</th>
        <th style="font-size: 11px;">:</th>
        <td style="font-size: 11px;"><?php echo $this->tanggalan->tgl_indo2($sql_pasien->tgl_lahir) ?></td>

        <th style="width: 50px; text-align: left; font-size: 11px;">Poli</th>
        <th style="font-size: 11px;">:</th>
        <td style="font-size: 11px;"><?php echo $sql_poli->lokasi ?></td>
    </tr>
    <tr>
        <th style="width: 50px; text-align: left; font-size: 11px;">Telp</th>
        <th style="font-size: 11px;">:</th>
        <td style="font-size: 11px;"><?php echo $sql_medc->no_hp ?></td>

        <th style="width: 50px; text-align: left; font-size: 11px;">Kasir</th>
        <th style="font-size: 11px;">:</th>
        <td style="font-size: 11px;"><?php echo $this->ion_auth->user()->row()->first_name ?></td>
    </tr>
</table>
<!--
<table class="header">
  <tbody>
    <tr>
      <td class="half-header">
        <p>
          No Faktur: {{ $pay->invoice_number }}<br>
          Tanggal: {{ $pay->medicalcheck->checkin_at->format('d M Y') }}
        </p>
      </td>
      <td class="half-header">
        <p>
          No RM: {{ $pay->medicalcheck->patient->member_number }}<br>
          Pasien: {{ $pay->medicalcheck->patient->fullname }}
        </p>
      </td>
    </tr>
  </tbody>
</table>
-->
<!-- BODY -->
<?php $number = 0; ?>
<table class="body">
    <tbody>
        <?php foreach ($sql_medc_det as $det) { ?>
            <?php $sql_kat = $this->db->where('id', $det->id_item_kat)->get('tbl_m_kategori')->row(); ?>
            <?php $sql_det = $this->db->where('id_medcheck', $det->id_medcheck)->where('id_item_kat', $det->id_item_kat)->get('tbl_trans_medcheck_det')->result(); ?>
            
            <tr class="header">
                <th width="43%"><?php echo $sql_kat->keterangan . ' (' . $sql_kat->kategori . ')'; ?></th>
                <th class="text-center" width="25%">Harga</th>
                <th class="text-center" width="6%">Jml</th>
                <th class="text-right" width="26%">Total</th>
            </tr>
            <?php $subtotal = 0; ?>
            <?php foreach ($sql_det as $medc) { ?>
                <tr class="item">
                    <td><?php echo $medc->item; ?></td>
                    <td class="text-center"><?php echo general::format_angka($medc->harga); ?></td>
                    <td class="text-center">
                        <?php echo (float) $medc->jml; ?>
                    </td>
                    <td class="text-right">
                        <?php echo general::format_angka($medc->subtotal); ?>
                    </td>
                </tr>
                <?php $subtotal += $medc->subtotal; ?>
            <?php } ?>
            <tr class="subtotal">
                <td colspan="3">
                    Subtotal
                </td>
                <td class="text-right">
                    <?php echo general::format_angka($subtotal); ?>
                </td>
            </tr>
            <?php $number++; ?>
        <?php } ?>
        <!--@if ($pay->medicalcheck->disc_amount > 0)-->
        <!--<tr>-->
            <!--<td class="text-right" colspan="3">-->
                <!--Total Biaya-->
            <!--</td>-->
            <!--<td class="text-right">-->
                <!--{{ i18l_number($pay->subtotal_order) }}-->
            <!--</td>-->
        <!--</tr>-->
        <tr>
            <td class="text-right" colspan="3">
                Disc (<?php echo (float)$sql_medc->diskon ?>%)
            </td>
            <td class="text-right">
                -<?php echo general::format_angka($sql_medc->jml_diskon) ?>
            </td>
        </tr>
        <!--@endif-->
        <tr>
            <td class="text-right" colspan="3"> 
                <strong>
                    Total
                </strong>
            </td>
            <td class="text-right"> 
                <strong>
                    -<?php echo general::format_angka($sql_medc->jml_gtotal) ?>
                </strong>
            </td>
        </tr>

        <!--
        <?php $amont = 0; ?>
        <?php foreach ($pay->medicalcheck->payments as $byr) { ?>
            <?php $jml_byr = $byr->amount; // - $pay->medicalcheck->disc_amount; ?>
            <?php $amont = $amont + $jml_byr; ?>
            <tr>
                <td colspan="2" style="text-align: right; font-weight: bold; font-size: 11px;">Bayar ({{ $byr->method }})</td>
                <td style="text-align: center; font-size: 11px; font-weight: bold;">Rp.</td>
                <td style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo number_format($jml_byr, 0, ',', '.'); ?></td>
            </tr>
        <?php } ?>
        <?php $kembaliam = $amont - ($total - $pay->medicalcheck->disc_amount); ?>
            -->
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold; font-size: 11px;">Kembali</td>
            <td style="text-align: center; font-size: 11px; font-weight: bold;">Rp.</td>
            <td style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo general::format_angka($sql_medc->jml_kembali) ?></td>
        </tr>

        <!--
              @if ($detail)
                @if ($pay->paid_before > 0)
                <tr>
                  <td class="text-right" colspan="3">
                    Sudah Dibayar
                  </td>
                  <td class="text-right" >
                    {{ i18l_number($pay->paid_before) }}
                  </td>
                </tr>
                <tr class="total">
                  <td class="text-right" colspan="3">
                    Belum Dilunasi
                  </td>
                  <td class="text-right" >
                    {{ i18l_number($total - $pay->paid_before) }}
                  </td>
                </tr>
                @endif
              <tr>
                <td class="text-right" colspan="3">
                  Bayar ({{ $pay->method }})
                </td>
                <td class="text-right" >
                  {{ i18l_number($pay->amount) }}
                </td>
              </tr>
              <tr>
                @if (($tot_pay = $pay->paid_before + $pay->amount) < $total)
                <td class="text-right" colspan="3">
                  <strong>Kekurangan</strong>
                </td>
                <td class="text-right">
                  <strong>{{ i18l_number($total - $tot_pay) }}</strong>
                </td>
                @else
                <td class="text-right" colspan="3">
                  Kembali
                </td>
                <td class="text-right">
                  {{ i18l_number($tot_pay - $total) }}
                </td>
                @endif
              </tr>
              <tr class="bill-status">
                <td colspan="4" class="text-center">
                  <strong>
                    @if ($tot_pay >= $total)
                    ---LUNAS---
                    @else
                    ---BELUM LUNAS---
                    @endif
                  </strong>
                </td>
              </tr>
              @endif
        -->
    </tbody>
</table>
<p class="text-center footer">
    Terima kasih atas kunjungannya, semoga lekas sembuh.
</p>