<form action="" class="product">
    <input type="hidden" name="id">
    <fieldset>
        <div class="form-group mb-2">
            <label for="category">Category</label>
            <select name="category" id="category" class="form-select"></select>
        </div>
        <div class="form-group mb-2">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control"> 
        </div>
        <div class="form-group mb-2">
            <label for="uom">Unit</label>
            <select name="uom" id="uom" class="form-select">
                <option value="">Select Unit</option>
                <?php foreach($uoms as $uom){ ?> 
                    <option value="<?= $uom->id ?>"><?= $uom->name ?></option>    
                <?php } ?>
            </select>
        </div>
        <div class="form-group mb-2">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
    </fieldset>
</form>