<h2>Products</h2>
<?php if (isset($error)) echo "$error"; ?>
<?php
if (!empty($products)):
    foreach ($products as $product): ?>
            <h3><?php echo $product->name; ?></h3>
            <p>Price:<?php echo $product->price; ?></p>
            <img src="<?php echo $product->pic; ?>"></p>
    <?php endforeach;
else: ?>
    <?php if (isset($error)) echo "$error"; ?>
    No products found.
<?php endif; ?>