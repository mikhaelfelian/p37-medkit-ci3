<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] 	                        = "login";
$route['404_override'] 			                        = '';
$route['translate_uri_dashes'] 	                        = FALSE;

/* Dashboard */
$route['home.php']                                      = "home/index";

/* FrontEnd */
$route['cek_login.php']                                 = "login/cek_login";
$route['dashboard.php']                                 = "home/index";

$route['home/register.php']                             = "home/register";

/* BUNDLE SATUSEHAT API */
$route['satusehat/index.php']                           = "Satusehat/index";
$route['satusehat/post_bundle.php']                     = "Satusehat/post_bundle_encounter_condition";

/* Master */
$route['master/index.php']                              = "master/index";

$route['master/data_kategori_list.php']                 = "master/data_kategori_list";
$route['master/data_kategori_tambah.php']               = "master/data_kategori_tambah";
$route['master/data_kategori_simpan.php']               = "master/data_kategori_simpan";
$route['master/data_kategori_update.php']               = "master/data_kategori_update";
$route['master/data_kategori_hapus.php']                = "master/data_kategori_hapus";
$route['master/set_kategori_cari.php']                  = "master/set_kategori_cari";

$route['master/data_merk_list.php']                     = "master/data_merk_list";
$route['master/data_merk_tambah.php']                   = "master/data_merk_tambah";
$route['master/data_merk_simpan.php']                   = "master/data_merk_simpan";
$route['master/data_merk_update.php']                   = "master/data_merk_update";
$route['master/data_merk_hapus.php']                    = "master/data_merk_hapus";
$route['master/set_merk_cari.php']                      = "master/set_merk_cari";

$route['master/data_klinik_list.php']                   = "master/data_klinik_list";
$route['master/data_klinik_tambah.php']                 = "master/data_klinik_tambah";
$route['master/data_klinik_simpan.php']                 = "master/data_klinik_simpan";
$route['master/data_klinik_update.php']                 = "master/data_klinik_update";
$route['master/data_klinik_hapus.php']                  = "master/data_klinik_hapus";
$route['master/set_klinik_cari.php']                    = "master/set_klinik_cari";

$route['master/data_satuan_list.php']                   = "master/data_satuan_list";
$route['master/data_satuan_tambah.php']                 = "master/data_satuan_tambah";
$route['master/data_satuan_simpan.php']                 = "master/data_satuan_simpan";
$route['master/data_satuan_update.php']                 = "master/data_satuan_update";
$route['master/data_satuan_hapus.php']                  = "master/data_satuan_hapus";
$route['master/set_cari_satuan.php']                    = "master/set_cari_satuan";

$route['master/data_barang_list.php']                   = "master/data_barang_list";
$route['master/data_barang_list_arsip.php']             = "master/data_barang_list_arsip";
$route['master/data_barang_list_retur_beli.php']        = "master/data_barang_list_retbeli";
$route['master/data_barang_tambah.php']                 = "master/data_barang_tambah";
$route['master/data_barang_det.php']                    = "master/data_barang_det";
$route['master/data_barang_import.php']                 = "master/data_barang_import";
$route['master/data_barang_export.php']                 = "master/ex_data_barang";
$route['master/data_barang_upload.php']                 = "master/data_barang_upload";
$route['master/data_barang_simpan.php']                 = "master/data_barang_simpan";
$route['master/data_barang_simpan_bom.php']             = "master/data_barang_simpan_bom";
$route['master/data_barang_simpan_bom_input.php']       = "master/data_barang_simpan_bom_input";
$route['master/data_barang_simpan_nom.php']             = "master/data_barang_simpan_nom";
$route['master/data_barang_simpan_sat.php']             = "master/data_barang_simpan_sat";
$route['master/data_barang_update_bom_input.php']       = "master/data_barang_update_bom_input";
$route['master/data_barang_update.php']                 = "master/data_barang_update";
$route['master/data_barang_hapus.php']                  = "master/data_barang_hapus";
$route['master/data_barang_hapus_ars.php']              = "master/data_barang_hapus_arsip";
$route['master/data_barang_hapus_nom.php']              = "master/data_barang_hapus_nom";
$route['master/data_barang_hapus_sat.php']              = "master/data_barang_hapus_sat";
$route['master/data_barang_hapus_ref.php']              = "master/data_barang_hapus_ref";
$route['master/data_barang_hapus_ref_ip.php']           = "master/data_barang_hapus_ref_input";
$route['master/json_item.php']                          = "master/json_item";

$route['master/data_pasien_list.php']                   = "master/data_pasien_list";
$route['master/data_pasien_tambah.php']                 = "master/data_pasien_tambah";
$route['master/data_pasien_det.php']                    = "master/data_pasien_det";
$route['master/data_pasien_simpan.php']                 = "master/data_pasien_simpan";
$route['master/data_pasien_simpan2.php']                = "master/data_pasien_simpan2";
$route['master/data_pasien_update.php']                 = "master/data_pasien_update";
$route['master/data_pasien_hapus.php']                  = "master/data_pasien_hapus";
$route['master/data_pasien_import.php']                 = "master/data_pasien_import";
$route['master/data_pasien_export.php']                 = "master/ex_data_pasien";
$route['master/data_pasien_upload.php']                 = "master/data_pasien_upload";
$route['master/data_pasien_user.php']                   = "master/data_pasien_user";
$route['master/data_pasien_user_reset.php']             = "master/data_pasien_user_reset";
$route['master/data_pasien_foto_reset.php']             = "master/data_pasien_foto_reset";
$route['master/data_pasien_pdf.php']                    = "master/pdf_pasien";

$route['master/data_mcu_list.php']                      = "master/data_mcu_list";
$route['master/data_mcu_tambah.php']                    = "master/data_mcu_tambah";
$route['master/data_mcu_simpan.php']                    = "master/data_mcu_simpan";
$route['master/data_mcu_update.php']                    = "master/data_mcu_update";
$route['master/data_mcu_hapus.php']                     = "master/data_mcu_hapus";
$route['master/set_mcu_cari.php']                       = "master/set_mcu_cari";

$route['master/data_mcu_kat_list.php']                  = "master/data_mcu_kat_list";
$route['master/data_mcu_kat_tambah.php']                = "master/data_mcu_kat_tambah";
$route['master/data_mcu_kat_simpan.php']                = "master/data_mcu_kat_simpan";
$route['master/data_mcu_kat_update.php']                = "master/data_mcu_kat_update";
$route['master/data_mcu_kat_hapus.php']                 = "master/data_mcu_kat_hapus";
$route['master/set_mcu_kat_cari.php']                   = "master/set_mcu_kat_cari";

$route['master/data_mcu_perusahaan_list.php']           = "master/data_mcu_perusahaan_list";
$route['master/data_mcu_perusahaan_tambah.php']         = "master/data_mcu_perusahaan_tambah";
$route['master/set_mcu_perusahaan_simpan.php']          = "master/set_mcu_perusahaan_simpan";
$route['master/set_mcu_perusahaan_update.php']          = "master/set_mcu_perusahaan_update";
$route['master/set_mcu_perusahaan_hapus.php']           = "master/set_mcu_perusahaan_hapus";
$route['master/set_mcu_perusahaan_cari.php']            = "master/set_cari_mcu_perusahaan";

$route['master/data_mcu_header_list.php']               = "master/data_mcu_header";
$route['master/data_mcu_header_param_simpan.php']       = "master/data_mcu_header_simpan";
$route['master/data_mcu_header_hapus.php']              = "master/data_mcu_header_hapus";
$route['master/set_mcu_header_cari.php']                = "master/set_mcu_header_cari";

$route['master/data_icd_list.php']                      = "master/data_icd_list";
$route['master/data_icd_tambah.php']                    = "master/data_icd_tambah";
$route['master/data_icd_simpan.php']                    = "master/data_icd_simpan";
$route['master/data_icd_update.php']                    = "master/data_icd_update";
$route['master/data_icd_hapus.php']                     = "master/data_icd_hapus";


$route['master/data_gudang_list.php']                   = "master/data_gudang_list";
$route['master/data_gudang_tambah.php']                 = "master/data_gudang_tambah";
$route['master/data_gudang_simpan.php']                 = "master/data_gudang_simpan";
$route['master/data_gudang_update.php']                 = "master/data_gudang_update";
$route['master/data_gudang_hapus.php']                  = "master/data_gudang_hapus";


$route['master/data_kamar_list.php']                    = "master/data_kamar_list";
$route['master/data_kamar_tambah.php']                  = "master/data_kamar_tambah";
$route['master/data_kamar_simpan.php']                  = "master/data_kamar_simpan";
$route['master/data_kamar_update.php']                  = "master/data_kamar_update";
$route['master/data_kamar_hapus.php']                   = "master/data_kamar_hapus";

$route['master/data_sales_list.php']                    = "master/data_karyawan_list";
$route['master/data_karyawan_list.php']                 = "master/data_karyawan_list";
$route['master/data_karyawan_tambah.php']               = "master/data_karyawan_tambah";
$route['master/data_karyawan_pend.php']                 = "master/data_karyawan_tambah_pend";
$route['master/data_karyawan_sert.php']                 = "master/data_karyawan_tambah_sert";
$route['master/data_karyawan_peg.php']                  = "master/data_karyawan_tambah_peg";
$route['master/data_karyawan_kel.php']                  = "master/data_karyawan_tambah_kel";
$route['master/data_karyawan_jadwal.php']               = "master/data_karyawan_tambah_jdwl";
$route['master/set_karyawan_simpan.php']                = "master/set_karyawan_simpan";
$route['master/set_karyawan_simpan_pend.php']           = "master/set_karyawan_simpan_pend";
$route['master/set_karyawan_simpan_sert.php']           = "master/set_karyawan_simpan_sert";
$route['master/set_karyawan_simpan_peg.php']            = "master/set_karyawan_simpan_peg";
$route['master/set_karyawan_simpan_kel.php']            = "master/set_karyawan_simpan_kel";
$route['master/set_karyawan_simpan_kel_ktp.php']        = "master/set_karyawan_simpan_kel_ktp";
$route['master/set_karyawan_simpan_jadwal.php']         = "master/set_karyawan_simpan_jdwl";
$route['master/set_karyawan_simpan_cuti.php']           = "master/set_karyawan_simpan_cuti";
$route['master/set_karyawan_update.php']                = "master/set_karyawan_update";
$route['master/set_karyawan_update_kel.php']            = "master/set_karyawan_update_kel";
$route['master/set_karyawan_hapus.php']                 = "master/set_karyawan_hapus";
$route['master/set_karyawan_hapus_pend.php']            = "master/set_karyawan_hapus_pend";
$route['master/set_karyawan_hapus_sert.php']            = "master/set_karyawan_hapus_sert";
$route['master/set_karyawan_hapus_peg.php']             = "master/set_karyawan_hapus_peg";
$route['master/set_karyawan_hapus_kel.php']             = "master/set_karyawan_hapus_kel";
$route['master/set_karyawan_hapus_jadwal.php']          = "master/set_karyawan_hapus_jdwl";
$route['master/data_karyawan_import.php']               = "master/data_karyawan_import";
$route['master/data_karyawan_export.php']               = "master/ex_data_karyawan";
$route['master/data_karyawan_upload.php']               = "master/data_karyawan_upload";

