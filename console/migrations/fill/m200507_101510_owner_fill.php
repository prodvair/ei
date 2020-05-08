<?php

use yii\db\Migration;
use common\models\db\Etp;
use common\models\db\Organization;
use common\models\db\Place;
use console\traits\Keeper;

/**
 * Class m200507_101510_owner_fill
 */
class m200507_101510_owner_fill extends Migration
{
    use Keeper;
    
    const TABLE = '{{%owner}}';

    public function safeUp()
    {
        // получение собственников лотов из существующего справочника
        $db = \Yii::$app->db;
        $select = $db->createCommand(
            'SELECT * FROM "eiLot".owners ORDER BY "owners".id'
        );
        $rows = $select->queryAll();
        
        $owners = [];
        $organizations = [];
        $places = [];
        
        // добавление собственников
        foreach($rows as $row) {

            $owner_id   = $row['id'];
            $created_at = strtotime($row['createdAt']);
            $updated_at = strtotime($row['updatedAt']);
            
            // Owner
            $o = [
                'id' = $owner_id;
                'slug' = $row['linkEi'];
                'description' = $row['description'];
            ];
            $owner = new Owner($o);
            
            if ($this->validateAndKeep($owner, $owners, $o)) {
                
                // Organization
                $o = [
                    'model'      => Organization::TYPE_OWNER,
                    'parent_id'  => $owner_id,
                    'activity'   => Organization::ACTIVITY_SIMPLE,
                    'title'      => $row['title'],
                    'full_title' => '',
                    'inn'        => null,
                    'ogrn'       => null,
                    'reg_number' => null,
                    'email'      => $row['email'],
                    'phone'      => $row['phone'],
                    'website'    => $row['url'],
                    'status'     => Organization::STATUS_CHECKED,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ];
                $organization = new Organization($o);
                
                $this->validateAndKeep($organization, $organizations, $o);
                
                $city     = isset($row['city']) && $row['city'] ? $row['city'] : '';
                $district = isset($row['district']) && $row['district'] ? $row['district'] : '';
                $address  = isset($row['address']) && $row['address'] ? $row['address'] : '-';
                
                // Place
                $p = [
                    'model'      => Organization::TYPE_OWNER,
                    'parent_id'  => $etp_id,
                    'city'       => $city,
                    'region_id'  => $row['regionId'],
                    'district'   => $district,
                    'address'    => $address,
                    'geo_lat'    => null,
                    'geo_lon'    => null,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ];
                $place = new Place($p);
                
                $this->validateAndKeep($place, $places, $p);
            }
        }
        $this->batchInsert(self::TABLE, ['id', 'slug', 'description', 'created_at', 'updated_at'], $owners);
        $this->batchInsert('{{%organization}}', ['model', 'parent_id', 'activity', 'title', 'full_title', 'inn', 'ogrn', 'reg_number', 'email', 'phone', 'website', 'status', 'created_at', 'updated_at'], $organizations);
        $this->batchInsert('{{%place}}', ['model', 'parent_id', 'city', 'region_id', 'district', 'address', 'geo_lat', 'geo_lon', 'created_at', 'updated_at'], $places);
    }

    public function safeDown()
    {
        $db = \Yii::$app->db;
        $db->createCommand('DELETE FROM {{%place}} WHERE model=' . Organization::TYPE_OWNER)->execute();
        $db->createCommand('DELETE FROM {{%organization}} WHERE model=' . Organization::TYPE_OWNER)->execute();
        $db->createCommand('TRUNCATE TABLE '. self::TABLE .' CASCADE')->execute();
    }
}
