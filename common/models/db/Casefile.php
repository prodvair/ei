<?php
namespace common\models\db;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use sergmoro1\uploader\behaviors\HaveFileBehavior;

/**
 * Casefile model
 * Дело по банкротному Торгу.
 *
 * @var integer $id
 * @var string  $reg_number
 * @var integer $year
 * @var string  $judje
 * @var integer $created_at
 * @var integer $updated_at
 * 
 * @property sergmoro1\uploader\models\OneFile[] $files
 */
class Casefile extends ActiveRecord
{
    // внутренний код модели используемый в составном ключе
    const INT_CODE = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%casefile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
			// [
			// 	'class' => HaveFileBehavior::className(),
			// 	'file_path' => '/case/',
			// ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reg_number', 'year'], 'required'],
            [['reg_number', 'judge'], 'string', 'max' => 255],
            ['year', 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reg_number' => Yii::t('app', 'Reg number'),
            'year'       => Yii::t('app', 'Year'),
            'judge'      => Yii::t('app', 'Judge'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Modified'),
        ];
    }
}
