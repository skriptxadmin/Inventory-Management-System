  <script>
window.app = {
    baseurl: "<?php echo base_url();?>",
    isUserLoggedIn: <?php echo is_user_logged_in()? 'true':'false';?>,
    svgs: {
        "trash": '<?= svg_icon('trash'); ?>',
        "edit": '<?= svg_icon('edit'); ?>',
    }
}


  </script>

  <script src="<?php echo base_url(); ?>libs/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>libs/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>libs/lodash.min.js"></script>
  <script src="<?php echo base_url(); ?>libs/moment.min.js"></script>
  <script src="<?php echo base_url(); ?>libs/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo base_url(); ?>libs/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo base_url(); ?>libs/DataTables/datatables.min.js"></script>
  <script src="<?php echo base_url(); ?>libs/swal/swal.min.js"></script>
  <script src="<?php echo base_url(); ?>libs/select2/js/select2.full.min.js"></script>
  <script src="<?php echo base_url(); ?>libs/datepicker/datepicker-full.min.js"></script>
  <script src="<?php echo base_url(); ?>scripts/libs.js"></script>
  <script src="<?php echo base_url(); ?>scripts/app.js"></script>