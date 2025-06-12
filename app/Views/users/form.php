<form action="" class="user">
    <h4>User Form</h4>
    <input type="hidden" name="id">
    <fieldset>
        <div class="form-group mb-2">

         <select name="role_id" class="form-select">
                <option value="">Select Role</option>
                <?php foreach($roles as $role){ ?> 
                <option value="<?= $role->id; ?>"><?= $role->name; ?></option>                    
                <?php } ?>
            </select>
                </div>
        <div class="form-group mb-2">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" class="form-control"> 
        </div>
          <div class="form-group mb-2">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" class="form-control"> 
        </div>
        <div class="form-group mb-2">
            <label for="mobile">Mobile</label>
            <input type="text" id="mobile" name="mobile" class="form-control"> 
        </div>
         <div class="form-group mb-2">
            <label for="password">Password</label>
            <input type="text" id="password" name="password" class="form-control"> 
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
    </fieldset>
</form>