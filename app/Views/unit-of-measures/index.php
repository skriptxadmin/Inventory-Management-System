<?php echo $this->extend('layouts/layout-2')?>

<?php echo $this->section('content')?>


<div class="container">
    <div class="row">
        <div class="col-12">
            <h4>Unit of Measures</h4>
        </div>
        <div class="col-12 col-md-8">
            <table class="unit-of-measures-dt table table-bordered"></table>
        </div>
        <div class="col-12 col-md-4">
            <?= $this->include('unit-of-measures/form'); ?>
        </div>
    </div>
</div>

<?php echo $this->endSection()?>

<?php echo $this->section('scripts')?>

<script src="<?php echo base_url(); ?>scripts/unit-of-measures/list.js"></script>
<script src="<?php echo base_url(); ?>scripts/unit-of-measures/form.js"></script>

<?php echo $this->endSection()?>