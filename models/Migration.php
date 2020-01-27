<?php


namespace app\models;


use app\migration\DOMHandler;
use app\migration\Table_cottages;
use app\migration\Table_additional_cottages;
use app\migration\Table_payed_fines;
use app\migration\Table_payed_membership;
use app\migration\Table_payed_power;
use app\migration\Table_payed_single;
use app\migration\Table_payed_target;
use app\migration\Table_payment_bills;
use app\migration\Table_power_months;
use app\migration\Table_tariffs_membership;
use app\migration\Table_tariffs_power;
use app\migration\Table_tariffs_target;
use app\migration\Table_transactions;
use app\models\database\BillEntities;
use app\models\database\Bills;
use app\models\database\ConsumedElectricity;
use app\models\database\Cottage_subordination;
use app\models\database\ElectricityMeters;
use app\models\database\Emails;
use app\models\database\MembershipData;
use app\models\database\PayedEntities;
use app\models\database\Person;
use app\models\database\PersonRoles;
use app\models\database\Phones;
use app\models\database\SingleData;
use app\models\database\TargetData;
use app\models\database\TariffsMembership;
use app\models\database\TariffsPower;
use app\models\database\TariffsTarget;
use app\models\database\Transactions;
use app\models\exceptions\CriticalException;
use Yii;
use yii\base\Model;
use yii\db\Exception;

class Migration extends Model
{
    /**
     * @throws exceptions\CriticalException
     */
    public static function doMigrate(): void
    {
        $snt = SNT::getInstance();
        $db = Yii::$app->getDb();
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_cottages`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        $ownerRole = PersonRoles::findOne(['role' => 'Владелец']);
        if (empty($ownerRole)) {
            throw new CriticalException('Не найдена роль владельца');
        }
        $contactRole = PersonRoles::findOne(['role' => 'Контакт']);
        if (empty($contactRole)) {
            throw new CriticalException('Не найдена роль');
        }
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_persons`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_emails`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_phones`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }


        // миграция тарифов
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_tariffs_power`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        // миграция тарифов
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_tariffs_target`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        // миграция тарифов
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_tariffs_membership`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_electricity_meters`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_consumed_electricity`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_membership_data`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_target_data`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_single_data`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_bills`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_pay_entities`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_payed_entities`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_transactions`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        $oldMembershipTariffs = Table_tariffs_membership::find()->all();
        if (!empty($oldMembershipTariffs)) {
            foreach ($oldMembershipTariffs as $oldMembershipTariff) {
                $newTariff = new TariffsMembership();
                $newTariff->quarter = $oldMembershipTariff->quarter;
                $newTariff->from_cottage = self::migrateRubles($oldMembershipTariff->fixed_part);
                $newTariff->from_square = self::migrateRubles($oldMembershipTariff->changed_part);
                $newTariff->timestamp = $oldMembershipTariff->search_timestamp;
                $newTariff->save();
            }
        }
        $oldTargetTariffs = Table_tariffs_target::find()->all();
        if (!empty($oldTargetTariffs)) {
            foreach ($oldTargetTariffs as $oldTargetTariff) {
                $newTariff = new TariffsTarget();
                $newTariff->year = $oldTargetTariff->year;
                $newTariff->from_cottage = self::migrateRubles($oldTargetTariff->fixed_part);
                $newTariff->from_square = self::migrateRubles($oldTargetTariff->float_part);
                $newTariff->pay_up = $oldTargetTariff->payUpTime;
                $newTariff->description = $oldTargetTariff->description;
                $newTariff->save();
            }
        }
        $oldPowerTariffs = Table_tariffs_power::find()->all();
        if (!empty($oldPowerTariffs)) {
            foreach ($oldPowerTariffs as $oldPowerTariff) {
                $newTariff = new TariffsPower();
                $newTariff->month = $oldPowerTariff->targetMonth;
                $newTariff->limit = $oldPowerTariff->powerLimit;
                $newTariff->preferential_price = self::migrateRubles($oldPowerTariff->powerCost);
                $newTariff->normal_price = self::migrateRubles($oldPowerTariff->powerOvercost);
                $newTariff->timestamp = $oldPowerTariff->searchTimestamp;
                $newTariff->save();
            }
        }

