<?php


namespace app\common\services\whois;


use yii\base\BaseObject;

/**
 * @property-read string $domain
 */
class Request extends BaseObject
{
    public $sld;
    public $tld;

    public function getDomain()
    {
        return $this->sld . '.' . $this->tld;
    }
}