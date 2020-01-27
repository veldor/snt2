<?php


namespace app\models\database;

use yii\db\ActiveRecord;

/**
 * Class TariffsPower
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property string $month [char(7)]  Месяц
 * @property int $limit [int(10) unsigned]  Льготный лимит
 * @property int $preferential_price [int(10) unsigned]  Льготная цена
 * @property int $normal_price [int(10) unsigned]  Обычная цена
 * @property int $timestamp [int(15) unsigned]  Временная метка для поиска
 */

class TariffsPower extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_tariffs_power';
    }
}