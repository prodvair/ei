<?php
namespace common\models\Query;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

class Settings extends ActiveRecord
{
    public static function tableName()
    {
        return 'site.{{settings}}';
    }
    public static function getDb()
    {
        return Yii::$app->get('db');
    }
}