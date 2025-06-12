<?php echo $this->extend('layouts/layout-2')?>

<?php echo $this->section('content')?>


<div class="container">
    <div class="row">
        <div class="col-12">
            <h4>Vendors</h4>
        </div>
        <div class="col-12 col-md-8">
            <table class="vendors-dt table table-bordered"></table>
        </div>
        <div class="col-12 col-md-4">
            <?= $this->include('vendors/form'); ?>
        </div>
    </div>
</div>

<?php echo $this->endSection()?>

<?php echo $this->section('scripts')?>

<script src="<?php echo base_url(); ?>scripts/vendors/list.js"></script>
<script src="<?php echo base_url(); ?>scripts/vendors/form.js"></script>

<?php echo $this->endSection()?>