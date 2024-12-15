<div class="card">
    <h2>Admin Dashboard</h2>
    <?php if ($allowed === 1): ?>
    <a href="?controller=news&method=add">Add news</a>
    <br><br>
    <a href="?controller=product&method=add">Add Products</a>
    <br><br>
    <a href="?controller=news&method=add_pic">Add Photos</a>
    <?php endif; ?>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</div>