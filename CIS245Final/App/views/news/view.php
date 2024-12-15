<h2>News</h2>
<?php if (isset($error)) echo "$error"; ?>
<?php
if (!empty($news)):
    foreach ($news as $news_piece): ?>
            <h3><?php echo $news_piece->title; ?></h3>
            <p>Posted on : <b><?php echo $news_piece->date; ?> </b> By <?php echo $news_piece->author["username"]; ?></p>
            <p><?php echo $news_piece->content; ?></p>
            <?php /*<a href="?controller=note&method=edit&i=<?php echo $news_piece->get_id(); ?>">Edit</a> | <a href="?conrtoller=note&method=delete&i=<?php echo $news_piece->get_id(); ?>">Delete</a> */ ?>
    <?php endforeach;
else: ?>
    <?php if (isset($error)) echo "$error"; ?>
    No news found.
<?php endif; ?>
<h2>Photos</h2>
<?php
if (!empty($photos)):
    foreach ($photos as $photo): ?>
        <img src="<?php echo $photo; ?>">
    <?php endforeach;
else: ?>
        No photos found.
<?php endif; ?>