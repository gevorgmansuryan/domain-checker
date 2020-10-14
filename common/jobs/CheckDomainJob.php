<?php

namespace app\common\jobs;

use app\common\services\whois\Whois;
use app\models\Domain;
use yii\base\BaseObject;
use yii\helpers\Console;
use yii\queue\JobInterface;

class CheckDomainJob extends BaseObject implements JobInterface
{
    public $id;

    public function execute($queue)
    {
        try {
            $domain = Domain::findOne(['id' => $this->id, 'status' => Domain::STATUS_PENDING]);

            if ($domain) {
                Console::output("Checking domain: {$domain->domain}");

                $domain->status = Domain::STATUS_PROCESSING;
                $domain->save();


                if ($response = Whois::instance()->check($domain->domain)) {
                    $domain->expires = $response->expires;
                    $domain->valid = !$response->available;
                } else {
                    $domain->valid = false;
                }

                $domain->status = Domain::STATUS_PROCESSED;
                $domain->save();

                Console::output('-- ' . ($domain->valid ? ('valid, expires:' . $domain->expires) : 'invalid'));
            }
        } catch (\Throwable $e) {
            Console::error($e->getMessage());
        }
    }
}