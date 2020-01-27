<?php


namespace app\models\database;


use yii\db\ActiveRecord;

/**
 * Class Transactions
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property int $cottageNumber [int(10) unsigned]
 * @property int $billId [int(10) unsigned]
 * @property int $transactionDate [int(20) unsigned]
 * @property string $transactionType [enum('cash', 'no-cash')]
 * @property int $payed [int(10) unsigned]
 * @property string $transactionReason
 * @property int $usedDeposit [int(11)]
 * @property int $gainedDeposit [int(11)]
 * @property bool $partial [tinyint(1)]
 * @property int $payDate [int(10) unsigned]
 * @property int $bankDate [int(10) unsigned]
 */



class Transactions extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_transactions';
    }
}