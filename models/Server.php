<?php

namespace app\models;

use Yii;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "servers".
 *
 * @property int $id
 * @property string|null $tld
 * @property string|null $whois
 * @property int|null $is_http
 * @property int|null $domain_only
 * @property string|null $available_string
 * @property string|null $expire_string
 * @property string|null $server_response
 * @property int|null $status
 */
class Server extends \yii\db\ActiveRecord
{
    const STATUS_NOT_LEARNED = 0;
    const STATUS_SERVER_NOT_WORKING = 1;
    const STATUS_CAN_NOT_PARSE_AVAILABLE = 2;
    const STATUS_CAN_NOT_PARSE_EXPIRED = 3;
    const STATUS_EXPIRED_MAY_NOT_CORRECT = 4;
    const STATUS_LEARNED = 5;

    const LEARNING_STATUS_LABELS = [
        self::STATUS_NOT_LEARNED => 'Not Learned',
        self::STATUS_SERVER_NOT_WORKING => 'not working/blocked',
        self::STATUS_CAN_NOT_PARSE_AVAILABLE => 'Can not parse `available` string',
        self::STATUS_CAN_NOT_PARSE_EXPIRED => 'Can not parse `expired` string',
        self::STATUS_EXPIRED_MAY_NOT_CORRECT => 'Parsing `expired` string may not correct',
        self::STATUS_LEARNED => 'Learned',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_http', 'domain_only', 'status'], 'integer'],
            [['server_response'], 'string'],
            [['tld', 'whois', 'available_string', 'expire_string'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tld' => 'Tld',
            'whois' => 'Whois',
            'is_http' => 'Is Http',
            'domain_only' => 'Domain Only',
            'available_string' => 'Available String',
            'expire_string' => 'Expire String',
            'server_response' => 'Server Response',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        $this->is_http = StringHelper::startsWith($this->whois, 'http') ? 1 : 0;

        return parent::beforeSave($insert);
    }
}
