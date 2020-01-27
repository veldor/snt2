<?php

use app\assets\CottagesListAsset;
use app\models\Cottage;
use app\widgets\CottagesListWidget;
use yii\web\View;

CottagesListAsset::register($this);

/* @var $this View */
/* @var $cottages Cottage[] */

$this->title = 'Список участков';
?>

<div class="col-lg-12">
    <?php
    try {
       echo CottagesListWidget::widget(['cottages' => $cottages]);
    } catch (Exception $e) {
        echo "have ex " . $e->getMessage();
        die;
    }
    ?>
</div>
