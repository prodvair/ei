<?php

use yii\db\Migration;

/**
 * Class m200415_124609_lookup_fill
 */
class m200415_124609_lookup_fill extends Migration
{
    private const TABLE_LOOKUP   = '{{%lookup}}';
    private const TABLE_PROPERTY = '{{%property}}';
    
    const WHO_AGENT  = 5;
    const AGENT_TYPE = 6;

    public function safeUp()
    {
        $this->insert(static::TABLE_PROPERTY, ['id' => self::WHO_AGENT, 'name' => 'WhoAgent']);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Персона', 'code' => 1, 'property_id' => self::WHO_AGENT, 'position' => 1]);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Организация', 'code' => 2, 'property_id' => self::WHO_AGENT, 'position' => 2]);

        $this->insert(static::TABLE_PROPERTY, ['id' => self::AGENT_TYPE, 'name' => 'AgentType']);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Обычный человек', 'code' => 15, 'property_id' => self::AGENT_TYPE, 'position' => 1]);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Обычная организация', 'code' => 11, 'property_id' => self::AGENT_TYPE, 'position' => 2]);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Предприниматель', 'code' => 13, 'property_id' => self::AGENT_TYPE, 'position' => 3]);
        $this->insert(static::TABLE_LOOKUP, ['name' => 'Dissolved Organization', 'code' => 6, 'property_id' => self::AGENT_TYPE, 'position' => 4]);
    }

    public function safeDown()
    {
        $this->delete(static::TABLE_LOOKUP, 'property_id=' . self::WHO_AGENT);
        $this->delete(static::TABLE_PROPERTY, self::WHO_AGENT);
        $this->delete(static::TABLE_LOOKUP, 'property_id=' . self::AGENT_TYPE);
        $this->delete(static::TABLE_PROPERTY, self::AGENT_TYPE);
    }
}
