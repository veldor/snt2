<?php
/**
 * Created by PhpStorm.
 * User: eldor
 * Date: 13.12.2018
 * Time: 8:54
 */

namespace app\migration;


use yii\db\ActiveRecord;

/**
 * Class Table_additional_cottages
 * @package app\models
 *
 * @property int $masterId [int(10) unsigned]
 * @property int $cottageSquare [int(4) unsigned]
 * @property bool $isPower [tinyint(1)]
 * @property string $powerPayFor [varchar(10)]
 * @property int $currentPowerData [int(10)]
 * @property float $powerDebt [float]
 * @property bool $isMembership [tinyint(1)]
 * @property string $membershipPayFor [varchar(10)]
 * @property bool $isTarget [tinyint(1)]
 * @property float $targetDebt [float]
 * @property string $targetPaysDuty
 * @property bool $individualTariff [tinyint(1)]
 * @property string $individualTariffRates
 * @property string $cottageOwnerPersonals [varchar(200)]  Имя владельца части участка
 * @property string $cottageOwnerPhone [char(18)]  Телефон владельца части участка
 * @property string $cottageOwnerEmail [varchar(200)]  Адрес электронной почты владельца участка
 * @property bool $hasDifferentOwner [tinyint(1)]
 * @property string $cottageOwnerAddress
 * @property float $deposit [float]
 * @property float $singleDebt [float]
 * @property string $cottageRegistrationInformation Данные кадастрового учёта
 * @property string $partialPayedPower Частично оплаченное электричество
 * @property string $partialPayedMembership Частично оплаченный членский взнос
 * @property string $singlePaysDuty Разовые платежи
 * @property string $cottageOwnerDescription Дополнительная информация о владельце
 * @property string $cottageContacterPersonals [varchar(200)]
 * @property string $cottageContacterPhone [char(18)]
 * @property string $cottageContacterEmail [varchar(200)]
 * @property string $passportData
 * @property string $cottageRightsData
 * @property string $bill_payers
 * @property bool $cottageHaveRights [tinyint(1)]
 * @property string $cottageRegisterData
 */
class Table_additional_cottages extends ActiveRecord
{
    public static function tableName()
    {
        return 'additional_cottages';
    }
}