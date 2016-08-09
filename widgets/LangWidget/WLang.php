<?php
namespace app\widgets\LangWidget;

use app\models\Lang;

class WLang extends \yii\bootstrap\Widget
{
	public $view;
	public $layout;

    public function init(){
        $this->layout = 'view';
    }

    public function run() {
        return $this->render($this->layout, [
            'current' => Lang::getCurrent(),
            'default' => Lang::getDefaultLang(),
            'languages' => Lang::find()->where('lang_id != :current_id', [':current_id' => Lang::getCurrent()->lang_id])->all(),
        ]);
    }
}