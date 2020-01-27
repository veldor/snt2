<?php

namespace app\controllers;

use app\models\exceptions\CriticalException;
use app\models\Migration;
use app\models\SNT;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() :string
    {
        $snt = SNT::getInstance();
        $cottages = $snt->getCottages();
        return $this->render('cottages_list',['cottages' => $cottages]);
    }
    public function actionMigrate(){
        try {
            Migration::doMigrate();
        } catch (CriticalException $e) {
        }
        return '';
    }
}
