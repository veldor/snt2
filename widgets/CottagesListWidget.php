<?php

namespace app\widgets;

use app\models\Cottage;
use app\models\database\Bills;
use app\priv\Info;
use yii\base\Widget;
use yii\helpers\Html;

class CottagesListWidget extends Widget
{

    public $cottages;
    public $content = '';

    public function init()
    {
        $previous = 0;
        $max = Info::COTTAGES_QUANTITY;
        /** @var Cottage $cottage */
        foreach ($this->cottages as $cottage) {
            // если есть незарегистрированные участки- оставлю для них место
            while ($previous <  (((int) $cottage->number)) -1 &&  $previous != (((int) $cottage->number)) -1) {
                ++$previous;
                $this->content .= "<div class='col-md-1 col-sm-2 col-xs-3 text-center margened inlined'><button class='btn empty cottage-button' data-index='$previous' data-toggle='tooltip' data-placement='top' title='Регистрация участка № $previous'>$previous</button></div>";
            }
            $additionalBlock = "<div class='col-xs-12 additional-block'>";
            // проверю, есть ли почта у этого участка
            if ($cottage->hasMail()) {
                $additionalBlock .= "<span class='custom-icon has-email'  data-toggle=\"tooltip\" data-placement=\"auto\" title=\"Есть адрес электронной почты\"></span>";
            }
            // проверю наличие незакрытого счёта у участка
            $lastOpenedBill = Bills::getLastOpened($cottage);
            if (!empty($lastOpenedBill)) {
                $additionalBlock .= "<span class='custom-icon has-bill' data-toggle=\"tooltip\" data-placement=\"auto\" title=\"Есть открытый счёт\"></span>";
                if ($lastOpenedBill->is_invoice_printed) {
                    $additionalBlock .= "<span class='custom-icon invoice_printed' data-toggle=\"tooltip\" data-placement=\"auto\" title=\"Печаталась квитанция\"></span>";
                }
                if ($lastOpenedBill->is_message_sent) {
                    $additionalBlock .= "<span class='custom-icon message_sended' data-toggle=\"tooltip\" data-placement=\"auto\" title=\"Квитанция отправлена на электронную почту\"></span>";
                }
            }
            $additionalBlock .= "</div>";
            $additional = '';
            $this->content .= "<div class='col-md-1 col-sm-2 col-xs-3 text-center margened inlined'><a href='/show-cottage/$cottage->number' class='btn btn-success cottage-button'>$cottage->number {$additional}</a>$additionalBlock</div>";
            $previous = (int) $cottage->number;
        }
        while ($previous + 1 <= $max) {
            $this->content .= "<div class='col-md-1 col-sm-2 col-xs-3 text-center margened inlined'><button class='btn empty cottage-button' data-index='$index' data-toggle='tooltip' data-placement='top' title='Регистрация участка № $index'>$index</button></div>";
            $previous++;
        }
    }

    public function run()
    {
        return Html::decode($this->content);
    }
}