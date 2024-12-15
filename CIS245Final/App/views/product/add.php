<h2>Add Products</h2>
    <?php if (isset($authorized) && $authorized !== 0):?>
        <form method="post" enctype="multipart/form-data">
            Name: <input type="text" name="name" id="name" required><br>
            Price: <input type="text" name="price" id="price" required><br>
            Pic: <input type="file" name="file" id="file" required><br>
            <button type="submit">Add Product</button>
        </form>
    <?php endif; ?>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>