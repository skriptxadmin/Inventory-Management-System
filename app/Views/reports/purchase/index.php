<?php echo $this->extend('layouts/layout-2')?>

<?php echo $this->section('styles')?>
<style>
    .dt-search {
  display: none;
}
</style>
<?php echo $this->endSection()?>

<?php echo $this->section('content')?>


<div class="container">
    <div class="row">
        <div class="col-12">
            <h4>Purchase Report</h4>
        </div>
        <div class="row">
             <div class="col-12 col-md-3">
                <select name="vendorId" class="form-select">
                   
                </select>
            </div>
            <div class="col-12 col-md-4">
                <select name="productId" class="form-select"></select>
            </div>
            <div class="col-12 col-md-4">
                <div id="duration" class="d-flex justify-content-between align-items-center">
                    <input type="text" class="form-control" name="start" placeholder="Start">
                    <input type="text" class="form-control" name="end" placeholder="End">
                </div>
            </div>
            <div class="col-12 col-md-1">
                <button class="btn btn-primary btn-get-report">Get</button>
            </div>
        </div>

        <div class="col-12">
            <table class="purchase-report-dt table table-bordered"></table>
        </div>

    </div>
</div>

<?php echo $this->endSection()?>

<?php echo $this->section('scripts')?>

<script src="<?php echo base_url(); ?>scripts/reports/purchase/list.js"></script>

<?php echo $this->endSection()?>