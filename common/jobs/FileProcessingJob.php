<?php

namespace app\common\jobs;

use app\common\services\whois\Whois;
use app\models\Domain;
use app\models\DomainFile;
use Gevman\CsvLite\Csv;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\queue\JobInterface;

class FileProcessingJob extends BaseObject implements JobInterface
{
    public $id;

    public function execute($queue)
    {
        try {
        $file = DomainFile::findOne(['id' => $this->id, 'status' => DomainFile::STATUS_PENDING]);
            if ($file) {
                Console::output("Checking csv: {$file->title}");
                $csv = new Csv();
                $csv->open($file->filePath('file_name'));
                $data = $csv->read();
                $file->status = $file::STATUS_PROCESSING;

                $added = 0;

                foreach ($data as $row) {
                    $parsed = Whois::instance()->parseUrl(ArrayHelper::getValue($row, 0));

                    $domain = new Domain();
                    $domain->file_id = $file->id;
                    $domain->domain = $parsed->domain;
                    if ($domain->save()) {
                        $added++;
                    }
                }

                if (empty($data) || !$added) {
                    $file->status = $file::STATUS_INVALID;
                    Console::output('File is invalid or empty');
                } else {
                    Console::output("Added to queue {$added} domains.");
                }

                $file->save();

            }
        } catch (\Throwable $e) {
            Console::error($e->getMessage());
        }
    }
}