<?php


namespace app\models;

use app\models\database\Cottage_subordination;
use app\models\database\Person;
use yii\db\ActiveRecord;

/**
 * Class Cottage
 * @package app\models
 *
 * @property int $id [int(10) unsigned]  Идентификатор участка
 * @property string $number [varchar(10)]  Номер участка
 * @property int $square [int(5) unsigned]  Площадь участка
 * @property int $deposit [int(20) unsigned]  Сумма депозита участка
 * @property string $description Примечание
 * @property bool $pay_membership [tinyint(1)]  Оплачивает ли участок членские взносы
 * @property bool $pay_target [tinyint(1)]  Оплачивает ли участок целевые взносы
 */

class Cottage extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_cottages';
    }


    /**
     * Проверка наличия хотя бы одного почтового адреса
     * @return bool
     */
    public function hasMail() :bool {
       $persons = $this->getPersons();
       if(!empty($persons)){
           foreach ($persons as $person) {
               // найду адрес почты
               if($person->getMail() != null)
                   return true;
           }
       }
       return false;
    }

    /**
     * Проверка, дополнительный ли участок
     * @return bool
     */
    public function isAdditional() :bool {
        return !!Cottage_subordination::find()->where(['sub_id' => $this->id])->count();
    }

    /**
     * Возвращает все контакты участка
     * @return Person[]
     */
    public function getPersons()
    {
        return Person::find()->where(['cottage' => $this->id])->all();
    }
}