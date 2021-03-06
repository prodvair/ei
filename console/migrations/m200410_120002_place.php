<?php

use yii\db\Migration;

/**
 * Class m200410_120002_place
 * Адрес частного лица, организации, объекта
 * 
 */
class m200410_120002_place extends Migration
{
    const TABLE = '{{%place}}';

    public function up()
    {
        $this->createTable(self::TABLE, [
            'id'         => $this->bigPrimaryKey(),
            'model'      => $this->smallInteger()->notNull(),
            'parent_id'  => $this->bigInteger()->notNull(),
            
            'city'       => $this->string()->notNull(),
            'region'     => $this->integer()->notNull(),
            'district'   => $this->string()->notNull(),
            'address'    => $this->string()->notNull(),
            'geo_lat'    => $this->string()->notNull(),
            'geo_lon'    => $this->string()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        $this->createIndex('idx-model-parent_id', self::TABLE, ['model', 'parent_id'], true);

		$this->addCommentOnColumn(self::TABLE, 'model', 'Код модели, например User::INT_CODE');
		$this->addCommentOnColumn(self::TABLE, 'parent_id', 'ID в соответствующей модели, например в User, Manager');
        
		$this->addCommentOnColumn(self::TABLE, 'city', 'Город');
		$this->addCommentOnColumn(self::TABLE, 'region', 'Код региона');
		$this->addCommentOnColumn(self::TABLE, 'district', 'Округ');
		$this->addCommentOnColumn(self::TABLE, 'address', 'Полный адрес');
		$this->addCommentOnColumn(self::TABLE, 'geo_lat', 'Широта');
		$this->addCommentOnColumn(self::TABLE, 'geo_lon', 'Долгота');
    }

    public function down()
    {
        $this->dropTable(self::TABLE);
    }
}
