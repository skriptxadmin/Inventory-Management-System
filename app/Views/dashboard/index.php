<?= $this->extend('layouts/layout-2') ?>

<?= $this->section('content') ?>


<div class="container">
<?= $this->include('dashboard/summary');?>
<?= $this->include('dashboard/stock');?>

</div>



<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="<?php echo base_url(); ?>scripts/dashboard/summary.js"></script>
<script src="<?php echo base_url(); ?>scripts/dashboard/stock.js"></script>

<?= $this->endSection() ?>
