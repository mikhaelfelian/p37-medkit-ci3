            <?php $pengaturan = $this->db->get('tbl_pengaturan')->row(); ?>
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <strong>Copyright &copy; <?php echo date('Y') ?> <a href="<?php echo $pengaturan->website ?>"><?php echo $pengaturan->judul ?></a>.</strong>
                <!--All rights reserved.-->
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 2.0
                </div>
            </footer>
        </div>
        <!-- ./wrapper -->

