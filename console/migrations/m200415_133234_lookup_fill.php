<?php

use yii\db\Migration;

/**
 * Class m200415_133234_lookup_fill
 */
class m200415_133234_lookup_fill extends Migration
{
    private const TABLE_LOOKUP   = '{{%lookup}}';
    private const TABLE_PROPERTY = '{{%property}}';
    
    const TORG_PROPERTY = 7;
    const TORG_OFFER    = 8;

    public function safeUp()
    {
        $this->insert(static::TABLE_PROPERTY, ['id' => self::TORG_PROPERTY, 'name' => 'TorgProperty']);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Банкротное',    'code' => 1, 'property_id' => self::TORG_PROPERTY, 'position' => 1]);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Залоговое',     'code' => 2, 'property_id' => self::TORG_PROPERTY, 'position' => 2]);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Арестованное',  'code' => 3, 'property_id' => self::TORG_PROPERTY, 'position' => 3]);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Муниципальное', 'code' => 4, 'property_id' => self::TORG_PROPERTY, 'position' => 4]);

        $this->insert(static::TABLE_PROPERTY, ['id' => self::TORG_OFFER, 'name' => 'TorgAuction']);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Публичное',        'code' => 1, 'property_id' => self::TORG_OFFER, 'position' => 1]);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Аукцион',          'code' => 2, 'property_id' => self::TORG_OFFER, 'position' => 2]);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Аукцион открытый', 'code' => 3, 'property_id' => self::TORG_OFFER, 'position' => 3]);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Конкурс',          'code' => 4, 'property_id' => self::TORG_OFFER, 'position' => 4]);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Конкурс открытый', 'code' => 5, 'property_id' => self::TORG_OFFER, 'position' => 5]);
    }

    public function safeDown()
    {
        $this->delete(static::TABLE_LOOKUP, 'property_id=' . self::TORG_PROPERTY);
        $this->delete(static::TABLE_PROPERTY, self::TORG_PROPERTY);
        $this->delete(static::TABLE_LOOKUP, 'property_id=' . self::TORG_OFFER);
        $this->delete(static::TABLE_PROPERTY, self::TORG_OFFER);
    }
}
