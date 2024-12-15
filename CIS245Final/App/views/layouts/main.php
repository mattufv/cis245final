<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes and emotes</title>
    <?php /*
    <base href="<?php echo BASE; ?>">
    */ ?>
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
	<?php
	$path = realpath(BASE_PATH . '/../../') . "/includes/";
	$header_file = $path . "header.php";
	$footer_file = $path . "footer.php";
	?>
    <div class="site-wrapper">
        <?php include $header_file; ?>
        <main>
            <?php echo $content; ?>
        
        </main>
        <?php include $footer_file; ?>
    </div>
</body>
</html>