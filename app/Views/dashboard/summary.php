<div class="row">
    <div class="col-12">
                <div id="duration" class="d-flex justify-content-between align-items-center">
                    <input type="text" class="form-control" name="start" placeholder="Start">
                    <input type="text" class="form-control" name="end" placeholder="End">
                </div>
    </div>

</div>
<div class="row my-3">
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Purchase</h4>
                <h5 class="card-subtitle text-center text-muted">(A)</h5>

            </div>
            <div class="card-body">
                <h1 class="text-center" data-field="purchase.total"></h1>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Paid</h4>
                <h5 class="card-subtitle text-center text-muted">(B)</h5>

            </div>
            <div class="card-body">
                <h1 class="text-center" data-field="purchase.total"></h1>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Balance</h4>
                <h5 class="card-subtitle text-center text-muted">(C =  A-B)</h5>

            </div>
            <div class="card-body">
                <h1 class="text-center"  data-field="purchase.balance"></h1>
            </div>
        </div>
    </div>
</div>

<div class="row my-3">
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Sales</h4>
                <h5 class="card-subtitle text-center text-muted">(A)</h5>

            </div>
            <div class="card-body">
                <h1 class="text-center"  data-field="invoice.total"></h1>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Received</h4>
                <h5 class="card-subtitle text-center text-muted">(B)</h5>

            </div>
            <div class="card-body">
                <h1 class="text-center"  data-field="invoice.paid"></h1>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Balance</h4>
                <h5 class="card-subtitle text-center text-muted">(C =  A-B)</h5>

            </div>
            <div class="card-body">
                <h1 class="text-center"  data-field="invoice.balance"></h1>
            </div>
        </div>
    </div>
</div>