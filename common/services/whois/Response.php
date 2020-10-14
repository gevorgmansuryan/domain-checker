<?php


namespace app\common\services\whois;


use yii\base\BaseObject;

class Response extends BaseObject
{
    public $available;
    public $expires;
    public $payload;
}