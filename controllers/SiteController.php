<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\BingTranslator;
use app\models\ContactForm;

class SiteController extends Controller
{

    /**
     * @return array
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return array
     */

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $output = array();

        $twitch = \Vinlock\StreamAPI\Services\Twitch::games();
        $hitBox = \Vinlock\StreamAPI\Services\Hitbox::games();

        $merge = \Vinlock\StreamAPI\Services\Service::merge($hitBox)->cut(15);

        foreach ($merge->get() as $obj){
            $output[] = array(
                'image' => $obj->previewGame(),
                'href' => Url::toRoute('/game/' . rawurlencode($obj->game()))
            );
        }

        return $this->render('index', ['data' => $output]);
    }

    /**
     * @param $request
     * @return string
     */

    public function actionGame($key){

        $output = array();

        //$goodGame = \Vinlock\StreamAPI\Services\Goodgame::game($key);
        $twitch = \Vinlock\StreamAPI\Services\Twitch::game($key);
        $hitBox = \Vinlock\StreamAPI\Services\Hitbox::game($key);

        $merge = \Vinlock\StreamAPI\Services\Service::merge($hitBox, $twitch)->cut(10);

        foreach ($merge->get() as $obj){
            $output[] = array(
                'preview' => $obj->preview('medium'),
                'name' => $obj->username(),
                'href' => Url::toRoute('/channel/' . rawurlencode($obj->username()))
            );
        }

        return $this->render('channels', ['data' => $output]);
    }

    public function actionChannel($key){

        $channels = explode('&', $key);

        $twitch = new \Vinlock\StreamAPI\Services\Twitch($channels);
        $hitBox = new \Vinlock\StreamAPI\Services\Hitbox($channels);

        $merge = \Vinlock\StreamAPI\Services\Service::merge($twitch);

        $merge = $merge->cut();

        $channels = $merge->getArray();

        return $this->render('stream', ['streams' => $channels]);
    }

    /**
     * @return string|\yii\web\Response
     */

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {

        return $this->render('about');
    }
}