$route['master/data_aps_list.php']                      = "master/data_aps_list";
$route['master/data_aps_tambah.php']                    = "master/data_aps_tambah";
$route['master/set_aps_simpan.php']                     = "master/set_aps_simpan";
$route['master/set_aps_update.php']                     = "master/set_aps_update";
$route['master/set_aps_hapus.php']                      = "master/set_aps_hapus";
$route['master/set_aps_cari.php']                       = "master/set_cari_aps";

$route['master/data_supplier_list.php']                 = "master/data_supplier_list";
$route['master/data_supplier_tambah.php']               = "master/data_supplier_tambah";
$route['master/data_supplier_simpan.php']               = "master/data_supplier_simpan";
$route['master/data_supplier_simpan2.php']              = "master/data_supplier_simpan2";
$route['master/data_supplier_update.php']               = "master/data_supplier_update";
$route['master/data_supplier_hapus.php']                = "master/data_supplier_hapus";
$route['master/data_supplier_import.php']               = "master/data_supplier_import";
$route['master/data_supplier_export.php']               = "master/ex_data_supplier";
$route['master/data_supplier_upload.php']               = "master/data_supplier_upload";
$route['master/set_cari_supplier.php']                  = "master/set_cari_supplier";

$route['master/data_platform_list.php']                 = "master/data_platform_list";
$route['master/data_platform_tambah.php']               = "master/data_platform_tambah";
$route['master/data_platform_simpan.php']               = "master/data_platform_simpan";
$route['master/data_platform_update.php']               = "master/data_platform_update";
$route['master/data_platform_hapus.php']                = "master/data_platform_hapus";

$route['master/data_platform_pjm_list.php']             = "master/data_platform_pjm_list";
$route['master/data_platform_pjm_tambah.php']           = "master/data_platform_pjm_tambah";
$route['master/data_platform_pjm_simpan.php']           = "master/data_platform_pjm_simpan";
$route['master/data_platform_pjm_update.php']           = "master/data_platform_pjm_update";
$route['master/data_platform_pjm_hapus.php']            = "master/data_platform_pjm_hapus";

$route['master/set_cari_kategori.php']                  = "master/set_cari_kategori";
$route['master/set_cari_lokasi.php']                    = "master/set_cari_lokasi";
$route['master/set_cari_merk.php']                      = "master/set_cari_merk";
$route['master/set_cari_promo.php']                     = "master/set_cari_promo";
$route['master/set_cari_barang.php']                    = "master/set_cari_barang";
$route['master/set_cari_barang_retbeli.php']            = "master/set_cari_barang_retbeli";
$route['master/set_cari_satuan.php']                    = "master/set_cari_satuan";
$route['master/set_cari_plgn.php']                      = "master/set_cari_plgn";
$route['master/set_cari_pasien.php']                    = "master/set_cari_pasien";
$route['master/set_cari_karyawan.php']                  = "master/set_cari_karyawan";
$route['master/set_cari_supplier.php']                  = "master/set_cari_supplier";
$route['master/set_cari_platform.php']                  = "master/set_cari_platform";
$route['master/set_cari_icd.php']                       = "master/set_cari_icd";

/* --- GUDANG --- */
$route['gudang/index.php']                              = "gudang/index";
$route['gudang/data_stok_list.php']                     = "gudang/data_stok_list";
$route['gudang/data_stok_tambah.php']                   = "gudang/data_stok_tambah";
$route['gudang/data_stok_update.php']                   = "gudang/data_stok_update";
$route['gudang/data_stok_update_br.php']                = "gudang/data_stok_update_br";
$route['gudang/data_stok_hapus.php']                    = "gudang/data_stok_hapus";
$route['gudang/data_stok_hapus_hist.php']               = "gudang/data_stok_hapus_hist";
$route['gudang/data_stok_det.php']                      = "gudang/data_stok_det";
$route['gudang/data_stok_import.php']                   = "gudang/data_stok_import";
$route['gudang/data_stok_trm_simpan.php']               = "gudang/data_stok_trm_simpan";
$route['gudang/data_stok_export.php']                   = "gudang/ex_data_stok";
$route['gudang/data_stok_export_tmp.php']               = "gudang/ex_data_stok_temp";
$route['gudang/data_stok_export_brc.php']               = "gudang/ex_data_stok_brcd";
$route['gudang/data_stok_op_tmp.php']                   = "gudang/ex_data_op_temp";
$route['gudang/data_stok_upload.php']                   = "gudang/data_stok_upload";
$route['gudang/data_po_list.php']                       = "gudang/data_po_list";
$route['gudang/cetak_data_stok.php']                    = "gudang/cetak_data_stok";
$route['gudang/trans_po_det.php']                       = "gudang/trans_po_det";
$route['gudang/trans_po_terima.php']                    = "gudang/trans_po_terima";
$route['gudang/set_stok_update_gd.php']                 = "gudang/set_stok_update_gd";
$route['gudang/trans_beli_list.php']                    = "gudang/trans_beli_list";
$route['gudang/trans_beli_terima.php']                  = "gudang/trans_beli_terima";
$route['gudang/trans_beli_terima_simpan.php']           = "gudang/trans_beli_terima_simpan";
$route['gudang/trans_beli_terima_hapus.php']            = "gudang/trans_beli_terima_hapus_hist";
$route['gudang/set_beli_terima.php']                    = "gudang/set_beli_terima";
$route['gudang/set_beli_terima_finish.php']             = "gudang/set_beli_terima_finish";
$route['gudang/set_beli_terima_reset.php']              = "gudang/set_beli_terima_reset";
$route['gudang/data_opname_list.php']                   = "gudang/data_opname_list";
$route['gudang/data_opname_item_list.php']              = "gudang/data_opname_item_list";
$route['gudang/data_opname_tambah.php']                 = "gudang/data_opname_tambah";
$route['gudang/data_opname_det.php']                    = "gudang/data_opname_det";
$route['gudang/data_opname_upload.php']                 = "gudang/data_opname_upload";
$route['gudang/set_opname.php']                         = "gudang/set_opname";
$route['gudang/set_opname_batal.php']                   = "gudang/set_opname_batal";
$route['gudang/set_opname_proses.php']                  = "gudang/set_opname_proses";
$route['gudang/set_opname_cari_item.php']               = "gudang/set_opname_cari_item";
$route['gudang/data_opname_dl.php']                     = "gudang/data_opname_dl";
$route['gudang/cart_opn_simpan.php']                    = "gudang/cart_opn_simpan";
$route['gudang/cart_opn_hapus.php']                     = "gudang/cart_opn_hapus";
$route['gudang/data_mutasi.php']                        = "gudang/trans_mutasi_list";
$route['gudang/data_mutasi_terima.php']                 = "gudang/trans_mutasi_list_terima";
$route['gudang/trans_mutasi.php']                       = "gudang/trans_mutasi";
$route['gudang/trans_mutasi_edit.php']                  = "gudang/trans_mutasi_edit";
$route['gudang/trans_mutasi_det.php']                   = "gudang/trans_mutasi_det";
$route['gudang/trans_mutasi_terima.php']                = "gudang/trans_mutasi_terima";
$route['gudang/trans_mutasi_terima_simpan.php']         = "gudang/trans_mutasi_terima_simpan";
$route['gudang/trans_mutasi_terima_hapus.php']          = "gudang/trans_mutasi_terima_hapus_hist";
$route['gudang/trans_mutasi_terima_cek.php']            = "gudang/trans_mutasi_terima_cek";
$route['gudang/set_trans_mutasi.php']                   = "gudang/set_trans_mutasi";
$route['gudang/set_trans_mutasi_update.php']            = "gudang/set_trans_mutasi_update";
$route['gudang/set_trans_mutasi_proses.php']            = "gudang/set_trans_mutasi_proses";
$route['gudang/set_trans_mutasi_batal.php']             = "gudang/set_trans_mutasi_batal";
$route['gudang/set_trans_mutasi_finish.php']            = "gudang/set_trans_mutasi_finish";
$route['gudang/cart_mutasi_simpan.php']                 = "gudang/cart_mutasi_simpan";
$route['gudang/cart_mutasi_hapus.php']                  = "gudang/cart_mutasi_hapus";
$route['gudang/cetak_nota.php']                         = "gudang/trans_mutasi_print_ex_do";
$route['gudang/set_cari_pemb.php']                      = "gudang/set_cari_pemb";
$route['gudang/set_cari_opn.php']                       = "gudang/set_cari_opn";
$route['gudang/set_cari_mutasi.php']                    = "gudang/set_cari_mutasi";
$route['gudang/set_cari_stok.php']                      = "gudang/set_cari_stok";
$route['gudang/set_cari_stok_tambah.php']               = "gudang/set_cari_stok_tambah";
$route['gudang/pdf_data_stok.php']                      = "gudang/pdf_data_stok";
$route['gudang/json_item.php']                          = "gudang/json_item";
/* --- GUDANG --- */

/* --- CETAK --- */
$route['master/cetak_data_satuan.php']                  = "master/cetak_data_satuan";
$route['master/cetak_data_barang.php']                  = "master/cetak_data_barang";
$route['master/cetak_data_customer.php']                = "master/cetak_data_customer";
$route['master/cetak_data_sales.php']                   = "master/cetak_data_sales";
$route['master/cetak_data_supplier.php']                = "master/cetak_data_supplier";
$route['master/pdf_data_satuan.php']                    = "master/pdf_data_satuan";
$route['master/pdf_data_barang.php']                    = "master/pdf_data_barang";
$route['master/pdf_data_customer.php']                  = "master/pdf_data_customer";
$route['master/pdf_data_sales.php']                     = "master/pdf_data_sales";
$route['master/pdf_data_supplier.php']                  = "master/pdf_data_supplier";
/* --- CETAK --- */

/* Medcheck */
// Satu Sehat
$route['medcheck/data_satusehat.php']                   = "medcheck/data_satusehat";

$route['medcheck/register.php']                         = "home/register";
$route['medcheck/set_register.php']                     = "home/set_register";
$route['medcheck/set_pasien.php']                       = "medcheck/set_pasien";
$route['medcheck/set_instansi.php']                     = "medcheck/set_instansi";

// Konfirmasi Pasien Hadir
$route['medcheck/set_pasien_konfirm.php']               = "medcheck/trans_medcheck_dft_konfirm";
$route['medcheck/daftar_konf_simpan.php']               = "medcheck/trans_medcheck_dft_konfirm_simpan";

