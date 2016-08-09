<?php
namespace app\models;

use yii\web\UrlManager;

class LangUrlManager extends UrlManager
{
    public function createUrl($params)
    {
            //Если не указан параметр языка, то работаем с текущим языком
            $lang = Lang::getCurrent();
        //Получаем сформированный URL(без префикса идентификатора языка)
        $url = parent::createUrl($params);

        //Добавляем к URL префикс - буквенный идентификатор языка
        if($lang->url != Lang::getDefaultLang()->url){
            if( $url == '/' ){
                return '/'. $lang->url . '/';
            }else{
                return '/' . $lang->url . $url;
            }
        }else{
            if( $url == '/' ){
                return '/';
            }else{
                return $url;
            }
        }
    }
}