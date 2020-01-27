<?php


namespace app\models\database;

use yii\db\ActiveRecord;

/**
 * Class Emails
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property string $address [varchar(255)]  Адрес
 * @property int $person [int(10) unsigned]  Владелец
 * @property string $description Примечание
 */

class Emails extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_emails';
    }
}