<?php


namespace app\models\database;

use yii\db\ActiveRecord;

/**
 * Class TargetData
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property int $cottage [int(10) unsigned]  Участок
 * @property int $counted_square [int(10) unsigned]  Площадь участка на момент расчёта
 * @property int $from_cottage [int(10) unsigned]  Цена с участка
 * @property int $from_square [int(10) unsigned]  Цена с сотки
 * @property int $amount_from_square [int(10) unsigned]  Начислено по площади
 * @property int $total_amount [int(10) unsigned]  К оплате
 * @property int $payed [int(15) unsigned]  Оплачено
 * @property string $description Назначение платежа
 * @property int $year [int(4) unsigned]  Год
 */

class TargetData extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_target_data';
    }
}