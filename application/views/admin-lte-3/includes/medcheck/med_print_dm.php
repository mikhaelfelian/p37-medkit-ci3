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
                <th rowspan="3" style="border-bottom: 1px solid #000;">
                    <img src="<?php echo base_url('/assets/theme/admin-lte-3/dist/img/kop_es_bw_197x234.png') ?>" width="75px" height="82px">                   
                </th>
                <th style="width: 75px; text-align: center; font-size: 18px; color: #00A650;" colspan="5">
                    <?php echo $setting->judul ?>
                    <!--<img src="<?php echo base_url('/assets/theme/admin-lte-3/dist/img/kop.png') ?>" width="365px" height="82px">-->
                </th>
            </tr>
            <tr>
                <td style="width: 75px; text-align: center; font-size: 11px; color: #00A650;" colspan="5">
                    <?php echo $setting->alamat ?>
                </td>
            </tr>
            <tr>
                <td style="width: 75px; text-align: center; font-size: 11px; border-bottom: 1px solid #000; color: #00A650;" colspan="5">
                    <?php echo $setting->tlp ?> / <?php echo $setting->email ?>
                </td>
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
                <th style="width: 50px; text-align: left; font-size: 11px;">Telp / HP</th>
                <th style="font-size: 11px;">:</th>
                <td style="font-size: 11px;"><?php echo $sql_pasien->no_hp ?></td>

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
                <?php $sql_det = $this->db->where('id_medcheck', $det->id_medcheck)->where('id_item_kat', $det->id_item_kat)->where('status_pkt', '0')->where('jml >=', '0')->get('tbl_trans_medcheck_det')->result(); ?>
                <tr>
                    <th style="text-align: left; font-size: 11px;" colspan="6"><?php echo $sql_kat->keterangan . ' (' . $sql_kat->kategori . ')'; ?></th>
                </tr>
                <?php $subtotal = 0; ?>
                <?php foreach ($sql_det as $medc) { ?>
                    <?php 
                        // Calculate subtotal: (harga - diskon - potongan) * jml
                        $item_subtotal  = (($medc->harga - $medc->diskon) * $medc->jml) - $medc->potongan;
                        $subtot         = $subtot + $item_subtotal;
                    ?>
                    <?php $total_item = $item_subtotal; ?>
                    <?php $total_hrg  = $item_subtotal; ?>
                    <?php $total_disk = $medc->diskon + $medc->potongan; ?>
                    <tr>
                        <td style="text-align: left; font-size: 11px;"><?php echo ($medc->status_rc == '1' ? ' -<i>'.$medc->item.'</i>' : $medc->item); ?></td>
                        <td style="text-align: center; font-size: 11px;"><?php echo (float) $medc->jml; ?></td>
                        <td style="text-align: center; font-size: 11px;">Rp.</td>
                        <td style="text-align: right; font-size: 11px;"><?php echo general::format_angka($medc->harga); ?></td>
                        <td style="text-align: center; font-size: 11px;">Rp.</td>
                        <td style="text-align: right; font-size: 11px;"><?php echo general::format_angka($item_subtotal); ?></td>
                    </tr>
                    <tr>
                    <td style="text-align: right; font-size: 11px; font-style: italic;" colspan="2"><?php echo ($medc->disk1 != '0.00' ? 'disk : '.(float)$medc->disk1 : '').($medc->disk2 != '0.00' ? ' + '.(float)$medc->disk2 : '').($medc->disk3 != '0.00' ? ' + '.(float)$medc->disk3 : '').($medc->disk1 != '0.00' || $medc->disk2 != '0.00' || $medc->disk3 != '0.00' ? '%' : '').($medc->potongan > 0 ? ' pot : '.general::format_angka($medc->potongan) : ''); ?></td>
                        <td style="text-align: center; font-size: 11px; font-style: italic;"></td>
                        <td style="text-align: right; font-size: 11px; font-style: italic;"><?php echo (!empty($total_disk) ? '('.general::format_angka($total_disk).')' : ''); ?></td>
                        <td style="text-align: center; font-size: 11px; font-style: italic;"></td>
                        <td style="text-align: right; font-size: 11px; font-style: italic;"></td>
                    </tr>
                    <?php foreach (json_decode($medc->resep) as $racikan) { ?>
                        <tr>
                            <td style="text-align: left; font-size: 11px;"><?php echo '-'.$racikan->item; ?></td>
                            <td style="text-align: center; font-size: 11px;"><?php echo (float) $racikan->jml; ?></td>
                            <td style="text-align: center; font-size: 11px;">Rp.</td>
                            <td style="text-align: right; font-size: 11px;"><?php echo general::format_angka($racikan->subtotal); ?></td>
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
                $jml_ongkir     = $sql_medc->jml_ongkir;
                $jml_total      = $sql_medc_sum->subtotal + $sql_medc_sum->diskon + $sql_medc_sum->potongan; // + $sql_medc_sum->potongan_poin;
                $jml_diskon     = $jml_total - $sql_medc_sum->subtotal; // $sql_medc->jml_total - $sql_medc->jml_subtotal;
                
                // Fix for division by zero error
                $diskon = 0;
                if ($jml_total > 0) {
                    $diskon = ($jml_diskon / $jml_total) * 100;
                }
                
                $jml_subtotal   = $sql_medc->jml_total - $sql_medc_sum->diskon - $sql_medc_sum->potongan - $sql_medc_sum->potongan_poin; // $sql_medc_sum->subtotal + $jml_ongkir;
            ?>
            <tr>
                <td colspan="2" style="text-align: left; font-weight: bold; font-size: 9px; border-top: 1px dashed #000;"><?php echo $sql_platform->platform ?></td>
                <td colspan="2" style="text-align: right; font-weight: bold; font-size: 11px; border-top: 1px dashed #000;">Grand Total</td>
                <td style="text-align: center; font-size: 11px; font-weight: bold; border-top: 1px dashed #000;">Rp.</td>
                <td style="text-align: right; font-weight: bold; font-size: 11px; border-top: 1px dashed #000;"><?php echo general::format_angka($sql_medc->jml_total); ?></td>
            </tr>            
            <tr>
                <td colspan="2" style="text-align: left; font-weight: bold; font-size: 9px;">PARAF</td>
                <td colspan="2" style="text-align: right; font-weight: bold; font-size: 11px;">Disc (<?php echo (float) round($diskon, 1) ?>%)</td>
                <td style="text-align: center; font-size: 11px; font-weight: bold;">Rp.</td>
                <td style="text-align: right; font-weight: bold; font-size: 11px;">-<?php echo general::format_angka($jml_diskon) ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left; font-weight: bold; font-size: 9px;">Poin : <?php echo ($sql_pasien_poin->jml_poin <= 0 ? 0 : (float)$sql_pasien_poin->jml_poin) ?></td>
                <td colspan="2" style="text-align: right; font-weight: bold; font-size: 11px;">Pot Poin</td>
                <td style="text-align: center; font-size: 11px; font-weight: bold;">Rp.</td>
                <td style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo general::format_angka($sql_medc->jml_potongan_poin) ?></td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align: left; font-weight: bold; font-size: 11px;">
                    <?php if(!empty($sql_medc->ttd_obat)){ ?>
                        <!--<img src="<?php // echo base_url($sql_medc->ttd_obat) ?>" style="width: 50px;">-->
                    <?php } ?>
                </td>
                <td colspan="3" style="text-align: right; vertical-align: top; font-weight: bold; font-size: 11px;">Harus Dibayar</td>
                <td style="text-align: center; vertical-align: top; font-size: 11px; font-weight: bold;">Rp.</td>
                <td style="text-align: right; vertical-align: top; font-weight: bold; font-size: 11px;"><?php echo general::format_angka($jml_subtotal) ?></td>
            </tr>
            <?php $jml_tot_byr = 0; ?>
            <?php foreach ($sql_medc_plat as $plat) { ?>
                <?php $sql_plat = $this->db->where('id', $plat->id_platform)->get('tbl_m_platform')->row() ?>
                <?php $jml_tot_byr = $jml_tot_byr + $plat->nominal; ?>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo $sql_plat->platform ?></td>
                    <td style="text-align: center; font-size: 11px; font-weight: bold;">Rp.</td>
                    <td style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo general::format_angka($plat->nominal) ?></td>
                </tr>
            <?php } ?>
            <?php $kembali      = $jml_tot_byr - $jml_subtotal; ?>
            <?php $jml_kembali  = ($kembali > 0 ? $kembali : 0); ?>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold; font-size: 11px;">Kembali</td>
                <td style="text-align: center; font-size: 11px; font-weight: bold;">Rp.</td>
                <td style="text-align: right; font-weight: bold; font-size: 11px;"><?php echo general::format_angka($jml_kembali) ?></td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: center; border-top: 1px double #000; font-size: 11px;">Terimakasih atas kunjungannya, semoga lekas sembuh</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: center; border-bottom: 1px double #000; font-size: 15px;">Transaksi yang sudah dibayar tidak dapat dibatalkan</td>
            </tr>
        </table>
        <br/>
        <button id="printPageButton" onclick="javascript:window.print()">Cetak</button>
    </body>
</html>