<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Pilih Kategori
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li><a href="<?php echo base_url('set_order1.php?id_kat1='.$_GET['id_kat1']) ?>"><?php echo $this->db->where('id', general::dekrip($_GET['id_kat1']))->get('tbl_m_kategori')->row()->kategori ?></a></li>
                <li class="active"><?php echo $this->db->where('id', general::dekrip($_GET['id_kat2']))->get('tbl_m_kategori2')->row()->kategori ?></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <?php foreach ($kategori3 as $kategori) { ?>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3><?php echo ucwords($kategori->kategori) ?></h3>
                                <p>&nbsp;</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="<?php echo base_url('set_cart.php?id_kat1='.general::enkrip($kategori->id_kategori).'&id_kat2='.general::enkrip($kategori->id_kategori2).'&id_kat3='.general::enkrip($kategori->id)) ?>" class="small-box-footer">Pilih <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
</div>