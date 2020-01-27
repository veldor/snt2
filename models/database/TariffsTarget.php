<?php


namespace app\models\database;

use yii\db\ActiveRecord;

/**
 * Class TariffsTarget
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property int $year [int(4) unsigned]  Год
 * @property int $from_cottage [int(10) unsigned]  Цена с участка
 * @property int $from_square [int(10) unsigned]  Цена с сотки
 * @property int $pay_up [int(15) unsigned]  Срок оплаты
 * @property string $description Назначение платежа
 */

class TariffsTarget extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_tariffs_target';
    }
}