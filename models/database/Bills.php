<?php


namespace app\models\database;


use app\models\Cottage;
use yii\db\ActiveRecord;

/**
 * Class Bills
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property int $bill_id [int(10) unsigned]  Идентификатор платежа для совместимости
 * @property int $cottage [int(10) unsigned]  Участок
 * @property int $total_amount [int(10) unsigned]  Сумма счёта
 * @property int $payed [int(10) unsigned]  Оплачено по счёту
 * @property int $creation_time [int(15) unsigned]  Дата создания
 * @property int $payment_time [int(15) unsigned]  Дата полной оплаты
 * @property int $deposit_used [int(10) unsigned]  Использованный депозит
 * @property int $deposit_gained [int(10) unsigned]  Излишки оплаты
 * @property int $discount [int(10) unsigned]  Скидка
 * @property string $discount_reason Причина скидки
 * @property bool $is_message_sent [tinyint(1)]  Отправлено сообщение
 * @property bool $is_invoice_printed [tinyint(1)]  Распечатана квитанция
 * @property bool $is_opened [tinyint(1)]  Счёт активен
 */



class Bills extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_bills';
    }

    /**
     * Поиск последнего незакрытого счёта
     * @return Bills
     */
    public static function getLastOpened(Cottage $cottage)
    {
       return self::find()->where(['cottage' => $cottage->id, 'is_opened' => true])->orderBy('bill_id DESC')->one();
    }
}