<?php echo $this->extend('layouts/layout-2')?>

<?php echo $this->section('content')?>


<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
            <h4>Invoices</h4>
            <a class="btn btn-primary" href="<?= base_url('/invoices/form') ?>">New</a>
            </div>
        </div>
        <div class="col-12">
            <table class="invoices-dt table table-bordered"></table>
        </div>
       
    </div>
</div>

<?php echo $this->endSection()?>

<?php echo $this->section('scripts')?>

<script src="<?php echo base_url(); ?>scripts/invoices/list.js"></script>

<?php echo $this->endSection()?>