<?php


namespace common\filters;


use Yii;
use yii\base\ActionFilter;

class NoAuthFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        Yii::$app->user->loginRequired = false;
        return true;
    }
}