$route['medcheck/data_pendaftaran.php']                 = "medcheck/trans_medcheck_dft";
$route['medcheck/daftar.php']                           = "medcheck/trans_medcheck_dft_tambah";
$route['medcheck/daftar_simpan.php']                    = "medcheck/trans_medcheck_dft_simpan";
$route['medcheck/daftar_update.php']                    = "medcheck/trans_medcheck_dft_update";
$route['medcheck/daftar_gc.php']                        = "medcheck/trans_medcheck_dft_gc";
$route['medcheck/daftar_gc_ttd.php']                    = "medcheck/trans_medcheck_dft_gc_ttd";
$route['medcheck/daftar_gc_det.php']                    = "medcheck/trans_medcheck_dft_gc_det";
$route['surat/print_pdf_gc.php']                        = "medcheck/pdf_gc";
$route['medcheck/set_gc_simpan.php']                    = "medcheck/set_gc_simpan";
$route['medcheck/set_gc_update.php']                    = "medcheck/set_gc_update";
$route['medcheck/set_cari_daftar.php']                  = "medcheck/set_cari_daftar";
$route['medcheck/set_cari_antrian.php']                 = "medcheck/set_cari_antrian";
$route['medcheck/data_dokter.php']                      = "medcheck/data_dokter";

$route['medcheck/data_antrian.php']                     = "medcheck/trans_medcheck_ant";
$route['medcheck/data_antrian_det.php']                 = "medcheck/trans_medcheck_ant_det";
$route['medcheck/set_data_antrian.php']                 = "medcheck/set_data_antrian";

$route['medcheck/index.php']                            = "medcheck/index";
$route['medcheck/data_radiologi.php']                   = "medcheck/data_radiologi";
$route['medcheck/data_laborat.php']                     = "medcheck/data_laborat";
$route['medcheck/tambah.php']                           = "medcheck/trans_medcheck";

# Retur yang setelah lunas
$route['medcheck/retur/retur.php']                      = "medcheck/trans_medcheck_retur";
$route['medcheck/retur/set_medcheck_retur.php']         = "medcheck/set_medcheck_retur";
$route['medcheck/retur/json_retur.php']                 = "medcheck/json_medcheck_retur";

$route['medcheck/retur.php']                            = "medcheck/trans_medcheck_retur_ranap";
$route['medcheck/tindakan.php']                         = "medcheck/trans_medcheck_tindakan";
$route['medcheck/transfer.php']                         = "medcheck/trans_medcheck_trf";
$route['medcheck/detail.php']                           = "medcheck/trans_medcheck_detail";
$route['medcheck/kamar.php']                            = "medcheck/trans_medcheck_detail_kamar";
$route['medcheck/hapus.php']                            = "medcheck/trans_medcheck_hapus";
$route['medcheck/hapus_dft.php']                        = "medcheck/trans_medcheck_dft_hapus";
$route['medcheck/restore.php']                          = "medcheck/trans_medcheck_restore";
$route['medcheck/invoice/detail.php']                   = "medcheck/trans_medcheck_invoice";
$route['medcheck/invoice/bayar.php']                    = "medcheck/trans_medcheck_bayar";
$route['medcheck/invoice/print_dm.php']                 = "medcheck/trans_medcheck_print_dm";
$route['medcheck/invoice/print_dm_pdf.php']             = "medcheck/pdf_medcheck_nota_dm";
$route['medcheck/invoice/print_dm_ranap.php']           = "medcheck/trans_medcheck_print_dm_ranap";
$route['medcheck/invoice/print_pdf.php']                = "medcheck/pdf_medcheck_nota_rajal";
$route['medcheck/invoice/print_pdf_ranap.php']          = "medcheck/pdf_medcheck_nota_ranap";
$route['medcheck/invoice/print_pdf_ranap2.php']         = "medcheck/pdf_medcheck_nota_ranap2";
$route['medcheck/invoice/print_pdf_ranap3.php']         = "medcheck/pdf_medcheck_nota_ranap3";
$route['medcheck/data_medcheck.php']                    = "medcheck/medcheck_kasir_list";
$route['medcheck/data_pemb.php']                        = "medcheck/medcheck_pemb_list";
$route['medcheck/data_hapus.php']                       = "medcheck/medcheck_batal_list";

$route['medcheck/set_medcheck.php']                     = "medcheck/set_medcheck";
$route['medcheck/set_medcheck_transfer.php']            = "medcheck/set_medcheck_transfer";
$route['medcheck/set_medcheck_upd.php']                 = "medcheck/set_medcheck_update";
$route['medcheck/set_medcheck_upd_penj.php']            = "medcheck/set_medcheck_update_penj";
$route['medcheck/set_medcheck_proses.php']              = "medcheck/set_medcheck_proses";
$route['medcheck/set_medcheck_proses_batal.php']        = "medcheck/set_medcheck_proses_batal";
$route['medcheck/set_medcheck_proses_farm.php']         = "medcheck/set_medcheck_proses_farm";
$route['medcheck/set_medcheck_proses_farm_batal.php']   = "medcheck/set_medcheck_proses_farm_batal";
$route['medcheck/set_medcheck_bayar.php']               = "medcheck/set_medcheck_bayar";
$route['medcheck/set_medcheck_bayar_batal.php']         = "medcheck/set_medcheck_bayar_batal";
$route['medcheck/set_medcheck_surat.php']               = "medcheck/set_medcheck_surat";
$route['medcheck/set_medcheck_surat_upd.php']           = "medcheck/set_medcheck_surat_update";
$route['medcheck/set_medcheck_inform.php']              = "medcheck/set_medcheck_inform";
$route['medcheck/set_medcheck_inform_upd.php']          = "medcheck/set_medcheck_inform_upd";
$route['medcheck/set_medcheck_inform_upd_ttd.php']      = "medcheck/set_medcheck_inform_upd_ttd";
$route['medcheck/set_medcheck_diskon_item.php']         = "medcheck/set_medcheck_diskon_item";
$route['medcheck/set_medcheck_upd_inv.php']             = "medcheck/set_medcheck_update_inv";

$route['medcheck/set_medcheck_resep.php']               = "medcheck/set_medcheck_resep";
$route['medcheck/set_medcheck_resep_copy.php']          = "medcheck/set_medcheck_resep_copy";
$route['medcheck/set_medcheck_resep_upd.php']           = "medcheck/set_medcheck_resep_upd";
$route['medcheck/set_medcheck_resep_upd_ttd.php']       = "medcheck/set_medcheck_resep_upd_ttd";
$route['medcheck/set_medcheck_resep_pros.php']          = "medcheck/set_medcheck_resep_proses";
$route['medcheck/set_medcheck_resep_stat.php']          = "medcheck/set_medcheck_resep_status";
$route['medcheck/set_medcheck_resep_farm.php']          = "medcheck/set_medcheck_resep_farm";
$route['medcheck/resep/hapus.php']                      = "medcheck/set_medcheck_resep_hapus";

$route['medcheck/set_medcheck_lab.php']                 = "medcheck/set_medcheck_lab";
$route['medcheck/set_medcheck_lab_finish.php']          = "medcheck/set_medcheck_lab_finish";
$route['medcheck/set_medcheck_lab_batal.php']           = "medcheck/set_medcheck_lab_batal";
$route['medcheck/set_medcheck_lab_upd.php']             = "medcheck/set_medcheck_lab_upd";
$route['medcheck/set_medcheck_lab_upd_hsl.php']         = "medcheck/set_medcheck_lab_upd_hsl";
$route['medcheck/set_medcheck_lab_pros.php']            = "medcheck/set_medcheck_lab_proses";
$route['medcheck/set_medcheck_lab_print.php']           = "medcheck/set_medcheck_lab_print";
$route['medcheck/set_medcheck_lab_stat.php']            = "medcheck/set_medcheck_lab_status";
$route['medcheck/set_medcheck_lab_farm.php']            = "medcheck/set_medcheck_lab_farm";
$route['medcheck/set_medcheck_lab_spr.php']             = "medcheck/set_medcheck_lab_spiro";
$route['medcheck/set_medcheck_lab_spr_upd.php']         = "medcheck/set_medcheck_lab_spiro_upd";
$route['medcheck/set_medcheck_lab_spr_hsl.php']         = "medcheck/set_medcheck_lab_spiro_upd_hsl";
$route['medcheck/set_medcheck_lab_spr_hps.php']         = "medcheck/set_medcheck_lab_spiro_hps";
$route['medcheck/set_medcheck_lab_spr_hps_hsl.php']     = "medcheck/set_medcheck_lab_spiro_hps_hsl";
$route['medcheck/set_medcheck_lab_adm_save.php']        = 'medcheck/set_medcheck_lab_adm_save';
$route['medcheck/set_medcheck_lab_adm_delete.php']      = 'medcheck/set_medcheck_lab_adm_delete';
$route['medcheck/set_medcheck_lab_ekg.php']             = "medcheck/set_medcheck_lab_ekg";
$route['medcheck/set_medcheck_lab_ekg_upd.php']         = "medcheck/set_medcheck_lab_ekg_upd";
$route['medcheck/set_medcheck_lab_ekg_upload.php']      = "medcheck/set_medcheck_lab_ekg_file";
$route['medcheck/lab/hapus.php']                        = "medcheck/set_medcheck_lab_hapus";
$route['medcheck/lab/hapus_spiro.php']                  = "medcheck/set_medcheck_lab_hapus_spiro";
$route['medcheck/lab/hapus_ekg.php']                    = "medcheck/set_medcheck_lab_hapus_ekg";

// Laporan routes
$route['laporan/laporan_referal.php'] = 'laporan/laporan_referal';
$route['laporan/set_cari_referal.php'] = 'laporan/set_cari_referal';
$route['laporan/set_bayar_referal.php'] = 'laporan/set_bayar_referal'; 

$route['medcheck/set_medcheck_rad.php']                 = "medcheck/set_medcheck_rad";
$route['medcheck/set_medcheck_rad_upd.php']             = "medcheck/set_medcheck_rad_upd";
$route['medcheck/set_medcheck_rad_upd_hsl.php']         = "medcheck/set_medcheck_rad_upd_hsl";
$route['medcheck/set_medcheck_rad_pros.php']            = "medcheck/set_medcheck_rad_proses";
$route['medcheck/set_medcheck_rad_stat.php']            = "medcheck/set_medcheck_rad_status";
$route['medcheck/set_medcheck_rad_farm.php']            = "medcheck/set_medcheck_rad_farm";
$route['medcheck/rad/hapus.php']                        = "medcheck/set_medcheck_rad_hapus";

$route['medcheck/set_medcheck_pen_hrv.php']             = "medcheck/set_medcheck_pen_hrv";
$route['medcheck/set_medcheck_pen_hrv_upd.php']         = "medcheck/set_medcheck_pen_hrv_upd";
$route['medcheck/set_medcheck_pen_hrv_pros.php']        = "medcheck/set_medcheck_pen_hrv_proses";
$route['medcheck/set_medcheck_pen_hrv_stat.php']        = "medcheck/set_medcheck_pen_hrv_status";
$route['medcheck/set_medcheck_pen_hrv_farm.php']        = "medcheck/set_medcheck_pen_hrv_farm";
$route['medcheck/hrv/hapus.php']                        = "medcheck/set_medcheck_pen_hrv_hapus";

