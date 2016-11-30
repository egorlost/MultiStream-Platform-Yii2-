<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
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

        //$json = json_decode(\Requests::get('https://api.twitch.tv/kraken/games/top')->body, TRUE);

        $twitch = \Vinlock\StreamAPI\Services\Twitch::games();

        $merge = \Vinlock\StreamAPI\Services\Service::merge($twitch);

        $merge = $merge->cut(2);

        $channels = $twitch->getArray();

        foreach ($channels as $channel){
            $output[] = array(
                'image' => $channel['game']['box']['large'],
                'href' => '/game/' . rawurlencode($channel['game']['name'])
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

        $twitch = \Vinlock\StreamAPI\Services\Twitch::game($key);
        $hitBox = \Vinlock\StreamAPI\Services\Hitbox::game($key);

        $merge = \Vinlock\StreamAPI\Services\Service::merge($twitch, $hitBox);

        $merge = $merge->cut();

        $streams = $merge->getArray();

        foreach ($streams as $stream){
            $output[] = array(
                'preview' => $stream['preview']['medium'],
                'name' => $stream['channel']['name'],
                'href' => '/channel/' . rawurlencode($stream['channel']['name'])
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
