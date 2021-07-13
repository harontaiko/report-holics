<div class="content-wrapper">
    <div id="focus" tabindex="0"></div>
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="fas fa-cash-register fa-2x"></i>
            </span> View Item
        </h3>
        <a href="<?php echo URLROOT; ?>/pages/list" class="btn btn-gradient-info text-right">back</a>
    </div>
    <?php if(getInventoryItemById($data['id'], $data['db'])): ?>
    <div class="wrapper">
        <nav id="carousel-btns">
            <?php if($data['id'] == $data['first']): ?>
            <a class="cr-link" href="#!"><button disabled class="nav prev">Prev</button></a>
            <?php else: ?>
            <a class="cr-link" href="<?php echo URLROOT; ?>/pages/viewItem/<?php echo $data['prev']; ?>"><button
                    class="nav prev">Prev</button></a>
            <?php endif; ?>
            <?php if($data['id'] == $data['last']): ?>
            <a class="cr-link" href="#!" title="the end"><button disabled class="nav next">Next</button></a>
            <?php else: ?>
            <a class="cr-link" href="<?php echo URLROOT; ?>/pages/viewItem/<?php echo $data['next']; ?>"><button
                    class="nav next">Next</button></a>
            <?php endif; ?>
        </nav>
        <h1><?php print_r($data['row']['0']['item_name']); ?> -
            <strong><?php echo number_format($data['row']['0']['item_buying']); ?>/=</strong>
        </h1>
        <p>
            <a class="g-hub" href="<?php echo URLROOT; ?>/pages/editInventory/<?php echo $data['id']; ?>">Edit this
                inventory item</a>
        </p>
        <?php if(empty($data['row']['0']['image'])): ?>
        <img style="width:30% !important; height:auto !important; " loading="lazy"
            src="https://plchldr.co/i/150x150?&bg=ccc&fc=fff&text=<?php print_r($data['row']['0']['item_name']); ?>"
            id="item-image" alt="no image for <?php print_r($data['row']['0']['item_name']); ?>">
        <?php else: ?>
        <img style="width:50%; " loading="lazy"
            src="<?php echo URLROOT; ?>/public/uploads/<?php print_r($data['row']['0']['image']); ?>" id="item-image"
            alt="<?php print_r($data['row']['0']['image']); ?>">
        <?php endif; ?>
        <div id="threesixty"
            style="background-size:contain;background-position:center;background-repeat: no-repeat; width:50% !important; height:50% !important;">
        </div>
        <div class="buttons-wrapper">
            <h2>In Stock:
                <?php
            $instock = $data['row']['0']['item_quantity'];
            $sold = getItemSoldCountInventory($data['row']['0']['item_name'],$data['db']);
            echo $instock - $sold;
            ?>
            </h2>
        </div>
    </div>
    <?php else: ?>
    <div class="box">
        <h1 class="title" id="h1-title">No item found in the records!</h1>
        <script src="https://cdn.lordicon.com//libs/frhvbuzj/lord-icon-2.0.2.js"></script>
        <lord-icon src="https://cdn.lordicon.com//hrqwmuhr.json" trigger="loop"
            colors="primary:#121331,secondary:#08a88a" style="width:250px;height:250px">
        </lord-icon>
    </div>
    <?php endif; ?>
</div>