$route['medcheck/set_medcheck_mcu.php']                 = "medcheck/set_medcheck_mcu";
$route['medcheck/set_medcheck_mcu_upd.php']             = "medcheck/set_medcheck_mcu_upd";
$route['medcheck/set_medcheck_mcu_upd_hsl.php']         = "medcheck/set_medcheck_mcu_upd_hsl";
$route['medcheck/set_medcheck_mcu_pros.php']            = "medcheck/set_medcheck_mcu_proses";
$route['medcheck/set_medcheck_mcu_stat.php']            = "medcheck/set_medcheck_mcu_status";
$route['medcheck/set_medcheck_mcu_farm.php']            = "medcheck/set_medcheck_mcu_farm";
$route['medcheck/mcu/hapus.php']                        = "medcheck/set_medcheck_mcu_hapus";

$route['medcheck/set_medcheck_resm.php']                = "medcheck/set_medcheck_resume";
$route['medcheck/set_medcheck_resm_upd.php']            = "medcheck/set_medcheck_resume_upd";
$route['medcheck/set_medcheck_resm_hsl.php']            = "medcheck/set_medcheck_resume_hsl";
$route['medcheck/set_medcheck_resm_hsl2.php']           = "medcheck/set_medcheck_resume_hsl2";
$route['medcheck/set_medcheck_resm_hsl3.php']           = "medcheck/set_medcheck_resume_hsl3";
$route['medcheck/set_medcheck_resm_hsl_upd.php']        = "medcheck/set_medcheck_resume_hsl_upd";
$route['medcheck/set_medcheck_resm_hsl2_upd.php']       = "medcheck/set_medcheck_resume_hsl2_upd";
$route['medcheck/set_medcheck_resm_hsl3_upd.php']       = "medcheck/set_medcheck_resume_hsl3_upd";
$route['medcheck/set_medcheck_resm_ctk.php']            = "medcheck/set_medcheck_resume_ctk";
$route['medcheck/set_medcheck_resm_pros.php']           = "medcheck/set_medcheck_resume_proses";
$route['medcheck/resume/hapus.php']                     = "medcheck/set_medcheck_resume_hapus";
$route['medcheck/resume/hapus_hsl.php']                 = "medcheck/set_medcheck_resume_hapus_hsl";
$route['medcheck/resume/hapus_hsl_rnp.php']             = "medcheck/set_medcheck_resume_hapus_hsl_rnp";

# Modul ICD
$route['medcheck/set_medcheck_icd.php']                 = "medcheck/set_medcheck_icd";
$route['medcheck/set_medcheck_icd_hps.php']             = "medcheck/set_medcheck_icd_hapus";

# Modul Dokter Rawat Bersama
$route['medcheck/dokter/set_medcheck_doc.php']          = "medcheck/set_medcheck_doc";
$route['medcheck/dokter/hapus.php']                     = "medcheck/set_medcheck_doc_hapus";

# Modul Kuitansi, DP, dan TPP jadi satu disini
$route['medcheck/set_kwitansi_simpan.php']              = "medcheck/set_medcheck_kwi";
$route['medcheck/set_kwitansi_hps.php']                 = "medcheck/set_medcheck_kwi_hapus";
$route['medcheck/cetak_kwitansi_pdf.php']               = "medcheck/pdf_medcheck_kwi";

# Modul Kamar Pasien
$route['medcheck/set_medcheck_kamar.php']               = "medcheck/set_medcheck_kamar";
$route['medcheck/set_medcheck_kamar_hps.php']           = "medcheck/set_medcheck_kamar_hapus";

# Modul Cetak ID Pasien
$route['medcheck/cetak_label_json.php']                 = "medcheck/json_medcheck_label_id";
$route['medcheck/cetak_label_json_dft.php']             = "medcheck/json_medcheck_label_dft";

# Upload
$route['medcheck/set_medcheck_upload.php']              = "medcheck/set_medcheck_upload";
$route['medcheck/file/file_hapus.php']                  = "medcheck/set_medcheck_upload_hapus";

# Konsul Antar Dokter
$route['medcheck/data_konsul.php']                      = "medcheck/data_konsul";
$route['medcheck/data_konsul_post.php']                 = "medcheck/data_konsul_post";
$route['medcheck/data_konsul_cari.php']                 = "medcheck/data_konsul_cari";
$route['medcheck/data_konsul_balas.php']                = "medcheck/data_konsul_balas";
$route['medcheck/set_konsul.php']                       = "medcheck/set_konsul";
$route['medcheck/set_konsul_balas.php']                 = "medcheck/set_konsul_balas";
$route['medcheck/set_konsul_hapus.php']                 = "medcheck/set_konsul_hapus";
$route['medcheck/set_cari_konsul.php']                  = "medcheck/set_cari_konsul";
$route['medcheck/set_cari_medcheck_kons.php']           = "medcheck/set_cari_medcheck_kons";

# Konsul Tracer Pasien Rawat Jalan
$route['medcheck/data_tracer.php']                      = "medcheck/trans_medcheck_tracer"; 
$route['medcheck/set_cari_tracer.php']                  = "medcheck/set_cari_tracer";

# Penunjang Spiro
$route['medcheck/data_pen_spiro.php']                   = "medcheck/data_pen_spiro"; 
//$route['medcheck/set_cari_tracer.php']                  = "medcheck/set_cari_tracer";

# Penunjang EKG
$route['medcheck/data_pen_ekg.php']                     = "medcheck/data_pen_ekg";

# Penunjang HRV
$route['medcheck/data_pen_hrv.php']                     = "medcheck/data_pen_hrv";

# Assesment Form Fisik
$route['medcheck/set_medcheck_ass_fisik.php']           = "medcheck/set_medcheck_ass_fisik";
$route['medcheck/set_medcheck_ass_fisik_upd.php']       = "medcheck/set_medcheck_ass_fisik_upd";
$route['medcheck/set_medcheck_ass_fisik_hsl.php']       = "medcheck/set_medcheck_ass_fisik_hsl";
$route['medcheck/set_medcheck_ass_fisik_hsl2.php']      = "medcheck/set_medcheck_ass_fisik_hsl2";
$route['medcheck/set_medcheck_ass_fisik_hsl3.php']      = "medcheck/set_medcheck_ass_fisik_hsl3";
$route['medcheck/set_medcheck_ass_fisik_hsl4.php']      = "medcheck/set_medcheck_ass_fisik_hsl4";
$route['medcheck/set_medcheck_ass_fisik_hsl5.php']      = "medcheck/set_medcheck_ass_fisik_hsl5";
$route['medcheck/set_medcheck_ass_fisik_hsl6.php']      = "medcheck/set_medcheck_ass_fisik_hsl6";
$route['medcheck/set_medcheck_ass_fisik_hsl7.php']      = "medcheck/set_medcheck_ass_fisik_hsl7";
$route['medcheck/set_medcheck_ass_fisik_hsl8.php']      = "medcheck/set_medcheck_ass_fisik_hsl8";
$route['medcheck/set_medcheck_ass_fisik_hsl9.php']      = "medcheck/set_medcheck_ass_fisik_hsl9";
$route['medcheck/set_medcheck_ass_fisik_hsl10.php']     = "medcheck/set_medcheck_ass_fisik_hsl10";
$route['medcheck/set_medcheck_ass_fisik_hsl11.php']     = "medcheck/set_medcheck_ass_fisik_hsl11";
$route['medcheck/set_medcheck_ass_fisik_hsl12.php']     = "medcheck/set_medcheck_ass_fisik_hsl12";
$route['medcheck/set_medcheck_ass_fisik_hsl13.php']     = "medcheck/set_medcheck_ass_fisik_hsl13";
$route['medcheck/set_medcheck_ass_fisik_hsl14.php']     = "medcheck/set_medcheck_ass_fisik_hsl14";
$route['medcheck/ass_fisik/hapus.php']                  = "medcheck/set_medcheck_ass_fisik_hapus";

$route['medcheck/set_medcheck_ass_ranap.php']           = "medcheck/set_medcheck_ass_ranap";
$route['medcheck/set_medcheck_ass_ranap_obt.php']       = "medcheck/set_medcheck_ass_ranap_obt";
$route['medcheck/set_medcheck_ass_ranap_obt_hps.php']   = "medcheck/set_medcheck_ass_ranap_obt_hapus";

$route['medcheck/set_medcheck_rad.php']                 = "medcheck/set_medcheck_rad";
$route['medcheck/set_cari_medcheck.php']                = "medcheck/set_cari_medcheck";
$route['medcheck/set_cari_medcheck_rad.php']            = "medcheck/set_cari_medcheck_rad";
$route['medcheck/set_cari_medcheck_hps.php']            = "medcheck/set_cari_medcheck_batal";
$route['medcheck/set_cari_medcheck_bayar.php']          = "medcheck/set_cari_medcheck_bayar";

$route['medcheck/set_medcheck_retur.php']               = "medcheck/set_medcheck_retur";

$route['medcheck/cart_medcheck_simpan.php']             = "medcheck/cart_medcheck_simpan";
$route['medcheck/cart_medcheck_resep.php']              = "medcheck/cart_medcheck_resep";
$route['medcheck/cart_medcheck_resep_upd1.php']         = "medcheck/cart_medcheck_resep_upd1";
$route['medcheck/cart_medcheck_resep_upd2.php']         = "medcheck/cart_medcheck_resep_upd2";
$route['medcheck/cart_medcheck_resep_rc.php']           = "medcheck/cart_medcheck_resep_rc";
$route['medcheck/cart_medcheck_resep_rc_hps.php']       = "medcheck/cart_medcheck_resep_rc_hapus";
$route['medcheck/cart_medcheck_resep_hps.php']          = "medcheck/cart_medcheck_resep_hapus";
$route['medcheck/cart_medcheck_resep_itm_hps.php']      = "medcheck/cart_medcheck_resep_item_hapus";
$route['medcheck/cart_medcheck_update.php']             = "medcheck/cart_medcheck_update";
$route['medcheck/cart_medcheck_hapus.php']              = "medcheck/cart_medcheck_hapus";
$route['medcheck/cart_medcheck_status.php']             = "medcheck/cart_medcheck_status";
$route['medcheck/cart_medcheck_rad.php']                = "medcheck/cart_medcheck_rad";
$route['medcheck/cart_medcheck_rad_hsl_hapus.php']      = "medcheck/cart_medcheck_rad_hsl_hapus";
$route['medcheck/cart_medcheck_rad_file.php']           = "medcheck/cart_medcheck_rad_file";
$route['medcheck/cart_medcheck_rad_file_hapus.php']     = "medcheck/cart_medcheck_rad_file_hapus";
$route['medcheck/cart_medcheck_lab_nilai.php']          = "medcheck/cart_medcheck_lab_nilai";
$route['medcheck/cart_medcheck_lab_hsl_hapus.php']      = "medcheck/cart_medcheck_lab_hsl_hapus";
$route['medcheck/cart_medcheck_lab_file_ekg_hapus.php'] = "medcheck/cart_medcheck_lab_ekg_file_hapus";
$route['medcheck/cart_medcheck_rm.php']                 = "medcheck/cart_medcheck_rm";
$route['medcheck/cart_medcheck_rm_upd.php']             = "medcheck/cart_medcheck_rm_upd";
$route['medcheck/cart_medcheck_rm_hps.php']             = "medcheck/cart_medcheck_rm_hapus";
$route['medcheck/cart_medcheck_ret.php']                = "medcheck/cart_medcheck_retur";
$route['medcheck/cart_medcheck_ret_hps.php']            = "medcheck/cart_medcheck_retur_hapus";