        // перенесу данные об участке
        $oldCottages = Table_cottages::find()->all();
        foreach ($oldCottages as $oldCottage) {
            $newCottage = new Cottage();
            $newCottage->number = $oldCottage->cottageNumber;
            $newCottage->square = $oldCottage->cottageSquare;
            $newCottage->deposit = self::migrateRubles($oldCottage->deposit);
            $newCottage->pay_membership = true;
            $newCottage->pay_target = true;
            $newCottage->save();

            // обработаю владельцев
            $person = new Person();
            $person->name = $oldCottage->cottageOwnerPersonals;
            $person->address = $oldCottage->cottageOwnerAddress;
            $person->passportData = $oldCottage->passportData;
            $person->description = $oldCottage->cottageOwnerDescription;
            $person->role = $ownerRole->id;
            $person->cottage = $newCottage->id;
            $person->save();
            if (!empty($oldCottage->cottageOwnerEmail)) {
                $mail = new Emails();
                $mail->address = $oldCottage->cottageOwnerEmail;
                $mail->person = $person->id;
                $mail->save();
            }
            if (!empty($oldCottage->cottageOwnerPhone)) {
                $mail = new Phones();
                $mail->phone = preg_replace('/\D/', '', $oldCottage->cottageOwnerPhone);
                $mail->person = $person->id;
                $mail->save();
            }
            if (!empty($oldCottage->cottageContacterPersonals)) {
                $contact = new Person();
                $contact->role = $contactRole->id;
                $contact->cottage = $newCottage->id;
                $contact->name = $oldCottage->cottageContacterPersonals;
                $contact->save();

                if (!empty($oldCottage->cottageContacterEmail)) {
                    $mail = new Emails();
                    $mail->address = $oldCottage->cottageContacterEmail;
                    $mail->person = $contact->id;
                    $mail->save();
                }
                if (!empty($oldCottage->cottageContacterPhone)) {
                    $mail = new Phones();
                    $mail->phone = preg_replace('/\D/', '', $oldCottage->cottageContacterPhone);
                    $mail->person = $contact->id;
                    $mail->save();
                }
            }

            // перенесу данные о потраченной электроэнергии
            $powerData = Table_power_months::find()->where(['cottageNumber' => $oldCottage->cottageNumber])->all();
            if (!empty($powerData)) {
                $previousData = null;
                $currentMeter = null;
                foreach ($powerData as $powerDatum) {
                    if ($previousData === null) {
                        $meter = new ElectricityMeters();
                        $meter->condition = 'in_use';
                        $meter->owner = $newCottage->id;
                        $meter->start_data = $powerDatum->oldPowerData;
                        $meter->save();
                        $currentMeter = $meter;
                    } else {
                        // проверю на замену счётика
                        if ($previousData > $powerDatum->oldPowerData) {
                            // деактивирую остальные счётчики по участку
                            $meters = ElectricityMeters::find()->where(['owner' => $newCottage->id])->all();
                            foreach ($meters as $m) {
                                $m->condition = 'expired';
                                $m->save();
                            }
                            $meter = new ElectricityMeters();
                            $meter->condition = 'in_use';
                            $meter->owner = $newCottage->id;
                            $meter->start_data = $powerDatum->oldPowerData;
                            $meter->save();
                            $currentMeter = $meter;
                        }
                    }
                    // добавлю показания
                    $consumed = new ConsumedElectricity();
                    $consumed->month = $powerDatum->month;
                    $consumed->old_data = $powerDatum->oldPowerData;
                    $consumed->new_data = $powerDatum->newPowerData;
                    $consumed->owner = $newCottage->id;
                    $consumed->meter = $currentMeter->id;
                    $consumed->consumption = $powerDatum->difference;
                    $consumed->limit = 50;
                    $consumed->in_limit_consumption = $powerDatum->inLimitSumm;
                    $consumed->over_limit_consumption = $powerDatum->overLimitSumm;
                    $consumed->in_limit_cost = self::migrateRubles($powerDatum->inLimitPay);
                    $consumed->over_limit_cost = self::migrateRubles($powerDatum->overLimitPay);
                    $consumed->total_cost = self::migrateRubles($powerDatum->totalPay);
                    $consumed->completion_date = $powerDatum->fillingDate;
                    $consumed->timestamp = $powerDatum->searchTimestamp;
                    $consumed->save();
                    $previousData = $powerDatum->newPowerData;
                }
            }
            $personalTariffsDom = null;
            if ($oldCottage->individualTariff) {
                // получу тарифы
                $personalTariffsDom = new DOMHandler($oldCottage->individualTariffRates);
            }
            // перенесу данные по членским взносам
            $payedMembership = Table_payed_membership::find()->where(['cottageId' => $oldCottage->cottageNumber])->orderBy('quarter')->all();
            if (empty($payedMembership)) {
                // оплаты членских взносов не было- считаю долг с последнего оплаченного месяца по данным участка
                $firstCountedQuarter = TimeHandler::getNextQuarter($oldCottage->membershipPayFor);
            } else {
                $firstCountedQuarter = $payedMembership[0]->quarter;
            }
            // покажу кварталы
            $quartersList = TimeHandler::getQuartersList($firstCountedQuarter, TimeHandler::getCurrentQuarter());
            foreach ($quartersList as $item) {
                // внесу данные в таблицу
                if ($oldCottage->individualTariff) {
                    $rate = $personalTariffsDom->query('//membership/quarter[@date="' . $item . '"]');
                    if ($rate->length > 0) {
                        // посчитаю по индивидуальному тарифу
                        $attributes = DOMHandler::getElemAttributes($rate->item(0));
                        $membershipData = new MembershipData();
                        $membershipData->cottage = $newCottage->id;
                        $membershipData->quarter = $item;
                        $membershipData->counted_square = $newCottage->square;
                        $membershipData->from_cottage = self::migrateRubles($attributes['fixed']);
                        $membershipData->from_square = self::migrateRubles($attributes['float']);
                        $count = Calculator::countFixedFloatPlus($membershipData->from_cottage, $membershipData->from_square, $membershipData->counted_square);
                        $membershipData->amount_from_square = $count['float'];
                        $membershipData->total_amount = $count['total'];
                        $membershipData->payed = 0;
                        $membershipData->save();
                    } else {
                        $tariff = TariffsMembership::findOne(['quarter' => $item]);
                        if (!empty($tariff)) {
                            // посчитаю по общему тарифу
                            $membershipData = new MembershipData();
                            $membershipData->cottage = $newCottage->id;
                            $membershipData->quarter = $item;
                            $membershipData->counted_square = $newCottage->square;
                            $membershipData->from_cottage = $tariff->from_cottage;
                            $membershipData->from_square = $tariff->from_square;
                            $count = Calculator::countFixedFloatPlus($membershipData->from_cottage, $membershipData->from_square, $membershipData->counted_square);
                            $membershipData->amount_from_square = $count['float'];
                            $membershipData->total_amount = $count['total'];
                            $membershipData->payed = 0;
                            $membershipData->save();
                        } else {
                            throw new CriticalException("Не найден тариф");
                        }
                    }
                } else {
                    $tariff = TariffsMembership::findOne(['quarter' => $item]);
                    if (!empty($tariff)) {
                        // посчитаю по общему тарифу
                        $membershipData = new MembershipData();
                        $membershipData->cottage = $newCottage->id;
                        $membershipData->quarter = $item;
                        $membershipData->counted_square = $newCottage->square;
                        $membershipData->from_cottage = $tariff->from_cottage;
                        $membershipData->from_square = $tariff->from_square;
                        $count = Calculator::countFixedFloatPlus($membershipData->from_cottage, $membershipData->from_square, $membershipData->counted_square);
                        $membershipData->amount_from_square = $count['float'];
                        $membershipData->total_amount = $count['total'];
                        $membershipData->payed = 0;
                        $membershipData->save();
                    } else {
                        throw new CriticalException("Не найден тариф");
                    }
                }
            }
            // данные по целевым взносам
            $tariffs = new DOMHandler($oldCottage->targetPaysDuty);
            $startYear = 2016;
            while ($startYear < 2020) {
                // проверю наличие задолженности за год
                $tariff = $tariffs->query("//target[@year='$startYear']");
                // при наличии задолженности- расчитываю данные по ней
                if ($tariff->length > 0) {
                    $attributes = DOMHandler::getElemAttributes($tariff->item(0));
                    $newData = new TargetData();
                    $newData->year = $startYear;
                    $newData->cottage = $newCottage->id;
                    $newData->counted_square = $attributes['square'];
                    $newData->from_cottage = self::migrateRubles($attributes['fixed']);
                    $newData->from_square = self::migrateRubles($attributes['float']);
                    $newData->payed = self::migrateRubles($attributes['payed']);
                    $counted = Calculator::countFixedFloatPlus($newData->from_cottage, $newData->from_square, $newData->counted_square);
                    $newData->amount_from_square = $counted['float'];
                    $newData->total_amount = $counted['total'];
                    if (!empty($attributes['description']))
                        $newData->description = $attributes['description'];
                    $newData->save();
                } else {
                    // если задолженности нет- считаю, что она оплачена
                    // найду тариф
                    if ($oldCottage->individualTariff) {
                        $rate = $personalTariffsDom->query('//target/year[@date="' . $startYear . '"]');
                        if ($rate->length > 0) {
                            // посчитаю по индивидуальному тарифу
                            $attributes = DOMHandler::getElemAttributes($rate->item(0));
                            $targetData = new TargetData();
                            $targetData->cottage = $newCottage->id;
                            $targetData->year = $startYear;
                            $targetData->counted_square = $newCottage->square;
                            $targetData->from_cottage = self::migrateRubles($attributes['fixed']);
                            $targetData->from_square = self::migrateRubles($attributes['float']);
                            $count = Calculator::countFixedFloatPlus($targetData->from_cottage, $targetData->from_square, $targetData->counted_square);
                            $targetData->amount_from_square = $count['float'];
                            $targetData->total_amount = $count['total'];
                            if(!empty($attributes['description']))
                                $targetData->description = $attributes['description'];
                            $targetData->payed = $targetData->total_amount;
                            $targetData->save();
                        } else {
                            $tariff = TariffsTarget::findOne(['year' => $startYear]);
                            if (!empty($tariff)) {
                                // посчитаю по общему тарифу

                            } else {
                                throw new CriticalException("Не найден тариф");
                            }
                        }
                    } else {
                        $tariff = TariffsTarget::findOne(['year' => $startYear]);
                        if (!empty($tariff)) {
                            // посчитаю по общему тарифу
                            $membershipData = new TargetData();
                            $membershipData->cottage = $newCottage->id;
                            $membershipData->year = $startYear;
                            $membershipData->counted_square = $newCottage->square;
                            $membershipData->from_cottage = $tariff->from_cottage;
                            $membershipData->from_square = $tariff->from_square;
                            $membershipData->description = $tariff->description;
                            $count = Calculator::countFixedFloatPlus($membershipData->from_cottage, $membershipData->from_square, $membershipData->counted_square);
                            $membershipData->amount_from_square = $count['float'];
                            $membershipData->total_amount = $count['total'];
                            $membershipData->payed = $membershipData->total_amount;
                            $membershipData->save();
                        } else {
                            throw new CriticalException("Не найден тариф");
                        }
                    }
                }
                $startYear++;
            }
            // данные по разовым взносам
            if(!empty($oldCottage->singlePaysDuty)){
                $singlesDom = new DOMHandler($oldCottage->singlePaysDuty);
                $singles = $singlesDom->query('//singlePayments/singlePayment');
                if($singles->length > 0){
                    foreach ($singles as $single) {
                        $attributes = DOMHandler::getElemAttributes($single);
                        $newSingle = new SingleData();
                        $newSingle->timestamp = $attributes['time'];
                        $newSingle->description = $attributes['description'];
                        $newSingle->total_amount = self::migrateRubles($attributes['summ']);
                        $newSingle->payed = self::migrateRubles($attributes['payed']);
                        $newSingle->cottage = $newCottage->id;
                        $newSingle->save();
                    }
                }
            }

            // обработаю счета
            $bills = Table_payment_bills::find()->where(['cottageNumber' => $oldCottage->cottageNumber])->all();
            if(!empty($bills)){
                foreach ($bills as $item) {
                    $newBill = new Bills();
                    $newBill->cottage = $newCottage->id;
                    $newBill->total_amount = self::migrateRubles($item->totalSumm);
                    $newBill->payed = self::migrateRubles($item->payedSumm);
                    $newBill->creation_time = $item->creationTime;
                    $newBill->payment_time = $item->paymentTime;
                    $newBill->deposit_used = $item->depositUsed;
                    $newBill->deposit_gained = $item->toDeposit;
                    $newBill->discount = $item->discount;
                    $newBill->discount_reason = $item->discountReason;
                    $newBill->is_message_sent = $item->isMessageSend;
                    $newBill->is_invoice_printed = $item->isInvoicePrinted;
                    $newBill->id = $item->id;
                    $newBill->bill_id = $item->id;
                    $newBill->save();

                    // определю оплачиваемые сущности
                    $billDom = new DOMHandler($item->bill_content);
                    $power = $billDom->query('//power/month');
                    if($power->length > 0){
                        foreach ($power as $powerItem) {
                            $attributes = DOMHandler::getElemAttributes($powerItem);
                            $value = ConsumedElectricity::find()->where(['owner' => $newCottage->id, 'month' => $attributes['date']])->one();
                            if(!empty($value)){
                                $entity = new BillEntities();
                                $entity->cottage = $newCottage->id;
                                $entity->type = 'power';
                                $entity->bill = $newBill->id;
                                $entity->entity_id = $value->id;
                                $entity->amount = self::migrateRubles($attributes['summ']);
                                $entity->save();
                            }
                            else{
                                echo 'Не найдена сущность электроэнергии';
                                die;
                            }
                        }
                    }
                    $membership = $billDom->query('//membership/quarter');
                    if($membership->length > 0){
                        foreach ($membership as $membershipItem) {
                            $attributes = DOMHandler::getElemAttributes($membershipItem);
                            $value = MembershipData::find()->where(['cottage' => $newCottage->id, 'quarter' => $attributes['date']])->one();
                            if(!empty($value)){
                                $entity = new BillEntities();
                                $entity->cottage = $newCottage->id;
                                $entity->type = 'membership';
                                $entity->bill = $newBill->id;
                                $entity->entity_id = $value->id;
                                $entity->amount = self::migrateRubles($attributes['summ']);
                                $entity->save();
                            }
                            else{
                                // создам сущность членских взносов
                                $membershipData = new MembershipData();
                                $membershipData->cottage = $newCottage->id;
                                $membershipData->quarter = $attributes['date'];
                                $membershipData->counted_square = $attributes['square'];
                                $membershipData->from_cottage = self::migrateRubles($attributes['fixed']);
                                $membershipData->from_square = self::migrateRubles($attributes['float']);
                                $membershipData->amount_from_square = self::migrateRubles($attributes['float-cost']);
                                $membershipData->total_amount = self::migrateRubles($attributes['summ']);
                                $membershipData->payed = 0;
                                $membershipData->save();

                                $entity = new BillEntities();
                                $entity->cottage = $newCottage->id;
                                $entity->type = 'membership';
                                $entity->bill = $newBill->id;
                                $entity->entity_id = $membershipData->id;
                                $entity->amount = self::migrateRubles($attributes['summ']);
                                $entity->save();
                            }
                        }
                    }
                    $membership = $billDom->query('//target/pay');
                    if($membership->length > 0){
                        foreach ($membership as $membershipItem) {
                            $attributes = DOMHandler::getElemAttributes($membershipItem);
                            $value = TargetData::find()->where(['cottage' => $newCottage->id, 'year' => $attributes['year']])->one();
                            if(!empty($value)){
                                $entity = new BillEntities();
                                $entity->cottage = $newCottage->id;
                                $entity->type = 'target';
                                $entity->bill = $newBill->id;
                                $entity->entity_id = $value->id;
                                $entity->amount = self::migrateRubles($attributes['summ']);
                                $entity->save();
                            }
                            else{
                                die('Не найдена сущность года');
                                // создам сущность членских взносов
                                $membershipData = new MembershipData();
                                $membershipData->cottage = $newCottage->id;
                                $membershipData->quarter = $attributes['date'];
                                $membershipData->counted_square = $attributes['square'];
                                $membershipData->from_cottage = self::migrateRubles($attributes['fixed']);
                                $membershipData->from_square = self::migrateRubles($attributes['float']);
                                $membershipData->amount_from_square = self::migrateRubles($attributes['float-cost']);
                                $membershipData->total_amount = self::migrateRubles($attributes['summ']);
                                $membershipData->payed = 0;
                                $membershipData->save();

                                $entity = new BillEntities();
                                $entity->cottage = $newCottage->id;
                                $entity->type = 'membership';
                                $entity->bill = $newBill->id;
                                $entity->entity_id = $membershipData->id;
                                $entity->amount = self::migrateRubles($attributes['summ']);
                                $entity->save();
                            }
                        }
                    }
                    $membership = $billDom->query('//single/pay');
                    if($membership->length > 0){
                        foreach ($membership as $membershipItem) {
                            $attributes = DOMHandler::getElemAttributes($membershipItem);
                            $value = SingleData::find()->where(['cottage' => $newCottage->id, 'timestamp' => $attributes['timestamp']])->one();
                            if(!empty($value)){
                                $entity = new BillEntities();
                                $entity->cottage = $newCottage->id;
                                $entity->type = 'simple';
                                $entity->bill = $newBill->id;
                                $entity->entity_id = $value->id;
                                $entity->amount = self::migrateRubles($attributes['summ']);
                                $entity->save();
                            }
                            else{
                                // создам сущность членских взносов
                                $membershipData = new SingleData();
                                $membershipData->cottage = $newCottage->id;
                                $membershipData->timestamp = $attributes['timestamp'];
                                $membershipData->description = urldecode($attributes['description']);
                                $membershipData->total_amount = self::migrateRubles($attributes['summ']);
                                $membershipData->payed = 0;
                                $membershipData->save();

                                $entity = new BillEntities();
                                $entity->cottage = $newCottage->id;
                                $entity->type = 'simple';
                                $entity->bill = $newBill->id;
                                $entity->entity_id = $membershipData->id;
                                $entity->amount = self::migrateRubles($attributes['summ']);
                                $entity->save();
                            }
                        }
                    }
                    // далее, найду транзакции, связанные с данным счётом
                    $transactions = Table_transactions::find()->where(['billId' => $item->id])->all();
                    if(!empty($transactions)){
                        foreach ($transactions as $transaction) {
                            $newTransaction = new Transactions();
                            $newTransaction->cottageNumber = $newCottage->id;
                            $newTransaction->billId = $newBill->id;
                            $newTransaction->transactionDate = $transaction->transactionDate;
                            $newTransaction->transactionType = $transaction->transactionType;
                            $newTransaction->payed = self::migrateRubles($transaction->transactionSumm);
                            $newTransaction->transactionReason = $transaction->transactionReason;
                            $newTransaction->usedDeposit = self::migrateRubles($transaction->usedDeposit);
                            $newTransaction->gainedDeposit = self::migrateRubles($transaction->gainedDeposit);
                            $newTransaction->partial = $transaction->partial;
                            $newTransaction->payDate = $transaction->payDate;
                            $newTransaction->bankDate = $transaction->bankDate;
                            $newTransaction->save();

                            // найду платежи с данной транзакции
                            $payedPower = Table_payed_power::find()->where(['transactionId' => $transaction->id])->all();
                            if(!empty($payedPower)){
                                foreach ($payedPower as $powerItem) {
                                    $entity = ConsumedElectricity::findOne(['owner' => $newCottage->id, 'month' => $powerItem->month]);
                                    $newItem = new PayedEntities();
                                    $newItem->type = 'power';
                                    $newItem->cottage = $newCottage->id;
                                    $newItem->bill = $newBill->id;
                                    $newItem->transaction = $newTransaction->id;
                                    $newItem->amount = self::migrateRubles($powerItem->summ);
                                    $newItem->pay_time = $powerItem->paymentDate;
                                    $newItem->entity_id = $entity->id;
                                    $newItem->save();
                                    $entity->payed += $newItem->amount;
                                    $entity->save();
                                }
                            }
                            // найду платежи с данной транзакции
                            $payedItems = Table_payed_membership::find()->where(['transactionId' => $transaction->id])->all();
                            if(!empty($payedItems)){
                                foreach ($payedItems as $payedItem) {
                                    $entity = MembershipData::findOne(['cottage' => $newCottage->id, 'quarter' => $payedItem->quarter]);
                                    $newItem = new PayedEntities();
                                    $newItem->type = 'membership';
                                    $newItem->cottage = $newCottage->id;
                                    $newItem->bill = $newBill->id;
                                    $newItem->transaction = $newTransaction->id;
                                    $newItem->amount = self::migrateRubles($payedItem->summ);
                                    $newItem->pay_time = $payedItem->paymentDate;
                                    $newItem->entity_id = $entity->id;
                                    $newItem->save();
                                    $entity->payed += $newItem->amount;
                                    $entity->save();
                                }
                            }
                            // найду платежи с данной транзакции
                            $payedItems = Table_payed_target::find()->where(['transactionId' => $transaction->id])->all();
                            if(!empty($payedItems)){
                                foreach ($payedItems as $payedItem) {
                                    $entity = TargetData::findOne(['cottage' => $newCottage->id, 'year' => $payedItem->year]);
                                    $newItem = new PayedEntities();
                                    $newItem->type = 'target';
                                    $newItem->cottage = $newCottage->id;
                                    $newItem->bill = $newBill->id;
                                    $newItem->transaction = $newTransaction->id;
                                    $newItem->amount = self::migrateRubles($payedItem->summ);
                                    $newItem->pay_time = $payedItem->paymentDate;
                                    $newItem->entity_id = $entity->id;
                                    $newItem->save();
                                    $entity->payed += $newItem->amount;
                                    $entity->save();
                                }
                            }
                            // найду платежи с данной транзакции
                            $payedItems = Table_payed_single::find()->where(['transactionId' => $transaction->id])->all();
                            if(!empty($payedItems)){
                                foreach ($payedItems as $payedItem) {
                                    $entity = SingleData::findOne(['cottage' => $newCottage->id, 'timestamp' => $payedItem->time]);
                                    $newItem = new PayedEntities();
                                    $newItem->type = 'single';
                                    $newItem->cottage = $newCottage->id;
                                    $newItem->bill = $newBill->id;
                                    $newItem->transaction = $newTransaction->id;
                                    $newItem->amount = self::migrateRubles($payedItem->summ);
                                    $newItem->pay_time = $payedItem->paymentDate;
                                    $newItem->entity_id = $entity->id;
                                    $newItem->save();
                                    $entity->payed += $newItem->amount;
                                    $entity->save();
                                }
                            }
                            // найду платежи с данной транзакции
                            $payedItems = Table_payed_fines::find()->where(['transaction_id' => $transaction->id])->all();
                            if(!empty($payedItems)){
                                die('have payed fine');
                            }
                        }
                    }
                }
            }
        }

