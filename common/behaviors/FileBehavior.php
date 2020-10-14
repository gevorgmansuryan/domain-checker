<?php


namespace app\common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 *  @property ActiveRecord $owner
 */
class FileBehavior extends Behavior
{
    public $attributes = [];

    public $deleteOldFileOnUpdate = true;

    public $basePath;

    public $baseUrl;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'upload',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'upload',
            ActiveRecord::EVENT_AFTER_DELETE => 'delete',
        ];
    }

    public function upload()
    {
        foreach ($this->attributes as $attribute) {
            $value = $this->owner->getAttribute($attribute);

            if ($value instanceof UploadedFile) {
                $newValue = sprintf(
                    '%s_%s.%s', $value->baseName,
                    Yii::$app->security->generateRandomString(6),
                    $value->extension,
                );

                $value->saveAs($this->getPath($newValue));

                $this->owner->setAttribute($attribute, $newValue);
            }

            if ($this->deleteOldFileOnUpdate && !$this->owner->isNewRecord && $this->owner->isAttributeChanged($attribute)) {
                $this->deleteFile($this->owner->getOldAttribute($attribute));
            }
        }
    }

    private function deleteFile($fileName)
    {
        if ($fileName) {
            $path = $this->getPath($fileName);
            if (file_exists($path)) {
                FileHelper::unlink($path);
            }
        }
    }

    public function delete()
    {
        foreach ($this->attributes as $attribute) {
            $this->deleteFile($this->owner->getAttribute($attribute));
        }
    }

    public function fileUrl($attribute)
    {
        if (in_array($attribute, $this->owner->attributes())) {
            $value = $this->owner->getAttribute($attribute);

            return $this->getUrl($value);
        }

        return null;
    }

    public function filePath($attribute)
    {
        if (in_array($attribute, $this->owner->attributes())) {
            $value = $this->owner->getAttribute($attribute);

            return $this->getPath($value);
        }

        return null;
    }

    private function getPath($value)
    {
        return Yii::getAlias("{$this->basePath}/$value");
    }

    private function getUrl($value)
    {
        return Yii::getAlias("{$this->baseUrl}/$value");
    }
}