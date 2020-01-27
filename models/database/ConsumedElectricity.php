<?php


namespace app\models\database;


use yii\db\ActiveRecord;

/**
 * Class ConsumedElectricity
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property string $month [char(7)]  Месяц
 * @property int $owner [int(10) unsigned]  Участок
 * @property int $meter [int(10) unsigned]  Счётчик
 * @property int $old_data [int(10) unsigned]  Показания на начало периода
 * @property int $new_data [int(10) unsigned]  Показания на конец периода
 * @property int $consumption [int(10) unsigned]  Потрачено электроэнергии
 * @property int $limit [int(10) unsigned]  Льготный лимит
 * @property int $in_limit_consumption [int(10) unsigned]  Потрачено внутри лимита
 * @property int $over_limit_consumption [int(10) unsigned]  Потрачено вне лимита
 * @property int $in_limit_cost [int(10) unsigned]  Льготная стоимость
 * @property int $over_limit_cost [int(10) unsigned]  Обычная стоимость
 * @property int $total_cost [int(10) unsigned]  Общая стоимость
 * @property int $completion_date [int(15) unsigned]  Дата заполнения показаний
 * @property int $timestamp [int(15) unsigned]  Метка времени для поиска
 * @property int $payed [int(15) unsigned]  Оплаченная сумма
 */

class ConsumedElectricity extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_consumed_electricity';
    }
}