$route['medcheck/cart_medcheck_ret_rnp.php']            = "medcheck/cart_medcheck_retur_ranap";
$route['medcheck/cart_medcheck_ret_rnp_hps.php']        = "medcheck/cart_medcheck_retur_ranap_hapus";

$route['medcheck/resep/data_resep.php']                 = "medcheck/data_resep";
$route['medcheck/resep/konfirm.php']                    = "medcheck/trans_resep_konfirm";
$route['medcheck/resep/detail.php']                     = "medcheck/trans_resep_detail";
$route['medcheck/resep/tambah.php']                     = "medcheck/trans_resep_tambah";
$route['medcheck/resep/set_cari_resep.php']             = "medcheck/set_cari_resep";
$route['medcheck/resep/cetak_label.php']                = "medcheck/pdf_medcheck_label";
$route['medcheck/resep/cetak_label_xls.php']            = "medcheck/xls_medcheck_label";
$route['medcheck/resep/cetak_label_json.php']           = "medcheck/json_medcheck_label";

$route['medcheck/json_medcheck.php']                    = "medcheck/json_medcheck";
$route['medcheck/json_medcheck_ant.php']                = "medcheck/json_medcheck_ant";
$route['medcheck/json_pasien.php']                      = "medcheck/json_pasien";
$route['medcheck/json_dokter.php']                      = "medcheck/json_dokter";
$route['medcheck/json_item.php']                        = "medcheck/json_item";
$route['medcheck/json_icd.php']                         = "medcheck/json_icd";

$route['medcheck/surat/cetak.php']                      = "medcheck/cetak_medcheck_surat";
$route['medcheck/surat/hapus.php']                      = "medcheck/hapus_medcheck_surat";
$route['medcheck/surat/hapus_inform.php']               = "medcheck/hapus_medcheck_surat_inform";
$route['medcheck/surat/cetak_pdf.php']                  = "medcheck/pdf_medcheck_surat";
$route['medcheck/surat/cetak_pdf_inf.php']              = "medcheck/pdf_medcheck_surat_inform";
$route['medcheck/surat/cetak_pdf_lab.php']              = "medcheck/pdf_medcheck_lab";
$route['medcheck/surat/cetak_pdf_lab_spiro.php']        = "medcheck/pdf_medcheck_lab_spiro";
$route['medcheck/surat/cetak_pdf_lab_ekg.php']          = "medcheck/pdf_medcheck_lab_ekg";
$route['medcheck/cetak_audiometri.php']                 = "medcheck/pdf_medcheck_lab_audio";
$route['medcheck/surat/cetak_pdf_pen_hrv.php']          = "medcheck/pdf_medcheck_pen_hrv";
$route['medcheck/surat/cetak_pdf_rad.php']              = "medcheck/pdf_medcheck_rad";
$route['medcheck/surat/cetak_pdf_rsm.php']              = "medcheck/pdf_medcheck_resume";
$route['medcheck/surat/cetak_pdf_rsm_lab.php']          = "medcheck/pdf_medcheck_resume_lab";
$route['medcheck/surat/cetak_pdf_rsm_rnp.php']          = "medcheck/pdf_medcheck_resume_rnp";
$route['medcheck/surat/cetak_pdf_ass_rnp.php']          = "medcheck/pdf_medcheck_ass_rnp";
$route['medcheck/surat/cetak_pdf_ass_fisik.php']        = "medcheck/pdf_medcheck_ass_fisik";
$route['medcheck/resep/cetak_pdf.php']                  = "medcheck/pdf_medcheck_resep";

// route['medcheck/cetak_audiometri.php'] = 'medcheck/cetak_audiometri'; 
/* --- Medcheck --- */

/* Transaksi */ 
// Pembelian
$route['transaksi/beli']                                = "transaksi/trans_beli_list";
$route['transaksi/beli/index.php']                      = "transaksi/trans_beli_list";
$route['transaksi/beli/trans_beli.php']                 = "transaksi/trans_beli";
$route['transaksi/beli/trans_beli_edit.php']            = "transaksi/trans_beli_edit";
$route['transaksi/beli/set_trans_beli.php']             = "transaksi/set_trans_beli";
$route['transaksi/beli/set_trans_beli_upd.php']         = "transaksi/set_trans_beli_upd";
$route['transaksi/beli/set_trans_beli_batal.php']       = "transaksi/set_trans_beli_batal";
$route['transaksi/beli/set_trans_beli_proses.php']      = "transaksi/set_trans_beli_proses";
$route['transaksi/beli/set_trans_beli_proses_upd.php']  = "transaksi/set_trans_beli_proses_upd";
$route['transaksi/beli/cart_beli_simpan.php']           = "transaksi/cart_beli_simpan";
$route['transaksi/beli/cart_beli_upd.php']              = "transaksi/cart_beli_upd";
$route['transaksi/beli/cart_beli_upd2.php']             = "transaksi/cart_beli_upd2";
$route['transaksi/beli/cart_beli_hapus.php']            = "transaksi/cart_beli_hapus";
$route['transaksi/beli/cart_beli_upd_hapus.php']        = "transaksi/cart_beli_upd_hapus";

$route['transaksi/beli/trans_beli_po.php']              = "transaksi/trans_beli_po";
$route['transaksi/beli/trans_beli_po_det.php']          = "transaksi/trans_beli_po_det";
$route['transaksi/beli/trans_beli_po_edit.php']         = "transaksi/trans_beli_po_edit";
$route['transaksi/beli/trans_beli_po_hapus.php']        = "transaksi/trans_beli_po_hapus";
$route['transaksi/beli/trans_beli_po_list.php']         = "transaksi/trans_beli_po_list";
$route['transaksi/beli/set_trans_beli_po_batal.php']    = "transaksi/set_trans_beli_po_batal";
$route['transaksi/beli/set_trans_beli_po.php']          = "transaksi/set_trans_beli_po";
$route['transaksi/beli/set_trans_beli_po_upd.php']      = "transaksi/set_trans_beli_po_upd";
$route['transaksi/beli/set_trans_beli_po_proses.php']   = "transaksi/set_trans_beli_po_proses";
$route['transaksi/beli/set_trans_beli_po_proses_upd.php'] = "transaksi/set_trans_beli_po_proses_upd";
$route['transaksi/beli/cart_beli_po_simpan.php']        = "transaksi/cart_beli_po_simpan";
$route['transaksi/beli/cart_beli_po_upd.php']           = "transaksi/cart_beli_po_upd";
$route['transaksi/beli/cart_beli_po_hapus.php']         = "transaksi/cart_beli_po_hapus";
$route['transaksi/beli/cart_beli_po_upd_hapus.php']     = "transaksi/cart_beli_po_upd_hapus";
$route['transaksi/index.php']                           = "transaksi/index";
$route['transaksi/beli/json_po.php']                    = "transaksi/json_po";
$route['transaksi/beli/json_supplier.php']              = "transaksi/json_supplier";
$route['transaksi/beli/json_item.php']                  = "transaksi/json_item";
$route['transaksi/pembelian/trans_beli_po.php']         = "transaksi/trans_beli_po";
$route['transaksi/trans_beli_edit.php']                 = "transaksi/trans_beli_edit";
$route['transaksi/trans_beli_edit_po.php']              = "transaksi/trans_beli_edit_po";
$route['transaksi/trans_beli_hapus.php']                = "transaksi/trans_beli_hapus";
$route['transaksi/trans_beli_edit_item.php']            = "transaksi/trans_beli_edit_item";
$route['transaksi/trans_beli_det.php']                  = "transaksi/trans_beli_det";
$route['transaksi/trans_beli_po_det.php']               = "transaksi/trans_beli_det_po";
$route['transaksi/set_nota_beli.php']                   = "transaksi/set_nota_beli";
$route['transaksi/pembelian/set_nota_beli_po.php']      = "transaksi/set_nota_beli_po";
$route['transaksi/set_nota_beli_update.php']            = "transaksi/set_nota_beli_upd";
$route['transaksi/set_nota_beli_update_po.php']         = "transaksi/set_nota_beli_upd_po";
$route['transaksi/set_nota_beli_upd_item.php']          = "transaksi/set_nota_beli_proses_upd_item";
$route['transaksi/set_status_po.php']                   = "transaksi/set_nota_beli_status";
$route['transaksi/cart_beli_simpan.php']                = "transaksi/cart_beli_simpan";
$route['transaksi/cart_beli_simpan_po.php']             = "transaksi/cart_beli_simpan_po";
$route['transaksi/cart_beli_update.php']                = "transaksi/cart_beli_update";
$route['transaksi/cart_beli_hapus.php']                 = "transaksi/cart_beli_hapus";
$route['transaksi/cart_beli_hapus_po.php']              = "transaksi/cart_beli_hapus_po";
$route['transaksi/cart_beli_upd_hapus.php']             = "transaksi/cart_beli_hapus_upd";
$route['transaksi/set_nota_beli_proses.php']            = "transaksi/set_nota_beli_proses";
$route['transaksi/set_nota_beli_proses_po.php']         = "transaksi/set_nota_beli_proses_po";
$route['transaksi/set_nota_beli_proses_po_upd.php']     = "transaksi/set_nota_beli_proses_po_upd";
$route['transaksi/set_nota_beli_proses_upd.php']        = "transaksi/set_nota_beli_proses_upd";
$route['transaksi/set_nota_beli_bayar.php']             = "transaksi/set_nota_beli_bayar";
$route['transaksi/trans_retur_beli.php']                = "transaksi/trans_retur_beli";
$route['transaksi/trans_retur_beli_det.php']            = "transaksi/trans_retur_beli_det";
$route['transaksi/set_retur_beli.php']                  = "transaksi/set_retur_beli";
$route['transaksi/set_retur_beli_m.php']                = "transaksi/set_retur_beli_m";
$route['transaksi/set_retur_beli_proses.php']           = "transaksi/set_retur_beli_proses";
$route['transaksi/set_retur_beli_m_proses.php']         = "transaksi/set_retur_beli_m_proses";
$route['transaksi/cart_retur_beli_simpan.php']          = "transaksi/cart_retur_beli_simpan";
$route['transaksi/cart_retur_beli_m_simpan.php']        = "transaksi/cart_retur_beli_m_simpan";
$route['transaksi/cart_retur_beli_hapus.php']           = "transaksi/cart_retur_beli_hapus";
$route['transaksi/set_nota_batal.php']                  = "transaksi/set_nota_batal";
$route['transaksi/set_nota_batal_draft.php']            = "transaksi/set_nota_batal_draft";
$route['transaksi/set_retur_jual_batal.php']            = "transaksi/set_retur_jual_batal";
$route['transaksi/set_retur_beli_batal.php']            = "transaksi/set_retur_beli_batal";
$route['transaksi/set_cari_penj.php']                   = "transaksi/set_cari_penj";
$route['transaksi/set_cari_penj_retur.php']             = "transaksi/set_cari_penj_retur";
$route['transaksi/set_cari_penj_bayar.php']             = "transaksi/set_cari_penj_bayar";
$route['transaksi/set_cari_penawaran.php']              = "transaksi/set_cari_penawaran";
$route['transaksi/beli/set_cari_pemb.php']              = "transaksi/set_cari_pemb";
$route['transaksi/beli/set_cari_po.php']                = "transaksi/set_cari_pemb_po";
$route['transaksi/set_cari_pemb_retur.php']             = "transaksi/set_cari_pemb_retur";
$route['transaksi/set_cari_pemb_bayar.php']             = "transaksi/set_cari_pemb_bayar";
$route['transaksi/set_cari_po.php']                     = "transaksi/set_cari_po";
$route['transaksi/data_penj_list.php']                  = "transaksi/data_penj_list";
$route['transaksi/data_penj_list_draft.php']            = "transaksi/data_penj_list_draft";
$route['transaksi/data_penj_list_tempo.php']            = "transaksi/data_penj_list_tempo";
$route['transaksi/data_pen_list.php']                   = "transaksi/data_pen_list";
$route['transaksi/pembelian/data_po_list.php']          = "transaksi/data_po_list";
$route['transaksi/data_pembelian_list_tempo.php']       = "transaksi/data_pembelian_list_tempo";
$route['transaksi/data_pemb_jual_list.php']             = "transaksi/data_pemb_jual_list";
$route['transaksi/data_pemb_beli_list.php']             = "transaksi/data_pemb_beli_list";
$route['transaksi/data_retur_jual_list.php']            = "transaksi/data_retur_jual_list";
$route['transaksi/data_retur_beli_list.php']            = "transaksi/data_retur_beli_list";
$route['transaksi/trans_bayar_jual.php']                = "transaksi/trans_bayar_jual";
$route['transaksi/trans_bayar_beli.php']                = "transaksi/trans_bayar_beli";
$route['transaksi/cetak_nota.php']                      = "transaksi/trans_jual_print_ex";
$route['transaksi/cetak_nota_retjual.php']              = "cetak/termal_ctk_retjual";
$route['transaksi/cetak_nota_retbeli.php']              = "cetak/termal_ctk_retbeli";
$route['transaksi/cetak_nota_pen.php']                  = "transaksi/trans_jual_print_ex_pen";
$route['transaksi/cetak_nota_do.php']                   = "transaksi/trans_jual_print_ex_do";
$route['transaksi/beli/cetak_nota.php']                 = "transaksi/trans_beli_print_ex";
$route['transaksi/beli/cetak_nota_po.php']              = "transaksi/trans_beli_print_ex_po";
$route['transaksi/beli/cetak_nota_termal.php']          = "transaksi/trans_jual_print_tr";
$route['transaksi/beli/cetak_nota_pdf.php']             = "transaksi/pdf_trans_beli";
$route['transaksi/beli/cetak_nota_po_pdf.php']          = "transaksi/pdf_trans_beli_po";
$route['transaksi/cetak_data_penj.php']                 = "transaksi/cetak_data_penjualan";
$route['transaksi/pdf_data_penj.php']                   = "transaksi/pdf_data_penjualan";

