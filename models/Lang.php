<?php
namespace app\models;


use Yii;
use yii\db\ActiveRecord;

class Lang extends ActiveRecord{

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['update_time'],
                ],
            ],
        ];
    }

    public static function tableName()
    {
        return 'idc_langs';
    }

    //Переменная, для хранения текущего объекта языка
    static $current = null;

//Получение текущего объекта языка
    static function getCurrent()
    {
        if( self::$current === null ){
            self::$current = self::getDefaultLang();
        }
        return self::$current;
    }

//Установка текущего объекта языка и локаль пользователя
    static function setCurrent($url = null)
    {
        $language = self::getLangByUrl($url);
        self::$current = ($language === null) ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$current->url;
        Yii::$app->formatter->locale = self::$current->local;

        if (isset(Yii::$app->request->cookies['lang']))
        {
            Yii::$app->response->cookies->remove('lang');
        }

        if(self::$current->url !== self::getDefaultLang()->url){

            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'lang',
                'value' => self::$current->url,
                'expire' => time() + (60*60*24),
            ]));
        }
    }

//Получения объекта языка по умолчанию
    static function getDefaultLang()
    {
        return self::find()->where('default_val = :default', [':default' => 1])->one();
    }

//Получения объекта языка по буквенному идентификатору
    static function getLangByUrl($url = null)
    {
        if ($url === null) {
            return null;
        } else {
            $language = self::find()->where('url = :url', [':url' => $url])->one();
            if ( $language === null ) {
                return null;
            }else{
                return $language;
            }
        }
    }
}