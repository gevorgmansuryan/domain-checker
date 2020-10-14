<?php

namespace app\models;

use app\common\behaviors\FileBehavior;
use app\common\jobs\FileProcessingJob;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "domain_files".
 *
 * @property int $id
 * @property string $title
 * @property string $file_name
 * @property int $status
 *
 * @property Domain[] $domains
 * @method string filePath($attribute)
 */
class DomainFile extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_PROCESSED = 2;
    const STATUS_INVALID = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domain_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_PENDING],
            [['title', 'status', 'file_name'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 255],
            ['file_name', 'file', 'extensions' => ['csv'], 'checkExtensionByMimeType' => false],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => FileBehavior::class,
                'attributes' => ['file_name'],
                'basePath' => '@webroot/uploads',
                'baseUrl' => '@web/uploads',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'status' => 'Status',
            'progress' => 'Progress',
            'file_name' => 'CSV File',
        ];
    }

    /**
     * Gets query for [[Domains]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDomains()
    {
        return $this->hasMany(Domain::class, ['file_id' => 'id']);
    }

    public function beforeValidate()
    {
        if ($this->file_name instanceof UploadedFile) {
            $this->title = $this->file_name->baseName;
        }

        return parent::beforeValidate();
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            Yii::$app->queue->push(new FileProcessingJob([
                'id' => $this->id,
            ]));
        }

        parent::afterSave($insert, $changedAttributes);
    }
}
