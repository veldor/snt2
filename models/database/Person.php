<?php


namespace app\models\database;


use yii\db\ActiveRecord;

/**
 * Class Person
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property string $name [varchar(255)]  ФИО
 * @property int $role [int(10) unsigned]  Статус
 * @property string $address Адрес места жительства
 * @property string $passportData Паспортные данные
 * @property int $cottage [int(10) unsigned]  Номер участка
 * @property Emails[] $mail
 * @property string $description Примечание
 */

class Person extends ActiveRecord
{

    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_persons';
    }


    /**
     * Верну почтовые адреса
     * @return Emails[]
     */
    public function getMail()
    {
        return Emails::find()->where(['person' => $this->id])->all();
    }
}