  <form action="" class="invoice my-3" data-invoice-id="<?php echo $id?>">
      <fieldset>
          <div class="row my-2">
             <div class="col-12 col-md-3">
                  <div class="form-group ">
                      <select name="outlet_id" id="outlet_id" class="form-select">
                        <option value="">Select Outlet</option>
                        <?php foreach($outlets as $outlet){ ?> 
                            <option value="<?= $outlet->id; ?>"><?= $outlet->name; ?></option>    
                        <?php } ?>
                      </select>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="form-group ">
                      <select name="customer_id" id="customer_id" class="form-select">
                      </select>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="invoiceNo" placeholder="Invoice Number">
                </div>
              </div>
              <div class="col-12 col-md-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="invoiceDate" placeholder="Date of Invoice">
                    </div>
              </div>
          </div>
          <table class="table table-bordered invoice">
              <thead>
                  <tr>
                      <th style="width:80px">SNo</th>
                      <th style="width:400px">Product</th>
                      <th>Unit</th>
                      <th style="width:120px">Quantity</th>
                      <th style="width:120px">Price</th>
                      <th style="width:120px">Total</th>
                      <th style="width:80px">Action</th>
                  </tr>
              </thead>
              <tbody class="line-items"></tbody>
              <tbody class="summary">
                  <tr>
                      <td colspan="5" class="text-end">SubTotal</td>
                      <td colspan="2" class="subtotal text-end"></td>
                  </tr>
                  <tr>
                      <td colspan="5" class="text-end">Taxes</td>
                      <td colspan="2" class="p-0">
                          <input type="text" name="taxes" class="form-control text-end" value="0">
                      </td>
                  </tr>
                  <tr>
                      <td colspan="5" class="text-end">Discount</td>
                      <td colspan="2" class="p-0">
                          <input type="text" name="discount" class="form-control text-end" value="0">
                      </td>
                  </tr>
                  <tr>
                      <td colspan="5" class="text-end">Total</td>
                      <td colspan="2" class="total text-end"></td>
                  </tr>
                   <tr>
                      <td colspan="5" class="text-end">Paid</td>
                      <td colspan="2" class="p-0">
                          <input type="text" name="paid" class="form-control text-end" value="0">
                      </td>
                  </tr>
                   <tr>
                     <td colspan="5" class="text-end">Balance</td>
                      <td colspan="2" class="balance text-end"></td>
                  </tr>
                  <tr>
                    <td class="p-0" colspan="7">
                        <textarea name="description" class="form-control" placeholder="Enter description"></textarea>
                    </td>
                  </tr>
              </tbody>
          </table>
          <div class="d-flex justify-content-end align-items-center">
              <button class="btn btn-primary" type="submit">Submit</button>
          </div>
      </fieldset>
  </form>

  <script type="text/html" id="invoiceFormTbody">
<tr>
    <td class="text-center"></td>
    <td class="p-0">
        <select name="product" class="form-select"></select>
    </td>
    <td class="text-center unit"></td>
    <td class="p-0">
        <input type="number" name="quantity" class="form-control text-center" value="0">
    </td>
    <td class="p-0">
        <input type="number" name="price" class="form-control text-center" value="0">
    </td>
    <td class="p-0 text-center row-total">0</td>
    <td class="p-0 text-center">
        <button type="button" class="btn text-danger remove-row">
            <?= svg_icon('trash') ?>
        </button>
    </td>
</tr>
  </script>