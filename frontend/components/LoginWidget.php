<?php
namespace frontend\components;

use Yii;
use yii\base\Widget;
use common\models\LoginForm;

class LoginWidget extends Widget
{
    public function run(){
        if (!Yii::$app->user->isGuest) {
            return false;
        }
        $model = new LoginForm();

        return $this->render('login',[
            'model' => $model,
        ]);
    }
}