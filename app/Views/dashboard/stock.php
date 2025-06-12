<div class="row">
    <div class="col-12 col-md-4">
        <h4>Stock Summary</h4>

    </div>
    <div class="col-12 col-md-4"></div>
    <div class="col-12 col-md-4">
        <form action="" class="stock-qty">
        <div class="input-group mb-3">
            
            <input type="number" class="form-control" placeholder="Minimum Stock" aria-label="Minimum Stock" value="10">
            <button class="btn btn-outline-secondary" type="submit"><?= svg_icon('refresh') ?></button>
        </div>
       </form>

    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-bordered dashboard-stock-dt"></table>
    </div>
</div>