<!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.0.3
    </div>
    <strong>Copyright &copy; 2020-2021 <a href="#">DnationSoft</a>.</strong> All rights
    reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>/backend/assets/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="<?php echo base_url()?>/backend/assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url()?>/backend/assets/js/additional-methods.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url()?>/backend/assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>/backend/assets/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/backend/assets/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>/backend/assets/js/responsive.bootstrap4.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo base_url()?>/backend/assets/js/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>/backend/assets/js/adminlte.min.js"></script>

<!--all custome js-->


<?php  //require_once(APPPATH.'../public_html/backend/assets/js/ajaxJs.php'); ?>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>/backend/assets/js/demo.js"></script>
<!-- page script -->
<script>
    $(document).ready(function() {
        $('#description').richText();
        $('#description2').richText();
        $('#description3').richText();
        $('#description4').richText();
        $('#description5').richText();
        // $('[name="description"]').richText();
    });
    // CKEDITOR.replace( 'editor' );
</script>

</body>
</html>