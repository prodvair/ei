<?php
namespace backend\models;

use Yii;
use yii\base\Model;

class Search extends Model
{
    public $search;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['search'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'search' => 'Поиск',
        ];
    }

}
