<?php echo $this->extend('layouts/layout-2')?>

<?php echo $this->section('content')?>


<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-start align-items-center gap-2">
            <a class="text-black" href="<?= base_url('/invoices') ?>"><?= svg_icon('arrow-left') ?></a>
            <h4 class="m-0">Invoice</h4>
            </div>
        </div>
        <div class="col-12">
            <?= $this->include('invoices/form/form') ?>
          
        </div>
    </div>
</div>

<?php echo $this->endSection()?>

<?php echo $this->section('scripts')?>

<script src="<?php echo base_url(); ?>scripts/invoices/form.js"></script>

<?php echo $this->endSection()?>