<?php

namespace app\models;



final class Language{

    private $original;
    private $translation;
    private $currentLang;
    private $defaultLang;

    public function __construct()
    {
        $this->original = \Yii::$app->cache->get('original');
        $this->translation = \Yii::$app->cache->get('translation');
        $this->currentLang = Lang::getCurrent()->url;
        $this->defaultLang = Lang::getDefaultLang()->url;
    }

    public function translate($word = null){

        $result = null;

        if($word && $this->currentLang !== $this->defaultLang){

            if(isset($this->translation[$this->currentLang]) && isset($this->original[$this->currentLang])){
                $key = array_search($word, $this->original[$this->currentLang]);
                if($key !== false){
                    $result = $this->translation[$this->currentLang][$key];
                } else{
                    $result = $this->translator($word);
                    $this->translation[$this->currentLang][] = $result;
                    $this->original[$this->currentLang][] = $word;
                }
            } else{
                $result = $this->translator($word);
                $this->translation[$this->currentLang][] = $result;
                $this->original[$this->currentLang][] = $word;
            }

            $this->setCache($this->original, $this->translation);
        }else{
            $result = $word;
        }

        return $result;
    }

    private function translator($word){

        $translator = BingTranslator::getInstance();

        $translate = $translator->translate($word, $this->defaultLang, $this->currentLang);

        return simplexml_load_string($translate)->__toString();
    }

    private function setCache(array $original, array $translate){

        \Yii::$app->cache->set('original', $original);
        \Yii::$app->cache->set('translation', $translate);
    }
}