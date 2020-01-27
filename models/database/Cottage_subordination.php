<?php
namespace app\models\database;

use yii\db\ActiveRecord;

/**
 * Class Cottage_subordination
 * @package app\models\database
 *
 * @property int $master_id [int(10) unsigned]  Главный участок
 * @property int $sub_id [int(10) unsigned]  Дополнительный участок
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 */

class Cottage_subordination extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_cottage_subordination';
    }
}