<?php
use yii\helpers\Html;

?>
    <li class="dropdown-header">Текущий язык</li>
    <li><span><?= $current->name;?></span></li>
    <li class="dropdown-header">Сменить язык</li>
    <?php foreach ($languages as $lang):?>
    <li><a href="<?='/' . $lang->url . '/' . Yii::$app->request->pathInfo ?>" ><?=$lang->name?></a></li>
    <?php endforeach;?>