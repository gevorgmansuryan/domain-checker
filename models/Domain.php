<?php

namespace app\models;

use app\common\jobs\CheckDomainJob;
use Yii;

/**
 * This is the model class for table "domains".
 *
 * @property int $id
 * @property int|null $file_id
 * @property string $domain
 * @property integer $valid
 * @property string|null $expires
 * @property int|null $status
 *
 * @property DomainFile $file
 */
class Domain extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_PROCESSED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domains';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_PENDING],
            [['file_id', 'status'], 'integer'],
            [['domain'], 'required'],
            [['valid'], 'boolean'],
            [['expires'], 'safe'],
            [['domain'], 'string', 'max' => 255],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => DomainFile::class, 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_id' => 'File ID',
            'domain' => 'Domain',
            'valid' => 'Valid',
            'expires' => 'Expires',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(DomainFile::class, ['id' => 'file_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            Yii::$app->queue->push(new CheckDomainJob([
                'id' => $this->id,
            ]));
        }

        if (!$this->file->getDomains()->where(['status' => self::STATUS_PENDING])->count()) {
            $this->file->status = DomainFile::STATUS_PROCESSED;
            $this->file->save();
        }

        parent::afterSave($insert, $changedAttributes);
    }
}
