<?php
namespace common\models\db;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\interfaces\ProfileInterface;

/**
 * Profile model
 * Индивидуальные данные.
 *
 * @property integer $id
 * @property integer $model
 * @property integer $parent_id
 * @property string  $inn
 * @property integer $gender
 * @property integer $birthday
 * @property string  $phone
 * @property string  $first_name
 * @property string  $last_name
 * @property string  $middle_name
 * @property integer $created_at
 * @property integer $updated_at
 */
class Profile extends ActiveRecord implements ProfileInterface
{
    const GENDER_MALE     = 1;
    const GENDER_FEMALE   = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model', 'parent_id', 'first_name'], 'required'],
            ['inn', 'match', 'pattern' => '/\d{12}/'],
            [['gender', 'birthday'], 'integer'],
            ['gender', 'in', 'range' => self::getGenderVariants()],
            ['gender', 'default', 'value' => null],
            ['phone', 'match', 'pattern' => '/^\+7 \d\d\d-\d\d\d-\d\d-\d\d$/',
                'message' => 'Номер должен состоять ровно из 10 цифр.'],
            [['first_name', 'last_name', 'middle_name', 'birth_place'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'inn'         => Yii::t('app', 'INN'),
            'gender'      => Yii::t('app', 'Gender'),
            'birthday'    => Yii::t('app', 'Birthday'),
            'first_name'  => Yii::t('app', 'First name'),
            'last_name'   => Yii::t('app', 'Last name'),
            'middle_name' => Yii::t('app', 'Middle name'),
            'created_at'  => Yii::t('app', 'Created'),
            'updated_at'  => Yii::t('app', 'Modified'),
        ];
    }

    /**
     * Get gender variants
     * @return array
     */
    public static function getGenderVariants() {
        return [
            self::GENDER_MALE,
            self::GENDER_FEMALE, 
        ];
    }

    /**
     * Get full name
     * @return string
     */
    public static function getFullName() {
        return
            ($this->last_name ? $this->last_name . ' ' : '') .
            $this->first_name . 
            ($this->middle_name ? ' ' . $this->middle_name : '');
    }
}
