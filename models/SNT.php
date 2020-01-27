<?php


namespace app\models;


use app\models\exceptions\CriticalException;

class SNT
{
    private static $instance;
    public static function getInstance(){
        if(empty(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
    }

    /**
     * @param $cottageNumber
     * @return Cottage|null
     * @throws CriticalException
     */
    public function getCottage($cottageNumber){
        $cottage = Cottage::findOne(['number' => $cottageNumber]);
        if(!empty($cottage)){
            return $cottage;
        }
        throw new CriticalException("Участок $cottageNumber не найден");
    }

    /**
     * @return Cottage[]
     */
    public function getCottages()
    {
        $cottages = Cottage::find()->orderBy('cast(number as unsigned) asc')->all();
        return $cottages;
    }
}