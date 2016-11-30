<div id="wrapper">
    <div id="main-container">
        <?php foreach($data as $channel): ?>
            <div><?php echo $channel['name']; ?></div>
            <a href="<?php echo $channel['href']; ?>"><img src="<?php echo $channel['preview']; ?>"/></a>
        <?php endforeach; ?>
    </div>
</div>