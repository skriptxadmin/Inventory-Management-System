<?php echo $this->extend('layouts/layout-2')?>

<?php echo $this->section('content')?>


<div class="container">
    <div class="row">
        <div class="col-12">
           <h4>Users</h4>
            <div>
                 <select name="roles" class="form-select w-25">
                <option value="">Select Role</option>
                <?php foreach($roles as $role){ ?> 
                <option value="<?= $role->id; ?>"><?= $role->name; ?></option>                    
                <?php } ?>
            </select>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <table class="users-dt table table-bordered"></table>
        </div>
        <div class="col-12 col-md-4">
            <?= $this->include('users/form'); ?>
        </div>
    </div>
</div>

<?php echo $this->endSection()?>

<?php echo $this->section('scripts')?>

<script src="<?php echo base_url(); ?>scripts/users/list.js"></script>
<script src="<?php echo base_url(); ?>scripts/users/form.js"></script>

<?php echo $this->endSection()?>