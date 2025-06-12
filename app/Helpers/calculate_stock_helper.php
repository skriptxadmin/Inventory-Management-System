<?php

function calculate_stock($product_ids = [])
{

    $stockModel = model('Stock');

    $builder = $stockModel->db->table('products p')
        ->select('
        p.id as product_id,
        COALESCE(pi.total_purchased, 0) AS purchased,
        COALESCE(SUM(ii.quantity), 0) AS invoiced,
        COALESCE(pi.total_purchased, 0) - COALESCE(SUM(ii.quantity), 0) AS balance
    ')
        ->join(
            '(SELECT product_id, SUM(quantity) AS total_purchased
          FROM purchase_items
          WHERE deleted_at IS NULL
          GROUP BY product_id) pi',
            'pi.product_id = p.id',
            'left'
        )
        ->join('invoice_items ii', 'ii.product_id = p.id AND ii.deleted_at IS NULL', 'left')
        ->where('p.deleted_at IS NULL');

        if(!empty($product_ids)){
            $builder->whereIn('p.id', $product_ids);
        }
       $result = $builder->groupBy('p.id')
        ->get()
        ->getResult();

    $productIds = array_column($result, 'product_id');

    $existing    = $stockModel->whereIn('product_id', $productIds)->findAll();
    $existingIds = array_column($existing, 'product_id');

    $toInsert = [];
    $toUpdate = [];

    foreach ($result as $product) {
        if (in_array($product->product_id, $existingIds)) {
            $existingItem = array_filter($existing, fn($e) => $e->product_id == $product->product_id);
            $toUpdate[]   = $product;
        } else {
            $toInsert[] = $product;
        }
    }

    if (! empty($toUpdate)) {
        $stockModel->updateBatch($toUpdate, 'product_id');
    }

    if (! empty($toInsert)) {
        $stockModel->insertBatch($toInsert);
    }

    return [$result, $productIds, $existingIds];

}
