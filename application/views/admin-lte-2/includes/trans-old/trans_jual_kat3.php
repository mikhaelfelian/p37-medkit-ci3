<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Pulito
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Transaksi</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <?php foreach ($kategori3 as $kategori3) { ?>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3><?php echo ucwords($kategori3->kategori) ?></h3>
                                <p>&nbsp;</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="<?php echo base_url('cart/cart-step-4.php?id_kat1='.$this->input->get('id_kat1').'&id_kat2='.$this->input->get('id_kat2').'&id_kat3='.general::enkrip($kategori3->id)) ?>" class="small-box-footer">Pilih <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
</div>