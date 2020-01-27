<?php


namespace app\models\database;

use yii\db\ActiveRecord;

/**
 * Class SingleData
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property int $timestamp [int(15) unsigned]  Временная метка
 * @property int $cottage [int(10) unsigned]  Участок
 * @property int $total_amount [int(10) unsigned]  К оплате
 * @property int $payed [int(15) unsigned]  Оплачено
 * @property string $description Назначение платежа
 */

class SingleData extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_single_data';
    }
}