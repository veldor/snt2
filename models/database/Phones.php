<?php


namespace app\models\database;

use yii\db\ActiveRecord;

/**
 * Class Phones
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property string $phone [char(10)]  Номер
 * @property int $person [int(10) unsigned]  Владелец
 * @property string $description Примечание
 */

class Phones extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_phones';
    }
}