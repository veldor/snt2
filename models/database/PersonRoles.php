<?php


namespace app\models\database;

use yii\db\ActiveRecord;

/**
 * Class PersonRoles
 * @package app\models\database
 *
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property string $role [varchar(100)]  Название роли
 */

class PersonRoles extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName() :string
    {
        return 'snt_person_roles';
    }
}