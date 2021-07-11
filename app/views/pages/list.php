<?php require(APPROOT . '/views/inc/header.php'); ?>


<body class="list __list">
    <header>
        <a id="add-record" title="add new item" href="<?php echo URLROOT; ?>/pages/addItem"><i
                class="fas fa-plus"></i></a>

        <div class="search-wrapper cf">
            <input type="text" id="filter-list" placeholder="name/model" required>
            <button type="submit">Search</button>
        </div>
    </header>

    <main id="list-inventory" class="list">
        <?php while($in = $data['inventory']->fetch_assoc()): ?>
        <?php if(empty($in['image'])): ?>
        <div>
            <a class="list__item" href="<?php echo URLROOT; ?>/pages/viewItem/<?php echo $in['item_id']; ?>"><img
                    class="lazy" loading="lazy" src="<?php echo URLROOT; ?>/public/images/images/placeholder.png"
                    alt="item"></a>
            <p class="item-name"><?php echo $in['item_name']; ?></p>
        </div>
        <?php else: ?>
        <div><a class="list__item" href="<?php echo URLROOT; ?>/pages/viewItem/<?php echo $in['item_id']; ?>"><img
                    class="lazy" loading="lazy" src="<?php echo URLROOT; ?>/public/uploads/<?php echo $in['image']; ?>"
                    alt="<?php echo $in['item_name']; ?>"></a>
            <p class="item-name"><?php echo $in['item_name']; ?> - <?php echo number_format($in['item_buying']) ?></p>

        </div>
        <?php endif; ?>
        <?php endwhile ?>
        <!-- images placed inside block elements to deal with a Firefox rendering bug affecting  scaled flexbox images -->
    </main>
</body>

<?php require(APPROOT . '/views/inc/footer.php'); ?>

</html>