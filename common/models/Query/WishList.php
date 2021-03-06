<?php
namespace common\models\Query;

use Yii;
use yii\db\ActiveRecord;
use common\models\Query\Lot\Lots;
use common\models\User;

/**
 * WishList model
 * 
 * Таблица связей Юзеров и Лотов, для пометки лотов, которые понравились Юзеру.
 * Юзер может получать уведомления, если выберет их в Личном Кабинете.
 */

class WishList extends ActiveRecord
{
    /**
     * The followings are the available columns in table 'site.{{wishList}}':
     * @property integer $id
     * @property integer $userId
     * @property integer $lotId
     * @property string  $type тип имущества
     * @property integer $createdAt
     */

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'site.{{wishList}}';
    }
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['userId', 'lotId', 'type'], 'required'],
            ['type', 'string'],
            ['type', 'in', 'range' => self::getTypes()],
            ['createdAt', 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'Пользователь',
            'lotId'  => 'Лот',
            'type'   => 'Тип',
        ];
    }

    /**
     * Get lot types.
     * @return array
     */
    public static function getTypes() {
        return [
            'arrest',
            'bunkrupt',
            'zalog',
            'municipal',
        ];
    }
    
    /**
     * @return common\models\User
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    public function getLots()
    {
        return $this->hasOne(Lots::className(), ['id' => 'lotId'])->alias('lots');
    }
}
