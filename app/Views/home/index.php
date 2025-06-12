<?= $this->extend('layouts/layout-1') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-center align-items-center vh-screen">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                <form action="" class="login">
                    <fieldset>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Login</h4>
                                <div class="form-group mb-2">
                                    <label for="username" class="form-label">Email/Mobile</label>
                                    <input type="text" id="username" name="username" class="form-control"
                                        autocomplete="username" autofocus value="administrator@example.com">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control"
                                        autocomplete="curent-password" value="Password@123">
                                </div>
                                <div class="d-flex justify-content-end align-items-center">
                                    <button class="btn btn-primary">Login</button>
                                </div>

                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="<?php echo base_url();?>scripts/guest/login.js"></script>

<?= $this->endSection() ?>
