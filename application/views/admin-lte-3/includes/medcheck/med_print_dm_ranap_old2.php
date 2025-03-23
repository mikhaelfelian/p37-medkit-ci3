<html>
    <head>
        <title>INVOICE</title>
        <style>
            @media print {
                html, body {
                    width: 4.5in;
                    /*was 8.5in*/
                    /*height: 13cm; */
                    /*was 5.5in*/
                    display: block;
                    font-family: "Calibri";
                    /*font-size: 10pt; NOT A VALID PROPERTY */
                }

                @page {
                    width: 21cm;
                    height: 13cm;
                    padding: 1cm;
                    margin: 0cm 1.20cm;
                    size:auto;
                    /*size: 21cm 13cm;*/
                    /*size: 11inch 4.5inch;
margin: 10;*/
                }

                #printPageButton {
                    display: none;
                }

                header, footer, aside, nav, form, iframe, .menu, .hero, .adslot {
                    display: none;
                }

                table.myFormat tr td {
                    font-size: 5px;
                }
            }
        </style>
    </head>
    <body>
        <table border="0" style="width: 365px;" cellspacing="0">
            <tr>
                <th style="width: 75px; text-align: left; font-size: 11px;" colspan="6">
                    <img src="<?php echo base_url('/assets/theme/admin-lte-3/dist/img/kop.png') ?>" width="365px" height="82px">
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
                <td style="font-size: 11px;"><?php echo $this->tanggalan->tgl_indo2($sql_medc->tgl_masuk) ?><br/><?php echo $this->tanggalan->wkt_indo($sql_medc->tgl_masuk) ?> - <?php echo $this->tanggalan->wkt_indo($sql_medc->tgl_bayar) ?></td>
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
                <td style="font-size: 11px;"><?php echo (!empty($sql_medc->id_kasir) ? $this->ion_auth->user($sql_medc->id_kasir)->row()->first_name : $this->ion_auth->user()->row()->first_name); ?></td>
            </tr>
        </table>
        <!--=======================================================================================================-->
        <table border="0" style="width: 365px;" cellspacing="0">
            <tr>
                <!--<th style="text-align: left; width: 100px; border-top: 1px dashed #000; border-bottom: 1px dashed #000; font-size: 14px;">Tanggal</th>-->
                <!--<th style="text-align: left; border-top: 1px dashed #000; border-bottom: 1px dashed #000;"></th>-->
                <!--<th style="text-align: left; border-top: 1px dashed #000; border-bottom: 1px dashed #000;">Tgl</th>-->
                <th style="text-align: left; border-top: 1px dashed #000; border-bottom: 1px dashed #000; font-size: 11px;">Item</th>
                <th style="text-align: center; border-top: 1px dashed #000; border-bottom: 1px dashed #000; font-size: 11px;">Jml</th>
                <th style="text-align: center; border-top: 1px dashed #000; border-bottom: 1px dashed #000; font-size: 11px; width: 5px;"></th>
                <th style="text-align: right; border-top: 1px dashed #000; border-bottom: 1px dashed #000; width: 100px; font-size: 11px; width: 50px;">Harga</th>
                <th style="text-align: center; border-top: 1px dashed #000; border-bottom: 1px dashed #000; font-size: 11px; width: 5px;"></th>
                <th style="text-align: right; border-top: 1px dashed #000; border-bottom: 1px dashed #000; width: 100px; font-size: 11px; width: 50px;">Subtotal</th>
            </tr>
            <?php $number = 1; ?>
            <?php $gtotal = 0; ?>
            <?php foreach ($sql_medc_det as $det) { ?>
                <?php $sql_kat = $this->db->where('id', $det->id_item_kat)->get('tbl_m_kategori')->row(); ?>
                <?php $sql_det = $this->db->where('id_medcheck', $det->id_medcheck)->where('id_item_kat', $det->id_item_kat)->get('tbl_trans_medcheck_det')->result(); ?>
                <tr>
                    <!--<th style="text-align: left; font-size: 11px;"></th>-->
                    <!--<th style="text-align: left; border-top: 1px dashed #000; border-bottom: 1px dashed #000;"></th>-->
                    <!--<th style="text-align: left; border-top: 1px dashed #000; border-bottom: 1px dashed #000;">Tgl</th>-->
                    <th style="text-align: left; font-size: 11px;" colspan="6"><?php echo $sql_kat->keterangan . ' (' . $sql_kat->kategori . ')'; ?></th>
                </tr>
                <?php $subtotal = 0; ?>
                <?php foreach ($sql_det as $medc) { ?>
                    <?php $total_item = $medc->potongan + $medc->subtotal; ?>
                    <?php $total_hrg  = $medc->potongan + $medc->subtotal; ?>
                    <tr>
                        <td style="text-align: left; font-size: 11px;"><?php echo $medc->item; ?></td>
                        <td style="text-align: center; font-size: 11px;"><?php echo (float) $medc->jml; ?></td>
                        <td style="text-align: center; font-size: 11px;">Rp.</td>
                        <td style="text-align: right; font-size: 11px;"><?php echo general::format_angka($medc->harga); ?></td>
                        <td style="text-align: center; font-size: 11px;">Rp.</td>
                        <td style="text-align: right; font-size: 11px;"><?php echo general::format_angka($total_hrg); ?></td>
                    </tr>
                    <?php foreach (json_decode($medc->resep) as $racikan) { ?>
                        <tr>
                            <td style="text-align: left; font-size: 11px;"><?php echo '-'.$racikan->item; ?></td>
                            <td style="text-align: center; font-size: 11px;"><?php echo (float) $racikan->jml; ?></td>
                            <td style="text-align: center; font-size: 11px;">Rp.</td>
                            <td style="text-align: right; font-size: 11px;"><?php echo general::format_angka($racikan->subtotal); ?></td>
                            <!--<td style="text-align: center; font-size: 11px;"></td>-->
                            <!--<td style="text-align: right; font-size: 11px;"><?php // echo general::format_angka($medc->subtotal);  ?></td>-->
                        </tr>
                    <?php } ?>
                    <?php $subtotal += $total_item; ?>
                <?php } ?>               
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold; font-size: 11px;">Subtotal</td>
                    <td style="text-align: center; font-size: 11px;font-weight: bold;">Rp.</td>
                    <td style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo general::format_angka($subtotal); ?></td>
                </tr>
                <?php $gtotal = $gtotal + $subtotal; ?>
                <?php $number++; ?>
            <?php } ?>
            <?php 
                $sql_platform   = $this->db->where('id', $sql_medc->metode)->get('tbl_m_platform')->row();
                $jml_total      = $sql_medc_sum->subtotal + $sql_medc_sum->diskon + $sql_medc_sum->potongan + $sql_medc_sum->potongan_poin;
                $jml_diskon     = $jml_total - ($jml_total - $sql_medc->jml_diskon);
                $diskon         = ($jml_diskon / $jml_total) * 100;            
            ?>
            <tr>
                <td colspan="2" style="text-align: left; font-weight: bold; font-size: 9px; border-top: 1px dashed #000;"><?php echo $sql_platform->platform ?></td>
                <td colspan="2" style="text-align: right; font-weight: bold; font-size: 11px; border-top: 1px dashed #000;">Grand Total</td>
                <td style="text-align: center; font-size: 11px; font-weight: bold; border-top: 1px dashed #000;">Rp.</td>
                <td style="text-align: right; font-weight: bold; font-size: 11px; border-top: 1px dashed #000;"><?php echo general::format_angka($jml_total); ?></td>
            </tr>            
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold; font-size: 11px;">Disc (<?php echo (float) number_format($diskon, 1) ?>%)</td>
                <td style="text-align: center; font-size: 11px; font-weight: bold;">Rp.</td>
                <td style="text-align: right; font-weight: bold; font-size: 11px;">-<?php echo general::format_angka($jml_diskon) ?></td>
            </tr>
            <?php $jml_tot_byr = 0; ?>
            <?php foreach ($sql_medc_plat as $plat) { ?>
                <?php $sql_plat = $this->db->where('id', $plat->id_platform)->get('tbl_m_platform')->row() ?>
                <?php $jml_tot_byr = $jml_tot_byr + $plat->nominal; ?>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo $sql_plat->platform ?></td>
                    <td style="text-align: center; font-size: 11px; font-weight: bold;">Rp.</td>
                    <td style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo general::format_angka($plat->nominal) ?></td>
                </tr>
            <?php } ?>
            <?php $kembali      = $jml_tot_byr - $sql_medc_sum->subtotal; ?>
            <?php $jml_kembali  = ($kembali > 0 ? $kembali : 0); ?>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold; font-size: 11px;">Kembali</td>
                <td style="text-align: center; font-size: 11px; font-weight: bold;">Rp.</td>
                <td style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo general::format_angka($jml_kembali) ?></td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: center; border-top: 1px double #000; border-bottom: 1px double #000; font-size: 11px;">Terimakasih atas kunjungannya, semoga lekas sembuh</td>
            </tr>
        </table>
        <br/>
        <button id="printPageButton" onclick="javascript:window.print()">Cetak</button>
    </body>
</html>