$route['master/json_biaya.php']                         = "master/json_biaya";

$route['akuntability/data_pems_list.php']               = "akuntability/data_pems_list";
$route['akuntability/data_pems_tambah.php']             = "akuntability/data_pems_tambah";
$route['akuntability/data_pems_simpan.php']             = "akuntability/data_pems_simpan";
$route['akuntability/data_pems_update.php']             = "akuntability/data_pems_update";
$route['akuntability/data_pems_hapus.php']              = "akuntability/data_pems_hapus";

$route['akuntability/data_modal_list.php']              = "akuntability/data_modal_list";
$route['akuntability/data_modal_simpan.php']            = "akuntability/data_modal_simpan";
$route['akuntability/data_modal_update.php']            = "akuntability/data_modal_update";
$route['akuntability/data_modal_hapus.php']             = "akuntability/data_modal_hapus";

$route['akuntability/data_pers_list.php']               = "akuntability/data_pers_list";
$route['akuntability/data_pers_tambah.php']             = "akuntability/data_pers_tambah";
$route['akuntability/data_pers_simpan.php']             = "akuntability/data_pers_simpan";
$route['akuntability/data_pers_update.php']             = "akuntability/data_pers_update";
$route['akuntability/data_pers_hapus.php']              = "akuntability/data_pers_hapus";

$route['akuntability/data_peng_list.php']               = "akuntability/data_peng_list";
$route['akuntability/data_peng_tambah.php']             = "akuntability/data_peng_tambah";
$route['akuntability/data_peng_simpan.php']             = "akuntability/data_peng_simpan";
$route['akuntability/data_peng_update.php']             = "akuntability/data_peng_update";
$route['akuntability/data_peng_hapus.php']              = "akuntability/data_peng_hapus";
$route['akuntability/data_peng_jns_simpan.php']         = "akuntability/data_peng_jns_simpan";
$route['akuntability/data_peng_jns_hapus.php']          = "akuntability/data_peng_jns_hapus";

/* -- AKUNTANSI -- */
$route['akuntability/data_akun_list.php']               = "akuntability/data_akun_list";
$route['akuntability/data_akun_tambah.php']             = "akuntability/data_akun_tambah";
$route['akuntability/data_akun_simpan.php']             = "akuntability/data_akun_simpan";
$route['akuntability/data_akun_update.php']             = "akuntability/data_akun_update";
$route['akuntability/data_akun_hapus.php']              = "akuntability/data_akun_hapus";
$route['akuntability/data_sawal_list.php']              = "akuntability/data_sawal_list";
$route['akuntability/data_sawal_simpan.php']            = "akuntability/data_sawal_simpan";
$route['akuntability/data_sawal_update.php']            = "akuntability/data_sawal_update";
$route['akuntability/data_sawal_hapus.php']             = "akuntability/data_sawal_hapus";
$route['akuntability/data_jur_jual_list.php']           = "akuntability/data_jur_jual_list";
$route['akuntability/data_jur_beli_list.php']           = "akuntability/data_jur_beli_list";
$route['akuntability/set_jur_jual_simpan.php']          = "akuntability/set_jur_jual_simpan";
$route['akuntability/set_jur_beli_simpan.php']          = "akuntability/set_jur_beli_simpan";
$route['akuntability/data_jurnal_list.php']             = "akuntability/data_jurnal_list";
$route['akuntability/data_jurnal_simpan.php']           = "akuntability/data_jurnal_simpan";
$route['akuntability/data_jurnal_update.php']           = "akuntability/data_jurnal_update";
$route['akuntability/data_jurnal_hapus.php']            = "akuntability/data_jurnal_hapus";
$route['akuntability/data_jurnal_umum_list.php']        = "akuntability/data_jurnal_umum_list";
$route['akuntability/data_jurnal_umum_simpan.php']      = "akuntability/data_jurnal_umum_simpan";
$route['akuntability/data_jurnal_umum_update.php']      = "akuntability/data_jurnal_umum_update";
$route['akuntability/data_jurnal_umum_hapus.php']       = "akuntability/data_jurnal_umum_hapus";
$route['akuntability/data_jurnal_peny_list.php']        = "akuntability/data_jurnal_peny_list";
$route['akuntability/data_jurnal_peny_simpan.php']      = "akuntability/data_jurnal_peny_simpan";
$route['akuntability/data_jurnal_peny_update.php']      = "akuntability/data_jurnal_peny_update";
$route['akuntability/data_jurnal_peny_hapus.php']       = "akuntability/data_jurnal_peny_hapus";
$route['akuntability/data_jurnal_pen_list.php']         = "akuntability/data_jurnal_pen_list";
$route['akuntability/data_jurnal_pen_simpan.php']       = "akuntability/data_jurnal_pen_simpan";
$route['akuntability/data_jurnal_pen_update.php']       = "akuntability/data_jurnal_pen_update";
$route['akuntability/data_jurnal_pen_hapus.php']        = "akuntability/data_jurnal_pen_hapus";
$route['akuntability/set_cari_pers.php']                = "akuntability/set_cari_pers";
$route['akuntability/set_jur_jual_cari.php']            = "akuntability/set_jur_jual_cari";
$route['akuntability/set_jur_beli_cari.php']            = "akuntability/set_jur_beli_cari";
/* -- END AKUNTANSI -- */

/* SDM */ 
$route['sdm/index.php']                                 = "sdm/index";
$route['sdm/data_cuti_list.php']                        = "sdm/data_cuti_list";
$route['sdm/data_cuti_det.php']                         = "sdm/data_cuti_det";
$route['sdm/data_surat_krj_list.php']                   = "sdm/data_surat_krj_list";
$route['sdm/data_surat_krj_tambah.php']                 = "sdm/data_surat_krj_tambah";
$route['sdm/data_surat_krj_det.php']                    = "sdm/data_surat_krj_det";
$route['sdm/data_surat_tgs_list.php']                   = "sdm/data_surat_tgs_list";
$route['sdm/data_surat_tgs_tambah.php']                 = "sdm/data_surat_tgs_tambah";
$route['sdm/data_surat_tgs_det.php']                    = "sdm/data_surat_tgs_det";
$route['sdm/data_gaji.php']                             = "sdm/data_gaji_list";
$route['sdm/data_gaji_tambah.php']                      = "sdm/data_gaji_tambah";
$route['sdm/data_gaji_det.php']                         = "sdm/data_gaji_det";
$route['sdm/data_absen.php']                            = "sdm/data_absen_list";
$route['sdm/data_absen_tambah.php']                     = "sdm/data_absen_tambah";
$route['sdm/data_absen_det.php']                        = "sdm/data_absen_det";
$route['sdm/set_cuti_simpan.php']                       = "sdm/set_cuti_simpan";
$route['sdm/set_cuti_update.php']                       = "sdm/set_cuti_update";
$route['sdm/set_cuti_hapus.php']                        = "sdm/set_cuti_hapus";
$route['sdm/set_cari_cuti.php']                         = "sdm/set_cari_cuti";
$route['sdm/set_cari_krj.php']                          = "sdm/set_cari_krj";
$route['sdm/set_cari_tgs.php']                          = "sdm/set_cari_tgs";
$route['sdm/set_cari_gaji.php']                         = "sdm/set_cari_gaji";
$route['sdm/set_cari_absen.php']                        = "sdm/set_cari_absen";
$route['sdm/set_surat_krj_simpan.php']                  = "sdm/set_surat_krj_simpan";
$route['sdm/set_surat_tgs_simpan.php']                  = "sdm/set_surat_tgs_simpan";
$route['sdm/set_surat_tgs_simpan_kary.php']             = "sdm/set_surat_tgs_simpan_kary";
$route['sdm/set_surat_tgs_hapus_kary.php']              = "sdm/set_surat_tgs_hapus_kary";
$route['sdm/set_gaji_simpan.php']                       = "sdm/set_gaji_simpan";
$route['sdm/set_gaji_hapus.php']                        = "sdm/set_gaji_hapus";
$route['sdm/set_absen_simpan.php']                      = "sdm/set_absen_simpan";
$route['sdm/pdf_cuti.php']                              = "sdm/pdf_cuti";
$route['sdm/pdf_cuti_bls.php']                          = "sdm/pdf_cuti_bls";
$route['sdm/pdf_surat_krj.php']                         = "sdm/pdf_surat_krj";
$route['sdm/pdf_surat_tgs.php']                         = "sdm/pdf_surat_tgs";
$route['sdm/pdf_surat_pkl.php']                         = "sdm/pdf_surat_pkl";
$route['sdm/json_karyawan.php']                         = "sdm/json_karyawan";