        $query = $db->createCommand('TRUNCATE TABLE `cottage2`.`snt_cottage_subordination`;');
        try {
            $query->query();
        } catch (Exception $e) {
            die('have exception');
        }
        // найду дополнительные участки
        $oldSubs = Table_additional_cottages::find()->all();
        foreach ($oldSubs as $oldSub) {
            $newSub = new Cottage();
            $newSub->number = $oldSub->masterId . '-a';
            $newSub->square = $oldSub->cottageSquare;
            $newSub->deposit = $oldSub->deposit;
            $newSub->pay_membership = $oldSub->isMembership;
            $newSub->pay_target = $oldSub->isTarget;
            $newSub->save();
            $master = $snt->getCottage($oldSub->masterId);
            if ($master !== null) {
                $subordination = new Cottage_subordination();
                $subordination->master_id = $master->id;
                $subordination->sub_id = $newSub->id;
                $subordination->save();
            } else {
                throw new CriticalException("Не найден главный участок $oldSub->masterId");
            }
            if ($oldSub->hasDifferentOwner) {
                // обработаю владельцев
                $person = new Person();
                $person->name = $oldSub->cottageOwnerPersonals;
                $person->address = $oldSub->cottageOwnerAddress;
                $person->passportData = $oldSub->passportData;
                $person->description = $oldSub->cottageOwnerDescription;
                $person->role = $ownerRole->id;
                $person->cottage = $newSub->id;
                $person->save();
                if (!empty($oldSub->cottageOwnerEmail)) {
                    $mail = new Emails();
                    $mail->address = $oldSub->cottageOwnerEmail;
                    $mail->person = $person->id;
                    $mail->save();
                }
                if (!empty($oldSub->cottageOwnerPhone)) {
                    $mail = new Phones();
                    $mail->phone = preg_replace('/\D/', '', $oldSub->cottageOwnerPhone);
                    $mail->person = $person->id;
                    $mail->save();
                }
                if (!empty($oldSub->cottageContacterPersonals)) {
                    $contact = new Person();
                    $contact->role = $contactRole->id;
                    $contact->cottage = $newSub->id;
                    $contact->name = $oldSub->cottageContacterPersonals;
                    $contact->save();

                    if (!empty($oldSub->cottageContacterEmail)) {
                        $mail = new Emails();
                        $mail->address = $oldSub->cottageContacterEmail;
                        $mail->person = $contact->id;
                        $mail->save();
                    }
                    if (!empty($oldSub->cottageContacterPhone)) {
                        $mail = new Phones();
                        $mail->phone = preg_replace('/\D/', '', $oldSub->cottageContacterPhone);
                        $mail->person = $contact->id;
                        $mail->save();
                    }
                }
            }
        }

    }

    private static function migrateRubles($old)
    {
        $old = str_replace(',', '.', $old);
        return round($old * 100);
    }
}