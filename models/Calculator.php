<?php
/**
 * Created by PhpStorm.
 * User: eldor
 * Date: 06.12.2018
 * Time: 15:36
 */

namespace app\models;


use yii\base\Model;

class Calculator extends Model
{
    public static function countFixedFloat($fixed, $float, $square){
        return $fixed + ($float / 100 * $square);
    }
    public static function countFixedFloatPlus($fixed, $float, $square):array {
        $float = round($float * $square / 100);
        return ['float' => $float, 'total' => $fixed + $float];
    }
}