<?php


namespace app\models\database;


use yii\db\ActiveRecord;

/**
 * Class PayedEntities
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property string $type [enum('power', 'membership', 'target', 'simple', 'fine')]  Тип оплаты
 * @property int $cottage [int(10) unsigned]  Участок
 * @property int $bill [int(10) unsigned]  Счёт
 * @property int $entity_id [int(10) unsigned]  Идентификатор периода
 * @property int $amount [int(10) unsigned]  Сумма оплаты
 * @property int $transaction [int(10) unsigned]  Номер транзакции
 * @property int $pay_time [int(15)]  Время оплаты
 */

class PayedEntities extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_payed_entities';
    }
}