<?php

namespace app\models;

use yii\base\Model;

class Captcha extends Model
{
    public $verifyCode;
    public function rules()
    {
        return [
            ['verifyCode', 'captcha'],
        ];
    }
}
?>