/* LAPORAN */
$route['laporan/index.php']                             = "laporan/index";

// Laporan Pasien
$route['laporan/data_pasien.php']                       = "laporan/data_pasien";
$route['laporan/set_data_pasien.php']                   = "laporan/set_data_pasien";
$route['laporan/xls_data_pasien.php']                   = "laporan/xls_data_pasien";
$route['laporan/xls_data_pasien2.php']                  = "laporan/xls_data_pasien2";
$route['laporan/data_pasien_st.php']                    = "laporan/data_pasien_st";
$route['laporan/set_data_pasien_st.php']                = "laporan/set_data_pasien_st";
$route['laporan/xls_data_pasien_st.php']                = "laporan/xls_data_pasien_st";

// Laporan Kunjungan Pasien
$route['laporan/data_visit_pasien.php']                 = "laporan/data_pasien_kunj";
$route['laporan/set_data_visit_pasien.php']             = "laporan/set_data_pasien_kunj";
$route['laporan/xls_data_visit_pasien.php']             = "laporan/xls_data_pasien_kunj";

// Laporan Pemeriksaan Pasien
$route['laporan/data_pemeriksaan.php']                  = "laporan/data_pasien_periksa";
$route['laporan/data_pemeriksaan_det.php']              = "laporan/data_pasien_periksa_det";
$route['laporan/data_pemeriksaan_rj.php']               = "laporan/data_pasien_periksa_rj";
$route['laporan/set_data_pemeriksaan.php']              = "laporan/set_data_pasien_periksa";
$route['laporan/set_data_pemeriksaan_rj.php']           = "laporan/set_data_pasien_periksa_rj";
$route['laporan/xls_data_pemeriksaan_rj.php']           = "laporan/xls_data_pasien_periksa_rj";

// Laporan Pasien Diagnosa ICD
$route['laporan/data_diagnosa.php']                     = "laporan/data_icd_pasien";
$route['laporan/set_data_diagnosa.php']                 = "laporan/set_data_icd_pasien";
$route['laporan/xls_data_pasien.php']                   = "laporan/xls_data_pasien";
$route['laporan/xls_data_pasien2.php']                  = "laporan/xls_data_pasien2";

// Laporan Pasien MCU
$route['laporan/data_mcu.php']                          = "laporan/data_mcu";
$route['laporan/set_data_mcu.php']                      = "laporan/set_data_mcu";
$route['laporan/xls_data_mcu.php']                      = "laporan/xls_data_mcu";
$route['laporan/xls_data_mcu2.php']                     = "laporan/xls_data_mcu2";
$route['laporan/htm_data_mcu.php']                      = "laporan/htm_data_mcu";

// Laporan Omset
$route['laporan/data_icd.php']                          = "laporan/data_icd";
$route['laporan/data_omset.php']                        = "laporan/data_omset";
$route['laporan/data_omset_poli.php']                   = "laporan/data_omset_poli";
$route['laporan/data_omset_detail.php']                 = "laporan/data_omset_detail";
$route['laporan/data_omset_jasa.php']                   = "laporan/data_omset_jasa";
$route['laporan/data_omset_dokter.php']                 = "laporan/data_omset_dokter";
$route['laporan/data_omset_bukti.php']                  = "laporan/data_omset_bukti";
$route['laporan/set_data_icd.php']                      = "laporan/set_data_icd";
$route['laporan/set_data_omset.php']                    = "laporan/set_data_omset";
$route['laporan/set_data_omset_poli.php']               = "laporan/set_data_omset_poli";
$route['laporan/set_data_omset_detail.php']             = "laporan/set_data_omset_detail";
$route['laporan/set_data_omset_jasa.php']               = "laporan/set_data_omset_jasa";
$route['laporan/set_data_omset_dokter.php']             = "laporan/set_data_omset_dokter";
$route['laporan/set_data_omset_bukti.php']              = "laporan/set_data_omset_bukti";
$route['laporan/xls_data_omset.php']                    = "laporan/xls_data_omset";
$route['laporan/xls_data_omset_zahir.php']              = "laporan/xls_data_omset_zahir";
$route['laporan/xls_data_icd.php']                      = "laporan/xls_data_icd";
$route['laporan/xls_data_omset_poli.php']               = "laporan/xls_data_omset_poli";
$route['laporan/xls_data_omset_detail.php']             = "laporan/xls_data_omset_detail";
$route['laporan/htm_data_omset_jasa.php']               = "laporan/htm_data_omset_jasa";
$route['laporan/htm_data_omset_dokter.php']             = "laporan/htm_data_omset_dokter";
$route['laporan/htm_data_omset.php']                    = "laporan/htm_data_omset_global";
$route['laporan/csv_data_omset.php']                    = "laporan/htm_data_omset";

// Laporan Bukti Bayar
$route['laporan/data_bayar.php']                        = "laporan/data_bayar";
$route['laporan/set_data_bayar.php']                    = "laporan/set_data_bayar";
//$route['laporan/xls_data_pasien.php']                 = "laporan/xls_data_pasien";
//$route['laporan/xls_data_pasien2.php']                = "laporan/xls_data_pasien2";

// Laporan Remunerasi
$route['laporan/data_remunerasi.php']                   = "laporan/data_remunerasi";
$route['laporan/set_data_remunerasi.php']               = "laporan/set_data_remunerasi";
$route['laporan/xls_data_remunerasi.php']               = "laporan/xls_data_remunerasi";

// Laporan Apresiasi
$route['laporan/data_apresiasi.php']                    = "laporan/data_apresiasi";
$route['laporan/set_data_apresiasi.php']                = "laporan/set_data_apresiasi";
$route['laporan/xls_data_apresiasi.php']                = "laporan/xls_data_apresiasi";

// Laporan Rekap SDM
$route['laporan/data_cuti.php']                         = "laporan/data_cuti";
$route['laporan/set_data_cuti.php']                     = "laporan/set_data_cuti";
$route['laporan/xls_data_cuti.php']                     = "laporan/xls_data_cuti";
$route['laporan/data_periksa.php']                      = "laporan/data_periksa";
$route['laporan/data_periksa_wa.php']                   = "laporan/data_periksa_wa";
$route['laporan/set_data_periksa.php']                  = "laporan/set_data_periksa";
$route['laporan/data_karyawan_ultah.php']               = "laporan/data_karyawan_ultah";
$route['laporan/set_data_karyawan_ultah.php']           = "laporan/set_data_karyawan_ultah";
$route['laporan/data_tracer.php']                       = "laporan/data_tracer";
$route['laporan/xls_data_periksa.php']                  = "laporan/xls_data_periksa";
$route['laporan/xls_data_karyawan_ultah.php']           = "laporan/xls_data_karyawan_ultah";

// Laporan Pembelian
$route['laporan/data_pembelian.php']                    = "laporan/data_pembelian";
$route['laporan/set_data_pembelian.php']                = "laporan/set_data_pembelian";
$route['laporan/xls_data_pembelian.php']                = "laporan/xls_data_pembelian";
$route['laporan/htm_data_pembelian.php']                = "laporan/htm_data_pembelian";

// Laporan Stok
$route['laporan/data_stok.php']                         = "laporan/data_stok";
$route['laporan/data_stok_telusur.php']                 = "laporan/data_stok_telusur";
$route['laporan/data_stok_pers.php']                    = "laporan/data_stok_pers";
$route['laporan/set_data_stok.php']                     = "laporan/set_data_stok";
$route['laporan/set_data_stok_telusur.php']             = "laporan/set_data_stok_telusur";
$route['laporan/set_data_stok_pers.php']                = "laporan/set_data_stok_pers";
$route['laporan/xls_data_stok.php']                     = "laporan/xls_data_stok";
$route['laporan/xls_data_stok_telusur.php']             = "laporan/xls_data_stok_telusur";
$route['laporan/xls_data_stok_pers.php']                = "laporan/xls_data_stok_pers";
$route['laporan/xls_data_stok_gomed.php']               = "laporan/xls_data_stok_gomed";
$route['laporan/csv_data_stok_gomed.php']               = "laporan/csv_data_stok_gomed";
$route['laporan/json_pasien.php']                       = "laporan/json_pasien";

// Laporan Stok Masuk
$route['laporan/data_stok_masuk.php']                   = "laporan/data_stok_masuk";
$route['laporan/set_data_stok_masuk.php']               = "laporan/set_data_stok_masuk";
$route['laporan/xls_data_stok_masuk.php']               = "laporan/xls_data_stok_masuk";
$route['laporan/json_pasien.php']                       = "laporan/json_pasien";

// Laporan Data Tracer
$route['laporan/data_tracer.php']                       = "laporan/data_tracer";
$route['laporan/set_data_tracer.php']                   = "laporan/set_data_tracer";
$route['laporan/xls_data_tracer.php']                   = "laporan/xls_data_tracer";

// Laporan Data Tracer Divisi
$route['laporan/data_tracer_div.php']                   = "laporan/data_tracer_div";
$route['laporan/set_data_tracer_div.php']               = "laporan/set_data_tracer_div";
$route['laporan/xls_data_tracer_div.php']               = "laporan/xls_data_tracer_div";


// Laporan Stok Keluar
$route['laporan/data_stok_keluar.php']                  = "laporan/data_stok_keluar";
$route['laporan/data_stok_keluar_resep.php']            = "laporan/data_stok_keluar_resep";
$route['laporan/set_data_stok_keluar.php']              = "laporan/set_data_stok_keluar";
$route['laporan/set_data_stok_keluar_resep.php']        = "laporan/set_data_stok_keluar_resep";
$route['laporan/xls_data_stok_keluar.php']              = "laporan/xls_data_stok_keluar";
$route['laporan/xls_data_stok_keluar_resep.php']        = "laporan/xls_data_stok_keluar_resep";

// Laporan Stok Keluar Laku
$route['laporan/data_stok_keluar_laku.php']             = "laporan/data_stok_keluar_laku";
$route['laporan/set_data_stok_keluar_laku.php']         = "laporan/set_data_stok_keluar_laku";
$route['laporan/xls_data_stok_keluar_laku.php']         = "laporan/xls_data_stok_keluar_laku";

// Laporan Stok Mutasi
$route['laporan/data_stok_mutasi.php']                  = "laporan/data_stok_mutasi";
$route['laporan/set_data_stok_mutasi.php']              = "laporan/set_data_stok_mutasi";
$route['laporan/xls_data_stok_mutasi.php']              = "laporan/xls_data_stok_mutasi";

