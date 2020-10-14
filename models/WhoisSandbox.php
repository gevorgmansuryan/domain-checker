<?php


namespace app\models;


use yii\base\Model;

class WhoisSandbox extends Model
{
    public $domain;
    public $available;
    public $expires;
    public $payload;

    public function rules()
    {
        return [
            ['domain', 'trim'],
            ['domain', 'required'],
        ];
    }
}