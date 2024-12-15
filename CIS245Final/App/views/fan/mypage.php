<h2>This is your fan page</h2>
<h3>Welcome <?php echo $_SESSION["username"];?></h3>
<?php if (isset($ppic)) {
    echo "<img src='$ppic'>";
} ?>
<p>Upload photo:</p>
<form method="post" enctype="multipart/form-data">
    <label for="file">Upload Profile Pic: </label>
    <input type="file" name="file" id="file">
    <button type="submit">Upload</button>
</form>
<?php if (isset($message) && !is_array($message)) echo $message;?>
<?php if (isset($message) && is_array($message)) {
    foreach ($message as $x) {
        echo "<p>$x</p>";
    }
}