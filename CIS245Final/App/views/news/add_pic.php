<h2>Add Pic</h2>
    <?php if (isset($authorized) && $authorized !== 0):?>
    <form method="post" enctype="multipart/form-data">
        <label for="file">Upload Pic: </label>
        <input type="file" name="file" id="file">
        <button type="submit">Upload</button>
    </form>
    <?php endif; ?>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>