$route['laporan/data_persediaan.php']                   = "laporan/data_persediaan";
$route['laporan/data_stok2.php']                        = "laporan/data_stok2";
$route['laporan/data_penjualan.php']                    = "laporan/data_penjualan";
$route['laporan/data_penjualan_prod.php']               = "laporan/data_penjualan_prod";
$route['laporan/data_penjualan_kasir.php']              = "laporan/data_penjualan_kasir";
$route['laporan/data_penjualan_produk.php']             = "laporan/data_penjualan_kasir_produk";
$route['laporan/data_piutang.php']                      = "laporan/data_piutang";
$route['laporan/data_retur_penjualan.php']              = "laporan/data_retur_penjualan";
$route['laporan/data_retur_pembelian.php']              = "laporan/data_retur_pembelian";
$route['laporan/data_pemasukan.php']                    = "laporan/data_pemasukan";
$route['laporan/data_pengeluaran.php']                  = "laporan/data_pengeluaran";
$route['laporan/data_lr.php']                           = "laporan/data_lr";
$route['laporan/data_mutasi.php']                       = "laporan/data_mutasi";

$route['laporan/data_persediaan_pdf.php']               = "laporan/data_persediaan_pdf";
$route['laporan/data_stok_pdf.php']                     = "laporan/data_stok_pdf";
$route['laporan/data_piutang_pdf.php']                  = "laporan/data_piutang_pdf";
$route['laporan/data_penjualan_pdf.php']                = "laporan/data_penjualan_pdf";
$route['laporan/data_penjualan_prod_pdf.php']           = "laporan/data_penjualan_prod_pdf";
$route['laporan/data_penjualan_kasir_pdf.php']          = "laporan/data_penjualan_kasir_pdf";
$route['laporan/data_penjualan_kasir_pos.php']          = "cetak/termal_ctk_rkp_ksr";
$route['laporan/data_penjualan_produk_pdf.php']         = "laporan/data_penjualan_kasir_produk_pdf";
$route['laporan/data_penjualan_kasir_prd.php']          = "cetak/termal_ctk_rkp_prd";
$route['laporan/data_pembelian_pdf.php']                = "laporan/data_pembelian_pdf";
$route['laporan/data_retur_penjualan_pdf.php']          = "laporan/data_retur_penjualan_pdf";
$route['laporan/data_retur_pembelian_pdf.php']          = "laporan/data_retur_pembelian_pdf";
$route['laporan/data_pemasukan_pdf.php']                = "laporan/data_pemasukan_pdf";
$route['laporan/data_pengeluaran_pdf.php']              = "laporan/data_pengeluaran_pdf";
$route['laporan/data_lr_pdf.php']                       = "laporan/data_lr_pdf";

$route['laporan/pdf_data_persediaan.php']               = "laporan/pdf_data_persediaan";
$route['laporan/pdf_data_stok.php']                     = "laporan/pdf_data_stok";
$route['laporan/pdf_data_piutang.php']                  = "laporan/pdf_data_piutang";
$route['laporan/pdf_data_penjualan.php']                = "laporan/pdf_data_penjualan";
$route['laporan/pdf_data_penjualan_prod.php']           = "laporan/pdf_data_penjualan_prod";
$route['laporan/pdf_data_penjualan_kasir.php']          = "laporan/pdf_data_penjualan_kasir";
$route['laporan/pdf_data_penjualan_produk.php']         = "laporan/pdf_data_penjualan_kasir_produk";
$route['laporan/pdf_data_pembelian.php']                = "laporan/pdf_data_pembelian";
$route['laporan/pdf_data_retur_penjualan.php']          = "laporan/pdf_data_retur_penjualan";
$route['laporan/pdf_data_retur_pembelian.php']          = "laporan/pdf_data_retur_pembelian";
$route['laporan/pdf_data_pemasukan.php']                = "laporan/pdf_data_pemasukan";
$route['laporan/pdf_data_pengeluaran.php']              = "laporan/pdf_data_pengeluaran";
$route['laporan/pdf_data_lr.php']                       = "laporan/pdf_data_lr";
$route['laporan/ex_data_lr.php']                        = "laporan/ex_data_lr";
$route['laporan/xls_data_pengeluaran.php']              = "laporan/xls_data_pengeluaran";

$route['laporan/xls_data_stok.php']                     = "laporan/xls_data_stok";
$route['laporan/xls_data_stok2.php']                    = "laporan/xls_data_stok2";
$route['laporan/xls_data_penjualan.php']                = "laporan/xls_data_penjualan";
$route['laporan/xls_data_piutang.php']                  = "laporan/xls_data_piutang";
$route['laporan/xls_data_pembelian.php']                = "laporan/xls_data_pembelian";

$route['laporan/set_lap_persediaan.php']                = "laporan/set_lap_persediaan";
$route['laporan/set_lap_stok.php']                      = "laporan/set_lap_stok";
$route['laporan/set_lap_piutang.php']                   = "laporan/set_lap_piutang";
$route['laporan/set_lap_penjualan.php']                 = "laporan/set_lap_penjualan";
$route['laporan/set_lap_penjualan_prod.php']            = "laporan/set_lap_penjualan_prod";
$route['laporan/set_lap_penjualan_kasir.php']           = "laporan/set_lap_penjualan_kasir";
$route['laporan/set_lap_penjualan_produk.php']          = "laporan/set_lap_penjualan_produk";
$route['laporan/set_lap_ret_penjualan.php']             = "laporan/set_lap_ret_penjualan";
$route['laporan/set_lap_ret_pembelian.php']             = "laporan/set_lap_ret_pembelian";
$route['laporan/set_lap_pemasukan.php']                 = "laporan/set_lap_pemasukan";
$route['laporan/set_lap_pengeluaran.php']               = "laporan/set_lap_pengeluaran";
$route['laporan/set_lap_mutasi.php']                    = "laporan/set_lap_mutasi";

$route['laporan/data_referall.php']                     = "laporan/data_referall";
$route['laporan/set_data_referall.php']                 = "laporan/set_data_referall";
$route['laporan/xls_data_referall.php']                 = "laporan/xls_data_referall";
/* -- END -- */


/* -- POS -- */
// Untuk penjualan bebas seperti apotik dll
$route['pos/index.php']                                 = "Pos/Index";
$route['pos/data_pelanggan_tambah.php']                 = "Pos/data_pelanggan_tambah";
$route['pos/trans_jual.php']                            = "Pos/trans_jual";
$route['pos/trans_jual_inv.php']                        = "Pos/trans_jual_invoice";
$route['pos/trans_jual_inv_print_dm.php']               = "Pos/trans_jual_invoice_print_dm";
$route['pos/trans_jual_list.php']                       = "Pos/trans_jual_list";
$route['pos/trans_jual_simpan.php']                     = "Pos/trans_jual_simpan";
$route['pos/trans_jual_hapus.php']                      = "Pos/trans_jual_hapus";
$route['pos/set_trans_jual.php']                        = "Pos/set_trans_jual";
$route['pos/set_trans_jual_proses.php']                 = "Pos/set_trans_jual_proses";
$route['pos/set_trans_jual_upd.php']                    = "Pos/set_trans_jual_upd";
$route['pos/set_trans_jual_upd_proses.php']             = "Pos/set_trans_jual_upd_proses";
$route['pos/set_trans_jual_simpan_item.php']            = "Pos/set_trans_jual_simpan_item";
$route['pos/set_trans_jual_hapus_item.php']             = "Pos/set_trans_jual_hapus_item";
$route['pos/set_trans_jual_batal.php']                  = "Pos/set_trans_jual_batal";
$route['pos/set_trans_jual_batal_post.php']             = "Pos/set_trans_jual_batal_posting";
$route['pos/set_trans_jual_cari.php']                   = "Pos/set_trans_jual_cari";
$route['pos/set_pelanggan_simpan.php']                  = "Pos/set_pelanggan_simpan";
$route['pos/json_customer.php']                         = "Pos/json_customer";
$route['pos/json_item.php']                             = "Pos/json_item";

/* -- e-PASIEN -- */
$route['pasien/login.php']                              = "Pasien/login";
$route['pasien/logout.php']                             = "Pasien/logout";
$route['pasien/cek_login.php']                          = "Pasien/cek_login";
$route['pasien/cek_login2.php']                         = "Pasien/cek_login2";
$route['pasien/dashboard.php']                          = "Pasien/dashboard";
$route['pasien/pendaftaran.php']                        = "Pasien/pendaftaran";
$route['pasien/pendaftaran_baru.php']                   = "Pasien/pendaftaran_baru";
$route['pasien/profile.php']                            = "Pasien/profile";
$route['pasien/detail.php']                             = "Pasien/detail";
$route['pasien/riwayat_lab.php']                        = "Pasien/riwayat_lab";
$route['pasien/riwayat_rad.php']                        = "Pasien/riwayat_rad";
$route['pasien/riwayat_berkas.php']                     = "Pasien/riwayat_berkas";
$route['pasien/set_daftar.php']                         = "Pasien/set_daftar";
$route['pasien/set_daftar_baru.php']                    = "Pasien/set_daftar_baru";
$route['pasien/set_daftar_hapus.php']                   = "Pasien/set_daftar_hapus";
$route['pasien/surat/cetak_pdf_lab.php']                = "Pasien/pdf_riwayat_lab";
$route['pasien/surat/cetak_pdf_rad.php']                = "Pasien/pdf_riwayat_rad";
$route['pasien/surat/cetak_pdf_berkas.php']             = "Pasien/pdf_riwayat_berkas";
/* -- PASIEN -- */

/* Pengaturan */
$route['pengaturan/index.php']                          = "pengaturan/index";
$route['pengaturan/set_pengaturan.php']                 = "pengaturan/set_pengaturan";
$route['pengaturan/data_cabang_list.php']               = "pengaturan/cabang_list";
$route['pengaturan/data_cabang_simpan.php']             = "pengaturan/cabang_simpan";
$route['pengaturan/data_cabang_update.php']             = "pengaturan/cabang_update";
$route['pengaturan/data_cabang_hapus.php']              = "pengaturan/cabang_hapus";
$route['pengaturan/data_user_list.php']                 = "pengaturan/user_list";
$route['pengaturan/data_user_simpan.php']               = "pengaturan/user_simpan";
$route['pengaturan/data_user_update.php']               = "pengaturan/user_update";
$route['pengaturan/data_user_hapus.php']                = "pengaturan/user_hapus";
$route['profile.php']                                   = "pengaturan/profile";
$route['set_profile_update.php']                        = "pengaturan/set_profile_update";


$route['pengaturan/set_cari_user.php']                  = "pengaturan/set_cari_user";
$route['pengaturan/set_cari_cabang.php']                = "pengaturan/set_cari_cabang";

$route['json_member.php']                               = "transaksi/json_member";
$route['logout.php']                                    = "login/logout";

$route['transaksi/cetak_nota_termal.php']               = "cetak/termal_ctk";


$route['medcheck/add_param.php']                        = "medcheck/add_param";
$route['medcheck/add_param_prod.php']                   = "medcheck/add_param_prod";
$route['medcheck/search_parameters.php']                = "medcheck/search_parameters";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
