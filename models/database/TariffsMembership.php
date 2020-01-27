<?php


namespace app\models\database;

use yii\db\ActiveRecord;

/**
 * Class TariffsMembership
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property string $quarter [char(6)]  Квартал
 * @property int $from_cottage [int(10) unsigned]  Цена с участка
 * @property int $from_square [int(10) unsigned]  Цена с сотки
 * @property int $timestamp [int(15) unsigned]  Временная метка для поиска
 */

class TariffsMembership extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_tariffs_membership';
    }
}