<?php


namespace app\models\database;


use yii\db\ActiveRecord;

/**
 * Class BillEntities
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property string $type [enum('power', 'membership', 'target', 'simple', 'fine')]
 * @property int $cottage [int(10) unsigned]
 * @property int $bill [int(10) unsigned]
 * @property int $entity_id [int(10) unsigned]
 * @property int $amount [int(10) unsigned]
 */

class BillEntities extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_pay_entities';
    }
}