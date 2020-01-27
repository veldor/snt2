<?php


namespace app\models\database;


use yii\db\ActiveRecord;

/**
 * Class ElectricityMeters
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property int $owner [int(10) unsigned]  Участок
 * @property string $condition [enum('in_use', 'expired', 'temporary_off')]  Статус
 * @property int $start_data [int(10) unsigned]  Начальные показания
 */

class ElectricityMeters extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_electricity_meters';
    }
}