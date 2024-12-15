    <h2>Add News</h2>
    <?php if (isset($authorized) && $authorized !== 0):?>
        <form method="post">
            Title: <input type="text" name="title" id="title" required><br>
            Content: <input type="text" name="content" id="content" required><br>
            <button type="submit">Add News</button>
        </form>
    <?php endif; ?>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>