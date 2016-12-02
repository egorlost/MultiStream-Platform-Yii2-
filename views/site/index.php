<div id="wrapper">
    <div id="main-container">
        <?php foreach($data as $channel): ?>
            <a href="<?php echo $channel['href']; ?>"><img src="<?php echo $channel['image']; ?>" width="272px" height="380px"/></a>
        <?php endforeach; ?>
    </div>
</div>

