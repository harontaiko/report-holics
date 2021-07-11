<div>
    <a href="#" title="Close" class="modal-close">Close</a>
    <h1 class="inventory-title">Inventory</h1>
    <input type="search" class="light-table-filter dr_input" data-table="order-table"
        placeholder="Filter (name/creator/no.)" />
    <section class="table-box">
        <table class="order-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Item No.</th>
                    <th>Quantity</th>
                    <th>Model</th>
                    <th>In Stock</th>
                    <th>Sold</th>
                    <th>Created on</th>
                    <th>Creator</th>
                    <th>edit</th>
                    <th>delete</th>
                    <th>view</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($inventory = $data['inventory']->fetch_assoc()) : 
                                    $instock = $inventory['item_quantity'];
                                    $sold = getItemSoldCountInventory($inventory['item_name'],$data['db']);
                                    ?>
                <tr>
                    <td><?php echo isset($inventory['item_name']) ? $inventory['item_name']: ''; ?></td>
                    <td>DR0<?php echo isset($inventory['item_id']) ? $inventory['item_id']: ''; ?>
                    </td>
                    <td><?php echo isset($inventory['item_quantity']) ? $inventory['item_quantity']: ''; ?>
                    </td>
                    <td><?php echo isset($inventory['item_model']) ? $inventory['item_model']: '';; ?>
                    </td>
                    <td><?php echo ($instock - $sold); ?>
                    </td>
                    <td><?php echo $sold ?>
                    </td>
                    <td> <?php echo date(
                                  'jS M Y',
                                  strtotime(
                                    htmlspecialchars($inventory["date_created"])
                                  )
                                ); ?> at <?php echo date(
                                    'h:iA',
                                    strtotime(
                                      htmlspecialchars($inventory["time_created"])
                                    )
                                  ); ?></td>
                    <td><?php echo isset($inventory['created_by']) ? $inventory['created_by']: ''; ?>
                    </td>
                    <td><a
                            href="<?php echo URLROOT; ?>/pages/editInventory/<?php echo isset($inventory['item_id']) ? $inventory['item_id']: ''; ?>">edit</a>
                    </td>
                    <td><a
                            href="<?php echo URLROOT; ?>/pages/removeItem/<?php echo isset($inventory['item_id']) ? $inventory['item_id']: ''; ?>">remove</a>
                    </td>
                    <td><a
                            href="<?php echo URLROOT; ?>/pages/viewItem/<?php echo isset($inventory['item_id']) ? $inventory['item_id']: ''; ?>">view</a>
                    </td>
                </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </section>

</div>